<?php

namespace App\Http\Livewire\MrRJ\Diagnosis;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\BPJS\AntrianTrait;
use App\Http\Traits\BPJS\VclaimTrait;


use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;


class Diagnosis extends Component
{
    use WithPagination;


    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef = '430269';



    // dataDaftarPoliRJ RJ
    public $dataDaftarPoliRJ = [];

    // data SKDP / kontrol=>[] 
    public $diagnosis = [];
    public $procedure = [];
    //////////////////////////////////////////////////////////////////////


    //  table LOV////////////////

    public $dataDiagnosaICD10Lov = [];
    public $dataDiagnosaICD10LovStatus = 0;
    public $dataDiagnosaICD10LovSearch = '';

    public $dataProcedureICD9CmLov = [];
    public $dataProcedureICD9CmLovStatus = 0;
    public $dataProcedureICD9CmLovSearch = '';



    // listener from blade////////////////
    protected $listeners = [
        'xxxxx' => 'xxxxx',
    ];



    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////





    // resert input private////////////////
    private function resetInputFields(): void
    {

        // resert validation
        $this->resetValidation();
        // resert input kecuali
        $this->resetExcept([
            'rjNoRef'
        ]);
    }





    // ////////////////
    // RJ Logic
    // ////////////////

    //////////////////////////////////////////////
    // updated when change Record ////////////////
    ///////////////////////////////////////////////



    //////////////////////////////////////////////
    // updated when change Record ////////////////
    ///////////////////////////////////////////////

    /////////////////////////////////////////////////
    // Lov dataDiagnosaICD10SEP //////////////////////
    ////////////////////////////////////////////////
    public function clickdataDiagnosaICD10lov()
    {
        $this->dataDiagnosaICD10LovStatus = true;
        $this->dataDiagnosaICD10Lov = [];
    }

    public function updateddataDiagnosaICD10lovsearch()
    {
        // Variable Search
        $search = $this->dataDiagnosaICD10LovSearch;

        // check LOV by dr_id rs id 
        $dataDiagnosaICD10 = DB::table('rsmst_mstdiags')->select(
            'diag_id',
            'diag_desc',
            'icdx',
        )
            ->where('diag_id', $search)
            ->first();

        if ($dataDiagnosaICD10) {

            // set dokter sep
            $this->addDiagICD10($dataDiagnosaICD10->diag_id, $dataDiagnosaICD10->diag_desc, $dataDiagnosaICD10->icdx);


            $this->dataDiagnosaICD10LovStatus = false;
            $this->dataDiagnosaICD10LovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->dataDiagnosaICD10Lov = [];
            } else {
                $this->dataDiagnosaICD10Lov = json_decode(
                    DB::table('rsmst_mstdiags')->select(
                        'diag_id',
                        'diag_desc',
                        'icdx',
                    )

                        ->Where(DB::raw('upper(diag_desc)'), 'like', '%' . strtoupper($search) . '%')
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
    public function setMydataDiagnosaICD10Lov($id, $name)
    {
        $dataDiagnosaICD10 = DB::table('rsmst_mstdiags')->select(
            'diag_id',
            'diag_desc',
            'icdx',
        )
            ->where('diag_id', $id)
            ->first();

        // set dokter sep
        $this->addDiagICD10($dataDiagnosaICD10->diag_id, $dataDiagnosaICD10->diag_desc, $dataDiagnosaICD10->icdx);



        $this->dataDiagnosaICD10LovStatus = false;
        $this->dataDiagnosaICD10LovSearch = '';
    }
    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataDiagnosaRJ //////////////////////
    ////////////////////////////////////////////////







    /////////////////////////////////////////////////
    // Lov dataProcedureICD9CmSEP //////////////////////
    ////////////////////////////////////////////////
    public function clickdataProcedureICD9Cmlov()
    {
        $this->dataProcedureICD9CmLovStatus = true;
        $this->dataProcedureICD9CmLov = [];
    }

    public function updateddataProcedureICD9Cmlovsearch()
    {
        // Variable Search
        $search = $this->dataProcedureICD9CmLovSearch;

        // check LOV by dr_id rs id 
        $dataProcedureICD9Cm = DB::table('rsmst_mstprocedures')->select(
            'proc_id',
            'proc_desc',
        )
            ->where('proc_id', $search)
            ->first();

        if ($dataProcedureICD9Cm) {

            // set dokter sep
            $this->addProcedureICD9Cm($dataProcedureICD9Cm->proc_id, $dataProcedureICD9Cm->proc_desc);


            $this->dataProcedureICD9CmLovStatus = false;
            $this->dataProcedureICD9CmLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->dataProcedureICD9CmLov = [];
            } else {
                $this->dataProcedureICD9CmLov = json_decode(
                    DB::table('rsmst_mstprocedures')->select(
                        'proc_id',
                        'proc_desc',
                    )

                        ->Where(DB::raw('upper(proc_desc)'), 'like', '%' . strtoupper($search) . '%')
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
    public function setMydataProcedureICD9CmLov($id, $name)
    {
        $dataProcedureICD9Cm = DB::table('rsmst_mstprocedures')->select(
            'proc_id',
            'proc_desc',
        )
            ->where('proc_id', $id)
            ->first();

        // set dokter sep
        $this->addProcedureICD9Cm($dataProcedureICD9Cm->proc_id, $dataProcedureICD9Cm->proc_desc);



        $this->dataProcedureICD9CmLovStatus = false;
        $this->dataProcedureICD9CmLovSearch = '';
    }
    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataDiagnosaRJ //////////////////////
    ////////////////////////////////////////////////



    // validate Data RJ//////////////////////////////////////////////////
    private function validateDataRJ(): void
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // require nik ketika pasien tidak dikenal



        $rules = [
            "dataDaftarPoliRJ.diagnosis" => "",
        ];



        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $this->emit('toastr-error', "Lakukan Pengecekan kembali Input Data.");
            $this->validate($rules, $messages);
        }
    }


    // insert and update record start////////////////
    public function store()
    {
        // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
        $this->setDataPrimer();

        // Validate RJ
        $this->validateDataRJ();

        // Logic update mode start //////////
        $this->updateDataRJ($this->dataDaftarPoliRJ['rjNo']);
    }

    private function updateDataRJ($rjNo): void
    {

        // update table trnsaksi
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'datadaftarpolirj_json' => json_encode($this->dataDaftarPoliRJ, true),
                'datadaftarpolirj_xml' => ArrayToXml::convert($this->dataDaftarPoliRJ),
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


        if ($findData->datadaftarpolirj_json) {
            $this->dataDaftarPoliRJ = json_decode($findData->datadaftarpolirj_json, true);

            // jika diagnosis tidak ditemukan tambah variable diagnosis pda array
            if (isset($this->dataDaftarPoliRJ['diagnosis']) == false) {
                $this->dataDaftarPoliRJ['diagnosis'] = $this->diagnosis;
            }
            if (isset($this->dataDaftarPoliRJ['procedure']) == false) {
                $this->dataDaftarPoliRJ['procedure'] = $this->procedure;
            }
        } else {

            $this->emit('toastr-error', "Json Tidak ditemukan, Data sedang diproses ulang.");
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
                "regNo" => "" . $dataDaftarPoliRJ->reg_no . "",

                "drId" => "" . $dataDaftarPoliRJ->dr_id . "",
                "drDesc" => "" . $dataDaftarPoliRJ->dr_name . "",

                "poliId" => "" . $dataDaftarPoliRJ->poli_id . "",
                "poliDesc" => "" . $dataDaftarPoliRJ->poli_desc . "",

                "kddrbpjs" => "" . $dataDaftarPoliRJ->kd_dr_bpjs . "",
                "kdpolibpjs" => "" . $dataDaftarPoliRJ->kd_poli_bpjs . "",

                "rjDate" => "" . $dataDaftarPoliRJ->rj_date . "",
                "rjNo" => "" . $dataDaftarPoliRJ->rj_no . "",
                "shift" => "" . $dataDaftarPoliRJ->shift . "",
                "noAntrian" => "" . $dataDaftarPoliRJ->no_antrian . "",
                "noBooking" => "" . $dataDaftarPoliRJ->nobooking . "",
                "slCodeFrom" => "02",
                "passStatus" => "",
                "rjStatus" => "" . $dataDaftarPoliRJ->rj_status . "",
                "txnStatus" => "" . $dataDaftarPoliRJ->txn_status . "",
                "ermStatus" => "" . $dataDaftarPoliRJ->erm_status . "",
                "cekLab" => "0",
                "kunjunganInternalStatus" => "0",
                "noReferensi" => "" . $dataDaftarPoliRJ->reg_no . "",
                "taskIdPelayanan" => [
                    "taskId1" => "",
                    "taskId2" => "",
                    "taskId3" => "" . $dataDaftarPoliRJ->rj_date . "",
                    "taskId4" => "",
                    "taskId5" => "",
                    "taskId6" => "",
                    "taskId7" => "",
                    "taskId99" => "",
                ],
                'sep' => [
                    "noSep" => "" . $dataDaftarPoliRJ->vno_sep . "",
                    "reqSep" => [],
                    "resSep" => [],
                ]
            ];

            $this->dataDaftarPoliRJ['klaimId'] = $dataDaftarPoliRJ->klaim_id == 'JM' ? 'JM' : 'UM';
            $this->dataDaftarPoliRJ['JenisKlaimDesc'] = $dataDaftarPoliRJ->klaim_id == 'JM' ? 'BPJS' : 'UMUM';

            $this->dataDaftarPoliRJ['kunjunganId'] = '1';
            $this->dataDaftarPoliRJ['JenisKunjunganDesc'] = 'Rujukan FKTP';


            // jika diagnosis tidak ditemukan tambah variable diagnosis pda array
            if (isset($this->dataDaftarPoliRJ['diagnosis']) == false) {
                $this->dataDaftarPoliRJ['diagnosis'] = $this->diagnosis;
            }
            if (isset($this->dataDaftarPoliRJ['procedure']) == false) {
                $this->dataDaftarPoliRJ['procedure'] = $this->procedure;
            }
        }
    }

    private function setDataPrimer(): void
    {
    }

    private function addDiagICD10($diagId, $diagDesc, $icdX): void
    {
        $checkDiagnosaCount = collect($this->dataDaftarPoliRJ['diagnosis'])->count();
        $kategoriDiagnosa = $checkDiagnosaCount ? 'Secondary' : 'Primary';

        $this->dataDaftarPoliRJ['diagnosis'][] = ['diagId' => $diagId, 'diagDesc' => $diagDesc, 'icdX' => $icdX, 'ketdiagnosa' => 'Keterangan Diagnosa', 'kategoriDiagnosa' => $kategoriDiagnosa];
    }

    public function removeDiagICD10($diagId)
    {

        $diagnosis = collect($this->dataDaftarPoliRJ['diagnosis'])->where("diagId", '!=', $diagId)->toArray();
        $this->dataDaftarPoliRJ['diagnosis'] = $diagnosis;
    }





    private function addProcedureICD9Cm($procedureId, $procedureDesc): void
    {
        $checkProcedurenosaCount = collect($this->dataDaftarPoliRJ['procedure'])->count();

        $this->dataDaftarPoliRJ['procedure'][] = ['procedureId' => $procedureId, 'procedureDesc' => $procedureDesc, 'ketProcedure' => 'Keterangan Procedure'];
    }

    public function removeProcedureICD9Cm($procedureId)
    {

        $procedure = collect($this->dataDaftarPoliRJ['procedure'])->where("procedureId", '!=', $procedureId)->toArray();
        $this->dataDaftarPoliRJ['procedure'] = $procedure;
    }




    // when new form instance
    public function mount()
    {
        $this->findData($this->rjNoRef);
        // set data dokter ref
        // $this->store();
    }



    // select data start////////////////
    public function render()
    {

        return view(
            'livewire.mr-r-j.diagnosis.diagnosis',
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
