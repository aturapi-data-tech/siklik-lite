<?php

namespace App\Http\Livewire\Master\MasterRefBpjs;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

use App\Http\Traits\customErrorMessagesTrait;

class MasterRefBpjs extends Component
{

    use WithPagination;
    protected $listeners = ['masterRefBpjsCloseModal' => 'closeModal'];



    // primitive Variable
    public string $myTitle = 'Data Ref BPJS';
    public string $mySnipt = 'Master Ref BPJS / Data Ref BPJS';
    public string $myProgram = 'Ref BPJS';

    // ID
    public string $refBpjsId;

    public array $myLimitPerPages = [5, 10, 15, 20, 100];
    // limit record per page -resetExcept////////////////
    public int $limitPerPage = 10;

    // my Top Bar
    public array $myTopBar = [];

    // ///////////////refFilter//////////////////////////////////
    public string $refFilter = '';

    // resert page pagination when coloumn search change ////////////////
    public function updatedReffilter(): void
    {
        $this->resetPage();
        $this->resetValidation();
    }
    // ///////////////refFilter//////////////////////////////////


    // open and close modal start////////////////
    public bool $isOpen = false;
    public string $isOpenMode = 'insert';

    private function openModal(): void
    {
        $this->isOpen = true;
        $this->isOpenMode = 'insert';
    }

    private function openModalEdit(): void
    {
        $this->isOpen = true;
        $this->isOpenMode = 'update';
    }

    public function closeModal(): void
    {
        $this->reset(['isOpen', 'isOpenMode']);
    }

    public function create(): void
    {
        $this->openModal();
        $this->refBpjsId = '';
    }

    public function edit($id): void
    {
        $this->openModalEdit();
        $this->refBpjsId = $id;
    }

    public function delete($refBpjsId, $poliDesc): void
    {
        // Proses Validasi///////////////////////////////////////////
        $r = ['refBpjsId' => $refBpjsId];
        $rules = ['refBpjsId' => 'required|numeric|unique:rstxn_rjhdrs,poli_id|unique:rsmst_doctors,poli_id'];
        $customErrorMessagesTrait = customErrorMessagesTrait::messages();
        $customErrorMessagesTrait['unique'] = 'Data :attribute sudah dipakai pada transaksi Rawat Jalan.';
        $attribute = ['refBpjsId' => 'Poliklinik'];

        $validator = Validator::make($r, $rules, $customErrorMessagesTrait, $attribute);

        if ($validator->fails()) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($validator->messages()->all());
            return;
        }
        // Proses Validasi///////////////////////////////////////////

        // delete table trnsaksi
        DB::table('rsmst_polis')
            ->where('poli_id', $refBpjsId)
            ->delete();

        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
            ->addSuccess("Data " . $poliDesc . " berhasil dihapus.");
    }
    // open and close modal start////////////////

    public function render()
    {
        // set mySearch
        $mySearch = $this->refFilter;

        //////////////////////////////////////////
        // Query ///////////////////////////////
        //////////////////////////////////////////
        $query = DB::table('ref_bpjs_table')
            ->select(
                'ref_keterangan',
                'ref_json',
            );

        $query->where(function ($q) use ($mySearch) {
            $q->Where(DB::raw('upper(ref_keterangan)'), 'like', '%' . strtoupper($mySearch) . '%');
        })
            ->orderBy('ref_keterangan',  'asc');


        ////////////////////////////////////////////////
        // end Query
        ///////////////////////////////////////////////

        return view('livewire.master.master-ref-bpjs.master-ref-bpjs', ['myQueryData' => $query->paginate($this->limitPerPage)]);
    }
}
