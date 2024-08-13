<?php

namespace App\Http\Livewire\EmrUGD;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;



class EmrUGD extends Component
{
    use WithPagination;

    // primitive Variable
    public string $myTitle = 'Rekam Medis UGD';
    public string $mySnipt = 'Rekam Medis Pasien';
    public string $myProgram = 'Pasien UGD';

    public array $myLimitPerPages = [5, 10, 15, 20, 100];
    // limit record per page -resetExcept////////////////
    public int $limitPerPage = 10;

    // my Reg No

    public string $regNo = '';

    public bool $callMasterPasien = false;





    // my Top Bar
    public array $myTopBar = [
        'refDate' => '',

        'refShiftId' => '1',
        'refShiftDesc' => '1',
        'refShiftOptions' => [
            ['refShiftId' => '1', 'refShiftDesc' => '1'],
            ['refShiftId' => '2', 'refShiftDesc' => '2'],
            ['refShiftId' => '3', 'refShiftDesc' => '3'],
        ],

        'refStatusId' => 'A',
        'refStatusDesc' => 'Antrian',
        'refStatusOptions' => [
            ['refStatusId' => 'A', 'refStatusDesc' => 'Antrian'],
            ['refStatusId' => 'L', 'refStatusDesc' => 'Selesai'],
            ['refStatusId' => 'I', 'refStatusDesc' => 'Transfer'],
        ],

        'drId' => 'All',
        'drName' => 'All',
        'drOptions' => [
            [
                'drId' => 'All',
                'drName' => 'All'
            ]
        ]
    ];

    public string $refFilter = '';
    // search logic -resetExcept////////////////
    protected $queryString = [
        'refFilter' => ['except' => '', 'as' => 'cariData'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];

    // reset page when myTopBar Change
    public function updatedReffilter()
    {
        $this->resetPage();
    }

    public function updatedMytopbarRefdate()
    {
        $this->resetPage();
    }

    public function updatedMytopbarRefstatusid()
    {
        $this->resetPage();
    }

    // setter myTopBar Shift and myTopBar refDate
    private function settermyTopBarShiftandmyTopBarrefDate(): void
    {
        // dd/mm/yyyy hh24:mi:ss
        $this->myTopBar['refDate'] = Carbon::now()->format('d/m/Y');
        // dd(Carbon::now()->format('H:i:s'));

        // shift
        $findShift = DB::table('rstxn_shiftctls')->select('shift')
            ->whereRaw("'" . Carbon::now()->format('H:i:s') . "' between
             shift_start and shift_end")
            ->first();
        $this->myTopBar['refShiftId'] = isset($findShift->shift) && $findShift->shift ? $findShift->shift : 3;
    }

    private function gettermyTopBardrOptions(): void
    {
        $myRefdate = $this->myTopBar['refDate'];

        // Query
        $query = DB::table('rsview_ugdkasir')
            ->select(
                'dr_id',
                'dr_name',
            )
            ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $myRefdate)
            ->groupBy('dr_id')
            ->groupBy('dr_name')
            ->orderBy('dr_name', 'desc')
            ->get();

        // loop and set Ref
        $query->each(function ($item, $key) {
            $this->myTopBar['drOptions'][$key + 1]['drId'] = $item->dr_id;
            $this->myTopBar['drOptions'][$key + 1]['drName'] = $item->dr_name;
        })->toArray();
    }

    public function settermyTopBardrOptions($drId, $drName): void
    {

        $this->myTopBar['drId'] = $drId;
        $this->myTopBar['drName'] = $drName;
        $this->resetPage();
    }




    // open and close modal start////////////////
    //  modal status////////////////
    public bool $isOpen = false;
    public string $isOpenMode = 'insert';

    public bool $isOpenDokter = false;
    public string $isOpenModeDokter = 'insert';

    public bool $isOpenInap = false;
    public string $isOpenModeInap = 'insert';

    public bool $isOpenScreening = false;
    public string $isOpenModeScreening = 'insert';

    public bool $forceInsertRecord = false;

    public int $rjNoRef;
    public string $regNoRef;

    //
    private function openModal(): void
    {
        $this->isOpen = true;
        $this->isOpenMode = 'insert';
    }
    private function openModalEdit($rjNo, $regNoRef): void
    {
        $this->isOpen = true;
        $this->isOpenMode = 'update';
        $this->rjNoRef = $rjNo;
        $this->regNoRef = $regNoRef;
    }

    private function openModalEditDokter($rjNo, $regNoRef): void
    {
        $this->isOpenDokter = true;
        $this->isOpenModeDokter = 'update';
        $this->rjNoRef = $rjNo;
        $this->regNoRef = $regNoRef;
    }

    private function openModalEditInap($rjNo, $regNoRef): void
    {
        $this->isOpenInap = true;
        $this->isOpenModeInap = 'update';
        $this->rjNoRef = $rjNo;
        $this->regNoRef = $regNoRef;
    }

    private function openModalEditScreening($rjNo, $regNoRef): void
    {
        $this->isOpenScreening = true;
        $this->isOpenModeScreening = 'update';
        $this->rjNoRef = $rjNo;
        $this->regNoRef = $regNoRef;
    }

    private function openModalTampil(): void
    {
        $this->isOpen = true;
        $this->isOpenMode = 'tampil';
    }

    public function closeModal(): void
    {
        $this->isOpen = false;
        $this->isOpenMode = 'insert';
        $this->resetInputFields();
    }

    public function closeModalDokter(): void
    {
        $this->isOpenDokter = false;
        $this->isOpenModeDokter = 'insert';
        $this->resetInputFields();
    }

    public function closeModalInap(): void
    {
        $this->isOpenInap = false;
        $this->isOpenModeInap = 'insert';
        $this->resetInputFields();
    }

    public function closeModalScreening(): void
    {
        $this->isOpenScreening = false;
        $this->isOpenModeScreening = 'insert';
        $this->resetInputFields();
    }
    // open and close modal end////////////////


    // resert input private////////////////
    private function resetInputFields(): void
    {

        // resert validation
        $this->resetValidation();
        // resert input

    }
    // resert input private////////////////

    // is going to edit data/////////////////
    public function edit($rjNo, $regNoRef)
    {
        $this->openModalEdit($rjNo, $regNoRef);
        // $this->findData($id);
    }

    public function editDokter($rjNo, $regNoRef)
    {
        $this->openModalEditDokter($rjNo, $regNoRef);
        // $this->findData($id);
    }

    // is going to edit data/////////////////
    public function editInap($rjNo, $regNoRef)
    {
        $this->openModalEditInap($rjNo, $regNoRef);
        // $this->findData($id);
    }

    public function editScreening($rjNo, $regNoRef)
    {
        $this->openModalEditScreening($rjNo, $regNoRef);
        // $this->findData($id);
    }


    // listener from blade////////////////
    protected $listeners = [
        'ListenerisOpenUgd' => 'ListenerisOpenUgd',
        'confirm_remove_record_UGDp' => 'delete'
    ];

    public function ListenerisOpenUgd($ListenerisOpenUgd): void
    {
        // dd($ListenerisOpenUgd);
        $this->isOpen = $ListenerisOpenUgd['isOpen'];
        $this->isOpenMode = $ListenerisOpenUgd['isOpenMode'];
        $this->render();
    }


    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////

    // is going to insert data////////////////
    public function create()
    {
        $this->openModal();
    }

    public function tampil()
    {
        $this->emit('toastr-error', 'Fitur dalam masa pengembangan');
    }

    public function delete()
    {
        $this->emit('toastr-error', 'Fitur dalam masa pengembangan');
    }


    public function callFormPasien(): void
    {
        // set Call MasterPasien True
        $this->callMasterPasien = true;
    }

    public string $activeTab = "rekamMedis";
    public string $activeTabDokter = "assessmentDokter";


    public array $EmrMenu = [
        // [
        //     'ermMenuId' => 'keperawatan',
        //     'ermMenuName' => 'Keperawatan'
        // ],
        [
            'ermMenuId' => 'anamnesa',
            'ermMenuName' => 'Anamnesa'
        ],
        [
            'ermMenuId' => 'pemeriksaan',
            'ermMenuName' => 'Pemeriksaan'
        ],
        [
            'ermMenuId' => 'penilaian',
            'ermMenuName' => 'Penilaian'
        ],
        [
            'ermMenuId' => 'diagnosis',
            'ermMenuName' => 'Diagnosis (ICD)'
        ],
        // [
        //     'ermMenuId' => 'penandaanGbr',
        //     'ermMenuName' => 'Penandaan Gambar'
        // ],
        [
            'ermMenuId' => 'perencanaan',
            'ermMenuName' => 'Perencanaan'
        ],
        [
            'ermMenuId' => 'administrasi',
            'ermMenuName' => 'Administrasi'
        ],
        // [
        //     'ermMenuId' => 'cppt',
        //     'ermMenuName' => 'CPPT'
        // ],
        // [
        //     'ermMenuId' => 'resumeMds',
        //     'ermMenuName' => 'Resume Medis'
        // ],
        // [
        //     'ermMenuId' => 'penerbitanSrt',
        //     'ermMenuName' => 'Penerbitan Surat'
        // ],
        [
            'ermMenuId' => 'rekamMedis',
            'ermMenuName' => 'Rekam Medis'
        ],

    ];

    public array $EmrMenuDokter = [
        [
            'ermMenuId' => 'assessmentDokter',
            'ermMenuName' => 'Assessment Dokter'
        ],
        [
            'ermMenuId' => 'pelayananPenunjang',
            'ermMenuName' => 'Pelayanan Penunjang'
        ],
        [
            'ermMenuId' => 'rekamMedis',
            'ermMenuName' => 'Resume Medis'
        ],

    ];


    // when new form instance
    public function mount()
    {
        $this->settermyTopBarShiftandmyTopBarrefDate();
    }




    // select data start////////////////
    public function render()
    {
        $this->gettermyTopBardrOptions();

        // set mySearch
        $mySearch = $this->refFilter;
        $myRefdate = $this->myTopBar['refDate'];
        // $myRefshift = $this->myTopBar['refShiftId'];
        $myRefstatusId = $this->myTopBar['refStatusId'];
        $myRefdrId = $this->myTopBar['drId'];



        //////////////////////////////////////////
        // Query ///////////////////////////////
        //////////////////////////////////////////
        $query = DB::table('rsview_ugdkasir')
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
                DB::raw("'UGD' AS poli_id"),
                DB::raw("'UGD' AS poli_desc"),
                'dr_id',
                'dr_name',
                'klaim_id',
                'shift',
                'vno_sep',
                'no_antrian',
                'rj_status',
                'nobooking',
                'push_antrian_bpjs_status',
                'push_antrian_bpjs_json',
                'datadaftarugd_json'
            )
            ->where(DB::raw("nvl(erm_status,'A')"), '=', $myRefstatusId)
            ->where('rj_status', '!=', 'F')

            // ->where('shift', '=', $myRefshift)
            ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $myRefdate);

        // Jika where dokter tidak kosong
        if ($myRefdrId != 'All') {
            $query->where('dr_id', $myRefdrId);
        }


        $query->where(function ($q) use ($mySearch) {
            $q->Where(DB::raw('upper(reg_name)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(reg_no)'), 'like', '%' . strtoupper($mySearch) . '%')
                ->orWhere(DB::raw('upper(dr_name)'), 'like', '%' . strtoupper($mySearch) . '%');
        })
            ->orderBy('rj_date1',  'desc')
            ->orderBy('dr_name',  'desc')
            ->orderBy('no_antrian',  'asc');

        ////////////////////////////////////////////////
        // end Query
        ///////////////////////////////////////////////



        return view(
            'livewire.emr-u-g-d.emr-u-g-d',
            ['myQueryData' => $query->paginate($this->limitPerPage)]
        );
    }
    // select data end////////////////


}
