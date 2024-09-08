<?php

namespace App\Http\Livewire\Component\DisplayPasien;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DisplayPasien extends Component
{
    public $regNoRef;

    public array $displayPasien = [];

    private function findData($regNo): void
    {
        $this->setdisplayPasien($regNo);
    }

    private function setdisplayPasien($value): void
    {
        $findData = DB::table('rsmst_pasiens')
            ->select('meta_data_pasien_json')
            ->where('reg_no', $value)
            ->first();


        $meta_data_pasien_json = isset($findData->meta_data_pasien_json) ? $findData->meta_data_pasien_json : null;
        // if meta_data_pasien_json = null
        // then cari Data Pasien By Key Collection (exception when no data found)
        //
        // else json_decode
        if ($meta_data_pasien_json == null) {

            $findData = $this->caridisplayPasienByKeyCollection('reg_no', $value);
            if ($findData) {
                $this->displayPasien['pasien']['regDate'] = $findData->reg_date;
                $this->displayPasien['pasien']['regNo'] = $findData->reg_no;
                $this->displayPasien['pasien']['regName'] = $findData->reg_name;
                $this->displayPasien['pasien']['identitas']['idBpjs'] = $findData->nokartu_bpjs;
                $this->displayPasien['pasien']['identitas']['nik'] = $findData->nik_bpjs;
                $this->displayPasien['pasien']['jenisKelamin']['jenisKelaminId'] = ($findData->sex == 'L') ? 1 : 2;
                $this->displayPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] = ($findData->sex == 'L') ? 'Laki-laki' : 'Perempuan';
                $this->displayPasien['pasien']['tglLahir'] = $findData->birth_date;

                $birth_date = $findData->birth_date ? $findData->birth_date : Carbon::now()->format('d/m/Y');
                $this->displayPasien['pasien']['thn'] = Carbon::createFromFormat('d/m/Y', $birth_date)->diff(Carbon::now())->format('%y Thn, %m Bln %d Hr'); //$findData->thn;
                $this->displayPasien['pasien']['bln'] = $findData->bln;
                $this->displayPasien['pasien']['hari'] = $findData->hari;
                $this->displayPasien['pasien']['tempatLahir'] = $findData->birth_place;
                $this->displayPasien['pasien']['golonganDarah']['golonganDarahId'] = '13';
                $this->displayPasien['pasien']['golonganDarah']['golonganDarahDesc'] = 'Tidak Tahu';
                $this->displayPasien['pasien']['statusPerkawinan']['statusPerkawinanId'] = '1';
                $this->displayPasien['pasien']['statusPerkawinan']['statusPerkawinanDesc'] = 'Belum Kawin';

                $this->displayPasien['pasien']['agama']['agamaId'] = $findData->rel_id;
                $this->displayPasien['pasien']['agama']['agamaDesc'] = $findData->rel_desc;

                $this->displayPasien['pasien']['pendidikan']['pendidikanId'] = $findData->edu_id;
                $this->displayPasien['pasien']['pendidikan']['pendidikanDesc'] = $findData->edu_desc;

                $this->displayPasien['pasien']['pekerjaan']['pekerjaanId'] = $findData->job_id;
                $this->displayPasien['pasien']['pekerjaan']['pekerjaanDesc'] = $findData->job_name;


                $this->displayPasien['pasien']['hubungan']['namaPenanggungJawab'] = $findData->reg_no;
                $this->displayPasien['pasien']['hubungan']['namaIbu'] = $findData->reg_no;

                $this->displayPasien['pasien']['identitas']['nik'] = $findData->nik_bpjs;
                $this->displayPasien['pasien']['identitas']['idBpjs'] = $findData->nokartu_bpjs;


                $this->displayPasien['pasien']['identitas']['alamat'] = $findData->address;

                $this->displayPasien['pasien']['identitas']['desaId'] = $findData->des_id;
                $this->displayPasien['pasien']['identitas']['desaName'] = $findData->des_name;

                $this->displayPasien['pasien']['identitas']['rt'] = $findData->rt;
                $this->displayPasien['pasien']['identitas']['rw'] = $findData->rw;
                $this->displayPasien['pasien']['identitas']['kecamatanId'] = $findData->kec_id;
                $this->displayPasien['pasien']['identitas']['kecamatanName'] = $findData->kec_name;

                $this->displayPasien['pasien']['identitas']['kotaId'] = $findData->kab_id;
                $this->displayPasien['pasien']['identitas']['kotaName'] = $findData->kab_name;

                $this->displayPasien['pasien']['identitas']['propinsiId'] = $findData->prop_id;
                $this->displayPasien['pasien']['identitas']['propinsiName'] = $findData->prop_name;

                $this->displayPasien['pasien']['kontak']['nomerTelponSelulerPasien'] = $findData->phone;

                $this->displayPasien['pasien']['hubungan']['namaPenanggungJawab'] = $findData->kk;
                $this->displayPasien['pasien']['hubungan']['namaIbu'] = $findData->nyonya;
                // $this->displayPasien['pasien']['hubungan']['noPenanggungJawab'] = $findData->no_kk;
            } else {
                // when no data found
                $this->displayPasien['pasien']['regDate'] = '-';
                $this->displayPasien['pasien']['regNo'] = '-';
                $this->displayPasien['pasien']['regName'] = '-';
                $this->displayPasien['pasien']['identitas']['idBpjs'] = '-';
                $this->displayPasien['pasien']['identitas']['nik'] = '-';
                $this->displayPasien['pasien']['jenisKelamin']['jenisKelaminId'] = '-';
                $this->displayPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] = '-';
                $this->displayPasien['pasien']['tglLahir'] = '-';
                $this->displayPasien['pasien']['thn'] = '-';
                $this->displayPasien['pasien']['bln'] = '-';
                $this->displayPasien['pasien']['hari'] = '-';
                $this->displayPasien['pasien']['tempatLahir'] = '-';
                $this->displayPasien['pasien']['golonganDarah']['golonganDarahId'] = '-';
                $this->displayPasien['pasien']['golonganDarah']['golonganDarahDesc'] = '-';
                $this->displayPasien['pasien']['statusPerkawinan']['statusPerkawinanId'] = '-';
                $this->displayPasien['pasien']['statusPerkawinan']['statusPerkawinanDesc'] = '-';

                $this->displayPasien['pasien']['agama']['agamaId'] = '-';
                $this->displayPasien['pasien']['agama']['agamaDesc'] = '-';

                $this->displayPasien['pasien']['pendidikan']['pendidikanId'] = '-';
                $this->displayPasien['pasien']['pendidikan']['pendidikanDesc'] = '-';

                $this->displayPasien['pasien']['pekerjaan']['pekerjaanId'] = '-';
                $this->displayPasien['pasien']['pekerjaan']['pekerjaanDesc'] = '-';


                $this->displayPasien['pasien']['hubungan']['namaPenanggungJawab'] = '-';
                $this->displayPasien['pasien']['hubungan']['namaIbu'] = '-';

                $this->displayPasien['pasien']['identitas']['nik'] = '-';
                $this->displayPasien['pasien']['identitas']['idBpjs'] = '-';


                $this->displayPasien['pasien']['identitas']['alamat'] = '-';

                $this->displayPasien['pasien']['identitas']['desaId'] = '-';
                $this->displayPasien['pasien']['identitas']['desaName'] = '-';

                $this->displayPasien['pasien']['identitas']['rt'] = '-';
                $this->displayPasien['pasien']['identitas']['rw'] = '-';
                $this->displayPasien['pasien']['identitas']['kecamatanId'] = '-';
                $this->displayPasien['pasien']['identitas']['kecamatanName'] = '-';

                $this->displayPasien['pasien']['identitas']['kotaId'] = '-';
                $this->displayPasien['pasien']['identitas']['kotaName'] = '-';

                $this->displayPasien['pasien']['identitas']['propinsiId'] = '-';
                $this->displayPasien['pasien']['identitas']['propinsiName'] = '-';

                $this->displayPasien['pasien']['kontak']['nomerTelponSelulerPasien'] = '-';

                $this->displayPasien['pasien']['hubungan']['namaPenanggungJawab'] = '-';
                $this->displayPasien['pasien']['hubungan']['namaIbu'] = '-';
            }
        } else {
            // ubah data Pasien
            $this->displayPasien = json_decode($findData->meta_data_pasien_json, true);
            // replace thn to age
            $this->displayPasien['pasien']['thn'] = Carbon::createFromFormat('d/m/Y', $this->displayPasien['pasien']['tglLahir'])->diff(Carbon::now())->format('%y Thn, %m Bln %d Hr'); //$findData->thn;
        }
    }

    private function caridisplayPasienByKeyCollection($key, $search)
    {
        $findData = DB::table('rsmst_pasiens')
            ->select(
                DB::raw("to_char(reg_date,'dd/mm/yyyy hh24:mi:ss') as reg_date"),
                DB::raw("to_char(reg_date,'yyyymmddhh24miss') as reg_date1"),
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
                'rsmst_religions.rel_id as rel_id',
                'rel_desc',
                'rsmst_educations.edu_id as edu_id',
                'edu_desc',
                'rsmst_jobs.job_id as job_id',
                'job_name',
                'kk',
                'nyonya',
                'no_kk',
                'address',
                'rsmst_desas.des_id as des_id',
                'des_name',
                'rt',
                'rw',
                'rsmst_kecamatans.kec_id as kec_id',
                'kec_name',
                'rsmst_kabupatens.kab_id as kab_id',
                'kab_name',
                'rsmst_propinsis.prop_id as prop_id',
                'prop_name',
                'phone'
            )->join('rsmst_religions', 'rsmst_religions.rel_id', 'rsmst_pasiens.rel_id')
            ->join('rsmst_educations', 'rsmst_educations.edu_id', 'rsmst_pasiens.edu_id')
            ->join('rsmst_jobs', 'rsmst_jobs.job_id', 'rsmst_pasiens.job_id')
            ->join('rsmst_desas', 'rsmst_desas.des_id', 'rsmst_pasiens.des_id')
            ->join('rsmst_kecamatans', 'rsmst_kecamatans.kec_id', 'rsmst_pasiens.kec_id')
            ->join('rsmst_kabupatens', 'rsmst_kabupatens.kab_id', 'rsmst_pasiens.kab_id')
            ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_pasiens.prop_id')
            ->where($key, $search)
            ->first();
        return $findData;
    }

    public function mount()
    {
        $this->findData($this->regNoRef);
    }

    public function render()
    {
        return view('livewire.component.display-pasien.display-pasien');
    }
}
