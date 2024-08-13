<?php

namespace App\Http\Livewire\MasterPoli\FormEntryPoli;

use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Traits\customErrorMessagesTrait;


use App\Http\Livewire\SatuSehat\Location\Location;
use App\Http\Traits\BPJS\SatuSehatTrait;


use Livewire\Component;

class FormEntryPoli extends Component
{
    // listener from blade////////////////
    protected $listeners = [];

    public string $poliId;
    public string $isOpenMode = 'insert';

    public array $FormEntryPoli = [];




    // rules///////////////////
    protected $rules = [
        'FormEntryPoli.poliId' => 'required|numeric|digits_between:1,3',
        'FormEntryPoli.poliDesc' => 'required',
        'FormEntryPoli.poliIdBPJS' => '',
        'FormEntryPoli.poliUuid' => '',
    ];

    protected $messages = [];

    protected $validationAttributes = [
        'FormEntryPoli.poliId' => 'Kode Poliklinik',
        'FormEntryPoli.poliDesc' => 'Nama Poliklinik'

    ];
    // rules///////////////////





    public function closeModal(): void
    {
        $this->emit('masterPoliCloseModal');
    }

    private function findData($poliId): void
    {
        try {
            $findData = DB::table('rsmst_polis')
                ->where('poli_id', $poliId)
                ->first();


            if ($findData) {
                $this->FormEntryPoli = [
                    'poliId' => $findData->poli_id,
                    'poliDesc' => $findData->poli_desc,
                    'poliIdBPJS' => $findData->kd_poli_bpjs,
                    'poliUuid' => $findData->poli_uuid,

                ];
            } else {

                $this->emit('toastr-error', "Data tidak ditemukan.");
                $this->FormEntryPoli = [
                    'poliId' => null,
                    'poliDesc' => null,
                    'poliIdBPJS' => null,
                    'poliUuid' => null,
                ];
            }
        } catch (Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            $this->FormEntryPoli = [
                'poliId' => null,
                'poliDesc' => null,
                'poliIdBPJS' => null,
                'poliUuid' => null,
            ];
        }
    }


    private function update($poliId): void
    {
        // update table trnsaksi
        DB::table('rsmst_polis')
            ->where('poli_id', $poliId)
            ->update([
                'poli_id' => isset($this->FormEntryPoli['poliId']) ? $this->FormEntryPoli['poliId'] : null,
                'poli_desc' => isset($this->FormEntryPoli['poliDesc']) ? $this->FormEntryPoli['poliDesc'] : '',
                'kd_poli_bpjs' => isset($this->FormEntryPoli['poliIdBPJS']) ? $this->FormEntryPoli['poliIdBPJS'] : '',
                'poli_uuid' => isset($this->FormEntryPoli['poliUuid']) ? $this->FormEntryPoli['poliUuid'] : ''
            ]);

        $this->emit('toastr-success', "Data berhasil diupdate.");
    }

    private function insert(): void
    {
        // update table trnsaksi
        DB::table('rsmst_polis')
            ->insert([
                'poli_id' => isset($this->FormEntryPoli['poliId']) ? $this->FormEntryPoli['poliId'] : null,
                'poli_desc' => isset($this->FormEntryPoli['poliDesc']) ? $this->FormEntryPoli['poliDesc'] : '',
                'kd_poli_bpjs' => isset($this->FormEntryPoli['poliIdBPJS']) ? $this->FormEntryPoli['poliIdBPJS'] : '',
                'poli_uuid' => isset($this->FormEntryPoli['poliUuid']) ? $this->FormEntryPoli['poliUuid'] : ''
            ]);

        $this->emit('toastr-success', "Data berhasil dimasukkan.");
    }

    public function store()
    {
        // validate
        $this->validateData();

        // Jika mode data //insert
        if ($this->isOpenMode == 'insert') {
            $this->insert();
            $this->isOpenMode = 'update';
        } else {
            // Jika mode data //update
            $this->update($this->poliId);
        }

        // $this->closeModal();
    }

    public function UpdatelocationUuid($poliId, $poliDesc)
    {
        // get dulu jika ditemukan update DB
        $getLocation = SatuSehatTrait::getLocation($poliDesc);
        if (isset($getLocation->getOriginalContent()['response']['entry'][0]['resource']['id'])) {
            $this->validateData();
            $this->FormEntryPoli['poliUuid'] = $getLocation->getOriginalContent()['response']['entry'][0]['resource']['id'];
            $this->store();
            return;
        }

        // jika tidak ditemukan maka POST Lokasi
        $this->validateData();

        $location = new Location;
        $location->addIdentifier($poliId); // unique string free text (increments / UUID / inisial)
        $location->setName($poliDesc); // string free text
        $location->addPhysicalType('ro'); // ro = ruangan, bu = bangunan, wi = sayap gedung, ve = kendaraan, ho = rumah, ca = kabined, rd = jalan, area = area. Default bila tidak dideklarasikan = ruangan

        // dd($location->json());
        $mylocation = SatuSehatTrait::postLocation($location->json());

        if (isset($mylocation->getOriginalContent()['response']['id'])) {
            $this->FormEntryPoli['poliUuid'] = $mylocation->getOriginalContent()['response']['id'];
            $this->store();
        } else {
            $this->emit('toastr-error', $mylocation->getOriginalContent()['metadata']['message']);
            return;
        }
    }

    // validate Data RJ//////////////////////////////////////////////////
    private function validateData(): void
    {
        // Proses Validasi///////////////////////////////////////////
        try {

            // tambahkan unique counstrain
            if ($this->isOpenMode == 'insert') {
                $this->rules['FormEntryPoli.poliId'] = 'required|numeric|digits_between:1,3|unique:rsmst_polis,poli_id';
            }

            $this->validate($this->rules, customErrorMessagesTrait::messages());
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->emit('toastr-error', $e->getMessage());
            $this->validate($this->rules, customErrorMessagesTrait::messages());
        }
    }

    public function mount()
    {
        $this->findData($this->poliId);
    }

    public function render()
    {
        return view('livewire.master-poli.form-entry-poli.form-entry-poli');
    }
}
