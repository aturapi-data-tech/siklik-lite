<?php

namespace App\Http\Traits\LOV\Pcare\LOVGetKesadaran;


use Illuminate\Support\Facades\DB;
use App\Http\Traits\BPJS\PcareTrait;
use Illuminate\Support\Str;

trait LOVGetKesadaranTrait
{
    use PcareTrait;

    public array $dataGetKesadaranLov = [];
    public int $dataGetKesadaranLovStatus = 0;
    public string $dataGetKesadaranLovSearch = '';
    public int $selecteddataGetKesadaranLovIndex = 0;
    public array $collectingMyGetKesadaran = [];

    /////////////////////////////////////////////////
    // Lov dataGetKesadaranLov //////////////////////
    ////////////////////////////////////////////////

    public function updateddataGetKesadaranLovsearch()
    {

        // Reset index of LoV
        $this->reset(['selecteddataGetKesadaranLovIndex', 'dataGetKesadaranLov']);
        // Variable Search
        $search = $this->dataGetKesadaranLovSearch;

        $getKesadaran = json_decode(DB::table('ref_bpjs_table')
            ->Where(DB::raw('upper(ref_keterangan)'), '=', strtoupper('Kesadaran'))
            // ->Where(DB::raw('upper(ref_keterangan)'), '=', strtoupper($this->dataGetKesadaranLovSearch))
            ->first()->ref_json, true) ?? [];

        $filteredPoliFktp = collect($getKesadaran)->filter(function ($getKesadaran) use ($search) {
            if ($getKesadaran['kdPoli'] === $search) {
                return Str::contains(strtoupper($getKesadaran['kdPoli']), strtoupper($search));
            }
        })->values()->first();

        // check LOV by dr_id rs id
        $dataGetKesadaranLovs = $filteredPoliFktp;
        if ($dataGetKesadaranLovs) {
            // set GetKesadaran sep
            $this->addGetKesadaran($dataGetKesadaranLovs['kdPoli'], $dataGetKesadaranLovs['nmPoli'], $dataGetKesadaranLovs['poliSakit']);
            $this->resetdataGetKesadaranLov();
        } else {

            // if there is no id found and check (min 1 char on search)
            if (strlen($search) < 1) {
                $this->dataGetKesadaranLov = [];
            } else {
                $this->dataGetKesadaranLov =
                    collect($getKesadaran)->filter(function ($getKesadaran) use ($search) {
                        return Str::contains(strtoupper($getKesadaran['nmPoli']), strtoupper($search));
                    })->values()->toArray();
            }
            $this->dataGetKesadaranLovStatus = true;
            // set doing nothing
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataGetKesadaranLov($id)
    {
        // set GetKesadaran sep
        $this->addGetKesadaran($this->dataGetKesadaranLov[$id]['kdPoli'], $this->dataGetKesadaranLov[$id]['nmPoli'], $this->dataGetKesadaranLov[$id]['poliSakit']);

        $this->resetdataGetKesadaranLov();
    }

    public function resetdataGetKesadaranLov()
    {
        $this->reset(['dataGetKesadaranLov', 'dataGetKesadaranLovStatus', 'dataGetKesadaranLovSearch', 'selecteddataGetKesadaranLovIndex']);
    }

    public function selectNextdataGetKesadaranLov()
    {
        if ($this->selecteddataGetKesadaranLovIndex === "") {
            $this->selecteddataGetKesadaranLovIndex = 0;
        } else {
            $this->selecteddataGetKesadaranLovIndex++;
        }

        if ($this->selecteddataGetKesadaranLovIndex === count($this->dataGetKesadaranLov)) {
            $this->selecteddataGetKesadaranLovIndex = 0;
        }
    }

    public function selectPreviousdataGetKesadaranLov()
    {

        if ($this->selecteddataGetKesadaranLovIndex === "") {
            $this->selecteddataGetKesadaranLovIndex = count($this->dataGetKesadaranLov) - 1;
        } else {
            $this->selecteddataGetKesadaranLovIndex--;
        }

        if ($this->selecteddataGetKesadaranLovIndex === -1) {
            $this->selecteddataGetKesadaranLovIndex = count($this->dataGetKesadaranLov) - 1;
        }
    }

    public function enterMydataGetKesadaranLov($id)
    {

        // jika JK belum siap maka toaster error
        if (isset($this->dataGetKesadaranLov[$id]['kdPoli'])) {
            $this->addGetKesadaran($this->dataGetKesadaranLov[$id]['kdPoli'], $this->dataGetKesadaranLov[$id]['nmPoli'], $this->dataGetKesadaranLov[$id]['poliSakit']);
            $this->resetdataGetKesadaranLov();
        } else {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError("Kode belum tersedia.");
            return;
        }
    }


    private function addGetKesadaran($kdPoli, $nmPoli, $poliSakit): void
    {
        $this->collectingMyGetKesadaran = [
            'kdPoli' => $kdPoli,
            'nmPoli' => $nmPoli,
            'poliSakit' => $poliSakit
        ];
    }


    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataGetKesadaranLov //////////////////////
    ////////////////////////////////////////////////
}
