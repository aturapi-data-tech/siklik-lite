<?php

namespace App\Http\Livewire\EmrRJ\PostEncounterRJ;


use App\Http\Traits\EmrRJ\EmrRJTrait;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Http\Livewire\SatuSehat\Encounter\Encounter;
use App\Http\Livewire\SatuSehat\Condition\Condition;
use App\Http\Livewire\SatuSehat\Bundle\Bundle;

use App\Http\Traits\BPJS\SatuSehatTrait;
use App\Http\Traits\customErrorMessagesTrait;
use Illuminate\Support\Facades\Validator;

use Livewire\Component;

class PostEncounterRJ extends Component
{
    use EmrRJTrait;


    public $rjNoRef;

    public array $dataDaftarPoliRJ = [];
    public array $dataPasienRJ = [];



    private function findData($rjno): void
    {
        $this->dataDaftarPoliRJ = $this->findDataRJ($rjno);
    }

    public function PostEncounterSatuSehat()
    {

        $findDataRJ = $this->findDataRJ($this->rjNoRef);
        $dataDaftarPoliRJ = $findDataRJ['dataDaftarRJ'];
        $dataPasienRJ = $findDataRJ['dataPasienRJ'];


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
                // Buat Condition
                $condition = new Condition;
                $condition->addClinicalStatus(); // active, inactive, resolved. Default bila tidak dideklarasi = active
                $condition->addCategory('Diagnosis'); // Diagnosis, Keluhan. Default : Diagnosis
                $condition->addCode($diag['diagId']); // Kode ICD10
                $condition->setSubject($dataPasienRJ['patientUuid'], $dataPasienRJ['regName']); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
                $condition->setOnsetDateTime(Carbon::now()->toDateTimeString()); // timestamp onset. Timestamp sekarang
                $condition->setRecordedDate(Carbon::now()->toDateTimeString()); // timestamp recorded. Timestamp sekarang
                $condition->json();
                $bundle->addCondition($condition);
            }



            $postEncounter = SatuSehatTrait::postBundleEncounterCondition($bundle->json());

            dd($postEncounter->getOriginalContent());


            // Jika uuid tidak ditemukan
            // if (!isset($postEncounter->getOriginalContent()['response']['entry'][0]['resource']['id'])) {
            //     $this->emit('toastr-error', 'UUID tidak dapat ditemukan.' . $postEncounter->getOriginalContent()['metadata']['message']);
            //     return;
            // }

            // $postEncounter = SatuSehatTrait::postEncounter($nik);

            // Jika uuid tidak ditemukan
            // if (!isset($postEncounter->getOriginalContent()['response']['entry'][0]['resource']['id'])) {
            //     $this->emit('toastr-error', 'UUID tidak dapat ditemukan.' . $postEncounter->getOriginalContent()['metadata']['message']);
            //     return;
            // }

            // $this->dataPasien['pasien']['identitas']['patientUuid'] = $postEncounter->getOriginalContent()['response']['entry'][0]['resource']['id'];
            // $this->store();
            // $this->emit('toastr-success', $postEncounter->getOriginalContent()['response']['entry'][0]['resource']['id'] . ' / ' . $postEncounter->getOriginalContent()['response']['entry'][0]['resource']['name'][0]['text']);

            // dd($postEncounter->getOriginalContent());
            // dd($postEncounter->getOriginalContent()['response']['entry'][0]['resource']['id']);
            // dd($postEncounter->getOriginalContent()['response']['entry'][0]['resource']['name'][0]['text']);
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
        return view('livewire.emr-r-j.post-encounter-r-j.post-encounter-r-j');
    }
}
