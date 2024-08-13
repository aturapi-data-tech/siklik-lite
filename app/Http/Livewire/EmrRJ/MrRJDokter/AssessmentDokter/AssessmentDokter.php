<?php

namespace App\Http\Livewire\EmrRJ\MrRJDokter\AssessmentDokter;

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


    public function storeAssessmentDokterRJ()
    {
        $this->emit('storeAssessmentDokterRJ');
    }


    // select data start////////////////
    public function render()
    {

        return view(
            'livewire.emr-r-j.mr-r-j-dokter.assessment-dokter.assessment-dokter',
            []
        );
    }
    // select data end////////////////


}
