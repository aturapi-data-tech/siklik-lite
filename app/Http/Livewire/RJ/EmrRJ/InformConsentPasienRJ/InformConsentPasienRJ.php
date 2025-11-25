<?php

namespace App\Http\Livewire\RJ\EmrRJ\InformConsentPasienRJ;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Validation\ValidationException;

use Livewire\Component;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Traits\EmrRJ\EmrRJTrait;
use App\Http\Traits\MasterPasien\MasterPasienTrait;

class InformConsentPasienRJ extends Component
{
    use  EmrRJTrait, MasterPasienTrait;


    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef;
    public $regNoRef;
    public array $dataDaftarRJ = [];


    public array $agreementOptions = [
        ["agreementId" => "1", "agreementDesc" => "Setuju"],
        ["agreementId" => "0", "agreementDesc" => "Tidak Setuju"],
    ];

    // Satu entri consent
    public array $informConsentPasienRJ = [
        'tindakan'  => '',
        'tujuan'    => '',
        'resiko'    => '',
        'alternatif' => '',
        'dokter'    => '',

        'signature'      => '',
        'signatureDate'  => '',
        'wali'           => '',

        'signatureSaksi'     => '',
        'signatureSaksiDate' => '',
        'saksi'              => '',

        'agreement'            => '1',
        'petugasPemeriksa'     => '',
        'petugasPemeriksaDate' => '',
        'petugasPemeriksaCode' => '',
    ];

    public $signature;
    public $signatureSaksi;

    protected $rules = [
        'informConsentPasienRJ.tindakan'   => 'required',
        'informConsentPasienRJ.tujuan'     => 'required',
        'informConsentPasienRJ.resiko'     => 'required',
        'informConsentPasienRJ.alternatif' => 'required',
        'informConsentPasienRJ.dokter'     => 'required',

        'informConsentPasienRJ.signature'     => 'required',
        'informConsentPasienRJ.signatureDate' => 'required|date_format:d/m/Y H:i:s',
        'informConsentPasienRJ.wali'          => 'required',

        'informConsentPasienRJ.signatureSaksi'     => 'required',
        'informConsentPasienRJ.signatureSaksiDate' => 'required|date_format:d/m/Y H:i:s',
        'informConsentPasienRJ.saksi'              => 'required',

        'informConsentPasienRJ.agreement'            => 'required|in:0,1',
        'informConsentPasienRJ.petugasPemeriksa'     => 'required',
        'informConsentPasienRJ.petugasPemeriksaDate' => 'required|date_format:d/m/Y H:i:s',
        'informConsentPasienRJ.petugasPemeriksaCode' => 'required',
    ];

    protected $messages = [
        'required'    => ':attribute wajib diisi.',
        'in'          => ':attribute tidak valid.',
        'date_format' => ':attribute harus dengan format dd/mm/yyyy hh:mm:ss',
    ];

    protected $attributes = [
        'informConsentPasienRJ.tindakan'   => 'Tindakan',
        'informConsentPasienRJ.tujuan'     => 'Tujuan',
        'informConsentPasienRJ.resiko'     => 'Risiko',
        'informConsentPasienRJ.alternatif' => 'Alternatif',
        'informConsentPasienRJ.dokter'     => 'Dokter',

        'informConsentPasienRJ.signature'     => 'Tanda tangan pasien/wali',
        'informConsentPasienRJ.signatureDate' => 'Waktu tanda tangan pasien/wali',
        'informConsentPasienRJ.wali'          => 'Nama wali',

        'informConsentPasienRJ.signatureSaksi'     => 'Tanda tangan saksi',
        'informConsentPasienRJ.signatureSaksiDate' => 'Waktu tanda tangan saksi',
        'informConsentPasienRJ.saksi'              => 'Nama saksi',

        'informConsentPasienRJ.agreement'            => 'Persetujuan',
        'informConsentPasienRJ.petugasPemeriksa'     => 'Petugas pemeriksa',
        'informConsentPasienRJ.petugasPemeriksaDate' => 'Waktu tanda tangan petugas',
        'informConsentPasienRJ.petugasPemeriksaCode' => 'Kode petugas pemeriksa',
    ];


    public function submit()
    {
        if (!$this->signature) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Tanda tangan pasien/wali belum diisi.');
            return;
        }
        if (!$this->signatureSaksi) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Tanda tangan saksi belum diisi.');
            return;
        }


        // set tanda tangan dari UI
        $this->informConsentPasienRJ['signature']     = (string)($this->signature ?? '');
        $this->informConsentPasienRJ['signatureDate'] = Carbon::now(config('app.timezone'))->format('d/m/Y H:i:s');

        $this->informConsentPasienRJ['signatureSaksi']     = (string)($this->signatureSaksi ?? '');
        $this->informConsentPasienRJ['signatureSaksiDate'] = Carbon::now(config('app.timezone'))->format('d/m/Y H:i:s');

        try {
            $this->validate($this->rules, $this->messages, $this->attributes);
        } catch (ValidationException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError($e->validator->errors()->first());
            return;
        }

        // masukkan satu entri ke list
        $this->store();
    }


    public function store()
    {


        $rjNo = $this->dataDaftarRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('rjNo kosong.');
            return;
        }

        $lockKey = "RJ:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {
                    // ambil data TERBARU
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];

                    // siapkan list
                    if (!isset($fresh['informConsentPasienRJ']) || !is_array($fresh['informConsentPasienRJ'])) {
                        $fresh['informConsentPasienRJ'] = [];
                    }

                    // idempoten sederhana (berdasar timestamp tanda tangan pasien)
                    $exists = collect($fresh['informConsentPasienRJ'])
                        ->firstWhere('signatureDate', $this->informConsentPasienRJ['signatureDate']);

                    if (!$exists) {
                        $fresh['informConsentPasienRJ'][] = $this->informConsentPasienRJ;
                    }

                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarRJ = $fresh;
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess("Inform consent tersimpan.");
            $this->informConsentPasienRJ = $this->defaultConsent();
            $this->signature = null;
            $this->signatureSaksi = null;
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (\Throwable $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal menyimpan Inform Consent.');
        }
    }



    private function findData($rjno): void
    {
        $wrap = $this->findDataRJ($rjno) ?: [];
        $this->dataDaftarRJ = $wrap['dataDaftarRJ'] ?? $wrap ?? [];

        if (!isset($this->dataDaftarRJ['informConsentPasienRJ']) || !is_array($this->dataDaftarRJ['informConsentPasienRJ'])) {
            // list of consent entries
            $this->dataDaftarRJ['informConsentPasienRJ'] = [];
        }
    }

    public function setPetugasPemeriksa()
    {
        $code = auth()->user()->myuser_code ?? '';
        $name = auth()->user()->myuser_name ?? '';

        if (empty($this->informConsentPasienRJ['petugasPemeriksa'])) {
            $this->informConsentPasienRJ['petugasPemeriksa']     = $name;
            $this->informConsentPasienRJ['petugasPemeriksaCode'] = $code;
            $this->informConsentPasienRJ['petugasPemeriksaDate'] = Carbon::now(config('app.timezone'))->format('d/m/Y H:i:s');
        } else {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError("Signature Petugas Pemeriksa sudah ada.");
        }
    }

    private function defaultConsent(): array
    {
        return [
            'tindakan'  => '',
            'tujuan'    => '',
            'resiko'    => '',
            'alternatif' => '',
            'dokter'    => '',

            'signature'      => '',
            'signatureDate'  => '',
            'wali'           => '',

            'signatureSaksi'     => '',
            'signatureSaksiDate' => '',
            'saksi'              => '',

            'agreement'            => '1',
            'petugasPemeriksa'     => '',
            'petugasPemeriksaDate' => '',
            'petugasPemeriksaCode' => '',
        ];
    }


    public function cetakInformConsentPasienRJ(string $signatureDate)
    {
        // Pastikan data RJ terbaru
        if (empty($this->dataDaftarRJ)) {
            $this->findData($this->rjNoRef);
        }

        // Cek rjNo
        $rjNo = $this->dataDaftarRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Data RJ (rjNo) tidak ditemukan.');
            return;
        }

        // Cek regNo
        $regNo = $this->dataDaftarRJ['regNo'] ?? $this->regNoRef ?? null;
        if (!$regNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor rekam medis tidak ditemukan.');
            return;
        }

        // Ambil list consent dari data RJ
        $listConsent = $this->dataDaftarRJ['informConsentPasienRJ'] ?? [];

        if (!is_array($listConsent) || count($listConsent) === 0) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Data Inform Consent RJ belum tersedia.');
            return;
        }

        // Cari consent berdasarkan signatureDate
        $consent = collect($listConsent)->firstWhere('signatureDate', $signatureDate);

        if (!$consent) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Data persetujuan yang dipilih tidak ditemukan.');
            return;
        }

        try {
            // Identitas RS
            $identitasRs = DB::table('dimst_identitases')
                ->select('int_name', 'int_phone1', 'int_phone2', 'int_fax', 'int_address', 'int_city')
                ->first();

            // Data master pasien
            $dataPasien = $this->findDataMasterPasien($regNo) ?? [];

            $data = [
                'identitasRs' => $identitasRs,
                'dataPasien'  => $dataPasien,
                'dataRJ'     => $this->dataDaftarRJ,
                'consent'     => $consent,
            ];

            $pdfContent = Pdf::loadView(
                'livewire.component.cetak.cetak-inform-consent-r-j-print',
                $data
            )->output();

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Berhasil mencetak Formulir Persetujuan / Penolakan Tindakan Medis.');

            return response()->streamDownload(function () use ($pdfContent) {
                echo $pdfContent;
            }, 'inform-consent-RJ-' . $rjNo . '.pdf');
        } catch (\Throwable $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal mencetak PDF: ' . $e->getMessage());
        }
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
            'livewire.r-j.emr-r-j.inform-consent-pasien-r-j.inform-consent-pasien-r-j',
            []
        );
    }
    // select data end////////////////


}
