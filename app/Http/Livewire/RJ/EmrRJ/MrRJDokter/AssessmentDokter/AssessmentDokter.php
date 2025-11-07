<?php

namespace App\Http\Livewire\RJ\EmrRJ\MrRJDokter\AssessmentDokter;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Http\Traits\customErrorMessagesTrait;

use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;


class AssessmentDokter extends Component
{
    use WithPagination;


    // listener from blade////////////////
    protected $listeners = [];

    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef;
    public $regNoRef;


    public function storeAssessmentDokter()
    {
        $this->emit('emr:rj:store');
    }


    // select data start////////////////
    public function render()
    {

        return view(
            'livewire.r-j.emr-r-j.mr-r-j-dokter.assessment-dokter.assessment-dokter',
            []
        );
    }
    // select data end////////////////


}
