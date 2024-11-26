<?php

namespace App\Http\Livewire\RJ\EmrRJ\PostEncounterRJ;


use App\Http\Traits\EmrRJ\EmrRJTrait;
use Carbon\Carbon;

use App\Http\Livewire\SatuSehat\Encounter\Encounter;
use App\Http\Livewire\SatuSehat\Condition\Condition;
use App\Http\Livewire\SatuSehat\Bundle\Bundle;

use App\Http\Traits\SATUSEHAT\SatuSehatTrait;
use App\Http\Traits\customErrorMessagesTrait;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\MasterPasien\MasterPasienTrait;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class PostEncounterRJ extends Component
{
    use EmrRJTrait, MasterPasienTrait;


    public $rjNoRef;

    public array $dataDaftarPoliRJ = [];
    public array $dataPasienRJ = [];
    public string $EncounterID;

    protected $listeners = [
        'syncronizePostEncounterRJ' => 'mount',
    ];

    private function findData($rjno): void
    {
        $this->dataDaftarPoliRJ = $this->findDataRJ($rjno)['dataDaftarRJ'];

        if (isset($this->dataDaftarPoliRJ['satuSehatUuidRJ'])) {
            $EncounterID = collect($this->dataDaftarPoliRJ['satuSehatUuidRJ'])
                ->filter(function ($item) {
                    return $item['response']['resourceType'] === 'Encounter';
                })->first();

            $this->EncounterID = $EncounterID['response']['resourceID'];
        } else {
            $this->EncounterID = '';
        }
    }

    public function PostEncounterSatuSehat()
    {

        $findDataRJ = $this->findDataRJ($this->rjNoRef);
        $dataDaftarPoliRJ = $findDataRJ['dataDaftarRJ'];
        $dataPasienRJ = $findDataRJ['dataPasienRJ'];

        // cek data satu sehat dikirim atau belum
        if (isset($dataDaftarPoliRJ['satuSehatUuidRJ'])) {
            $EncounterID = collect($dataDaftarPoliRJ['satuSehatUuidRJ'])
                ->filter(function ($item) {
                    return $item['response']['resourceType'] === 'Encounter';
                })->first();

            $this->emit('toastr-error', 'Data Pasien ' . $dataPasienRJ['regName'] . ' sudah dikirim ke satu sehat dengan EncounterID ' . $EncounterID['response']['resourceID']);
            return;
        }

        // cek
        // if task id null batal proses 3 4 5
        // if pasien uuid null -> then get uuid -> if fail batal proses if ok
        // proses
        // if dokter uuid null -> then get uuid -> if fail batal proses if ok
        // proses
        // if// if poli uuid null -> then get uuid -> if fail batal proses if ok
        // proses
        $r = [
            'patientUuid' => $dataPasienRJ['patientUuid'],
            'drUuid' => $dataPasienRJ['drUuid'],
            'poliUuid' => $dataPasienRJ['poliUuid'],
            'taskId3' => $dataDaftarPoliRJ['taskIdPelayanan']['taskId3'],
            'taskId4' => $dataDaftarPoliRJ['taskIdPelayanan']['taskId4'],
            'taskId5' => $dataDaftarPoliRJ['taskIdPelayanan']['taskId5'],


        ];

        // update ihs pasien
        if (!$r['patientUuid']) {
            $UpdatepatientUuid = $this->UpdatepatientUuid($dataPasienRJ['regNo'], $dataPasienRJ['nik']);

            $r['patientUuid'] = $UpdatepatientUuid;
        }

        $rules = [
            'patientUuid' => 'bail|required',
            'drUuid' => 'bail|required',
            'poliUuid' => 'bail|required',
            'taskId3' => 'bail|required|date_format:d/m/Y H:i:s',
            'taskId4' => 'bail|required|date_format:d/m/Y H:i:s',
            'taskId5' => 'bail|required|date_format:d/m/Y H:i:s',

        ];
        $customErrorMessagesTrait = customErrorMessagesTrait::messages();
        $attribute = [
            'patientUuid' => 'HIS Pasien Kosong',
            'drUuid' => 'UUID Dokter Kosong',
            'poliUuid' => 'UUID Poli Kosong',
        ];

        $validator = Validator::make($r, $rules, $customErrorMessagesTrait, $attribute);

        if ($validator->fails()) {
            $this->emit('toastr-error', $validator->messages()->all());
            return;
        }


        // Proses Validasi///////////////////////////////////////////
        try {

            // Pembuatan Struktur Array Encounter
            $encounter = new Encounter;
            $encounter->addRegistrationId($this->rjNoRef); // unique string free text (increments / UUID)

            $encounter->setArrived(Carbon::createFromFormat('d/m/Y H:i:s', $dataDaftarPoliRJ['taskIdPelayanan']['taskId3'])->toDateTimeString());
            $encounter->setInProgress(
                Carbon::createFromFormat('d/m/Y H:i:s', $dataDaftarPoliRJ['taskIdPelayanan']['taskId4'])->toDateTimeString(),
                Carbon::createFromFormat('d/m/Y H:i:s', $dataDaftarPoliRJ['taskIdPelayanan']['taskId5'])->addMinutes(15)->toDateTimeString()
            );
            $encounter->setFinished(Carbon::createFromFormat('d/m/Y H:i:s', $dataDaftarPoliRJ['taskIdPelayanan']['taskId5'])->addMinutes(35)->toDateTimeString());

            $encounter->setConsultationMethod('RAJAL'); // RAJAL, IGD, RANAP, HOMECARE, TELEKONSULTASI
            $encounter->setSubject($dataPasienRJ['patientUuid'], $dataPasienRJ['regName']); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
            $encounter->addParticipant($dataPasienRJ['drUuid'], $dataPasienRJ['drName']); // ID SATUSEHAT Dokter, Nama Dokter
            $encounter->addLocation($dataPasienRJ['poliUuid'], $dataPasienRJ['poliDesc']); // ID SATUSEHAT Location, Nama Poli

            $bundle = new Bundle;
            $bundle->addEncounter($encounter);

            foreach ($dataDaftarPoliRJ['diagnosis'] as $key => $diag) {

                // Pembuatan Struktur Array Condition
                $condition = new Condition;
                $condition->addClinicalStatus(); // active, inactive, resolved. Default bila tidak dideklarasi = active
                $condition->addCategory('Diagnosis'); // Diagnosis, Keluhan. Default : Diagnosis
                $condition->addCode($diag['icdX'], $diag['diagDesc']); // Kode ICD10
                $condition->setSubject($dataPasienRJ['patientUuid'], $dataPasienRJ['regName']); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
                $condition->setOnsetDateTime(Carbon::now(env('APP_TIMEZONE'))->toDateTimeString()); // timestamp onset. Timestamp sekarang
                $condition->setRecordedDate(Carbon::now(env('APP_TIMEZONE'))->toDateTimeString()); // timestamp recorded. Timestamp sekarang
                $condition->json();
                $bundle->addCondition($condition);
            }

            // dd($bundle->json());
            // Post Ke satu sehat
            $postEncounter = SatuSehatTrait::postBundleEncounterCondition($bundle->json());


            if (isset($postEncounter->getOriginalContent()['response']['entry'])) {
                // Jika 200
                $dataDaftarPoliRJ['satuSehatUuidRJ'] = $postEncounter->getOriginalContent()['response']['entry'];
                // update Json ke database
                $this->updateJsonRJ($this->rjNoRef, $dataDaftarPoliRJ);
                $this->emit('syncronizePostEncounterRJ');
            } else {

                // dd($postEncounter->getOriginalContent());
                $this->emit('toastr-error', json_encode($postEncounter->getOriginalContent(), true));
                return;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // dd($validator->fails());
            $this->emit('toastr-error', 'Errors "' . $e->getMessage());
            return;
        }
    }


    private function UpdatepatientUuid(string $regNo = '', string $nik = '')
    {
        // validateNIIK
        $r = ['nik' => $nik, 'regNo' => $regNo];
        $rules = ['nik' => 'required', 'regNo' => 'required'];
        $customErrorMessagesTrait = customErrorMessagesTrait::messages();
        $attribute = ['nik' => 'NIK', 'regNo' => 'No Rekam Medis'];
        $validator = Validator::make($r, $rules, $customErrorMessagesTrait, $attribute);
        if ($validator->fails()) {
            $this->emit('toastr-error', $validator->messages()->all());
            return;
        }
        // validateNIIK


        // Proses Validasi///////////////////////////////////////////
        try {

            $PatientByNIK = SatuSehatTrait::PatientByNIK($nik);

            // Jika uuid tidak ditemukan
            if (!isset($PatientByNIK->getOriginalContent()['response']['entry'][0]['resource']['id'])) {
                $this->emit('toastr-error', 'UUID tidak dapat ditemukan.' . $PatientByNIK->getOriginalContent()['metadata']['message']);
                return;
            }

            $dataPasien = $this->findDataMasterPasien($regNo);
            $dataPasien['pasien']['identitas']['patientUuid'] = $PatientByNIK->getOriginalContent()['response']['entry'][0]['resource']['id'];

            //    updateDB
            DB::table('rsmst_pasiens')->where('reg_no', $regNo)
                ->update([
                    'patient_uuid' => isset($this->dataPasien['pasien']['identitas']['patientUuid']) ? $this->dataPasien['pasien']['identitas']['patientUuid'] : '',
                ]);

            //    updateJson
            $this->updateJsonMasterPasien($regNo, $dataPasien);

            $this->emit('toastr-success', $PatientByNIK->getOriginalContent()['response']['entry'][0]['resource']['id'] . ' / ' . $PatientByNIK->getOriginalContent()['response']['entry'][0]['resource']['name'][0]['text']);
            return  $PatientByNIK->getOriginalContent()['response']['entry'][0]['resource']['id'];
        } catch (\Illuminate\Validation\ValidationException $e) {
            // dd($validator->fails());
            $this->emit('toastr-error', 'Errors "' . $e->getMessage());
            return;
        }
    }

    public function mount()
    {
        $this->findData($this->rjNoRef);
    }
    public function render()
    {
        return view('livewire.r-j.emr-r-j.post-encounter-r-j.post-encounter-r-j');
    }
}
