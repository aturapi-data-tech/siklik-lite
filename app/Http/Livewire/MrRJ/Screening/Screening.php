<?php

namespace App\Http\Livewire\MrRJ\Screening;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use Spatie\ArrayToXml\ArrayToXml;


class Screening extends Component
{
    use WithPagination;


    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef = '430268';



    // dataDaftarPoliRJ RJ
    public $dataDaftarPoliRJ = [];

    // data screening / kesimpulan=>[] 
    public $screeningQuestions = [
        [
            "sc_seq" => "1",
            "sc_desc" => "Apakah Pasien Sadar?",
            "active_status" => "1",
            "sc_score" => 1,
            "sc_value" => 1,
            "sc_option" =>
            [
                [
                    "option_label" => "Sadar Penuh",
                    "option_value" => 1,
                    "option_score" => 1
                ],
                [
                    "option_label" => "Tampak (Mengantuk / Gelisah / Bicara Tida Jelas)",
                    "option_value" => 2,
                    "option_score" => 2
                ],
                [
                    "option_label" => "Tidak Sadar",
                    "option_value" => 3,
                    "option_score" => 3
                ]
            ],


        ],
        [
            "sc_seq" => "2",
            "sc_desc" => "Apakah Pasien Merasa Sesak Nafas?",
            "active_status" => "1",
            "sc_score" => 1,
            "sc_value" => 1,
            "sc_option" =>
            [
                [
                    "option_label" => "Nafas Normal",
                    "option_value" => 1,
                    "option_score" => 1
                ],
                [
                    "option_label" => "Tampak (Sesak)",
                    "option_value" => 2,
                    "option_score" => 2
                ],
                [
                    "option_label" => "Tidak Bernafas",
                    "option_value" => 3,
                    "option_score" => 3
                ]
            ],


        ],
        [
            "sc_seq" => "3",
            "sc_desc" => "Apakah Pasien Beresiko Jatuh?",
            "active_status" => "1",
            "sc_score" => 1,
            "sc_value" => 1,
            "sc_option" =>
            [
                [
                    "option_label" => "Resiko Rendah",
                    "option_value" => 1,
                    "option_score" => 1
                ],
                [
                    "option_label" => "Resiko (Sedang)",
                    "option_value" => 2,
                    "option_score" => 2
                ],
                [
                    "option_label" => "Resiko Tinggi",
                    "option_value" => 3,
                    "option_score" => 3
                ]
            ],


        ],
        [
            "sc_seq" => "4",
            "sc_desc" => "Apakah Pasien Nyeri Pada Dada?",
            "active_status" => "1",
            "sc_score" => 1,
            "sc_value" => 1,
            "sc_option" =>
            [
                [
                    "option_label" => "Tidak Ada",
                    "option_value" => 1,
                    "option_score" => 1
                ],
                [
                    "option_label" => "Ada (Tingkat Rendah)",
                    "option_value" => 2,
                    "option_score" => 2
                ],
                [
                    "option_label" => "Nyeri Dada Kiri Tembis Punggung",
                    "option_value" => 3,
                    "option_score" => 3
                ]
            ],


        ],
        [
            "sc_seq" => "5",
            "sc_desc" => "Apakah Pasien Batuk?",
            "active_status" => "1",
            "sc_score" => 1,
            "sc_value" => 1,
            "sc_option" =>
            [
                [
                    "option_label" => "Tidak Ada",
                    "option_value" => 1,
                    "option_score" => 1
                ],
                [
                    "option_label" => "Batuk < 2 Minggu",
                    "option_value" => 2,
                    "option_score" => 2
                ],
                [
                    "option_label" => "Batuk > 2 Minggu",
                    "option_value" => 3,
                    "option_score" => 3
                ]
            ],


        ],
        [
            "sc_seq" => "2",
            "sc_desc" => "Tingkat Nyeri Pasien",
            "active_status" => "1",
            "sc_score" => 0,
            "sc_value" => 0,
            "sc_image" => "pain_scale_level.jpg",
            "sc_option" =>
            [
                [
                    "option_label" => "0 (Tidak Nyeri)",
                    "option_value" => 0,
                    "option_score" => 0
                ],
                [
                    "option_label" => "1-3 (Sedikit Nyeri)",
                    "option_value" => 1,
                    "option_score" => 1
                ],
                [
                    "option_label" => "4-7 (Nyeri)",
                    "option_value" => 2,
                    "option_score" => 2
                ],
                [
                    "option_label" => "8-10 (Sangat Nyeri)",
                    "option_value" => 3,
                    "option_score" => 3
                ],

            ],


        ],
    ];

    public $screeningKesimpulan = [
        "sck_value" => 1,
        "sck_score" => 1,
        "sck_option" =>
        [
            [
                "option_id" => "1",
                "option_label" => "SESUAI ANTRIAN",
                "option_value" => 1,
                "option_score" => 1,
            ],
            [
                "option_id" => "2",
                "option_label" => "DISEGERAKAN",
                "option_value" => 2,
                "option_score" => 2,
            ],
            [
                "option_id" => "3",
                "option_label" => "IGD",
                "option_value" => 3,
                "option_score" => 3,
            ],
        ]
    ];

    //////////////////////////////////////




    // listener from blade////////////////
    protected $listeners = [
        'xxxxx' => 'xxxxx',
    ];



    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////





    // resert input private////////////////
    private function resetInputFields(): void
    {

        // resert validation
        $this->resetValidation();
        // resert input kecuali
        $this->resetExcept([
            'rjNoRef'
        ]);
    }



    // ////////////////
    // screening Logic
    // ////////////////




    // insert and update record start////////////////
    public function store()
    {
        $this->updateDataRJ($this->dataDaftarPoliRJ['rjNo']);
    }

    private function updateDataRJ($rjNo): void
    {

        // update table trnsaksi
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'datadaftarpolirj_json' => json_encode($this->dataDaftarPoliRJ, true),
                'datadaftarpolirj_xml' => ArrayToXml::convert($this->dataDaftarPoliRJ),
            ]);

        $this->emit('toastr-success', "Screening " . $this->dataDaftarPoliRJ['regNo'] . " berhasil disimpan.");
    }
    // insert and update record end////////////////


    private function findData($rjno): void
    {
        $findData = DB::table('rsview_rjkasir')
            ->select('datadaftarpolirj_json')
            ->where('rj_no', $rjno)
            ->first();


        if ($findData->datadaftarpolirj_json) {
            $this->dataDaftarPoliRJ = json_decode($findData->datadaftarpolirj_json, true);

            // jika screening tidak ditemukan tambah variable kontrol pda array
            if (isset($this->dataDaftarPoliRJ['screening']) == false) {
                $this->dataDaftarPoliRJ['screening'] = $this->screeningQuestions;
            }

            // jika screeningKesimpulan tidak ditemukan tambah variable kontrol pda array
            if (isset($this->dataDaftarPoliRJ['screeningKesimpulan']) == false) {
                $this->dataDaftarPoliRJ['screeningKesimpulan'] = $this->screeningKesimpulan;
            }
        } else {

            $this->emit('toastr-error', "Json Tidak ditemukan, Data sedang diproses ulang.");
            $dataDaftarPoliRJ = DB::table('rsview_rjkasir')
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
                    'shift',
                    'vno_sep',
                    'no_antrian',

                    'nobooking',
                    'push_antrian_bpjs_status',
                    'push_antrian_bpjs_json',
                    'kd_dr_bpjs',
                    'kd_poli_bpjs',
                    'rj_status',
                    'txn_status',
                    'erm_status',
                )
                ->where('rj_no', '=', $rjno)
                ->first();

            $this->dataDaftarPoliRJ = [
                "regNo" => "" . $dataDaftarPoliRJ->reg_no . "",

                "drId" => "" . $dataDaftarPoliRJ->dr_id . "",
                "drDesc" => "" . $dataDaftarPoliRJ->dr_name . "",

                "poliId" => "" . $dataDaftarPoliRJ->poli_id . "",
                "poliDesc" => "" . $dataDaftarPoliRJ->poli_desc . "",

                "kddrbpjs" => "" . $dataDaftarPoliRJ->kd_dr_bpjs . "",
                "kdpolibpjs" => "" . $dataDaftarPoliRJ->kd_poli_bpjs . "",

                "rjDate" => "" . $dataDaftarPoliRJ->rj_date . "",
                "rjNo" => "" . $dataDaftarPoliRJ->rj_no . "",
                "shift" => "" . $dataDaftarPoliRJ->shift . "",
                "noAntrian" => "" . $dataDaftarPoliRJ->no_antrian . "",
                "noBooking" => "" . $dataDaftarPoliRJ->nobooking . "",
                "slCodeFrom" => "02",
                "passStatus" => "",
                "rjStatus" => "" . $dataDaftarPoliRJ->rj_status . "",
                "txnStatus" => "" . $dataDaftarPoliRJ->txn_status . "",
                "ermStatus" => "" . $dataDaftarPoliRJ->erm_status . "",
                "cekLab" => "0",
                "kunjunganInternalStatus" => "0",
                "noReferensi" => "" . $dataDaftarPoliRJ->reg_no . "",
                "taskIdPelayanan" => [
                    "taskId1" => "",
                    "taskId2" => "",
                    "taskId3" => "" . $dataDaftarPoliRJ->rj_date . "",
                    "taskId4" => "",
                    "taskId5" => "",
                    "taskId6" => "",
                    "taskId7" => "",
                    "taskId99" => "",
                ],
                'sep' => [
                    "noSep" => "" . $dataDaftarPoliRJ->vno_sep . "",
                    "reqSep" => [],
                    "resSep" => [],
                ]
            ];

            $this->dataDaftarPoliRJ['klaimId'] = $dataDaftarPoliRJ->klaim_id == 'JM' ? 'JM' : 'UM';
            $this->dataDaftarPoliRJ['JenisKlaimDesc'] = $dataDaftarPoliRJ->klaim_id == 'JM' ? 'BPJS' : 'UMUM';

            $this->dataDaftarPoliRJ['kunjunganId'] = '1';
            $this->dataDaftarPoliRJ['JenisKunjunganDesc'] = 'Rujukan FKTP';

            // jika screening tidak ditemukan tambah variable kontrol pda array
            if (isset($this->dataDaftarPoliRJ['screening']) == false) {
                $this->dataDaftarPoliRJ['screening'] = $this->screeningQuestions;
            }

            // jika screeningKesimpulan tidak ditemukan tambah variable kontrol pda array
            if (isset($this->dataDaftarPoliRJ['screeningKesimpulan']) == false) {
                $this->dataDaftarPoliRJ['screeningKesimpulan'] = $this->screeningKesimpulan;
            }
        }
    }


    // /prosesDataScreening/////////////
    public function prosesDataScreening($desc, $value, $score, $label, $key)
    {

        $this->dataDaftarPoliRJ['screening'][$key]['sc_value'] = $value;
        $this->dataDaftarPoliRJ['screening'][$key]['sc_score'] = $score;


        // update kesimpulan dari screening otomatis
        $KesimpulanDariScreening = $this->updateDataKesimpulanDariScreening() == 1
            ? 'Sesuai Antrian' : ($this->updateDataKesimpulanDariScreening() == 2
                ? 'Disegerakan' : 'IGD');

        // //////////////////////////////////////


        $this->emit('toastr-success', "$desc : $label Kesimpulan : $KesimpulanDariScreening");
    }

    // /prosesDataKesimpulan/////////////
    public function prosesDataKesimpulan($value, $label)
    {
        $this->dataDaftarPoliRJ['screeningKesimpulan']['sck_value'] = $value;
    }

    // /updateDataKesimpulanDariScreening/////////////
    private function updateDataKesimpulanDariScreening()
    {
        $KesimpulanDariScreening = collect($this->dataDaftarPoliRJ['screening'])
            ->pluck('sc_score')
            ->max();
        $this->dataDaftarPoliRJ['screeningKesimpulan']['sck_value'] = $KesimpulanDariScreening != 0 ? $KesimpulanDariScreening : 1;
        return ($KesimpulanDariScreening);
    }









    // when new form instance
    public function mount()
    {
        $this->findData($this->rjNoRef);
    }



    // select data start////////////////
    public function render()
    {

        return view(
            'livewire.mr-r-j.screening.screening',
            [
                'myTitle' => 'Screening Rawat Jalan',
                'mySnipt' => 'Rekam Medis',
                'myProgram' => 'Rawat Jalan',
            ]
        );
    }
}
