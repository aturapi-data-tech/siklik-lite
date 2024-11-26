<?php

namespace App\Http\Livewire\RJ\EmrRJ\PostEncounterRJ;


use App\Http\Traits\EmrRJ\EmrRJTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Http\Livewire\SatuSehat\Encounter\Encounter;
use App\Http\Livewire\SatuSehat\Condition\Condition;
use App\Http\Livewire\SatuSehat\Bundle\Bundle;

use App\Http\Traits\SATUSEHAT\SatuSehatTrait;
use App\Http\Traits\customErrorMessagesTrait;
use Illuminate\Support\Facades\Validator;

use Livewire\Component;

class PostEncounterRJAll extends Component
{
    use EmrRJTrait;


    public $rjDateRef;

    protected $listeners = [
        'syncronizePostEncounterRJ' => 'mount',
    ];



    public function PostEncounterSatuSehatAll()
    {

        ///////////////////////
        // validate date format
        ///////////////////////
        $r = ['rjDate' => $this->rjDateRef];
        $rules = ['rjDate' => 'bail|required|date_format:d/m/Y'];
        $customErrorMessagesTrait = customErrorMessagesTrait::messages();
        $attribute = ['rjDate' => 'Tanggal'];
        $validator = Validator::make($r, $rules, $customErrorMessagesTrait, $attribute);

        if ($validator->fails()) {
            $this->emit('toastr-error', $validator->messages()->all());
            return;
        }
        ///////////////////////
        // validate date format
        ///////////////////////

        $dataDaftarPoliRJDate = DB::table('rsview_rjkasir')
            ->select('rj_no')
            ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $this->rjDateRef)
            ->where(DB::raw("nvl(erm_status,'A')"), '=', 'A')
            ->where('rj_status', '!=', 'F')
            ->where('klaim_id', '!=', 'KR')
            ->orderBy('rj_no',  'asc')
            ->get();

        ///////////////////////
        // validate data tidak ditemukan
        ///////////////////////

        if ($dataDaftarPoliRJDate->isEmpty()) {
            $this->emit('toastr-error', 'Tidak ada data yang diproses');
            return;
        }
        ///////////////////////
        // validate data tidak ditemukan
        ///////////////////////

        foreach ($dataDaftarPoliRJDate as $ddRJ) {
            $this->PostEncounterSatuSehat($ddRJ->rj_no);
        }
    }

    private function PostEncounterSatuSehat($rjNo): void
    {

        $findDataRJ = $this->findDataRJ($rjNo);
        $dataDaftarPoliRJ = $findDataRJ['dataDaftarRJ'];
        $dataPasienRJ = $findDataRJ['dataPasienRJ'];

        // cek data satu sehat dikirim atau belum
        if (isset($dataDaftarPoliRJ['satuSehatUuidRJ'])) {
            if ($dataDaftarPoliRJ['satuSehatUuidRJ']) {
                $EncounterID = collect($dataDaftarPoliRJ['satuSehatUuidRJ'])
                    ->filter(function ($item) {
                        return $item['response']['resourceType'] === 'Encounter';
                    })->first();

                $this->emit('toastr-error', 'Data Pasien ' . $dataPasienRJ['regName'] . ' sudah dikirim ke satu sehat dengan EncounterID ' . $EncounterID['response']['resourceID']);
                return;
            }
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
            $encounter->addRegistrationId($rjNo); // unique string free text (increments / UUID)

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

            if (isset($dataDaftarPoliRJ['diagnosis'])) {
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
            }

            // dd($bundle->json());
            // Post Ke satu sehat
            $postEncounter = SatuSehatTrait::postBundleEncounterCondition($bundle->json());
            // dd($postEncounter->getOriginalContent());

            if (isset($postEncounter->getOriginalContent()['response']['entry'])) {
                // Jika 200
                $dataDaftarPoliRJ['satuSehatUuidRJ'] = $postEncounter->getOriginalContent()['response']['entry'];
                // update Json ke database
                $this->updateJsonRJ($rjNo, $dataDaftarPoliRJ);
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

    public function mount() {}

    public function render()
    {
        return view('livewire.r-j.emr-r-j.post-encounter-r-j.post-encounter-r-j-all');
    }
}
