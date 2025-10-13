<?php

namespace App\Http\Livewire\Pcare\RJ\Kunjungan;

use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;

use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\EmrRJ\EmrRJTrait;
use App\Http\Traits\MasterPasien\MasterPasienTrait;
use App\Http\Traits\BPJS\PcareTrait;

use Illuminate\Support\Facades\Validator;


use Livewire\Component;

class FormEntryKunjungan extends Component
{
    use EmrRJTrait, MasterPasienTrait, PcareTrait;

    // listener from blade////////////////
    protected $listeners = [
        'syncronizeAssessmentPerawatRJFindData' => 'mount',
        'syncronizeAssessmentDokterRJFindData' => 'mount',
    ];

    public string $rjNoRef;
    public bool $rjStatusRef = false;
    public string $isOpenMode = 'insert';

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

    // rules///////////////////
    protected $rules = [
        "FormEntry.addKunjungan.noKunjungan" => "",
        "FormEntry.addKunjungan.noKartu" => "",
        "FormEntry.addKunjungan.tglDaftar" => "",
        "FormEntry.addKunjungan.kdPoli" => "",
        "FormEntry.addKunjungan.keluhan" => "",
        "FormEntry.addKunjungan.kdSadar" => "",
        "FormEntry.addKunjungan.sistole" => "",
        "FormEntry.addKunjungan.diastole" => "",
        "FormEntry.addKunjungan.beratBadan" => "",
        "FormEntry.addKunjungan.tinggiBadan" => "",
        "FormEntry.addKunjungan.respRate" => "",
        "FormEntry.addKunjungan.heartRate" => "",
        "FormEntry.addKunjungan.lingkarPerut" => "",
        "FormEntry.addKunjungan.kdStatusPulang" => "",
        "FormEntry.addKunjungan.tglPulang" => "",
        "FormEntry.addKunjungan.kdDokter" => "",
        "FormEntry.addKunjungan.kdDiag1" => "",
        "FormEntry.addKunjungan.kdDiag2" => "",
        "FormEntry.addKunjungan.kdDiag3" => "",
        "FormEntry.addKunjungan.kdPoliRujukInternal" => "",

        "FormEntry.addKunjungan.rujukLanjut.tglEstRujuk" => "",
        "FormEntry.addKunjungan.rujukLanjut.kdppk" => "",
        "FormEntry.addKunjungan.rujukLanjut.subSpesialis" => "",

        "FormEntry.addKunjungan.rujukLanjut.khusus" => "",
        "FormEntry.addKunjungan.rujukLanjut.khusus.kdKhusus" => "",
        "FormEntry.addKunjungan.rujukLanjut.khusus.kdSubSpesialis1" => "",
        "FormEntry.addKunjungan.rujukLanjut.khusus.catatan" => "",

        "FormEntry.addKunjungan.kdTacc" => "",
        "FormEntry.addKunjungan.alasanTacc" => "",
        "FormEntry.addKunjungan.anamnesa" => "",
        "FormEntry.addKunjungan.alergiMakan" => "",
        "FormEntry.addKunjungan.alergiUdara" => "",
        "FormEntry.addKunjungan.alergiObat" => "",
        "FormEntry.addKunjungan.kdPrognosa" => "",
        "FormEntry.addKunjungan.terapiObat" => "",
        "FormEntry.addKunjungan.terapiNonObat" => "",
        "FormEntry.addKunjungan.bmhp" => "",
        "FormEntry.addKunjungan.suhu" => ""
    ];

    protected $messages = [];

    protected $validationAttributes = [
        // 'FormEntry.poliId' => 'Kode Poliklinik',
    ];
    // rules///////////////////







    private function findData($id): void
    {
        try {
            $findData = $this->findDataRJ($id);
            if (isset($findData['errorMessages'])) {

                $this->emit('toastr-error', $findData['errorMessages']);
                $this->emit('CloseModal');
                // return;
            }


            $this->FormEntry  = $findData['dataDaftarRJ'];
            $this->displayPasien  = $this->findDataMasterPasien($this->FormEntry['regNo']);

            $this->syncDataPrimer();
            $this->rjStatusRef = $this->checkRJStatus($id);
        } catch (Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            $this->emit('CloseModal');
            return;
        }
    }




    private function syncDataPrimer(): void
    {

        if (isset($this->FormEntry['dataKunjungan'])) {
            // edit kunjungan
            $noKunjungan = collect($this->FormEntry['dataKunjungan'])
                ->where('field', '=', 'noKunjungan')
                ->first()['message'] ?? null;

            $this->FormEntry['addKunjungan']['noKunjungan'] = $noKunjungan;
        }
        // sync data primer dilakukan ketika update
        if (empty($this->FormEntry['addKunjungan']['noKunjungan'])) {

            // default array
            $this->FormEntry['addKunjungan'] = $this->addKunjungan;
            // default array

            $this->FormEntry['addKunjungan']['noKartu'] = $this->displayPasien['pasien']['identitas']['idBpjs'] ?? '';
            // entry no kunjungan
            $this->FormEntry['addKunjungan']['noKunjungan'] =  null; //$this->FormEntry['noUrutBpjs'] ?? '';


            $this->FormEntry['addKunjungan']['kdPoli'] = $this->FormEntry['kdpolibpjs'] ?? '';

            $this->FormEntry['addKunjungan']['tglDaftar'] = Carbon::createFromFormat('d/m/Y H:i:s', $this->FormEntry['rjDate'], env('APP_TIMEZONE'))->format('d-m-Y') ?? '';
            $this->FormEntry['addKunjungan']['tglPulang'] = Carbon::createFromFormat('d/m/Y H:i:s', $this->FormEntry['rjDate'], env('APP_TIMEZONE'))->format('d-m-Y') ?? '';

            $this->FormEntry['addKunjungan']['keluhan'] = $this->FormEntry['anamnesa']['keluhanUtama']['keluhanUtama'] ?? '';
            $this->FormEntry['addKunjungan']['anamnesa'] = $this->FormEntry['anamnesa']['riwayatPenyakitSekarangUmum']['riwayatPenyakitSekarangUmum'] ?? '';

            $this->FormEntry['addKunjungan']['alergiMakan'] = $this->FormEntry['anamnesa']['alergi']['alergiMakanan'] ?? '';
            $this->FormEntry['addKunjungan']['alergiUdara'] = $this->FormEntry['anamnesa']['alergi']['alergiUdara'] ?? '';
            $this->FormEntry['addKunjungan']['alergiObat'] = $this->FormEntry['anamnesa']['alergi']['alergiObat'] ?? '';

            $this->FormEntry['addKunjungan']['kdPrognosa'] = $this->FormEntry['perencanaan']['prognosa']['prognosa'] ?? '';


            $this->FormEntry['addKunjungan']['terapiObat'] = $this->FormEntry['perencanaan']['terapi']['terapi'] ?? '';
            $this->FormEntry['addKunjungan']['terapiNonObat'] = $this->FormEntry['perencanaan']['terapi']['terapiNonObat'] ?? '';

            $this->FormEntry['addKunjungan']['kdDiag1'] = $this->FormEntry['diagnosis'][0]['diagId'] ?? null;
            $this->FormEntry['addKunjungan']['kdDiag2'] = $this->FormEntry['diagnosis'][1]['diagId'] ?? null;
            $this->FormEntry['addKunjungan']['kdDiag3'] = $this->FormEntry['diagnosis'][2]['diagId'] ?? null;

            $this->FormEntry['addKunjungan']['kdPoliRujukInternal'] = null;


            $this->FormEntry['addKunjungan']['kdSadar'] = $this->FormEntry['pemeriksaan']['tandaVital']['tingkatKesadaran'] ?? '';

            $this->FormEntry['addKunjungan']['suhu'] = $this->FormEntry['pemeriksaan']['tandaVital']['suhu'] ?? '';
            $this->FormEntry['addKunjungan']['tinggiBadan'] = $this->FormEntry['pemeriksaan']['nutrisi']['tb'] ?? '';
            $this->FormEntry['addKunjungan']['beratBadan'] = $this->FormEntry['pemeriksaan']['nutrisi']['bb'] ?? '';
            $this->FormEntry['addKunjungan']['lingkarPerut'] = $this->FormEntry['pemeriksaan']['nutrisi']['liPerut'] ?? '';
            // imt blm ada

            $this->FormEntry['addKunjungan']['sistole'] = $this->FormEntry['pemeriksaan']['tandaVital']['sistolik'] ?? '';
            $this->FormEntry['addKunjungan']['diastole'] = $this->FormEntry['pemeriksaan']['tandaVital']['distolik'] ?? '';

            $this->FormEntry['addKunjungan']['respRate'] = $this->FormEntry['pemeriksaan']['tandaVital']['frekuensiNafas'] ?? '';
            $this->FormEntry['addKunjungan']['heartRate'] = $this->FormEntry['pemeriksaan']['tandaVital']['frekuensiNadi'] ?? '';


            $this->FormEntry['addKunjungan']['kdStatusPulang'] = $this->FormEntry['perencanaan']['tindakLanjut']['tindakLanjut'] ?? '';
            $this->FormEntry['addKunjungan']['kdDokter'] = $this->FormEntry['kddrbpjs'] ?? '';


            $this->FormEntry['addKunjungan']['rujukLanjut']['tglEstRujuk'] = $this->FormEntry['addKunjungan']['rujukLanjut']['tglEstRujuk'] ?? Carbon::createFromFormat('d/m/Y H:i:s', $this->FormEntry['rjDate'], env('APP_TIMEZONE'))->format('d-m-Y') ?? '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['kdppk'] = $this->FormEntry['addKunjungan']['rujukLanjut']['kdppk'] ?? null;
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] = $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] ?? null;
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis'] = $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis'] ?? null;
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] = $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] ?? null;




            $this->FormEntry['addKunjungan']['kdTacc'] = '-1';
            $this->FormEntry['addKunjungan']['alasanTacc'] = null;

            $this->FormEntry['addKunjungan']['nonSpesialis'] = $this->FormEntry['addKunjungan']['nonSpesialis'] ?? false;
            // cari tau status nonSpesialis true/false untuk menggunakan TACC atau tidak
            $this->getDiagnosaBpjs();

            // dd($this->getRiwayatKunjungan($this->FormEntry['addKunjungan']['noKartu']));
        }
    }

    // validate Data RJ//////////////////////////////////////////////////
    private function validateData(): void
    {
        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($this->rules, customErrorMessagesTrait::messages());
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->emit('toastr-error', $e->getMessage());
            $this->validate($this->rules, customErrorMessagesTrait::messages());
        }
    }

    private function syncDataFormEntry(): void
    {
        //  Entry ketika Mont
        // Pasien Baru Lama di blade wire:model
    }
    private function syncLOV(): void {}

    // /////////provider////////////
    public $providerLov = [];
    public $providerLovStatus = 0;
    public $providerLovSearch = '';
    public function clickproviderlov()
    {
        $this->providerLovStatus = true;

        $getprovider = json_decode(DB::table('ref_bpjs_table')
            ->Where(DB::raw('upper(ref_keterangan)'), '=', strtoupper('Provider'))
            ->first()->ref_json ?? '{}', true);

        $this->providerLov = collect($getprovider)->map(function ($item) {
            $item['providerId'] = $item['kdProvider'];
            unset($item['kdProvider']);
            $item['providerDesc'] = $item['nmProvider'];
            unset($item['nmProvider']);
            return $item;
        })->toArray();
    }

    // /////////////////////
    // LOV selected start
    public function setMyproviderLov($id, $desc)
    {
        $this->FormEntry['addKunjungan']['rujukLanjut']['kdppk'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['kdppkDesc'] = $desc;

        $this->providerLovStatus = false;
        $this->providerLovSearch = '';
        $this->synJsonRJ();
    }
    // LOV selected end
    // /////////////////////

    // /////////spesialis////////////
    public $spesialisLov = [];
    public $spesialisLovStatus = 0;
    public $spesialisLovSearch = '';
    public function clickspesialislov()
    {
        $this->spesialisLovStatus = true;

        $getspesialis = json_decode(DB::table('ref_bpjs_table')
            ->Where(DB::raw('upper(ref_keterangan)'), '=', strtoupper('Spesialis'))
            ->first()->ref_json ?? '{}', true);

        $this->spesialisLov = collect($getspesialis)->map(function ($item) {
            $item['spesialisId'] = $item['kdSpesialis'];
            unset($item['kdSpesialis']);
            $item['spesialisDesc'] = $item['nmSpesialis'];
            unset($item['nmSpesialis']);
            return $item;
        })->toArray();
    }
    public function updatedspesialislovsearch()
    {
        // Variable Search
        $search = $this->spesialisLovSearch;

        $getspesialis = json_decode(DB::table('ref_bpjs_table')
            ->Where(DB::raw('upper(ref_keterangan)'), '=', strtoupper('Spesialis'))
            ->first()->ref_json ?? '{}', true);

        $this->spesialisLov = collect($getspesialis)->map(function ($item) {
            $item['spesialisId'] = $item['kdSpesialis'];
            unset($item['kdSpesialis']);
            $item['spesialisDesc'] = $item['nmSpesialis'];
            unset($item['nmSpesialis']);
            return $item;
        })->toArray();

        // check LOV by id
        $GetData = collect($this->spesialisLov)
            ->where('spesialisId', '=', $search)
            ->first();

        if ($GetData) {
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1'] = $GetData['spesialisId'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1Desc'] = $GetData['spesialisDesc'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis'] = $GetData['spesialisId'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialisDesc'] = $GetData['spesialisDesc'];

            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1Desc'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialisDesc'] = '';

            $this->spesialisLovStatus = false;
            $this->spesialisLovSearch = '';
        } else {
            // if there is no id found and check (min 1 char on search)
            if (strlen($search) < 1) {
                $this->spesialisLov = collect($getspesialis)->map(function ($item) {
                    $item['spesialisId'] = $item['kdSpesialis'];
                    unset($item['kdSpesialis']);
                    $item['spesialisDesc'] = $item['nmSpesialis'];
                    unset($item['nmSpesialis']);
                    return $item;
                })->toArray();
            } else {
                $this->spesialisLov = collect(collect($getspesialis)->map(function ($item) {
                    $item['spesialisId'] = $item['kdSpesialis'];
                    unset($item['kdSpesialis']);
                    $item['spesialisDesc'] = $item['nmSpesialis'];
                    unset($item['nmSpesialis']);
                    return $item;
                })->toArray())
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['spesialisDesc'], $search);
                    });
            }
            $this->spesialisLovStatus = true;
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1Desc'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialisDesc'] = '';

            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1Desc'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialisDesc'] = '';
        }
        $this->synJsonRJ();
    }
    // /////////////////////
    // LOV selected start
    public function setMyspesialisLov($id, $desc)
    {
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1Desc'] = $desc;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialisDesc'] = $desc;

        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] = '';
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1Desc'] = '';
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis'] = '';
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialisDesc'] = '';

        $this->spesialisLovStatus = false;
        $this->spesialisLovSearch = '';
        $this->synJsonRJ();
    }
    // LOV selected end
    // /////////////////////

    // /////////subSpesialis////////////
    public $subSpesialisLov = [];
    public $subSpesialisLovStatus = 0;
    public $subSpesialisLovSearch = '';
    public function clicksubSpesialislov()
    {
        $this->subSpesialisLovStatus = true;
        $getSubSpesialis = $this->getReferensiSubSpesialis($this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1'] ?? '')->getOriginalContent()['response']['list'] ?? [];

        $this->subSpesialisLov = collect($getSubSpesialis)->map(function ($item) {
            $item['subSpesialisId'] = $item['kdSubSpesialis'];
            unset($item['kdSubSpesialis']);
            $item['subSpesialisDesc'] = $item['nmSubSpesialis'];
            unset($item['nmSubSpesialis']);
            return $item;
        })->toArray();
    }
    public function updatedsubspesialislovsearch()
    {
        // Variable Search
        $search = $this->subSpesialisLovSearch;


        $getSubSpesialis = $this->getReferensiSubSpesialis($this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis1'] ?? '')->getOriginalContent()['response']['list'] ?? [];


        $this->subSpesialisLov = collect($getSubSpesialis)->map(function ($item) {
            $item['subSpesialisId'] = $item['kdSubSpesialis'];
            unset($item['kdSubSpesialis']);
            $item['subSpesialisDesc'] = $item['nmSubSpesialis'];
            unset($item['nmSubSpesialis']);
            return $item;
        })->toArray();

        // check LOV by id
        $GetData = collect($this->subSpesialisLov)
            ->where('subSpesialisId', '=', $search)
            ->first();

        if ($GetData) {
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] = $GetData['subSpesialisId'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1Desc'] = $GetData['subSpesialisDesc'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis'] = $GetData['subSpesialisId'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialisDesc'] = $GetData['subSpesialisDesc'];

            $this->subSpesialisLovStatus = false;
            $this->subSpesialisLovSearch = '';
        } else {
            // if there is no id found and check (min 1 char on search)
            if (strlen($search) < 1) {
                $this->subSpesialisLov = collect($getSubSpesialis)->map(function ($item) {
                    $item['subSpesialisId'] = $item['kdSubSpesialis'];
                    unset($item['kdSubSpesialis']);
                    $item['subSpesialisDesc'] = $item['nmSubSpesialis'];
                    unset($item['nmSubSpesialis']);
                    return $item;
                })->toArray();
            } else {
                $this->subSpesialisLov = collect(collect($getSubSpesialis)->map(function ($item) {
                    $item['subSpesialisId'] = $item['kdSubSpesialis'];
                    unset($item['kdSubSpesialis']);
                    $item['subSpesialisDesc'] = $item['nmSubSpesialis'];
                    unset($item['nmSubSpesialis']);
                    return $item;
                })->toArray())
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['subSpesialisDesc'], $search);
                    });
            }
            $this->subSpesialisLovStatus = true;
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1Desc'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialisDesc'] = '';
        }
        $this->synJsonRJ();
    }
    // /////////////////////
    // LOV selected start
    public function setMysubSpesialisLov($id, $desc)
    {
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1Desc'] = $desc;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialisDesc'] = $desc;

        $this->subSpesialisLovStatus = false;
        $this->subSpesialisLovSearch = '';
        $this->synJsonRJ();
    }
    // LOV selected end
    // /////////////////////


    // /////////sarana////////////
    public $saranaLov = [];
    public $saranaLovStatus = 0;
    public $saranaLovSearch = '';
    public function clicksaranalov()
    {
        $this->saranaLovStatus = true;

        $getsarana = json_decode(DB::table('ref_bpjs_table')
            ->Where(DB::raw('upper(ref_keterangan)'), '=', strtoupper('Sarana'))
            ->first()->ref_json ?? '{}', true);

        $this->saranaLov = collect($getsarana)->map(function ($item) {
            $item['saranaId'] = $item['kdSarana'];
            unset($item['kdSarana']);
            $item['saranaDesc'] = $item['nmSarana'];
            unset($item['nmSarana']);
            return $item;
        })->toArray();
    }

    public function updatedsaranalovsearch()
    {
        // Variable Search
        $search = $this->saranaLovSearch;

        $getsarana = json_decode(DB::table('ref_bpjs_table')
            ->Where(DB::raw('upper(ref_keterangan)'), '=', strtoupper('Sarana'))
            ->first()->ref_json ?? '{}', true);

        $this->saranaLov = collect($getsarana)->map(function ($item) {
            $item['saranaId'] = $item['kdSarana'];
            unset($item['kdSarana']);
            $item['saranaDesc'] = $item['nmSarana'];
            unset($item['nmSarana']);
            return $item;
        })->toArray();

        // check LOV by id
        $GetData = collect($this->saranaLov)
            ->where('saranaId', '=', $search)
            ->first();

        if ($GetData) {
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] = $GetData['saranaId'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSaranaDesc'] = $GetData['saranaDesc'];

            $this->saranaLovStatus = false;
            $this->saranaLovSearch = '';
        } else {
            // if there is no id found and check (min 1 char on search)
            if (strlen($search) < 1) {
                $this->saranaLov = collect($getsarana)->map(function ($item) {
                    $item['saranaId'] = $item['kdSarana'];
                    unset($item['kdSarana']);
                    $item['saranaDesc'] = $item['nmSarana'];
                    unset($item['nmSarana']);
                    return $item;
                })->toArray();
            } else {
                $this->saranaLov = collect(collect($getsarana)->map(function ($item) {
                    $item['saranaId'] = $item['kdSarana'];
                    unset($item['kdSarana']);
                    $item['saranaDesc'] = $item['nmSarana'];
                    unset($item['nmSarana']);
                    return $item;
                })->toArray())
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['saranaDesc'], $search);
                    });
            }
            $this->saranaLovStatus = true;
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSaranaDesc'] = '';
        }

        $this->synJsonRJ();
    }

    // /////////////////////
    // LOV selected start
    public function setMysaranaLov($id, $desc)
    {
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSaranaDesc'] = $desc;

        $this->saranaLovStatus = false;
        $this->saranaLovSearch = '';
        $this->synJsonRJ();
    }
    // LOV selected end
    // /////////////////////


    public function store()
    {
        // validate
        $this->validateData();
        // Jika mode data //insert
        if (empty($this->FormEntry['dataKunjungan'])) {
            $this->addKunjunganBpjs();
        } else {
            $this->editKunjunganBpjs();
        }
        $this->updateJsonRJ($this->FormEntry['rjNo'], $this->FormEntry);
        $this->emit('syncronizeAssessmentPerawatRJFindData');
        $this->emit('syncronizeAssessmentDokterRJFindData');
        $this->emit('toastr-success', 'Data Berhasil disimpan');
    }

    private function addKunjunganBpjs(): void
    {
        try {
            $addKunjungan = $this->addKunjungan($this->FormEntry['addKunjungan'])
                ->getOriginalContent();
            if ($addKunjungan['metadata']['code'] == 201) {
                $this->FormEntry['dataKunjungan'] = $addKunjungan['response'];

                $noKunjungan = collect($this->FormEntry['dataKunjungan'])
                    ->where('field', '=', 'noKunjungan')
                    ->first()['message'] ?? null;

                $this->FormEntry['addKunjungan']['noKunjungan'] = $noKunjungan;
            } else {
                $this->emit('toastr-error', json_encode($addKunjungan, true));
            }
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            return;
        }
    }

    private function editKunjunganBpjs(): void
    {
        try {
            $editKunjungan = $this->editKunjungan($this->FormEntry['addKunjungan'])
                ->getOriginalContent();
            if ($editKunjungan['metadata']['code'] == 200) {
                $this->emit('toastr-success', $editKunjungan['metadata']['message']);
            } else {
                $this->emit('toastr-error', json_encode($editKunjungan, true));
            }
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            return;
        }
    }

    public function deleteKunjunganBpjs(): void
    {
        try {
            $deleteKunjungan = $this->deleteKunjungan($this->FormEntry['addKunjungan']['noKunjungan'] ?? '')
                ->getOriginalContent();
            if ($deleteKunjungan['metadata']['code'] == 200) {
                $this->emit('toastr-success', $deleteKunjungan['metadata']['message']);
                unset($this->FormEntry['dataKunjungan']);
                unset($this->FormEntry['addKunjungan']);
                $this->FormEntry['noUrutBpjs'] = null;

                $this->synJsonRJ();
                $this->emit('toastr-success', 'Data Berhasil dihapus');
            } else {
                $this->emit('toastr-error', json_encode($deleteKunjungan, true));
            }
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            return;
        }
    }

    public function resetKunjunganBpjs(): void
    {
        try {
            // ketika data kunjungan belum ter create masih bisa di reset
            if (!isset($this->FormEntry['dataKunjungan'])) {
                unset($this->FormEntry['addKunjungan']);
                unset($this->FormEntry['dataKunjungan']);
                $this->synJsonRJ();
                $this->emit('toastr-success', 'Data Berhasil dihapus');
            } else {
                $this->emit('toastr-error', 'Data Kunjungan sudah di buat, anda tidak bisa me-reset data ini');
            }
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            return;
        }
    }


    public function getDiagnosaBpjs(): void
    {
        try {
            $getDiagnosa = $this->getDiagnosa($this->FormEntry['addKunjungan']['kdDiag1'], 1, 10)
                ->getOriginalContent();

            if ($getDiagnosa['metadata']['code'] == 200) {
                // dd($getDiagnosa['response']['list'][0]['nonSpesialis']);
                $this->FormEntry['addKunjungan']['nonSpesialis'] = $getDiagnosa['response']['list'][0]['nonSpesialis'] ?? false;
                $this->synJsonRJ();
                $this->emit('toastr-success', 'syncronze nonSpesialis status ok!');
                // dd($this->FormEntry['addKunjungan']);
            } else {
                $this->emit('toastr-error', json_encode($getDiagnosa, true));
            }
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
        }
    }


    // /////////faskesRujukan////////////
    public $faskesRujukanLov = [];
    public $faskesRujukanLovStatus = 0;
    public $faskesRujukanLovSearch = '';
    public function clickfaskesRujukanlov()
    {
        $this->faskesRujukanLovStatus = true;

        $kdSubSpesialis = $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis']  ?? null;
        $kdSarana = $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] ?? null;
        $tglEstRujuk = $this->FormEntry['addKunjungan']['rujukLanjut']['tglEstRujuk'] ?? null;
        $getFaskesRujukanSubSpesialis = $this->getFaskesRujukanSubSpesialis($kdSubSpesialis, $kdSarana, $tglEstRujuk)
            ->getOriginalContent();

        $this->faskesRujukanLov = $getFaskesRujukanSubSpesialis['response']['list'] ?? [];
    }
    public function updatedfaskesRujukanlovsearch()
    {
        // Variable Search
        $search = $this->faskesRujukanLovSearch;

        $kdSubSpesialis = $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis']  ?? null;
        $kdSarana = $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] ?? null;
        $tglEstRujuk = $this->FormEntry['addKunjungan']['rujukLanjut']['tglEstRujuk'] ?? null;
        $getFaskesRujukanSubSpesialis = $this->getFaskesRujukanSubSpesialis($kdSubSpesialis, $kdSarana, $tglEstRujuk)
            ->getOriginalContent();

        $this->faskesRujukanLov = $getFaskesRujukanSubSpesialis['response']['list'] ?? [];

        // check LOV by id
        $GetData = collect($this->faskesRujukanLov)
            ->where('kdppk', '=', $search)
            ->first();

        if ($GetData) {
            $this->FormEntry['addKunjungan']['rujukLanjut']['kdppk'] = $GetData['kdppk'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['nmppk'] = $GetData['nmppk'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['alamatPpk'] = $GetData['alamatPpk'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['telpPpk'] = $GetData['telpPpk'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['kelas'] = $GetData['kelas'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['nmkc'] = $GetData['nmkc'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['jadwal'] = $GetData['jadwal'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['jmlRujuk'] = $GetData['jmlRujuk'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['kapasitas'] = $GetData['kapasitas'];
            $this->FormEntry['addKunjungan']['rujukLanjut']['persentase'] = $GetData['persentase'];




            $this->faskesRujukanLovStatus = false;
            $this->faskesRujukanLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->faskesRujukanLov = $getFaskesRujukanSubSpesialis['response']['list'] ?? [];
            } else {
                $this->faskesRujukanLov = collect($getFaskesRujukanSubSpesialis['response']['list'] ?? [])
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['nmppk'], $search);
                    });
            }
            $this->faskesRujukanLovStatus = true;
            $this->FormEntry['addKunjungan']['rujukLanjut']['kdppk'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['nmppk'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['alamatPpk'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['telpPpk'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['kelas'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['nmkc'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['distance'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['jadwal'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['jmlRujuk'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['kapasitas'] = '';
            $this->FormEntry['addKunjungan']['rujukLanjut']['persentase'] = '';
        }
        $this->synJsonRJ();
    }
    // /////////////////////
    // LOV selected start
    public function setMyfaskesRujukanLov($getData)
    {
        $GetData = json_decode($getData, true);
        $this->FormEntry['addKunjungan']['rujukLanjut']['kdppk'] = $GetData['kdppk'];
        $this->FormEntry['addKunjungan']['rujukLanjut']['nmppk'] = $GetData['nmppk'];
        $this->FormEntry['addKunjungan']['rujukLanjut']['alamatPpk'] = $GetData['alamatPpk'];
        $this->FormEntry['addKunjungan']['rujukLanjut']['telpPpk'] = $GetData['telpPpk'];
        $this->FormEntry['addKunjungan']['rujukLanjut']['kelas'] = $GetData['kelas'];
        $this->FormEntry['addKunjungan']['rujukLanjut']['nmkc'] = $GetData['nmkc'];
        $this->FormEntry['addKunjungan']['rujukLanjut']['distance'] = $GetData['distance'];
        $this->FormEntry['addKunjungan']['rujukLanjut']['jadwal'] = $GetData['jadwal'];
        $this->FormEntry['addKunjungan']['rujukLanjut']['jmlRujuk'] = $GetData['jmlRujuk'];
        $this->FormEntry['addKunjungan']['rujukLanjut']['kapasitas'] = $GetData['kapasitas'];
        $this->FormEntry['addKunjungan']['rujukLanjut']['persentase'] = $GetData['persentase'];

        $this->faskesRujukanLovStatus = false;
        $this->faskesRujukanLovSearch = '';
        $this->synJsonRJ();
    }
    // LOV selected end
    // /////////////////////
    public function clicktglEstRujuk()
    {
        if (!$this->FormEntry['addKunjungan']['rujukLanjut']['tglEstRujuk']) {
            $this->FormEntry['addKunjungan']['rujukLanjut']['tglEstRujuk'] = Carbon::now(env('APP_TIMEZONE'))->addDays(3)->format('d-m-Y');
        }
    }


    private function synJsonRJ(): void
    {
        $this->updateJsonRJ($this->FormEntry['rjNo'], $this->FormEntry);
        $this->emit('syncronizeAssessmentPerawatRJFindData');
        $this->emit('syncronizeAssessmentDokterRJFindData');
    }
    public function mount()
    {
        $this->findData($this->rjNoRef);
    }



    public function checkRiwayatKunjunganPasien($noKartu): void
    {
        $messages = [
            'noKartu.required' => 'Nomor kartu BPJS tidak boleh kosong.',
            'noKartu.digits' => 'Nomor kartu BPJS harus 13 digit.',
            'noKartu.numeric' => 'Nomor kartu BPJS harus berupa angka.',
        ];
        $validator = Validator::make(
            ['noKartu' => $noKartu],
            ['noKartu' => 'required|numeric|digits:13'],
            $messages
        );
        if ($validator->fails()) {
            $this->emit('toastr-error', $validator->errors()->first());
            return;
        }

        // Panggil fungsi getRiwayatKunjungan() yang sudah kamu punya
        $getKunjungan = $this->getRiwayatKunjungan($noKartu);
        $data = $getKunjungan->getData(true); // ambil array-nya

        $list = $data['response']['list'] ?? [];

        dd($list);
        return;
    }

    public function checkRujukanKunjungan($noRujukan): void
    {
        $messages = [
            'noRujukan.required' => 'Nomor rujukan BPJS tidak boleh kosong.',
            'noRujukan.size'   => 'Nomor rujukan BPJS harus tepat 19 karakter.',
        ];
        $validator = Validator::make(
            ['noRujukan' => $noRujukan],
            ['noRujukan' => 'required|string|size:19'],
            $messages
        );
        if ($validator->fails()) {
            $this->emit('toastr-error', $validator->errors()->first());
            return;
        }

        // Panggil fungsi getRujukanKunjungan() yang sudah kamu punya
        $getKunjungan = $this->getRujukanKunjungan($noRujukan);
        $data = $getKunjungan->getData(true); // ambil array-nya

        $list = $data['response'] ?? [];

        dd($list);
        return;
    }



    public function render()
    {
        // LOV
        $this->syncLOV();
        // FormEntry
        $this->syncDataFormEntry();

        return view('livewire.pcare.r-j.kunjungan.form-entry-kunjungan');
    }
}
