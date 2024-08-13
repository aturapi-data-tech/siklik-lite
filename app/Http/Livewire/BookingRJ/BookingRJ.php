<?php

namespace App\Http\Livewire\BookingRJ;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;


class BookingRJ extends Component
{
    use WithPagination;

    // primitive Variable
    public string $myTitle = 'Booking Rawat Jalan';
    public string $mySnipt = 'Daftar Pasien yang Melakukan Booking Layanan Rawat Jalan';
    public string $myProgram = 'Pasien Rawat Jalan';

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

        'refStatusId' => 'Belum',
        'refStatusDesc' => 'Belum',
        'refStatusOptions' => [
            ['refStatusId' => 'Belum', 'refStatusDesc' => 'Belum'],
            ['refStatusId' => 'Checkin', 'refStatusDesc' => 'Checkin'],
            ['refStatusId' => 'Batal', 'refStatusDesc' => 'Batal'],
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
        $query = DB::table('rsview_rjkasir')
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

    public function editScreening($rjNo, $regNoRef)
    {
        $this->openModalEditScreening($rjNo, $regNoRef);
        // $this->findData($id);
    }





    // listener from blade////////////////
    protected $listeners = [
        // 'ListenerisOpenRJ' => 'ListenerisOpenRJ',
        'confirm_remove_record_RJp' => 'delete'
    ];

    // public function ListenerisOpenRJ($ListenerisOpenRJ): void
    // {
    //     // dd($ListenerisOpenRJ);
    //     $this->isOpen = $ListenerisOpenRJ['isOpen'];
    //     $this->isOpenMode = $ListenerisOpenRJ['isOpenMode'];
    //     $this->render();
    // }


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
        [
            'ermMenuId' => 'suket',
            'ermMenuName' => 'Surat Keterangan (Sehat/Istirahat)'
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
            'ermMenuName' => 'Resume Medis'
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

        $query = DB::table('referensi_mobilejkn_bpjs')
            ->select(
                // DB::raw("to_char(rj_date,'dd/mm/yyyy hh24:mi:ss') AS rj_date"),
                // DB::raw("to_char(rj_date,'yyyymmddhh24miss') AS rj_date1"),
                'nobooking',
                'no_rawat',
                'nomorkartu',
                'nik',
                'nohp',
                'kodepoli',
                DB::raw("(select poli_desc from rsmst_polis where kd_poli_bpjs=referensi_mobilejkn_bpjs.kodepoli)poli_desc"),
                'pasienbaru',
                'norm',
                'kodedokter',
                DB::raw("(select dr_name from rsmst_doctors where kd_dr_bpjs=referensi_mobilejkn_bpjs.kodedokter)dr_name"),
                DB::raw("to_char(to_date(tanggalperiksa,'yyyy-mm-dd'),'dd/mm/yyyy') as tanggalperiksa"),
                'jampraktek',
                'jeniskunjungan',
                'nomorreferensi',
                'nomorantrean',
                'angkaantrean',
                'estimasidilayani',
                'sisakuotajkn',
                'kuotajkn',
                'sisakuotanonjkn',
                'kuotanonjkn',
                'status',
                'validasi',
                'statuskirim',
                'keterangan_batal',
                'tanggalbooking',
                'daftardariapp',
                'reg_name',
                'address'

            )
            ->join('rsmst_pasiens', 'referensi_mobilejkn_bpjs.norm', 'rsmst_pasiens.reg_no')
            ->where(DB::raw("to_char(to_date(tanggalperiksa,'yyyy-mm-dd'),'dd/mm/yyyy')"), '=', $myRefdate)
            ->orderBy('tanggalperiksa',  'asc')
            ->orderBy('kodedokter',  'asc');


        ////////////////////////////////////////////////
        // end Query
        ///////////////////////////////////////////////


        return view(
            'livewire.booking-r-j.booking-r-j',
            ['myQueryData' => $query->paginate($this->limitPerPage)]
        );
    }
    // select data end////////////////


}
