<?php

namespace App\Http\Traits\LOV\LOVDokter;


use Illuminate\Support\Facades\DB;

trait LOVDokterTrait
{

    public array $dataDokterLov = [];
    public int $dataDokterLovStatus = 0;
    public string $dataDokterLovSearch = '';
    public int $selecteddataDokterLovIndex = 0;
    public array $collectingMyDokter = [];

    /////////////////////////////////////////////////
    // Lov dataDokterLov //////////////////////
    ////////////////////////////////////////////////

    public function updateddataDokterLovsearch()
    {

        // Reset index of LoV
        $this->reset(['selecteddataDokterLovIndex', 'dataDokterLov']);
        // Variable Search
        $search = $this->dataDokterLovSearch;

        // check LOV by dr_id rs id
        $dataDokterLovs = DB::table('rsmst_doctors ')
            ->select(
                'dr_id',
                'dr_name',
                'rsmst_doctors.poli_id as poli_id',
                'poli_desc',
                'kd_poli_bpjs',
                'kd_dr_bpjs'
            )
            ->join('rsmst_polis', 'rsmst_polis.poli_id', '=', 'rsmst_doctors.poli_id')
            ->where('rsmst_doctors.dr_id', '=', $search)
            // ->where('active_status', '1')
            ->first();

        if ($dataDokterLovs) {

            // set Dokter sep
            $this->addDokter($dataDokterLovs->dr_id, $dataDokterLovs->dr_name, $dataDokterLovs->poli_id, $dataDokterLovs->poli_desc, $dataDokterLovs->kd_poli_bpjs, $dataDokterLovs->kd_dr_bpjs);
            $this->resetdataDokterLov();
        } else {

            // if there is no id found and check (min 1 char on search)
            if (strlen($search) < 1) {
                $this->dataDokterLov = [];
            } else {
                $this->dataDokterLov = json_decode(
                    DB::table('rsmst_doctors')
                        ->select(
                            'dr_id',
                            'dr_name',
                            'rsmst_doctors.poli_id as poli_id',
                            'poli_desc',
                            'kd_poli_bpjs',
                            'kd_dr_bpjs'
                        )
                        ->join('rsmst_polis', 'rsmst_polis.poli_id', '=', 'rsmst_doctors.poli_id')
                        // ->where('active_status', '1')
                        ->Where(DB::raw('upper(dr_name)'), 'like', '%' . strtoupper($search) . '%')
                        ->orWhere(DB::raw('upper(rsmst_doctors.dr_id)'), 'like', '%' . strtoupper($search) . '%')
                        ->orWhere(DB::raw('upper(rsmst_doctors.poli_id)'), 'like', '%' . strtoupper($search) . '%')
                        ->orWhere(DB::raw('upper(poli_desc)'), 'like', '%' . strtoupper($search) . '%')
                        ->limit(10)
                        ->orderBy('dr_name', 'ASC')
                        ->orderBy('dr_id', 'ASC')
                        ->get(),
                    true
                );
            }
            $this->dataDokterLovStatus = true;
            // set doing nothing
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataDokterLov($id)
    {
        // $this->checkRjStatus();
        $dataDokterLovs = DB::table('rsmst_doctors')
            ->select(
                'dr_id',
                'dr_name',
                'rsmst_doctors.poli_id as poli_id',
                'poli_desc',
                'kd_poli_bpjs',
                'kd_dr_bpjs'
            )
            ->join('rsmst_polis', 'rsmst_polis.poli_id', '=', 'rsmst_doctors.poli_id')
            ->where('dr_id', $this->dataDokterLov[$id]['dr_id'])
            ->first();

        // set dokter sep
        $this->addDokter($dataDokterLovs->dr_id, $dataDokterLovs->dr_name, $dataDokterLovs->poli_id, $dataDokterLovs->poli_desc, $dataDokterLovs->kd_poli_bpjs, $dataDokterLovs->kd_dr_bpjs);
        $this->resetdataDokterLov();
    }

    public function resetdataDokterLov()
    {
        $this->reset(['dataDokterLov', 'dataDokterLovStatus', 'dataDokterLovSearch', 'selecteddataDokterLovIndex']);
    }

    public function selectNextdataDokterLov()
    {
        if ($this->selecteddataDokterLovIndex === "") {
            $this->selecteddataDokterLovIndex = 0;
        } else {
            $this->selecteddataDokterLovIndex++;
        }

        if ($this->selecteddataDokterLovIndex === count($this->dataDokterLov)) {
            $this->selecteddataDokterLovIndex = 0;
        }
    }

    public function selectPreviousdataDokterLov()
    {

        if ($this->selecteddataDokterLovIndex === "") {
            $this->selecteddataDokterLovIndex = count($this->dataDokterLov) - 1;
        } else {
            $this->selecteddataDokterLovIndex--;
        }

        if ($this->selecteddataDokterLovIndex === -1) {
            $this->selecteddataDokterLovIndex = count($this->dataDokterLov) - 1;
        }
    }

    public function enterMydataDokterLov($id)
    {
        // dd($this->dataDokterLov);
        // $this->checkRjStatus();
        // jika JK belum siap maka toaster error
        if (isset($this->dataDokterLov[$id]['dr_id'])) {
            $this->addDokter($this->dataDokterLov[$id]['dr_id'], $this->dataDokterLov[$id]['dr_name'], $this->dataDokterLov[$id]['poli_id'], $this->dataDokterLov[$id]['poli_desc'], $this->dataDokterLov[$id]['kd_poli_bpjs'], $this->dataDokterLov[$id]['kd_dr_bpjs']);
            $this->resetdataDokterLov();
        } else {
            $this->emit('toastr-error', "Kode belum tersedia.");
            return;
        }
    }


    private function addDokter($DokterId, $DokterDesc, $PoliId, $PoliDesc, $kdPoliBpjs, $kdDokterBpjs): void
    {
        $this->collectingMyDokter = [
            'DokterId' => $DokterId,
            'DokterDesc' => $DokterDesc,
            'PoliId' => $PoliId,
            'PoliDesc' => $PoliDesc,
            'kdPoliBpjs' => $kdPoliBpjs,
            'kdDokterBpjs' => $kdDokterBpjs

        ];
    }


    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataDokterLov //////////////////////
    ////////////////////////////////////////////////
}
