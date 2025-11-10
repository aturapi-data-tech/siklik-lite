<?php

namespace App\Http\Livewire\RJ\EmrRJ\AdministrasiRJ;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;



class RadiologiRJ extends Component
{
    use WithPagination;






    //////////////////////////////z
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef;



    // dataDaftarPoliRJ RJ
    public array $dataDaftarPoliRJ = [];

    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////

    private function findData($rjno): void
    {
        $findData = DB::table('rstxn_rjrads')
            ->join('rsmst_radiologis', 'rsmst_radiologis.rad_id', 'rstxn_rjrads.rad_id')
            ->select('rad_desc', 'rstxn_rjrads.rad_price as rad_price', 'rad_dtl')
            ->where('rj_no', $rjno)
            ->get();



        if ($findData) {
            $this->dataDaftarPoliRJ['rjRad'] = json_decode(json_encode($findData, true), true);
        } else {

            $this->dataDaftarPoliRJ['rjRad'] = [];
        }
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
            'livewire.r-j.emr-r-j.administrasi-r-j.radiologi-r-j',
            [
                // 'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Data Pasien Rawat Jalan',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Radiologi',
            ]
        );
    }
    // select data end////////////////


}
