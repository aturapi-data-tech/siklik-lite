<?php

namespace App\Http\Livewire\MasterPoli;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

use App\Http\Traits\customErrorMessagesTrait;

class MasterPoli extends Component
{

    use WithPagination;
    protected $listeners = ['masterPoliCloseModal' => 'closeModal'];



    // primitive Variable
    public string $myTitle = 'Data Poli';
    public string $mySnipt = 'Master Poli / Ruang Poli';
    public string $myProgram = 'Data Poli';

    // ID
    public string $poliId;

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
        $this->poliId = '';
    }

    public function edit($id): void
    {
        $this->openModalEdit();
        $this->poliId = $id;
    }

    public function delete($poliId, $poliDesc): void
    {
        // Proses Validasi///////////////////////////////////////////
        $r = ['poliId' => $poliId];
        $rules = ['poliId' => 'required|numeric|unique:rstxn_rjhdrs,poli_id'];
        $customErrorMessagesTrait = customErrorMessagesTrait::messages();
        $customErrorMessagesTrait['unique'] = 'Data :attribute sudah dipakai pada transaksi Rawat Jalan.';
        $attribute = ['poliId' => 'Poliklinik'];

        $validator = Validator::make($r, $rules, $customErrorMessagesTrait, $attribute);

        if ($validator->fails()) {
            $this->emit('toastr-error', $validator->messages()->all());
            return;
        }
        // Proses Validasi///////////////////////////////////////////

        // delete table trnsaksi
        DB::table('rsmst_polis')
            ->where('poli_id', $poliId)
            ->delete();

        $this->emit('toastr-success', "Data " . $poliDesc . " berhasil dihapus.");
    }
    // open and close modal start////////////////

    public function render()
    {
        // set mySearch
        $mySearch = $this->refFilter;

        //////////////////////////////////////////
        // Query ///////////////////////////////
        //////////////////////////////////////////
        $query = DB::table('rsmst_polis')
            ->select(
                'poli_id',
                'poli_desc',
                'kd_poli_bpjs',
                'poli_uuid'
            );

        $query->where(function ($q) use ($mySearch) {
            $q->Where(DB::raw('upper(poli_id)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(poli_desc)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(kd_poli_bpjs)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(poli_uuid)'), 'like', '%' . strtoupper($mySearch) . '%');
        })
            ->orderBy('poli_desc',  'asc');


        ////////////////////////////////////////////////
        // end Query
        ///////////////////////////////////////////////

        return view('livewire.master-poli.master-poli', ['myQueryData' => $query->paginate($this->limitPerPage)]);
    }
}
