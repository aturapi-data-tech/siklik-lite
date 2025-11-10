<?php

namespace App\Http\Livewire\RJ\DaftarRJ;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Http\Traits\BPJS\PcareTrait;

use App\Http\Traits\customErrorMessagesTrait;

class DaftarRJ extends Component
{
    use PcareTrait;

    use WithPagination;
    protected $listeners = ['CloseModal' => 'closeModal'];



    // primitive Variable
    public string $myTitle = 'Data Pasien Rawat Jalan';
    public string $mySnipt = 'Rekam Medis Pasien';
    public string $myProgram = 'Pasien Rawat Jalan';


    public array $pendaftaranProvider = [];


    public function getPedaftaranProviderBPJS($tglDaftar, $start, $end): void
    {

        $tglDaftarFormatted = Carbon::createFromFormat('d/m/Y', $tglDaftar, env('APP_TIMEZONE'))->format('d-m-Y');
        try {

            $data = $this->getPendaftaranProvider($tglDaftarFormatted, $start, $end)->getOriginalContent();
            dd($data);
            $this->pendaftaranProvider = isset($data['response']['count']) ? $data : [];
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
            return;
        }
    }

    /////////////////////
    // TopBar Parameters
    /////////////////////
    public string $dateRjRef = '';

    public array $shiftRjRef = [
        'shiftId' => '1',
        'shiftDesc' => '1',
        'shiftOptions' => [
            ['shiftId' => '1', 'shiftDesc' => '1'],
            ['shiftId' => '2', 'shiftDesc' => '2'],
            ['shiftId' => '3', 'shiftDesc' => '3'],
        ]
    ];

    public array $statusRjRef = [
        'statusId' => 'A',
        'statusDesc' => 'Antrian',
        'statusOptions' => [
            ['statusId' => 'A', 'statusDesc' => 'Antrian'],
            ['statusId' => 'L', 'statusDesc' => 'Selesai'],
            ['statusId' => 'I', 'statusDesc' => 'Transfer'],
        ]
    ];

    public $drRjRef = [
        'drId' => 'All',
        'drName' => 'All',
        'drOptions' => [
            [
                'drId' => 'All',
                'drName' => 'All'
            ]
        ]
    ];

    // dr
    public function setdrRjRef($id, $name): void
    {
        toastr()
            ->closeOnHover(true)
            ->closeDuration(3)
            ->positionClass('toast-top-left')
            ->addError($id);

        $this->drRjRef['drId'] = $id;
        $this->drRjRef['drName'] = $name;
        $this->resetPage();
        $this->resetValidation();
    }
    /////////////////////
    // TopBar Parameters
    /////////////////////




    // ID
    public string $rjNoRef;

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
        $this->rjNoRef = '';
    }

    public function edit($id): void
    {
        $this->openModalEdit();
        $this->rjNoRef = $id;
    }


    // open and close modal start////////////////







    // /////////////////////
    // TopBarFunction
    // /////////////////////

    // Menambahkan dokter yang aktif
    private function optionsdrRjRef(): void
    {
        // Query
        $query = DB::table('rsview_rjkasir')
            ->select(
                'dr_id',
                'dr_name',
            )
            // ->where('shift', '=', $this->shiftRjRef['shiftId'])
            ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $this->dateRjRef)
            ->groupBy('dr_id')
            ->groupBy('dr_name')
            ->orderBy('dr_name', 'desc')
            ->get();

        // loop and set Ref
        $query->each(function ($item, $key) {
            $this->drRjRef['drOptions'][$key + 1]['drId'] = $item->dr_id;
            $this->drRjRef['drOptions'][$key + 1]['drName'] = $item->dr_name;
        })->toArray();
    }

    private function setCurrentDate(): void
    {
        $this->dateRjRef = Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y');
    }

    private function setCurrentShift(): void
    {
        $findShift = DB::table('rstxn_shiftctls')->select('shift')
            ->whereRaw("'" . Carbon::now(env('APP_TIMEZONE'))->format('H:i:s') . "' between shift_start and shift_end")
            ->first();
        $this->shiftRjRef['shiftId'] = isset($findShift->shift) && $findShift->shift ? $findShift->shift : 1;
        $this->shiftRjRef['shiftDesc'] = isset($findShift->shift) && $findShift->shift ? $findShift->shift : 1;
    }
    // /////////////////////
    // TopBarFunction
    // /////////////////////







    // when new form instance
    public function mount()
    {
        $this->setCurrentDate();
        $this->setCurrentShift();
        $this->optionsdrRjRef();
    }

    public function render()
    {
        // set mySearch
        $mySearch = $this->refFilter;
        $myStatus = $this->statusRjRef['statusId'];
        // $myShift = $this->shiftRjRef['shiftId'];
        $myDr =  $this->drRjRef['drId'];
        $myDate = $this->dateRjRef;

        //////////////////////////////////////////
        // Query ///////////////////////////////
        //////////////////////////////////////////

        $query = DB::table('rsview_rjkasir')
            ->select(
                DB::raw("to_char(rj_date,'dd/mm/yyyy hh24:mi:ss') AS rj_date"),
                DB::raw("to_char(rj_date,'yyyymmddhh24miss') AS rj_date1"),
                'rj_no',
                'reg_no',
                'reg_name',
                'sex',
                'address',
                'thn',
                DB::raw("to_char(birth_date,'dd/mm/yyyy') AS birth_date"),
                'poli_id',
                'poli_desc',
                'dr_id',
                'dr_name',
                'klaim_id',
                'shift',
                'vno_sep',
                'no_antrian',
                'rj_status',
                'nobooking',

            )
            ->where('rj_status', '=', $myStatus)
            // ->where('shift', '=', $myShift)
            ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $myDate);

        //Jika where dokter tidak kosong
        if ($myDr != 'All') {
            $query->where('dr_id', $myDr);
        }

        $query->where(function ($q) use ($mySearch) {
            $q->Where(DB::raw('upper(reg_name)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(reg_no)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(dr_name)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(poli_desc)'), 'like', '%' . strtoupper($mySearch) . '%');
        })
            ->orderBy('dr_name',  'desc')
            ->orderBy('poli_desc',  'desc')
            ->orderBy('no_antrian',  'asc')
            ->orderBy('rj_date1',  'desc');

        ////////////////////////////////////////////////
        // end Query
        ///////////////////////////////////////////////



        return view('livewire.r-j.daftar-r-j.daftar-r-j', ['myQueryData' => $query->paginate($this->limitPerPage)]);
    }
}
