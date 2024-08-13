<?php

namespace App\Http\Livewire\MasterDokter;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

use App\Http\Traits\customErrorMessagesTrait;

class MasterDokter extends Component
{

    use WithPagination;
    protected $listeners = ['masterDokterCloseModal' => 'closeModal'];



    // primitive Variable
    public string $myTitle = 'Data Dokter';
    public string $mySnipt = 'Master Dokter / Poli';
    public string $myProgram = 'Data Dokter';

    // ID
    public string $dokterId;

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
        $this->dokterId = '';
    }

    public function edit($id): void
    {
        $this->openModalEdit();
        $this->dokterId = $id;
    }

    public function delete($dokterId, $dokterDesc): void
    {
        // Proses Validasi///////////////////////////////////////////
        $r = ['dokterId' => $dokterId];
        $rules = ['dokterId' => 'required|numeric|unique:rstxn_rjhdrs,dr_id'];
        $customErrorMessagesTrait = customErrorMessagesTrait::messages();
        $customErrorMessagesTrait['unique'] = 'Data :attribute sudah dipakai pada transaksi Rawat Jalan.';
        $attribute = ['dokterId' => 'Poliklinik'];

        $validator = Validator::make($r, $rules, $customErrorMessagesTrait, $attribute);

        if ($validator->fails()) {
            $this->emit('toastr-error', $validator->messages()->all());
            return;
        }
        // Proses Validasi///////////////////////////////////////////

        // delete table trnsaksi
        DB::table('rsmst_doctors')
            ->where('dr_id', $dokterId)
            ->delete();

        $this->emit('toastr-success', "Data " . $dokterDesc . " berhasil dihapus.");
    }
    // open and close modal start////////////////

    public function render()
    {
        // set mySearch
        $mySearch = $this->refFilter;

        //////////////////////////////////////////
        // Query ///////////////////////////////
        //////////////////////////////////////////
        $query = DB::table('rsmst_doctors')
            ->select(
                'dr_id',
                'dr_name',
                'kd_dr_bpjs',
                'dr_uuid',
                'dr_nik',
                'dr_phone',
                'dr_address',
                'rsmst_polis.poli_desc as poli_desc'
            )->join('rsmst_polis', 'rsmst_polis.poli_id', '=',  'rsmst_doctors.poli_id')
            ->where('active_status', '=', '1');

        $query->where(function ($q) use ($mySearch) {
            $q->Where(DB::raw('upper(dr_id)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(dr_name)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(kd_dr_bpjs)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(dr_uuid)'), 'like', '%' . strtoupper($mySearch) . '%');
        })
            ->orderBy('dr_name',  'asc');


        ////////////////////////////////////////////////
        // end Query
        ///////////////////////////////////////////////

        return view('livewire.master-dokter.master-dokter', ['myQueryData' => $query->paginate($this->limitPerPage)]);
    }
}
