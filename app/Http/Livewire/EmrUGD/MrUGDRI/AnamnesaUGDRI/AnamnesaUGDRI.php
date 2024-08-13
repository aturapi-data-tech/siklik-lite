<?php

namespace App\Http\Livewire\EmrUGD\MrUGDRI\AnamnesaUGDRI;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use Spatie\ArrayToXml\ArrayToXml;


class AnamnesaUGDRI extends Component
{
    use WithPagination;

    // listener from blade////////////////
    protected $listeners = [];



    //////////////////////////////
    // Ref on top bar
    //////////////////////////////



    // dataDaftarUgd RJ
    public $rjNoRef;

    public array $dataDaftarUgd = [];

    public array $rekonsiliasiObat = ["namaObat" => "", "dosis" => "", "rute" => ""];

    public array $anamnesa =
    [
        "pengkajianPerawatanTab" => "Pengkajian Perawatan",
        "pengkajianPerawatan" => [
            "perawatPenerima" => "",
            "jamDatang" => "",
            "caraMasukIgd" => "",
            "caraMasukIgdDesc" => "",
            "caraMasukIgdOption" => [
                ["caraMasukIgd" => "Sendiri"],
                ["caraMasukIgd" => "Rujuk"],
                ["caraMasukIgd" => "Kasus Polisi"],
            ],

            "tingkatKegawatan" => "",
            "tingkatKegawatanOption" => [
                ["tingkatKegawatan" => "P1"],
                ["tingkatKegawatan" => "P2"],
                ["tingkatKegawatan" => "P3"],
                ["tingkatKegawatan" => "P0"],
            ],
        ],

        "keluhanUtamaTab" => "Keluhan Utama",
        "keluhanUtama" => [
            "keluhanUtama" => ""
        ],

        "anamnesaDiperolehTab" => "Anamnesa Diperoleh",
        "anamnesaDiperoleh" => [
            "autoanamnesa" => [],
            "allonanamnesa" => [],
            "anamnesaDiperolehDari" => ""
        ],

        "riwayatPenyakitSekarangUmumTab" => "Riwayat Penyakit Sekarang (Umum)",
        "riwayatPenyakitSekarangUmum" => [
            "riwayatPenyakitSekarangUmum" => ""
        ],

        "riwayatPenyakitDahuluTab" => "Riwayat Penyakit (Dahulu)",
        "riwayatPenyakitDahulu" => [
            "riwayatPenyakitDahulu" => ""
        ],

        "alergiTab" => "Alergi",
        "alergi" => [
            "alergi" => ""
        ],

        "rekonsiliasiObatTab" => "Rekonsiliasi Obat",
        "rekonsiliasiObat" => [],

        "lainLainTab" => "lain-Lain",
        "lainLain" => [
            "merokok" => [],
            "terpaparRokok" => []

        ],

        "faktorResikoTab" => "Faktor Resiko",
        "faktorResiko" => [
            "hipertensi" => [],
            "diabetesMelitus" => [],
            "penyakitJantung" => [],
            "asma" => [],
            "stroke" => [],
            "liver" => [],
            "tuberculosisParu" => [],
            "rokok" => [],
            "minumAlkohol" => [],
            "ginjal" => [],
            "lainLain" => ""
        ],

        "penyakitKeluargaTab" => "Riwayat Penyakit Keluarga",
        "penyakitKeluarga" => [
            "hipertensi" => [],
            "diabetesMelitus" => [],
            "penyakitJantung" => [],
            "asma" => [],
            "lainLain" => ""
        ],

        "statusFungsionalTab" => "Status Fungsional",
        "statusFungsional" => [
            "tongkat" => [],
            "kursiRoda" => [],
            "brankard" => [],
            "walker" => [],
            "lainLain" => ""
        ],

        "cacatTubuhTab" => "Cacat Tubuh",
        "cacatTubuh" => [
            "cacatTubuh" => [],
            "sebutCacatTubuh" => ""
        ],

        "statusPsikologisTab" => "Status Psikologis",
        "statusPsikologis" => [
            "tidakAdaKelainan" => [],
            "marah" => [],
            "ccemas" => [],
            "takut" => [],
            "sedih" => [],
            "cenderungBunuhDiri" => [],
            "sebutstatusPsikologis" => ""
        ],

        "statusMentalTab" => "Status Mental",
        "statusMental" => [
            "statusMental" => "",
            "statusMentalOption" => [
                ["statusMental" => "Sadar dan Orientasi Baik"],
                ["statusMental" => "Ada Masalah Perilaku"],
                ["statusMental" => "Perilaku Kekerasan yang dialami sebelumnya"],
            ],
            "keteranganStatusMental" => "",
        ],

        "hubunganDgnKeluargaTab" => "Sosial",
        "hubunganDgnKeluarga" => [
            "hubunganDgnKeluarga" => "",
            "hubunganDgnKeluargaOption" => [
                ["hubunganDgnKeluarga" => "Baik"],
                ["hubunganDgnKeluarga" => "Tidak Baik"],
            ],
        ],

        "tempatTinggalTab" => "Tempat Tinggal",
        "tempatTinggal" => [
            "tempatTinggal" => "",
            "tempatTinggalOption" => [
                ["tempatTinggal" => "Rumah"],
                ["tempatTinggal" => "Panti"],
                ["tempatTinggal" => "Lain-lain"],
            ],
            "keteranganTempatTinggal" => ""

        ],

        "spiritualTab" => "Spiritual",
        "spiritual" => [
            "spiritual" => "Islam",
            "ibadahTeratur" => "",
            "ibadahTeraturOptions" => [
                ["ibadahTeratur" => "Ya"],
                ["ibadahTeratur" => "Tidak"],
            ],

            "nilaiKepercayaan" => "",
            "nilaiKepercayaanOptions" => [
                ["nilaiKepercayaan" => "Ya"],
                ["nilaiKepercayaan" => "Tidak"],
            ],

            "keteranganSpiritual" => ""

        ],

        "ekonomiTab" => "Ekonomi",
        "ekonomi" => [
            "pengambilKeputusan" => "Ayah",
            "pekerjaan" => "Swasta",
            "penghasilanBln" => "",
            "penghasilanBlnOptions" => [
                ["penghasilanBln" => "< 5Jt"],
                ["penghasilanBln" => "5Jt - 10Jt"],
                ["penghasilanBln" => ">10Jt"],

            ],
            "keteranganEkonomi" => ""

        ],

        "edukasiTab" => "Edukasi",
        "edukasi" => [
            "pasienKeluargaMenerimaInformasi" => "",
            "pasienKeluargaMenerimaInformasiOptions" => [
                ["pasienKeluargaMenerimaInformasi" => "Ya"],
                ["pasienKeluargaMenerimaInformasi" => "Tidak"],
            ],

            "hambatanEdukasi" => "",
            "keteranganHambatanEdukasi" => "",
            "hambatanEdukasiOptions" => [
                ["hambatanEdukasi" => "Ya"],
                ["hambatanEdukasi" => "Tidak"],
            ],

            "penerjemah" => "",
            "keteranganPenerjemah" => "",
            "penerjemahOptions" => [
                ["penerjemah" => "Ya"],
                ["penerjemah" => "Tidak"],
            ],

            "diagPenyakit" => [],
            "obat" => [],
            "dietNutrisi" => [],
            "rehabMedik" => [],
            "managemenNyeri" => [],
            "penggunaanAlatMedis" => [],
            "hakKewajibanPasien" => [],

            "edukasiFollowUp" => "",
            "segeraKembaliIGDjika" => "",
            "informedConsent" => "", //uploadfile pdf dll
            "keteranganEdukasi" => ""
        ],

        "screeningGiziTab" => "Screening Gizi",
        "screeningGizi" => [
            "perubahanBB3Bln" => "",
            "perubahanBB3BlnScore" => "0",
            "perubahanBB3BlnOptions" => [
                ["perubahanBB3Bln" => "Ya (1)"],
                ["perubahanBB3Bln" => "Tidak (0)"],

            ],

            "jmlPerubahabBB" => "",
            "jmlPerubahabBBScore" => "0",
            "jmlPerubahabBBOptions" => [
                ["jmlPerubahabBB" => "0,5Kg-1Kg (1)"],
                ["jmlPerubahabBB" => ">5Kg-10Kg (2)"],
                ["jmlPerubahabBB" => ">10Kg-15Kg (3)"],
                ["jmlPerubahabBB" => ">15Kg-20Kg (4)"],
            ],

            "intakeMakanan" => "",
            "intakeMakananScore" => "0",
            "intakeMakananOptions" => [
                ["intakeMakanan" => "Ya (1)"],
                ["intakeMakanan" => "Tidak (0)"],

            ],
            "keteranganScreeningGizi" => "",
            "scoreTotalScreeningGizi" => "0",
            "tglScreeningGizi" => ""
        ],

        "batukTab" => "Batuk",
        "batuk" => [
            "riwayatDemam" => [],
            "keteranganRiwayatDemam" => "",

            "berkeringatMlmHari" => [],
            "keteranganBerkeringatMlmHari" => "",

            "bepergianDaerahWabah" => [],
            "keteranganBepergianDaerahWabah" => "",

            "riwayatPakaiObatJangkaPanjangan" => [],
            "keteranganRiwayatPakaiObatJangkaPanjangan" => "",

            "BBTurunTanpaSebab" => [],
            "keteranganBBTurunTanpaSebab" => "",

            "pembesaranGetahBening" => [],
            "keteranganPembesaranGetahBening" => "",

        ],
    ];
    //////////////////////////////////////////////////////////////////////


    protected $rules = [

        'dataDaftarUgd.anamnesa.pengkajianPerawatan.jamDatang' => 'required|date_format:d/m/Y H:i:s',

    ];



    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////
    public function updated($propertyName)
    {
        // dd($propertyName);
        $this->validateOnly($propertyName);
    }




    // resert input private////////////////
    private function resetInputFields(): void
    {

        // resert validation
        $this->resetValidation();
        // resert input kecuali
        $this->reset(['']);
    }





    // ////////////////
    // RJ Logic
    // ////////////////


    // validate Data RJ//////////////////////////////////////////////////
    private function validateDataAnamnesaUgd(): void
    {
        // customErrorMessages
        // $messages = customErrorMessagesTrait::messages();
        $messages = [];


        // $rules = [];



        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($this->rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $this->emit('toastr-error', "Lakukan Pengecekan kembali Input Data.");
            $this->validate($this->rules, $messages);
        }
    }


    // insert and update record start////////////////
    public function store()
    {
        // Validate RJ
        $this->validateDataAnamnesaUgd();

        // Logic update mode start //////////
        $this->updateDataUgd($this->dataDaftarUgd['rjNo']);
    }

    private function updateDataUgd($rjNo): void
    {
        $p_status = (isset($this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['tingkatKegawatan']) ?
            ($this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['tingkatKegawatan'] ?
                $this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['tingkatKegawatan']
                : 'P0')
            : 'P0');

        $waktu_pasien_datang = (isset($this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang']) ?
            ($this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang'] ?
                $this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang']
                : Carbon::now()->format('d/m/Y H:i:s'))
            : Carbon::now()->format('d/m/Y H:i:s'));

        $waktu_pasien_dilayani = (isset($this->dataDaftarUgd['perencanaan']['pengkajianMedis']['waktuPemeriksaan']) ?
            ($this->dataDaftarUgd['perencanaan']['pengkajianMedis']['waktuPemeriksaan'] ?
                $this->dataDaftarUgd['perencanaan']['pengkajianMedis']['waktuPemeriksaan']
                : Carbon::now()->format('d/m/Y H:i:s'))
            : Carbon::now()->format('d/m/Y H:i:s'));

        // update table trnsaksi
        DB::table('rstxn_ugdhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'datadaftarugd_json' => json_encode($this->dataDaftarUgd, true),
                'datadaftarUgd_xml' => ArrayToXml::convert($this->dataDaftarUgd),
                'p_status' => $p_status,
                'waktu_pasien_datang' => DB::raw("to_date('" . $waktu_pasien_datang . "','dd/mm/yyyy hh24:mi:ss')"),
                'waktu_pasien_dilayani' => DB::raw("to_date('" . $waktu_pasien_dilayani . "','dd/mm/yyyy hh24:mi:ss')"),


            ]);

        $this->emit('toastr-success', "Anamnesa berhasil disimpan.");
    }
    // insert and update record end////////////////


    private function findData($rjno): void
    {


        $findData = DB::table('rsview_ugdkasir')
            ->select('datadaftarugd_json', 'vno_sep')
            ->where('rj_no', $rjno)
            ->first();

        $datadaftarugd_json = isset($findData->datadaftarugd_json) ? $findData->datadaftarugd_json : null;
        // if meta_data_pasien_json = null
        // then cari Data Pasien By Key Collection (exception when no data found)
        // 
        // else json_decode
        if ($datadaftarugd_json) {
            $this->dataDaftarUgd = json_decode($findData->datadaftarugd_json, true);

            // jika anamnesa tidak ditemukan tambah variable anamnesa pda array
            if (isset($this->dataDaftarUgd['anamnesa']) == false) {
                $this->dataDaftarUgd['anamnesa'] = $this->anamnesa;
            }
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

            $this->dataDaftarUgd = [
                "regNo" =>  $dataDaftarUgd->reg_no,

                "drId" =>  $dataDaftarUgd->dr_id,
                "drDesc" =>  $dataDaftarUgd->dr_name,

                "poliId" =>  $dataDaftarUgd->poli_id,
                "klaimId" => $dataDaftarUgd->klaim_id,
                // "poliDesc" =>  $dataDaftarUgd->poli_desc ,

                // "kddrbpjs" =>  $dataDaftarUgd->kd_dr_bpjs ,
                // "kdpolibpjs" =>  $dataDaftarUgd->kd_poli_bpjs ,

                "rjDate" =>  $dataDaftarUgd->rj_date,
                "rjNo" =>  $dataDaftarUgd->rj_no,
                "shift" =>  $dataDaftarUgd->shift,
                "noAntrian" =>  $dataDaftarUgd->no_antrian,
                "noBooking" =>  $dataDaftarUgd->nobooking,
                "slCodeFrom" => "02",
                "passStatus" => "",
                "rjStatus" =>  $dataDaftarUgd->rj_status,
                "txnStatus" =>  $dataDaftarUgd->txn_status,
                "ermStatus" =>  $dataDaftarUgd->erm_status,
                "cekLab" => "0",
                "kunjunganInternalStatus" => "0",
                "noReferensi" =>  $dataDaftarUgd->reg_no,
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
                    "taskId3" =>  $dataDaftarUgd->rj_date,
                    "taskId4" => "",
                    "taskId5" => "",
                    "taskId6" => "",
                    "taskId7" => "",
                    "taskId99" => "",
                ],
                'sep' => [
                    "noSep" =>  $dataDaftarUgd->vno_sep,
                    "reqSep" => [],
                    "resSep" => [],
                ]
            ];


            // jika anamnesa tidak ditemukan tambah variable anamnesa pda array
            if (isset($this->dataDaftarUgd['anamnesa']) == false) {
                $this->dataDaftarUgd['anamnesa'] = $this->anamnesa;
            }
        }
        // menyamakan Variabel
        $this->matchingMyVariable();
    }



    public function addRekonsiliasiObat()
    {
        if ($this->rekonsiliasiObat['namaObat']) {

            // check exist
            $cekRekonsiliasiObat = collect($this->dataDaftarUgd['anamnesa']['rekonsiliasiObat'])
                ->where("namaObat", '=', $this->rekonsiliasiObat['namaObat'])
                ->count();

            if (!$cekRekonsiliasiObat) {
                $this->dataDaftarUgd['anamnesa']['rekonsiliasiObat'][] = [
                    "namaObat" => $this->rekonsiliasiObat['namaObat'],
                    "dosis" => $this->rekonsiliasiObat['dosis'],
                    "rute" => $this->rekonsiliasiObat['rute']
                ];

                // reset rekonsiliasiObat
                $this->reset(['rekonsiliasiObat']);
            } else {
                $this->emit('toastr-error', "Nama Obat Sudah ada.");
            }
        } else {
            $this->emit('toastr-error', "Nama Obat Kosong.");
        }
    }

    public function removeRekonsiliasiObat($namaObat)
    {

        $rekonsiliasiObat = collect($this->dataDaftarUgd['anamnesa']['rekonsiliasiObat'])->where("namaObat", '!=', $namaObat)->toArray();
        $this->dataDaftarUgd['anamnesa']['rekonsiliasiObat'] = $rekonsiliasiObat;
    }


    private function matchingMyVariable()
    {

        // keluhanUtama
        $this->dataDaftarUgd['anamnesa']['keluhanUtama']['keluhanUtama'] =
            ($this->dataDaftarUgd['anamnesa']['keluhanUtama']['keluhanUtama'])
            ? $this->dataDaftarUgd['anamnesa']['keluhanUtama']['keluhanUtama']
            : ((isset($this->dataDaftarUgd['screening']['keluhanUtama']) && !$this->dataDaftarUgd['anamnesa']['keluhanUtama']['keluhanUtama'])
                ? $this->dataDaftarUgd['screening']['keluhanUtama']
                : "");
    }


    public function setJamDatang($myTime)
    {
        $this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang'] = $myTime;
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
            'livewire.emr-u-g-d.mr-u-g-d-r-i.anamnesa-u-g-d-r-i.anamnesa-u-g-d-r-i',
            [
                // 'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Anamnesa',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
            ]
        );
    }
    // select data end////////////////


}
