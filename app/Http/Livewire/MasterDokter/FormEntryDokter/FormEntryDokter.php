<?php

namespace App\Http\Livewire\MasterDokter\FormEntryDokter;

use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;

use App\Http\Traits\customErrorMessagesTrait;


use App\Http\Traits\BPJS\SatuSehatTrait;


use Livewire\Component;

class FormEntryDokter extends Component
{
    // listener from blade////////////////
    protected $listeners = [];

    public string $dokterId;
    public string $isOpenMode = 'insert';

    public array $FormEntryDokter = [];




    // rules///////////////////
    protected $rules = [
        'FormEntryDokter.dokterId' => 'required|numeric|digits_between:1,3',
        'FormEntryDokter.dokterName' => 'required',
        'FormEntryDokter.dokterIdBPJS' => '',
        'FormEntryDokter.dokterUuid' => '',
    ];

    protected $messages = [];

    protected $validationAttributes = [
        'FormEntryDokter.dokterId' => 'Kode Dokter',
        'FormEntryDokter.dokterName' => 'Nama Dokter'

    ];
    // rules///////////////////





    public function closeModal(): void
    {
        $this->emit('masterDokterCloseModal');
    }

    private function findData($dokterId): void
    {
        try {
            $findData = DB::table('rsmst_doctors')
                ->where('dr_id', $dokterId)
                ->first();


            if ($findData) {
                $this->FormEntryDokter = [
                    'dokterId' => $findData->dr_id,
                    'dokterName' => $findData->dr_name,
                    'dokterIdBPJS' => $findData->kd_dr_bpjs,
                    'dokterUuid' => $findData->dr_uuid,
                    'dokterNik' => $findData->dr_nik,


                ];
            } else {

                $this->emit('toastr-error', "Data tidak ditemukan.");
                $this->FormEntryDokter = [
                    'dokterId' => null,
                    'dokterName' => null,
                    'dokterIdBPJS' => null,
                    'dokterUuid' => null,
                    'dokterNik' => null,

                ];
            }
        } catch (Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            $this->FormEntryDokter = [
                'dokterId' => null,
                'dokterName' => null,
                'dokterIdBPJS' => null,
                'dokterUuid' => null,
                'dokterNik' => null,

            ];
        }
    }


    private function update($dokterId): void
    {
        // update table trnsaksi
        DB::table('rsmst_doctors')
            ->where('dr_id', $dokterId)
            ->update([
                'dr_id' => isset($this->FormEntryDokter['dokterId']) ? $this->FormEntryDokter['dokterId'] : null,
                'dr_name' => isset($this->FormEntryDokter['dokterName']) ? $this->FormEntryDokter['dokterName'] : '',
                'kd_dr_bpjs' => isset($this->FormEntryDokter['dokterIdBPJS']) ? $this->FormEntryDokter['dokterIdBPJS'] : '',
                'dr_uuid' => isset($this->FormEntryDokter['dokterUuid']) ? $this->FormEntryDokter['dokterUuid'] : '',
                'dr_nik' => isset($this->FormEntryDokter['dokterNik']) ? $this->FormEntryDokter['dokterNik'] : '',
            ]);

        $this->emit('toastr-success', "Data berhasil diupdate.");
    }

    private function insert(): void
    {
        // update table trnsaksi
        DB::table('rsmst_doctors')
            ->insert([
                'dr_id' => isset($this->FormEntryDokter['dokterId']) ? $this->FormEntryDokter['dokterId'] : null,
                'dr_name' => isset($this->FormEntryDokter['dokterName']) ? $this->FormEntryDokter['dokterName'] : '',
                'kd_dr_bpjs' => isset($this->FormEntryDokter['dokterIdBPJS']) ? $this->FormEntryDokter['dokterIdBPJS'] : '',
                'dr_uuid' => isset($this->FormEntryDokter['dokterUuid']) ? $this->FormEntryDokter['dokterUuid'] : '',
                'dr_nik' => isset($this->FormEntryDokter['dokterNik']) ? $this->FormEntryDokter['dokterNik'] : '',
            ]);

        $this->emit('toastr-success', "Data berhasil dimasukkan.");
    }

    public function store()
    {
        // validate
        $this->validateData();

        // Jika mode data //insert
        if ($this->isOpenMode == 'insert') {
            $this->emit('toastr-error', "masih dikembangkan Master Level 2.");
            return;
            $this->insert();
            $this->isOpenMode = 'update';
        } else {
            // Jika mode data //update
            $this->update($this->dokterId);
        }

        // $this->closeModal();
    }

    public function UpdatePractitionerUuid(string $nik = '')
    {
        // Proses Validasi///////////////////////////////////////////
        $r = ['nik' => $nik];
        $rules = ['nik' => 'bail|required|digits:16'];
        $customErrorMessagesTrait = customErrorMessagesTrait::messages();
        $attribute = ['nik' => 'Data NIK'];

        $validator = Validator::make($r, $rules, $customErrorMessagesTrait, $attribute);

        if ($validator->fails()) {
            $this->emit('toastr-error', $validator->messages()->all());
            return;
        }
        // Proses Validasi///////////////////////////////////////////


        // Proses Validasi///////////////////////////////////////////
        try {

            $PractitionerByNIK = SatuSehatTrait::PractitionerByNIK($nik);

            // Jika uuid tidak ditemukan
            if (!isset($PractitionerByNIK->getOriginalContent()['response']['entry'][0]['resource']['id'])) {
                $this->emit('toastr-error', 'UUID tidak dapat ditemukan.' . $PractitionerByNIK->getOriginalContent()['metadata']['message']);
                return;
            }

            $this->validateData();
            $this->FormEntryDokter['dokterUuid'] = $PractitionerByNIK->getOriginalContent()['response']['entry'][0]['resource']['id'];
            $this->store();
            $this->emit('toastr-success', $PractitionerByNIK->getOriginalContent()['response']['entry'][0]['resource']['id'] . ' / ' . $PractitionerByNIK->getOriginalContent()['response']['entry'][0]['resource']['name'][0]['text']);
            return;

            // dd($PractitionerByNIK->getOriginalContent());
            // dd($PractitionerByNIK->getOriginalContent()['response']['entry'][0]['resource']['id']);
            // dd($PractitionerByNIK->getOriginalContent()['response']['entry'][0]['resource']['name'][0]['text']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // dd($validator->fails());
            $this->emit('toastr-error', 'Errors "' . $e->getMessage());
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
                $this->rules['FormEntryDokter.dokterId'] = 'required|numeric|digits_between:1,3|unique:rsmst_doctors,dr_id';
            }

            $this->validate($this->rules, customErrorMessagesTrait::messages());
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->emit('toastr-error', $e->getMessage());
            $this->validate($this->rules, customErrorMessagesTrait::messages());
        }
    }

    public function mount()
    {
        $this->findData($this->dokterId);
    }

    public function render()
    {
        return view('livewire.master-dokter.form-entry-dokter.form-entry-dokter');
    }
}
