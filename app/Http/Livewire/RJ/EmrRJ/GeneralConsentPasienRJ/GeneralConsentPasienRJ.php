<?php

namespace App\Http\Livewire\RJ\EmrRJ\GeneralConsentPasienRJ;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Traits\EmrRJ\EmrRJTrait;
use App\Http\Traits\MasterPasien\MasterPasienTrait;


class GeneralConsentPasienRJ extends Component
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
    public array $generalConsentPasienRJ = [
        'signature' => '',
        'signatureDate' => '',
        'wali' => '',
        'agreement' => '1',
        'petugasPemeriksa' => '',
        'petugasPemeriksaDate' => '',
        'petugasPemeriksaCode' => '',
    ];
    public $signature;

    protected $rules = [
        'dataDaftarRJ.generalConsentPasienRJ.signature'            => 'required',
        'dataDaftarRJ.generalConsentPasienRJ.signatureDate'        => 'required|date_format:d/m/Y H:i:s',
        'dataDaftarRJ.generalConsentPasienRJ.wali'                 => 'required',
        'dataDaftarRJ.generalConsentPasienRJ.agreement'            => 'required|in:0,1',
        'dataDaftarRJ.generalConsentPasienRJ.petugasPemeriksa'     => 'required',
        'dataDaftarRJ.generalConsentPasienRJ.petugasPemeriksaDate' => 'required|date_format:d/m/Y H:i:s',
        'dataDaftarRJ.generalConsentPasienRJ.petugasPemeriksaCode' => 'required',
    ];

    protected $messages = [
        'required'    => ':attribute wajib diisi.',
        'in'          => ':attribute tidak valid.',
        'date_format' => ':attribute harus dengan format dd/mm/yyyy hh:mm:ss',
    ];

    // pakai nama $attributes (param ke-3 validate)
    protected $attributes = [
        'dataDaftarRJ.generalConsentPasienRJ.signature'            => 'Tanda tangan pasien/wali',
        'dataDaftarRJ.generalConsentPasienRJ.signatureDate'        => 'Waktu tanda tangan',
        'dataDaftarRJ.generalConsentPasienRJ.wali'                 => 'Nama wali',
        'dataDaftarRJ.generalConsentPasienRJ.agreement'            => 'Persetujuan',
        'dataDaftarRJ.generalConsentPasienRJ.petugasPemeriksa'     => 'Petugas pemeriksa',
        'dataDaftarRJ.generalConsentPasienRJ.petugasPemeriksaDate' => 'Waktu tanda tangan petugas',
        'dataDaftarRJ.generalConsentPasienRJ.petugasPemeriksaCode' => 'Kode petugas pemeriksa',
    ];

    public function submit()
    {

        if (empty($this->signature)) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Tanda tangan pasien/wali belum diisi.');
            return;
        }

        // set tanda tangan dari canvas/signpad di UI
        $this->dataDaftarRJ['generalConsentPasienRJ']['signature']     = (string)($this->signature ?? '');
        $this->dataDaftarRJ['generalConsentPasienRJ']['signatureDate'] = Carbon::now(config('app.timezone'))->format('d/m/Y H:i:s');

        // validasi sebelum simpan
        try {
            $this->validate($this->rules, $this->messages, $this->attributes);
        } catch (ValidationException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError($e->validator->errors()->first());
            return;
        }

        $this->store();
    }

    public function store()
    {


        $rjNo = $this->dataDaftarRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('rjNo kosong.');
            return;
        }

        $lockKey = "RJ:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {
                    // ambil data TERBARU agar tidak menimpa modul lain
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];

                    if (!isset($fresh['generalConsentPasienRJ']) || !is_array($fresh['generalConsentPasienRJ'])) {
                        $fresh['generalConsentPasienRJ'] = $this->generalConsentPasienRJ;
                    }

                    // patch hanya subtree general consent
                    $fresh['generalConsentPasienRJ'] = array_replace(
                        $fresh['generalConsentPasienRJ'],
                        (array)($this->dataDaftarRJ['generalConsentPasienRJ'] ?? [])
                    );
                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarRJ = $fresh;
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess("Signature berhasil disimpan.");
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (\Throwable $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal menyimpan General Consent.');
        }
    }

    private function findData($rjno): void
    {
        $wrap = $this->findDataRJ($rjno) ?: [];
        $this->dataDaftarRJ = $wrap['dataDaftarRJ'] ?? $wrap ?? [];

        if (!isset($this->dataDaftarRJ['generalConsentPasienRJ']) || !is_array($this->dataDaftarRJ['generalConsentPasienRJ'])) {
            $this->dataDaftarRJ['generalConsentPasienRJ'] = $this->generalConsentPasienRJ;
        }
    }

    public function setPetugasPemeriksa()
    {
        $code = auth()->user()->myuser_code ?? '';
        $name = auth()->user()->myuser_name ?? '';

        if (empty($this->dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksa'])) {

            $this->dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksa']     = $name;
            $this->dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksaCode'] = $code;
            $this->dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksaDate'] = Carbon::now(config('app.timezone'))->format('d/m/Y H:i:s');
        } else {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError("Signature Petugas Pemeriksa sudah ada.");
        }
    }


    public function cetakGeneralConsentPasienRJ()
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

        // Ambil regNo untuk data pasien
        $regNo = $this->dataDaftarRJ['regNo'] ?? $this->regNoRef ?? null;
        if (!$regNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor rekam medis tidak ditemukan.');
            return;
        }

        // Ambil blok general consent
        $consent = $this->dataDaftarRJ['generalConsentPasienRJ'] ?? null;
        if (!$consent || !is_array($consent)) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Data General Consent RJ belum tersedia.');
            return;
        }

        try {
            // Identitas RS
            $identitasRs = DB::table('dimst_identitases')
                ->select('int_name', 'int_phone1', 'int_phone2', 'int_fax', 'int_address', 'int_city')
                ->first();

            // Data master pasien (dari trait EmrRJTrait)
            $dataPasien = $this->findDataMasterPasien($regNo) ?? [];

            // Data yang dikirim ke view cetak
            $data = [
                'identitasRs' => $identitasRs,
                'dataPasien'  => $dataPasien,
                'dataRJ'     => $this->dataDaftarRJ,
                'consent'     => $consent,
            ];

            $pdfContent = Pdf::loadView(
                'livewire.component.cetak.cetak-general-consent-r-j-print',
                $data
            )->output();

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Berhasil mencetak Formulir Persetujuan Umum RJ.');

            return response()->streamDownload(
                fn() => print($pdfContent),
                'general-consent-RJ-' . $rjNo . '.pdf'
            );
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
            'livewire.r-j.emr-r-j.general-consent-pasien-r-j.general-consent-pasien-r-j',
            []
        );
    }
    // select data end////////////////


}
