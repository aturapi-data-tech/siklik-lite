<?php

namespace App\Http\Livewire\EmrRJ\MrRJ\Penilaian;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use Spatie\ArrayToXml\ArrayToXml;


class Penilaian extends Component
{
    use WithPagination;
    // listener from blade////////////////
    protected $listeners = [
        'syncronizeAssessmentPerawatRJFindData' => 'mount'

    ];

    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef;

    // dataDaftarPoliRJ RJ
    public array $dataDaftarPoliRJ = [];

    // data penilaian=>[] 
    public array $penilaian =
    [
        "fisikTab" => "Fisik",
        "fisik" => [
            "fisik" => ""
        ],

        // "statusMedikTab" => "Status Medik",
        // "statusMedik" => [
        //     "statusMedik" => "",
        //     "statusMedikOptions" => [
        //         ["statusMedik" => "Emergency Trauma"],
        //         ["statusMedik" => "Emergency Non Trauma"],
        //         ["statusMedik" => "Non Emergency Trauma"],
        //         ["statusMedik" => "Non Emergency Non Trauma"],
        //     ]
        // ],

        "nyeriTab" => "Nyeri",
        "nyeri" => [
            "vas" => [
                "vas" => "",
                "vasOptions" => [
                    ["vas" => "0"],
                    ["vas" => "1"],
                    ["vas" => "2"],
                    ["vas" => "3"],
                    ["vas" => "4"],
                    ["vas" => "5"],
                    ["vas" => "6"],
                    ["vas" => "7"],
                    ["vas" => "8"],
                    ["vas" => "9"],
                    ["vas" => "10"],
                ]

            ],
            "nyeri" => "",
            "nyeriOptions" => [
                ["nyeri" => "Ya"],
                ["nyeri" => "Tidak"],
            ],
            "nyeriKet" => "",
            "nyeriKetOptions" => [
                ["nyeriKet" => "Akut"],
                ["nyeriKet" => "Kronis"],
            ],
            "skalaNyeri" => "",
            "nyeriMetode" => "",
            "nyeriMetodeOptions" => [
                ["nyeriMetode" => "NRS"],
                ["nyeriMetode" => "BPS"],
                ["nyeriMetode" => "NIPS"],
                ["nyeriMetode" => "FLACC"],
                ["nyeriMetode" => "VAS"],
            ],
            "pencetus" => "",
            "gambar" => "",
            "durasi" => "",
            "lokasi" => "",
        ],

        "statusPediatrikTab" => "Status Pediatrik",
        "statusPediatrik" => [
            "statusPediatrik" => "",
            "statusPediatrikOptions" => [
                ["statusPediatrik" => "Gizi Kurang"],
                ["statusPediatrik" => "Gizi Cukup"],
                ["statusPediatrik" => "Gizi Lebih"],
            ]
        ],

        "diagnosisTab" => "Diagnosis",
        "diagnosis" => [
            "diagnosis" => "",
        ],

        "resikoJatuhTab" => "Resiko Jatuh",
        "resikoJatuh" => [
            "skalaMorse" => [
                "skalaMorseTab" => "Skala Morse Score",
                "skalaMorseScore" => 0,
                "skalaMorseDesc" => "",


                "riwayatJatuh3blnTerakhir" => "",
                "riwayatJatuh3blnTerakhirScore" => 0,
                "riwayatJatuh3blnTerakhirOptions" => [
                    ["riwayatJatuh3blnTerakhir" => "Ya", "score" => 25],
                    ["riwayatJatuh3blnTerakhir" => "Tidak", "score" => 0],
                ],
                "diagSekunder" => "",
                "diagSekunderScore" => 0,
                "diagSekunderOptions" => [
                    ["diagSekunder" => "Ya", "score" => 15],
                    ["diagSekunder" => "Tidak", "score" => 0],
                ],
                "alatBantu" => "",
                "alatBantuScore" => 0,
                "alatBantuOptions" => [
                    ["alatBantu" => "Tidak Ada / Bed Rest", "score" => 0],
                    ["alatBantu" => "Tongkat / Alat Penopang / Walker", "score" => 15],
                    ["alatBantu" => "Furnitur", "score" => 30],

                ],
                "heparin" => "",
                "heparinScore" => 0,
                "heparinOptions" => [
                    ["heparin" => "Ya", "score" => 20],
                    ["heparin" => "Tidak", "score" => 0],
                ],
                "gayaBerjalan" => "",
                "gayaBerjalanScore" => 0,
                "gayaBerjalanOptions" => [
                    ["gayaBerjalan" => "Normal / Tirah Baring / Tidak Bergerak", "score" => 0],
                    ["gayaBerjalan" => "Lemah", "score" => 10],
                    ["gayaBerjalan" => "Terganggu", "score" => 20],
                ],
                "kesadaran" => "",
                "kesadaranScore" => 0,
                "kesadaranOptions" => [
                    ["kesadaran" => "Baik", "score" => 0],
                    ["kesadaran" => "Lupa / Pelupa", "score" => 15],
                ],
            ],

            "skalaHumptyDumpty" => [
                "skalaHumptyDumptyTab" => "Skala Humpty Dumpty Score",
                "skalaHumptyDumptyScore" => 0,
                "skalaHumptyDumptyDesc" => "",

                "umur" => "",
                "umurScore" => 0,
                "umurOptions" => [
                    ["umur" => "< 3 tahun", "score" => 4],
                    ["umur" => "3-7 tahun", "score" => 3],
                    ["umur" => "7-13 tahun", "score" => 2],
                    ["umur" => "13-18 tahun", "score" => 1],

                ],

                "sex" => "",
                "sexScore" => 0,
                "sexOptions" => [
                    ["sex" => "Laki-laki", "score" => 2],
                    ["sex" => "Perempuan", "score" => 1],
                ],

                "diagnosa" => "",
                "diagnosaScore" => 0,
                "diagnosaOptions" => [
                    ["diagnosa" => "Kelainan Neurologi", "score" => 4],
                    ["diagnosa" => "Perubahan dalam Oksigenasi (Masalah Saluran Nafas, Dehidrasi, Anemia, Anoreksi, Slokop/sakit kepala, dll)", "score" => 3],
                    ["diagnosa" => "Kelamin Priksi/Perilaku", "score" => 2],
                    ["diagnosa" => "Diagnosa Lain", "score" => 1],
                ],
                "gangguanKognitif" => "",
                "gangguanKognitifScore" => 0,
                "gangguanKognitifOptions" => [
                    ["gangguanKognitif" => "Tidak Sadar terhadap Keterbatasan", "score" => 3],
                    ["gangguanKognitif" => "Lupa keterbatasan", "score" => 2],
                    ["gangguanKognitif" => "Mengetahui Kemampuan Diri", "score" => 1],
                ],
                "faktorLingkungan" => "",
                "faktorLingkunganScore" => 0,
                "faktorLingkunganOptions" => [
                    ["faktorLingkungan" => "Riwayat jatuh dari tempat tidur saat bayi anak", "score" => 4],
                    ["faktorLingkungan" => "Pasien menggunakan alat bantu box atau mobel", "score" => 3],
                    ["faktorLingkungan" => "Pasien berada ditempat tidur", "score" => 2],
                    ["faktorLingkungan" => "Diluar ruang rawat", "score" => 1],
                ],
                "penggunaanObat" => "",
                "penggunaanObatScore" => 0,
                "penggunaanObatOptions" => [
                    ["penggunaanObat" => "Bermacam-macam obat yang digunakan: obat sedarif (kecuali pasien ICU yang menggunakan sedasi dan paralisis), Hipnotik, Barbiturat, Fenotiazin, Antidepresan, Laksans/Diuretika,Narketik", "score" => 3],
                    ["penggunaanObat" => "Salah satu pengobatan diatas", "score" => 2],
                    ["penggunaanObat" => "Pengobatan lain", "score" => 1],
                ],
                "responTerhadapOperasi" => "",
                "responTerhadapOperasiScore" => 0,
                "responTerhadapOperasiOptions" => [
                    ["responTerhadapOperasi" => "Dalam 24 Jam", "score" => 3],
                    ["responTerhadapOperasi" => "Dalam 48 jam riwayat jatuh", "score" => 2],
                    ["responTerhadapOperasi" => "> 48 jam", "score" => 1],
                ],
            ],

            "edmonson" => [
                "edmonsonTab" => "Edmonson Psychiatric Fall Risk Assesment",
                "edmonsonScore" => "",
                "edmonsonUsia" => "< 50 Tahun",

                "statusMental" => "",
                "statusMentalOptions" => [
                    ["statusMental" => "Sadar penuh dan orientasi waktu baik"],
                    ["statusMental" => "Agitasi / Cemas"],
                    ["statusMental" => "Sering bingung"],
                    ["statusMental" => "Bingung dan disorientasi"],
                ],

                "eliminasi" => "",
                "eliminasiOptions" => [
                    ["eliminasi" => "Mandiri untuk BAB dan BAK"],
                    ["eliminasi" => "Memakai Kateter / Ostomy"],
                    ["eliminasi" => "BAB dan BAK dengan bantuan"],
                    ["eliminasi" => "Gangguan eliminasi (inkontinensia, banyak BAK di malam hari, sering BAB dan BAK)"],
                    ["eliminasi" => "Inkontinensia tetapi bisa ambulasi mandiri"],
                ],

                "medikasi" => "",
                "medikasiOptions" => [
                    ["medikasi" => "Tidak ada pengobatan yang diberikan"],
                    ["medikasi" => "Obat-obatan jantung"],
                    ["medikasi" => "Obat psikiatri termasuk benzodiazepin dan anti depresan"],
                    ["medikasi" => "Meningkatnya dosis obat yang dikonsumsi / ditambahkan dalam 24 jam terakhir"],
                ],

                "diagnosis" => "",
                "diagnosisOptions" => [
                    ["diagnosis" => "Bipolar / gangguan scizo affective"],
                    ["diagnosis" => "Penyalahgunaan zat terlarang dan alkohol"],
                    ["diagnosis" => "Gangguan depresi mayor"],
                    ["diagnosis" => "Dimensia / Delirium"],
                ],

                "ambulasi" => "",
                "ambulasiOptions" => [
                    ["ambulasi" => "Ambulasi mandiri dan langkah stabil atau pasien imobil"],
                    ["ambulasi" => "Penggunaan alat bantu yang tepat (tongkat, walker, tripod, dll)"],
                    ["ambulasi" => "Vertigo / Hipotensi Ortostatik / Kelemahan"],
                    ["ambulasi" => "Langkah tidak stabil, butuh bantuan dan menyadari kemampuannya"],
                ],

                "nutrisi" => "",
                "nutrisiOptions" => [
                    ["nutrisi" => "Hanya sedikit mendapatkan asupan makanan / minum dalam 24 jam terakhir"],
                    ["nutrisi" => "Nafsu makan baik"],
                ],

                "ganguanTidur" => "",
                "ganguanTidurOptions" => [
                    ["ganguanTidur" => "Tidak ada gangguan tidur"],
                    ["ganguanTidur" => "Ada gangguan tidur yang dilaporkan keluarga pasien / staf"],
                ],

                "riwayatJatuh" => "",
                "riwayatJatuhOptions" => [
                    ["riwayatJatuh" => "Tidak ada riwayat jatuh"],
                    ["riwayatJatuh" => "Ada riwayat jatuh dalam 3 bulan terakhir"],
                ],


                "faktorLingkungan" => "",
                "faktorLingkunganOptions" => [
                    ["faktorLingkungan" => "Riwayat jatuh dari tempat tidur saat bayi anak"],
                    ["faktorLingkungan" => "Pasien menggunakan alat bantu box atau mobel"],
                    ["faktorLingkungan" => "Pasien berada ditempat tidur"],
                    ["faktorLingkungan" => "Diluar ruang rawat"],
                ],
                "penggunaanObat" => "",
                "penggunaanObatOptions" => [
                    ["penggunaanObat" => "Bermacam-macam obat yang digunakan: obat sedarif (kecuali pasien ICU yang menggunakan sedasi dan paralisis), Hipnotik, Barbiturat, Fenotiazin, Antidepresan, Laksans/Diuretika,Narketik"],
                    ["penggunaanObat" => "Salah satu pengobatan diatas"],
                    ["penggunaanObat" => "Pengobatan lain"],
                ],
                "responTerhadapOperasi" => "",
                "responTerhadapOperasiOptions" => [
                    ["responTerhadapOperasi" => "Dalam 24 Jam"],
                    ["responTerhadapOperasi" => "Dalam 48 jam riwayat jatuh"],
                    ["responTerhadapOperasi" => "> 48 jam"],
                ],
            ],

        ],

        "dekubitus" => [
            "dekubitusTab" => "Dekubitus",
            "kodisiFisik" => "",
            "kodisiFisikOptions" => [
                ["kodisiFisik" => "Baik"],
                ["kodisiFisik" => "Lumayan"],
                ["kodisiFisik" => "Buruk"],
                ["kodisiFisik" => "Sangat Buruk"],
            ],

            "kesadaran" => "",
            "kesadaranOptions" => [
                ["kesadaran" => "Kompos Mentis"],
                ["kesadaran" => "Apatis"],
                ["kesadaran" => "Konfus/Soporis"],
                ["kesadaran" => "Stupor/Koma"],
            ],

            "aktifitas" => "",
            "aktifitasOptions" => [
                ["aktifitas" => "Dapat Berpindah"],
                ["aktifitas" => "Berjalan Dengan Bantuan"],
                ["aktifitas" => "Terbatas di Kursi"],
                ["aktifitas" => "Terbatas di Tempat Tidur"],
            ],

            "mobilitas" => "",
            "mobilitasOptions" => [
                ["mobilitas" => "Bergerak Bebas"],
                ["mobilitas" => "Sedikit Terbatas"],
                ["mobilitas" => "Sangat Terbatas"],
                ["mobilitas" => "Tak Bisa Bergerak"],
            ],

            "inkontinensia" => "",
            "inkontinensiaOptions" => [
                ["inkontinensia" => "Tidak Ngompol"],
                ["inkontinensia" => "Kadang-kadang"],
                ["inkontinensia" => "Sering Inkontinensia Urin"],
                ["inkontinensia" => "Sering Inkontinensia Alvi dan Urin"],
            ],
        ],
    ];
    //////////////////////////////////////////////////////////////////////



    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////


    public function updated($propertyName)
    {
        // dd($propertyName);
        // $this->validateOnly($propertyName);
        $this->scoringSkalaMorse();
        $this->scoringSkalaHumptyDumpty();
        $this->store();
    }



    // ////////////////
    // RJ Logic
    // ////////////////


    // validate Data RJ//////////////////////////////////////////////////
    private function validateDataRJ(): void
    {
        // customErrorMessages
        // $messages = customErrorMessagesTrait::messages();

        // require nik ketika pasien tidak dikenal



        // $rules = [];



        // Proses Validasi///////////////////////////////////////////
        // try {
        //     $this->validate($rules, $messages);
        // } catch (\Illuminate\Validation\ValidationException $e) {

        //     $this->emit('toastr-error', "Lakukan Pengecekan kembali Input Data.");
        //     $this->validate($rules, $messages);
        // }
    }


    // insert and update record start////////////////
    public function store()
    {
        // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
        $this->setDataPrimer();

        // Validate RJ
        $this->validateDataRJ();

        // Logic update mode start //////////
        $this->updateDataRJ($this->dataDaftarPoliRJ['rjNo']);
        $this->emit('syncronizeAssessmentPerawatRJFindData');
    }

    private function updateDataRJ($rjNo): void
    {

        // update table trnsaksi
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'dataDaftarPoliRJ_json' => json_encode($this->dataDaftarPoliRJ, true),
                'dataDaftarPoliRJ_xml' => ArrayToXml::convert($this->dataDaftarPoliRJ),
            ]);

        $this->emit('toastr-success', "Penilaian Fisik berhasil disimpan.");
    }
    // insert and update record end////////////////


    private function findData($rjno): void
    {


        $findData = DB::table('rsview_rjkasir')
            ->select('datadaftarpolirj_json', 'vno_sep')
            ->where('rj_no', $rjno)
            ->first();

        $dataDaftarPoliRJ_json = isset($findData->datadaftarpolirj_json) ? $findData->datadaftarpolirj_json   : null;
        // if meta_data_pasien_json = null
        // then cari Data Pasien By Key Collection (exception when no data found)
        // 
        // else json_decode
        if ($dataDaftarPoliRJ_json) {
            $this->dataDaftarPoliRJ = json_decode($findData->datadaftarpolirj_json, true);

            // jika penilaian tidak ditemukan tambah variable penilaian pda array
            if (isset($this->dataDaftarPoliRJ['penilaian']) == false) {
                $this->dataDaftarPoliRJ['penilaian'] = $this->penilaian;
            }
        } else {

            $this->emit('toastr-error', "Data tidak dapat di proses json.");
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
                    // 'entry_id',
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
                "regNo" =>  $dataDaftarPoliRJ->reg_no,

                "drId" =>  $dataDaftarPoliRJ->dr_id,
                "drDesc" =>  $dataDaftarPoliRJ->dr_name,

                "poliId" =>  $dataDaftarPoliRJ->poli_id,
                "klaimId" => $dataDaftarPoliRJ->klaim_id,
                "poliDesc" =>  $dataDaftarPoliRJ->poli_desc,

                "kddrbpjs" =>  $dataDaftarPoliRJ->kd_dr_bpjs,
                "kdpolibpjs" =>  $dataDaftarPoliRJ->kd_poli_bpjs,

                "rjDate" =>  $dataDaftarPoliRJ->rj_date,
                "rjNo" =>  $dataDaftarPoliRJ->rj_no,
                "shift" =>  $dataDaftarPoliRJ->shift,
                "noAntrian" =>  $dataDaftarPoliRJ->no_antrian,
                "noBooking" =>  $dataDaftarPoliRJ->nobooking,
                "slCodeFrom" => "02",
                "passStatus" => "",
                "rjStatus" =>  $dataDaftarPoliRJ->rj_status,
                "txnStatus" =>  $dataDaftarPoliRJ->txn_status,
                "ermStatus" =>  $dataDaftarPoliRJ->erm_status,
                "cekLab" => "0",
                "kunjunganInternalStatus" => "0",
                "noReferensi" =>  $dataDaftarPoliRJ->reg_no,
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
                    "taskId3" =>  $dataDaftarPoliRJ->rj_date,
                    "taskId4" => "",
                    "taskId5" => "",
                    "taskId6" => "",
                    "taskId7" => "",
                    "taskId99" => "",
                ],
                'sep' => [
                    "noSep" =>  $dataDaftarPoliRJ->vno_sep,
                    "reqSep" => [],
                    "resSep" => [],
                ]
            ];


            // jika penilaian tidak ditemukan tambah variable penilaian pda array
            if (isset($this->dataDaftarPoliRJ['penilaian']) == false) {
                $this->dataDaftarPoliRJ['penilaian'] = $this->penilaian;
            }
        }
    }

    // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
    private function setDataPrimer(): void
    {
    }

    private function scoringSkalaMorse(): void
    {
        $riwayatJatuh3blnTerakhirScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['riwayatJatuh3blnTerakhirScore'];
        $diagSekunderScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['diagSekunderScore'];
        $alatBantuScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['alatBantuScore'];
        $heparinScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['heparinScore'];
        $gayaBerjalanScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['gayaBerjalanScore'];
        $kesadaranScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['kesadaranScore'];

        $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseScore'] = $riwayatJatuh3blnTerakhirScore + $diagSekunderScore  + $alatBantuScore + $heparinScore + $gayaBerjalanScore + $kesadaranScore;
        $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseDesc'] =
            ($this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseScore'] >= 0
                && $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseScore'] <= 24
                ? 'Tidak Ada Risiko'
                : ($this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseScore'] >= 25
                    && $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseScore'] <= 50
                    ? 'Risiko Rendah'
                    : 'Risiko Tinggi'));
    }

    private function scoringSkalaHumptyDumpty(): void
    {
        $umurScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['umurScore'];
        $sexScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['sexScore'];
        $diagnosaScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['diagnosaScore'];
        $gangguanKognitifScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['gangguanKognitifScore'];
        $faktorLingkunganScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['faktorLingkunganScore'];
        $penggunaanObatScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['penggunaanObatScore'];
        $responTerhadapOperasiScore = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['responTerhadapOperasiScore'];

        $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyScore'] = $umurScore + $sexScore  + $diagnosaScore + $gangguanKognitifScore + $faktorLingkunganScore + $penggunaanObatScore +
            $responTerhadapOperasiScore;
        $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyDesc'] =
            ($this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyScore'] >= 0
                && $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyScore'] <= 11
                ? 'Risiko Rendah'
                : ($this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyScore'] >= 12
                    && $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyScore'] <= 12
                    ? 'Risiko Tinggi'
                    : 'Risiko Tinggi'));
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
            'livewire.emr-r-j.mr-r-j.penilaian.penilaian',
            [
                // 'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Penilaian',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
            ]
        );
    }
    // select data end////////////////


}
