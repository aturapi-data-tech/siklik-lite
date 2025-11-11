<?php

namespace App\Http\Livewire\RJ\EmrRJ\MrRJ\Pemeriksaan;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\LockTimeoutException;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use App\Http\Traits\EmrRJ\EmrRJTrait;
use App\Http\Traits\LOV\Pcare\LOVGetKesadaran\LOVGetKesadaranTrait;

class Pemeriksaan extends Component
{
    use WithPagination, WithFileUploads, EmrRJTrait, LOVGetKesadaranTrait;

    // ==========================
    // Listeners
    // ==========================
    protected $listeners = [
        'emr:rj:store'        => 'store',
        // RACE-FIX: samakan pattern Anamnesa
    ];



    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef;

    // dataDaftarPoliRJ RJ
    public array $dataDaftarPoliRJ = [];
    public array $kesadaran = [];

    // ==========================
    // DEFAULT SUBTREE
    // ==========================
    public array $pemeriksaan = [
        "umumTab" => "Umum",
        "tandaVital" => [
            "keadaanUmum" => "",
            "tingkatKesadaran" => "01",
            "tingkatKesadaranDesc" => "Compos mentis",
            "sistolik" => "",
            "distolik" => "",
            "frekuensiNafas" => "",
            "frekuensiNadi" => "",
            "suhu" => "",
            "spo2" => "",
            "gda" => "",
            "waktuPemeriksaan" => "",
        ],

        "nutrisi" => [
            "bb" => "",
            "tb" => "",
            "imt" => "",
            "lk" => "",
            "lila" => "",
            "liPerut" => ""
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
            "payudara" => [
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

        "suspekAkibatKerja" => [
            "suspekAkibatKerja" => "",
            "keteranganSuspekAkibatKerja" => "",
            "suspekAkibatKerjaOptions" => [
                ["suspekAkibatKerja" => "Ya"],
                ["suspekAkibatKerja" => "Tidak"],
            ]
        ],
        "FisikujiFungsi" => [
            "FisikujiFungsi" => "",
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
            "pengobatan" => "",
            "td" => "",
            "rr" => "",
            "hr" => "",
            "s" => "",
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
            "skoring" => "",
            "presentil" => "",
            "interpretasi" => "",
            "anjuran" => "",
        ],

        // Container penunjang
        "pemeriksaanPenunjang" => [
            "lab" => [],
            "rad" => [],
        ],
        // uploadHasilPenunjang akan dibuat dinamis
    ];

    public $filePDF, $descPDF;
    public bool $isOpenRekamMedisuploadpenunjangHasil = false;

    // Modal laboratorium
    public bool $isOpenLaboratorium = false;
    public string $isOpenModeLaboratorium = 'insert';
    public array $isPemeriksaanLaboratorium = [];
    public $isPemeriksaanLaboratoriumSelected = [];
    public int $isPemeriksaanLaboratoriumSelectedKeyHdr = 0;
    public int $isPemeriksaanLaboratoriumSelectedKeyDtl = 0;

    // Modal radiologi
    public bool $isOpenRadiologi = false;
    public string $isOpenModeRadiologi = 'insert';
    public array $isPemeriksaanRadiologi = [];
    public $isPemeriksaanRadiologiSelected = [];
    public int $isPemeriksaanRadiologiSelectedKeyHdr = 0;
    public int $isPemeriksaanRadiologiSelectedKeyDtl = 0;

    // LOV kesadaran
    public array $tingkatKesadaranLov = [];
    public bool $tingkatKesadaranLovStatus = false;
    public string $tingkatKesadaranLovSearch = '';

    // ==========================
    // Validation
    // ==========================
    protected $rules = [
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik' => 'required|numeric|min:40|max:250',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik' => 'required|numeric|min:30|max:180',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi' => 'required|numeric|min:30|max:160',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas' => 'required|numeric|min:5|max:70',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu' => 'required|numeric|min:35|max:42',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.spo2' => 'nullable|numeric|min:70|max:100',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.gda' => 'nullable|numeric|min:50|max:500',

        'dataDaftarPoliRJ.pemeriksaan.nutrisi.bb' => 'required|numeric|min:2|max:300',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.tb' => 'required|numeric|min:30|max:250',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.imt' => 'required|numeric|min:10|max:100',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.lk' => 'nullable|numeric|min:10|max:100',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.lila' => 'nullable|numeric|min:5|max:100',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.liPerut' => 'required|numeric|min:10|max:200',
    ];

    protected $messages = [
        // tanda vital
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik.required' => 'Kolom :attribute wajib diisi.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik.numeric' => ':attribute harus berupa angka.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik.min' => ':attribute minimal :min mmHg.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik.max' => ':attribute maksimal :max mmHg.',

        'dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik.required' => 'Kolom :attribute wajib diisi.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik.numeric' => ':attribute harus berupa angka.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik.min' => ':attribute minimal :min mmHg.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik.max' => ':attribute maksimal :max mmHg.',

        'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi.required' => ':attribute wajib diisi.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi.numeric' => ':attribute harus angka.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi.min' => ':attribute minimal :min x/menit.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi.max' => ':attribute maksimal :max x/menit.',

        'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas.required' => ':attribute wajib diisi.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas.numeric' => ':attribute harus angka.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas.min' => ':attribute minimal :min x/menit.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas.max' => ':attribute maksimal :max x/menit.',

        'dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu.required' => ':attribute wajib diisi.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu.numeric' => ':attribute harus angka.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu.min' => ':attribute minimal :min °C.',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu.max' => ':attribute maksimal :max °C.',

        // nutrisi
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.bb.required' => ':attribute wajib diisi.',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.bb.numeric' => ':attribute harus berupa angka.',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.bb.min' => ':attribute minimal :min kg.',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.bb.max' => ':attribute maksimal :max kg.',

        'dataDaftarPoliRJ.pemeriksaan.nutrisi.tb.required' => ':attribute wajib diisi.',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.tb.numeric' => ':attribute harus berupa angka.',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.tb.min' => ':attribute minimal :min cm.',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.tb.max' => ':attribute maksimal :max cm.',

        'dataDaftarPoliRJ.pemeriksaan.nutrisi.imt.required' => ':attribute wajib diisi.',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.imt.numeric' => ':attribute harus berupa angka.',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.imt.min' => ':attribute minimal :min.',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.imt.max' => ':attribute maksimal :max.',

        'dataDaftarPoliRJ.pemeriksaan.nutrisi.liPerut.required' => ':attribute wajib diisi.',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.liPerut.numeric' => ':attribute harus angka.',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.liPerut.min' => ':attribute minimal :min cm.',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.liPerut.max' => ':attribute maksimal :max cm.',
    ];

    protected $validationAttributes = [
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik' => 'Tekanan darah sistolik',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik' => 'Tekanan darah diastolik',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi' => 'Frekuensi nadi',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas' => 'Frekuensi napas',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu' => 'Suhu tubuh',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.spo2' => 'Saturasi oksigen (SpO₂)',
        'dataDaftarPoliRJ.pemeriksaan.tandaVital.gda' => 'Gula darah acak (GDA)',

        'dataDaftarPoliRJ.pemeriksaan.nutrisi.bb' => 'Berat badan',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.tb' => 'Tinggi badan',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.imt' => 'Indeks massa tubuh (IMT)',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.lk' => 'Lingkar kepala',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.lila' => 'Lingkar lengan atas (LILA)',
        'dataDaftarPoliRJ.pemeriksaan.nutrisi.liPerut' => 'Lingkar perut',
    ];

    // ==========================
    // Lifecycle/UI
    // ==========================
    public function updated($propertyName)
    {
        // RACE-FIX: jangan autosave di setiap ketikan
        if (str_starts_with($propertyName, 'dataDaftarPoliRJ.pemeriksaan.')) {
            $this->validateOnly($propertyName);
            $this->scoringIMT();
        }
    }

    // ==========================
    // PUBLIC API (no autosave)
    // ==========================
    public function store(): void
    {
        // 1) Validasi form
        $this->validateDataRJ();

        // 2) RJ No
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";

        // 3) Mutex + Transaction + PATCH subtree
        try {
            // RACE-FIX: lock + block
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {

                // Ambil FRESH state dari DB
                $freshWrap = $this->findDataRJ($rjNo);
                $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                if (!is_array($fresh)) $fresh = [];

                // Bootstrap subtree pemeriksaan
                if (!isset($fresh['pemeriksaan']) || !is_array($fresh['pemeriksaan'])) {
                    $fresh['pemeriksaan'] = $this->pemeriksaan;
                }

                // PATCH: replace hanya subtree 'pemeriksaan' dari form saat ini
                $fresh['pemeriksaan'] = $this->dataDaftarPoliRJ['pemeriksaan'];

                // Tulis dalam transaksi
                DB::transaction(function () use ($rjNo, $fresh) {
                    // gunakan helper trait seperti di Anamnesa
                    $this->updateJsonRJ($rjNo, $fresh); // RACE-FIX: single writer, bukan json_encode manual
                });

                // Sinkronkan state komponen
                $this->dataDaftarPoliRJ = $fresh;
            });
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sedang sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');

            return;
        }

        // 4) Broadcast ke modul lain

        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
            ->addSuccess('Pemeriksaan berhasil disimpan.');
    }

    // ==========================
    // Lab
    // ==========================
    private function openModalLaboratorium(): void
    {
        $this->isOpenLaboratorium = true;
        $this->isOpenModeLaboratorium = 'insert';
    }

    public function pemeriksaanLaboratorium()
    {
        $this->openModalLaboratorium();
        $this->renderisPemeriksaanLaboratorium();
    }

    public function closeModalLaboratorium(): void
    {
        $this->reset([
            'isOpenLaboratorium',
            'isOpenModeLaboratorium',
            'isPemeriksaanLaboratorium',
            'isPemeriksaanLaboratoriumSelected',
            'isPemeriksaanLaboratoriumSelectedKeyHdr',
            'isPemeriksaanLaboratoriumSelectedKeyDtl'
        ]);
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
                $isPemeriksaanLaboratorium->map(function ($row) {
                    $row->labStatus = 0;
                    return $row;
                }),
                true
            );
        }
    }

    public function PemeriksaanLaboratoriumIsSelectedFor($key): void
    {
        $this->isPemeriksaanLaboratorium[$key]['labStatus'] =
            $this->isPemeriksaanLaboratorium[$key]['labStatus'] ? 0 : 1;
        $this->renderPemeriksaanLaboratoriumIsSelected($key);
    }

    public function RemovePemeriksaanLaboratoriumIsSelectedFor($key): void
    {
        $this->isPemeriksaanLaboratorium[$key]['labStatus'] =
            $this->isPemeriksaanLaboratorium[$key]['labStatus'] ? 0 : 1;
        $this->renderPemeriksaanLaboratoriumIsSelected($key);
    }

    private function renderPemeriksaanLaboratoriumIsSelected($key): void
    {
        $this->isPemeriksaanLaboratoriumSelected = collect($this->isPemeriksaanLaboratorium)
            ->where('labStatus', 1)
            ->values();
    }

    public function kirimLaboratorium()
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        if (!$this->checkRjStatus($this->rjNoRef)) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Data pasien terkunci, pasien sudah pulang.');
            return;
        }



        $sql = "select rj_status from rstxn_rjhdrs where rj_no=:rjNo";
        $checkStatusRJ = DB::scalar($sql, ["rjNo" => $rjNo]);

        if ($checkStatusRJ !== 'A') {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addWarning('Pasien sudah pulang. Pemeriksaan tidak dapat dilanjutkan.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            // RACE-FIX: protect penulisan header/dtl + patch JSON sekaligus
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {

                // 1) Fresh
                $freshWrap = $this->findDataRJ($rjNo);
                $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                if (!is_array($fresh)) $fresh = [];
                if (!isset($fresh['pemeriksaan']) || !is_array($fresh['pemeriksaan'])) {
                    $fresh['pemeriksaan'] = $this->pemeriksaan;
                }
                if (!isset($fresh['pemeriksaan']['pemeriksaanPenunjang'])) {
                    $fresh['pemeriksaan']['pemeriksaanPenunjang'] = ['lab' => [], 'rad' => []];
                }

                // 2) Generate nomor & insert ke tabel LAB dalam transaksi
                DB::transaction(function () use (&$fresh, $rjNo) {

                    $hdrIndex = collect($fresh['pemeriksaan']['pemeriksaanPenunjang']['lab'])->count();

                    $sql = "select nvl(max(to_number(checkup_no))+1,1) from lbtxn_checkuphdrs";
                    $checkupNo = DB::scalar($sql);

                    // Insert hdr
                    DB::table('lbtxn_checkuphdrs')->insert([
                        'reg_no' => $fresh['regNo'],
                        'dr_id' => $fresh['drId'],
                        'checkup_date' => DB::raw("to_date('" . Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'))->format('d/m/Y H:i:s') . "','dd/mm/yyyy hh24:mi:ss')"),
                        'status_rjri' => 'RJ',
                        'checkup_status' => 'P',
                        'ref_no' => $rjNo,
                        'checkup_no' => $checkupNo,
                    ]);

                    $selected = collect($this->isPemeriksaanLaboratorium)->where('labStatus', 1)->values();

                    // Simpan ke JSON (dtl preview)
                    $fresh['pemeriksaan']['pemeriksaanPenunjang']['lab'][$hdrIndex]['labHdr'] = [
                        'labHdrNo' => $checkupNo,
                        'labHdrDate' => Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'))->format('d/m/Y H:i:s'),
                        'labDtl' => $selected->toArray(),
                    ];

                    // Insert dtl utama + subitems
                    foreach ($selected as $labDtl) {
                        $sql = "select nvl(to_number(max(checkup_dtl))+1,1) from LBTXN_CHECKUPDTLS";
                        $checkupDtl = DB::scalar($sql);

                        DB::table('lbtxn_checkupdtls')->insert([
                            'clabitem_id' => $labDtl['clabitem_id'],
                            'checkup_no' => $checkupNo,
                            'checkup_dtl' => $checkupDtl,
                            'lab_item_code' => $labDtl['item_code'],
                            'price' => $labDtl['price']
                        ]);

                        // subitems
                        $items = DB::table('lbmst_clabitems')
                            ->select('clabitem_desc', 'clabitem_id', 'price', 'clabitem_group', 'item_code')
                            ->where('clabitem_group', $labDtl['clabitem_id'])
                            ->orderBy('item_seq', 'asc')
                            ->orderBy('clabitem_desc', 'asc')
                            ->get();

                        foreach ($items as $item) {
                            $sql = "select nvl(to_number(max(checkup_dtl))+1,1) from LBTXN_CHECKUPDTLS";
                            $checkupDtl = DB::scalar($sql);

                            DB::table('lbtxn_checkupdtls')->insert([
                                'clabitem_id' => $items->clabitem_id,
                                'checkup_no' => $checkupNo,
                                'checkup_dtl' => $checkupDtl,
                                'lab_item_code' => $items->item_code,
                                'price' => $items->price
                            ]);
                        }
                    }

                    // Tulis balik JSON RJ (single writer)
                    $this->updateJsonRJ($rjNo, $fresh);
                });

                // sinkronkan state komponen
                $this->dataDaftarPoliRJ = $fresh;
            });

            $this->closeModalLaboratorium();
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Permintaan laboratorium berhasil dikirim.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sedang sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');
        }
    }

    // ==========================
    // Radiologi
    // ==========================
    private function openModalRadiologi(): void
    {
        $this->isOpenRadiologi = true;
        $this->isOpenModeRadiologi = 'insert';
    }

    public function pemeriksaanRadiologi()
    {
        $this->openModalRadiologi();
        $this->renderisPemeriksaanRadiologi();
    }

    public function closeModalRadiologi(): void
    {
        $this->reset([
            'isOpenRadiologi',
            'isOpenModeRadiologi',
            'isPemeriksaanRadiologi',
            'isPemeriksaanRadiologiSelected',
            'isPemeriksaanRadiologiSelectedKeyHdr',
            'isPemeriksaanRadiologiSelectedKeyDtl'
        ]);
    }

    private function renderisPemeriksaanRadiologi()
    {
        if (empty($this->isPemeriksaanRadiologi)) {
            $isPemeriksaanRadiologi = DB::table('rsmst_radiologis')
                ->select('rad_desc', 'rad_price', 'rad_id')
                ->orderBy('rad_desc', 'asc')
                ->get();

            $this->isPemeriksaanRadiologi = json_decode(
                $isPemeriksaanRadiologi->map(function ($row) {
                    $row->radStatus = 0;
                    return $row;
                }),
                true
            );
        }
    }

    public function PemeriksaanRadiologiIsSelectedFor($key): void
    {
        $this->isPemeriksaanRadiologi[$key]['radStatus'] =
            $this->isPemeriksaanRadiologi[$key]['radStatus'] ? 0 : 1;
        $this->renderPemeriksaanRadiologiIsSelected($key);
    }

    public function RemovePemeriksaanRadiologiIsSelectedFor($key): void
    {
        $this->isPemeriksaanRadiologi[$key]['radStatus'] =
            $this->isPemeriksaanRadiologi[$key]['radStatus'] ? 0 : 1;
        $this->renderPemeriksaanRadiologiIsSelected($key);
    }

    private function renderPemeriksaanRadiologiIsSelected($key): void
    {
        $this->isPemeriksaanRadiologiSelected = collect($this->isPemeriksaanRadiologi)
            ->where('radStatus', 1)
            ->values();
    }

    public function kirimRadiologi()
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }
        if (!$this->checkRjStatus($this->rjNoRef)) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Data pasien terkunci, pasien sudah pulang.');
            return;
        }


        $sql = "select rj_status from rstxn_rjhdrs where rj_no=:rjNo";
        $checkStatusRJ = DB::scalar($sql, ["rjNo" => $rjNo]);

        if ($checkStatusRJ !== 'A') {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addWarning('Pasien sudah pulang. Pemeriksaan tidak dapat dilanjutkan.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            // RACE-FIX
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {

                DB::transaction(function () use ($rjNo) {

                    // fresh
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!is_array($fresh)) $fresh = [];
                    if (!isset($fresh['pemeriksaan']) || !is_array($fresh['pemeriksaan'])) {
                        $fresh['pemeriksaan'] = $this->pemeriksaan;
                    }
                    if (!isset($fresh['pemeriksaan']['pemeriksaanPenunjang'])) {
                        $fresh['pemeriksaan']['pemeriksaanPenunjang'] = ['lab' => [], 'rad' => []];
                    }

                    $hdrIndex = collect($fresh['pemeriksaan']['pemeriksaanPenunjang']['rad'])->count();

                    $selected = collect($this->isPemeriksaanRadiologi)->where('radStatus', 1)->values();

                    // simpan JSON
                    $fresh['pemeriksaan']['pemeriksaanPenunjang']['rad'][$hdrIndex]['radHdr'] = [
                        'radHdrNo' => $rjNo,
                        'radHdrDate' => Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'))->format('d/m/Y H:i:s'),
                        'radDtl' => $selected->toArray(),
                    ];

                    // insert dtl DB
                    foreach ($selected as $radDtl) {
                        $sql = "select nvl(max(rad_dtl)+1,1) from rstxn_rjrads";
                        $checkupDtl = DB::scalar($sql);

                        DB::table('rstxn_rjrads')->insert([
                            'rad_dtl' => $checkupDtl,
                            'rad_id' => $radDtl['rad_id'],
                            'rj_no' => $rjNo,
                            'rad_price' => $radDtl['rad_price'],
                            'dr_radiologi' => 'dr. M.A. Budi Purwito, Sp.Rad.',
                            'waktu_entry' => DB::raw("to_date('" . Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'))->format('d/m/Y H:i:s') . "','dd/mm/yyyy hh24:mi:ss')"),
                        ]);
                    }

                    // write JSON RJ
                    $this->updateJsonRJ($rjNo, $fresh);

                    // sinkronkan state
                    $this->dataDaftarPoliRJ = $fresh;
                });
            });

            $this->closeModalRadiologi();
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Permintaan radiologi berhasil dikirim.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sedang sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');
        }
    }

    // ==========================
    // LOV Kesadaran
    // ==========================
    public function clicktingkatKesadaranlov()
    {
        $this->tingkatKesadaranLovStatus = true;

        $json = DB::table('ref_bpjs_table')
            ->whereRaw('upper(ref_keterangan) = ?', [strtoupper('Kesadaran')])
            ->value('ref_json');

        $getKesadaran = json_decode($json ?? '[]', true);

        $this->tingkatKesadaranLov = collect($getKesadaran)->map(function ($item) {
            return [
                'tingkatKesadaranId' => $item['kdSadar'] ?? '',
                'tingkatKesadaranDesc' => $item['nmSadar'] ?? '',
            ];
        })->toArray();
    }

    public function setMytingkatKesadaranLov($id, $desc)
    {
        $this->dataDaftarPoliRJ['pemeriksaan']['tandaVital']['tingkatKesadaran'] = $id;
        $this->dataDaftarPoliRJ['pemeriksaan']['tandaVital']['tingkatKesadaranDesc'] = $desc;

        $this->tingkatKesadaranLovStatus = false;
        $this->tingkatKesadaranLovSearch = '';
    }

    // ==========================
    // Validation helpers
    // ==========================
    private function validateDataRJ(): void
    {
        $sql = "select birth_date from rsmst_pasiens where reg_no=:regNo";
        $birthDate = DB::scalar($sql, ["regNo" => $this->dataDaftarPoliRJ['regNo'] ?? null]);
        if ($birthDate) {
            $cekUsia = Carbon::createFromFormat('Y-m-d H:i:s', $birthDate)
                ->diff(Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta')))
                ->format('%y');

            if ((int)$cekUsia > 13) {
                // (range tetap sama, hanya memastikan required)
                $this->rules['dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik'] = 'required|numeric|min:40|max:250';
                $this->rules['dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik'] = 'required|numeric|min:30|max:180';
            }
        }

        $this->validate($this->rules, $this->messages);
    }

    // ==========================
    // Upload Hasil Penunjang
    // ==========================
    public function uploadHasilPenunjang(): void
    {
        $rules = [
            "filePDF" => "bail|required|mimes:pdf|max:10240",
            "descPDF" => "bail|required|max:255"
        ];
        $this->validate($rules, []);

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {

                    $file = $this->filePDF->store('uploadHasilPenunjang');

                    // fresh
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!isset($fresh['pemeriksaan']) || !is_array($fresh['pemeriksaan'])) {
                        $fresh['pemeriksaan'] = $this->pemeriksaan;
                    }

                    $fresh['pemeriksaan']['uploadHasilPenunjang'] =
                        $fresh['pemeriksaan']['uploadHasilPenunjang'] ?? [];

                    $fresh['pemeriksaan']['uploadHasilPenunjang'][] = [
                        'file' => $file,
                        'desc' => $this->descPDF,
                        'tglUpload' => Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'))->format('d/m/Y H:i:s'),
                        'penanggungJawab' => [
                            'userLog' => auth()->user()->myuser_name,
                            'userLogDate' => Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'))->format('d/m/Y H:i:s'),
                            'userLogCode' => auth()->user()->myuser_code
                        ]
                    ];

                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarPoliRJ = $fresh;
                    $this->reset(['filePDF', 'descPDF']);
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Hasil penunjang berhasil diunggah.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sedang sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');
        }
    }

    public function deleteHasilPenunjang($file): void
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo, $file) {
                DB::transaction(function () use ($rjNo, $file) {

                    Storage::delete($file);

                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!isset($fresh['pemeriksaan']) || !is_array($fresh['pemeriksaan'])) {
                        $fresh['pemeriksaan'] = $this->pemeriksaan;
                    }

                    $list = collect($fresh['pemeriksaan']['uploadHasilPenunjang'] ?? [])
                        ->where('file', '!=', $file)->values()->toArray();

                    $fresh['pemeriksaan']['uploadHasilPenunjang'] = $list;

                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarPoliRJ = $fresh;
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Hasil penunjang berhasil dihapus.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sedang sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');
        }
    }

    // ==========================
    // Data & Helpers
    // ==========================
    private function findData($rjno): void
    {
        $findDataRJ = $this->findDataRJ($rjno);
        $this->dataDaftarPoliRJ  = $findDataRJ['dataDaftarRJ'] ?? [];

        if (!isset($this->dataDaftarPoliRJ['pemeriksaan']) || !is_array($this->dataDaftarPoliRJ['pemeriksaan'])) {
            $this->dataDaftarPoliRJ['pemeriksaan'] = $this->pemeriksaan;
        }
        if (!isset($this->dataDaftarPoliRJ['pemeriksaan']['pemeriksaanPenunjang'])) {
            $this->dataDaftarPoliRJ['pemeriksaan']['pemeriksaanPenunjang'] = ['lab' => [], 'rad' => []];
        }
    }

    private function setDataPrimer(): void {}

    private function scoringIMT(): void
    {
        $bb = (float)($this->dataDaftarPoliRJ['pemeriksaan']['nutrisi']['bb'] ?? 0);
        $tb = (float)($this->dataDaftarPoliRJ['pemeriksaan']['nutrisi']['tb'] ?? 0);

        if ($bb > 0 && $tb > 0) {
            $this->dataDaftarPoliRJ['pemeriksaan']['nutrisi']['imt'] = round($bb / (($tb / 100) ** 2), 2);
        }
    }

    // ==========================
    // Lifecycle
    // ==========================
    public function mount(): void
    {
        $this->findData($this->rjNoRef);
    }

    public function render()
    {
        return view(
            'livewire.r-j.emr-r-j.mr-r-j.pemeriksaan.pemeriksaan',
            [
                'myTitle'   => 'Pemeriksaan',
                'mySnipt'   => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
            ]
        );
    }
}
