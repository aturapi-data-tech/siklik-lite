<?php

namespace App\Http\Livewire\RJ\PelayananRJ;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Http\Traits\EmrRJ\EmrRJTrait;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Cache;

class PelayananRJ extends Component
{
    use WithPagination, EmrRJTrait;



    //////////////////////////////
    // Ref on top bar start
    //////////////////////////////
    public $dateRjRef = '';



    public $statusRjRef = [
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
    //////////////////////////////
    // Ref on top bar end
    //////////////////////////////


    // limit record per page -resetExcept////////////////
    public $limitPerPage = 10;



    //



    // search logic -resetExcept////////////////
    public $search;
    protected $queryString = [
        'search' => ['except' => '', 'as' => 'cariData'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];



    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////





    // resert input private////////////////
    private function resetInputFields(): void
    {

        // resert validation
        $this->resetValidation();
        // resert input
        $this->resetExcept([
            'limitPerPage',
            'search',
            'dateRjRef',
            'statusRjRef',
            'drRjRef'

        ]);
    }





    // setLimitPerpage////////////////
    public function setLimitPerPage($value): void
    {
        $this->limitPerPage = $value;
        $this->resetValidation();
    }


    private function optionsdrRjRef(): void
    {
        // Query
        $query = DB::table('rsview_rjkasir')
            ->select(
                'dr_id',
                'dr_name',
            )
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






    /////////////////////////////////////////////////////////////////////
    // resert page pagination when coloumn search change ////////////////
    // tabular Ref topbar
    /////////////////////////////////////////////////////////////////////

    // search
    public function updatedSearch(): void
    {
        // $this->emit('toastr-error', "search.");

        $this->resetPage();
        $this->resetValidation();
        $this->resetInputFields();
    }
    // date
    public function updatedDaterjref(): void
    {
        // $this->emit('toastr-error', "date.");

        $this->resetPage();
        $this->resetValidation();
        $this->resetInputFields();
    }
    // status
    public function updatedStatusrjref(): void
    {
        // $this->emit('toastr-error', "status.");

        $this->resetPage();
        $this->resetValidation();
        $this->resetInputFields();
    }
    // dr
    public function setdrRjRef($id, $name): void
    {
        // $this->emit('toastr-error', "dr.");

        $this->drRjRef['drId'] = $id;
        $this->drRjRef['drName'] = $name;
        $this->resetPage();
        $this->resetValidation();
        $this->resetInputFields();
    }

    /////////////////////////////////////////////////////////////////////






    public function masukPoli($rjNo): void
    {
        $lockKey = "rj:{$rjNo}:task";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {

                    // 1) Guard via DB row + lockForUpdate
                    $row = DB::table('rstxn_rjhdrs')
                        ->where('rj_no', $rjNo)
                        ->lockForUpdate()
                        ->first();

                    if (!$row) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Data RJ tidak ditemukan.');
                        return;
                    }
                    if (!empty($row->waktu_masuk_poli)) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Masuk Poli sudah terisi.');
                        return;
                    }

                    // 2) Timestamp
                    $waktu = Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s');

                    // 3) Update kolom DB dengan guard (idempotent)
                    $affected = DB::table('rstxn_rjhdrs')
                        ->where('rj_no', $rjNo)
                        ->whereNull('waktu_masuk_poli')
                        ->update([
                            'waktu_masuk_poli' => DB::raw("to_date('{$waktu}','dd/mm/yyyy hh24:mi:ss')")
                        ]);

                    if ($affected === 0) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Masuk Poli gagal karena sudah terisi oleh proses lain.');
                        return;
                    }

                    // 4) Ambil FRESH JSON → patch subtree → simpan
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!is_array($fresh)) $fresh = [];
                    if (!isset($fresh['taskIdPelayanan']) || !is_array($fresh['taskIdPelayanan'])) {
                        $fresh['taskIdPelayanan'] = [];
                    }
                    if (!isset($fresh['userLogs']) || !is_array($fresh['userLogs'])) {
                        $fresh['userLogs'] = [];
                    }

                    $fresh['taskIdPelayanan']['taskId4'] = $waktu;
                    $fresh['userLogs'][] = [
                        'userLogDesc' => 'Masuk Poli',
                        'userLog'     => auth()->user()->myuser_name,
                        'userLogDate' => $waktu,
                    ];

                    $this->updateJsonRJ($rjNo, $fresh);

                    toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                        ->addSuccess("Masuk Poli {$waktu}");
                });
            });
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk. Gagal memperoleh lock. Coba lagi.');
        }
    }

    public function keluarPoli($rjNo): void
    {
        $lockKey = "rj:{$rjNo}:task";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {

                    $row = DB::table('rstxn_rjhdrs')
                        ->where('rj_no', $rjNo)
                        ->lockForUpdate()
                        ->first();

                    if (!$row) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Data RJ tidak ditemukan.');
                        return;
                    }
                    if (empty($row->waktu_masuk_poli)) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Status pasien belum Masuk Poli.');
                        return;
                    }
                    if (!empty($row->waktu_masuk_apt)) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Keluar Poli sudah terisi.');
                        return;
                    }

                    $waktu = Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s');

                    $affected = DB::table('rstxn_rjhdrs')
                        ->where('rj_no', $rjNo)
                        ->whereNull('waktu_masuk_apt')
                        ->update([
                            // (mengikuti skema kamu: kolom ini dipakai utk waktu keluar poli)
                            'waktu_masuk_apt' => DB::raw("to_date('{$waktu}','dd/mm/yyyy hh24:mi:ss')")
                        ]);

                    if ($affected === 0) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Keluar Poli gagal karena sudah terisi oleh proses lain.');
                        return;
                    }

                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!is_array($fresh)) $fresh = [];
                    if (!isset($fresh['taskIdPelayanan']) || !is_array($fresh['taskIdPelayanan'])) {
                        $fresh['taskIdPelayanan'] = [];
                    }
                    if (!isset($fresh['userLogs']) || !is_array($fresh['userLogs'])) {
                        $fresh['userLogs'] = [];
                    }

                    $fresh['taskIdPelayanan']['taskId5'] = $waktu;
                    $fresh['userLogs'][] = [
                        'userLogDesc' => 'Keluar Poli',
                        'userLog'     => auth()->user()->myuser_name,
                        'userLogDate' => $waktu,
                    ];

                    $this->updateJsonRJ($rjNo, $fresh);

                    toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                        ->addSuccess("Keluar Poli {$waktu}");
                });
            });
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk. Gagal memperoleh lock. Coba lagi.');
        }
    }

    public function batalPoli($rjNo, $regName): void
    {
        $lockKey = "rj:{$rjNo}:task";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo, $regName) {
                DB::transaction(function () use ($rjNo, $regName) {

                    $row = DB::table('rstxn_rjhdrs')
                        ->where('rj_no', $rjNo)
                        ->lockForUpdate()
                        ->first();

                    if (!$row) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Data RJ tidak ditemukan.');
                        return;
                    }
                    if (!empty($row->waktu_masuk_apt)) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError("Pembatalan tidak dapat dilakukan, {$regName} sudah melakukan pelayanan Poli.");
                        return;
                    }
                    if ($row->rj_status === 'F') {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Pembatalan sudah tercatat.');
                        return;
                    }

                    // set F dengan guard supaya idempotent
                    $affected = DB::table('rstxn_rjhdrs')
                        ->where('rj_no', $rjNo)
                        ->where('rj_status', '!=', 'F')
                        ->update(['rj_status' => 'F']);

                    if ($affected === 0) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Pembatalan gagal karena status sudah berubah.');
                        return;
                    }

                    $waktu = Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s');

                    // patch JSON FRESH
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!is_array($fresh)) $fresh = [];
                    if (!isset($fresh['taskIdPelayanan']) || !is_array($fresh['taskIdPelayanan'])) {
                        $fresh['taskIdPelayanan'] = [];
                    }
                    if (!isset($fresh['userLogs']) || !is_array($fresh['userLogs'])) {
                        $fresh['userLogs'] = [];
                    }

                    $fresh['taskIdPelayanan']['taskId99'] = $waktu;
                    $fresh['userLogs'][] = [
                        'userLogDesc' => 'Batal Poli',
                        'userLog'     => auth()->user()->myuser_name,
                        'userLogDate' => $waktu,
                    ];

                    $this->updateJsonRJ($rjNo, $fresh);

                    toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                        ->addSuccess("Batal Poli {$waktu}");
                });
            });
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk. Gagal memperoleh lock. Coba lagi.');
        }
    }



    public function getListTaskId($noBooking): void
    {

        // $HttpGetBpjs =  AntrianTrait::taskid_antrean($noBooking)->getOriginalContent();
        $HttpGetBpjs = 'xxx';
        dd($HttpGetBpjs);
        $this->emit('toastr-success', 'Task Id' . $noBooking . ' ' . $HttpGetBpjs);
    }



    public function mount()
    {
        // set date
        $this->dateRjRef = Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y');
        // set data dokter ref
        $this->optionsdrRjRef();
    }


    // select data start////////////////
    public function render()
    {

        // render drRjRef
        $this->optionsdrRjRef();

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

                'waktu_masuk_poli',
                'waktu_masuk_apt',
                'datadaftarpolirj_json'
            )
            ->where('rj_status', '=', $this->statusRjRef['statusId'])
            ->where('klaim_id', '!=', 'KR')
            ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $this->dateRjRef);

        //Jika where dokter tidak kosong
        if ($this->drRjRef['drId'] != 'All') {
            $query->where('dr_id', $this->drRjRef['drId']);
        }

        $query->where(function ($q) {
            $q->Where(DB::raw('upper(reg_name)'), 'like', '%' . strtoupper($this->search) . '%')
                ->orWhere(DB::raw('upper(reg_no)'), 'like', '%' . strtoupper($this->search) . '%')
                ->orWhere(DB::raw('upper(dr_name)'), 'like', '%' . strtoupper($this->search) . '%')
                ->orWhere(DB::raw('upper(poli_desc)'), 'like', '%' . strtoupper($this->search) . '%');
        })
            ->orderBy('dr_name',  'desc')
            ->orderBy('poli_desc',  'desc')
            ->orderBy('no_antrian',  'asc')
            ->orderBy('rj_date1',  'desc');

        ////////////////////////////////////////////////
        // end Query
        ///////////////////////////////////////////////



        return view(
            'livewire.r-j.pelayanan-r-j.pelayanan-r-j',
            [
                'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Pelayanan Rawat Jalan',
                'mySnipt' => 'Data Pelayanan Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
                'myLimitPerPages' => [5, 10, 15, 20, 100],
            ]
        );
    }
    // select data end////////////////
}
