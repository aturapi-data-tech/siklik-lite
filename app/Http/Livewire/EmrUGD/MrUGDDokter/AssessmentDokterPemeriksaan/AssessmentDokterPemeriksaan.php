<?php

namespace App\Http\Livewire\EmrUGD\MrUGDDokter\AssessmentDokterPemeriksaan;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use Spatie\ArrayToXml\ArrayToXml;
use App\Http\Traits\EmrUGD\EmrUGDTrait;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;


class AssessmentDokterPemeriksaan extends Component
{
    use WithPagination, WithFileUploads, EmrUGDTrait;

    // listener from blade////////////////
    protected $listeners = [
        'storeAssessmentDokterUGD' => 'store',
        'syncronizeAssessmentDokterUGDFindData' => 'mount'
    ];


    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef;

    // dataDaftarUgd RJ
    public array $dataDaftarUgd = [];

    // data pemeriksaan=>[]
    public array $pemeriksaan = [
        "umumTab" => "Umum",
        "tandaVital" => [
            "keadaanUmum" => "",
            "tingkatKesadaran" => "",
            "tingkatKesadaranOptions" => [
                ["tingkatKesadaran" => "Sadar Baik / Alert"],
                ["tingkatKesadaran" => "Berespon Dengan Kata-Kata / Voice"],
                ["tingkatKesadaran" => "Hanya Beresponse Jika Dirangsang Nyeri / Pain"],
                ["tingkatKesadaran" => "Pasien Tidak Sadar / Unresponsive"],
                ["tingkatKesadaran" => "Gelisah Atau Bingung"],
                ["tingkatKesadaran" => "Acute Confusional States"],
            ],
            // jalan nafas
            "jalanNafas" => [
                "jalanNafas" => "",
                "jalanNafasOptions" => [
                    ["jalanNafas" => "Paten"],
                    ["jalanNafas" => "Obstruksi Partial"],
                    ["jalanNafas" => "Obstruksi Total"],
                    ["jalanNafas" => "Stridor"],
                ]
            ],

            // pernafasan
            "pernafasan" => [
                "pernafasan" => "",
                "pernafasanOptions" => [
                    ["pernafasan" => "Normal"],
                    ["pernafasan" => "Kusmaul"],
                    ["pernafasan" => "Takipneu"],
                    ["pernafasan" => "Retraktif"],
                    ["pernafasan" => "Dangkal"],

                ]
            ],

            "gerakDada" => [
                "gerakDada" => "",
                "gerakDadaOptions" => [
                    ["gerakDada" => "Simetris"],
                    ["gerakDada" => "Asimetris"],
                ]
            ],

            // sirkulasi
            "sirkulasi" => [
                "sirkulasi" => "",
                "sirkulasiOptions" => [
                    ["sirkulasi" => "Normal"],
                    ["sirkulasi" => "Sianosis"],
                    ["sirkulasi" => "Berkeringat"],
                    ["sirkulasi" => "Joundise"],
                    ["sirkulasi" => "Pucat"],

                ]
            ],

            // neurologis

            "e" => "", //number
            "m" => "", //number
            "v" => "", //number
            "gcs" => "", //number
            "sistolik" => "", //number
            "distolik" => "", //number
            "frekuensiNafas" => "", //number
            "frekuensiNadi" => "", //number
            "suhu" => "", //number
            // "saturasiO2" => "", //number
            "spo2" => "", //number
            "gda" => "", //number
            "waktuPemeriksaan" => "", //date dd/mm/yyyy hh24:mi:ss
        ],

        "nutrisi" => [
            "bb" => "", //number
            "tb" => "", //number
            "imt" => "", //number
            "lk" => "", //number
            "lila" => "" //number
        ],
        "fungsional" => [
            "alatBantu" => "",
            "prothesa" => "",
            "cacatTubuh" => "",
        ],

        "fisik" => "",

        "anatomi" => [
            "kepala" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "mata" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "telinga" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "hidung" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "rambut" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "bibir" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "gigiGeligi" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "lidah" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "langitLangit" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "leher" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "tenggorokan" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "tonsil" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "dada" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "payudarah" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "punggung" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "perut" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "genital" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "anus" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "lenganAtas" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "lenganBawah" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "jariTangan" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "kukuTangan" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "persendianTangan" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "tungkaiAtas" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "tungkaiBawah" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "jariKaki" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "kukuKaki" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "persendianKaki" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
            "faring" => [
                "kelainan" => "Tidak Diperiksa",
                "kelainanOptions" => [
                    ["kelainan" => "Tidak Diperiksa"],
                    ["kelainan" => "Tidak Ada Kelainan"],
                    ["kelainan" => "Ada"],
                ],
                "desc" => "",
            ],
        ],

        "fungsional" => [
            "alatBantu" => "",
            "prothesa" => "",
            "cacatTubuh" => "",
        ],
        "eeg" => [
            "hasilPemeriksaan" => "",
            "hasilPemeriksaanSebelumnya" => "",
            "mriKepala" => "",
            "hasilPerekaman" => "",
            "kesimpulan" => "",
            "saran" => "",

        ],
        "emg" => [
            "keluhanPasien" => "",
            "pengobatan     " => "",
            "td" => "", //number
            "rr" => "", //number
            "hr" => "", //number
            "s" => "", //number
            "gcs" => "",
            "fkl" => "",
            "nprs" => "",
            "rclRctl" => "",
            "nnCr" => "",
            "nnCrLain" => "",
            "motorik" => "",
            "pergerakan" => "",
            "kekuatan" => "",
            "extremitasSuperior" => "",
            "extremitasInferior" => "",
            "tonus" => "",
            "refleksFisiologi" => "",
            "refleksPatologis" => "",
            "sensorik" => "",
            "otonom" => "",
            "emcEmgFindings" => "",
            "impresion" => "",
        ],
        "ravenTest" => [
            "skoring" => "", //number
            "presentil" => "", //number
            "interpretasi" => "",
            "anjuran" => "",


        ],
        "penunjang" => ""

    ];

    public $filePDF, $descPDF;
    public bool $isOpenRekamMedisuploadpenunjangHasil;


    //////////////////////////////////////////////////////////////////////

    // open and close modal start////////////////
    //  modal status////////////////

    public bool $isOpenLaboratorium = false;
    public string $isOpenModeLaboratorium = 'insert';

    public  $isPemeriksaanLaboratorium = [];
    public  $isPemeriksaanLaboratoriumSelected = [];
    public int $isPemeriksaanLaboratoriumSelectedKeyHdr = 0;
    public int $isPemeriksaanLaboratoriumSelectedKeyDtl = 0;



    public bool $isOpenRadiologi = false;
    public string $isOpenModeRadiologi = 'insert';

    public  $isPemeriksaanRadiologi = [];
    public  $isPemeriksaanRadiologiSelected = [];
    public int $isPemeriksaanRadiologiSelectedKeyHdr = 0;
    public int $isPemeriksaanRadiologiSelectedKeyDtl = 0;


    // open and close modal start////////////////
    //  modal status////////////////

    public $tingkatKesadaranLov = [];
    public $tingkatKesadaranLovStatus = 0;
    public $tingkatKesadaranLovSearch = '';



    protected $rules = [
        // 'dataDaftarUgd.pemeriksaan.tandaVital.sistolik' => 'required|numeric',
        // 'dataDaftarUgd.pemeriksaan.tandaVital.distolik' => 'required|numeric',
        'dataDaftarUgd.pemeriksaan.tandaVital.frekuensiNadi' => 'required|numeric',
        'dataDaftarUgd.pemeriksaan.tandaVital.frekuensiNafas' => 'required|numeric',
        'dataDaftarUgd.pemeriksaan.tandaVital.suhu' => 'required|numeric',
        'dataDaftarUgd.pemeriksaan.tandaVital.spo2' => 'numeric',
        'dataDaftarUgd.pemeriksaan.tandaVital.gda' => 'numeric',

        'dataDaftarUgd.pemeriksaan.nutrisi.bb' => 'required|numeric',
        'dataDaftarUgd.pemeriksaan.nutrisi.tb' => 'required|numeric',
        'dataDaftarUgd.pemeriksaan.nutrisi.imt' => 'required|numeric',
        'dataDaftarUgd.pemeriksaan.nutrisi.lk' => 'numeric',
        'dataDaftarUgd.pemeriksaan.nutrisi.lila' => 'numeric',
    ];

    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////

    public function updated($propertyName)
    {
        // dd($propertyName);
        $this->validateOnly($propertyName);
        $this->scoringIMT();
        $this->store();
    }

    // lab
    private function openModalLaboratorium(): void
    {
        $this->isOpenLaboratorium = true;
        $this->isOpenModeLaboratorium = 'insert';
    }

    public function pemeriksaanLaboratorium()
    {
        $this->openModalLaboratorium();
        $this->renderisPemeriksaanLaboratorium();
        // $this->findData($id);
    }

    public function closeModalLaboratorium(): void
    {
        $this->reset(['isOpenLaboratorium', 'isOpenModeLaboratorium', 'isPemeriksaanLaboratorium', 'isPemeriksaanLaboratoriumSelected', 'isPemeriksaanLaboratoriumSelectedKeyHdr', 'isPemeriksaanLaboratoriumSelectedKeyDtl']);
    }

    private function renderisPemeriksaanLaboratorium()
    {
        if (empty($this->isPemeriksaanLaboratorium)) {
            $isPemeriksaanLaboratorium = DB::table('lbmst_clabitems')
                ->select('clabitem_desc', 'clabitem_id', 'price', 'clabitem_group', 'item_code')
                ->whereNull('clabitem_group')
                ->whereNotNull('clabitem_desc')
                ->orderBy('clabitem_desc', 'asc')
                ->get();

            $this->isPemeriksaanLaboratorium = json_decode(
                $isPemeriksaanLaboratorium->map(function ($isPemeriksaanLaboratorium) {
                    $isPemeriksaanLaboratorium->labStatus = 0;

                    return $isPemeriksaanLaboratorium;
                }),
                true
            );
        }
    }

    public function PemeriksaanLaboratoriumIsSelectedFor($key): void
    {
        $this->isPemeriksaanLaboratorium[$key]['labStatus'] = $this->isPemeriksaanLaboratorium[$key]['labStatus'] ? 0 : 1;
        $this->renderPemeriksaanLaboratoriumIsSelected($key);
    }

    public function RemovePemeriksaanLaboratoriumIsSelectedFor($key): void
    {
        $this->isPemeriksaanLaboratorium[$key]['labStatus'] = $this->isPemeriksaanLaboratorium[$key]['labStatus'] ? 0 : 1;
        $this->renderPemeriksaanLaboratoriumIsSelected($key);
    }

    private function renderPemeriksaanLaboratoriumIsSelected($key): void
    {
        $this->isPemeriksaanLaboratoriumSelected = collect($this->isPemeriksaanLaboratorium)
            ->where('labStatus', 1);
    }

    public function kirimLaboratorium()
    {
        $sql = "select rj_status  from rstxn_ugdhdrs where rj_no=:rjNo";
        $checkStatusRJ = DB::scalar($sql, [
            "rjNo" => $this->dataDaftarUgd['rjNo'],
        ]);

        if ($checkStatusRJ == 'A') {
            // hasil Key = 0 atau urutan pemeriksan lab lebih dari 1
            $this->isPemeriksaanLaboratoriumSelectedKeyHdr = collect(isset($this->dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['lab']) ? $this->dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['lab'] : [])->count();

            $sql = "select nvl(max(to_number(checkup_no))+1,1) from lbtxn_checkuphdrs";
            $checkupNo = DB::scalar($sql);

            // array Hdr
            $this->dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['lab'][$this->isPemeriksaanLaboratoriumSelectedKeyHdr]['labHdr']['labHdrNo'] =  $checkupNo;
            $this->dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['lab'][$this->isPemeriksaanLaboratoriumSelectedKeyHdr]['labHdr']['labHdrDate'] = Carbon::now()->format('d/m/Y H:i:s');


            // insert Hdr
            DB::table('lbtxn_checkuphdrs')->insert([
                'reg_no' => $this->dataDaftarUgd['regNo'],
                'dr_id' => $this->dataDaftarUgd['drId'],
                'checkup_date' => DB::raw("to_date('" . Carbon::now()->format('d/m/Y H:i:s') . "','dd/mm/yyyy hh24:mi:ss')"),
                'status_rjri' => 'UGD',
                'checkup_status' => 'P',
                'ref_no' => $this->dataDaftarUgd['rjNo'],
                'checkup_no' => $checkupNo,

            ]);


            // hasil Key Dtl dari jml yang selected -1 karena array dimulai dari 0
            $this->isPemeriksaanLaboratoriumSelectedKeyDtl = collect($this->isPemeriksaanLaboratoriumSelected)->count() - 1;


            // array Dtl
            $this->dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['lab'][$this->isPemeriksaanLaboratoriumSelectedKeyHdr]['labHdr']['labDtl'] =  collect($this->isPemeriksaanLaboratorium)
                ->where('labStatus', 1)
                ->toArray();

            // insert Dtl
            foreach ($this->dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['lab'][$this->isPemeriksaanLaboratoriumSelectedKeyHdr]['labHdr']['labDtl'] as $labDtl) {
                $sql = "select nvl(to_number(max(checkup_dtl))+1,1) from LBTXN_CHECKUPDTLS";
                $checkupDtl = DB::scalar($sql);

                // insert Prise checkup dtl
                DB::table('lbtxn_checkupdtls')->insert([
                    'clabitem_id' => $labDtl['clabitem_id'],
                    'checkup_no' => $checkupNo,
                    'checkup_dtl' => $checkupDtl,
                    'lab_item_code' => $labDtl['item_code'],
                    'price' => $labDtl['price']
                ]);

                foreach ($this->isPemeriksaanLaboratoriumSelected as $isPemeriksaanLaboratoriumSelected) {

                    // insert No Prise checkup dtl
                    $items = DB::table('lbmst_clabitems')->select('clabitem_desc', 'clabitem_id', 'price', 'clabitem_group', 'item_code')
                        ->where('clabitem_group', $labDtl['clabitem_id'])
                        ->orderBy('item_seq', 'asc')
                        ->orderBy('clabitem_desc', 'asc')
                        ->get();

                    foreach ($items as $item) {
                        $sql = "select nvl(to_number(max(checkup_dtl))+1,1) from LBTXN_CHECKUPDTLS";
                        $checkupDtl = DB::scalar($sql);

                        DB::table('lbtxn_checkupdtls')->insert([
                            'clabitem_id' => $item->clabitem_id,
                            'checkup_no' => $checkupNo,
                            'checkup_dtl' => $checkupDtl,
                            'lab_item_code' => $item->item_code,
                            'price' => $item->price
                        ]);

                        $this->isPemeriksaanLaboratoriumSelectedKeyDtl = $this->isPemeriksaanLaboratoriumSelectedKeyDtl + 1;
                    }
                }


                $this->isPemeriksaanLaboratoriumSelectedKeyDtl = $this->isPemeriksaanLaboratoriumSelectedKeyDtl + 1;
            }



            $this->updateDataUgd($this->dataDaftarUgd['rjNo']);
            $this->closeModalLaboratorium();
        } else {
            $this->emit('toastr-error', "Pasien Sudah Pulang, Anda tidak bisa meneruskan pemeriksaan ini.");
            return;
        }
    }
    // Lab

    // Rad
    private function openModalRadiologi(): void
    {
        $this->isOpenRadiologi = true;
        $this->isOpenModeRadiologi = 'insert';
    }

    public function pemeriksaanRadiologi()
    {
        $this->openModalRadiologi();
        $this->renderisPemeriksaanRadiologi();
        // $this->findData($id);
    }

    public function closeModalRadiologi(): void
    {
        $this->reset(['isOpenRadiologi', 'isOpenModeRadiologi', 'isPemeriksaanRadiologi', 'isPemeriksaanRadiologiSelected', 'isPemeriksaanRadiologiSelectedKeyHdr', 'isPemeriksaanRadiologiSelectedKeyDtl']);
    }

    private function renderisPemeriksaanRadiologi()
    {
        if (empty($this->isPemeriksaanRadiologi)) {
            $isPemeriksaanRadiologi = DB::table('rsmst_radiologis ')
                ->select('rad_desc', 'rad_price', 'rad_id')
                ->orderBy('rad_desc', 'asc')
                ->get();

            $this->isPemeriksaanRadiologi = json_decode(
                $isPemeriksaanRadiologi->map(function ($isPemeriksaanRadiologi) {
                    $isPemeriksaanRadiologi->radStatus = 0;

                    return $isPemeriksaanRadiologi;
                }),
                true
            );
        }
    }

    public function PemeriksaanRadiologiIsSelectedFor($key): void
    {
        $this->isPemeriksaanRadiologi[$key]['radStatus'] = $this->isPemeriksaanRadiologi[$key]['radStatus'] ? 0 : 1;
        $this->renderPemeriksaanRadiologiIsSelected($key);
    }

    public function RemovePemeriksaanRadiologiIsSelectedFor($key): void
    {
        $this->isPemeriksaanRadiologi[$key]['radStatus'] = $this->isPemeriksaanRadiologi[$key]['radStatus'] ? 0 : 1;
        $this->renderPemeriksaanRadiologiIsSelected($key);
    }

    private function renderPemeriksaanRadiologiIsSelected($key): void
    {
        $this->isPemeriksaanRadiologiSelected = collect($this->isPemeriksaanRadiologi)
            ->where('radStatus', 1);
    }

    public function kirimRadiologi()
    {

        $sql = "select rj_status  from rstxn_ugdhdrs where rj_no=:rjNo";
        $checkStatusRJ = DB::scalar($sql, [
            "rjNo" => $this->dataDaftarUgd['rjNo'],
        ]);

        if ($checkStatusRJ == 'A') {
            // hasil Key = 0 atau urutan pemeriksan lab lebih dari 1
            $this->isPemeriksaanRadiologiSelectedKeyHdr = collect(isset($this->dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['rad']) ? $this->dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['rad'] : [])->count();

            // $sql = "select nvl(max(rad_dtl)+1,1) from rstxn_ugdrads";
            // $checkupNo = DB::scalar($sql);

            // array Hdr
            $this->dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['rad'][$this->isPemeriksaanRadiologiSelectedKeyHdr]['radHdr']['radHdrNo'] =  $this->dataDaftarUgd['rjNo'];
            $this->dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['rad'][$this->isPemeriksaanRadiologiSelectedKeyHdr]['radHdr']['radHdrDate'] = Carbon::now()->format('d/m/Y H:i:s');


            // insert Hdr (Radiologi tidak di insert header / ikut txn rj)
            // DB::table('lbtxn_checkuphdrs')->insert([
            //     'reg_no' => $this->dataDaftarUgd['regNo'],
            //     'dr_id' => $this->dataDaftarUgd['drId'],
            //     'checkup_date' => DB::raw("to_date('" . Carbon::now()->format('d/m/Y H:i:s') . "','dd/mm/yyyy hh24:mi:ss')"),
            //     'status_rjri' => 'RJ',
            //     'checkup_status' => 'P',
            //     'ref_no' => $this->dataDaftarUgd['rjNo'],
            //     'checkup_no' => $checkupNo,

            // ]);


            // hasil Key Dtl dari jml yang selected -1 karena array dimulai dari 0
            $this->isPemeriksaanRadiologiSelectedKeyDtl = collect($this->isPemeriksaanRadiologiSelected)->count() - 1;


            // array Dtl
            $this->dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['rad'][$this->isPemeriksaanRadiologiSelectedKeyHdr]['radHdr']['radDtl'] =  collect($this->isPemeriksaanRadiologi)
                ->where('radStatus', 1)
                ->toArray();

            // insert Dtl
            foreach ($this->dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['rad'][$this->isPemeriksaanRadiologiSelectedKeyHdr]['radHdr']['radDtl'] as $radDtl) {
                $sql = "select nvl(max(rad_dtl)+1,1) from rstxn_ugdrads";
                $checkupDtl = DB::scalar($sql);

                // insert Prise checkup dtl
                DB::table('rstxn_ugdrads')->insert([
                    'rad_dtl' => $checkupDtl,
                    'rad_id' => $radDtl['rad_id'],
                    'rj_no' => $this->dataDaftarUgd['rjNo'],
                    'rad_price' => $radDtl['rad_price'],
                    'dr_radiologi' => 'dr. M.A. Budi Purwito, Sp.Rad.',
                    'waktu_entry' => DB::raw("to_date('" . Carbon::now()->format('d/m/Y H:i:s') . "','dd/mm/yyyy hh24:mi:ss')"),
                ]);


                $this->isPemeriksaanRadiologiSelectedKeyDtl = $this->isPemeriksaanRadiologiSelectedKeyDtl + 1;
            }



            $this->updateDataUgd($this->dataDaftarUgd['rjNo']);
            $this->closeModalRadiologi();
        } else {
            $this->emit('toastr-error', "Pasien Sudah Pulang, Anda tidak bisa meneruskan pemeriksaan ini.");
            return;
        }
    }
    // Rad



    // /////////tingkatKesadaran////////////
    public function clicktingkatKesadaranlov()
    {
        $this->tingkatKesadaranLovStatus = true;
        $this->tingkatKesadaranLov = $this->dataDaftarUgd['pemeriksaan']['tandaVital']['tingkatKesadaranOptions'];
    }
    public function updatedtingkatKesadaranlovsearch()
    {
        // Variable Search
        $search = $this->tingkatKesadaranLovSearch;

        // check LOV by id
        $tingkatKesadaran = collect($this->dataDaftarUgd['pemeriksaan']['tandaVital']['tingkatKesadaranOptions'])
            ->where('tingkatKesadaran', '=', $search)
            ->first();

        if ($tingkatKesadaran) {
            $this->dataDaftarUgd['pemeriksaan']['tandaVital']['tingkatKesadaranOptions'] = $tingkatKesadaran['tingkatKesadaran'];

            $this->tingkatKesadaranLovStatus = false;
            $this->tingkatKesadaranLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->tingkatKesadaranLov = $this->dataDaftarUgd['pemeriksaan']['tandaVital']['tingkatKesadaranOptions'];
            } else {
                $this->tingkatKesadaranLov = collect($this->dataDaftarUgd['pemeriksaan']['tandaVital']['tingkatKesadaranOptions'])
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['tingkatKesadaran'], $search);
                    });
            }
            $this->tingkatKesadaranLovStatus = true;
            $this->dataDaftarUgd['pemeriksaan']['tandaVital']['tingkatKesadaran'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMytingkatKesadaranLov($id)
    {
        $this->dataDaftarUgd['pemeriksaan']['tandaVital']['tingkatKesadaran'] = $id;
        $this->tingkatKesadaranLovStatus = false;
        $this->tingkatKesadaranLovSearch = '';
    }
    // LOV selected end
    // /////////////////////




    // ////////////////
    // RJ Logic
    // ////////////////


    // validate Data RJ//////////////////////////////////////////////////
    private function validateDataUgd(): void
    {
        // customErrorMessages
        // $messages = customErrorMessagesTrait::messages();
        $messages = [];

        //Cek Usia Anak dibawah 13th tidak di cek tekanan darah
        $sql = "select birth_date from rsmst_pasiens where reg_no=:regNo";
        $birthDate = DB::scalar($sql, [
            "regNo" => $this->dataDaftarUgd['regNo'],
        ]);
        $cekUsia = Carbon::createFromFormat('Y-m-d H:i:s', $birthDate)->diff(Carbon::now())->format('%y');

        if ($cekUsia > 13) {
            $this->rules['dataDaftarUgd.pemeriksaan.tandaVital.sistolik'] = 'required|numeric';
            $this->rules['dataDaftarUgd.pemeriksaan.tandaVital.distolik'] = 'required|numeric';
        }

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
        // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
        $this->setDataPrimer();

        // Validate RJ
        $this->validateDataUgd();

        // Logic update mode start //////////
        $this->updateDataUgd($this->dataDaftarUgd['rjNo']);

        $this->emit('syncronizeAssessmentDokterUGDFindData');
    }

    private function updateDataUgd($rjNo): void
    {

        // update table trnsaksi
        DB::table('rstxn_ugdhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'datadaftarUgd_json' => json_encode($this->dataDaftarUgd, true),
                'datadaftarUgd_xml' => ArrayToXml::convert($this->dataDaftarUgd),
            ]);

        $this->emit('toastr-success', "Pemeriksaan berhasil disimpan.");
    }
    // insert and update record end////////////////


    private function findData($rjno): void
    {

        $this->dataDaftarUgd = $this->findDataUGD($rjno);
        // dd($this->dataDaftarUgd);
        // jika pemeriksaan tidak ditemukan tambah variable pemeriksaan pda array
        if (isset($this->dataDaftarUgd['pemeriksaan']) == false) {
            $this->dataDaftarUgd['pemeriksaan'] = $this->pemeriksaan;
        }
    }


    // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
    private function setDataPrimer(): void
    {
    }

    private function scoringIMT(): void
    {
        $bb = (isset($this->dataDaftarUgd['pemeriksaan']['nutrisi']['bb'])
            ? ($this->dataDaftarUgd['pemeriksaan']['nutrisi']['bb']
                ? $this->dataDaftarUgd['pemeriksaan']['nutrisi']['bb']
                : 1)
            : 1);
        $tb = (isset($this->dataDaftarUgd['pemeriksaan']['nutrisi']['tb'])
            ? ($this->dataDaftarUgd['pemeriksaan']['nutrisi']['tb']
                ? $this->dataDaftarUgd['pemeriksaan']['nutrisi']['tb']
                : 1)
            : 1);;


        $this->dataDaftarUgd['pemeriksaan']['nutrisi']['imt'] = round($bb / (($tb / 100) * ($tb / 100)), 2);
    }


    public function uploadHasilPenunjang(): void
    {
        // validate
        // cek status transaksi
        $checkUGDStatus = $this->checkUGDStatus($this->rjNoRef);
        if ($checkUGDStatus) {
            $this->emit('toastr-error', "Pasien Sudah Pulang, Trasaksi Terkunci.");
            return;
        }

        // cek status transaksi
        $this->validateDataUgd($this->rjNoRef);


        // customErrorMessages
        $messages = [];
        // require nik ketika pasien tidak dikenal
        $rules = [
            "filePDF" => "bail|required|mimes:pdf|max:10240",
            "descPDF" => "bail|required|max:255"
        ];

        // Proses Validasi///////////////////////////////////////////
        $this->validate($rules, $messages);
        // upload photo
        $uploadHasilPenunjangfile = $this->filePDF->store('uploadHasilPenunjang');

        $this->dataDaftarUgd['pemeriksaan']['uploadHasilPenunjang'][] = [
            'file' => $uploadHasilPenunjangfile,
            'desc' => $this->descPDF,
            'tglUpload' => Carbon::now()->format('d/m/Y H:i:s'),
            'penanggungJawab' => [
                'userLog' => auth()->user()->myuser_name,
                'userLogDate' => Carbon::now()->format('d/m/Y H:i:s'),
                'userLogCode' => auth()->user()->myuser_code
            ]
        ];
        $this->reset(['filePDF', 'descPDF'],);
        $this->store();
    }

    public function deleteHasilPenunjang($file): void
    {
        // Foto/////////////////////////////////////////////////////////////////////////
        Storage::delete($file);
        $deleteHasilpenunjang = collect($this->dataDaftarUgd['pemeriksaan']['uploadHasilPenunjang'])->where("file", '!=', $file)->toArray();
        $this->dataDaftarUgd['pemeriksaan']['uploadHasilPenunjang'] = $deleteHasilpenunjang;
        $this->store();
        //
    }

    public function openModalHasilPenunjang($file)
    {

        if (Storage::exists($file)) {
            $this->isOpenRekamMedisuploadpenunjangHasil = true;
            $this->filePDF = $file;
        } else {
            $this->emit('toastr-error', 'File tidak ditemukan');
            return;
        }
    }

    public function closeModalHasilPenunjang()
    {
        $this->isOpenRekamMedisuploadpenunjangHasil = false;
        $this->reset(['filePDF']);
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
            'livewire.emr-u-g-d.mr-u-g-d-dokter.assessment-dokter-pemeriksaan.assessment-dokter-pemeriksaan',
            [
                // 'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Anamnesia',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
            ]
        );
    }
    // select data end////////////////


}
