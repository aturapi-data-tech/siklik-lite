<?php

namespace App\Http\Livewire\EmrRJ\MrRJ\Diagnosis;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;

use App\Http\Traits\customErrorMessagesTrait;

use Spatie\ArrayToXml\ArrayToXml;
use Exception;


class Diagnosis extends Component
{
    use WithPagination;


    // listener from blade////////////////
    protected $listeners = [
        'syncronizeAssessmentPerawatRJFindData' => 'mount'
    ];


    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef;



    // dataDaftarPoliRJ RJ
    public array $dataDaftarPoliRJ = [];

    // data SKDP / kontrol=>[]
    public array $diagnosis = [];
    public array $procedure = [];
    //////////////////////////////////////////////////////////////////////


    //  table LOV////////////////

    public $dataDiagnosaICD10Lov = [];
    public $dataDiagnosaICD10LovStatus = 0;
    public $dataDiagnosaICD10LovSearch = '';
    public $selecteddataDiagnosaICD10LovIndex = 0;
    public $collectingMyDiagnosaICD10 = [];

    public $dataProcedureICD9CmLov = [];
    public $dataProcedureICD9CmLovStatus = 0;
    public $dataProcedureICD9CmLovSearch = '';
    public $selecteddataProcedureICD9CmLovIndex = 0;
    public $collectingMyProcedureICD9Cm = [];






    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////



    // ////////////////
    // RJ Logic
    // ////////////////

    /////////////////////////////////////////////////
    // Lov dataDiagnosaICD10Lov //////////////////////
    ////////////////////////////////////////////////
    public function clickdataDiagnosaICD10Lov()
    {
        $this->dataDiagnosaICD10LovStatus = true;
        $this->dataDiagnosaICD10Lov = [];
    }

    public function updateddataDiagnosaICD10Lovsearch()
    {

        // Reset index of LoV
        $this->reset(['selecteddataDiagnosaICD10LovIndex', 'dataDiagnosaICD10Lov']);
        // Variable Search
        $search = $this->dataDiagnosaICD10LovSearch;

        // check LOV by dr_id rs id
        $dataDiagnosaICD10Lovs = DB::table('rsmst_mstdiags ')->select(
            'diag_id',
            'diag_desc',
            'icdx'
        )
            ->where('icdx', $search)
            // ->where('active_status', '1')
            ->first();

        if ($dataDiagnosaICD10Lovs) {

            // set DiagnosaICD10 sep
            $this->addDiagnosaICD10($dataDiagnosaICD10Lovs->diag_id, $dataDiagnosaICD10Lovs->diag_desc, $dataDiagnosaICD10Lovs->icdx);
            $this->resetdataDiagnosaICD10Lov();
        } else {

            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 1) {
                $this->dataDiagnosaICD10Lov = [];
            } else {
                $this->dataDiagnosaICD10Lov = json_decode(
                    DB::table('rsmst_mstdiags')->select(
                        'diag_id',
                        'diag_desc',
                        'icdx'
                    )
                        // ->where('active_status', '1')
                        ->Where(DB::raw('upper(diag_desc)'), 'like', '%' . strtoupper($search) . '%')
                        ->orWhere(DB::raw('upper(diag_id)'), 'like', '%' . strtoupper($search) . '%')
                        ->orWhere(DB::raw('upper(icdx)'), 'like', '%' . strtoupper($search) . '%')
                        ->limit(10)
                        ->orderBy('diag_id', 'ASC')
                        ->orderBy('diag_desc', 'ASC')
                        ->get(),
                    true
                );
            }
            $this->dataDiagnosaICD10LovStatus = true;
            // set doing nothing
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataDiagnosaICD10Lov($id)
    {
        // $this->checkRjStatus();
        $dataDiagnosaICD10Lovs = DB::table('rsmst_mstdiags')->select(
            'diag_id',
            'diag_desc',
            'icdx'
        )
            // ->where('active_status', '1')
            ->where('diag_id', $this->dataDiagnosaICD10Lov[$id]['diag_id'])
            ->first();

        // set dokter sep
        $this->addDiagnosaICD10($dataDiagnosaICD10Lovs->diag_id, $dataDiagnosaICD10Lovs->diag_desc, $dataDiagnosaICD10Lovs->icdx);
        $this->resetdataDiagnosaICD10Lov();
    }

    public function resetdataDiagnosaICD10Lov()
    {
        $this->reset(['dataDiagnosaICD10Lov', 'dataDiagnosaICD10LovStatus', 'dataDiagnosaICD10LovSearch', 'selecteddataDiagnosaICD10LovIndex']);
    }

    public function selectNextdataDiagnosaICD10Lov()
    {
        if ($this->selecteddataDiagnosaICD10LovIndex === "") {
            $this->selecteddataDiagnosaICD10LovIndex = 0;
        } else {
            $this->selecteddataDiagnosaICD10LovIndex++;
        }

        if ($this->selecteddataDiagnosaICD10LovIndex === count($this->dataDiagnosaICD10Lov)) {
            $this->selecteddataDiagnosaICD10LovIndex = 0;
        }
    }

    public function selectPreviousdataDiagnosaICD10Lov()
    {

        if ($this->selecteddataDiagnosaICD10LovIndex === "") {
            $this->selecteddataDiagnosaICD10LovIndex = count($this->dataDiagnosaICD10Lov) - 1;
        } else {
            $this->selecteddataDiagnosaICD10LovIndex--;
        }

        if ($this->selecteddataDiagnosaICD10LovIndex === -1) {
            $this->selecteddataDiagnosaICD10LovIndex = count($this->dataDiagnosaICD10Lov) - 1;
        }
    }

    public function enterMydataDiagnosaICD10Lov($id)
    {
        // $this->checkRjStatus();
        // jika JK belum siap maka toaster error
        if (isset($this->dataDiagnosaICD10Lov[$id]['diag_id'])) {
            $this->addDiagnosaICD10($this->dataDiagnosaICD10Lov[$id]['diag_id'], $this->dataDiagnosaICD10Lov[$id]['diag_desc'], $this->dataDiagnosaICD10Lov[$id]['icdx']);
            $this->resetdataDiagnosaICD10Lov();
        } else {
            $this->emit('toastr-error', "Kode Diagnosa belum tersedia.");
        }
    }


    private function addDiagnosaICD10($DiagnosaICD10Id, $DiagnosaICD10Desc, $icdx): void
    {
        $this->collectingMyDiagnosaICD10 = [
            'DiagnosaICD10Id' => $DiagnosaICD10Id,
            'DiagnosaICD10Desc' => $DiagnosaICD10Desc,
            'DiagnosaICD10icdx' => $icdx,
        ];

        $this->insertDiagnosaICD10();
    }

    private function insertDiagnosaICD10(): void
    {

        // validate
        // $this->checkRjStatus();
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();
        // require nik ketika pasien tidak dikenal
        $rules = [
            "collectingMyDiagnosaICD10.DiagnosaICD10Id" => 'bail|required|exists:rsmst_mstdiags,diag_id',
            "collectingMyDiagnosaICD10.DiagnosaICD10Desc" => 'bail|required|',
            "collectingMyDiagnosaICD10.DiagnosaICD10icdx" => 'bail|required|',

        ];

        // Proses Validasi///////////////////////////////////////////
        $this->validate($rules, $messages);

        // validate


        // pengganti race condition
        // start:
        try {

            $lastInserted = DB::table('rstxn_rjdtls')
                ->select(DB::raw("nvl(max(rjdtl_dtl)+1,1) as rjdtl_dtl_max"))
                ->first();
            // insert into table transaksi
            DB::table('rstxn_rjdtls')
                ->insert([
                    'rjdtl_dtl' => $lastInserted->rjdtl_dtl_max,
                    'rj_no' => $this->rjNoRef,
                    'diag_id' => $this->collectingMyDiagnosaICD10['DiagnosaICD10Id'],
                ]);

            // update status diagnosa rstxn_rjhdrs
            DB::table('rstxn_rjhdrs')
                ->where('rj_no',  $this->rjNoRef)
                ->update([
                    'rj_diagnosa' => 'D',
                ]);

            $checkDiagnosaCount = collect($this->dataDaftarPoliRJ['diagnosis'])->count();
            $kategoriDiagnosa = $checkDiagnosaCount ? 'Secondary' : 'Primary';

            $this->dataDaftarPoliRJ['diagnosis'][] = [
                'diagId' => $this->collectingMyDiagnosaICD10['DiagnosaICD10Id'],
                'diagDesc' => $this->collectingMyDiagnosaICD10['DiagnosaICD10Desc'],
                'icdX' => $this->collectingMyDiagnosaICD10['DiagnosaICD10icdx'],
                'ketdiagnosa' => 'Keterangan Diagnosa',
                'kategoriDiagnosa' => $kategoriDiagnosa,
                'rjDtlDtl' => $lastInserted->rjdtl_dtl_max,
                'rjNo' => $this->rjNoRef,
            ];

            $this->store();
            $this->reset(['collectingMyDiagnosaICD10']);


            //
        } catch (Exception $e) {
            // display an error to user
            dd($e->getMessage());
        }
        // goto start;
    }

    public function removeDiagnosaICD10($rjDtlDtl)
    {

        // $this->checkRjStatus();


        // pengganti race condition
        // start:
        try {


            // remove into table transaksi
            DB::table('rstxn_rjdtls')
                ->where('rjdtl_dtl', $rjDtlDtl)
                ->delete();


            $DiagnosaICD10 = collect($this->dataDaftarPoliRJ['diagnosis'])->where("rjDtlDtl", '!=', $rjDtlDtl)->toArray();
            $this->dataDaftarPoliRJ['diagnosis'] = $DiagnosaICD10;


            $this->store();


            //
        } catch (Exception $e) {
            // display an error to user
            dd($e->getMessage());
        }
        // goto start;


    }
    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataDiagnosaICD10Lov //////////////////////
    ////////////////////////////////////////////////


    /////////////////////////////////////////////////
    // Lov dataProcedureICD9CmLov //////////////////////
    ////////////////////////////////////////////////
    public function clickdataProcedureICD9CmLov()
    {
        $this->dataProcedureICD9CmLovStatus = true;
        $this->dataProcedureICD9CmLov = [];
    }

    public function updateddataProcedureICD9CmLovsearch()
    {

        // Reset index of LoV
        $this->reset(['selecteddataProcedureICD9CmLovIndex', 'dataProcedureICD9CmLov']);
        // Variable Search
        $search = $this->dataProcedureICD9CmLovSearch;

        // check LOV by dr_id rs id
        $dataProcedureICD9CmLovs = DB::table('rsmst_mstprocedures ')->select(
            'proc_id',
            'proc_desc',

        )
            ->where('proc_id', $search)
            // ->where('active_status', '1')
            ->first();

        if ($dataProcedureICD9CmLovs) {

            // set ProcedureICD9Cm sep
            $this->addProcedureICD9Cm($dataProcedureICD9CmLovs->proc_id, $dataProcedureICD9CmLovs->proc_desc);
            $this->resetdataProcedureICD9CmLov();
        } else {

            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 1) {
                $this->dataProcedureICD9CmLov = [];
            } else {
                $this->dataProcedureICD9CmLov = json_decode(
                    DB::table('rsmst_mstprocedures')->select(
                        'proc_id',
                        'proc_desc',

                    )
                        // ->where('active_status', '1')
                        ->Where(DB::raw('upper(proc_desc)'), 'like', '%' . strtoupper($search) . '%')
                        ->orWhere(DB::raw('upper(proc_id)'), 'like', '%' . strtoupper($search) . '%')
                        ->limit(10)
                        ->orderBy('proc_id', 'ASC')
                        ->orderBy('proc_desc', 'ASC')
                        ->get(),
                    true
                );
            }
            $this->dataProcedureICD9CmLovStatus = true;
            // set doing nothing
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataProcedureICD9CmLov($id)
    {
        // $this->checkRjStatus();
        $dataProcedureICD9CmLovs = DB::table('rsmst_mstprocedures')->select(
            'proc_id',
            'proc_desc',

        )
            // ->where('active_status', '1')
            ->where('proc_id', $this->dataProcedureICD9CmLov[$id]['proc_id'])
            ->first();

        // set dokter sep
        $this->addProcedureICD9Cm($dataProcedureICD9CmLovs->proc_id, $dataProcedureICD9CmLovs->proc_desc);
        $this->resetdataProcedureICD9CmLov();
    }

    public function resetdataProcedureICD9CmLov()
    {
        $this->reset(['dataProcedureICD9CmLov', 'dataProcedureICD9CmLovStatus', 'dataProcedureICD9CmLovSearch', 'selecteddataProcedureICD9CmLovIndex']);
    }

    public function selectNextdataProcedureICD9CmLov()
    {
        if ($this->selecteddataProcedureICD9CmLovIndex === "") {
            $this->selecteddataProcedureICD9CmLovIndex = 0;
        } else {
            $this->selecteddataProcedureICD9CmLovIndex++;
        }

        if ($this->selecteddataProcedureICD9CmLovIndex === count($this->dataProcedureICD9CmLov)) {
            $this->selecteddataProcedureICD9CmLovIndex = 0;
        }
    }

    public function selectPreviousdataProcedureICD9CmLov()
    {

        if ($this->selecteddataProcedureICD9CmLovIndex === "") {
            $this->selecteddataProcedureICD9CmLovIndex = count($this->dataProcedureICD9CmLov) - 1;
        } else {
            $this->selecteddataProcedureICD9CmLovIndex--;
        }

        if ($this->selecteddataProcedureICD9CmLovIndex === -1) {
            $this->selecteddataProcedureICD9CmLovIndex = count($this->dataProcedureICD9CmLov) - 1;
        }
    }

    public function enterMydataProcedureICD9CmLov($id)
    {
        // $this->checkRjStatus();
        // jika JK belum siap maka toaster error
        if (isset($this->dataProcedureICD9CmLov[$id]['proc_id'])) {
            $this->addProcedureICD9Cm($this->dataProcedureICD9CmLov[$id]['proc_id'], $this->dataProcedureICD9CmLov[$id]['proc_desc']);
            $this->resetdataProcedureICD9CmLov();
        } else {
            $this->emit('toastr-error', "Kode Diagnosa belum tersedia.");
        }
    }


    private function addProcedureICD9Cm($ProcedureICD9CmId, $ProcedureICD9CmDesc): void
    {
        $this->collectingMyProcedureICD9Cm = [
            'ProcedureICD9CmId' => $ProcedureICD9CmId,
            'ProcedureICD9CmDesc' => $ProcedureICD9CmDesc,
        ];

        $this->insertProcedureICD9Cm();
    }

    private function insertProcedureICD9Cm(): void
    {

        // validate
        // $this->checkRjStatus();
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();
        // require nik ketika pasien tidak dikenal
        $rules = [
            "collectingMyProcedureICD9Cm.ProcedureICD9CmId" => 'bail|required|exists:rsmst_mstprocedures,proc_id',
            "collectingMyProcedureICD9Cm.ProcedureICD9CmDesc" => 'bail|required|',
        ];

        // Proses Validasi///////////////////////////////////////////
        $this->validate($rules, $messages);

        // validate


        // pengganti race condition

        $this->dataDaftarPoliRJ['procedure'][] = [
            'procedureId' => $this->collectingMyProcedureICD9Cm['ProcedureICD9CmId'],
            'procedureDesc' => $this->collectingMyProcedureICD9Cm['ProcedureICD9CmDesc'],
            'ketProcedure' => 'Keterangan Procedure',
            'rjNo' => $this->rjNoRef,
        ];

        $this->store();
        $this->reset(['collectingMyProcedureICD9Cm']);


        //

        // goto start;
    }

    public function removeProcedureICD9Cm($procedureId)
    {

        // $this->checkRjStatus();

        $ProcedureICD9Cm = collect($this->dataDaftarPoliRJ['procedure'])->where("procedureId", '!=', $procedureId)->toArray();
        $this->dataDaftarPoliRJ['procedure'] = $ProcedureICD9Cm;
        $this->store();
    }
    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataProcedureICD9CmLov //////////////////////
    ////////////////////////////////////////////////


    // insert and update record start////////////////
    public function store()
    {
        // Logic update mode start //////////
        $this->updateDataRJ($this->dataDaftarPoliRJ['rjNo']);
        $this->emit('syncronizeAssessmentPerawatRJFindData');
    }

    private function updateDataRJ($rjNo): void
    {

        // update table trnsaksi
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'dataDaftarPoliRJ_json' => json_encode($this->dataDaftarPoliRJ, true),
                'dataDaftarPoliRJ_xml' => ArrayToXml::convert($this->dataDaftarPoliRJ),
            ]);

        $this->emit('toastr-success', "Diagnosa berhasil disimpan.");
    }
    // insert and update record end////////////////


    private function findData($rjno): void
    {


        $findData = DB::table('rsview_rjkasir')
            ->select('datadaftarpolirj_json', 'vno_sep')
            ->where('rj_no', $rjno)
            ->first();

        $dataDaftarPoliRJ_json = isset($findData->datadaftarpolirj_json) ? $findData->datadaftarpolirj_json   : null;
        // if meta_data_pasien_json = null
        // then cari Data Pasien By Key Collection (exception when no data found)
        //
        // else json_decode
        if ($dataDaftarPoliRJ_json) {
            $this->dataDaftarPoliRJ = json_decode($findData->datadaftarpolirj_json, true);

            // jika diagnosis tidak ditemukan tambah variable diagnosis pda array
            if (isset($this->dataDaftarPoliRJ['diagnosis']) == false) {
                $this->dataDaftarPoliRJ['diagnosis'] = $this->diagnosis;
            }

            // jika procedure tidak ditemukan tambah variable procedure pda array
            if (isset($this->dataDaftarPoliRJ['procedure']) == false) {
                $this->dataDaftarPoliRJ['procedure'] = $this->procedure;
            }
        } else {

            $this->emit('toastr-error', "Data tidak dapat di proses json.");
            $dataDaftarPoliRJ = DB::table('rsview_rjkasir')
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
                    // 'entry_id',
                    'shift',
                    'vno_sep',
                    'no_antrian',

                    'nobooking',
                    'push_antrian_bpjs_status',
                    'push_antrian_bpjs_json',
                    'kd_dr_bpjs',
                    'kd_poli_bpjs',
                    'rj_status',
                    'txn_status',
                    'erm_status',
                )
                ->where('rj_no', '=', $rjno)
                ->first();

            $this->dataDaftarPoliRJ = [
                "regNo" =>  $dataDaftarPoliRJ->reg_no,

                "drId" =>  $dataDaftarPoliRJ->dr_id,
                "drDesc" =>  $dataDaftarPoliRJ->dr_name,

                "poliId" =>  $dataDaftarPoliRJ->poli_id,
                "klaimId" => $dataDaftarPoliRJ->klaim_id,
                // "poliDesc" =>  $dataDaftarPoliRJ->poli_desc ,

                // "kddrbpjs" =>  $dataDaftarPoliRJ->kd_dr_bpjs ,
                // "kdpolibpjs" =>  $dataDaftarPoliRJ->kd_poli_bpjs ,

                "rjDate" =>  $dataDaftarPoliRJ->rj_date,
                "rjNo" =>  $dataDaftarPoliRJ->rj_no,
                "shift" =>  $dataDaftarPoliRJ->shift,
                "noAntrian" =>  $dataDaftarPoliRJ->no_antrian,
                "noBooking" =>  $dataDaftarPoliRJ->nobooking,
                "slCodeFrom" => "02",
                "passStatus" => "",
                "rjStatus" =>  $dataDaftarPoliRJ->rj_status,
                "txnStatus" =>  $dataDaftarPoliRJ->txn_status,
                "ermStatus" =>  $dataDaftarPoliRJ->erm_status,
                "cekLab" => "0",
                "kunjunganInternalStatus" => "0",
                "noReferensi" =>  $dataDaftarPoliRJ->reg_no,
                "postInap" => [],
                "internal12" => "1",
                "internal12Desc" => "Faskes Tingkat 1",
                "internal12Options" => [
                    [
                        "internal12" => "1",
                        "internal12Desc" => "Faskes Tingkat 1"
                    ],
                    [
                        "internal12" => "2",
                        "internal12Desc" => "Faskes Tingkat 2 RS"
                    ]
                ],
                "kontrol12" => "1",
                "kontrol12Desc" => "Faskes Tingkat 1",
                "kontrol12Options" => [
                    [
                        "kontrol12" => "1",
                        "kontrol12Desc" => "Faskes Tingkat 1"
                    ],
                    [
                        "kontrol12" => "2",
                        "kontrol12Desc" => "Faskes Tingkat 2 RS"
                    ],
                ],
                "taskIdPelayanan" => [
                    "taskId1" => "",
                    "taskId2" => "",
                    "taskId3" =>  $dataDaftarPoliRJ->rj_date,
                    "taskId4" => "",
                    "taskId5" => "",
                    "taskId6" => "",
                    "taskId7" => "",
                    "taskId99" => "",
                ],
                'sep' => [
                    "noSep" =>  $dataDaftarPoliRJ->vno_sep,
                    "reqSep" => [],
                    "resSep" => [],
                ]
            ];


            // jika diagnosis tidak ditemukan tambah variable diagnosis pda array
            if (isset($this->dataDaftarPoliRJ['diagnosis']) == false) {
                $this->dataDaftarPoliRJ['diagnosis'] = $this->diagnosis;
            }
            // jika procedure tidak ditemukan tambah variable procedure pda array
            if (isset($this->dataDaftarPoliRJ['procedure']) == false) {
                $this->dataDaftarPoliRJ['procedure'] = $this->procedure;
            }
        }
    }


    private function setDataPrimer(): void
    {
    }



    // when new form instance
    public function mount()
    {
        $this->findData($this->rjNoRef);
    }



    // select data start////////////////
    public function render()
    {

        return view(
            'livewire.emr-r-j.mr-r-j.diagnosis.diagnosis',
            [
                // 'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Data Pasien Rawat Jalan',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'ICD 10',
            ]
        );
    }
    // select data end////////////////


}
