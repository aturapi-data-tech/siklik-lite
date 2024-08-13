<?php

namespace App\Http\Livewire\EmrUGD\MrUGD\Anamnesa\Anamnesa;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use Spatie\ArrayToXml\ArrayToXml;
use App\Http\Traits\EmrUGD\EmrUGDTrait;
use App\Http\Traits\customErrorMessagesTrait;


class Screening extends Component
{
    use WithPagination, EmrUGDTrait, customErrorMessagesTrait;

    // listener from blade////////////////
    protected $listeners = [
        'syncronizeAssessmentPerawatUGDFindData' => 'mount'
    ];



    //////////////////////////////
    // Ref on top bar
    //////////////////////////////



    // dataDaftarUgd RJ
    public $rjNoRef;

    public array $dataDaftarUgd = [];

    public array $screening =
    [
        "keluhanUtama" => "",
        "pernafasan" => "",
        "pernafasanOptions" => [
            ["pernafasan" => "Nafas Normal"],
            ["pernafasan" => "Tampak Sesak"],
        ],

        "kesadaran" => "",
        "kesadaranOptions" => [
            ["kesadaran" => "Sadar Penuh"],
            ["kesadaran" => "Tampak Mengantuk"],
            ["kesadaran" => "Gelisah"],
            ["kesadaran" => "Bicara Tidak Jelas"],

        ],

        "nyeriDada" => "",
        "nyeriDadaOptions" => [
            ["nyeriDada" => "Tidak Ada"],
            ["nyeriDada" => "Ada"],
        ],

        "nyeriDadaTingkat" => "",
        "nyeriDadaTingkatOptions" => [
            ["nyeriDadaTingkat" => "Ringan"],
            ["nyeriDadaTingkat" => "Sedang"],
            ["nyeriDadaTingkat" => "Berat"],

        ],

        "prioritasPelayanan" => "",
        "prioritasPelayananOptions" => [
            ["prioritasPelayanan" => "Preventif"],
            ["prioritasPelayanan" => "Paliatif"],
            ["prioritasPelayanan" => "Kuaratif"],
            ["prioritasPelayanan" => "Rehabilitatif"],


        ],
        "tanggalPelayanan" => "",
        "petugasPelayanan" => "",

    ];
    //////////////////////////////////////////////////////////////////////
    protected $rules = [
        'dataDaftarUgd.screening.keluhanUtama' => 'required',
        'dataDaftarUgd.screening.pernafasan' => 'required',
        'dataDaftarUgd.screening.kesadaran' => 'required',
        'dataDaftarUgd.screening.nyeriDada' => 'required',

        'dataDaftarUgd.screening.prioritasPelayanan' => 'required',

        'dataDaftarUgd.screening.tanggalPelayanan' => 'required',
        'dataDaftarUgd.screening.petugasPelayanan' => 'required',

    ];





    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////

    public function updated($propertyName)
    {
        // dd($propertyName);
        $this->validateOnly($propertyName);
        $this->store();
    }



    // resert input private////////////////
    private function resetInputFields(): void
    {

        // resert validation
        $this->resetValidation();
        // resert input kecuali
        $this->reset(['']);
    }

    // resert resetScreening///////////////
    public function resetScreening(): void
    {
        $this->dataDaftarUgd['screening'] = $this->screening;
        $this->resetValidation();
        $this->updateDataUgd($this->dataDaftarUgd['rjNo']);
    }




    // ////////////////
    // RJ Logic
    // ////////////////


    // validate Data RJ//////////////////////////////////////////////////
    private function validateDataAnamnesaUgd(): void
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // require nik ketika pasien tidak dikenal



        $rules = [
            'dataDaftarUgd.screening.keluhanUtama' => 'required',
            'dataDaftarUgd.screening.pernafasan' => 'required',
            'dataDaftarUgd.screening.kesadaran' => 'required',
            'dataDaftarUgd.screening.nyeriDada' => 'required',

            'dataDaftarUgd.screening.prioritasPelayanan' => 'required',

            'dataDaftarUgd.screening.tanggalPelayanan' => 'required',
            'dataDaftarUgd.screening.petugasPelayanan' => 'required',
        ];



        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {

            // $this->emit('toastr-error', "Lakukan Pengecekan kembali Input Data.");
            $this->validate($rules, $messages);
        }
    }


    // insert and update record start////////////////
    public function store()
    {
        // Validate RJ
        $this->validateDataAnamnesaUgd();

        // Logic update mode start //////////
        $this->updateDataUgd($this->dataDaftarUgd['rjNo']);
    }

    private function updateDataUgd($rjNo): void
    {

        // update table trnsaksi
        DB::table('rstxn_ugdhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'datadaftarugd_json' => json_encode($this->dataDaftarUgd, true),
                'datadaftarUgd_xml' => ArrayToXml::convert($this->dataDaftarUgd),
            ]);

        $this->emit('toastr-success', "Screening berhasil disimpan.");
    }
    // insert and update record end////////////////


    private function findData($rjno): void
    {
        $this->dataDaftarUgd = $this->findDataUGD($rjno);
        // dd($this->dataDaftarUgd);
        // jika screening tidak ditemukan tambah variable screening pda array
        if (isset($this->dataDaftarUgd['screening']) == false) {
            $this->dataDaftarUgd['screening'] = $this->screening;
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
            'livewire.emr-u-g-d.mr-u-g-d.anamnesa.anamnesa.screening',
            [
                // 'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Anamnesa',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
            ]
        );
    }
    // select data end////////////////


}
