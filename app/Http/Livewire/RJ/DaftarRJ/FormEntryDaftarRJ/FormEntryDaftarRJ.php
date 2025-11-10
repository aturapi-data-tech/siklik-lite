<?php

namespace App\Http\Livewire\RJ\DaftarRJ\FormEntryDaftarRJ;

use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use App\Http\Traits\BPJS\PcareTrait;

use App\Http\Traits\EmrRJ\EmrRJTrait;
use App\Http\Traits\MasterPasien\MasterPasienTrait;

use App\Http\Traits\LOV\LOVDokter\LOVDokterTrait;
use App\Http\Traits\LOV\LOVPasien\LOVPasienTrait;

use Livewire\Component;

class FormEntryDaftarRJ extends Component
{
    use EmrRJTrait, LOVDokterTrait, LOVPasienTrait, MasterPasienTrait, PcareTrait;
    // listener from blade////////////////
    protected $listeners =  [];

    public string $rjNoRef;
    public bool $rjStatusRef = false;
    public string $isOpenMode = 'insert';

    public array $FormEntry = [];
    public array $displayPasien = [];
    public array $checkStatusKlaimPasien = [];


    public array $jenisKlaim = [
        'JenisKlaimId' => 'UM',
        'JenisKlaimDesc' => 'UMUM',
        'JenisKlaimOptions' => [
            ['JenisKlaimId' => 'UM', 'JenisKlaimDesc' => 'UMUM'],
            ['JenisKlaimId' => 'JM', 'JenisKlaimDesc' => 'BPJS'],
            ['JenisKlaimId' => 'JML', 'JenisKlaimDesc' => 'Asuransi Lain'],
        ]
    ];

    public array $kunjSakit = [
        'kunjSakitId' => '1',
        'kunjSakitDesc' => 'Ya',
        'kunjSakitOptions' => [
            ['kunjSakitId' => '1', 'kunjSakitDesc' => 'Ya'],
            ['kunjSakitId' => '0', 'kunjSakitDesc' => 'Tidak'],
        ]
    ]; // true false

    public array $refTkp = [
        'refTkpId' => '10',
        'refTkpDesc' => 'RJTP',
        'refTkpOptions' => [
            ['refTkpId' => '10', 'refTkpDesc' => 'RJTP'],
            ['refTkpId' => '20', 'refTkpDesc' => 'RITP'],
            ['refTkpId' => '50', 'refTkpDesc' => 'Promotif'],

        ]
    ]; // true false


    // LOV Nested
    public array $pasien;
    public array $dokter;
    // LOV Nested





    // rules///////////////////
    protected $rules = [
        'FormEntry.noKartu' => '',
        'FormEntry.rjDate' => 'bail|required|date_format:d/m/Y H:i:s|after_or_equal:today',
        'FormEntry.rjNo' => 'bail|required',
        'FormEntry.passStatus' => '',
        'FormEntry.noAntrian' => 'bail|required',
        'FormEntry.noBooking' => 'bail|required',




        'FormEntry.drId' => 'bail|required|exists:rsmst_doctors,dr_id',
        'FormEntry.drDesc' => 'bail|required',

        'FormEntry.poliId' => 'bail|required|exists:rsmst_polis,poli_id',
        'FormEntry.poliDesc' => 'bail|required',

        'FormEntry.klaimId' => 'bail|required|exists:rsmst_klaimtypes,klaim_id',

        'FormEntry.kddrbpjs' => '',
        'FormEntry.kdpolibpjs' => '',

        'FormEntry.rjStatus' => 'bail|required|in:A,L,F,I',
        'FormEntry.txnStatus' => 'bail|required|in:A,L,F,H',
        'FormEntry.ermStatus' => 'bail|required|in:A,L,F',
        'FormEntry.kunjSakit' => 'bail|required|in:1,0',
        'FormEntry.kdTkp' => 'bail|required|in:10,20,50', //"tkp": [{ "kdTkp": "10", "nmTkp": "RJTP" }, { "kdTkp": "20", "nmTkp": "RITP" }, { "kdTkp": "50", "nmTkp": "Promotif" }]
    ];




    protected $validationAttributes = [
        'FormEntry.rjDate' => 'Tanggal Rawat Jalan',
        'FormEntry.rjNo' => 'Nomor Rawat Jalan',
        'FormEntry.noKartu' => 'Id BPJS',
        'FormEntry.passStatus' => 'Status Pasien (Baru/Lama)',
        'FormEntry.noAntrian' => 'Nomor Antrian',
        'FormEntry.noBooking' => 'Nomor Booking',

        'FormEntry.regNo' => 'Nomor Registrasi',

        'FormEntry.drId' => 'Kode Dokter',
        'FormEntry.drDesc' => 'Nama Dokter',

        'FormEntry.poliId' => 'Kode Poli',
        'FormEntry.poliDesc' => 'Nama Poli',

        'FormEntry.klaimId' => 'Klaim',

        'FormEntry.kddrbpjs' => 'Kode Dokter BPJS',
        'FormEntry.kdpolibpjs' => 'Kode Poli BPJS',

        'FormEntry.rjStatus' => 'Status Rawat Jalan',
        'FormEntry.txnStatus' => 'Status Transaksi',
        'FormEntry.ermStatus' => 'Status Rekam Medis',
        'FormEntry.kunjSakit' => 'Kunjungan Sakit',
        'FormEntry.kdTkp' => 'Kode TKP',
    ];

    protected $messages = [
        // Tanggal dan Waktu Rawat Jalan
        'FormEntry.rjDate.required'         => 'Tanggal rawat jalan wajib diisi.',
        'FormEntry.rjDate.date_format'      => 'Format tanggal rawat jalan tidak valid. Gunakan format dd/mm/YYYY H:i:s.',
        'FormEntry.rjDate.after_or_equal'   => 'Tanggal rawat jalan tidak boleh lebih kecil dari hari ini.',

        // Nomor Rawat Jalan
        'FormEntry.rjNo.required'           => 'Nomor rawat jalan wajib diisi.',

        // Nomor Antrian dan Booking
        'FormEntry.noAntrian.required'      => 'Nomor antrian wajib diisi.',
        'FormEntry.noBooking.required'      => 'Nomor booking wajib diisi.',

        // Registrasi Pasien
        'FormEntry.regNo.required'          => 'Nomor registrasi wajib diisi.',
        'FormEntry.noKartu.required'          => 'Id BPJS wajib diisi.',

        'FormEntry.regNo.exists'            => 'Nomor registrasi tidak ditemukan.',

        // Dokter
        'FormEntry.drId.required'           => 'Dokter wajib dipilih.',
        'FormEntry.drId.exists'             => 'Dokter tidak valid.',
        'FormEntry.drDesc.required'         => 'Deskripsi dokter wajib diisi.',

        // Poli
        'FormEntry.poliId.required'         => 'Poli wajib dipilih.',
        'FormEntry.poliId.exists'           => 'Poli tidak valid.',
        'FormEntry.poliDesc.required'       => 'Deskripsi poli wajib diisi.',

        // Klaim
        'FormEntry.klaimId.required'        => 'Klaim wajib dipilih.',
        'FormEntry.klaimId.exists'          => 'Klaim tidak valid.',

        // Status Rawat Jalan dan Transaksi
        'FormEntry.rjStatus.required'       => 'Status rawat jalan wajib diisi.',
        'FormEntry.rjStatus.in'             => 'Status rawat jalan tidak valid. (A, L, F, I)',
        'FormEntry.txnStatus.required'      => 'Status transaksi wajib diisi.',
        'FormEntry.txnStatus.in'            => 'Status transaksi tidak valid. (A, L, F, H)',
        'FormEntry.ermStatus.required'      => 'Status EMR wajib diisi.',
        'FormEntry.ermStatus.in'            => 'Status EMR tidak valid. (A, L, F)',

        // Kunjungan Sakit
        'FormEntry.kunjSakit.required'      => 'Kunjungan sakit wajib diisi.',
        'FormEntry.kunjSakit.in'            => 'Nilai untuk kunjungan sakit tidak valid. (1, 0)',

        // Kode TKP
        'FormEntry.kdTkp.required'          => 'Kode TKP wajib diisi.',
        'FormEntry.kdTkp.in'                => 'Kode TKP tidak valid. (10, 20, 50)',
    ];

    // rules///////////////////



    private function generateSafeRjNo(): int
    {
        // 2) Fallback aman: hitung MAX di dalam lockForUpdate
        return Cache::lock('rj:seq', 5)->block(3, function () {
            $maxRow = DB::table('rstxn_rjhdrs')
                ->select(DB::raw('MAX(rj_no) AS max_rj_no'))
                ->first();
            return (int) ($maxRow->max_rj_no ?? 0) + 1;
        });
    }



    public function closeModal(): void
    {
        $this->emit('CloseModal');
    }


    public function cekStatusPasienBPJS(): void
    {
        $this->checkJnsKlaimPasien($this->FormEntry['klaimId'], $this->FormEntry['regNo']);
    }

    private function findData($id): void
    {
        if (empty($id)) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addWarning('ID Rawat Jalan tidak valid.');
            $this->emit('CloseModal');
            return;
        }

        try {
            $res = $this->findDataRJ($id);

            if (!is_array($res) || empty($res)) {
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addError('Data Rawat Jalan tidak ditemukan.');
                $this->emit('CloseModal');
                return;
            }

            if (!empty($res['errorMessages'])) {
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addError($res['errorMessages']);
                $this->emit('CloseModal');
                return;
            }

            if (empty($res['dataDaftarRJ'])) {
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addWarning('Data pendaftaran tidak tersedia.');
                $this->emit('CloseModal');
                return;
            }

            $this->FormEntry = $res['dataDaftarRJ'];
            $this->syncDataPrimer();
            $this->rjStatusRef = (bool) $this->checkRJStatus($id) ? false : true;
        } catch (\Throwable $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal memuat data: ' . $e->getMessage());
            $this->emit('CloseModal');
            return;
        }
    }



    private function update($rjNo): void
    {
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', '=', $rjNo)
            ->update([
                'rj_date'    => DB::raw("to_date('" . $this->FormEntry['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"),
                'reg_no'     => $this->FormEntry['regNo'],
                'nobooking'  => $this->FormEntry['noBooking'],
                'no_antrian' => $this->FormEntry['noAntrian'],
                'klaim_id'   => $this->FormEntry['klaimId'],
                'poli_id'    => $this->FormEntry['poliId'],
                'dr_id'      => $this->FormEntry['drId'],
                'txn_status' => $this->FormEntry['txnStatus'],
                'rj_status'  => $this->FormEntry['rjStatus'],
                'erm_status' => $this->FormEntry['ermStatus'],
                'pass_status' => $this->FormEntry['passStatus'],
            ]);
    }

    private function insert(): void
    {
        DB::table('rstxn_rjhdrs')->insert([
            'rj_no'      => $this->FormEntry['rjNo'],
            'rj_date'    => DB::raw("to_date('" . $this->FormEntry['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"),
            'reg_no'     => $this->FormEntry['regNo'],
            'nobooking'  => $this->FormEntry['noBooking'],
            'no_antrian' => $this->FormEntry['noAntrian'],
            'klaim_id'   => $this->FormEntry['klaimId'],
            'poli_id'    => $this->FormEntry['poliId'],
            'dr_id'      => $this->FormEntry['drId'],
            'txn_status' => $this->FormEntry['txnStatus'],
            'rj_status'  => $this->FormEntry['rjStatus'],
            'erm_status' => $this->FormEntry['ermStatus'],
            'pass_status' => $this->FormEntry['passStatus'],
        ]);
    }


    public function store(): void
    {

        // Lock per konteks pendaftaran untuk cegah submit paralel
        $rjDateRaw = $this->FormEntry['rjDate'] ?? Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s');
        $dateKey   = Carbon::createFromFormat('d/m/Y H:i:s', $rjDateRaw, env('APP_TIMEZONE'))->format('Ymd');

        // 3 placeholder: tanggal, dokter, poli
        $lockKey = sprintf(
            "rj:entry:%s:%s:%s",
            $dateKey,
            $this->FormEntry['drId']   ?? 'DR',
            $this->FormEntry['poliId'] ?? 'POLI'
        );

        try {
            Cache::lock($lockKey, 5)->block(3, function () {
                DB::transaction(function () {
                    // 1) Set data primer DI DALAM transaksi (rjNo & antrian aman)
                    $this->setDataPrimer();

                    // 2) Validasi setelah auto-fill
                    $this->validateData();

                    // 3) Cek duplikasi khusus BPJS dengan noUrut
                    if (($this->FormEntry['klaimId'] ?? '') === 'JM' && !empty($this->FormEntry['noUrutBpjs'])) {
                        $date = Carbon::createFromFormat('d/m/Y H:i:s', $this->FormEntry['rjDate'])->format('d/m/Y');

                        $exists = DB::table('rstxn_rjhdrs')
                            ->where('reg_no', $this->FormEntry['regNo'])
                            ->where('dr_id',   $this->FormEntry['drId'] ?? '')
                            ->where('poli_id', $this->FormEntry['poliId'] ?? '')
                            ->where('klaim_id', $this->FormEntry['klaimId'] ?? '')
                            ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), $date)
                            ->exists();

                        if ($exists) {
                            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                                ->addWarning('Pendaftaran dengan poli yang sama dalam satu hari sudah ada.');
                            return; // stop tanpa menulis
                        }
                    }

                    // 4) Tulis data atomik
                    if ($this->isOpenMode === 'insert') {
                        $this->insert();
                        $this->isOpenMode = 'update';
                    } else {
                        $this->update($this->rjNoRef);
                    }

                    // 5) Simpan JSON konsisten dengan transaksi
                    $this->updateJsonRJ($this->FormEntry['rjNo'], $this->FormEntry);

                    toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                        ->addSuccess($this->isOpenMode === 'update' ? 'Data berhasil diupdate.' : 'Data berhasil dimasukkan.');
                });

                // 6) Setelah COMMIT baru panggil PCare (hindari nahan lock/txn)
                DB::afterCommit(function () {
                    try {
                        $this->checkJnsKlaimPasien($this->FormEntry['klaimId'], $this->FormEntry['regNo']);
                        $this->addPedaftaranBPJS($this->FormEntry['klaimId']);
                    } catch (\Throwable $e) {
                        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                            ->addError('Registrasi tersimpan, namun integrasi PCare gagal: ' . $e->getMessage());
                    }
                });
            });
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk. Gagal memperoleh lock. Coba lagi.');
        } catch (\Throwable $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal menyimpan pendaftaran: ' . $e->getMessage());
        }
    }



    private function addPedaftaranBPJS($statusPasien): void
    {
        if ($statusPasien == 'JM') {
            $kdProvider = $this->checkStatusKlaimPasien['metadata']['code'] == 200 ?
                $this->checkStatusKlaimPasien['response']['kdProviderPst']['kdProvider']
                : '';

            if ($kdProvider !== env('PCARE_PROVIDER')) {
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addWarning('Kode Provider Peserta dari faskes lain / ' . $kdProvider);
            }

            try {
                $displayPasien  = $this->findDataMasterPasien($this->FormEntry['regNo']);
                $dataPedaftaran = [
                    "kdProviderPeserta" => $kdProvider,
                    "tglDaftar" => Carbon::createFromFormat('d/m/Y H:i:s', $this->FormEntry['rjDate'], env('APP_TIMEZONE'))->format('d-m-Y'),
                    "noKartu" => $displayPasien['pasien']['identitas']['idBpjs'] ?? '',
                    "kdPoli" => $this->FormEntry['kdpolibpjs'],
                    "keluhan" => 'null',
                    "kunjSakit" => !empty($this->FormEntry['kunjSakit']) ? true : false,
                    "sistole" => 0,
                    "diastole" => 0,
                    "beratBadan" => 0,
                    "tinggiBadan" => 0,
                    "respRate" => 0,
                    "lingkarPerut" => 0,
                    "heartRate" => 0,
                    "rujukBalik" => 0,
                    "kdTkp" => $this->FormEntry['kdTkp']
                ];
                $addPedaftaran = $this->addPedaftaran($dataPedaftaran)->getOriginalContent();
            } catch (Exception $e) {
                toastr()->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Gagal menambahkan pendaftaran BPJS: ' . $e->getMessage());
                return;
            }

            if (isset($addPedaftaran['metadata']['code']) && $addPedaftaran['metadata']['code'] == 201) {
                $this->FormEntry['noUrutBpjs'] = $addPedaftaran['response']['message'] ?? '';
                toastr()->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addSuccess('Pendaftaran BPJS berhasil ditambahkan.');
            } else {
                $msg = $addPedaftaran['metadata']['message'] ?? 'Terjadi kesalahan pada server BPJS.';
                toastr()->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError($msg);
            }
        }
    }

    public function deletePendaftaranPasienBPJS(string $statusPasien): void
    {
        // Hanya untuk pasien BPJS (status JM)
        if ($statusPasien !== 'JM') {
            return;
        }

        // 1. Ambil data peserta
        try {
            $displayPasien = $this->findDataMasterPasien($this->FormEntry['regNo']);
            $noKartu       = $displayPasien['pasien']['identitas']['idBpjs'] ?? '';
        } catch (Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Gagal mengambil data peserta: ' . $e->getMessage());
            return;
        }

        // 2. Siapkan parameter delete
        try {
            // Format tanggal pendaftaran dari formEntry (d/m/Y H:i:s → d-m-Y)
            $tglDaftar = Carbon::createFromFormat(
                'd/m/Y H:i:s',
                $this->FormEntry['rjDate'],
                env('APP_TIMEZONE')
            )->format('d-m-Y');
        } catch (Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Format tanggal pendaftaran tidak valid.');
            return;
        }


        $noUrut = $this->FormEntry['noUrutBpjs'] ?? '';
        $kdPoli = $this->FormEntry['kdpolibpjs'] ?? '';

        // 3. Panggil deletePedaftaran (method Anda sebelumnya)
        try {
            $result = $this
                ->deletePedaftaran($noKartu, $tglDaftar, $noUrut, $kdPoli)
                ->getOriginalContent();
        } catch (Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Error saat menghapus pendaftaran: ' . $e->getMessage());
            return;
        }


        // 4. Tangani response dari PCare
        if (isset($result['metadata']['code']) && $result['metadata']['code'] == 200) {
            // sukses: reset noUrutBpjs di formEntry
            $this->FormEntry['noUrutBpjs'] = null;

            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addSuccess('Pendaftaran BPJS berhasil dihapus.');
            return;
        } else {
            $msgResponse = $result['response']['message'] ?? 'x';
            $msg = $result['metadata']['message'] . ' ' . $msgResponse
                ?? 'Gagal menghapus pendaftaran.';

            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($msg);
            return;
        }
    }

    public function checkPendaftaranPasienBPJSbyNomorUrut(string $noUrut, string $tglDaftar): void
    {
        if (empty($noUrut) || empty($tglDaftar)) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor urut atau tanggal daftar tidak boleh kosong.');
            return;
        }

        try {
            $tglDaftarFormatted = Carbon::createFromFormat('d/m/Y H:i:s', $tglDaftar)->format('d-m-Y');
        } catch (\Exception $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Format tanggal tidak valid. Gunakan format dd/mm/yyyy hh:mm:ss');
            return;
        }

        try {
            $resp = $this->getPendaftaranbyNomorUrut($noUrut, $tglDaftarFormatted)->getData(true);
            // kirim ke front-end bila perlu:
            $this->emit('dataPendaftaranPasienUpdated', $resp);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Data pendaftaran BPJS ditemukan.');
        } catch (\Throwable $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal mengambil data pendaftaran: ' . $e->getMessage());
        }
    }



    private function checkJnsKlaimPasien($statusPasien = 'UM', $regNo = ''): void
    {
        // cek jika pasien BPJS
        if ($statusPasien == 'JM') {
            // cari display master pasien
            $displayPasien  = $this->findDataMasterPasien($regNo);

            $noka = $displayPasien['pasien']['identitas']['idBpjs'] ?? '';
            $nik = $displayPasien['pasien']['identitas']['nik'] ?? '';

            if (!empty($noka) && $noka !== '-') {
                // Get BPJS peserta by noka
                $getpeserta = $this->getPesertabyJenisKartu('noka', $noka);
            } elseif (!empty($nik) && $nik !== '-') {
                // Get BPJS peserta by nik jika noka kosong
                $getpeserta = $this->getPesertabyJenisKartu('nik', $nik);
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Noka dan NIK kosong.');
                return;
            }

            $this->checkStatusKlaimPasien = $getpeserta->getOriginalContent() ?? [];
            // lakukan update jika data nik dan noka tidak sama dengan data bpjs
            $this->updateNikNokaMasterPasien($regNo, $displayPasien, $nik, $noka, $this->checkStatusKlaimPasien['response']['noKTP'] ?? '', $this->checkStatusKlaimPasien['response']['noKartu'] ?? '');

            $this->emit('displayPasienUpdated', $this->checkStatusKlaimPasien);
            return;
        }


        $this->checkStatusKlaimPasien = [];
        $this->emit('displayPasienUpdated', $this->checkStatusKlaimPasien);

        return;
    }
    private function updateNikNokaMasterPasien($regNo, array $displayPasienArry, string $nikDataRs = '', string $nokaDataRs = '', string $nikDataBpjs = '', string $nokaDataBpjs = ''): void
    {
        if ($nikDataBpjs && $nokaDataBpjs) {
            if ($nikDataRs != $nikDataBpjs || $nokaDataRs != $nokaDataBpjs) {
                // update DB
                DB::table('rsmst_pasiens')->where('reg_no', $regNo)
                    ->update([
                        'nokartu_bpjs' => $nokaDataBpjs,
                        'nik_bpjs' => $nikDataBpjs,
                    ]);
                // update Json
                $displayPasienArry['pasien']['identitas']['idBpjs'] = $nokaDataBpjs;
                $displayPasienArry['pasien']['identitas']['nik'] = $nikDataBpjs;
                $this->updateJsonMasterPasien($regNo, $displayPasienArry);
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addWarning('Ada perbedaan data pasien di RS dan data pasien di BPJS, data pasien akan diupdate.');

                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addSuccess("Update data pasien dari NIK {$nikDataRs} ke NIK {$nikDataBpjs} berhasil diupdate.");

                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addSuccess("Update data pasien dari Noka {$nokaDataRs} ke Noka {$nokaDataBpjs} berhasil diupdate.");
                $this->emit('syncronizeDataDisplayPasien');
            }
        }
    }
    private function setDataPrimer(): void
    {
        if ($this->isOpenMode == 'insert') {

            // rjNo aman → di-generate dalam transaksi
            if (empty($this->FormEntry['rjNo'])) {
                $this->FormEntry['rjNo'] = $this->generateSafeRjNo();
            }

            // Klaim & Kunjungan (default)
            $this->FormEntry['klaimId']   = $this->jenisKlaim['JenisKlaimId'] ?? 'UM';
            $this->FormEntry['kunjSakit'] = $this->kunjSakit['kunjSakitId']   ?? '1';
            $this->FormEntry['kdTkp']     = $this->refTkp['refTkpId']         ?? '10';

            // noBooking default
            if (empty($this->FormEntry['noBooking'])) {
                $this->FormEntry['noBooking'] = Carbon::now(env('APP_TIMEZONE'))->format('YmdHis') . 'KLIKM';
            }

            // Antrian: hitung di dalam trx + lock agar tidak salip
            if (empty($this->FormEntry['noAntrian'])) {
                if (($this->FormEntry['klaimId'] ?? '') !== 'KR') {
                    $tgl = Carbon::createFromFormat('d/m/Y H:i:s', $this->FormEntry['rjDate'], env('APP_TIMEZONE'))->format('dmY');

                    $noUrutAntrian = DB::table('rstxn_rjhdrs')
                        ->where('dr_id', '=', $this->FormEntry['drId'])
                        ->where(DB::raw("to_char(rj_date, 'ddmmyyyy')"), '=', $tgl)
                        ->where('klaim_id', '!=', 'KR')

                        ->count();

                    $this->FormEntry['noAntrian'] = $noUrutAntrian + 1;
                } else {
                    $this->FormEntry['noAntrian'] = 999; // Kronis
                }
            }

            // Normalisasi flag/status
            $this->FormEntry['passStatus'] = ($this->FormEntry['passStatus'] == 'N') ? 'N' : 'O';

            $this->FormEntry['txnStatus']  = $this->FormEntry['txnStatus'] ?? 'A';
            $this->FormEntry['rjStatus']   = $this->FormEntry['rjStatus']  ?? 'A';
            $this->FormEntry['ermStatus']  = $this->FormEntry['ermStatus'] ?? 'A';

            $this->FormEntry['userLogs'][] = [
                'userLogDesc' => 'Form Entry Daftar RJ (Insert Data)',
                'userLog'     => auth()->user()->myuser_name,
                'userLogDate' => Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s')
            ];

            $this->FormEntry['taskIdPelayanan']['taskId3'] = $this->FormEntry['rjDate'];
        } else {
            // UPDATE mode (tetap seperti semula, boleh tambahkan default booking)
            if (empty($this->FormEntry['noBooking'])) {
                $this->FormEntry['noBooking'] = Carbon::now(env('APP_TIMEZONE'))->format('YmdHis') . 'KLIKM';
            }

            $this->FormEntry['klaimId']    = $this->jenisKlaim['JenisKlaimId'];
            $this->FormEntry['passStatus'] = $this->FormEntry['passStatus'] ? 'N' : 'O';

            $this->FormEntry['userLogs'][] = [
                'userLogDesc' => 'Form Entry Daftar RJ (Update Data)',
                'userLog'     => auth()->user()->myuser_name,
                'userLogDate' => Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s')
            ];

            $this->FormEntry['taskIdPelayanan']['taskId3'] = $this->FormEntry['rjDate'];
        }
    }


    private function syncDataPrimer(): void
    {
        // sync data primer dilakukan ketika update
        if ($this->isOpenMode == 'update') {

            $this->jenisKlaim['JenisKlaimId'] = $this->FormEntry['klaimId'] ?? 'UM';
            $this->kunjSakit['kunjSakitId'] = $this->FormEntry['kunjSakit'] ?? '1';
            $this->refTkp['refTkpId'] = $this->FormEntry['kdTkp'] ?? '10';

            $this->addDokter($this->FormEntry['drId'], $this->FormEntry['drDesc'], $this->FormEntry['poliId'], $this->FormEntry['poliDesc'], $this->FormEntry['kdpolibpjs'], $this->FormEntry['kddrbpjs']);


            $findDataPasien = DB::table('rsmst_pasiens')
                ->select(
                    'reg_no',
                    'reg_name',
                    'sex',
                    'address',
                )
                ->where('reg_no', '=', $this->FormEntry['regNo'])
                ->first();
            $this->addPasien($findDataPasien->reg_no, $findDataPasien->reg_name, $findDataPasien->sex, $findDataPasien->address);
        }
    }

    // validate Data RJ//////////////////////////////////////////////////
    private function validateData(): void
    {
        $this->rules['FormEntry.regNo'] = 'required';
        $this->rules['FormEntry.kdpolibpjs'] = '';
        $this->rules['FormEntry.noKartu'] = '';

        // timpa jika JM
        if ($this->FormEntry['klaimId'] == 'JM') {
            $this->rules['FormEntry.noKartu'] = 'required';

            if (!empty($this->FormEntry['noUrutBpjs'])) {
                $this->rules['FormEntry.regNo'] = [
                    'required',
                    function ($attribute, $value, $fail) {
                        // Pastikan format tanggal sesuai dengan aturan yang digunakan
                        $date = Carbon::createFromFormat('d/m/Y H:i:s', $this->FormEntry['rjDate'])->format('d/m/Y');
                        // Misalnya, model Registration mewakili pendaftaran pasien
                        $exists = DB::table('rstxn_rjhdrs')
                            ->where('reg_no', '=', $value)
                            ->where('dr_id', '=', $this->FormEntry['drId'] ?? '')
                            ->where('poli_id', '=', $this->FormEntry['poliId'] ?? '')
                            ->where('klaim_id', '=', $this->FormEntry['klaimId'] ?? '')
                            ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $date ?? '')
                            ->exists();
                        if ($exists) {
                            $fail('Pendaftaran dengan poli yang sama dalam satu hari sudah ada.');
                        }
                    },
                ];
            }

            $this->rules['FormEntry.kdpolibpjs'] = [
                'required',
                function ($attribute, $value, $fail) {
                    $allowedPoli = ['020', '021', '023', '024', '025', '026'];
                    // Jika kunjungan sehat (kunjSakit == 0), maka nilai harus ada dalam array allowedPoli.
                    if ($this->FormEntry['kunjSakit'] == 0 && !in_array($value, $allowedPoli)) {
                        $fail('Untuk kunjungan sehat, Kode Poli harus salah satu dari: ' . implode(', ', $allowedPoli) . '.');
                    }

                    if ($this->FormEntry['kunjSakit'] == 1 && in_array($value, $allowedPoli)) {
                        $fail('Untuk kunjungan sakit, Kode Poli tidak boleh salah satu dari: ' . implode(', ', $allowedPoli) . '.');
                    }
                    // Jika kunjungan sakit (kunjSakit == 1), tidak perlu dicek apakah nilai ada di dalam allowedPoli.
                },
            ];
        }




        // Proses Validasi///////////////////////////////////////////
        try {

            $this->validate($this->rules, $this->messages, $this->validationAttributes);
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError($e->getMessage());
            $this->validate($this->rules, $this->messages, $this->validationAttributes);
        }
        $this->resetValidation();
    }

    private function setCurrentDate(): void
    {
        $this->FormEntry['rjDate'] = Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s');
    }

    private function syncDataFormEntry(): void
    {
        // RJ Date Entry ketika Mont
        // Pasien Baru Lama di blade wire:model
        $this->FormEntry['passStatus'] = isset($this->FormEntry['passStatus']) ? ($this->FormEntry['passStatus'] == 'N' ? 'N' : '') : '';
        $this->FormEntry['regNo'] = isset($this->pasien['regNo']) ? $this->pasien['regNo'] : '';

        $displayPasien  = $this->findDataMasterPasien($this->FormEntry['regNo']);
        $this->FormEntry['noKartu'] = isset($displayPasien['pasien']['identitas']['idBpjs']) ? $displayPasien['pasien']['identitas']['idBpjs'] : '';

        $this->FormEntry['drId'] = isset($this->dokter['DokterId']) ? $this->dokter['DokterId'] : '';
        $this->FormEntry['drDesc'] = isset($this->dokter['DokterDesc']) ? $this->dokter['DokterDesc'] : '';
        $this->FormEntry['poliId'] = isset($this->dokter['PoliId']) ? $this->dokter['PoliId'] : '';
        $this->FormEntry['poliDesc'] = isset($this->dokter['PoliDesc']) ? $this->dokter['PoliDesc'] : '';
        $this->FormEntry['klaimId'] = $this->jenisKlaim['JenisKlaimId'] ?? 'UM';
        $this->FormEntry['kunjSakit'] = $this->kunjSakit['kunjSakitId'] ?? '1';
        $this->FormEntry['kdTkp'] =  $this->refTkp['refTkpId'] ?? '10';
        $this->FormEntry['kdpolibpjs'] =  $this->dokter['kdPoliBpjs'] ?? '';
        $this->FormEntry['kddrbpjs'] =  $this->dokter['kdDokterBpjs'] ?? '';
    }

    private function syncLOV(): void
    {
        $this->dokter = $this->collectingMyDokter;
        $this->pasien = $this->collectingMyPasien;
    }

    public function mount()
    {
        $this->findData($this->rjNoRef);

        if ($this->isOpenMode == 'insert') {
            $this->setCurrentDate();
        }
    }

    public function render()
    {
        // LOV
        $this->syncLOV();
        // FormEntry
        $this->syncDataFormEntry();


        return view('livewire.r-j.daftar-r-j.form-entry-daftar-r-j.form-entry-daftar-r-j');
    }
}
