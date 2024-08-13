<?php

namespace App\Http\Livewire\DisplayPelayananRJ;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;


class DisplayPelayananRJ extends Component
{
    use WithPagination;






    //////////////////////////////
    // Ref on top bar start
    //////////////////////////////
    public $dateRjRef = '';

    public $shiftRjRef = [];

    public $statusRjRef = [];

    public $drRjRef = [];
    //////////////////////////////
    // Ref on top bar end
    //////////////////////////////

    public $dataDaftarPoliRJ = [];



    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////


    private function optionsshiftRjRef(): void
    {
        $findShift = DB::table('rstxn_shiftctls')->select('shift')
            ->whereRaw("'" . Carbon::now()->format('H:i:s') . "' between shift_start and shift_end")
            ->first();
        $this->shiftRjRef['shiftId'] = isset($findShift->shift) && $findShift->shift ? $findShift->shift : 3;
        $this->shiftRjRef['shiftDesc'] = isset($findShift->shift) && $findShift->shift ? $findShift->shift : 3;
    }



    private function optionsdrRjRef(): void
    {
        // Query dokter
        $query = DB::table('rsview_rjkasir')
            ->select(
                'dr_id',
                'dr_name',
                'poli_desc'
            )
            ->where('shift', '=', $this->shiftRjRef['shiftId'])
            ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $this->dateRjRef)
            ->groupBy('dr_id')
            ->groupBy('dr_name')
            ->groupBy('poli_desc')
            ->orderBy('poli_desc', 'desc')
            ->orderBy('dr_name', 'desc')
            ->get();

        // loop and set Ref
        $query->each(function ($item, $key) {

            // Pasien dilayani dokter
            $queryPasienDilayani = DB::table('rsview_rjkasir')
                ->select(
                    DB::raw("to_char(rj_date,'dd/mm/yyyy hh24:mi:ss') AS rj_date"),
                    DB::raw("to_char(rj_date,'yyyymmddhh24miss') AS rj_date1"),
                    'rj_no',
                    'reg_no',
                    'reg_name',
                    'sex',
                    'address',
                    'thn',
                    'poli_desc',
                    'dr_name',
                    'no_antrian',
                    'waktu_masuk_poli',
                    'waktu_masuk_apt'
                )
                ->where('rj_status', '=', $this->statusRjRef['statusId'])
                ->where('shift', '=', $this->shiftRjRef['shiftId'])
                ->where('klaim_id', '!=', 'KR')
                ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $this->dateRjRef)
                ->where('dr_id', '=', $item->dr_id)
                ->whereNotNull('waktu_masuk_poli') //not null
                ->whereNull('waktu_masuk_apt') //null Status pelayanan
                ->orderBy('no_antrian',  'asc')
                ->orderBy('rj_date1',  'desc')
                ->first();

            $this->drRjRef['drOptions'][$key + 1]['drName'] = $item->dr_name;
            $this->drRjRef['drOptions'][$key + 1]['poliDesc'] = $item->poli_desc;
            $this->drRjRef['drOptions'][$key + 1]['noAntrian'] = isset($queryPasienDilayani->no_antrian) ? $queryPasienDilayani->no_antrian : '-';
            $this->drRjRef['drOptions'][$key + 1]['regNo'] = isset($queryPasienDilayani->reg_no) ? $queryPasienDilayani->reg_no : '-';
            $this->drRjRef['drOptions'][$key + 1]['regName'] = isset($queryPasienDilayani->reg_name) ? $queryPasienDilayani->reg_name : '-';
            $this->drRjRef['drOptions'][$key + 1]['address'] = isset($queryPasienDilayani->address) ? $queryPasienDilayani->address : '-';
            $this->drRjRef['drOptions'][$key + 1]['sex'] = isset($queryPasienDilayani->sex) ? $queryPasienDilayani->sex : '-';
            $this->drRjRef['drOptions'][$key + 1]['thn'] = isset($queryPasienDilayani->thn) ? $queryPasienDilayani->thn : '-';
            $this->drRjRef['drOptions'][$key + 1]['waktu_masuk_poli'] = isset($queryPasienDilayani->waktu_masuk_poli) ? $queryPasienDilayani->waktu_masuk_poli : '-';
            $this->drRjRef['drOptions'][$key + 1]['waktu_masuk_apt'] = isset($queryPasienDilayani->waktu_masuk_apt) ? $queryPasienDilayani->waktu_masuk_apt : '-';


            // Pasien dari dokter
            $queryPasien = DB::table('rsview_rjkasir')
                ->select(
                    DB::raw("to_char(rj_date,'dd/mm/yyyy hh24:mi:ss') AS rj_date"),
                    DB::raw("to_char(rj_date,'yyyymmddhh24miss') AS rj_date1"),
                    'rj_no',
                    'reg_no',
                    'reg_name',
                    'sex',
                    'address',
                    'thn',
                    'poli_desc',
                    'dr_name',
                    'no_antrian',
                    'waktu_masuk_poli',
                    'waktu_masuk_apt'
                )
                ->where('rj_status', '=', $this->statusRjRef['statusId'])
                ->where('shift', '=', $this->shiftRjRef['shiftId'])
                ->where('klaim_id', '!=', 'KR')
                ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $this->dateRjRef)
                ->where('dr_id', '=', $item->dr_id)
                ->orderBy('no_antrian',  'asc')
                ->orderBy('rj_date1',  'desc')
                ->get();

            // loop and set Ref
            // $drName = $item->dr_name;
            foreach ($queryPasien as $keyqP => $qP) {
                $this->drRjRef['drOptions'][$key + 1]['pasien'][$keyqP + 1]['noAntrian'] = $qP->no_antrian;
                $this->drRjRef['drOptions'][$key + 1]['pasien'][$keyqP + 1]['regNo'] = $qP->reg_no;
                $this->drRjRef['drOptions'][$key + 1]['pasien'][$keyqP + 1]['regName'] = $qP->reg_name;
                $this->drRjRef['drOptions'][$key + 1]['pasien'][$keyqP + 1]['address'] = $qP->address;
                $this->drRjRef['drOptions'][$key + 1]['pasien'][$keyqP + 1]['sex'] = $qP->sex;
                $this->drRjRef['drOptions'][$key + 1]['pasien'][$keyqP + 1]['thn'] = $qP->thn;
                $this->drRjRef['drOptions'][$key + 1]['pasien'][$keyqP + 1]['drName'] = $qP->dr_name;
                $this->drRjRef['drOptions'][$key + 1]['pasien'][$keyqP + 1]['waktu_masuk_poli'] = $qP->waktu_masuk_poli;
                $this->drRjRef['drOptions'][$key + 1]['pasien'][$keyqP + 1]['waktu_masuk_apt'] = $qP->waktu_masuk_apt;
            }
        });
    }





    // when new form instance
    public function mount()
    {
        // set date
        $this->dateRjRef = Carbon::now()->format('d/m/Y');
        // set Status
        $this->statusRjRef['statusId'] = 'A';
        // set shift
        $this->optionsshiftRjRef();
        // set data dokter ref
        $this->optionsdrRjRef();
    }


    // select data start////////////////
    public function render()
    {

        // render drRjRef
        // set shift
        $this->optionsshiftRjRef();
        // set data dokter ref
        $this->optionsdrRjRef();


        return view(
            'livewire.display-pelayanan-r-j.display-pelayanan-r-j',
            [
                'myTitle' => 'Antrian Pasien Rawat Jalan',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
                'myLimitPerPages' => [5, 10, 15, 20, 100],
            ]
        );
    }
    // select data end////////////////
}
