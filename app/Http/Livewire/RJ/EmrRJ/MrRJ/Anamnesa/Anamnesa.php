<?php

namespace App\Http\Livewire\RJ\EmrRJ\MrRJ\Anamnesa;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

use App\Http\Traits\EmrRJ\EmrRJTrait;
use App\Http\Traits\MasterPasien\MasterPasienTrait;


class Anamnesa extends Component
{
    use WithPagination, EmrRJTrait, MasterPasienTrait;

    // ==========================
    // Listeners
    // ==========================
    protected $listeners = ['emr:rj:store' => 'store'];




    // ==========================
    // Refs & state
    // ==========================
    public $rjNoRef;

    public array $dataDaftarPoliRJ = [];

    public array $dataPasien = [];

    public array $rekonsiliasiObat = ["namaObat" => "", "dosis" => "", "rute" => ""];

    public array $anamnesa =
    [
        "pengkajianPerawatanTab" => "Pengkajian Perawatan",
        "pengkajianPerawatan" => [
            "perawatPenerima" => "",
            "jamDatang" => "",
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
            "alergi" => "",
            "alergiMakanan" => "00",
            "alergiMakananDesc" => "Tidak Ada",
            "alergiObat" => "00",
            "alergiObatDesc" => "Tidak Ada",
            "alergiUdara" => "00",
            "alergiUdaraDesc" => "Tidak Ada",
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
            "segeraKembaliRjjika" => "",
            "informedConsent" => "",
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



    // ==========================
    // Validation
    // ==========================
    protected $rules = [
        'dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.jamDatang' => 'required|date_format:d/m/Y H:i:s',
    ];

    protected $messages = [
        'dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.jamDatang.required' => 'Kolom :attribute wajib diisi.',
        'dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.jamDatang.date_format' => 'Format :attribute harus d/m/Y H:i:s (contoh: 05/11/2025 08:30:00).',
    ];

    protected $attributes = [
        'dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.jamDatang' => 'Jam Kedatangan Pasien',
    ];



    // ==========================
    // PUBLIC API (no autosave)
    // ==========================
    public function store(): void
    {
        // 1) Validasi form
        $this->validateDataAnamnesaRj();

        // 2) Pastikan kunci
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError("Nomor RJ kosong.");
            return;
        }

        $lockKey = "rj:{$rjNo}";

        // 3) Mutex + Transaction + Patch subtree
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {

                // Ambil FRESH state dari DB
                $freshWrap = $this->findDataRJ($rjNo);
                $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                if (!is_array($fresh)) $fresh = [];

                // Bootstrap subtree
                if (!isset($fresh['anamnesa']) || !is_array($fresh['anamnesa'])) {
                    $fresh['anamnesa'] = $this->anamnesa;
                }

                // PATCH: replace hanya subtree 'anamnesa' dari form saat ini
                $fresh['anamnesa'] = $this->dataDaftarPoliRJ['anamnesa'];

                // Tulis dalam transaksi
                DB::transaction(function () use ($rjNo, $fresh) {
                    $this->updateJsonRJ($rjNo, $fresh);

                    // sinkron alergi / riwayat ke master pasien jika perlu
                    $regNo = $fresh['regNo'] ?? ($this->dataDaftarPoliRJ['regNo'] ?? null);
                    if ($regNo) {
                        $this->dataPasien = $this->findDataMasterPasien($regNo);
                        $this->updateDataPasien($regNo);
                    }
                });

                // Sinkronkan state komponen
                $this->dataDaftarPoliRJ = $fresh;
            });
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');
            return;
        }

        // 4) Broadcast ke modul lain

        toastr()
            ->closeOnHover(true)
            ->closeDuration(3)
            ->positionClass('toast-top-left')
            ->addSuccess("Anamnesa berhasil disimpan.");
    }

    // ==========================
    // Private helpers
    // ==========================
    private function validateDataAnamnesaRj(): void
    {
        try {
            $this->validate($this->rules, $this->messages, $this->attributes);
        } catch (ValidationException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError("Periksa kembali input data Anda.");
            throw $e;
        }
    }

    private function findData($rjNo): void
    {
        $findDataRJ = $this->findDataRJ($rjNo);
        $this->dataDaftarPoliRJ = $findDataRJ['dataDaftarRJ'] ?? [];

        if (!isset($this->dataDaftarPoliRJ['anamnesa']) || !is_array($this->dataDaftarPoliRJ['anamnesa'])) {
            $this->dataDaftarPoliRJ['anamnesa'] = $this->anamnesa;
        }

        // Mirror dari master pasien (alergi/riwayat) bila kosong di form
        $this->matchingMyVariable();
    }

    private function matchingMyVariable(): void
    {
        // ---------- 1) Keluhan Utama: fallback dari screening jika kosong ----------
        $keluhanSaatIni = (string) data_get($this->dataDaftarPoliRJ, 'anamnesa.keluhanUtama.keluhanUtama', '');
        if ($keluhanSaatIni === '') {
            $keluhanScreening = (string) data_get($this->dataDaftarPoliRJ, 'screening.keluhanUtama', '');
            if ($keluhanScreening !== '') {
                data_set($this->dataDaftarPoliRJ, 'anamnesa.keluhanUtama.keluhanUtama', $keluhanScreening);
            }
        }

        // ---------- 2) Ambil data master pasien (read-only) ----------
        $regNo = data_get($this->dataDaftarPoliRJ, 'regNo');
        if ($regNo) {
            $this->dataPasien = $this->findDataMasterPasien($regNo) ?: [];
        }

        // ---------- 3) Alergi: isi dari master pasien jika kosong ----------
        $alergiForm = (string) data_get($this->dataDaftarPoliRJ, 'anamnesa.alergi.alergi', '');
        if ($alergiForm === '') {
            $alergiMaster = (string) data_get($this->dataPasien, 'pasien.alergi', '');
            if ($alergiMaster !== '') {
                data_set($this->dataDaftarPoliRJ, 'anamnesa.alergi.alergi', $alergiMaster);
            }
        }

        // ---------- 4) Riwayat Penyakit Dahulu: isi dari master pasien jika kosong ----------
        $rpdForm = (string) data_get($this->dataDaftarPoliRJ, 'anamnesa.riwayatPenyakitDahulu.riwayatPenyakitDahulu', '');
        if ($rpdForm === '') {
            $rpdMaster = (string) data_get($this->dataPasien, 'pasien.riwayatPenyakitDahulu', '');
            if ($rpdMaster !== '') {
                data_set($this->dataDaftarPoliRJ, 'anamnesa.riwayatPenyakitDahulu.riwayatPenyakitDahulu', $rpdMaster);
            }
        }

        // Catatan:
        // - Tidak ada pemanggilan updateDataPasien() di sini agar fungsi ini tidak melakukan write.
        // - Sinkron tulis balik ke master pasien (jika perlu) lakukan di proses save (store) dalam transaction+lock.
    }


    public function setJamDatang($myTime = null): void
    {
        $jam = $myTime ?: Carbon::now('Asia/Jakarta')->format('d/m/Y H:i:s');
        $this->dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['jamDatang'] = $jam;
    }

    private function updateDataPasien($regNo): void
    {
        if (!$regNo) return;

        if (!isset($this->dataPasien['pasien']['alergi'])) {
            $this->dataPasien['pasien']['alergi'] = "";
        }
        if (!isset($this->dataPasien['pasien']['riwayatPenyakitDahulu'])) {
            $this->dataPasien['pasien']['riwayatPenyakitDahulu'] = "";
        }

        $changed = false;

        // sinkron alergi
        $formAlergi = $this->dataDaftarPoliRJ['anamnesa']['alergi']['alergi'] ?? '';
        if (($this->dataPasien['pasien']['alergi'] ?? '') !== $formAlergi) {
            $this->dataPasien['pasien']['alergi'] = $formAlergi;
            $changed = true;
        }

        // sinkron riwayatPenyakitDahulu
        $formRPD = $this->dataDaftarPoliRJ['anamnesa']['riwayatPenyakitDahulu']['riwayatPenyakitDahulu'] ?? '';
        if (($this->dataPasien['pasien']['riwayatPenyakitDahulu'] ?? '') !== $formRPD) {
            $this->dataPasien['pasien']['riwayatPenyakitDahulu'] = $formRPD;
            $changed = true;
        }

        if ($changed) {
            DB::table('rsmst_pasiens')
                ->where('reg_no', $regNo)
                ->update([
                    'meta_data_pasien_json' => json_encode($this->dataPasien, JSON_UNESCAPED_UNICODE)
                ]);
        }
    }

    public function setPerawatPenerima(): void
    {
        $myUserCodeActive = auth()->user()->myuser_code;
        $myUserNameActive = auth()->user()->myuser_name;

        $this->validatePerawatPenerima();

        if (auth()->user()->hasRole('Perawat')) {
            $this->dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['perawatPenerima'] = $myUserNameActive;
            $this->dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['perawatPenerimaCode'] = $myUserCodeActive;
            $this->store();
        } else {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError("Maaf {$myUserNameActive}, Anda tidak memiliki hak akses untuk TTD-E. Fitur ini hanya untuk peran Perawat.");
        }
    }

    private function validatePerawatPenerima(): void
    {
        // Isi sesuai kebutuhanmu; contoh minimal guard:
        try {
            $this->validate([
                'dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.perawatPenerima' => ''
            ], []);
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError("Data pemeriksaan belum lengkap. TTD-E tidak dapat dilakukan.");
            throw $e;
        }
    }

    // ==========================
    // Rekonsiliasi Obat
    // ==========================
    public function addRekonsiliasiObat(): void
    {
        if (empty($this->rekonsiliasiObat['namaObat'])) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError("Nama obat wajib diisi.");
            return;
        }

        $exists = collect($this->dataDaftarPoliRJ['anamnesa']['rekonsiliasiObat'] ?? [])
            ->where('namaObat', $this->rekonsiliasiObat['namaObat'])
            ->count();

        if ($exists) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError("Nama obat sudah ada.");
            return;
        }

        $this->dataDaftarPoliRJ['anamnesa']['rekonsiliasiObat'][] = [
            "namaObat" => $this->rekonsiliasiObat['namaObat'],
            "dosis"    => $this->rekonsiliasiObat['dosis'],
            "rute"     => $this->rekonsiliasiObat['rute']
        ];

        $this->store();
        $this->reset(['rekonsiliasiObat']);
        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
            ->addSuccess("Obat berhasil ditambahkan.");
    }

    public function removeRekonsiliasiObat(string $namaObat): void
    {
        $list = collect($this->dataDaftarPoliRJ['anamnesa']['rekonsiliasiObat'] ?? [])
            ->reject(fn($i) => ($i['namaObat'] ?? '') === $namaObat)
            ->values()
            ->toArray();

        $this->dataDaftarPoliRJ['anamnesa']['rekonsiliasiObat'] = $list;

        $this->store();
        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
            ->addSuccess("Obat berhasil dihapus.");
    }




    // ======== PROPERTIES ========
    // Alergi Makanan
    public array $alergiMakananLov = [];
    public bool  $alergiMakananLovStatus = false;
    public string $alergiMakananLovSearch = '';

    // Alergi Obat
    public array $alergiObatLov = [];
    public bool  $alergiObatLovStatus = false;
    public string $alergiObatLovSearch = '';

    // Alergi Udara
    public array $alergiUdaraLov = [];
    public bool  $alergiUdaraLovStatus = false;
    public string $alergiUdaraLovSearch = '';


    // ======== PRIVATE HELPER (DRY) ========
    /**
     * Ambil LOV dari ref_bpjs_table berdasarkan kategori (ref_keterangan),
     * lalu mapping ke id/desc yang diminta. Bisa difilter dengan keyword (case-insensitive).
     *
     * @param string      $kategori   e.g. 'Alergi Makanan'
     * @param string      $idField    kolom id pada output (e.g. 'alergiMakananId')
     * @param string      $descField  kolom desc pada output (e.g. 'alergiMakananDesc')
     * @param string|null $keyword    filter contains pada nama alergi (nmAlergi)
     * @return array
     */
    private function loadLov(string $kategori, string $idField, string $descField, ?string $keyword = null): array
    {
        // Ambil ref_json langsung dengan value() → null-safe
        $json = DB::table('ref_bpjs_table')
            ->whereRaw('upper(ref_keterangan) = ?', [mb_strtoupper($kategori)])
            ->value('ref_json');

        $data = json_decode($json ?? '[]', true);
        if (!is_array($data)) $data = [];

        // Optional search (contains, case-insensitive)
        if ($keyword !== null && $keyword !== '') {
            $kw = mb_strtolower($keyword);
            $data = array_values(array_filter($data, function ($row) use ($kw) {
                $nm = mb_strtolower((string)($row['nmAlergi'] ?? ''));
                return $nm !== '' && str_contains($nm, $kw);
            }));
        }

        // Mapping ke bentuk uniform {idField, descField}
        return collect($data)->map(function ($item) use ($idField, $descField) {
            return [
                $idField   => $item['kdAlergi'] ?? '',
                $descField => $item['nmAlergi'] ?? '',
            ];
        })->values()->toArray();
    }


    // ======== ALERGI MAKANAN ========
    public function clickAlergiMakananLov(): void
    {
        $this->alergiMakananLovStatus = true;
        $this->alergiMakananLov = $this->loadLov(
            'Alergi Makanan',
            'alergiMakananId',
            'alergiMakananDesc',
            $this->alergiMakananLovSearch
        );
    }

    public function setMyAlergiMakananLov($id, $desc): void
    {
        data_set($this->dataDaftarPoliRJ, 'anamnesa.alergi.alergiMakanan', $id);
        data_set($this->dataDaftarPoliRJ, 'anamnesa.alergi.alergiMakananDesc', $desc);

        $this->alergiMakananLovStatus = false;
        $this->alergiMakananLovSearch = '';
        // Opsional: auto-save
        // $this->store();
    }


    // ======== ALERGI OBAT ========
    public function clickAlergiObatLov(): void
    {
        $this->alergiObatLovStatus = true;
        $this->alergiObatLov = $this->loadLov(
            'Alergi Obat',
            'alergiObatId',
            'alergiObatDesc',
            $this->alergiObatLovSearch
        );
    }

    public function setMyAlergiObatLov($id, $desc): void
    {
        data_set($this->dataDaftarPoliRJ, 'anamnesa.alergi.alergiObat', $id);
        data_set($this->dataDaftarPoliRJ, 'anamnesa.alergi.alergiObatDesc', $desc);

        $this->alergiObatLovStatus = false;
        $this->alergiObatLovSearch = '';
        // Opsional: auto-save
        // $this->store();
    }


    // ======== ALERGI UDARA ========
    public function clickAlergiUdaraLov(): void
    {
        $this->alergiUdaraLovStatus = true;
        $this->alergiUdaraLov = $this->loadLov(
            'Alergi Udara',
            'alergiUdaraId',
            'alergiUdaraDesc',
            $this->alergiUdaraLovSearch
        );
    }

    public function setMyAlergiUdaraLov($id, $desc): void
    {
        data_set($this->dataDaftarPoliRJ, 'anamnesa.alergi.alergiUdara', $id);
        data_set($this->dataDaftarPoliRJ, 'anamnesa.alergi.alergiUdaraDesc', $desc);

        $this->alergiUdaraLovStatus = false;
        $this->alergiUdaraLovSearch = '';
        // Opsional: auto-save
        // $this->store();
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
            'livewire.r-j.emr-r-j.mr-r-j.anamnesa.anamnesa',
            [
                'myTitle'   => 'Anamnesa',
                'mySnipt'   => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
            ]
        );
    }
}
