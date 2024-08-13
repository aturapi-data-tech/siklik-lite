<?php

namespace App\Http\Livewire\SetupHfisBpjs;

use Livewire\Component;
use App\Models\Province;
use Livewire\WithPagination;

use Carbon\Carbon;

use App\Http\Traits\BPJS\AntrianTrait;
use App\Http\Traits\BPJS\VclaimTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\BPJS\SatuSehatTrait;
use App\Http\Livewire\SatuSehat\Encounter\Encounter;





class SetupHfisBpjs extends Component
{
    use WithPagination;

    //  table data////////////////
    public $name, $province_id;


    // limit record per page -resetExcept////////////////
    public $limitPerPage = 5;

    //  table LOV////////////////
    public $hfisLov = [];
    public $hfisLovStatus = 0;
    public $hfisLovSearch = '';

    // get Jadwal Dokter BPJS
    public $jadwal_dokter = [];


    //  modal status////////////////
    public $isOpen = 0;
    public $isOpenMode = 'insert';
    public $tampilIsOpen = 0;


    // search logic -resetExcept////////////////
    public $search;
    protected $queryString = [
        'search' => ['except' => '', 'as' => 'cariData'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];


    // sort logic -resetExcept////////////////
    public $sortField = 'id';
    public $sortAsc = true;


    // listener from blade////////////////
    protected $listeners = [
        'confirm_remove_record_province' => 'delete',
    ];


    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $dateRef = '';

    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////


    public function gettokenSatusehat(): void
    {
        // $accesstoken = SatuSehatTrait::OAuth2();

        // dd($accesstoken->getOriginalContent());

        // $PatientByNIK = SatuSehatTrait::PatientByNIK('3504111211890002');
        // dd($PatientByNIK->getOriginalContent());

        // $PractitionerByNIK = SatuSehatTrait::PractitionerByNIK('3504111211890002');
        // dd($PractitionerByNIK->getOriginalContent());

        $encounter = new Encounter;
        // $uuid = Uuid::uuid4()->toString();
        $rjNo = 1;
        $encounter->addRegistrationId($rjNo); // unique string free text (increments / UUID)

        $encounter->setArrived(Carbon::now()->subMinutes(15)->toDateTimeString());
        $encounter->setInProgress(Carbon::now()->subMinutes(5)->toDateTimeString(), Carbon::now()->toDateTimeString());
        $encounter->setFinished(Carbon::now()->toDateTimeString());

        $encounter->addRegistrationId('123456789'); // unique string free text (increments / UUID)
        $encounter->setConsultationMethod('RAJAL'); // RAJAL, IGD, RANAP, HOMECARE, TELEKONSULTASI
        $encounter->setSubject('P12312312123', 'TESTER'); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
        $encounter->addParticipant('102938712983', 'dr. X'); // ID SATUSEHAT Dokter, Nama Dokter
        $encounter->addLocation('A1-001', 'Ruang Poli A1'); // ID SATUSEHAT Location, Nama Poli
        $encounter->addDiagnosis($rjNo, 'J06.9'); // ID SATUSEHAT Condition, Kode ICD10
        // $encounter = $encounter->json();
        dd($encounter);
    }


    // resert input private////////////////
    private function resetInputFields(): void
    {
        $this->reset([
            'name',
            'province_id',

            'isOpen',
            'tampilIsOpen',
            'isOpenMode'
        ]);
    }




    // open and close modal start////////////////
    private function openModal(): void
    {
        $this->resetInputFields();
        $this->isOpen = true;
        $this->isOpenMode = 'insert';
    }
    private function openModalEdit(): void
    {
        $this->resetInputFields();
        $this->isOpen = true;
        $this->isOpenMode = 'update';
    }

    private function openModalTampil(): void
    {
        $this->resetInputFields();
        $this->isOpen = true;
        $this->isOpenMode = 'tampil';
    }

    public function closeModal(): void
    {
        $this->resetInputFields();
    }
    // open and close modal end////////////////




    // setLimitPerpage////////////////
    public function setLimitPerPage($value)
    {
        $this->limitPerPage = $value;
    }




    // resert page pagination when coloumn search change ////////////////
    public function updatedSearch(): void
    {
        // updatedhfisLovSearch->run
        $this->hfisLovSearch = $this->search;
        $this->updatedHfislovsearch();
    }




    // logic ordering record (shotby)////////////////
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }



    // is going to insert data////////////////
    public function create()
    {
        $this->openModal();
    }



    // insert record start////////////////
    public function store()
    {

        $customErrorMessages = [
            'name.required' => 'Nama tidak boleh kosong',
            'province_id.required' => 'Kode tidak boleh kosong'
        ];

        $this->validate([
            'name' => 'required',
            'province_id' => 'required'
        ], $customErrorMessages);

        Province::updateOrCreate(['id' => $this->province_id], [
            'name' => $this->name
        ]);


        $this->closeModal();
        $this->resetInputFields();
        $this->emit('toastr-success', "Data " . $this->name . " berhasil disimpan.");
    }
    // insert record end////////////////



    // Find data from table start////////////////
    private function findData($value)
    {
        $findData = Province::findOrFail($value);
        return $findData;
    }
    // Find data from table end////////////////



    // show edit record start////////////////
    public function edit($id)
    {
        $this->openModalEdit();

        $province = $this->findData($id);
        $this->province_id = $id;
        $this->name = $province->name;
    }
    // show edit record end////////////////



    // tampil record start////////////////
    public function tampil($id)
    {
        $this->openModalTampil();

        $province = $this->findData($id);
        $this->province_id = $id;
        $this->name = $province->name;
    }
    // tampil record end////////////////



    // delete record start////////////////
    public function delete($id, $name)
    {
        Province::find($id)->delete();
        $this->emit('toastr-success', "Hapus data " . $name . " berhasil.");
    }
    // delete record end////////////////

    // /////////LOV////////////
    // /////////hfis////////////
    // klik tdak dipakek
    // public function clickhfislov()
    // {
    //     $this->hfisLovStatus = true;
    //     $this->hfisLov = $this->dataPasien['pasien']['hfis']['hfisOptions'];
    // }
    public function updatedHfislovsearch()
    {
        // Variable Search
        $search = $this->hfisLovSearch;

        $this->hfisLovStatus = true;

        // if there is no id found and check (min 3 char on search)
        if (strlen($search) < 3) {
            $this->hfisLov = [];
        } else {

            // Variable Search Get data BPJS
            $HttpGetBpjs =  VclaimTrait::ref_poliklinik($search)->getOriginalContent();

            if ($HttpGetBpjs['metadata']['code'] == 200) {
                $this->hfisLov = $HttpGetBpjs['response']['poli'];
                $this->emit('toastr-success', $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
            } else {
                $this->hfisLov = [];
                $this->emit('toastr-error', $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
            }
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMyhfisLov($id, $name)
    {

        // Variable Search Get data BPJS
        $dateRef = Carbon::createFromFormat('d/m/Y', $this->dateRef)->format('Y-m-d');
        $HttpGetBpjs =  AntrianTrait::ref_jadwal_dokter($id, $dateRef)->getOriginalContent();

        // Variable Search Get data BPJS
        if ($HttpGetBpjs['metadata']['code'] == 200) {
            $this->jadwal_dokter = $HttpGetBpjs['response'];
            // dd($this->jadwal_dokter);

            $this->emit('toastr-success', $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        } else {
            $this->jadwal_dokter = [];
            $this->emit('toastr-error', $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        }


        $this->hfisLovStatus = false;
        // $this->hfisLovSearch = '';
    }
    // LOV selected end
    // /////////////////////



    public function updateJadwalRS($poliIdBPJS, $drIdBPJS, $dayId, $jamPraktek, $kuota)
    {
        // cek poli
        $kdPoliBpjsSyncRs = DB::table('rsmst_polis')->where('kd_poli_bpjs',  $poliIdBPJS ? $poliIdBPJS : '')->first();

        if (!$kdPoliBpjsSyncRs) {
            dd("Poli tidak ditemukan / Data Dokter belum di syncronuze");
        }

        // cek dokter
        $kdDrBpjsSyncRs = DB::table('rsmst_doctors')->where('kd_dr_bpjs',  $drIdBPJS ? $drIdBPJS : '')->first();

        if (!$kdDrBpjsSyncRs) {
            dd("Dokter tidak ditemukan / Data Dokter belum di syncronuze");
        }

        // cek dayId
        $kd_hari_bpjs = DB::table('scmst_scdays')->where('day_id',  $dayId ? $dayId : '')->first();

        if (!$kd_hari_bpjs) {
            dd("Kode Hari Tidak ditemukan");
        }

        if (!$kuota) {
            dd("Kuota Tidak Tersedia");
        }

        if (!$jamPraktek) {
            dd("Jam Praktek Tidak Tersedia");
        }

        $jammulai   = substr($jamPraktek, 0, 5);
        $jamselesai = substr($jamPraktek, 6, 5);

        // shift
        $findShift = DB::table('rstxn_shiftctls')
            ->select('shift')
            ->whereRaw("'" . Carbon::createFromFormat('H:i', $jammulai)->format('H:i:s') . "' between
            shift_start and shift_end")
            ->first();

        if (!$findShift) {
            dd("Shift Invalid");
        }

        // cek jadwal RS
        $jadwalRS = DB::table('scmst_scpolis')
            ->where('day_id',  $dayId ? $dayId : '')
            ->where('poli_id',  $kdPoliBpjsSyncRs->poli_id ? $kdPoliBpjsSyncRs->poli_id : '')
            ->where('dr_id',  $kdDrBpjsSyncRs->dr_id ? $kdDrBpjsSyncRs->dr_id : '')
            ->where('sc_poli_ket', $jamPraktek)
            ->first();

        if (!$jadwalRS) {
            // insert
            DB::table('scmst_scpolis')->insert([
                'sc_poli_status_' => '1',
                'sc_poli_ket' => $jamPraktek,
                'day_id' => $dayId,
                'poli_id' => $kdPoliBpjsSyncRs->poli_id,
                'dr_id' => $kdDrBpjsSyncRs->dr_id,
                'shift' => $findShift->shift,
                'mulai_praktek' => $jammulai . ':00',
                'pelayanan_perp_asien' => '',
                'no_urut' => '1',
                'kuota' => $kuota,
                'selesai_praktek' => $jamselesai . ':00',
            ]);
            $this->emit('toastr-success', 'Insert OK');
        } else {
            // update
            DB::table('scmst_scpolis')
                ->where('day_id',  $dayId ? $dayId : '')
                ->where('poli_id',  $kdPoliBpjsSyncRs->poli_id ? $kdPoliBpjsSyncRs->poli_id : '')
                ->where('dr_id',  $kdDrBpjsSyncRs->dr_id ? $kdDrBpjsSyncRs->dr_id : '')
                ->where('sc_poli_ket', $jamPraktek)

                ->update([
                    'sc_poli_status_' => '1',
                    'sc_poli_ket' => $jamPraktek,
                    'day_id' => $dayId,
                    'poli_id' => $kdPoliBpjsSyncRs->poli_id,
                    'dr_id' => $kdDrBpjsSyncRs->dr_id,
                    'shift' => $findShift->shift,
                    'mulai_praktek' => $jammulai . ':00',
                    'pelayanan_perp_asien' => '',
                    'no_urut' => '1',
                    'kuota' => $kuota,
                    'selesai_praktek' => $jamselesai . ':00',
                ]);
            $this->emit('toastr-success', 'Update OK');
        }
    }


    // when new form instance
    public function mount()
    {
        $this->dateRef = Carbon::now()->format('d/m/Y');
        $this->jadwal_dokter = [];
    }



    // select data start////////////////
    public function render()
    {
        return view(
            'livewire.setup-hfis-bpjs.setup-hfis-bpjs',
            [
                'hfis' => [],
                'myTitle' => 'HFIS BPJS',
                'mySnipt' => 'Data HFIS BPJS',
                'myProgram' => 'HFIS BPJS',
                'myLimitPerPages' => [5, 10, 15, 20, 100]
            ]
        );
    }
    // select data end////////////////
}
