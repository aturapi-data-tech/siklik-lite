<?php

namespace App\Http\Livewire\Pcare\RJ\Kunjungan;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Exception;
use Carbon\Carbon;

use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\EmrRJ\EmrRJTrait;
use App\Http\Traits\MasterPasien\MasterPasienTrait;
use App\Http\Traits\BPJS\PcareTrait;

class FormEntryKunjungan extends Component
{
    use EmrRJTrait, MasterPasienTrait, PcareTrait;


    public string $rjNoRef;
    public bool   $rjStatusRef = false;
    public string $isOpenMode  = 'insert';

    public array $FormEntry = [];
    public array $displayPasien = [];

    public array $addKunjungan = [
        "noKunjungan" => "",
        "noKartu" => "",
        "tglDaftar" => "",
        "kdPoli" => "",
        "keluhan" => "",
        "kdSadar" => "",
        "sistole" => "",
        "diastole" => "",
        "beratBadan" => "",
        "tinggiBadan" => "",
        "respRate" => "",
        "heartRate" => "",
        "lingkarPerut" => "",
        "kdStatusPulang" => "",
        "tglPulang" => "",
        "kdDokter" => "",
        "kdDiag1" => "",
        "nonSpesialis" => "",
        "kdDiag2" => "",
        "kdDiag3" => "",
        "kdPoliRujukInternal" => "",
        "rujukLanjut" => [
            "tglEstRujuk" => "",
            "kdppk" => "",
            "subSpesialis" => [
                "kdSubSpesialis1" => "",
                "kdSarana" => ""
            ],
            "khusus" => [
                "kdKhusus" => "",
                "kdSubSpesialis1" => "",
                "catatan" => ""
            ]
        ],
        "kdTacc" => 0,
        "alasanTacc" => "",
        "anamnesa" => "",
        "alergiMakan" => "",
        "alergiUdara" => "",
        "alergiObat" => "",
        "kdPrognosa" => "",
        "terapiObat" => "",
        "terapiNonObat" => "",
        "bmhp" => "",
        "suhu" => ""
    ];

    public array $refTacc = [
        ["kdTacc" => "-1", "nmTacc" => "Tanpa TACC", "alasanTacc" => [null]],
        ["kdTacc" => "1", "nmTacc" => "Time", "alasanTacc" => ["< 3 Hari", ">= 3 - 7 Hari", ">= 7 Hari"]],
        ["kdTacc" => "2", "nmTacc" => "Age", "alasanTacc" => ["< 1 Bulan", ">= 1 Bulan s/d < 12 Bulan", ">= 1 Tahun s/d < 5 Tahun", ">= 5 Tahun s/d < 12 Tahun", ">= 12 Tahun s/d < 55 Tahun", ">= 55 Tahun"]],
        ["kdTacc" => "3", "nmTacc" => "Complication", "alasanTacc" => ["(format : kdDiagnosa +  -  + NamaDiagnosa, contoh : A09 - Diarrhoea and gastroenteritis of presumed infectious origin)"]],
        ["kdTacc" => "4", "nmTacc" => "Comorbidity", "alasanTacc" => ["< 3 Hari", ">= 3 - 7 Hari", ">= 7 Hari"]]
    ];

    ////////////////// Rules //////////////////
    protected $rules = ['refTacc' => ''];
    protected $messages = [];
    protected $validationAttributes = [];

    ////////////////// lifecycle //////////////////
    public function mount()
    {
        $this->findData($this->rjNoRef);
    }

    public function render()
    {
        $this->syncLOV();
        $this->syncDataFormEntry();
        return view('livewire.pcare.r-j.kunjungan.form-entry-kunjungan');
    }

    ////////////////// data load & sync //////////////////
    private function findData($id): void
    {
        try {
            $findData = $this->findDataRJ($id);
            if (isset($findData['errorMessages'])) {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError($findData['errorMessages']);
                $this->emit('CloseModal');
                return;
            }

            $this->FormEntry  = $findData['dataDaftarRJ'];
            $this->displayPasien  = $this->findDataMasterPasien($this->FormEntry['regNo']);

            $this->syncDataPrimer();
            $this->rjStatusRef = (bool) $this->checkRJStatus($id) ? false : true;
        } catch (Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
            $this->emit('CloseModal');
        }
    }

    private function syncDataPrimer(): void
    {
        if (isset($this->FormEntry['dataKunjungan'])) {
            $noKunjungan = collect($this->FormEntry['dataKunjungan'])->where('field', 'noKunjungan')->first()['message'] ?? null;
            $this->FormEntry['addKunjungan']['noKunjungan'] = $noKunjungan;
        }

        if (empty($this->FormEntry['addKunjungan']['noKunjungan'])) {
            $this->FormEntry['addKunjungan'] = $this->addKunjungan; // default draft

            $this->FormEntry['addKunjungan']['noKartu']  = $this->displayPasien['pasien']['identitas']['idBpjs'] ?? '';
            $this->FormEntry['addKunjungan']['noKunjungan'] = null;
            $this->FormEntry['addKunjungan']['kdPoli'] = $this->FormEntry['kdpolibpjs'] ?? '';

            $this->FormEntry['addKunjungan']['tglDaftar'] = Carbon::createFromFormat('d/m/Y H:i:s', $this->FormEntry['rjDate'], env('APP_TIMEZONE'))->format('d-m-Y');
            $this->FormEntry['addKunjungan']['tglPulang'] = Carbon::createFromFormat('d/m/Y H:i:s', $this->FormEntry['rjDate'], env('APP_TIMEZONE'))->format('d-m-Y');

            $this->FormEntry['addKunjungan']['keluhan']   = $this->FormEntry['anamnesa']['keluhanUtama']['keluhanUtama'] ?? '';
            $this->FormEntry['addKunjungan']['anamnesa']  = $this->FormEntry['anamnesa']['riwayatPenyakitSekarangUmum']['riwayatPenyakitSekarangUmum'] ?? '';

            $this->FormEntry['addKunjungan']['alergiMakan'] = $this->FormEntry['anamnesa']['alergi']['alergiMakanan'] ?? '';
            $this->FormEntry['addKunjungan']['alergiUdara'] = $this->FormEntry['anamnesa']['alergi']['alergiUdara'] ?? '';
            $this->FormEntry['addKunjungan']['alergiObat']  = $this->FormEntry['anamnesa']['alergi']['alergiObat'] ?? '';

            $this->FormEntry['addKunjungan']['kdPrognosa'] = $this->FormEntry['perencanaan']['prognosa']['prognosa'] ?? '';
            $this->FormEntry['addKunjungan']['terapiObat']  = $this->FormEntry['perencanaan']['terapi']['terapi'] ?? '';
            $this->FormEntry['addKunjungan']['terapiNonObat'] = $this->FormEntry['perencanaan']['terapi']['terapiNonObat'] ?? '';

            $this->FormEntry['addKunjungan']['kdDiag1'] = $this->FormEntry['diagnosis'][0]['diagId'] ?? null;
            $this->FormEntry['addKunjungan']['kdDiag2'] = $this->FormEntry['diagnosis'][1]['diagId'] ?? null;
            $this->FormEntry['addKunjungan']['kdDiag3'] = $this->FormEntry['diagnosis'][2]['diagId'] ?? null;
            $this->FormEntry['addKunjungan']['kdPoliRujukInternal'] = null;

            $this->FormEntry['addKunjungan']['kdSadar'] = $this->FormEntry['pemeriksaan']['tandaVital']['tingkatKesadaran'] ?? '';
            $this->FormEntry['addKunjungan']['suhu']    = $this->FormEntry['pemeriksaan']['tandaVital']['suhu'] ?? '';
            $this->FormEntry['addKunjungan']['tinggiBadan'] = $this->FormEntry['pemeriksaan']['nutrisi']['tb'] ?? '';
            $this->FormEntry['addKunjungan']['beratBadan']  = $this->FormEntry['pemeriksaan']['nutrisi']['bb'] ?? '';
            $this->FormEntry['addKunjungan']['lingkarPerut'] = $this->FormEntry['pemeriksaan']['nutrisi']['liPerut'] ?? '';
            $this->FormEntry['addKunjungan']['sistole']  = $this->FormEntry['pemeriksaan']['tandaVital']['sistolik'] ?? '';
            $this->FormEntry['addKunjungan']['diastole'] = $this->FormEntry['pemeriksaan']['tandaVital']['distolik'] ?? '';
            $this->FormEntry['addKunjungan']['respRate'] = $this->FormEntry['pemeriksaan']['tandaVital']['frekuensiNafas'] ?? '';
            $this->FormEntry['addKunjungan']['heartRate'] = $this->FormEntry['pemeriksaan']['tandaVital']['frekuensiNadi'] ?? '';

            $this->FormEntry['addKunjungan']['kdStatusPulang'] = $this->FormEntry['perencanaan']['tindakLanjut']['tindakLanjut'] ?? '';
            $this->FormEntry['addKunjungan']['kdDokter'] = $this->FormEntry['kddrbpjs'] ?? '';

            $this->FormEntry['addKunjungan']['rujukLanjut']['tglEstRujuk'] = $this->FormEntry['addKunjungan']['rujukLanjut']['tglEstRujuk'] ?? Carbon::createFromFormat('d/m/Y H:i:s', $this->FormEntry['rjDate'], env('APP_TIMEZONE'))->format('d-m-Y');
            $this->FormEntry['addKunjungan']['rujukLanjut']['kdppk'] = $this->FormEntry['addKunjungan']['rujukLanjut']['kdppk'] ?? null;
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] = $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] ?? null;
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis']  = $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis']  ?? null;
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana']       = $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] ?? null;

            $this->FormEntry['addKunjungan']['kdTacc'] = '-1';
            $this->FormEntry['addKunjungan']['alasanTacc'] = null;

            $this->FormEntry['addKunjungan']['nonSpesialis'] = $this->FormEntry['addKunjungan']['nonSpesialis'] ?? false;
            $this->getDiagnosaBpjs();
        }
    }

    private function syncDataFormEntry(): void
    { /* wire:model side-effects here if needed */
    }
    private function syncLOV(): void
    { /* noop */
    }

    ////////////////// Validation //////////////////
    private function validateData(): void
    {
        try {
            $this->validate($this->rules, $this->messages, $this->validationAttributes);
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
            $this->validate($this->rules, customErrorMessagesTrait::messages(), $this->validationAttributes);
        }
    }

    ////////////////// Concurrency helpers //////////////////
    private function withRjLock(string $rjNo, \Closure $fn)
    {
        $lockKey = "rj:{$rjNo}";
        Cache::lock($lockKey, 5)->block(3, function () use ($fn, $rjNo) {
            DB::transaction(function () use ($fn, $rjNo) {
                // guard header row to prevent concurrent changes
                DB::table('rstxn_rjhdrs')->where('rj_no', $rjNo)->first();
                $fn();
            });
        });
    }

    /** Patch ONLY PCare subtree to avoid clobbering other modules */
    private function patchJsonKunjungan(): void
    {
        $rjNo = $this->FormEntry['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) return;

        $this->withRjLock($rjNo, function () use ($rjNo) {
            $freshWrap = $this->findDataRJ($rjNo);
            $fresh = $freshWrap['dataDaftarRJ'] ?? [];
            if (!is_array($fresh)) $fresh = [];

            // ensure keys exist
            if (!isset($fresh['addKunjungan']) || !is_array($fresh['addKunjungan'])) $fresh['addKunjungan'] = [];

            // apply patch from local state
            $fresh['addKunjungan'] = $this->FormEntry['addKunjungan'] ?? [];
            if (isset($this->FormEntry['dataKunjungan'])) {
                $fresh['dataKunjungan'] = $this->FormEntry['dataKunjungan'];
            } else {
                unset($fresh['dataKunjungan']);
            }

            $this->updateJsonRJ($rjNo, $fresh);
            $this->FormEntry = $fresh; // sync back
        });
    }

    ////////////////// Actions //////////////////
    public function store()
    {
        $this->validateData();
        try {
            if (empty($this->FormEntry['dataKunjungan'])) {
                $this->addKunjunganBpjs();
            } else {
                $this->editKunjunganBpjs();
            }
            $this->patchJsonKunjungan();
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Data Berhasil disimpan');
        } catch (LockTimeoutException $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
        }
    }

    private function addKunjunganBpjs(): void
    {
        $resp = $this->addKunjungan($this->FormEntry['addKunjungan'])->getOriginalContent();
        if (($resp['metadata']['code'] ?? 0) == 201) {
            $this->FormEntry['dataKunjungan'] = $resp['response'];
            $noKunjungan = collect($this->FormEntry['dataKunjungan'])->where('field', 'noKunjungan')->first()['message'] ?? null;
            $this->FormEntry['addKunjungan']['noKunjungan'] = $noKunjungan;
        } else {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError(json_encode($resp, JSON_UNESCAPED_UNICODE));
        }
    }

    private function editKunjunganBpjs(): void
    {
        $resp = $this->editKunjungan($this->FormEntry['addKunjungan'])->getOriginalContent();
        if (($resp['metadata']['code'] ?? 0) == 200) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess($resp['metadata']['message'] ?? 'Berhasil memperbarui');
        } else {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError(json_encode($resp, JSON_UNESCAPED_UNICODE));
        }
    }

    public function deleteKunjunganBpjs(): void
    {
        try {
            $resp = $this->deleteKunjungan($this->FormEntry['addKunjungan']['noKunjungan'] ?? '')->getOriginalContent();
            if (($resp['metadata']['code'] ?? 0) == 200) {
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess($resp['metadata']['message'] ?? 'Berhasil dihapus');
                unset($this->FormEntry['dataKunjungan'], $this->FormEntry['addKunjungan']);
                $this->FormEntry['noUrutBpjs'] = null;
                $this->patchJsonKunjungan();
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Berhasil dihapus');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError(json_encode($resp, JSON_UNESCAPED_UNICODE));
            }
        } catch (Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
        }
    }

    public function resetKunjunganBpjs(): void
    {
        if (!isset($this->FormEntry['dataKunjungan'])) {
            unset($this->FormEntry['addKunjungan'], $this->FormEntry['dataKunjungan']);
            $this->patchJsonKunjungan();
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Data Berhasil dihapus');
        } else {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Data Kunjungan sudah di buat, anda tidak bisa me-reset data ini');
        }
    }

    public function getDiagnosaBpjs(): void
    {
        try {
            $resp = $this->getDiagnosa($this->FormEntry['addKunjungan']['kdDiag1'], 1, 10)->getOriginalContent();
            if (($resp['metadata']['code'] ?? 0) == 200) {
                $this->FormEntry['addKunjungan']['nonSpesialis'] = $resp['response']['list'][0]['nonSpesialis'] ?? false;
                $this->patchJsonKunjungan();
                // toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                //     ->addSuccess('syncronze nonSpesialis status ok!');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError(json_encode($resp, JSON_UNESCAPED_UNICODE));
            }
        } catch (Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
        }
    }

    ////////////////// LOVs //////////////////
    public $providerLov = [];
    public $providerLovStatus = 0;
    public $providerLovSearch = '';

    public function clickproviderlov()
    {
        $this->providerLovStatus = 1;
        $getprovider = json_decode(DB::table('ref_bpjs_table')->where(DB::raw('upper(ref_keterangan)'), '=', strtoupper('Provider'))->first()->ref_json ?? '{}', true);
        $this->providerLov = collect($getprovider)->map(fn($i) => ['providerId' => $i['kdProvider'] ?? '', 'providerDesc' => $i['nmProvider'] ?? ''])->toArray();
    }

    public function setMyproviderLov($id, $desc)
    {
        $this->FormEntry['addKunjungan']['rujukLanjut']['kdppk'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['kdppkDesc'] = $desc;
        $this->providerLovStatus = 0;
        $this->providerLovSearch = '';
        $this->patchJsonKunjungan();
    }

    public $spesialisLov = [];
    public $spesialisLovStatus = 0;
    public $spesialisLovSearch = '';

    public function clickspesialislov()
    {
        $this->spesialisLovStatus = 1;
        $get = json_decode(DB::table('ref_bpjs_table')->where(DB::raw('upper(ref_keterangan)'), '=', strtoupper('Spesialis'))->first()->ref_json ?? '{}', true);
        $this->spesialisLov = collect($get)->map(fn($i) => ['spesialisId' => $i['kdSpesialis'] ?? '', 'spesialisDesc' => $i['nmSpesialis'] ?? ''])->toArray();
    }

    public function updatedspesialislovsearch()
    {
        $search = $this->spesialisLovSearch;
        $get = json_decode(DB::table('ref_bpjs_table')->where(DB::raw('upper(ref_keterangan)'), '=', strtoupper('Spesialis'))->first()->ref_json ?? '{}', true);
        $list = collect($get)->map(fn($i) => ['spesialisId' => $i['kdSpesialis'] ?? '', 'spesialisDesc' => $i['nmSpesialis'] ?? ''])->toArray();
        $this->spesialisLov = $list;

        $found = collect($list)->firstWhere('spesialisId', $search);
        if ($found) {
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1'] = $found['spesialisId'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1Desc'] = $found['spesialisDesc'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis'] = $found['spesialisId'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialisDesc'] = $found['spesialisDesc'];
            foreach (['kdSubSpesialis1', 'kdSubSpesialis', 'kdSubSpesialis1Desc', 'kdSubSpesialisDesc'] as $k) $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis'][$k] = '';
            $this->spesialisLovStatus = 0;
            $this->spesialisLovSearch = '';
        } else {
            $this->spesialisLov = strlen((string)$search) < 1 ? $list : collect($list)->filter(fn($i) => false !== stristr($i['spesialisDesc'], $search));
            $this->spesialisLovStatus = 1;
            foreach (['kdSpesialis1', 'kdSpesialis', 'kdSpesialis1Desc', 'kdSpesialisDesc', 'kdSubSpesialis1', 'kdSubSpesialis', 'kdSubSpesialis1Desc', 'kdSubSpesialisDesc'] as $k) $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis'][$k] = '';
        }
        $this->patchJsonKunjungan();
    }

    public function setMyspesialisLov($id, $desc)
    {
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1Desc'] = $desc;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialisDesc'] = $desc;
        foreach (['kdSubSpesialis1', 'kdSubSpesialis', 'kdSubSpesialis1Desc', 'kdSubSpesialisDesc'] as $k) $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis'][$k] = '';
        $this->spesialisLovStatus = 0;
        $this->spesialisLovSearch = '';
        $this->patchJsonKunjungan();
    }

    public $subSpesialisLov = [];
    public $subSpesialisLovStatus = 0;
    public $subSpesialisLovSearch = '';

    public function clicksubSpesialislov()
    {
        $this->subSpesialisLovStatus = 1;
        $get = $this->getReferensiSubSpesialis($this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1'] ?? '')->getOriginalContent()['response']['list'] ?? [];
        $this->subSpesialisLov = collect($get)->map(fn($i) => ['subSpesialisId' => $i['kdSubSpesialis'] ?? '', 'subSpesialisDesc' => $i['nmSubSpesialis'] ?? ''])->toArray();
    }

    public function updatedsubspesialislovsearch()
    {
        $search = $this->subSpesialisLovSearch;
        $get = $this->getReferensiSubSpesialis($this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1'] ?? '')->getOriginalContent()['response']['list'] ?? [];
        $list = collect($get)->map(fn($i) => ['subSpesialisId' => $i['kdSubSpesialis'] ?? '', 'subSpesialisDesc' => $i['nmSubSpesialis'] ?? ''])->toArray();
        $this->subSpesialisLov = $list;

        $found = collect($list)->firstWhere('subSpesialisId', $search);
        if ($found) {
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] = $found['subSpesialisId'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1Desc'] = $found['subSpesialisDesc'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis'] = $found['subSpesialisId'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialisDesc'] = $found['subSpesialisDesc'];
            $this->subSpesialisLovStatus = 0;
            $this->subSpesialisLovSearch = '';
        } else {
            $this->subSpesialisLov = strlen((string)$search) < 1 ? $list : collect($list)->filter(fn($i) => false !== stristr($i['subSpesialisDesc'], $search));
            $this->subSpesialisLovStatus = 1;
            foreach (['kdSubSpesialis1', 'kdSubSpesialis', 'kdSubSpesialis1Desc', 'kdSubSpesialisDesc'] as $k) $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis'][$k] = '';
        }
        $this->patchJsonKunjungan();
    }

    public function setMysubSpesialisLov($id, $desc)
    {
        foreach ([['kdSubSpesialis1', $id], ['kdSubSpesialis1Desc', $desc], ['kdSubSpesialis', $id], ['kdSubSpesialisDesc', $desc]] as [$k, $v]) {
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis'][$k] = $v;
        }
        $this->subSpesialisLovStatus = 0;
        $this->subSpesialisLovSearch = '';
        $this->patchJsonKunjungan();
    }

    public $saranaLov = [];
    public $saranaLovStatus = 0;
    public $saranaLovSearch = '';

    public function clicksaranalov()
    {
        $this->saranaLovStatus = 1;
        $get = json_decode(DB::table('ref_bpjs_table')->where(DB::raw('upper(ref_keterangan)'), '=', strtoupper('Sarana'))->first()->ref_json ?? '{}', true);
        $this->saranaLov = collect($get)->map(fn($i) => ['saranaId' => $i['kdSarana'] ?? '', 'saranaDesc' => $i['nmSarana'] ?? ''])->toArray();
    }

    public function updatedsaranalovsearch()
    {
        $search = $this->saranaLovSearch;
        $get = json_decode(DB::table('ref_bpjs_table')->where(DB::raw('upper(ref_keterangan)'), '=', strtoupper('Sarana'))->first()->ref_json ?? '{}', true);
        $list = collect($get)->map(fn($i) => ['saranaId' => $i['kdSarana'] ?? '', 'saranaDesc' => $i['nmSarana'] ?? ''])->toArray();
        $this->saranaLov = $list;

        $found = collect($list)->firstWhere('saranaId', $search);
        if ($found) {
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] = $found['saranaId'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSaranaDesc'] = $found['saranaDesc'];
            $this->saranaLovStatus = 0;
            $this->saranaLovSearch = '';
        } else {
            $this->saranaLov = strlen((string)$search) < 1 ? $list : collect($list)->filter(fn($i) => false !== stristr($i['saranaDesc'], $search));
            $this->saranaLovStatus = 1;
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSaranaDesc'] = '';
        }
        $this->patchJsonKunjungan();
    }

    public function setMysaranaLov($id, $desc)
    {
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSaranaDesc'] = $desc;
        $this->saranaLovStatus = 0;
        $this->saranaLovSearch = '';
        $this->patchJsonKunjungan();
    }

    public function clicktglEstRujuk()
    {
        if (!($this->FormEntry['addKunjungan']['rujukLanjut']['tglEstRujuk'] ?? null)) {
            $this->FormEntry['addKunjungan']['rujukLanjut']['tglEstRujuk'] = Carbon::now(env('APP_TIMEZONE'))->addDays(3)->format('d-m-Y');
        }
    }

    ////////////////// External lookups (no dd) //////////////////
    public function checkRiwayatKunjunganPasien($noKartu): void
    {
        $messages = [
            'noKartu.required' => 'Nomor kartu BPJS tidak boleh kosong.',
            'noKartu.digits'   => 'Nomor kartu BPJS harus 13 digit.',
            'noKartu.numeric'  => 'Nomor kartu BPJS harus berupa angka.',
        ];
        $validator = Validator::make(['noKartu' => $noKartu], ['noKartu' => 'required|numeric|digits:13'], $messages);
        if ($validator->fails()) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($validator->errors()->first());
            return;
        }

        $data = $this->getRiwayatKunjungan($noKartu)->getData(true);
        $list = $data['response']['list'] ?? [];
        $this->emit('riwayat-kunjungan-loaded', $list);
    }

    public function checkRujukanKunjungan($noRujukan): void
    {
        $messages = [
            'noRujukan.required' => 'Nomor rujukan BPJS tidak boleh kosong.',
            'noRujukan.size'     => 'Nomor rujukan BPJS harus tepat 19 karakter.',
        ];
        $validator = Validator::make(['noRujukan' => $noRujukan], ['noRujukan' => 'required|string|size:19'], $messages);
        if ($validator->fails()) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($validator->errors()->first());
            return;
        }

        $data = $this->getRujukanKunjungan($noRujukan)->getData(true);
        $list = $data['response'] ?? [];
        $this->emit('rujukan-kunjungan-loaded', $list);
    }
}
