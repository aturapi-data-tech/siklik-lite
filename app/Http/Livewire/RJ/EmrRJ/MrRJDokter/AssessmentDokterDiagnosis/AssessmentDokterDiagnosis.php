<?php

namespace App\Http\Livewire\RJ\EmrRJ\MrRJDokter\AssessmentDokterDiagnosis;


use Livewire\Component;
use Livewire\WithPagination;

use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\EmrRJ\EmrRJTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\LockTimeoutException;




class AssessmentDokterDiagnosis extends Component
{
    use WithPagination, EmrRJTrait;


    // listener from blade////////////////
    protected $listeners = ['emr:rj:store' => 'store'];



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

    public function updatedDataDiagnosaICD10LovSearch()
    {

        // Reset index of LoV
        $this->reset(['selecteddataDiagnosaICD10LovIndex', 'dataDiagnosaICD10Lov']);
        // Variable Search
        $search = $this->dataDiagnosaICD10LovSearch;

        // check LOV by dr_id rs id
        $dataDiagnosaICD10Lovs = DB::table('rsmst_mstdiags')->select(
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
                        ->limit(100)
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
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Kode Diagnosa belum tersedia.');
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
        $messages = customErrorMessagesTrait::messages();
        $rules = [
            "collectingMyDiagnosaICD10.DiagnosaICD10Id"   => 'bail|required|exists:rsmst_mstdiags,diag_id',
            "collectingMyDiagnosaICD10.DiagnosaICD10Desc" => 'bail|required',
            "collectingMyDiagnosaICD10.DiagnosaICD10icdx" => 'bail|required',
        ];
        $this->validate($rules, $messages);

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {
                    // lock list + next detail
                    $last = DB::table('rstxn_rjdtls')
                        ->select(DB::raw("nvl(max(rjdtl_dtl)+1,1) as next_dtl"))
                        ->first();
                    // CEK DUPLIKASI
                    $dup = DB::table('rstxn_rjdtls')
                        ->where('rj_no', $rjNo)
                        ->where('diag_id', $this->collectingMyDiagnosaICD10['DiagnosaICD10Id'])
                        ->exists();

                    if ($dup) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Diagnosa sudah ada pada kunjungan ini.');
                        return; // batalkan transaksi
                    }

                    $nextDtl = (int)($last->next_dtl ?? 1);

                    try {
                        DB::table('rstxn_rjdtls')->insert([
                            'rjdtl_dtl' => $nextDtl,
                            'rj_no'     => $rjNo,
                            'diag_id'   => $this->collectingMyDiagnosaICD10['DiagnosaICD10Id'],
                        ]);
                    } catch (\Illuminate\Database\QueryException $e) {
                        // ini error SQL
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError("Gagal insert data RJDTL: " . $e->getMessage());
                        return;
                    } catch (\Exception $e) {
                        // error non-SQL (misalnya koneksi putus)
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError("Terjadi kesalahan: " . $e->getMessage());
                        return;
                    }

                    // flag diagnosa di header (bila perlu)
                    DB::table('rstxn_rjhdrs')->where('rj_no', $rjNo)->update(['rj_diagnosa' => 'D']);

                    // fresh JSON dari DB lalu patch subtree diagnosis
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!isset($fresh['diagnosis']) || !is_array($fresh['diagnosis'])) $fresh['diagnosis'] = [];

                    $kategori = collect($fresh['diagnosis'])->count() ? 'Secondary' : 'Primary';

                    $fresh['diagnosis'][] = [
                        'diagId'         => $this->collectingMyDiagnosaICD10['DiagnosaICD10Id'],
                        'diagDesc'       => $this->collectingMyDiagnosaICD10['DiagnosaICD10Desc'],
                        'icdX'           => $this->collectingMyDiagnosaICD10['DiagnosaICD10icdx'],
                        'ketdiagnosa'    => 'Keterangan Diagnosa',
                        'kategoriDiagnosa' => $kategori,
                        'rjDtlDtl'       => $nextDtl,
                        'rjNo'           => $rjNo,
                    ];

                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarPoliRJ = $fresh;
                    $this->reset(['collectingMyDiagnosaICD10']);
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Diagnosa berhasil ditambahkan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Lock timeout. Coba lagi.');
        } catch (\Throwable $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal menambah diagnosa.');
        }
    }

    public function removeDiagnosaICD10($rjDtlDtl): void
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo, $rjDtlDtl) {
                DB::transaction(function () use ($rjNo, $rjDtlDtl) {
                    DB::table('rstxn_rjdtls')
                        ->where('rj_no', $rjNo)
                        ->where('rjdtl_dtl', $rjDtlDtl)
                        ->delete();

                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    $fresh['diagnosis'] = collect($fresh['diagnosis'] ?? [])
                        ->where('rjDtlDtl', '!=', $rjDtlDtl)->values()->toArray();

                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarPoliRJ = $fresh;
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Diagnosa dihapus.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Lock timeout. Coba lagi.');
        }
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

    public function updatedDataProcedureICD9CmLovSearch()
    {

        // Reset index of LoV
        $this->reset(['selecteddataProcedureICD9CmLovIndex', 'dataProcedureICD9CmLov']);
        // Variable Search
        $search = $this->dataProcedureICD9CmLovSearch;

        // check LOV by dr_id rs id
        $dataProcedureICD9CmLovs = DB::table('rsmst_mstprocedures')->select(
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
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Kode Prosedur belum tersedia.');
            return;
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
        $messages = customErrorMessagesTrait::messages();
        $rules = [
            "collectingMyProcedureICD9Cm.ProcedureICD9CmId"   => 'bail|required|exists:rsmst_mstprocedures,proc_id',
            "collectingMyProcedureICD9Cm.ProcedureICD9CmDesc" => 'bail|required',
        ];
        $this->validate($rules, $messages);

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!isset($fresh['procedure']) || !is_array($fresh['procedure'])) $fresh['procedure'] = [];

                    $procId = $this->collectingMyProcedureICD9Cm['ProcedureICD9CmId'];

                    // CEK DUPLIKASI
                    $dup = collect($fresh['procedure'])->contains(function ($row) use ($procId) {
                        return ($row['procedureId'] ?? null) === $procId;
                    });
                    if ($dup) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Prosedur sudah ada pada kunjungan ini.');
                        return;
                    }

                    $fresh['procedure'][] = [
                        'procedureId'   => $procId,
                        'procedureDesc' => $this->collectingMyProcedureICD9Cm['ProcedureICD9CmDesc'],
                        'ketProcedure'  => 'Keterangan Procedure',
                        'rjNo'          => $rjNo,
                    ];

                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarPoliRJ = $fresh;
                    $this->reset(['collectingMyProcedureICD9Cm']);
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Prosedur berhasil ditambahkan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Lock timeout. Coba lagi.');
        }
    }

    public function removeProcedureICD9Cm($procedureId): void
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo, $procedureId) {
                DB::transaction(function () use ($rjNo, $procedureId) {
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    $fresh['procedure'] = collect($fresh['procedure'] ?? [])
                        ->where('procedureId', '!=', $procedureId)->values()->toArray();

                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarPoliRJ = $fresh;
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Prosedur dihapus.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Lock timeout. Coba lagi.');
        }
    }
    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataProcedureICD9CmLov //////////////////////
    ////////////////////////////////////////////////


    // insert and update record start////////////////
    public function store(): void
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        // (opsional) blokir bila RJ sudah pulang
        $status = DB::scalar("select rj_status from rstxn_rjhdrs where rj_no=:rjNo", ['rjNo' => $rjNo]);
        if ($status !== 'A') {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Pasien sudah pulang. Tidak bisa menyimpan diagnosis/procedure.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                $freshWrap = $this->findDataRJ($rjNo);
                $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                if (!is_array($fresh)) $fresh = [];

                // bootstrap
                if (!isset($fresh['diagnosis']) || !is_array($fresh['diagnosis'])) $fresh['diagnosis'] = [];
                if (!isset($fresh['procedure']) || !is_array($fresh['procedure'])) $fresh['procedure'] = [];

                // PATCH subtree dari state saat ini
                $fresh['diagnosis'] = $this->dataDaftarPoliRJ['diagnosis'] ?? [];
                $fresh['procedure'] = $this->dataDaftarPoliRJ['procedure'] ?? [];

                DB::transaction(function () use ($rjNo, $fresh) {
                    $this->updateJsonRJ($rjNo, $fresh); // single-writer
                });

                // sync komponen
                $this->dataDaftarPoliRJ = $fresh;
            });


            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Diagnosa/Prosedur berhasil disimpan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');
        }
    }

    // insert and update record end////////////////


    private function findData($rjno): void
    {
        $wrap = $this->findDataRJ($rjno);
        $this->dataDaftarPoliRJ = $wrap['dataDaftarRJ'] ?? [];

        if (!isset($this->dataDaftarPoliRJ['diagnosis']) || !is_array($this->dataDaftarPoliRJ['diagnosis'])) {
            $this->dataDaftarPoliRJ['diagnosis'] = [];
        }
        if (!isset($this->dataDaftarPoliRJ['procedure']) || !is_array($this->dataDaftarPoliRJ['procedure'])) {
            $this->dataDaftarPoliRJ['procedure'] = [];
        }
    }


    private function setDataPrimer(): void {}



    // when new form instance
    public function mount()
    {
        $this->findData($this->rjNoRef);
    }



    public function render()
    {

        return view(
            'livewire.r-j.emr-r-j.mr-r-j-dokter.assessment-dokter-diagnosis.assessment-dokter-diagnosis',
            [
                'myTitle' => 'Data Pasien Rawat Jalan',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'ICD 10',
            ]
        );
    }
}
