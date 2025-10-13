<?php

namespace App\Http\Livewire\RJ\DaftarRJ\FormEntryDaftarRJ;

use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Traits\customErrorMessagesTrait;
use Carbon\Carbon;
use App\Http\Traits\BPJS\PcareTrait;


// use App\Http\Livewire\SatuSehat\Location\Location;
// use App\Http\Traits\BPJS\SatuSehatTrait;
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
        try {
            $findData = $this->findDataRJ($id);
            if (isset($findData['errorMessages'])) {
                // dd($findData['errorMessages']);
                $this->emit('toastr-error', $findData['errorMessages']);
                $this->emit('CloseModal');
                // return;
            }


            $this->FormEntry  = $findData['dataDaftarRJ'];
            $this->syncDataPrimer();
            $this->rjStatusRef = $this->checkRJStatus($id);
        } catch (Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            $this->emit('CloseModal');
            return;
        }
    }


    private function update($rjNo): void
    {
        // update table trnsaksi
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', '=', $rjNo)
            ->update([
                // 'rj_no' => $this->FormEntry['rjNo'],
                'rj_date' => DB::raw("to_date('" . $this->FormEntry['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"),
                'reg_no' => $this->FormEntry['regNo'],
                'nobooking' => $this->FormEntry['noBooking'],
                'no_antrian' => $this->FormEntry['noAntrian'],

                'klaim_id' => $this->FormEntry['klaimId'],
                'poli_id' => $this->FormEntry['poliId'],
                'dr_id' => $this->FormEntry['drId'],

                'txn_status' => $this->FormEntry['txnStatus'],
                'rj_status' => $this->FormEntry['rjStatus'],
                'erm_status' => $this->FormEntry['ermStatus'],

                'pass_status' => $this->FormEntry['passStatus'],
            ]);


        $this->emit('toastr-success', "Data berhasil diupdate.");
    }

    private function insert(): void
    {
        //insert
        DB::table('rstxn_rjhdrs')
            ->insert([
                'rj_no' => $this->FormEntry['rjNo'],
                'rj_date' => DB::raw("to_date('" . $this->FormEntry['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"),
                'reg_no' => $this->FormEntry['regNo'],
                'nobooking' => $this->FormEntry['noBooking'],
                'no_antrian' => $this->FormEntry['noAntrian'],

                'klaim_id' => $this->FormEntry['klaimId'],
                'poli_id' => $this->FormEntry['poliId'],
                'dr_id' => $this->FormEntry['drId'],

                'txn_status' => $this->FormEntry['txnStatus'],
                'rj_status' => $this->FormEntry['rjStatus'],
                'erm_status' => $this->FormEntry['ermStatus'],

                'pass_status' => $this->FormEntry['passStatus'],
            ]);

        $this->emit('toastr-success', "Data berhasil dimasukkan.");
    }

    public function store(): void
    {
        // validate
        $this->setDataPrimer();
        $this->validateData();
        $this->checkJnsKlaimPasien($this->FormEntry['klaimId'], $this->FormEntry['regNo']);

        // Jika mode data //insert
        if ($this->isOpenMode == 'insert') {
            $this->insert();
            $this->isOpenMode = 'update';
        } else {
            // Jika mode data //update
            $this->update($this->rjNoRef);
        }

        $this->addPedaftaranBPJS($this->FormEntry['klaimId'],);
        $this->updateJsonRJ($this->FormEntry['rjNo'], $this->FormEntry);
        // ///////////////////////////


        // $this->closeModal();
    }

    private function addPedaftaranBPJS($statusPasien): void
    {
        if ($statusPasien == 'JM') {
            $kdProvider = $this->checkStatusKlaimPasien['metadata']['code'] == 200 ?
                $this->checkStatusKlaimPasien['response']['kdProviderPst']['kdProvider']
                : '';

            if ($kdProvider !== env('PCARE_PROVIDER')) {
                $this->emit('toastr-error', 'Kode Provider Peserta dari faskes lain /' . $kdProvider);
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
                $this->emit('toastr-error', $e->getMessage());
                return;
            }

            if ($addPedaftaran['metadata']['code'] == 201) {
                $this->FormEntry['noUrutBpjs'] = $addPedaftaran['response']['message'];
            } else {
                $this->emit('toastr-error', $addPedaftaran['metadata']['message']);
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
            $this->emit('toastr-error', 'Gagal ambil data peserta: ' . $e->getMessage());
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
            $this->emit('toastr-error', 'Format tanggal pendaftaran tidak valid.');
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
            $this->emit('toastr-error', 'Error saat hapus pendaftaran: ' . $e->getMessage());
            return;
        }

        // 4. Tangani response dari PCare
        if (isset($result['metadata']['code']) && $result['metadata']['code'] == 200) {
            // sukses: reset noUrutBpjs di formEntry
            $this->FormEntry['noUrutBpjs'] = null;
            $this->emit('toastr-success', 'Pendaftaran BPJS berhasil dihapus.');
            return;
        } else {
            $msgResponse = $result['response']['message'] ?? 'x';
            $msg = $result['metadata']['message'] . '  ' . $msgResponse
                ?? 'Gagal menghapus pendaftaran.';
            $this->emit('toastr-error', $msg);
            return;
        }
    }

    public function checkPendaftaranPasienBPJSbyNomorUrut(string $noUrut, string $tglDaftar): void
    {
        // Pastikan input tidak kosong
        if (empty($noUrut) || empty($tglDaftar)) {
            $this->emit('toastr-error', 'Nomor urut atau tanggal daftar tidak boleh kosong');
            $this->emit('dataPendaftaranPasienUpdated', $this->dataPendaftaranPasien);
            return;
        }

        // Konversi format tanggal dari: 28/07/2025 18:51:33 → 28-07-2025
        try {
            $tglDaftarFormatted = Carbon::createFromFormat('d/m/Y H:i:s', $tglDaftar)->format('d-m-Y');
        } catch (\Exception $e) {
            $this->emit('toastr-error', 'Format tanggal tidak valid. Gunakan format dd/mm/yyyy hh:mm:ss');
            return;
        }

        // Panggil API PCare untuk ambil data pendaftaran berdasarkan no urut dan tgl
        $getPendaftaran = $this->getPendaftaranbyNomorUrut($noUrut, $tglDaftarFormatted);
        dd($getPendaftaran->getData(true));
        return;
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
                $this->emit('toastr-error', 'Noka dan NIK kosong');
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
                $this->emit('toastr-error', 'Ada perbedaan data pasien di RS dan data pasien di BPJS, data pasien akan diupdate');
                $this->emit('toastr-success', "Update data pasien dari NIK " . $nikDataRs . " ke NIK " . $nikDataBpjs . " berhasil diupdate.");
                $this->emit('toastr-success', "Update data pasien dari Noka " . $nokaDataRs . " ke Noka " . $nokaDataBpjs . " berhasil diupdate.");
                $this->emit('syncronizeDataDisplayPasien');
            }
        }
    }
    private function setDataPrimer(): void
    {
        // set data primer dilakukan ketika insert
        if ($this->isOpenMode == 'insert') {
            // rjNoMax
            if (!$this->FormEntry['rjNo']) {
                $sql = "select nvl(max(rj_no)+1,1) rjno_max from rstxn_rjhdrs";
                $this->FormEntry['rjNo'] = DB::scalar($sql);
            }


            // Klaim & Kunjungan
            $this->FormEntry['klaimId'] = $this->jenisKlaim['JenisKlaimId'] ?? 'UM';
            $this->FormEntry['kunjSakit'] = $this->kunjSakit['kunjSakitId'] ?? '1';
            $this->FormEntry['kdTkp'] =  $this->refTkp['refTkpId'] ?? '10';
            // noBooking
            if (!$this->FormEntry['noBooking']) {
                $this->FormEntry['noBooking'] = Carbon::now(env('APP_TIMEZONE'))->format('YmdHis') . 'KLIKM';
            }




            // Antrian ketika data antrian kosong
            if (!$this->FormEntry['noAntrian']) {
                // proses antrian
                if ($this->FormEntry['klaimId'] != 'KR') {
                    // noUrutAntrian (count all kecuali KRonis) if KR 999
                    $noUrutAntrian = DB::table('rstxn_rjhdrs')
                        ->where('dr_id', '=', $this->FormEntry['drId'])
                        ->where(DB::raw("to_char(rj_date, 'ddmmyyyy')"), '=', Carbon::createFromFormat('d/m/Y H:i:s', $this->FormEntry['rjDate'], env('APP_TIMEZONE'))->format('dmY'))
                        ->where('klaim_id', '!=', 'KR')
                        ->count();

                    $noAntrian = $noUrutAntrian + 1;
                } else {
                    // Kronis
                    $noAntrian = 999;
                }

                $this->FormEntry['noAntrian'] = $noAntrian;
            }

            // Convert Pasien Baru Lama
            $this->FormEntry['passStatus'] = $this->FormEntry['passStatus'] == 'N' ? 'N' : 'O';
            $this->FormEntry['txnStatus'] = $this->FormEntry['txnStatus'] ? $this->FormEntry['txnStatus'] : 'A';
            $this->FormEntry['rjStatus'] = $this->FormEntry['rjStatus'] ? $this->FormEntry['rjStatus'] : 'A';
            $this->FormEntry['ermStatus'] = $this->FormEntry['ermStatus'] ? $this->FormEntry['ermStatus'] : 'A';
            $this->FormEntry['userLogs'][] =
                [
                    'userLogDesc' => 'Form Entry Daftar RJ (Insert Data)',
                    'userLog' => auth()->user()->myuser_name,
                    'userLogDate' => Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s')
                ];

            $this->FormEntry['taskIdPelayanan']['taskId3'] = $this->FormEntry['rjDate'];
        } else {
            // Klaim & Kunjungan
            // noBooking kosong maka buat
            if (!$this->FormEntry['noBooking']) {
                $this->FormEntry['noBooking'] = Carbon::now(env('APP_TIMEZONE'))->format('YmdHis') . 'KLIKM';
            }

            $this->FormEntry['klaimId'] = $this->jenisKlaim['JenisKlaimId'];
            $this->FormEntry['passStatus'] = $this->FormEntry['passStatus'] ? 'N' : 'O';

            $this->FormEntry['userLogs'][] =
                [
                    'userLogDesc' => 'Form Entry Daftar RJ (Update Data)',
                    'userLog' => auth()->user()->myuser_name,
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
            $this->emit('toastr-error', $e->getMessage());
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
