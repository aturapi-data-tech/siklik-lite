<?php

namespace App\Http\Traits\EmrUGD;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;


trait EmrUGDTrait
{

    protected function findDataUGD($rjno): array
    {
        try {
            $findData = DB::table('rsview_ugdkasir')
                ->select('datadaftarugd_json', 'vno_sep')
                ->where('rj_no', '=', $rjno)
                ->first();

            $datadaftarugd_json = isset($findData->datadaftarugd_json) ? $findData->datadaftarugd_json : null;
            // if meta_data_pasien_json = null
            // then cari Data Pasien By Key Collection (exception when no data found)
            //
            // else json_decode
            if ($datadaftarugd_json) {
                $dataDaftarUgd = json_decode($findData->datadaftarugd_json, true);
            } else {

                $this->emit('toastr-error', "Data tidak dapat di proses json.");
                $dataDaftarUgd = DB::table('rsview_ugdkasir')
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
                        // 'poli_desc',
                        'dr_id',
                        'dr_name',
                        'klaim_id',
                        'entry_id',
                        'shift',
                        'vno_sep',
                        'no_antrian',

                        'nobooking',
                        'push_antrian_bpjs_status',
                        'push_antrian_bpjs_json',
                        // 'kd_dr_bpjs',
                        // 'kd_poli_bpjs',
                        'rj_status',
                        'txn_status',
                        'erm_status',
                    )
                    ->where('rj_no', '=', $rjno)
                    ->first();

                $dataDaftarUgd = [
                    "regNo" => "" . $dataDaftarUgd->reg_no . "",

                    "drId" => "" . $dataDaftarUgd->dr_id . "",
                    "drDesc" => "" . $dataDaftarUgd->dr_name . "",

                    "poliId" => "" . $dataDaftarUgd->poli_id . "",
                    "klaimId" => "" . $dataDaftarUgd->klaim_id == 'JM' ? 'JM' : 'UM' . "",
                    // "poliDesc" => "" . $dataDaftarUgd->poli_desc . "",

                    // "kddrbpjs" => "" . $dataDaftarUgd->kd_dr_bpjs . "",
                    // "kdpolibpjs" => "" . $dataDaftarUgd->kd_poli_bpjs . "",

                    "rjDate" => "" . $dataDaftarUgd->rj_date . "",
                    "rjNo" => "" . $dataDaftarUgd->rj_no . "",
                    "shift" => "" . $dataDaftarUgd->shift . "",
                    "noAntrian" => "" . $dataDaftarUgd->no_antrian . "",
                    "noBooking" => "" . $dataDaftarUgd->nobooking . "",
                    "slCodeFrom" => "02",
                    "passStatus" => "",
                    "rjStatus" => "" . $dataDaftarUgd->rj_status . "",
                    "txnStatus" => "" . $dataDaftarUgd->txn_status . "",
                    "ermStatus" => "" . $dataDaftarUgd->erm_status . "",
                    "cekLab" => "0",
                    "kunjunganInternalStatus" => "0",
                    "noReferensi" => "" . $dataDaftarUgd->reg_no . "",
                    "postInap" => [],
                    "internal12" => "1",
                    "internal12Desc" => "Faskes Tingkat 1",
                    "internal12Options" => [
                        [
                            "internal12" => "1",
                            "internal12Desc" => "Faskes Tingkat 1"
                        ],
                        [
                            "internal12" => "2",
                            "internal12Desc" => "Faskes Tingkat 2 RS"
                        ]
                    ],
                    "kontrol12" => "1",
                    "kontrol12Desc" => "Faskes Tingkat 1",
                    "kontrol12Options" => [
                        [
                            "kontrol12" => "1",
                            "kontrol12Desc" => "Faskes Tingkat 1"
                        ],
                        [
                            "kontrol12" => "2",
                            "kontrol12Desc" => "Faskes Tingkat 2 RS"
                        ],
                    ],
                    "taskIdPelayanan" => [
                        "taskId1" => "",
                        "taskId2" => "",
                        "taskId3" => "" . $dataDaftarUgd->rj_date . "",
                        "taskId4" => "",
                        "taskId5" => "",
                        "taskId6" => "",
                        "taskId7" => "",
                        "taskId99" => "",
                    ],
                    'sep' => [
                        "noSep" => "" . $dataDaftarUgd->vno_sep . "",
                        "reqSep" => [],
                        "resSep" => [],
                    ]
                ];
            }

            return $dataDaftarUgd;
        } catch (Exception $e) {
            dd($e->getMessage());
            return ["errorMessages" => $e->getMessage()];
        }
    }

    protected function checkUGDStatus($rjNo): bool
    {
        $lastInserted = DB::table('rstxn_ugdhdrs')
            ->select('rj_status')
            ->where('rj_no', '=', $rjNo)
            ->first();

        if ($lastInserted->rj_status !== 'A') {
            return true;
        }
        return false;
    }
}
