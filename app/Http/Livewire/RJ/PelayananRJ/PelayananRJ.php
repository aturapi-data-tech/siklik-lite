<?php

namespace App\Http\Livewire\RJ\PelayananRJ;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Http\Traits\EmrRJ\EmrRJTrait;


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





    public function masukPoli($rjNo)
    {

        $findDataRJ = $this->findDataRJ($rjNo);
        $dataDaftarPoliRJ  = $findDataRJ['dataDaftarRJ'];

        if (!$dataDaftarPoliRJ['taskIdPelayanan']['taskId4']) {
            $waktuMasukPoli = Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s');
            $dataDaftarPoliRJ['taskIdPelayanan']['taskId4'] = $waktuMasukPoli;
            // update DB

            DB::table('rstxn_rjhdrs')
                ->where('rj_no', $rjNo)
                ->update([
                    'waktu_masuk_poli' => DB::raw("to_date('" . $waktuMasukPoli . "','dd/mm/yyyy hh24:mi:ss')"), //waktu masuk = rjdate
                ]);

            $dataDaftarPoliRJ['userLogs'][] =
                [
                    'userLogDesc' => 'Masuk Poli',
                    'userLog' => auth()->user()->myuser_name,
                    'userLogDate' => Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s')
                ];

            $this->updateJsonRJ($rjNo, $dataDaftarPoliRJ);

            $this->emit('toastr-success', "Masuk Poli " . $dataDaftarPoliRJ['taskIdPelayanan']['taskId4']);
        } else {
            $this->emit('toastr-error', "Masuk Poli " . $dataDaftarPoliRJ['taskIdPelayanan']['taskId4'] . " Sudah Terisi");
        }
    }


    public function keluarPoli($rjNo)
    {
        $findDataRJ = $this->findDataRJ($rjNo);
        $dataDaftarPoliRJ  = $findDataRJ['dataDaftarRJ'];

        // cek taskId sebelumnya
        if ($dataDaftarPoliRJ['taskIdPelayanan']['taskId4']) {

            // isi taskId5
            if (!$dataDaftarPoliRJ['taskIdPelayanan']['taskId5']) {
                $waktuKeluarPoli = Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s');
                $dataDaftarPoliRJ['taskIdPelayanan']['taskId5'] = $waktuKeluarPoli;

                // update DB
                DB::table('rstxn_rjhdrs')
                    ->where('rj_no', $rjNo)
                    ->update([
                        'waktu_masuk_apt' => DB::raw("to_date('" . $waktuKeluarPoli . "','dd/mm/yyyy hh24:mi:ss')"), //waktu keluar = rjdate
                    ]);

                $dataDaftarPoliRJ['userLogs'][] =
                    [
                        'userLogDesc' => 'Keluar Poli',
                        'userLog' => auth()->user()->myuser_name,
                        'userLogDate' => Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s')
                    ];

                $this->updateJsonRJ($rjNo, $dataDaftarPoliRJ);

                $this->emit('toastr-success', "Keluar Poli " . $dataDaftarPoliRJ['taskIdPelayanan']['taskId5']);
            } else {
                $this->emit('toastr-error', "Keluar Poli " . $dataDaftarPoliRJ['taskIdPelayanan']['taskId5'] . " Sudah Terisi");
            }
        } else {
            $this->emit('toastr-error', "Satus Pasien Belum melalui pelayanan Poli");
        }
    }


    public function batalPoli($rjNo, $regName): void
    {
        $findDataRJ = $this->findDataRJ($rjNo);
        $dataDaftarPoliRJ  = $findDataRJ['dataDaftarRJ'];

        // cek taskId sebelumnya
        if (!$dataDaftarPoliRJ['taskIdPelayanan']['taskId5']) {

            // isi taskId99 Pembatalan
            if (!$dataDaftarPoliRJ['taskIdPelayanan']['taskId99']) {
                $waktuBatalPoli = Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s');
                $dataDaftarPoliRJ['taskIdPelayanan']['taskId99'] = $waktuBatalPoli;

                // update DB
                DB::table('rstxn_rjhdrs')
                    ->where('rj_no', $rjNo)
                    ->update([
                        'rj_status' => 'F',
                    ]);

                $dataDaftarPoliRJ['userLogs'][] =
                    [
                        'userLogDesc' => 'Batal Poli',
                        'userLog' => auth()->user()->myuser_name,
                        'userLogDate' => Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s')
                    ];


                $this->updateJsonRJ($rjNo, $dataDaftarPoliRJ);

                $this->emit('toastr-success', "Batal Poli " . $dataDaftarPoliRJ['taskIdPelayanan']['taskId99']);
            } else {
                $this->emit('toastr-error', "Batal Poli " . $dataDaftarPoliRJ['taskIdPelayanan']['taskId99'] . " Sudah Terisi");
            }
        } else {
            $this->emit('toastr-error', "Pembatalan tidak dapat dilakukan, " . $regName . " sudak melakukan pelayanan Poli.");
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
