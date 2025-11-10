<?php

namespace App\Http\Livewire\RJ\EmrRJ\MrRJ\Perencanaan;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Carbon\Carbon;
use App\Http\Traits\EmrRJ\EmrRJTrait;

class Perencanaan extends Component
{
    use WithPagination, EmrRJTrait;
    protected $listeners = ['emr:rj:store' => 'store'];


    public $rjNoRef;

    public array $dataDaftarPoliRJ = [];

    public array $perencanaan = [
        'terapiTab' => 'Terapi',
        'terapi' => ['terapi' => ''],

        'tindakLanjutTab' => 'Tindak Lanjut',
        'tindakLanjut' => [
            'tindakLanjut' => '',
            'tindakLanjutDesc' => '',
            'keteranganTindakLanjut' => '',
        ],

        'pengkajianMedisTab' => 'Petugas Medis',
        'pengkajianMedis' => [
            'waktuPemeriksaan' => '',
            'selesaiPemeriksaan' => '',
            'drPemeriksa' => '',
        ],

        'rawatInapTab' => 'Rawat Inap',
        'rawatInap' => [
            'noRef' => '',
            'tanggal' => '',
            'keterangan' => '',
        ],

        'dischargePlanningTab' => 'Discharge Planning',
        'dischargePlanning' => [
            'pelayananBerkelanjutan' => [
                'pelayananBerkelanjutan' => 'Tidak Ada',
                'pelayananBerkelanjutanOption' => [
                    ['pelayananBerkelanjutan' => 'Tidak Ada'],
                    ['pelayananBerkelanjutan' => 'Ada'],
                ],
            ],
            'pelayananBerkelanjutanOpsi' => [
                'rawatLuka' => [],
                'dm' => [],
                'ppok' => [],
                'hivAids' => [],
                'dmTerapiInsulin' => [],
                'ckd' => [],
                'tb' => [],
                'stroke' => [],
                'kemoterapi' => [],
            ],

            'penggunaanAlatBantu' => [
                'penggunaanAlatBantu' => 'Tidak Ada',
                'penggunaanAlatBantuOption' => [
                    ['penggunaanAlatBantu' => 'Tidak Ada'],
                    ['penggunaanAlatBantu' => 'Ada'],
                ],
            ],
            'penggunaanAlatBantuOpsi' => [
                'kateterUrin' => [],
                'ngt' => [],
                'traechotomy' => [],
                'colostomy' => [],
            ],
        ],
    ];

    // rules kamu
    protected $rules = [
        // ubah sesuai kebutuhan (mis. required|in:..., atau nullable)
        'dataDaftarPoliRJ.perencanaan.pengkajianMedis.drPemeriksa' => '',
        // kalau kamu validasi waktu, boleh tambahkan juga:
        'dataDaftarPoliRJ.perencanaan.pengkajianMedis.waktuPemeriksaan'   => 'date_format:d/m/Y H:i:s',
        'dataDaftarPoliRJ.perencanaan.pengkajianMedis.selesaiPemeriksaan' => 'date_format:d/m/Y H:i:s',
    ];

    // pesan kustom
    protected $messages = [
        'dataDaftarPoliRJ.perencanaan.pengkajianMedis.drPemeriksa.required' => ':attribute wajib diisi.',
        'dataDaftarPoliRJ.perencanaan.pengkajianMedis.drPemeriksa.in'       => ':attribute tidak valid.',

        // kalau pakai date_format pada field waktu:
        'dataDaftarPoliRJ.perencanaan.pengkajianMedis.waktuPemeriksaan.required'   => ':attribute wajib diisi.',
        'dataDaftarPoliRJ.perencanaan.pengkajianMedis.waktuPemeriksaan.date_format' => ':attribute harus dengan format :format.',
        'dataDaftarPoliRJ.perencanaan.pengkajianMedis.selesaiPemeriksaan.required' => ':attribute wajib diisi.',
        'dataDaftarPoliRJ.perencanaan.pengkajianMedis.selesaiPemeriksaan.date_format' => ':attribute harus dengan format :format.',
    ];

    // label/atribut yang ramah
    protected $validationAttributes = [
        'dataDaftarPoliRJ.perencanaan.pengkajianMedis.drPemeriksa' => 'Dokter pemeriksa',
    ];


    public function updated($propertyName)
    {
        // RACE-FIX: jangan autosave setiap ketikan
        if (str_starts_with($propertyName, 'dataDaftarPoliRJ.perencanaan.')) {
            $this->validateOnly($propertyName);
        }
    }

    private function validateDataRJ(): void
    {
        try {
            $this->validate($this->rules, $this->messages, $this->validationAttributes);
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Lakukan pengecekan kembali Input Data.');
            $this->validate($this->rules, $this->messages, $this->validationAttributes);
        }
    }

    // ==========================
    // Single-writer saver
    // ==========================
    public function store(): void
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }


        // validasi ringan
        $this->validateDataRJ();

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                // FRESH first
                $freshWrap = $this->findDataRJ($rjNo);
                $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                if (!is_array($fresh)) $fresh = [];
                if (!isset($fresh['perencanaan']) || !is_array($fresh['perencanaan'])) {
                    $fresh['perencanaan'] = $this->perencanaan;
                }

                // PATCH hanya subtree 'perencanaan' dari state sekarang (UI)
                $fresh['perencanaan'] = $this->dataDaftarPoliRJ['perencanaan'] ?? $fresh['perencanaan'];

                DB::transaction(function () use ($rjNo, $fresh) {
                    // single writer JSON
                    $this->updateJsonRJ($rjNo, $fresh);
                });

                // sinkronkan state komponen
                $this->dataDaftarPoliRJ = $fresh;
            });


            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Perencanaan berhasil disimpan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');
        }
    }

    // ==========================
    // Helpers that also write (wrap with lock)
    // ==========================
    public function setWaktuPemeriksaan($myTime): void
    {
        $this->dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['waktuPemeriksaan'] = $myTime;
        // simpan via single-writer
        $this->store();
    }

    public function setSelesaiPemeriksaan($myTime): void
    {
        $this->dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['selesaiPemeriksaan'] = $myTime;
        $this->store();
    }

    private function validateDrPemeriksa(): void
    {
        $rules = [
            'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi'  => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas' => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu'           => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.tandaVital.spo2'           => 'numeric',
            'dataDaftarPoliRJ.pemeriksaan.tandaVital.gda'            => 'numeric',

            'dataDaftarPoliRJ.pemeriksaan.nutrisi.bb'   => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.nutrisi.tb'   => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.nutrisi.imt'  => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.nutrisi.lk'   => 'numeric',
            'dataDaftarPoliRJ.pemeriksaan.nutrisi.lila' => 'numeric',

            'dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.jamDatang' => 'required|date_format:d/m/Y H:i:s',
        ];

        try {
            $this->validate($rules, []);
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Anda tidak dapat melakukan TTD-E karena data pemeriksaan belum lengkap.');
            $this->validate($rules, []);
        }
    }

    public function setDrPemeriksa(): void
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $this->validateDrPemeriksa();

        $myUserCodeActive = auth()->user()->myuser_code;
        $myUserNameActive = auth()->user()->myuser_name;

        if (!auth()->user()->hasRole('Dokter')) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Anda tidak dapat melakukan TTD-E karena User Role ' . $myUserNameActive . ' Bukan Dokter');
            return;
        }
        if (($this->dataDaftarPoliRJ['drId'] ?? null) !== $myUserCodeActive) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Anda tidak dapat melakukan TTD-E karena Bukan Pasien ' . $myUserNameActive);
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {
                    // fresh
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!isset($fresh['perencanaan']) || !is_array($fresh['perencanaan'])) {
                        $fresh['perencanaan'] = $this->perencanaan;
                    }

                    // PATCH hanya subtree 'perencanaan ketika ada perubahan terakhir' dari state sekarang (UI)
                    $fresh['perencanaan'] = $this->dataDaftarPoliRJ['perencanaan'] ?? $fresh['perencanaan'];
                    // set dr pemeriksa + set ERM status
                    $fresh['perencanaan']['pengkajianMedis']['drPemeriksa'] =
                        $fresh['drDesc'] ?? 'Dokter pemeriksa';
                    $fresh['ermStatus'] = 'L';

                    // update header ERM status juga
                    DB::table('rstxn_rjhdrs')
                        ->where('rj_no', $rjNo)
                        ->update(['erm_status' => $fresh['ermStatus']]);

                    // tulis JSON
                    $this->updateJsonRJ($rjNo, $fresh);

                    // sync
                    $this->dataDaftarPoliRJ = $fresh;
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('TTD-E berhasil.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');
        }
    }

    public function openModalEresepRJ(): void
    {
        $this->isOpenEresepRJ = true;
        $this->isOpenModeEresepRJ = 'insert';
    }
    public function closeModalEresepRJ(): void
    {
        $this->isOpenEresepRJ = false;
        $this->isOpenModeEresepRJ = 'insert';
    }

    public bool $isOpenEresepRJ = false;
    public string $isOpenModeEresepRJ = 'insert';
    public string $activeTabRacikanNonRacikan = 'NonRacikan';
    public array $EmrMenuRacikanNonRacikan = [
        ['ermMenuId' => 'NonRacikan', 'ermMenuName' => 'NonRacikan'],
        ['ermMenuId' => 'Racikan', 'ermMenuName' => 'Racikan'],
    ];

    public function simpanTerapi(): void
    {
        // RJ No
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {

                    // 1) Ambil data FRESH
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];

                    // 2) Rakit terapi dari FRESH (bukan dari state lama)
                    $eresep = $fresh['eresep'] ?? [];
                    $eresepRacikan = $fresh['eresepRacikan'] ?? [];

                    // Non-racikan
                    $eresepStr = '';
                    foreach ($eresep as $value) {
                        $catatanKhusus = !empty($value['catatanKhusus']) ? ' (' . $value['catatanKhusus'] . ')' : '';
                        $eresepStr .= 'R/ ' . ($value['productName'] ?? '') .
                            ' | No. ' . ($value['qty'] ?? '') .
                            ' | S ' . ($value['signaX'] ?? '') . 'dd' . ($value['signaHari'] ?? '') .
                            $catatanKhusus . PHP_EOL;
                    }

                    // Racikan
                    $racikanStr = '';
                    foreach ($eresepRacikan as $value) {
                        if (!isset($value['jenisKeterangan'])) continue;
                        $noR   = $value['noRacikan']   ?? '';
                        $prod  = $value['productName'] ?? '';
                        $dosis = $value['dosis']       ?? '';
                        $jmlR  = !empty($value['qty'])
                            ? ('Jml Racikan ' . $value['qty'] . ' | ' . ($value['catatan'] ?? '') .
                                ' | S ' . ($value['catatanKhusus'] ?? '') . PHP_EOL)
                            : '';
                        $racikanStr .= $noR . '/ ' . $prod . ' - ' . $dosis . PHP_EOL . $jmlR;
                    }

                    // 3) Siapkan subtree perencanaan di FRESH, lalu set terapi
                    if (!isset($fresh['perencanaan']) || !is_array($fresh['perencanaan'])) {
                        $fresh['perencanaan'] = $this->perencanaan ?? [];
                    }
                    if (!isset($fresh['perencanaan']['terapi']) || !is_array($fresh['perencanaan']['terapi'])) {
                        $fresh['perencanaan']['terapi'] = [];
                    }

                    $fresh['perencanaan']['terapi']['terapi'] = trim($eresepStr . $racikanStr);

                    // 4) Commit JSON + sinkron state
                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarPoliRJ = $fresh;
                });
            });

            $this->closeModalEresepRJ();
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Terapi disimpan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');
        }
    }


    public function setstatusPRB(): void
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!isset($fresh['perencanaan']) || !is_array($fresh['perencanaan'])) {
                        $fresh['perencanaan'] = $this->perencanaan;
                    }

                    $curr = $fresh['statusPRB']['penanggungJawab']['statusPRB'] ?? 0;
                    $statusPRB = $curr ? 0 : 1;

                    $fresh['statusPRB']['penanggungJawab'] = [
                        'statusPRB'   => $statusPRB,
                        'userLog'     => auth()->user()->myuser_name,
                        'userLogDate' => Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'))->format('d/m/Y H:i:s'),
                        'userLogCode' => auth()->user()->myuser_code,
                    ];

                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarPoliRJ = $fresh;
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Status PRB diperbarui.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');
        }
    }

    // ==========================
    // LOV & bootstrap options
    // ==========================
    public $prognosaLov = [];
    public $prognosaLovStatus = 0;
    public $prognosaLovSearch = '';

    public function clickprognosalov(): void
    {
        $this->prognosaLovStatus = 1;
        $getprognosa = json_decode(
            DB::table('ref_bpjs_table')
                ->whereRaw('upper(ref_keterangan)=?', ['PROGNOSA'])
                ->value('ref_json') ?? '[]',
            true
        );

        $this->prognosaLov = collect($getprognosa)->map(function ($item) {
            return [
                'prognosaId' => $item['kdPrognosa'] ?? '',
                'prognosaDesc' => $item['nmPrognosa'] ?? '',
            ];
        })->toArray();
    }

    public function setMyprognosaLov($id, $desc): void
    {
        $this->dataDaftarPoliRJ['perencanaan']['prognosa']['prognosa'] = $id;
        $this->dataDaftarPoliRJ['perencanaan']['prognosa']['prognosaDesc'] = $desc;
        $this->prognosaLovStatus = 0;
        $this->prognosaLovSearch = '';
        $this->store();
    }

    private function setstatusPulangRJ(): void
    {
        if (!isset($this->dataDaftarPoliRJ['perencanaan']['tindakLanjut']['tindakLanjutOptions'])) {
            $raw = DB::table('ref_bpjs_table')
                ->whereRaw('upper(ref_keterangan)=?', ['STATUS PULANG RJ'])
                ->value('ref_json');
            $data = json_decode($raw ?? '[]', true);

            $this->dataDaftarPoliRJ['perencanaan']['tindakLanjut']['tindakLanjutOptions'] =
                collect($data)->map(function ($item) {
                    return [
                        'tindakLanjut' => $item['kdStatusPulang'] ?? '',
                        'tindakLanjutDesc' => $item['nmStatusPulang'] ?? '',
                    ];
                })->values()->toArray();
        }
    }

    private function syncDataFormEntry(): void
    {
        $this->setstatusPulangRJ();
    }

    private function findData($rjno): void
    {
        $wrap = $this->findDataRJ($rjno);
        $this->dataDaftarPoliRJ = $wrap['dataDaftarRJ'] ?? [];
        if (!isset($this->dataDaftarPoliRJ['perencanaan']) || !is_array($this->dataDaftarPoliRJ['perencanaan'])) {
            $this->dataDaftarPoliRJ['perencanaan'] = $this->perencanaan;
        }
    }

    public function mount(): void
    {
        $this->findData($this->rjNoRef);
    }

    public function render()
    {
        $this->syncDataFormEntry();
        return view('livewire.r-j.emr-r-j.mr-r-j.perencanaan.perencanaan', [
            'myTitle' => 'Perencanaan',
            'mySnipt' => 'Rekam Medis Pasien',
            'myProgram' => 'Pasien Rawat Jalan',
        ]);
    }
}
