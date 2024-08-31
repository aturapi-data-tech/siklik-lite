<?php

namespace App\Http\Traits\EmrRJ;


// use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
// use Spatie\ArrayToXml\ArrayToXml;

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

            $dataPasienRJ = [
                "regNo" => $dataPasienRJ->reg_no,
                "regName" => $dataPasienRJ->reg_name,
                "patientUuid" => $dataPasienRJ->patient_uuid,
                "drUuid" => $dataPasienRJ->dr_uuid,
                "drName" => $dataPasienRJ->dr_name,
                "poliUuid" => $dataPasienRJ->poli_uuid,
                "poliDesc" => $dataPasienRJ->poli_desc,

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
                ],

                "errorMessages" => $e->getMessage()
            ];
        }
    }

    protected  function checkRJStatus($rjNo): bool
    {
        $lastInserted = DB::table('rstxn_rjhdrs')
            ->select('rj_status')
            ->where('rj_no', '=', $rjNo)
            ->first();

        if ($lastInserted->rj_status !== 'A') {
            return true;
        }
        return false;
    }

    public static function updateJsonRJ($rjNo, array $rjArr): void
    {
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'datadaftarpolirj_json' => json_encode($rjArr, true),
                // 'datadaftarpolirj_xml' => ArrayToXml::convert($rjArr),
            ]);
    }
}
