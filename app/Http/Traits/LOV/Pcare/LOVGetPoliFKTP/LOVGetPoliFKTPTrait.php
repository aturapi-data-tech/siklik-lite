<?php

namespace App\Http\Traits\LOV\Pcare\LOVGetPoliFKTP;


use Illuminate\Support\Facades\DB;
use App\Http\Traits\BPJS\PcareTrait;
use Illuminate\Support\Str;

trait LOVGetPoliFKTPTrait
{
    use PcareTrait;

    public array $dataGetPoliFKTPLov = [];
    public int $dataGetPoliFKTPLovStatus = 0;
    public string $dataGetPoliFKTPLovSearch = '';
    public int $selecteddataGetPoliFKTPLovIndex = 0;
    public array $collectingMyGetPoliFKTP = [];

    /////////////////////////////////////////////////
    // Lov dataGetPoliFKTPLov //////////////////////
    ////////////////////////////////////////////////

    public function updateddataGetPoliFKTPLovsearch()
    {

        // Reset index of LoV
        $this->reset(['selecteddataGetPoliFKTPLovIndex', 'dataGetPoliFKTPLov']);
        // Variable Search
        $search = $this->dataGetPoliFKTPLovSearch;

        $getPoliFktp = json_decode(DB::table('ref_bpjs_table')
            ->Where(DB::raw('upper(ref_keterangan)'), '=', strtoupper('PoliFktp'))
            // ->Where(DB::raw('upper(ref_keterangan)'), '=', strtoupper($this->dataGetPoliFKTPLovSearch))
            ->first()->ref_json ?? '{}', true);

        $filteredPoliFktp = collect($getPoliFktp)->filter(function ($getPoliFktp) use ($search) {
            if ($getPoliFktp['kdPoli'] === $search) {
                return Str::contains(strtoupper($getPoliFktp['kdPoli']), strtoupper($search));
            }
        })->values()->first();

        // check LOV by dr_id rs id
        $dataGetPoliFKTPLovs = $filteredPoliFktp;
        if ($dataGetPoliFKTPLovs) {
            // set GetPoliFKTP sep
            $this->addGetPoliFKTP($dataGetPoliFKTPLovs['kdPoli'], $dataGetPoliFKTPLovs['nmPoli'], $dataGetPoliFKTPLovs['poliSakit']);
            $this->resetdataGetPoliFKTPLov();
        } else {

            // if there is no id found and check (min 1 char on search)
            if (strlen($search) < 1) {
                $this->dataGetPoliFKTPLov = [];
            } else {
                $this->dataGetPoliFKTPLov =
                    collect($getPoliFktp)->filter(function ($getPoliFktp) use ($search) {
                        return Str::contains(strtoupper($getPoliFktp['nmPoli']), strtoupper($search));
                    })->values()->toArray();
            }
            $this->dataGetPoliFKTPLovStatus = true;
            // set doing nothing
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataGetPoliFKTPLov($id)
    {
        // set GetPoliFKTP sep
        $this->addGetPoliFKTP($this->dataGetPoliFKTPLov[$id]['kdPoli'], $this->dataGetPoliFKTPLov[$id]['nmPoli'], $this->dataGetPoliFKTPLov[$id]['poliSakit']);

        $this->resetdataGetPoliFKTPLov();
    }

    public function resetdataGetPoliFKTPLov()
    {
        $this->reset(['dataGetPoliFKTPLov', 'dataGetPoliFKTPLovStatus', 'dataGetPoliFKTPLovSearch', 'selecteddataGetPoliFKTPLovIndex']);
    }

    public function selectNextdataGetPoliFKTPLov()
    {
        if ($this->selecteddataGetPoliFKTPLovIndex === "") {
            $this->selecteddataGetPoliFKTPLovIndex = 0;
        } else {
            $this->selecteddataGetPoliFKTPLovIndex++;
        }

        if ($this->selecteddataGetPoliFKTPLovIndex === count($this->dataGetPoliFKTPLov)) {
            $this->selecteddataGetPoliFKTPLovIndex = 0;
        }
    }

    public function selectPreviousdataGetPoliFKTPLov()
    {

        if ($this->selecteddataGetPoliFKTPLovIndex === "") {
            $this->selecteddataGetPoliFKTPLovIndex = count($this->dataGetPoliFKTPLov) - 1;
        } else {
            $this->selecteddataGetPoliFKTPLovIndex--;
        }

        if ($this->selecteddataGetPoliFKTPLovIndex === -1) {
            $this->selecteddataGetPoliFKTPLovIndex = count($this->dataGetPoliFKTPLov) - 1;
        }
    }

    public function enterMydataGetPoliFKTPLov($id)
    {
        // jika JK belum siap maka toaster error
        if (isset($this->dataGetPoliFKTPLov[$id]['kdPoli'])) {
            $this->addGetPoliFKTP($this->dataGetPoliFKTPLov[$id]['kdPoli'], $this->dataGetPoliFKTPLov[$id]['nmPoli'], $this->dataGetPoliFKTPLov[$id]['poliSakit']);
            $this->resetdataGetPoliFKTPLov();
        } else {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError("Kode belum tersedia.");
            return;
        }
    }


    private function addGetPoliFKTP($kdPoli, $nmPoli, $poliSakit): void
    {
        $this->collectingMyGetPoliFKTP = [
            'kdPoli' => $kdPoli,
            'nmPoli' => $nmPoli,
            'poliSakit' => $poliSakit
        ];
    }


    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataGetPoliFKTPLov //////////////////////
    ////////////////////////////////////////////////
}
