<?php

namespace App\Http\Livewire\Pcare\RJ\Kunjungan;

use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;

use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\EmrRJ\EmrRJTrait;
use App\Http\Traits\MasterPasien\MasterPasienTrait;
use App\Http\Traits\BPJS\PcareTrait;



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
        "FormEntry.pcare.addKunjungan.noKunjungan" => "",
        "FormEntry.pcare.addKunjungan.noKartu" => "",
        "FormEntry.pcare.addKunjungan.tglDaftar" => "",
        "FormEntry.pcare.addKunjungan.kdPoli" => "",
        "FormEntry.pcare.addKunjungan.keluhan" => "",
        "FormEntry.pcare.addKunjungan.kdSadar" => "",
        "FormEntry.pcare.addKunjungan.sistole" => "",
        "FormEntry.pcare.addKunjungan.diastole" => "",
        "FormEntry.pcare.addKunjungan.beratBadan" => "",
        "FormEntry.pcare.addKunjungan.tinggiBadan" => "",
        "FormEntry.pcare.addKunjungan.respRate" => "",
        "FormEntry.pcare.addKunjungan.heartRate" => "",
        "FormEntry.pcare.addKunjungan.lingkarPerut" => "",
        "FormEntry.pcare.addKunjungan.kdStatusPulang" => "",
        "FormEntry.pcare.addKunjungan.tglPulang" => "",
        "FormEntry.pcare.addKunjungan.kdDokter" => "",
        "FormEntry.pcare.addKunjungan.kdDiag1" => "",
        "FormEntry.pcare.addKunjungan.kdDiag2" => "",
        "FormEntry.pcare.addKunjungan.kdDiag3" => "",
        "FormEntry.pcare.addKunjungan.kdPoliRujukInternal" => "",

        "FormEntry.pcare.addKunjungan.rujukLanjut.tglEstRujuk" => "",
        "FormEntry.pcare.addKunjungan.rujukLanjut.kdppk" => "",
        "FormEntry.pcare.addKunjungan.rujukLanjut.subSpesialis" => "",

        "FormEntry.pcare.addKunjungan.rujukLanjut.khusus" => "",
        "FormEntry.pcare.addKunjungan.rujukLanjut.khusus.kdKhusus" => "",
        "FormEntry.pcare.addKunjungan.rujukLanjut.khusus.kdSubSpesialis1" => "",
        "FormEntry.pcare.addKunjungan.rujukLanjut.khusus.catatan" => "",

        "FormEntry.pcare.addKunjungan.kdTacc" => "",
        "FormEntry.pcare.addKunjungan.alasanTacc" => "",
        "FormEntry.pcare.addKunjungan.anamnesa" => "",
        "FormEntry.pcare.addKunjungan.alergiMakan" => "",
        "FormEntry.pcare.addKunjungan.alergiUdara" => "",
        "FormEntry.pcare.addKunjungan.alergiObat" => "",
        "FormEntry.pcare.addKunjungan.kdPrognosa" => "",
        "FormEntry.pcare.addKunjungan.terapiObat" => "",
        "FormEntry.pcare.addKunjungan.terapiNonObat" => "",
        "FormEntry.pcare.addKunjungan.bmhp" => "",
        "FormEntry.pcare.addKunjungan.suhu" => ""
    ];

    protected $messages = [];

    protected $validationAttributes = [
        // 'FormEntry.pcare.poliId' => 'Kode Poliklinik',
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

        // sync data primer dilakukan ketika update
        if (isset($this->FormEntry['dataKunjungan']) == false) {
            $this->FormEntry['addKunjungan']['noKartu'] = $this->displayPasien['pasien']['identitas']['idBpjs'] ?? '';
            $this->FormEntry['addKunjungan']['noKunjugan'] =  null; //$this->FormEntry['noUrutBpjs'] ?? '';
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


            if ($this->FormEntry['addKunjungan']['kdStatusPulang'] === '3') {
                $this->FormEntry['addKunjungan']['rujukLanjut']['tglEstRujuk'] = null;
                $this->FormEntry['addKunjungan']['rujukLanjut']['kdppk'] = null;
                $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] = null;
                $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis'] = null;
                $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] = null;
            } else if ($this->FormEntry['addKunjungan']['kdStatusPulang'] === '4') {
                $this->FormEntry['addKunjungan']['rujukLanjut']['tglEstRujuk'] = $this->FormEntry['rjDate'] ?? '';
                $this->FormEntry['addKunjungan']['rujukLanjut']['kdppk'] = null;
                $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] = null;
                $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis'] = null;
                $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] = null;
            }

            $this->FormEntry['addKunjungan']['kdTacc'] = '-1';
            $this->FormEntry['addKunjungan']['alasanTacc'] = null;






            // kecelakanan lalu lintas KKL
            // if Y
            // tgl kejadian
            // propinsi / kab /kec


            //tenaga medis
            // pelayanan non kapitasi
            // status pulang

        } else {
            // edit kunjungan
            $noKunjungan = collect($this->FormEntry['dataKunjungan'])
                ->where('field', '=', 'noKunjungan')
                ->first()['message'] ?? null;

            $this->FormEntry['addKunjungan']['noKunjugan'] = $noKunjungan;
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

    // /////////////////////
    // LOV selected start
    public function setMyspesialisLov($id, $desc)
    {
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1Desc'] = $desc;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialisDesc'] = $desc;

        $this->spesialisLovStatus = false;
        $this->spesialisLovSearch = '';
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

    // /////////////////////
    // LOV selected start
    public function setMysaranaLov($id, $desc)
    {
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] = $id;
        $this->FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSaranaDesc'] = $desc;

        $this->saranaLovStatus = false;
        $this->saranaLovSearch = '';
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
            if ($addKunjungan['metadata']['code'] === 201) {
                $this->FormEntry['dataKunjungan'] = $addKunjungan['response'];

                $noKunjungan = collect($this->FormEntry['dataKunjungan'])
                    ->where('field', '=', 'noKunjungan')
                    ->first()['message'] ?? null;

                $this->FormEntry['addKunjungan']['noKunjugan'] = $noKunjungan;
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
            if ($editKunjungan['metadata']['code'] === 200) {
                $this->emit('toastr-success', $editKunjungan['metadata']['message']);
            } else {
                $this->emit('toastr-error', json_encode($editKunjungan, true));
            }
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            return;
        }
    }



    public function mount()
    {
        $this->findData($this->rjNoRef);
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
