<?php

namespace App\Http\Livewire\EmrUGD\MrUGDDokter\AssessmentDokter;

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


    public function storeAssessmentDokterUGD()
    {
        $this->emit('storeAssessmentDokterUGD');
    }


    // select data start////////////////
    public function render()
    {

        return view(
            'livewire.emr-u-g-d.mr-u-g-d-dokter.assessment-dokter.assessment-dokter',
            []
        );
    }
    // select data end////////////////


}
