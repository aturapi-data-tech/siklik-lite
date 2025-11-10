<?php

namespace App\Http\Traits\LOV\LOVPasien;


use Illuminate\Support\Facades\DB;

trait LOVPasienTrait
{

    public array $dataPasienLov = [];
    public int $dataPasienLovStatus = 0;
    public string $dataPasienLovSearch = '';
    public int $selecteddataPasienLovIndex = 0;
    public array $collectingMyPasien = [];

    /////////////////////////////////////////////////
    // Lov dataPasienLov //////////////////////
    ////////////////////////////////////////////////

    public function updateddataPasienLovsearch()
    {

        // Reset index of LoV
        $this->reset(['selecteddataPasienLovIndex', 'dataPasienLov']);
        // Variable Search
        $search = $this->dataPasienLovSearch;


        $dataPasienLov = $this->cariDataPasienByKey('reg_no', $search);
        if ($dataPasienLov) {
            $this->addPasien($dataPasienLov->reg_no, $dataPasienLov->reg_name, $dataPasienLov->address, $dataPasienLov->sex);
            $this->resetdataPasienLov();
        } else {
            // by nik
            $dataPasienLov = $this->cariDataPasienByKey('nik_bpjs', $search);
            if ($dataPasienLov) {
                $this->addPasien($dataPasienLov->reg_no, $dataPasienLov->reg_name, $dataPasienLov->address, $dataPasienLov->sex);
                $this->resetdataPasienLov();
            } else {
                // by nokaBPJS
                $dataPasienLov = $this->cariDataPasienByKey('nokartu_bpjs', $search);
                if ($dataPasienLov) {
                    $this->addPasien($dataPasienLov->reg_no, $dataPasienLov->reg_name, $dataPasienLov->address, $dataPasienLov->sex);
                    $this->resetdataPasienLov();
                } else {

                    // if there is no id found and check (min 1 char on search)
                    if (strlen($search) < 1) {
                        $this->dataPasienLov = [];
                    } else {
                        $dataPasienLov = DB::table('rsmst_pasiens')
                            ->select(
                                DB::raw("to_char(reg_date,'dd/mm/yyyy hh24:mi:ss') as reg_date"),
                                'reg_no',
                                'reg_name',
                                DB::raw("nvl(nokartu_bpjs,'-') as nokartu_bpjs"),
                                DB::raw("nvl(nik_bpjs,'-') as nik_bpjs"),
                                'sex',
                                DB::raw("to_char(birth_date,'dd/mm/yyyy') as birth_date"),
                                DB::raw("(select trunc( months_between( sysdate, birth_date ) /12 ) from dual) as thn"),
                                'bln',
                                'hari',
                                'birth_place',
                                'blood',
                                'marital_status',
                                'rel_id',
                                'edu_id',
                                'job_id',
                                'kk',
                                'nyonya',
                                'no_kk',
                                'address',
                                'rsmst_desas.des_id  as des_id',
                                'rsmst_kecamatans.kec_id  as kec_id',
                                'rsmst_kabupatens.kab_id  as kab_id',
                                'rsmst_propinsis.prop_id  as prop_id',
                                'des_name  as des_name',
                                'kec_name  as kec_name',
                                'kab_name  as kab_name',
                                'prop_name  as prop_name',
                                'rt',
                                'rw',
                                'phone'
                            )
                            ->join('rsmst_desas', 'rsmst_desas.des_id', 'rsmst_pasiens.des_id')
                            ->join('rsmst_kecamatans', 'rsmst_kecamatans.kec_id', 'rsmst_desas.kec_id')
                            ->join('rsmst_kabupatens', 'rsmst_kabupatens.kab_id', 'rsmst_kecamatans.kab_id')
                            ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_kabupatens.prop_id');


                        // myMultipleSearch by more than one table
                        $myMultipleSearch = explode('%', $search);

                        foreach ($myMultipleSearch as $key => $myMS) {
                            // key 0  mencari regno dan reg name
                            if ($key == 0) {
                                $dataPasienLov->where(function ($dataPasienLov) use ($myMS) {
                                    $dataPasienLov
                                        ->where(DB::raw('upper(reg_no)'), 'like', '%' . strtoupper($myMS) . '%')
                                        ->orWhere(DB::raw('upper(reg_name)'), 'like', '%' . strtoupper($myMS) . '%');
                                });
                            }
                            // key 1  mencari alamat
                            if ($key == 1) {
                                $dataPasienLov->where(function ($dataPasienLov) use ($myMS) {
                                    $dataPasienLov
                                        ->where(DB::raw('upper(address)'), 'like', '%' . strtoupper($myMS) . '%');
                                });
                            }
                        }

                        // limit 50 rec
                        $dataPasienLov->orderBy('reg_name', 'desc')
                            ->limit(50);

                        $this->dataPasienLov = json_decode($dataPasienLov->get(), true);
                    }
                    $this->dataPasienLovStatus = true;
                    // set doing nothing
                }
            }
        }
    }


    // /////////////////////
    // LOV selected start
    public function setMydataPasienLov($id): void
    {
        if (isset($this->dataPasienLov[$id]['reg_no'])) {
            $this->addPasien($this->dataPasienLov[$id]['reg_no'], $this->dataPasienLov[$id]['reg_name'], $this->dataPasienLov[$id]['address'], $this->dataPasienLov[$id]['sex']);
            $this->resetdataPasienLov();
        } else {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError("Kode belum tersedia.");
            return;
        }
    }

    public function resetdataPasienLov(): void
    {
        $this->reset(['dataPasienLov', 'dataPasienLovStatus', 'dataPasienLovSearch', 'selecteddataPasienLovIndex']);
    }

    public function selectNextdataPasienLov(): void
    {
        if ($this->selecteddataPasienLovIndex === "") {
            $this->selecteddataPasienLovIndex = 0;
        } else {
            $this->selecteddataPasienLovIndex++;
        }

        if ($this->selecteddataPasienLovIndex === count($this->dataPasienLov)) {
            $this->selecteddataPasienLovIndex = 0;
        }
    }

    public function selectPreviousdataPasienLov(): void
    {

        if ($this->selecteddataPasienLovIndex === "") {
            $this->selecteddataPasienLovIndex = count($this->dataPasienLov) - 1;
        } else {
            $this->selecteddataPasienLovIndex--;
        }

        if ($this->selecteddataPasienLovIndex === -1) {
            $this->selecteddataPasienLovIndex = count($this->dataPasienLov) - 1;
        }
    }

    public function enterMydataPasienLov($id)
    {

        // jika JK belum siap maka toaster error
        if (isset($this->dataPasienLov[$id]['reg_no'])) {
            $this->addPasien($this->dataPasienLov[$id]['reg_no'], $this->dataPasienLov[$id]['reg_name'], $this->dataPasienLov[$id]['address'], $this->dataPasienLov[$id]['sex']);
            $this->resetdataPasienLov();
        } else {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError("Kode belum tersedia.");
            return;
        }
    }


    private function addPasien($regNo, $RegName, $sex, $address): void
    {
        $this->collectingMyPasien = [
            'regNo' => $regNo,
            'regName' => $RegName,
            'sex' => $sex,
            'address' => $address,

        ];
    }


    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataPasienLov //////////////////////
    ////////////////////////////////////////////////


    private function cariDataPasienByKey($key, $search)
    {
        $cariDataPasienByKey = DB::table('rsmst_pasiens')
            ->select(
                DB::raw("to_char(reg_date,'dd/mm/yyyy hh24:mi:ss') as reg_date"),
                'reg_no',
                'reg_name',
                DB::raw("nvl(nokartu_bpjs,'-') as nokartu_bpjs"),
                DB::raw("nvl(nik_bpjs,'-') as nik_bpjs"),
                'sex',
                DB::raw("to_char(birth_date,'dd/mm/yyyy') as birth_date"),
                DB::raw("(select trunc( months_between( sysdate, birth_date ) /12 ) from dual) as thn"),
                'bln',
                'hari',
                'birth_place',
                'blood',
                'marital_status',
                'rel_id',
                'edu_id',
                'job_id',
                'kk',
                'nyonya',
                'no_kk',
                'address',
                'rsmst_desas.des_id  as des_id',
                'rsmst_kecamatans.kec_id  as kec_id',
                'rsmst_kabupatens.kab_id  as kab_id',
                'rsmst_propinsis.prop_id  as prop_id',
                'des_name  as des_name',
                'kec_name  as kec_name',
                'kab_name  as kab_name',
                'prop_name  as prop_name',
                'rt',
                'rw',
                'phone'
            )
            ->join('rsmst_desas', 'rsmst_desas.des_id', 'rsmst_pasiens.des_id')
            ->join('rsmst_kecamatans', 'rsmst_kecamatans.kec_id', 'rsmst_desas.kec_id')
            ->join('rsmst_kabupatens', 'rsmst_kabupatens.kab_id', 'rsmst_kecamatans.kab_id')
            ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_kabupatens.prop_id')
            ->where($key, $search)
            ->orderBy('reg_name', 'desc')
            ->first();

        return  $cariDataPasienByKey;
    }
}
