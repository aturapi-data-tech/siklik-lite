<?php

namespace App\Http\Livewire\Master\MasterPoli\FormEntryPoli;

use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Traits\customErrorMessagesTrait;

use App\Http\Traits\LOV\Pcare\LOVGetPoliFKTP\LOVGetPoliFKTPTrait;

use App\Http\Livewire\SatuSehat\Location\Location;
use App\Http\Traits\SatuSehat\SatuSehatTrait;


use Livewire\Component;

class FormEntryPoli extends Component
{
    use LOVGetPoliFKTPTrait;

    // listener from blade////////////////
    protected $listeners = [];

    public string $poliId;
    public string $isOpenMode = 'insert';

    public array $FormEntryPoli = [];
    public array $poliFKTP = [];



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

        $this->syncDataPrimer();
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

    private function syncDataPrimer(): void
    {
        // sync data primer dilakukan ketika update
        if ($this->isOpenMode == 'update') {
            $this->addGetPoliFKTP($this->FormEntryPoli['poliIdBPJS'], $this->FormEntryPoli['poliDesc'], true);
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

    private function syncDataFormEntry(): void
    {
        //  Entry ketika Mont
        // Pasien Baru Lama di blade wire:model
        $this->FormEntryPoli['poliIdBPJS'] = $this->poliFKTP['kdPoli'] ?? '';
    }
    private function syncLOV(): void
    {
        $this->poliFKTP = $this->collectingMyGetPoliFKTP;
    }

    public function mount()
    {
        $this->findData($this->poliId);
    }

    /*************  ✨ Codeium Command ⭐  *************/
    /**
     * The render method will be called when the component is rendered or after a props value has changed.
     * It will also be called when the Livewire component is mounted.
     *
     * This method will sync the LOV and FormEntry data before rendering the view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    /******  2731f88d-0049-4769-8780-c801c36723f9  *******/
    public function render()
    {
        // LOV
        $this->syncLOV();
        // FormEntry
        $this->syncDataFormEntry();

        return view('livewire.master.master-poli.form-entry-poli.form-entry-poli');
    }
}
