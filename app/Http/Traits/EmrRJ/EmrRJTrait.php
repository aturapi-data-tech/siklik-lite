<?php

namespace App\Http\Traits\EmrRJ;


use Illuminate\Support\Facades\DB;
use Exception;

trait EmrRJTrait
{

    protected function findDataRJ($rjno): array
    {
        try {
            $findData = DB::table('rsview_rjkasir')
                ->select('datadaftarpolirj_json', 'vno_sep')
                ->where('rj_no', '=', $rjno)
                ->first();

            $datadaftarpolirj_json = isset($findData->datadaftarpolirj_json) ? $findData->datadaftarpolirj_json : null;
            // if meta_data_pasien_json = null
            // then cari Data Pasien By Key Collection (exception when no data found)
            //
            // else json_decode
            if ($datadaftarpolirj_json) {
                $dataDaftarRJ = json_decode($findData->datadaftarpolirj_json, true);
            } else {
                $dataDaftarRJ = DB::table('rsview_rjkasir')
                    ->select(
                        DB::raw("to_char(rj_date,'dd/mm/yyyy hh24:mi:ss') AS rj_date"),
                        DB::raw("to_char(rj_date,'yyyymmddhh24miss') AS rj_date1"),
                        'rj_no',
                        'reg_no',
                        'reg_name',
                        'sex',
                        'address',
                        'thn',
                        DB::raw("to_char(birth_date,'dd/mm/yyyy') AS birth_date"),
                        'poli_id',
                        'poli_desc',
                        'dr_id',
                        'dr_name',
                        'klaim_id',
                        // 'entry_id',
                        'shift',
                        'vno_sep',
                        'no_antrian',

                        'nobooking',
                        'kd_dr_bpjs',
                        'kd_poli_bpjs',
                        'rj_status',
                        'txn_status',
                        'erm_status',
                        'pass_status' //Pasien Baru Lama
                    )
                    ->where('rj_no', '=', $rjno)
                    ->first();

                $dataDaftarRJ = [
                    "rjNo" => $dataDaftarRJ->rj_no,
                    "rjDate" => $dataDaftarRJ->rj_date,
                    "shift" => $dataDaftarRJ->shift,
                    "noAntrian" => $dataDaftarRJ->no_antrian,
                    "noBooking" => $dataDaftarRJ->nobooking,
                    "passStatus" => $dataDaftarRJ->pass_status == 'N' ? true : false, //"Owe bukan Nol
                    "rjStatus" => $dataDaftarRJ->rj_status,
                    "txnStatus" => $dataDaftarRJ->txn_status,
                    "ermStatus" => $dataDaftarRJ->erm_status,
                    "cekLab" => "0",

                    "regNo" => $dataDaftarRJ->reg_no,

                    "drId" => $dataDaftarRJ->dr_id,
                    "drDesc" => $dataDaftarRJ->dr_name,

                    "poliId" => $dataDaftarRJ->poli_id,
                    "poliDesc" => $dataDaftarRJ->poli_desc,

                    "klaimId" => $dataDaftarRJ->klaim_id,
                    "klaimDesc" => $dataDaftarRJ->klaim_id == 'UM' ? 'UMUM' : 'BPJS',

                    "kddrbpjs" => $dataDaftarRJ->kd_dr_bpjs,
                    "kdpolibpjs" => $dataDaftarRJ->kd_poli_bpjs,


                    "taskIdPelayanan" => [
                        "taskId1" => "",
                        "taskId2" => "",
                        "taskId3" => $dataDaftarRJ->rj_date,
                        "taskId4" => "",
                        "taskId5" => "",
                        "taskId6" => "",
                        "taskId7" => "",
                        "taskId99" => "",
                    ]
                ];
            }


            // dataPasienRJ
            $dataPasienRJ = DB::table('rsview_rjkasir')
                ->select(
                    'reg_no',
                    'reg_name',
                    'sex',
                    'address',
                    'patient_uuid',

                    'dr_id',
                    'dr_name',
                    'dr_uuid',

                    'poli_id',
                    'poli_desc',
                    'poli_uuid',

                    'nobooking',
                    'kd_dr_bpjs',
                    'kd_poli_bpjs',
                )
                ->where('rj_no', '=', $rjno)
                ->first();

            $dataPasien = DB::table('rsmst_pasiens')
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
                ->where('reg_no', $dataPasienRJ->reg_no)
                ->first();

            $dataPasienRJ = [
                "regNo" => $dataPasien->reg_no,
                "regName" => $dataPasien->reg_name,
                "patientUuid" => $dataPasienRJ->patient_uuid,
                "drUuid" => $dataPasienRJ->dr_uuid,
                "drName" => $dataPasienRJ->dr_name,
                "poliUuid" => $dataPasienRJ->poli_uuid,
                "poliDesc" => $dataPasienRJ->poli_desc,
                "nik" => $dataPasien->nik_bpjs,
                "address" => $dataPasien->address,
                "desa" => $dataPasien->des_name,
                "kecamatan" => $dataPasien->kec_name,
            ];


            return ([
                "dataDaftarRJ" => $dataDaftarRJ,
                "dataPasienRJ" => $dataPasienRJ
            ]);
        } catch (Exception $e) {

            // dd($e->getMessage());
            return [
                "dataDaftarRJ" => [
                    "rjNo" => "",
                    "rjDate" => "",
                    "shift" => "",
                    "noAntrian" => "",
                    "noBooking" => "",
                    "passStatus" => "",
                    "rjStatus" => "",
                    "txnStatus" => "",
                    "ermStatus" => "",
                    "cekLab" => "",

                    "regNo" => "",

                    "drId" => "",
                    "drDesc" => "",

                    "poliId" => "",
                    "poliDesc" => "",

                    "klaimId" => "",
                    "klaimDesc" => "",

                    "kddrbpjs" => "",
                    "kdpolibpjs" => "",


                    "taskIdPelayanan" => [
                        "taskId1" => "",
                        "taskId2" => "",
                        "taskId3" => "",
                        "taskId4" => "",
                        "taskId5" => "",
                        "taskId6" => "",
                        "taskId7" => "",
                        "taskId99" => "",
                    ]
                ],
                "dataPasienRJ" => [
                    "regNo" => "",
                    "regName" => "",
                    "patientUuid" => "",
                    "drUuid" => "",
                    "drName" => "",
                    "poliUuid" => "",
                    "poliDesc" => "",
                    "nik" => "",
                    "address" => "",
                    "desa" => "",
                    "kecamatan" => "",
                ],

                "errorMessages" => $e->getMessage()
            ];
        }
    }

    public function checkRjStatus($rjNo): bool
    {
        $row = DB::table('rstxn_rjhdrs')
            ->select('rj_status')
            ->where('rj_no', $rjNo)
            ->first();

        if (!$row || $row->rj_status !== 'A') {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Pasien Sudah Pulang, Transaksi Terkunci.');
            return false;
        }
        return true;
    }



    public static function updateJsonRJ(string $rjNo, array $rjArr): void
    {
        // Ambil rjNo dari array JSON
        $rjNoJson = $rjArr['rjNo'] ?? null;

        // Cek apakah field rjNo ada
        if (is_null($rjNoJson)) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError("Field 'rjNo' tidak ditemukan pada data JSON.");
            return;
        }

        // Cek kesesuaian nomor RJ
        if ((int) $rjNo !== (int) $rjNoJson) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError("Nomor RJ tidak sesuai. Parameter: {$rjNo} / JSON: {$rjNoJson}");
            return;
        }

        // Cek apakah record-nya benar-benar ada di DB
        $exists = DB::table('rstxn_rjhdrs')->where('rj_no', $rjNo)->exists();
        if (!$exists) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError("Data RJ dengan nomor {$rjNo} tidak ditemukan di tabel rstxn_rjhdrs.");
            return;
        }



        // Update ke tabel
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'datadaftarpolirj_json' => json_encode($rjArr, JSON_UNESCAPED_UNICODE),
            ]);
    }
}
