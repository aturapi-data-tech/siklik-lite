<?php

namespace App\Http\Livewire\DaftarRJ;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\BPJS\AntrianTrait;
use App\Http\Traits\BPJS\VclaimTrait;
use App\Http\Traits\EmrRJ\EmrRJTrait;


use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;
use Barryvdh\DomPDF\Facade\Pdf;


class DaftarRJ extends Component
{
    use WithPagination, EmrRJTrait;




    //  table data////////////////
    // variable data pasien dan rawat jalan
    //  table data////////////////
    public  $dataPasien = [
        "pasien" => [
            "pasientidakdikenal" => [],  //status pasien tdak dikenal 0 false 1 true
            "regNo" => '', //harus diisi
            "gelarDepan" => '',
            "regName" => '', //harus diisi / (Sesuai KTP)
            "gelarBelakang" => '',
            "namaPanggilan" => '',
            "tempatLahir" => '', //harus diisi
            "tglLahir" => '', //harus diisi / (dd/mm/yyyy)
            "thn" => '',
            "bln" => '',
            "hari" => '',
            "jenisKelamin" => [ //harus diisi (saveid)
                "jenisKelaminId" => 1,
                "jenisKelaminDesc" => "Laki-laki",

            ],
            "agama" => [ //harus diisi (save id+nama)
                "agamaId" => "1",
                "agamaDesc" => "Islam",

            ],
            "statusPerkawinan" => [ //harus diisi (save id)
                "statusPerkawinanId" => "1",
                "statusPerkawinanDesc" => "Belum Kawin",

            ],
            "pendidikan" =>  [ //harus diisi (save id)
                "pendidikanId" => "3",
                "pendidikanDesc" => "SLTA Sederajat",

            ],
            "pekerjaan" => [ //harus diisi (save id)
                "pekerjaanId" => "4",
                "pekerjaanDesc" => "Pegawai Swasta/ Wiraswasta",

            ],
            "golonganDarah" => [ //harus diisi (save id+nama) (default Tidak Tahu)
                "golonganDarahId" => "13",
                "golonganDarahDesc" => "Tidak Tahu",

            ],

            "kewarganegaraan" => 'INDONESIA', //Free text (defult INDONESIA)
            "suku" => 'Jawa', //Free text (defult Jawa)
            "bahasa" => 'Indonesia / Jawa', //Free text (defult Indonesia / Jawa)
            "status" => [
                "statusId" => "1",
                "statusDesc" => "Aktif / Hidup",

            ],
            "domisil" => [
                "samadgnidentitas" => [], //status samadgn domisil 0 false 1 true (auto entry = domisil)
                "alamat" => '', //harus diisi
                "rt" => '', //harus diisi
                "rw" => '', //harus diisi
                "kodepos" => '', //harus diisi
                "desaId" => '', //harus diisi (Kode data Kemendagri)
                "kecamatanId" => '', //harus diisi (Kode data Kemendagri)
                "kotaId" => "3504", //harus diisi (Kode data Kemendagri)
                "propinsiId" => "35", //harus diisi (Kode data Kemendagri)
                "desaName" => '', //harus diisi (Kode data Kemendagri)
                "kecamatanName" => '', //harus diisi (Kode data Kemendagri)
                "kotaName" => "TULUNGAGUNG", //harus diisi (Kode data Kemendagri)
                "propinsiName" => "JAWA TIMUR", //harus diisi (Kode data Kemendagri)

            ],
            "identitas" => [
                "nik" => '', //harus diisi
                "idbpjs" => '',
                "pasport" => '', //untuk WNA / WNI yang memiliki passport
                "alamat" => '', //harus diisi
                "rt" => '', //harus diisi
                "rw" => '', //harus diisi
                "kodepos" => '', //harus diisi
                "desaId" => '', //harus diisi (Kode data Kemendagri)
                "kecamatanId" => '', //harus diisi (Kode data Kemendagri)
                "kotaId" => "3504", //harus diisi (Kode data Kemendagri)
                "propinsiId" => "35", //harus diisi (Kode data Kemendagri)
                "desaName" => '', //harus diisi (Kode data Kemendagri)
                "kecamatanName" => '', //harus diisi (Kode data Kemendagri)
                "kotaName" => "TULUNGAGUNG", //harus diisi (Kode data Kemendagri)
                "propinsiName" => "JAWA TIMUR", //harus diisi (Kode data Kemendagri)
                "negara" => "ID" //harus diisi (ISO 3166) ID 	IDN 	360 	ISO 3166-2:ID 	.id
            ],
            "kontak" => [
                "kodenegara" => "62", //+(62) Indonesia
                "nomerTelponSelulerPasien" => '', //+(kode negara) no telp
                "nomerTelponLain" => '' //+(kode negara) no telp
            ],
            "hubungan" => [
                "namaAyah" => '', //
                "kodenegaraAyah" => "62", //+(62) Indonesia
                "nomerTelponSelulerAyah" => '', //+(kode negara) no telp
                "namaIbu" => '', //
                "kodenegaraIbu" => "62", //+(62) Indonesia
                "nomerTelponSelulerIbu" => '', //+(kode negara) no telp

                "namaPenanggungJawab" => '', // di isi untuk pasien (Tidak dikenal / Hal Lain)
                "kodenegaraPenanggungJawab" => "62", //+(62) Indonesia
                "nomerTelponSelulerPenanggungJawab" => '', //+(kode negara) no telp
                "hubunganDgnPasien" => [
                    "hubunganDgnPasienId" => 5, //Default 5 Kerabat / Saudara
                    "hubunganDgnPasienDesc" => "Kerabat / Saudara",

                ]
            ],

        ],

    ];


    public $ruleDataPasien =
    [
        'pasien' => [
            'regNo' => false,
            'gelarDepan' => false,
            'regName' => false,
            'gelarBelakang' => false,
            'namaPanggilan' => false,
            'tempatLahir' => false,
            'tglLahir' => false,
            'thn' => false,
            'bln' => false,
            'hari' => false,

            'jenisKelamin' => [
                'jenisKelaminId' => false,
                'jenisKelaminDesc' => false,
            ],
            'agama' => [
                'agamaId' => false,
                'agamaDesc' => false,
            ],

            'statusPerkawinan' => [
                'statusPerkawinanId' => false,
                'statusPerkawinanDesc' => false,
            ],

            'pendidikan' => [
                'pendidikanId' => false,
                'pendidikanDesc' => false,
            ],

            'pekerjaan' => [
                'pekerjaanId' => false,
                'pekerjaanDesc' => false,
            ],

            'golonganDarah' => [
                'golonganDarahId' => false,
                'golonganDarahDesc' => false,
            ],

            'kewarganegaraan' => false,
            'suku' => false,
            'bahasa' => false,
            'status' => [
                'statusId' => false,
                'statusDesc' => false,
            ],

            'domisil' => [
                'alamat' => false,
                'rt' => false,
                'rw' => false,
                'kodepos' => false,
                'desaId' => false,
                'kecamatanId' => false,
                'kotaId' => false,
                'propinsiId' => false,
                'desaName' => false,
                'kecamatanName' => false,
                'kotaName' => false,
                'propinsiName' => false,
            ],

            'identitas' => [
                'nik' => false,
                'idbpjs' => false,
                'pasport' => false,
                'alamat' => false,
                'rt' => false,
                'rw' => false,
                'kodepos' => false,
                'desaId' => false,
                'kecamatanId' => false,
                'kotaId' => false,
                'propinsiId' => false,
                'desaName' => false,
                'kecamatanName' => false,
                'kotaName' => false,
                'propinsiName' => false,
                'negara' => false,
            ],

            'kontak' => [
                'kodenegara' => false,
                'nomerTelponSelulerPasien' => false,
                'nomerTelponLain' => false,
            ],

            'hubungan' => [
                'namaAyah' => false,
                'kodenegaraAyah' => false,
                'nomerTelponSelulerAyah' => false,

                'namaIbu' => false,
                'kodenegaraIbu' => false,
                'nomerTelponSelulerIbu' => false,

                'namaPenanggungJawab' => false,
                'kodenegaraPenanggungJawab' => false,
                'nomerTelponSelulerPenanggungJawab' => false,
                'hubunganDgnPasien' => [
                    'hubunganDgnPasienId' => false,
                    'hubunganDgnPasienDesc' => false,
                ]
            ]
        ]
    ];

    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $dateRjRef = '';

    public $shiftRjRef = [
        'shiftId' => '1',
        'shiftDesc' => '1',
        'shiftOptions' => [
            ['shiftId' => '1', 'shiftDesc' => '1'],
            ['shiftId' => '2', 'shiftDesc' => '2'],
            ['shiftId' => '3', 'shiftDesc' => '3'],
        ]
    ];

    public $statusRjRef = [
        'statusId' => 'A',
        'statusDesc' => 'Antrian',
        'statusOptions' => [
            ['statusId' => 'A', 'statusDesc' => 'Antrian'],
            ['statusId' => 'L', 'statusDesc' => 'Selesai'],
            ['statusId' => 'I', 'statusDesc' => 'Transfer'],
        ]
    ];

    public $drRjRef = [
        'drId' => 'All',
        'drName' => 'All',
        'drOptions' => [
            [
                'drId' => 'All',
                'drName' => 'All'
            ]
        ]
    ];

    // Pendaftaran RJ
    public $JenisKlaim = [
        'JenisKlaimId' => 'UM',
        'JenisKlaimDesc' => 'UMUM',
        'JenisKlaimOptions' => [
            ['JenisKlaimId' => 'UM', 'JenisKlaimDesc' => 'UMUM'],
            ['JenisKlaimId' => 'JM', 'JenisKlaimDesc' => 'BPJS'],
            ['JenisKlaimId' => 'JML', 'JenisKlaimDesc' => 'Asuransi Lain'],
            ['JenisKlaimId' => 'KR', 'JenisKlaimDesc' => 'Kronis'],

        ]
    ];

    public $JenisKunjungan = [
        'JenisKunjunganId' => '1',
        'JenisKunjunganDesc' => 'Rujukan FKTP',
        'JenisKunjunganOptions' => [
            ['JenisKunjunganId' => '1', 'JenisKunjunganDesc' => 'Rujukan FKTP'],
            ['JenisKunjunganId' => '2', 'JenisKunjunganDesc' => 'Rujukan Internal'],
            ['JenisKunjunganId' => '3', 'JenisKunjunganDesc' => 'Kontrol'],
            ['JenisKunjunganId' => '4', 'JenisKunjunganDesc' => 'Rujukan Antar RS'],

        ]
    ];

    public $dataDaftarPoliRJ = [
        "regNo" => '',

        "drId" => '',
        "drDesc" => '',

        "poliId" => '',
        "poliDesc" => '',

        "kddrbpjs" => '',
        "kdpolibpjs" => '',

        "rjDate" => '',
        "rjNo" => '',
        "shift" => '',
        "noAntrian" => '',
        "noBooking" => '',
        "slCodeFrom" => "02",
        "passStatus" => "",
        "rjStatus" => "A",
        "txnStatus" => "A",
        "ermStatus" => "A",
        "cekLab" => "0",
        "kunjunganInternalStatus" => "0",
        "noReferensi" => '',
        "postInap" => [],
        "internal12" => "1",
        "internal12Desc" => "Faskes Tingkat 1",
        "internal12Options" => [
            [
                "internal12" => "1",
                "internal12Desc" => "Faskes Tingkat 1"
            ],
            [
                "internal12" => "2",
                "internal12Desc" => "Faskes Tingkat 2 RS"
            ],
        ],
        "kontrol12" => "1",
        "kontrol12Desc" => "Faskes Tingkat 1",
        "kontrol12Options" => [
            [
                "kontrol12" => "1",
                "kontrol12Desc" => "Faskes Tingkat 1"
            ],
            [
                "kontrol12" => "2",
                "kontrol12Desc" => "Faskes Tingkat 2 RS"
            ],
        ],
        "taskIdPelayanan" => [
            "taskId1" => "",
            "taskId2" => "",
            "taskId3" => "",
            "taskId4" => "",
            "taskId5" => "",
            "taskId6" => "",
            "taskId7" => "",
            "taskId99" => "",
        ],
        'sep' => [
            "noSep" => "",
            "reqSep" => [],
            "resSep" => [],
        ]
    ];

    // http status Push antrian BPJS
    public $HttpGetBpjsStatus; //status push antrian 200 /201/ 400
    public $HttpGetBpjsJson; // response json

    public $SEPJsonReq = [
        "request" =>  [
            "t_sep" =>  [
                "noKartu" => "",
                "tglSep" => "", //Y-m-d
                "ppkPelayanan" => "",
                "jnsPelayanan" => "",
                "klsRawat" =>  [
                    "klsRawatHak" => "",
                    "klsRawatNaik" => "",
                    "pembiayaan" => "",
                    "penanggungJawab" => "",
                ],
                "noMR" => "",
                "rujukan" =>  [
                    "asalRujukan" => "",
                    "tglRujukan" => "", //Y-m-d
                    "noRujukan" => "",
                    "ppkRujukan" => "",
                ],
                "catatan" => "",
                "diagAwal" => "",
                "poli" =>  [
                    "tujuan" => "",
                    "tujuanNama" => "",
                    "eksekutif" => "0",
                    "eksekutifRef" => [],
                ],
                "cob" =>  [
                    "cob" => "0",
                    "cobRef" => [],
                ],
                "katarak" =>  [
                    "katarak" => "0",
                    "katarakRef" => [],
                ],
                "jaminan" =>  [
                    "lakaLantas" => "0",
                    "lakaLantasRef" => [],
                    "noLP" => "",
                    "penjamin" =>  [
                        "tglKejadian" => "",
                        "keterangan" => "",
                        "suplesi" =>  [
                            "suplesi" => "0",
                            "noSepSuplesi" => "",
                            "lokasiLaka" =>  [
                                "kdPropinsi" => "",
                                "kdKabupaten" => "",
                                "kdKecamatan" => "",
                            ]
                        ]
                    ]
                ],
                "tujuanKunj" => "0",
                "tujuanKunjDesc" => "Normal",

                "flagProcedure" => "",
                "flagProcedureDesc" => "",

                "kdPenunjang" => "",
                "kdPenunjangDesc" => "",

                "assesmentPel" => "",
                "assesmentPelDesc" => "",


                "skdp" =>  [
                    "noSurat" => "",
                    "kodeDPJP" => "",
                ],
                "dpjpLayan" => "",
                "noTelp" => "",
                "user" => "sirus App",
            ],
        ],
    ];
    //////////////////////////////
    public $SEPQuestionnaire = [
        'tujuanKunj' => [
            ['tujuanKunjId' => '', 'tujuanKunjDesc' => ''],
            ['tujuanKunjId' => '0', 'tujuanKunjDesc' => 'Normal'],
            ['tujuanKunjId' => '1', 'tujuanKunjDesc' => 'Prosedur'],
            ['tujuanKunjId' => '2', 'tujuanKunjDesc' => 'Konsul Dokter'],
        ],
        'flagProcedure' => [
            ['flagProcedureId' => '', 'flagProcedureDesc' => ''],
            ['flagProcedureId' => '0', 'flagProcedureDesc' => 'Prosedur Tidak Berkelanjutan'],
            ['flagProcedureId' => '1', 'flagProcedureDesc' => 'Prosedur dan Terapi Berkelanjutan'],
        ],
        'kdPenunjang' => [
            ['kdPenunjangId' => '', 'kdPenunjangDesc' => ''],
            ['kdPenunjangId' => '1', 'kdPenunjangDesc' => 'Radioterapi'],
            ['kdPenunjangId' => '2', 'kdPenunjangDesc' => 'Kemoterapi'],
            ['kdPenunjangId' => '3', 'kdPenunjangDesc' => 'Rehabilitasi Medik'],
            ['kdPenunjangId' => '4', 'kdPenunjangDesc' => 'Rehabilitasi Psikososial'],
            ['kdPenunjangId' => '5', 'kdPenunjangDesc' => 'Transfusi Darah'],
            ['kdPenunjangId' => '6', 'kdPenunjangDesc' => 'Pelayanan Gigi'],
            ['kdPenunjangId' => '7', 'kdPenunjangDesc' => 'Laboratorium'],
            ['kdPenunjangId' => '8', 'kdPenunjangDesc' => 'USG'],
            ['kdPenunjangId' => '9', 'kdPenunjangDesc' => 'Farmasi'],
            ['kdPenunjangId' => '10', 'kdPenunjangDesc' => 'Lain-Lain'],
            ['kdPenunjangId' => '11', 'kdPenunjangDesc' => 'MRI'],
            ['kdPenunjangId' => '12', 'kdPenunjangDesc' => 'HEMODIALISA'],


        ],
        'assesmentPel' => [
            ['assesmentPelId' => '', 'assesmentPelDesc' => ''],
            ['assesmentPelId' => '1', 'assesmentPelDesc' => 'Poli spesialis tidak tersedia pada hari sebelumnya'],
            ['assesmentPelId' => '2', 'assesmentPelDesc' => 'Jam Poli telah berakhir pada hari sebelumnya'],
            ['assesmentPelId' => '3', 'assesmentPelDesc' => 'Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya'],
            ['assesmentPelId' => '4', 'assesmentPelDesc' => 'Atas Instruksi RS'],
            ['assesmentPelId' => '5', 'assesmentPelDesc' => 'Tujuan Kontrol'],
        ],
    ];


    //////////////////////////////////////////////////////////////////////





    // limit record per page -resetExcept////////////////
    public $limitPerPage = 10;


    //  table LOV////////////////
    public $dataPasienLov = [];
    public $dataPasienLovStatus = 0;
    public $dataPasienLovSearch = '';

    public $dataDokterLov = [];
    public $dataDokterLovStatus = 0;
    public $dataDokterLovSearch = '';

    public $dataDokterBPJSLov = [];
    public $dataDokterBPJSLovStatus = 0;
    public $dataDokterBPJSLovSearch = '';

    public $dataRefBPJSLov = [];
    public $dataRefBPJSLovStatus = 0;
    public $dataRefBPJSLovSearch = '';


    public $formRujukanRefBPJS = [];
    public $formRujukanRefBPJSStatus = 0;
    public $formRujukanRefBPJSSearch = '';

    public $dataDiagnosaBPJSLov = [];
    public $dataDiagnosaBPJSLovStatus = 0;
    public $dataDiagnosaBPJSLovSearch = '';





    //

    //  modal status////////////////
    public $isOpen = 0;
    public $isOpenMode = 'insert';
    public $forceInsertRecord = 0;

    // call Form
    public $callMasterPasien = 0;
    public $callRJskdp = 0;


    // search logic -resetExcept////////////////
    public $search;
    protected $queryString = [
        'search' => ['except' => '', 'as' => 'cariData'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];


    // sort logic -resetExcept////////////////
    public $sortField = 'reg_no';
    public $sortAsc = true;


    // listener from blade////////////////
    protected $listeners = [
        'confirm_remove_record_RJp' => 'delete',
        'rePush_Data_Antrian' => 'store',
        'confirm_doble_record_RJp' => 'setforceInsertRecord'
        // 'rePush_Data_TaskId' => '', //blm di pakai ->model fitur blm diemukan (repush data to URL)
    ];



    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////





    // resert input private////////////////
    private function resetInputFields(): void
    {

        // resert validation
        $this->resetValidation();
        // resert input kecuali
        $this->resetExcept([
            'limitPerPage',
            'search',
            'dateRjRef',
            'shiftRjRef',
            'statusRjRef',
            'drRjRef'


        ]);
    }




    // open and close modal start////////////////
    private function openModal(): void
    {
        $this->resetInputFields();
        $this->isOpen = true;
        $this->isOpenMode = 'insert';
        $this->setShiftnCurrentDate();
    }
    private function openModalEdit(): void
    {
        $this->resetInputFields();
        $this->isOpen = true;
        $this->isOpenMode = 'update';
    }

    private function openModalTampil(): void
    {
        $this->resetInputFields();
        $this->isOpen = true;
        $this->isOpenMode = 'tampil';
    }

    public function closeModal(): void
    {
        $this->resetInputFields();
    }
    // open and close modal end////////////////




    // setLimitPerpage////////////////
    public function setLimitPerPage($value): void
    {
        $this->limitPerPage = $value;
        $this->resetValidation();
    }



    private function optionsdrRjRef(): void
    {

        // Query
        $query = DB::table('rsview_rjkasir')
            ->select(
                'dr_id',
                'dr_name',
            )
            ->where('shift', '=', $this->shiftRjRef['shiftId'])
            ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $this->dateRjRef)
            ->groupBy('dr_id')
            ->groupBy('dr_name')
            ->orderBy('dr_name', 'desc')
            ->get();

        // loop and set Ref
        $query->each(function ($item, $key) {
            $this->drRjRef['drOptions'][$key + 1]['drId'] = $item->dr_id;
            $this->drRjRef['drOptions'][$key + 1]['drName'] = $item->dr_name;
        })->toArray();
    }



    // setShiftRJ//////////////// Form
    public function setShiftRJ($id, $desc): void
    {
        $this->dataDaftarPoliRJ['shift'] = $id;
        $this->resetValidation();
    }








    /////////////////////////////////////////////////////////////////////
    // resert page pagination when coloumn search change ////////////////
    // tabular Ref topbar
    /////////////////////////////////////////////////////////////////////

    // search
    public function updatedSearch(): void
    {
        // $this->emit('toastr-error', "search.");

        $this->resetPage();
        $this->resetValidation();
        $this->resetInputFields();
    }
    // date
    public function updatedDaterjref(): void
    {
        // $this->emit('toastr-error', "date.");

        $this->resetPage();
        $this->resetValidation();
        $this->resetInputFields();
    }
    // status
    public function updatedStatusrjref(): void
    {
        // $this->emit('toastr-error', "status.");

        $this->resetPage();
        $this->resetValidation();
        $this->resetInputFields();
    }
    // dr
    public function setdrRjRef($id, $name): void
    {
        // $this->emit('toastr-error', "dr.");

        $this->drRjRef['drId'] = $id;
        $this->drRjRef['drName'] = $name;
        $this->resetPage();
        $this->resetValidation();
        $this->resetInputFields();
    }
    // shift
    public function setShift($id, $desc): void
    {
        // $this->emit('toastr-error', "shift.");

        $this->shiftRjRef['shiftId'] = $id;
        $this->shiftRjRef['shiftDesc'] = $desc;
        $this->resetPage();
        $this->resetValidation();
        $this->resetInputFields();
    }
    /////////////////////////////////////////////////////////////////////





    // is going to insert data////////////////
    public function create()
    {
        $this->openModal();
    }

    // is going to delete data////////////////
    public function delete()
    {
        $this->emit('toastr-error', "delete Data tidak dapat di proses.");
    }

    // is going to tampil data////////////////
    public function tampil()
    {
        $this->emit('toastr-error', "tampil Data tidak dapat di proses.");
    }

    // is going to edit data/////////////////
    public function edit($id)
    {
        $this->openModalEdit();
        $this->findData($id);
    }

    // logic LOV start////////////////










    // ////////////////
    // RJ Logic
    // ////////////////

    //////////////////////////////////////////////
    // updated when change Record ////////////////
    ///////////////////////////////////////////////
    // klaimId
    public function updatedJenisklaimJenisklaimid()
    {
        $this->dataDaftarPoliRJ['klaimId'] = $this->JenisKlaim['JenisKlaimId'];
    }

    // kunjunganId
    public function updatedJeniskunjunganJeniskunjunganid()
    {
        $this->dataDaftarPoliRJ['kunjunganId'] = $this->JenisKunjungan['JenisKunjunganId'];
    }
    //////////////////////////////////////////////
    // updated when change Record ////////////////
    ///////////////////////////////////////////////




    // validate Data RJ//////////////////////////////////////////////////
    private function validateDataRJ(): void
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // require nik ketika pasien tidak dikenal



        $rules = [

            "dataDaftarPoliRJ.regNo" => "bail|required|exists:rsmst_pasiens,reg_no",

            "dataDaftarPoliRJ.drId" => "required",
            "dataDaftarPoliRJ.drDesc" => "required",

            "dataDaftarPoliRJ.poliId" => "required",
            "dataDaftarPoliRJ.poliDesc" => "required",

            "dataDaftarPoliRJ.kddrbpjs" => '',
            "dataDaftarPoliRJ.kdpolibpjs" => '',


            "dataDaftarPoliRJ.rjDate" => "required",
            "dataDaftarPoliRJ.rjNo" => "required",

            "dataDaftarPoliRJ.shift" => "required",

            "dataDaftarPoliRJ.noAntrian" => "required",
            "dataDaftarPoliRJ.noBooking" => "required",

            "dataDaftarPoliRJ.slCodeFrom" => "required",
            "dataDaftarPoliRJ.passStatus" => "",

            "dataDaftarPoliRJ.rjStatus" => "required",
            "dataDaftarPoliRJ.txnStatus" => "required",
            "dataDaftarPoliRJ.ermStatus" => "required",

            "dataDaftarPoliRJ.cekLab" => "required",

            "dataDaftarPoliRJ.kunjunganInternalStatus" => "required",

            "dataDaftarPoliRJ.noReferensi" => "",

        ];

        // gabunga array noReferensi jika BPJS harus di isi
        if ($this->JenisKlaim['JenisKlaimId'] == 'JM') {
            $rules['dataDaftarPoliRJ.noReferensi'] =  'bail|required|min:3|max:19';
        } else {
            $rules['dataDaftarPoliRJ.noReferensi'] =  'bail|min:3|max:19';
        }

        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $this->emit('toastr-error', "Lakukan Pengecekan kembali Input Data Pasien.");
            $this->validate($rules, $messages);
        }
    }


    public function setforceInsertRecord()
    {
        $this->forceInsertRecord = '1';

        if ($this->forceInsertRecord) {
            $this->insertDataRJ();
            $this->isOpenMode = 'update';
        }
    }

    // insert and update record start////////////////
    public function store()
    {

        // dd($this->SEPJsonReq);
        // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
        $this->setDataPrimer();
        // Validate RJ
        $this->validateDataRJ();
        // Logic push data ke BPJS
        // Push data antrian dan Task ID 3
        $this->pushDataAntrian();


        // Logic insert and update mode start //////////
        if ($this->isOpenMode == 'insert') {

            // cari data berdasarkan regno pada tgl tsb dgn status selain 'F'
            // fungsi dasar untuk memperbaiki data EMR
            $cekDoblePendaftaran = DB::table('rsview_rjkasir')
                ->where('rj_status', '!=', 'F')
                ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $this->dateRjRef)
                ->where("reg_no", '=', $this->dataDaftarPoliRJ['regNo'])
                ->count();


            //cek Doble Pendaftaran
            if ($cekDoblePendaftaran > 0) {
                $this->emit('confirm_doble_record', $this->dataDaftarPoliRJ['regNo'], $this->dataDaftarPoliRJ['regNo']);
            } else {
                $this->forceInsertRecord = '1';
            }


            // forceInsert record by default is flase true when cekDoblePendaftaran=0 or confirmation from user
            if ($this->forceInsertRecord) {
                $this->insertDataRJ();
                $this->isOpenMode = 'update';
            }
        } else if ($this->isOpenMode == 'update') {
            $this->updateDataRJ($this->dataDaftarPoliRJ['rjNo']);
        }




        // Opstional (Jika ingin fast Entry resert setelah proses diatas)
        // Jika ingin auto close resert dan close aktifkan
        // $this->resetInputFields();
        // $this->closeModal();

    }

    private function insertDataRJ(): void
    {

        // insert into table transaksi
        DB::table('rstxn_rjhdrs')->insert([
            'rj_no' => $this->dataDaftarPoliRJ['rjNo'],
            'rj_date' => DB::raw("to_date('" . $this->dataDaftarPoliRJ['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"),
            'reg_no' => $this->dataDaftarPoliRJ['regNo'],
            'nobooking' => $this->dataDaftarPoliRJ['noBooking'],
            'no_antrian' => $this->dataDaftarPoliRJ['noAntrian'],

            'klaim_id' => $this->dataDaftarPoliRJ['klaimId'],
            'poli_id' => $this->dataDaftarPoliRJ['poliId'],
            'dr_id' => $this->dataDaftarPoliRJ['drId'],
            'shift' => $this->dataDaftarPoliRJ['shift'],

            'txn_status' => $this->dataDaftarPoliRJ['txnStatus'],
            'rj_status' => $this->dataDaftarPoliRJ['rjStatus'],
            'erm_status' => $this->dataDaftarPoliRJ['ermStatus'],

            'pass_status' => $this->dataDaftarPoliRJ['passStatus'] == 'N' ? 'N' : 'O', //Baru lama

            'cek_lab' => $this->dataDaftarPoliRJ['cekLab'],
            'sl_codefrom' => $this->dataDaftarPoliRJ['slCodeFrom'],
            'kunjungan_internal_status' => $this->dataDaftarPoliRJ['kunjunganInternalStatus'],
            'push_antrian_bpjs_status' => $this->HttpGetBpjsStatus, //status push antrian 200 /201/ 400
            'push_antrian_bpjs_json' => $this->HttpGetBpjsJson,  // response json
            'datadaftarpolirj_json' => json_encode($this->dataDaftarPoliRJ, true),
            'datadaftarpolirj_xml' => ArrayToXml::convert($this->dataDaftarPoliRJ),

            'waktu_masuk_pelayanan' => DB::raw("to_date('" . $this->dataDaftarPoliRJ['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"), //waktu masuk = rjdate

            'vno_sep' => isset($this->dataDaftarPoliRJ['sep']['noSep']) ? $this->dataDaftarPoliRJ['sep']['noSep'] : "",

        ]);

        $this->emit('toastr-success', "Data sudah tersimpan.");
    }

    private function updateDataRJ($rjNo): void
    {

        // update table trnsaksi
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                // 'rj_no' => $this->dataDaftarPoliRJ['rjNo'],
                'rj_date' => DB::raw("to_date('" . $this->dataDaftarPoliRJ['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"),
                'reg_no' => $this->dataDaftarPoliRJ['regNo'],
                'nobooking' => $this->dataDaftarPoliRJ['noBooking'],
                'no_antrian' => $this->dataDaftarPoliRJ['noAntrian'],

                'klaim_id' => $this->dataDaftarPoliRJ['klaimId'],
                'poli_id' => $this->dataDaftarPoliRJ['poliId'],
                'dr_id' => $this->dataDaftarPoliRJ['drId'],
                'shift' => $this->dataDaftarPoliRJ['shift'],

                'txn_status' => $this->dataDaftarPoliRJ['txnStatus'],
                'rj_status' => $this->dataDaftarPoliRJ['rjStatus'],
                'erm_status' => $this->dataDaftarPoliRJ['ermStatus'],

                'pass_status' => $this->dataDaftarPoliRJ['passStatus'] == 'N' ? 'N' : 'O', //Baru lama

                'cek_lab' => $this->dataDaftarPoliRJ['cekLab'],
                'sl_codefrom' => $this->dataDaftarPoliRJ['slCodeFrom'],
                'kunjungan_internal_status' => $this->dataDaftarPoliRJ['kunjunganInternalStatus'],
                'push_antrian_bpjs_status' => $this->HttpGetBpjsStatus, //status push antrian 200 /201/ 400
                'push_antrian_bpjs_json' => $this->HttpGetBpjsJson,  // response json
                'datadaftarpolirj_json' => json_encode($this->dataDaftarPoliRJ, true),
                'datadaftarpolirj_xml' => ArrayToXml::convert($this->dataDaftarPoliRJ),

                'waktu_masuk_pelayanan' => DB::raw("to_date('" . $this->dataDaftarPoliRJ['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"), //waktu masuk = rjdate

                'vno_sep' => isset($this->dataDaftarPoliRJ['sep']['noSep']) ? $this->dataDaftarPoliRJ['sep']['noSep'] : "",
            ]);

        $this->emit('toastr-success', "Data berhasil diupdate.");
    }
    // insert and update record end////////////////



    // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
    private function setDataPrimer(): void
    {
        // Klaim & Kunjungan
        // dd($this->dataDaftarPoliRJ['klaimId']);
        $this->dataDaftarPoliRJ['klaimId'] = $this->JenisKlaim['JenisKlaimId'];
        $this->dataDaftarPoliRJ['kunjunganId'] = $this->JenisKunjungan['JenisKunjunganId'];

        // JenisKunjungan Internal
        if ($this->JenisKunjungan['JenisKunjunganId'] == 2) {
            $this->dataDaftarPoliRJ['kunjunganInternalStatus'] = "1";
        }

        // noBooking
        if (!$this->dataDaftarPoliRJ['noBooking']) {
            $this->dataDaftarPoliRJ['noBooking'] = Carbon::now()->format('YmdHis') . 'RSIM';
        }

        // rjNoMax
        if (!$this->dataDaftarPoliRJ['rjNo']) {
            $sql = "select nvl(max(rj_no)+1,1) rjno_max from rstxn_rjhdrs";
            $this->dataDaftarPoliRJ['rjNo'] = DB::scalar($sql);
        }

        // noUrutAntrian (count all kecuali KRonis) if KR 999
        $sql = "select count(*) no_antrian
         from rstxn_rjhdrs
         where dr_id=:drId
         and to_char(rj_date,'ddmmyyyy')=:tgl
         and klaim_id!='KR'";

        // Antrian ketika data antrian kosong
        if (!$this->dataDaftarPoliRJ['noAntrian']) {
            // proses antrian
            if ($this->dataDaftarPoliRJ['klaimId'] != 'KR') {
                $noUrutAntrian = DB::scalar($sql, [
                    "tgl" => Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'])->format('dmY'),
                    "drId" => $this->dataDaftarPoliRJ['drId']
                ]);

                $noAntrian = $noUrutAntrian + 1;
            } else {
                // Kronis
                $noAntrian = 999;
            }

            $this->dataDaftarPoliRJ['noAntrian'] = $noAntrian;
        }
    }

    private function setDataPasien($value): void
    {
        $findData = DB::table('rsmst_pasiens')
            ->select('meta_data_pasien_json')
            ->where('reg_no', $value)
            ->first();

        if ($findData->meta_data_pasien_json == null) {

            $findData = $this->cariDataPasienByKeyCollection('reg_no', $value);

            $this->dataPasien['pasien']['regDate'] = $findData->reg_date;
            $this->dataPasien['pasien']['regNo'] = $findData->reg_no;
            $this->dataPasien['pasien']['regName'] = $findData->reg_name;
            $this->dataPasien['pasien']['identitas']['idbpjs'] = $findData->nokartu_bpjs;
            $this->dataPasien['pasien']['identitas']['nik'] = $findData->nik_bpjs;
            $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] = ($findData->sex == 'L') ? 1 : 2;
            $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] = ($findData->sex == 'L') ? 'Laki-laki' : 'Perempuan';
            $this->dataPasien['pasien']['tglLahir'] = $findData->birth_date;
            $this->dataPasien['pasien']['thn'] = $findData->thn;
            $this->dataPasien['pasien']['bln'] = $findData->bln;
            $this->dataPasien['pasien']['hari'] = $findData->hari;
            $this->dataPasien['pasien']['tempatLahir'] = $findData->birth_place;
            $this->dataPasien['pasien']['golonganDarah']['golonganDarahId'] = '13';
            $this->dataPasien['pasien']['golonganDarah']['golonganDarahDesc'] = 'Tidak Tahu';
            $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanId'] = '1';
            $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanDesc'] = 'Belum Kawin';

            $this->dataPasien['pasien']['agama']['agamaId'] = $findData->rel_id;
            $this->dataPasien['pasien']['agama']['agamaDesc'] = $findData->rel_desc;

            $this->dataPasien['pasien']['pendidikan']['pendidikanId'] = $findData->edu_id;
            $this->dataPasien['pasien']['pendidikan']['pendidikanDesc'] = $findData->edu_desc;

            $this->dataPasien['pasien']['pekerjaan']['pekerjaanId'] = $findData->job_id;
            $this->dataPasien['pasien']['pekerjaan']['pekerjaanDesc'] = $findData->job_name;


            $this->dataPasien['pasien']['hubungan']['namaPenanggungJawab'] = $findData->reg_no;
            $this->dataPasien['pasien']['hubungan']['namaIbu'] = $findData->reg_no;

            $this->dataPasien['pasien']['identitas']['nik'] = $findData->nik_bpjs;
            $this->dataPasien['pasien']['identitas']['idBpjs'] = $findData->nokartu_bpjs;


            $this->dataPasien['pasien']['identitas']['alamat'] = $findData->address;

            $this->dataPasien['pasien']['identitas']['desaId'] = $findData->des_id;
            $this->dataPasien['pasien']['identitas']['desaName'] = $findData->des_name;

            $this->dataPasien['pasien']['identitas']['rt'] = $findData->rt;
            $this->dataPasien['pasien']['identitas']['rw'] = $findData->rw;
            $this->dataPasien['pasien']['identitas']['kecamatanId'] = $findData->kec_id;
            $this->dataPasien['pasien']['identitas']['kecamatanName'] = $findData->kec_name;

            $this->dataPasien['pasien']['identitas']['kotaId'] = $findData->kab_id;
            $this->dataPasien['pasien']['identitas']['kotaName'] = $findData->kab_name;

            $this->dataPasien['pasien']['identitas']['propinsiId'] = $findData->prop_id;
            $this->dataPasien['pasien']['identitas']['propinsiName'] = $findData->prop_name;

            $this->dataPasien['pasien']['kontak']['nomerTelponSelulerPasien'] = $findData->phone;

            $this->dataPasien['pasien']['hubungan']['namaPenanggungJawab'] = $findData->kk;
            $this->dataPasien['pasien']['hubungan']['namaIbu'] = $findData->nyonya;


            // $this->dataPasien['pasien']['hubungan']['noPenanggungJawab'] = $findData->no_kk;


            // dd($this->dataPasien);
        } else {
            // ubah data Pasien
            $this->dataPasien = json_decode($findData->meta_data_pasien_json, true);
        }
    }

    private function setShiftnCurrentDate(): void
    {
        // dd/mm/yyyy hh24:mi:ss
        $this->dataDaftarPoliRJ['rjDate'] = Carbon::now()->format('d/m/Y H:i:s');

        // shift
        $findShift = DB::table('rstxn_shiftctls')->select('shift')
            ->whereRaw("'" . Carbon::now()->format('H:i:s') . "' between
            shift_start and shift_end")
            ->first();
        $this->dataDaftarPoliRJ['shift'] = isset($findShift->shift) && $findShift->shift ? $findShift->shift : 3;
    }


    public function clickrujukanPeserta(): void
    {
        // Cek jika bukan BPJS
        if ($this->JenisKlaim['JenisKlaimId'] != 'JM') {
            $this->emit('toastr-error', 'Jenis Klaim ' . $this->JenisKlaim['JenisKlaimDesc']);
        } else {
            // Cek Apakah reqSep ada datanya apa blm
            // if (isset($this->dataDaftarPoliRJ['sep']['reqSep']['request']) && isset($this->dataDaftarPoliRJ['sep']['noSep'])) {
            if ($this->dataDaftarPoliRJ['sep']['noSep']) {

                $this->SEPJsonReq = $this->dataDaftarPoliRJ['sep']['reqSep'];
                // set formRujukanRefBPJSStatus true (open form)
                $this->formRujukanRefBPJSStatus = true;
            } else {
                // if jenis klaim BPJS dan Kunjungan = FKTP (1)
                if ($this->JenisKlaim['JenisKlaimId'] == 'JM' && $this->JenisKunjungan['JenisKunjunganId'] == 1) {
                    $this->rujukanPesertaFKTP($this->dataPasien['pasien']['identitas']['idbpjs']);
                    //
                    //
                    //
                } else if ($this->JenisKlaim['JenisKlaimId'] == 'JM' && $this->JenisKunjungan['JenisKunjunganId'] == 2) {
                    // if jenis klaim BPJS dan Kunjungan = Inernal (2) FKTP 1 atau FKTL 2
                    if ($this->dataDaftarPoliRJ['internal12'] == "1") {
                        $this->rujukanPesertaFKTP($this->dataPasien['pasien']['identitas']['idbpjs']);
                    } else {
                        $this->rujukanPesertaFKTL($this->dataPasien['pasien']['identitas']['idbpjs']);
                    }
                    //
                    //
                    //
                } else if ($this->JenisKlaim['JenisKlaimId'] == 'JM' && $this->JenisKunjungan['JenisKunjunganId'] == 3) {
                    // if jenis klaim BPJS dan Kunjungan = Kontrol (3) / Post Inap
                    if ($this->dataDaftarPoliRJ['postInap']) {
                        $tanggal = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'])->format('Y-m-d');
                        $this->pesertaNomorKartu($this->dataPasien['pasien']['identitas']['idbpjs'], $tanggal);
                    } else {
                        // if jenis klaim BPJS dan Kunjungan = Kontrol (3)
                        if ($this->dataDaftarPoliRJ['kontrol12'] == "1") {
                            $this->rujukanPesertaFKTP($this->dataPasien['pasien']['identitas']['idbpjs']);
                        } else {
                            $this->rujukanPesertaFKTL($this->dataPasien['pasien']['identitas']['idbpjs']);
                        }
                    }
                    //
                    //
                    //
                } else if ($this->JenisKlaim['JenisKlaimId'] == 'JM' && $this->JenisKunjungan['JenisKunjunganId'] == 4) {
                    // if jenis klaim BPJS dan Kunjungan = FKTL antar rs(4)
                    $this->rujukanPesertaFKTL($this->dataPasien['pasien']['identitas']['idbpjs']);
                    $this->emit('toastr-error', 'Jenis Klaim FKTL antar rs cek');
                }
            }
        }
    }

    ///////////cariDataPasienByKey/////////////////////////////////
    private function cariDataPasienByKeyArr($key, $search)
    {
        $cariDataPasienByKeyArr = json_decode(DB::table('rsmst_pasiens')
            ->select(
                DB::raw("to_char(reg_date,'dd/mm/yyyy hh24:mi:ss') as reg_date"),
                'reg_no',
                'reg_name',
                DB::raw("nvl(nokartu_bpjs,'-') as nokartu_bpjs"),
                DB::raw("nvl(nik_bpjs,'-') as nik_bpjs"),
                'sex',
                DB::raw("to_char(birth_date,'dd/mm/yyyy') as birth_date"),
                DB::raw("(select trunc( months_between( sysdate, birth_date ) /12 ) from dual) as thn"),
                'bln',
                'hari',
                'birth_place',
                'blood',
                'marital_status',
                'rel_id',
                'edu_id',
                'job_id',
                'kk',
                'nyonya',
                'no_kk',
                'address',
                'rsmst_desas.des_id  as des_id',
                'rsmst_kecamatans.kec_id  as kec_id',
                'rsmst_kabupatens.kab_id  as kab_id',
                'rsmst_propinsis.prop_id  as prop_id',
                'des_name  as des_name',
                'kec_name  as kec_name',
                'kab_name  as kab_name',
                'prop_name  as prop_name',
                'rt',
                'rw',
                'phone'
            )
            ->join('rsmst_desas', 'rsmst_desas.des_id', 'rsmst_pasiens.des_id')
            ->join('rsmst_kecamatans', 'rsmst_kecamatans.kec_id', 'rsmst_desas.kec_id')
            ->join('rsmst_kabupatens', 'rsmst_kabupatens.kab_id', 'rsmst_kecamatans.kab_id')
            ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_kabupatens.prop_id')
            ->where($key, $search)
            ->orderBy('reg_name', 'desc')
            ->get(), true);

        return  $cariDataPasienByKeyArr;
    }
    ////////////////////////////////////////////////////////////////////////

    private function cariDataPasienByKeyCollection($key, $search)
    {
        $findData = DB::table('rsmst_pasiens')
            ->select(
                DB::raw("to_char(reg_date,'dd/mm/yyyy hh24:mi:ss') as reg_date"),
                DB::raw("to_char(reg_date,'yyyymmddhh24miss') as reg_date1"),
                'reg_no',
                'reg_name',
                DB::raw("nvl(nokartu_bpjs,'-') as nokartu_bpjs"),
                DB::raw("nvl(nik_bpjs,'-') as nik_bpjs"),
                'sex',
                DB::raw("to_char(birth_date,'dd/mm/yyyy') as birth_date"),
                DB::raw("(select trunc( months_between( sysdate, birth_date ) /12 ) from dual) as thn"),
                'bln',
                'hari',
                'birth_place',
                'blood',
                'marital_status',
                'rsmst_religions.rel_id as rel_id',
                'rel_desc',
                'rsmst_educations.edu_id as edu_id',
                'edu_desc',
                'rsmst_jobs.job_id as job_id',
                'job_name',
                'kk',
                'nyonya',
                'no_kk',
                'address',
                'rsmst_desas.des_id as des_id',
                'des_name',
                'rt',
                'rw',
                'rsmst_kecamatans.kec_id as kec_id',
                'kec_name',
                'rsmst_kabupatens.kab_id as kab_id',
                'kab_name',
                'rsmst_propinsis.prop_id as prop_id',
                'prop_name',
                'phone'
            )->join('rsmst_religions', 'rsmst_religions.rel_id', 'rsmst_pasiens.rel_id')
            ->join('rsmst_educations', 'rsmst_educations.edu_id', 'rsmst_pasiens.edu_id')
            ->join('rsmst_jobs', 'rsmst_jobs.job_id', 'rsmst_pasiens.job_id')
            ->join('rsmst_desas', 'rsmst_desas.des_id', 'rsmst_pasiens.des_id')
            ->join('rsmst_kecamatans', 'rsmst_kecamatans.kec_id', 'rsmst_pasiens.kec_id')
            ->join('rsmst_kabupatens', 'rsmst_kabupatens.kab_id', 'rsmst_pasiens.kab_id')
            ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_pasiens.prop_id')
            ->where($key, $search)
            ->first();
        return $findData;
    }
    ///////////cariDataPasienByKey/////////////////////////////////

    private function findData($rjno): void
    {
        $findDataRJ = $this->findDataRJ($rjno);
        $this->dataDaftarPoliRJ  = $findDataRJ['dataDaftarRJ'];

        // dd(isset($this->dataDaftarPoliRJ['klaimId']));
        if (!isset($this->dataDaftarPoliRJ['klaimId'])) {
            $this->emit('toastr-error', "Data Klaim tidak ditemukan, Reset Data Ke UMUM");
            $this->dataDaftarPoliRJ['klaimId'] = 'UM';
            $this->dataDaftarPoliRJ['klaimDesc'] = 'UMUM';
        }

        if (!isset($this->dataDaftarPoliRJ['kunjunganId'])) {
            $this->emit('toastr-error', "Data Kunjungan tidak ditemukan, Reset Data Ke FKTP");
        }

        $this->setDataPasien($this->dataDaftarPoliRJ['regNo']);
        $this->dataPasienLovSearch = $this->dataDaftarPoliRJ['regNo'];
        $this->JenisKlaim['JenisKlaimId'] = $this->dataDaftarPoliRJ['klaimId'] == 'JM' ? 'JM' : 'UM';
        $this->JenisKlaim['JenisKlaimDesc'] = $this->dataDaftarPoliRJ['klaimId']  == 'JM' ? 'BPJS' : 'UMUM';

        $this->JenisKunjungan['JenisKunjunganId'] = isset($this->dataDaftarPoliRJ['JenisKunjunganId']) ? $this->dataDaftarPoliRJ['klaimId'] : '1';
        $this->JenisKunjungan['JenisKunjunganDesc'] = isset($this->dataDaftarPoliRJ['JenisKunjunganDesc']) ? isset($this->dataDaftarPoliRJ['JenisKunjunganDesc']) : 'Rujukan FKTP';
    }



    ////////////////////////////////////////////////
    // Lov Pasien //////////////////////
    ////////////////////////////////////////////////
    public function updateddataPasienlovsearch()
    {
        // Variable Search
        $search = $this->dataPasienLovSearch;

        // check LOV by id

        // set Call MasterPasien False
        $this->callMasterPasien = false;

        // Open Lov Pasien Status
        $this->dataPasienLovStatus = true;

        // if there is no id found and check (min 3 char on search)

        if (strlen($search) < 3) {
            $this->dataPasienLov = [];
        } else {


            // Proses Cari Data


            // 1.Cari berdasarkan reg_no  ->if null DB
            // 2.Cari berdasarkan nik ->if null DB
            // 3.Cari berdasarkan nokaBPJS ->if null DB
            // 4.Cari berdasarkan reg_name ->if null DB

            // 5. Goto Pasien Baru berdasarkan nik apiBPJS ->if null
            // 6. Entry Manual Pasien Baru

            // by reg_noxxx
            $cariDataPasienRegNo = $this->cariDataPasienByKeyArr('reg_no', $search);
            if ($cariDataPasienRegNo) {
                $this->dataPasienLov = $cariDataPasienRegNo;
            } else {
                // by nik
                $cariDataPasienNik = $this->cariDataPasienByKeyArr('nik_bpjs', $search);
                if ($cariDataPasienNik) {
                    $this->dataPasienLov = $cariDataPasienNik;
                } else {
                    // by nokaBPJS
                    $cariDataPasienNokaBpjs = $this->cariDataPasienByKeyArr('nokartu_bpjs', $search);
                    if ($cariDataPasienNokaBpjs) {
                        $this->dataPasienLov = $cariDataPasienNokaBpjs;
                    } else {
                        // by name
                        // $cariDataPasienName = json_decode(DB::table('rsmst_pasiens')

                        $cariDataPasienName = DB::table('rsmst_pasiens')
                            ->select(
                                DB::raw("to_char(reg_date,'dd/mm/yyyy hh24:mi:ss') as reg_date"),
                                'reg_no',
                                'reg_name',
                                DB::raw("nvl(nokartu_bpjs,'-') as nokartu_bpjs"),
                                DB::raw("nvl(nik_bpjs,'-') as nik_bpjs"),
                                'sex',
                                DB::raw("to_char(birth_date,'dd/mm/yyyy') as birth_date"),
                                DB::raw("(select trunc( months_between( sysdate, birth_date ) /12 ) from dual) as thn"),
                                'bln',
                                'hari',
                                'birth_place',
                                'blood',
                                'marital_status',
                                'rel_id',
                                'edu_id',
                                'job_id',
                                'kk',
                                'nyonya',
                                'no_kk',
                                'address',
                                'rsmst_desas.des_id  as des_id',
                                'rsmst_kecamatans.kec_id  as kec_id',
                                'rsmst_kabupatens.kab_id  as kab_id',
                                'rsmst_propinsis.prop_id  as prop_id',
                                'des_name  as des_name',
                                'kec_name  as kec_name',
                                'kab_name  as kab_name',
                                'prop_name  as prop_name',
                                'rt',
                                'rw',
                                'phone'
                            )
                            ->join('rsmst_desas', 'rsmst_desas.des_id', 'rsmst_pasiens.des_id')
                            ->join('rsmst_kecamatans', 'rsmst_kecamatans.kec_id', 'rsmst_desas.kec_id')
                            ->join('rsmst_kabupatens', 'rsmst_kabupatens.kab_id', 'rsmst_kecamatans.kab_id')
                            ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_kabupatens.prop_id');


                        // myMultipleSearch by more than one table
                        $myMultipleSearch = explode('%', $search);

                        foreach ($myMultipleSearch as $key => $myMS) {
                            // key 0  mencari regno dan reg name
                            if ($key == 0) {
                                $cariDataPasienName->where(function ($cariDataPasienName) use ($myMS) {
                                    $cariDataPasienName
                                        ->where(DB::raw('upper(reg_no)'), 'like', '%' . strtoupper($myMS) . '%')
                                        ->orWhere(DB::raw('upper(reg_name)'), 'like', '%' . strtoupper($myMS) . '%');
                                });
                            }
                            // key 1  mencari alamat
                            if ($key == 1) {
                                $cariDataPasienName->where(function ($cariDataPasienName) use ($myMS) {
                                    $cariDataPasienName
                                        ->where(DB::raw('upper(address)'), 'like', '%' . strtoupper($myMS) . '%');
                                });
                            }
                        }

                        // limit 50 rec
                        $cariDataPasienName->orderBy('reg_name', 'desc')
                            ->limit(50);

                        $cariDataPasienName = json_decode($cariDataPasienName->get(), true);


                        if ($cariDataPasienName) {
                            $this->dataPasienLov = $cariDataPasienName;
                        } else {
                            // If Confirmation
                            $this->dataPasienLov = [];
                            $this->emit('cari_Data_Pasien_Tidak_Ditemukan_Confirmation', $search);
                            // $this->callMasterPasien = true;
                        }
                    }
                }
            }
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataPasienLov($id)
    {
        $this->setDataPasien($id);
        $this->dataDaftarPoliRJ['regNo'] = $id;

        $this->dataPasienLovStatus = false;
        $this->dataPasienLov = [];
        $this->dataPasienLovSearch = $id;
    }
    ////////////////////////////////////////////////
    // Lov Pasien //////////////////////
    ////////////////////////////////////////////////



    /////////////////////////////////////////////////
    // Lov dataDokterRJ //////////////////////
    ////////////////////////////////////////////////
    public function clickdataDokterlov()
    {
        $this->dataDokterLovStatus = true;
        $this->dataDokterLov = [];
    }

    public function updateddataDokterlovsearch()
    {
        // Variable Search
        $search = $this->dataDokterLovSearch;

        // check LOV by dr_id rs id
        $dataDokter = DB::table('rsmst_doctors')->select(
            'rsmst_doctors.dr_id as dr_id',
            'rsmst_doctors.dr_name as dr_name',
            'kd_dr_bpjs',

            'rsmst_polis.poli_id as poli_id',
            'rsmst_polis.poli_desc as poli_desc',
            'kd_poli_bpjs'
        )
            ->Join('rsmst_polis', 'rsmst_polis.poli_id', 'rsmst_doctors.poli_id')
            ->where('rsmst_doctors.dr_id', $search)
            ->first();

        if ($dataDokter) {
            $this->dataDaftarPoliRJ['drId'] = $dataDokter->dr_id;
            $this->dataDaftarPoliRJ['drDesc'] = $dataDokter->dr_name;

            $this->dataDaftarPoliRJ['poliId'] = $dataDokter->poli_id;
            $this->dataDaftarPoliRJ['poliDesc'] = $dataDokter->poli_desc;

            $this->dataDaftarPoliRJ['kddrbpjs'] = $dataDokter->kd_dr_bpjs;
            $this->dataDaftarPoliRJ['kdpolibpjs'] = $dataDokter->kd_poli_bpjs;

            $this->dataDokterLovStatus = false;
            $this->dataDokterLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->dataDokterLov = [];
            } else {
                $this->dataDokterLov = json_decode(
                    DB::table('rsmst_doctors')->select(
                        'rsmst_doctors.dr_id as dr_id',
                        'rsmst_doctors.dr_name as dr_name',
                        'kd_dr_bpjs',

                        'rsmst_polis.poli_id as poli_id',
                        'rsmst_polis.poli_desc as poli_desc',
                        'kd_poli_bpjs'

                    )
                        ->Join('rsmst_polis', 'rsmst_polis.poli_id', 'rsmst_doctors.poli_id')

                        ->where('rsmst_doctors.active_status', '1')
                        ->Where(DB::raw('upper(dr_name)'), 'like', '%' . strtoupper($search) . '%')
                        ->orWhere('poli_desc', 'like', '%' . strtoupper($search) . '%')
                        ->limit(10)
                        ->orderBy('dr_name', 'ASC')
                        ->orderBy('poli_desc', 'ASC')
                        ->get(),
                    true
                );
            }
            $this->dataDokterLovStatus = true;
            $this->dataDaftarPoliRJ['drId'] = '';
            $this->dataDaftarPoliRJ['drDesc'] = '';
            $this->dataDaftarPoliRJ['poliId'] = '';
            $this->dataDaftarPoliRJ['poliDesc'] = '';
            $this->dataDaftarPoliRJ['kddrbpjs'] = '';
            $this->dataDaftarPoliRJ['kdpolibpjs'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataDokterLov($id, $name)
    {
        $dataDokter = DB::table('rsmst_doctors')->select(
            'rsmst_doctors.dr_id as dr_id',
            'rsmst_doctors.dr_name as dr_name',
            'kd_dr_bpjs',

            'rsmst_polis.poli_id as poli_id',
            'rsmst_polis.poli_desc as poli_desc',
            'kd_poli_bpjs'
        )
            ->Join('rsmst_polis', 'rsmst_polis.poli_id', 'rsmst_doctors.poli_id')
            ->where('rsmst_doctors.dr_id', $id)
            ->first();
        $this->dataDaftarPoliRJ['drId'] = $dataDokter->dr_id;
        $this->dataDaftarPoliRJ['drDesc'] = $dataDokter->dr_name;

        $this->dataDaftarPoliRJ['poliId'] = $dataDokter->poli_id;
        $this->dataDaftarPoliRJ['poliDesc'] = $dataDokter->poli_desc;

        $this->dataDaftarPoliRJ['kddrbpjs'] = $dataDokter->kd_dr_bpjs;
        $this->dataDaftarPoliRJ['kdpolibpjs'] = $dataDokter->kd_poli_bpjs;

        $this->dataDokterLovStatus = false;
        $this->dataDokterLovSearch = '';
    }
    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataDokterRJ //////////////////////
    ////////////////////////////////////////////////








    // ////////////////
    // Antrol Logic
    // ////////////////


    private function pushDataAntrian()
    {
        //push data antrian UMUM BPJS kecuali 'kronis'
        if ($this->dataDaftarPoliRJ['klaimId'] != 'KR') {
            $rjdate = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate']); //Tgl RJ

            $dayDesc = $rjdate->isoFormat('dddd'); //Senin Selasa Rabu ...

            $dayid = ($dayDesc == 'Senin') ? 1 //kode Senin Selasa Rabu ...
                : ($dayDesc == 'Selasa' ? 2
                    : ($dayDesc == 'Rabu' ? 3
                        : ($dayDesc == 'Kamis' ? 4
                            : ($dayDesc == 'Jumat' ? 5
                                : 6
                            )
                        )
                    )
                );

            $JadwalPraktek = json_decode(json_encode(DB::table('scmst_scpolis')
                ->select(
                    //Poli RS
                    'scmst_scpolis.dr_id as dr_id',
                    'rsmst_doctors.dr_name as dr_name',
                    'scmst_scpolis.sc_poli_ket as sc_poli_ket',
                    'scmst_scpolis.poli_id as poli_id',
                    'rsmst_polis.poli_desc as poli_desc',

                    //Poli BPJS
                    'rsmst_doctors.kd_dr_bpjs as kd_dr_bpjs',
                    'rsmst_polis.kd_poli_bpjs as kd_poli_bpjs',

                    DB::raw("nvl(mulai_praktek,'00:00:00') as mulai_praktek"),
                    DB::raw("nvl(selesai_praktek,'00:00:00') as selesai_praktek"),

                    DB::raw('nvl(kuota,35) as kuota'),
                )
                ->Join('rsmst_doctors', 'rsmst_doctors.dr_id', 'scmst_scpolis.dr_id')
                ->Join('rsmst_polis', 'rsmst_polis.poli_id', 'scmst_scpolis.poli_id')
                ->Where('day_id', $dayid)
                ->Where('scmst_scpolis.dr_id', $this->dataDaftarPoliRJ['drId']) //Cek Poli RS
                ->Where('sc_poli_status_', 1)
                ->orderBy('scmst_scpolis.no_urut', 'ASC')
                ->orderBy('scmst_scpolis.poli_id', 'ASC')
                ->first(), true), true);


            if (!$JadwalPraktek) {
                $JadwalPraktek['mulai_praktek'] = '07:00:00';
                $JadwalPraktek['selesai_praktek'] = '13:00:00';

                $JadwalPraktek['kuota'] = 30;
            }

            // Pelayanan (Poli Tgl + Jam Layanan)
            $hariLayananJamLayanan = Carbon::createFromFormat('d/m/Y H:i:s', $rjdate->format('d/m/Y') . ' ' . $JadwalPraktek['mulai_praktek']);
            // $timestamp = $hariLayananJamLayanan->timestamp; //Timestemp Layanan
            // off kan semsntara dan atur ulang logic jadwal_estimasi (masalah pada penambahan 10 menit per pasien tidak jalan)
            // $jadwal_estimasi = $hariLayananJamLayanan->addMinutes(10 * ($this->dataDaftarPoliRJ['noAntrian'] + 1)); // Hari Layanan||JamPraktek + 10menit

            // $jadwal_estimasi = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'])->timestamp * 1000; //waktu dalam timestamp milisecond
            $jadwal_estimasi = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'])->valueOf();

            // JamPraktek
            $jampraktek = Str::substr($JadwalPraktek['mulai_praktek'], 0, 5) . '-' . Str::substr($JadwalPraktek['selesai_praktek'], 0, 5); //'00:00-00:00'

            $antreanadd = [
                "kodebooking" => $this->dataDaftarPoliRJ['noBooking'],
                "jenispasien" => ($this->dataDaftarPoliRJ['klaimId'] == 'JM') ? 'JKN' : 'NON JKN', //Layanan UMUM BPJS
                "nomorkartu" => ($this->dataDaftarPoliRJ['klaimId'] == 'JM') ? $this->dataPasien['pasien']['identitas']['idbpjs'] : '',
                "nik" => $this->dataPasien['pasien']['identitas']['nik'],
                "nohp" =>  $this->dataPasien['pasien']['kontak']['nomerTelponSelulerPasien'],
                "kodepoli" => $this->dataDaftarPoliRJ['kdpolibpjs'] ? $this->dataDaftarPoliRJ['kdpolibpjs'] : $this->dataDaftarPoliRJ['poliId'], //if null poliidRS
                "namapoli" => $this->dataDaftarPoliRJ['poliDesc'],
                "pasienbaru" => 0,
                "norm" => $this->dataDaftarPoliRJ['regNo'],
                "tanggalperiksa" => Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'])->format('Y-m-d'),
                "kodedokter" => $this->dataDaftarPoliRJ['kddrbpjs'] ? $this->dataDaftarPoliRJ['kddrbpjs'] : $this->dataDaftarPoliRJ['drId'], //if Null dridRS
                "namadokter" => $this->dataDaftarPoliRJ['drDesc'],
                "jampraktek" => $jampraktek,
                "jeniskunjungan" => $this->dataDaftarPoliRJ['kunjunganId'], //FKTP/FKTL/Kontrol/Internal
                "nomorreferensi" => $this->dataDaftarPoliRJ['noReferensi'],
                "nomorantrean" => $this->dataDaftarPoliRJ['noAntrian'],
                "angkaantrean" => $this->dataDaftarPoliRJ['noAntrian'],
                "estimasidilayani" => $jadwal_estimasi,
                "sisakuotajkn" => $JadwalPraktek['kuota'] - $this->dataDaftarPoliRJ['noAntrian'],
                "kuotajkn" => $JadwalPraktek['kuota'],
                "sisakuotanonjkn" => $JadwalPraktek['kuota'] - $this->dataDaftarPoliRJ['noAntrian'],
                "kuotanonjkn" => $JadwalPraktek['kuota'],
                "keterangan" => "Peserta harap 30 menit lebih awal guna pencatatan administrasi.",
            ];

            // dd($jadwal_estimasi);
            // dd(Carbon::createFromTimestamp($jadwal_estimasi / 1000)->toDateTimeString());
            // dd($antreanadd);
        }

        // http Post



        // Lakukan 2 x cek http dan BPJS untuk memastikan proses kirim data berhasil
        // dan menentukan nilai status / jika code =200 skip proses tersebut
        // jika antrean berhasil-> buat SEP
        //jika gagal ulangi-> antrean
        // (pembuatan SEP dilakukan ketika proses antrean berhasil)

        $cekAntrianAntreanBPJS = DB::table('rstxn_rjhdrs')
            ->select('push_antrian_bpjs_status', 'push_antrian_bpjs_json')
            ->where('rj_no', $this->dataDaftarPoliRJ['rjNo'])
            ->first();


        $cekAntrianAntreanBPJSStatus = isset($cekAntrianAntreanBPJS->push_antrian_bpjs_status) ? $cekAntrianAntreanBPJS->push_antrian_bpjs_status : "";
        // 1 cek proses pada database status 208 task id sudah terbit
        if ($cekAntrianAntreanBPJSStatus == 200 || $cekAntrianAntreanBPJSStatus == 208) {

            // set http response to public
            $this->HttpGetBpjsStatus = $cekAntrianAntreanBPJS->push_antrian_bpjs_status; //status 200 201 400 ..
            $this->HttpGetBpjsJson = $cekAntrianAntreanBPJS->push_antrian_bpjs_json; //Return Response Tambah Antrean

            //ketika Push Tambah Antrean Berhasil buat SEP
            //////////////////////////////////////////////
            if ($this->JenisKlaim['JenisKlaimId'] == 'JM') {
                $this->pushInsertSEP($this->SEPJsonReq);
            }
            //ketika Push Tambah Antrean Berhasil buat SEP
            //////////////////////////////////////////////

        } else {
            // Tambah Antrean
            $HttpGetBpjs =  AntrianTrait::tambah_antrean($antreanadd)->getOriginalContent();
            // set http response to public
            $this->HttpGetBpjsStatus = $HttpGetBpjs['metadata']['code']; //status 200 201 400 ..
            $this->HttpGetBpjsJson = json_encode($HttpGetBpjs, true); //Return Response Tambah Antrean


            // 2 cek proses pada getHttp
            if ($HttpGetBpjs['metadata']['code'] == 200 || $HttpGetBpjs['metadata']['code'] == 208) {
                $this->emit('toastr-success', 'Tambah Antrian ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);

                $this->HttpGetBpjsStatus = $HttpGetBpjs['metadata']['code']; //status 200 201 400 ..
                $this->HttpGetBpjsJson = json_encode($HttpGetBpjs, true); //Return Response Tambah Antrean

                //ketika Push Tambah Antrean Berhasil buat SEP
                //////////////////////////////////////////////
                if ($this->JenisKlaim['JenisKlaimId'] == 'JM') {
                    $this->pushInsertSEP($this->SEPJsonReq);
                }
                //ketika Push Tambah Antrean Berhasil buat SEP
                //////////////////////////////////////////////
            } else {
                $this->emit('toastr-error', 'Tambah Antrian ' . $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);

                $this->HttpGetBpjsStatus = $HttpGetBpjs['metadata']['code']; //status 200 201 400 ..
                $this->HttpGetBpjsJson = json_encode($HttpGetBpjs, true); //Return Response Tambah Antrean

                // Ulangi Proses pushDataAntrian;
                // $this->emit('rePush_Data_Antrian_Confirmation');
            }
        }



        /////////////////////////
        // Update TaskId 3
        /////////////////////////

        $noBooking = $this->dataDaftarPoliRJ['noBooking'];
        $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId3'] = $this->dataDaftarPoliRJ['rjDate'];
        $waktu = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId3'])->timestamp * 1000; //waktu dalam timestamp milisecond
        // $waktu = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId3'])->valueOf(); //waktu dalam timestamp milisecond
        $waktu = Carbon::now()->timestamp * 1000;

        $this->pushDataTaskId($noBooking, 3, $waktu);
    }

    private function pushDataTaskId($noBooking, $taskId, $time): void
    {
        //////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////
        // Update Task Id $kodebooking, $taskid, $waktu, $jenisresep

        $waktu = $time;
        $HttpGetBpjs =  AntrianTrait::update_antrean($noBooking, $taskId, $waktu, "")->getOriginalContent();



        // metadata d kecil
        if ($HttpGetBpjs['metadata']['code'] == 200) {
            $this->emit('toastr-success', 'Task Id' . $taskId . ' ' . $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        } else {
            $this->emit('toastr-error', 'Task Id' . $taskId . ' ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);

            // Ulangi Proses pushTaskId;
            // $this->emit('rePush_Data_TaskId_Confirmation');
        }
    }

    private function rujukanPesertaFKTP($idBpjs): void
    {
        $HttpGetBpjs =  VclaimTrait::rujukan_peserta($idBpjs)->getOriginalContent();

        // metadata d kecil
        if ($HttpGetBpjs['metadata']['code'] == 200) {
            $this->dataRefBPJSLovStatus = true;
            $this->dataRefBPJSLov = json_decode(json_encode($HttpGetBpjs['response']['rujukan'], true), true);

            $this->emit('toastr-success', $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        } else {
            $this->dataRefBPJSLovStatus = false;
            $this->dataRefBPJSLov = [];
            $this->emit('toastr-error', $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        }
    }

    private function rujukanPesertaFKTL($idBpjs): void
    {
        $HttpGetBpjs =  VclaimTrait::rujukan_rs_peserta($idBpjs)->getOriginalContent();

        // metadata d kecil
        if ($HttpGetBpjs['metadata']['code'] == 200) {
            $this->dataRefBPJSLovStatus = true;
            $this->dataRefBPJSLov = json_decode(json_encode($HttpGetBpjs['response']['rujukan'], true), true);

            $this->emit('toastr-success', $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        } else {
            $this->dataRefBPJSLovStatus = false;
            $this->dataRefBPJSLov = [];
            $this->emit('toastr-error', $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        }
    }

    private function pesertaNomorKartu($idBpjs, $tanggal): void
    {
        $HttpGetBpjs =  VclaimTrait::peserta_nomorkartu($idBpjs, $tanggal)->getOriginalContent();

        // metadata d kecil
        if ($HttpGetBpjs['metadata']['code'] == 200) {
            $peserta = $HttpGetBpjs['response'];
            $this->setSEPJsonReqPostInap($peserta);
            $this->formRujukanRefBPJSStatus = true;
            $this->emit('toastr-success', $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        } else {
            $this->dataRefBPJSLovStatus = false;
            $this->dataRefBPJSLov = [];
            $this->emit('toastr-error', $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        }
    }







    // ////////////////
    // SEP Logic
    // ////////////////

    private function pushInsertSEP($SEPJsonReq)
    {

        //ketika Push Tambah Antrean Berhasil buat SEP
        //////////////////////////////////////////////
        $HttpGetBpjs =  VclaimTrait::sep_insert($SEPJsonReq)->getOriginalContent();
        if ($HttpGetBpjs['metadata']['code'] == 200) {
            // dd($HttpGetBpjs);
            $this->dataDaftarPoliRJ['sep']['resSep'] = $HttpGetBpjs['response']['sep'];
            $this->dataDaftarPoliRJ['sep']['noSep'] = $HttpGetBpjs['response']['sep']['noSep'];

            $this->emit('toastr-success', 'SEP ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        } else {
            $this->emit('toastr-error', 'SEP ' . $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        }

        // response sep value
        //ketika Push Tambah Antrean Berhasil buat SEP
        //////////////////////////////////////////////
    }

    public function storeDataSepReq(): void
    {
        // jika jenis klaim JM (BPJS)
        if ($this->JenisKlaim['JenisKlaimId'] == 'JM') {

            //tambah logic untuk antrol
            //jika 1 kunjungan awal set data noRujukan
            //jika 2 internal set data -----
            //jika 3 kontrol set data no SKDP
            //jika 4 kunjungan awal dari RS set data noRujukan

            $this->dataDaftarPoliRJ['noReferensi'] =
                ($this->JenisKunjungan['JenisKunjunganId'] == 1)
                ? (isset($this->SEPJsonReq['request']['t_sep']['rujukan']['noRujukan']) ? $this->SEPJsonReq['request']['t_sep']['rujukan']['noRujukan'] : "Data tidak dapat diproses")
                : (
                    ($this->JenisKunjungan['JenisKunjunganId'] == 2)
                    ? (isset($this->SEPJsonReq['request']['t_sep']['rujukan']['noRujukan']) ? substr($this->SEPJsonReq['request']['t_sep']['rujukan']['noRujukan'], 0, 16) : "Data tidak dapat diproses") . 'XXX'
                    : (
                        ($this->JenisKunjungan['JenisKunjunganId'] == 3)
                        ? (isset($this->SEPJsonReq['request']['t_sep']['skdp']['noSurat']) ? $this->SEPJsonReq['request']['t_sep']['skdp']['noSurat'] : "Data tidak dapat diproses")
                        : (
                            ($this->JenisKunjungan['JenisKunjunganId'] == 4)
                            ? (isset($this->SEPJsonReq['request']['t_sep']['rujukan']['noRujukan']) ? $this->SEPJsonReq['request']['t_sep']['rujukan']['noRujukan'] : "Data tidak dapat diproses")
                            : (isset($this->SEPJsonReq['request']['t_sep']['rujukan']['noRujukan']) ? $this->SEPJsonReq['request']['t_sep']['rujukan']['noRujukan'] : "Data tidak dapat diproses")
                        )
                    )
                );
        }
        // close Form
        $this->formRujukanRefBPJSStatus = false;

        $this->dataDaftarPoliRJ['sep']['reqSep'] = $this->SEPJsonReq;
    }

    /////////////////////////////////////////////////
    // Lov dataRefBPJSLov //////////////////////
    ////////////////////////////////////////////////
    public function clickdataRefBPJSlov()
    {
        $this->dataRefBPJSLovStatus = true;
        $this->dataRefBPJSLov = [];
    }
    public function updateddataRefBPJSlovsearch()
    {
        // Variable Search
        $search = $this->dataRefBPJSLovSearch;

        // check LOV by id
        $dataRefBPJS = DB::table('rsmst_doctors')->select(
            'rsmst_doctors.dr_id as dr_id',
            'rsmst_doctors.dr_name as dr_name',
            'kd_dr_bpjs',

            'rsmst_polis.poli_id as poli_id',
            'rsmst_polis.poli_desc as poli_desc',
            'kd_poli_bpjs'
        )
            ->Join('rsmst_polis', 'rsmst_polis.poli_id', 'rsmst_doctors.poli_id')

            ->where('rsmst_doctors.active_status', '1')
            ->where('rsmst_doctors.dr_id', $search)
            ->first();

        if ($dataRefBPJS) {
            $this->dataDaftarPoliRJ['drId'] = $dataRefBPJS->dr_id;
            $this->dataDaftarPoliRJ['drDesc'] = $dataRefBPJS->dr_name;

            $this->dataDaftarPoliRJ['poliId'] = $dataRefBPJS->poli_id;
            $this->dataDaftarPoliRJ['poliDesc'] = $dataRefBPJS->poli_desc;

            $this->dataDaftarPoliRJ['kddrbpjs'] = $dataRefBPJS->kd_dr_bpjs;
            $this->dataDaftarPoliRJ['kdpolibpjs'] = $dataRefBPJS->kd_poli_bpjs;

            $this->dataRefBPJSLovStatus = false;
            $this->dataRefBPJSLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->dataRefBPJSLov = [];
            } else {
                $this->dataRefBPJSLov = json_decode(
                    DB::table('rsmst_doctors')->select(
                        'rsmst_doctors.dr_id as dr_id',
                        'rsmst_doctors.dr_name as dr_name',
                        'kd_dr_bpjs',

                        'rsmst_polis.poli_id as poli_id',
                        'rsmst_polis.poli_desc as poli_desc',
                        'kd_poli_bpjs'

                    )
                        ->Join('rsmst_polis', 'rsmst_polis.poli_id', 'rsmst_doctors.poli_id')

                        ->where('rsmst_doctors.active_status', '1')
                        ->Where(DB::raw('upper(dr_name)'), 'like', '%' . strtoupper($search) . '%')
                        ->orWhere('poli_desc', 'like', '%' . strtoupper($search) . '%')
                        ->limit(10)
                        ->orderBy('dr_name', 'ASC')
                        ->orderBy('poli_desc', 'ASC')
                        ->get(),
                    true
                );
            }
            $this->dataRefBPJSLovStatus = true;
            $this->dataDaftarPoliRJ['drId'] = '';
            $this->dataDaftarPoliRJ['drDesc'] = '';
            $this->dataDaftarPoliRJ['poliId'] = '';
            $this->dataDaftarPoliRJ['poliDesc'] = '';
            $this->dataDaftarPoliRJ['kddrbpjs'] = '';
            $this->dataDaftarPoliRJ['kdpolibpjs'] = '';
        }
    }
    public function setMydataRefBPJSLov($id, $name)
    {

        // dd($dataRefBPJSLov);
        // set SEPJsonReq
        $this->setSEPJsonReq($id);

        $this->dataRefBPJSLovStatus = false;
        $this->dataRefBPJSLovSearch = '';

        // set formRujukanRefBPJSStatus true (open form)
        $this->formRujukanRefBPJSStatus = true;
    }

    private function setSEPJsonReq($id): void
    {
        // cari data Lov dgn no Kunjungan
        $dataRefBPJSLov = collect($this->dataRefBPJSLov)->where('noKunjungan', $id)->first();

        // cari data Poli sesuai rujukan BPJS (mapping data poli dan dokter)
        $cariDataIdBpjs_dr_poli = DB::table('rsmst_doctors')
            ->select('kd_dr_bpjs', 'kd_poli_bpjs', 'rsmst_doctors.dr_id as dr_id', 'dr_name', 'rsmst_doctors.poli_id as poli_id', 'poli_desc')
            ->join('rsmst_polis', 'rsmst_doctors.poli_id', 'rsmst_polis.poli_id')
            ->where('kd_poli_bpjs', $dataRefBPJSLov['poliRujukan']['kode'])
            ->whereNotNull('kd_poli_bpjs')
            ->whereNotNull('kd_dr_bpjs')
            ->first();

        // Jika cariDataIdBpjs_dr_poli true
        if ($cariDataIdBpjs_dr_poli) {

            // Jika Data doker dan poli bpjs true
            if (isset($cariDataIdBpjs_dr_poli->kd_dr_bpjs) && isset($cariDataIdBpjs_dr_poli->kd_poli_bpjs)) {
                // set data dokter RJ
                $this->dataDaftarPoliRJ['drId'] = $cariDataIdBpjs_dr_poli->dr_id;
                $this->dataDaftarPoliRJ['drDesc'] = $cariDataIdBpjs_dr_poli->dr_name;

                $this->dataDaftarPoliRJ['poliId'] = $cariDataIdBpjs_dr_poli->poli_id;
                $this->dataDaftarPoliRJ['poliDesc'] = $cariDataIdBpjs_dr_poli->poli_desc;

                $this->dataDaftarPoliRJ['kddrbpjs'] = $cariDataIdBpjs_dr_poli->kd_dr_bpjs;
                $this->dataDaftarPoliRJ['kdpolibpjs'] = $cariDataIdBpjs_dr_poli->kd_poli_bpjs;
            } else {
                // jika salah satu data kosong
                $this->emit('toastr-error', "Data Dokter atau Poli mapping BPJS belum di set.");
            }
        } else {
            $this->emit('toastr-error', "Data Dokter atau Poli mapping BPJS belum tidak di temukan.");
        }

        // Mencari asalRujukan
        // if jenis klaim BPJS dan Kunjungan = FKTP (1)
        if ($this->JenisKlaim['JenisKlaimId'] == 'JM' && $this->JenisKunjungan['JenisKunjunganId'] == 1) {
            $asalRujukan = "1";
            $asalRujukanNama = "Faskes Tingkat 1";
            //
            //
            //
        } else if ($this->JenisKlaim['JenisKlaimId'] == 'JM' && $this->JenisKunjungan['JenisKunjunganId'] == 2) {
            // if jenis klaim BPJS dan Kunjungan = Inernal (2) FKTP 1 atau FKTL 2
            if ($this->dataDaftarPoliRJ['internal12'] == "1") {
                $asalRujukan = "1";
                $asalRujukanNama = "Faskes Tingkat 1";
            } else {
                $asalRujukan = "2";
                $asalRujukanNama = "Faskes Tingkat 2 RS";
            }

            //
            //
            //
        } else if ($this->JenisKlaim['JenisKlaimId'] == 'JM' && $this->JenisKunjungan['JenisKunjunganId'] == 3) {
            // if jenis klaim BPJS dan Kunjungan = Kontrol (3) / Post Inap
            if ($this->dataDaftarPoliRJ['postInap']) {
                $asalRujukan = "2";
                $asalRujukanNama = "Faskes Tingkat 2 RS";
            } else {
                // if jenis klaim BPJS dan Kunjungan = Kontrol (3)
                if ($this->dataDaftarPoliRJ['kontrol12'] == "1") {
                    $asalRujukan = "1";
                    $asalRujukanNama = "Faskes Tingkat 1";
                } else {
                    $asalRujukan = "2";
                    $asalRujukanNama = "Faskes Tingkat 2 RS";
                }
            }
            //
            //
            //
        } else if ($this->JenisKlaim['JenisKlaimId'] == 'JM' && $this->JenisKunjungan['JenisKunjunganId'] == 4) {
            // if jenis klaim BPJS dan Kunjungan = FKTL antar rs(4)
            $asalRujukan = "2";
            $asalRujukanNama = "Faskes Tingkat 2 RS";
        }


        $this->SEPJsonReq = [
            "request" =>  [
                "t_sep" =>  [
                    "noKartu" => "" . $dataRefBPJSLov['peserta']['noKartu'] . "",
                    "tglSep" => "" . Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'])->format('Y-m-d') . "", //Y-m-d =tgl rj
                    "ppkPelayanan" => "0184R006", //ppk rs
                    "jnsPelayanan" => "" . $dataRefBPJSLov['pelayanan']['kode'] . "", // {jenis pelayanan = 1. r.inap 2. r.jalan}
                    "klsRawat" =>  [
                        "klsRawatHak" => "" . $dataRefBPJSLov['peserta']['hakKelas']['kode'] . "",
                        "klsRawatHakNama" => "" . $dataRefBPJSLov['peserta']['hakKelas']['keterangan'] . "",
                        "klsRawatNaik" => "", //{diisi jika naik kelas rawat, 1. VVIP, 2. VIP, 3. Kelas 1, 4. Kelas 2, 5. Kelas 3, 6. ICCU, 7. ICU, 8. Diatas Kelas 1}
                        "pembiayaan" => "", //{1. Pribadi, 2. Pemberi Kerja, 3. Asuransi Kesehatan Tambahan. diisi jika naik kelas rawat}
                        "penanggungJawab" => "", //{Contoh: jika pembiayaan 1 maka penanggungJawab=Pribadi. diisi jika naik kelas rawat}
                    ],
                    "noMR" => "" . $dataRefBPJSLov['peserta']['mr']['noMR'] . "",
                    "rujukan" =>  [
                        "asalRujukan" =>  $asalRujukan, //{asal rujukan ->1.Faskes 1, 2. Faskes 2(RS)}
                        "asalRujukanNama" => $asalRujukanNama, //{asal rujukan ->1.Faskes 1, 2. Faskes 2(RS)}
                        "tglRujukan" => "" . $dataRefBPJSLov['tglKunjungan'] . "", //Y-m-d
                        "noRujukan" => "" . $dataRefBPJSLov['noKunjungan'] . "",
                        "ppkRujukan" => "" . $dataRefBPJSLov['provPerujuk']['kode'] . "", //{kode faskes rujukam -> baca di referensi faskes}
                        "ppkRujukanNama" => "" . $dataRefBPJSLov['provPerujuk']['nama'] . "", //{kode faskes rujukam -> baca di referensi faskes}
                    ],
                    "catatan" => "-",
                    "diagAwal" => "" . $dataRefBPJSLov['diagnosa']['kode'] . "",
                    "diagAwalNama" => "" . $dataRefBPJSLov['diagnosa']['nama'] . "",
                    "poli" =>  [
                        "tujuan" => "" . $dataRefBPJSLov['poliRujukan']['kode'] . "", //Untuk Kunjungan Internal beda poli dgn rujukan
                        "tujuanNama" => "" . $dataRefBPJSLov['poliRujukan']['nama'] . "",
                        "eksekutif" => "" . "0" . "", //{poli eksekutif -> 0. Tidak 1.Ya}
                        "eksekutifRef" =>  $this->SEPJsonReq['request']['t_sep']['poli']['eksekutifRef'], //{poli eksekutif -> 0. Tidak 1.Ya}
                    ],
                    "cob" =>  [
                        "cob" => "" . "0" . "", //{cob -> 0.Tidak 1. Ya}
                        "cobRef" => $this->SEPJsonReq['request']['t_sep']['cob']['cobRef'], //{cob -> 0.Tidak 1. Ya}

                    ],
                    "katarak" =>  [
                        "katarak" => "" . "0" . "", //{katarak --> 0.Tidak 1.Ya}
                        "katarakRef" =>  $this->SEPJsonReq['request']['t_sep']['katarak']['katarakRef'], //{katarak --> 0.Tidak 1.Ya}

                    ],

                    // fitur jaminan laka blm dikerjakan
                    "jaminan" =>  [
                        "lakaLantas" => "0", //" 0 : Bukan Kecelakaan lalu lintas [BKLL], 1 : KLL dan bukan kecelakaan Kerja [BKK], 2 : KLL dan KK, 3 : KK",
                        "noLP" => "",
                        "penjamin" =>  [
                            "tglKejadian" => "",
                            "keterangan" => "",
                            "suplesi" =>  [
                                "suplesi" => "0",
                                "noSepSuplesi" => "",
                                "lokasiLaka" =>  [
                                    "kdPropinsi" => "",
                                    "kdKabupaten" => "",
                                    "kdKecamatan" => "",
                                ]
                            ]
                        ]
                    ],
                    "tujuanKunj" => "0", //{"0": Normal,"1": Prosedur,"2": Konsul Dokter}
                    "tujuanKunjDesc" => "Normal",

                    "flagProcedure" => "",
                    "flagProcedureDesc" => "",

                    "kdPenunjang" => "",
                    "kdPenunjangDesc" => "",

                    "assesmentPel" => "",
                    "assesmentPelDesc" => "",
                    "skdp" =>  [
                        "noSurat" => "", //disi ketika wire model dan JenisKunjunganId == 3
                        "kodeDPJP" => "" . $dataRefBPJSLov['pelayanan']['kode'] == 1
                            ? "" : (($cariDataIdBpjs_dr_poli->kd_dr_bpjs && $this->JenisKunjungan['JenisKunjunganId'] == 3)
                                ? $cariDataIdBpjs_dr_poli->kd_dr_bpjs : "") . "", //tidak di isi jika jenis kunjungan selain KONTROL
                    ],
                    "dpjpLayan" => "" . $dataRefBPJSLov['pelayanan']['kode'] == 1
                        ? "" : ($cariDataIdBpjs_dr_poli->kd_dr_bpjs
                            ? $cariDataIdBpjs_dr_poli->kd_dr_bpjs : "") . "", //(tidak diisi jika jnsPelayanan = "1" (RANAP),
                    "dpjpLayanNama" => "" . $cariDataIdBpjs_dr_poli->dr_name . "", //(tidak diisi jika jnsPelayanan = "1" (RANAP),
                    "noTelp" => "" . $dataRefBPJSLov['peserta']['mr']['noTelepon'] . "",
                    "user" => "sirus App",
                ],
            ],
        ];
    }

    private function setSEPJsonReqPostInap($dataRefPeserta): void
    {



        $this->SEPJsonReq = [
            "request" =>  [
                "t_sep" =>  [
                    "noKartu" => "" . $dataRefPeserta['peserta']['noKartu'] . "",
                    "tglSep" => "" . Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'])->format('Y-m-d') . "", //Y-m-d =tgl rj
                    "ppkPelayanan" => "0184R006", //ppk rs
                    "jnsPelayanan" => "2", // {jenis pelayanan = 1. r.inap 2. r.jalan}
                    "klsRawat" =>  [
                        "klsRawatHak" => "" . $dataRefPeserta['peserta']['hakKelas']['kode'] . "",
                        "klsRawatHakNama" => "" . $dataRefPeserta['peserta']['hakKelas']['keterangan'] . "",
                        "klsRawatNaik" => "", //{diisi jika naik kelas rawat, 1. VVIP, 2. VIP, 3. Kelas 1, 4. Kelas 2, 5. Kelas 3, 6. ICCU, 7. ICU, 8. Diatas Kelas 1}
                        "pembiayaan" => "", //{1. Pribadi, 2. Pemberi Kerja, 3. Asuransi Kesehatan Tambahan. diisi jika naik kelas rawat}
                        "penanggungJawab" => "", //{Contoh: jika pembiayaan 1 maka penanggungJawab=Pribadi. diisi jika naik kelas rawat}
                    ],
                    "noMR" => "" . $dataRefPeserta['peserta']['mr']['noMR'] . "",
                    "rujukan" =>  [
                        "asalRujukan" => "2", //{asal rujukan ->1.Faskes 1, 2. Faskes 2(RS)} Post inap asal rujukan 2
                        "asalRujukanNama" => "Faskes Tingkat 2 RS ", //{asal rujukan ->1.Faskes 1, 2. Faskes 2(RS)}
                        "tglRujukan" => "" . Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'])->format('Y-m-d') . "", //Y-m-d
                        "noRujukan" => "" . '' . "",
                        "ppkRujukan" => "" . '0184R006' . "", //{kode faskes rujukam -> baca di referensi faskes}
                        "ppkRujukanNama" => "" . 'MADINAH' . "", //{kode faskes rujukam -> baca di referensi faskes}
                    ],
                    "catatan" => "-",
                    "diagAwal" => "" . '' . "",
                    "diagAwalNama" => "" . '' . "",
                    "poli" =>  [
                        "tujuan" => "" . '' . "", //Untuk Kunjungan Internal beda poli dgn rujukan
                        "tujuanNama" => "" . '' . "",
                        "eksekutif" => "" . "0" . "", //{poli eksekutif -> 0. Tidak 1.Ya}
                        "eksekutifRef" =>  $this->SEPJsonReq['request']['t_sep']['poli']['eksekutifRef'], //{poli eksekutif -> 0. Tidak 1.Ya}
                    ],
                    "cob" =>  [
                        "cob" => "" . "0" . "", //{cob -> 0.Tidak 1. Ya}
                        "cobRef" => $this->SEPJsonReq['request']['t_sep']['cob']['cobRef'], //{cob -> 0.Tidak 1. Ya}

                    ],
                    "katarak" =>  [
                        "katarak" => "" . "0" . "", //{katarak --> 0.Tidak 1.Ya}
                        "katarakRef" =>  $this->SEPJsonReq['request']['t_sep']['katarak']['katarakRef'], //{katarak --> 0.Tidak 1.Ya}

                    ],

                    // fitur jaminan laka blm dikerjakan
                    "jaminan" =>  [
                        "lakaLantas" => "0", //" 0 : Bukan Kecelakaan lalu lintas [BKLL], 1 : KLL dan bukan kecelakaan Kerja [BKK], 2 : KLL dan KK, 3 : KK",
                        "noLP" => "",
                        "penjamin" =>  [
                            "tglKejadian" => "",
                            "keterangan" => "",
                            "suplesi" =>  [
                                "suplesi" => "0",
                                "noSepSuplesi" => "",
                                "lokasiLaka" =>  [
                                    "kdPropinsi" => "",
                                    "kdKabupaten" => "",
                                    "kdKecamatan" => "",
                                ]
                            ]
                        ]
                    ],
                    "tujuanKunj" => "0", //{"0": Normal,"1": Prosedur,"2": Konsul Dokter}
                    "tujuanKunjDesc" => "Normal",

                    "flagProcedure" => "",
                    "flagProcedureDesc" => "",

                    "kdPenunjang" => "",
                    "kdPenunjangDesc" => "",

                    "assesmentPel" => "",
                    "assesmentPelDesc" => "",
                    "skdp" =>  [
                        "noSurat" => "", //disi ketika wire model dan JenisKunjunganId == 3
                        "kodeDPJP" => "", //tidak di isi jika jenis kunjungan selain KONTROL
                    ],
                    "dpjpLayan" =>  "", //(tidak diisi jika jnsPelayanan = "1" (RANAP),
                    "dpjpLayanNama" => "", //(tidak diisi jika jnsPelayanan = "1" (RANAP),
                    "noTelp" => "" . $dataRefPeserta['peserta']['mr']['noTelepon'] . "",
                    "user" => "sirus App",
                ],
            ],
        ];
    }
    /////////////////////////////////////////////////
    // Lov dataRefBPJSLov //////////////////////
    ////////////////////////////////////////////////


    /////////////////////////////////////////////////
    // Lov dataDokterBPJSSEP //////////////////////
    ////////////////////////////////////////////////
    public function clickdataDokterBPJSlov()
    {
        $this->dataDokterBPJSLovStatus = true;
        $this->dataDokterBPJSLov = [];
    }

    public function updateddataDokterBPJSlovsearch()
    {
        // Variable Search
        $search = $this->dataDokterBPJSLovSearch;

        // check LOV by dr_id rs id
        $dataDokterBPJS = DB::table('rsmst_doctors')->select(
            'rsmst_doctors.dr_id as dr_id',
            'rsmst_doctors.dr_name as dr_name',
            'kd_dr_bpjs',

            'rsmst_polis.poli_id as poli_id',
            'rsmst_polis.poli_desc as poli_desc',
            'kd_poli_bpjs'
        )
            ->Join('rsmst_polis', 'rsmst_polis.poli_id', 'rsmst_doctors.poli_id')
            ->where('rsmst_doctors.dr_id', $search)
            ->first();

        if ($dataDokterBPJS) {
            // set dokter antrol
            $this->dataDaftarPoliRJ['drId'] = $dataDokterBPJS->dr_id;
            $this->dataDaftarPoliRJ['drDesc'] = $dataDokterBPJS->dr_name;

            $this->dataDaftarPoliRJ['poliId'] = $dataDokterBPJS->poli_id;
            $this->dataDaftarPoliRJ['poliDesc'] = $dataDokterBPJS->poli_desc;

            $this->dataDaftarPoliRJ['kddrbpjs'] = $dataDokterBPJS->kd_dr_bpjs;
            $this->dataDaftarPoliRJ['kdpolibpjs'] = $dataDokterBPJS->kd_poli_bpjs;

            // set dokter sep
            $this->SEPJsonReq['request']['t_sep']['dpjpLayan'] = $dataDokterBPJS->kd_dr_bpjs;
            $this->SEPJsonReq['request']['t_sep']['dpjpLayanNama'] = $dataDokterBPJS->dr_name;
            $this->SEPJsonReq['request']['t_sep']['poli']['tujuan'] = $dataDokterBPJS->kd_poli_bpjs;
            $this->SEPJsonReq['request']['t_sep']['poli']['tujuanNama'] = $dataDokterBPJS->poli_desc;


            $this->dataDokterBPJSLovStatus = false;
            $this->dataDokterBPJSLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->dataDokterBPJSLov = [];
            } else {
                $this->dataDokterBPJSLov = json_decode(
                    DB::table('rsmst_doctors')->select(
                        'rsmst_doctors.dr_id as dr_id',
                        'rsmst_doctors.dr_name as dr_name',
                        'kd_dr_bpjs',

                        'rsmst_polis.poli_id as poli_id',
                        'rsmst_polis.poli_desc as poli_desc',
                        'kd_poli_bpjs'

                    )
                        ->Join('rsmst_polis', 'rsmst_polis.poli_id', 'rsmst_doctors.poli_id')

                        ->where('rsmst_doctors.active_status', '1')
                        ->Where(DB::raw('upper(dr_name)'), 'like', '%' . strtoupper($search) . '%')
                        ->orWhere('poli_desc', 'like', '%' . strtoupper($search) . '%')
                        ->limit(10)
                        ->orderBy('dr_name', 'ASC')
                        ->orderBy('poli_desc', 'ASC')
                        ->get(),
                    true
                );
            }
            $this->dataDokterBPJSLovStatus = true;
            // set dokter antrol

            $this->dataDaftarPoliRJ['drId'] = '';
            $this->dataDaftarPoliRJ['drDesc'] = '';
            $this->dataDaftarPoliRJ['poliId'] = '';
            $this->dataDaftarPoliRJ['poliDesc'] = '';
            $this->dataDaftarPoliRJ['kddrbpjs'] = '';
            $this->dataDaftarPoliRJ['kdpolibpjs'] = '';

            // set dokter sep
            $this->SEPJsonReq['request']['t_sep']['dpjpLayan'] = '';
            $this->SEPJsonReq['request']['t_sep']['dpjpLayanNama'] = '';
            $this->SEPJsonReq['request']['t_sep']['poli']['tujuan'] = '';
            $this->SEPJsonReq['request']['t_sep']['poli']['tujuanNama'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataDokterBPJSLov($id, $name)
    {
        $dataDokterBPJS = DB::table('rsmst_doctors')->select(
            'rsmst_doctors.dr_id as dr_id',
            'rsmst_doctors.dr_name as dr_name',
            'kd_dr_bpjs',

            'rsmst_polis.poli_id as poli_id',
            'rsmst_polis.poli_desc as poli_desc',
            'kd_poli_bpjs'
        )
            ->Join('rsmst_polis', 'rsmst_polis.poli_id', 'rsmst_doctors.poli_id')
            ->where('rsmst_doctors.dr_id', $id)
            ->first();

        // set dokter antrol
        $this->dataDaftarPoliRJ['drId'] = $dataDokterBPJS->dr_id;
        $this->dataDaftarPoliRJ['drDesc'] = $dataDokterBPJS->dr_name;

        $this->dataDaftarPoliRJ['poliId'] = $dataDokterBPJS->poli_id;
        $this->dataDaftarPoliRJ['poliDesc'] = $dataDokterBPJS->poli_desc;

        $this->dataDaftarPoliRJ['kddrbpjs'] = $dataDokterBPJS->kd_dr_bpjs;
        $this->dataDaftarPoliRJ['kdpolibpjs'] = $dataDokterBPJS->kd_poli_bpjs;

        // set dokter sep
        $this->SEPJsonReq['request']['t_sep']['dpjpLayan'] = $dataDokterBPJS->kd_dr_bpjs;

        // ketika post inap
        if ($this->dataDaftarPoliRJ['postInap']) {
            $this->SEPJsonReq['request']['t_sep']['skdp']['kodeDPJP'] = $dataDokterBPJS->kd_dr_bpjs;
        }
        $this->SEPJsonReq['request']['t_sep']['kodeDPJP']['dpjpLayanNama'] = $dataDokterBPJS->dr_name;
        $this->SEPJsonReq['request']['t_sep']['poli']['tujuan'] = $dataDokterBPJS->kd_poli_bpjs;
        $this->SEPJsonReq['request']['t_sep']['poli']['tujuanNama'] = $dataDokterBPJS->poli_desc;


        $this->dataDokterBPJSLovStatus = false;
        $this->dataDokterBPJSLovSearch = '';
    }
    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataDokterRJ //////////////////////
    ////////////////////////////////////////////////


    /////////////////////////////////////////////////
    // Lov dataDiagnosaBPJSSEP //////////////////////
    ////////////////////////////////////////////////
    public function clickdataDiagnosaBPJSlov()
    {
        $this->dataDiagnosaBPJSLovStatus = true;
        $this->dataDiagnosaBPJSLov = [];
    }

    public function updateddataDiagnosaBPJSlovsearch()
    {
        // Variable Search
        $search = $this->dataDiagnosaBPJSLovSearch;

        // check LOV by dr_id rs id
        $dataDiagnosaBPJS = DB::table('rsmst_mstdiags')->select(
            'diag_id',
            'diag_desc',
            'icdx',
        )
            ->where('diag_id', $search)
            ->first();

        if ($dataDiagnosaBPJS) {

            // set dokter sep
            $this->SEPJsonReq['request']['t_sep']['diagAwal'] = $dataDiagnosaBPJS->icdx;
            $this->SEPJsonReq['request']['t_sep']['diagAwalNama'] = $dataDiagnosaBPJS->diag_desc;


            $this->dataDiagnosaBPJSLovStatus = false;
            $this->dataDiagnosaBPJSLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->dataDiagnosaBPJSLov = [];
            } else {
                $this->dataDiagnosaBPJSLov = json_decode(
                    DB::table('rsmst_mstdiags')->select(
                        'diag_id',
                        'diag_desc',
                        'icdx',
                    )

                        ->Where(DB::raw('upper(diag_desc)'), 'like', '%' . strtoupper($search) . '%')
                        ->orWhere(DB::raw('upper(icdx)'), 'like', '%' . strtoupper($search) . '%')
                        ->limit(10)
                        ->orderBy('diag_id', 'ASC')
                        ->orderBy('diag_desc', 'ASC')
                        ->get(),
                    true
                );
            }
            $this->dataDiagnosaBPJSLovStatus = true;
            // set dokter sep
            $this->SEPJsonReq['request']['t_sep']['diagAwal'] = '';
            $this->SEPJsonReq['request']['t_sep']['diagAwalNama'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataDiagnosaBPJSLov($id, $name)
    {
        $dataDiagnosaBPJS = DB::table('rsmst_mstdiags')->select(
            'diag_id',
            'diag_desc',
            'icdx',
        )
            ->where('diag_id', $id)
            ->first();

        // set dokter sep
        $this->SEPJsonReq['request']['t_sep']['diagAwal'] = $dataDiagnosaBPJS->icdx;
        $this->SEPJsonReq['request']['t_sep']['diagAwalNama'] = $dataDiagnosaBPJS->diag_desc;


        $this->dataDiagnosaBPJSLovStatus = false;
        $this->dataDiagnosaBPJSLovSearch = '';
    }
    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataDiagnosaRJ //////////////////////
    ////////////////////////////////////////////////


    // logic flagProcedure???
    // public function settujuanKunj($id, $name)
    // {
    //     $this->SEPJsonReq['request']['t_sep']['tujuanKunj'] = $this->JenisKunjungan['JenisKunjunganId'] == 2 || $this->JenisKunjungan['JenisKunjunganId'] == 3 ? $id : "";
    //     $this->SEPJsonReq['request']['t_sep']['tujuanKunjDesc'] = $this->JenisKunjungan['JenisKunjunganId'] == 2 || $this->JenisKunjungan['JenisKunjunganId'] == 3 ? $name : "";
    // }

    // public function setflagProcedure($id, $name)
    // {
    //     $this->SEPJsonReq['request']['t_sep']['flagProcedure'] = $this->SEPJsonReq['request']['t_sep']['tujuanKunj'] == 0 ? "" : $id;
    //     $this->SEPJsonReq['request']['t_sep']['flagProcedureDesc'] =  $this->SEPJsonReq['request']['t_sep']['tujuanKunj'] == 0 ? "" : $name;
    // }
    // public function setkdPenunjang($id, $name)
    // {
    //     $this->SEPJsonReq['request']['t_sep']['kdPenunjang'] = $this->SEPJsonReq['request']['t_sep']['tujuanKunj'] == 0 ? "" : $id;
    //     $this->SEPJsonReq['request']['t_sep']['kdPenunjangDesc'] = $this->SEPJsonReq['request']['t_sep']['tujuanKunj'] == 0 ? "" : $name;
    // }
    // public function setassesmentPel($id, $name)
    // {
    //     $this->SEPJsonReq['request']['t_sep']['assesmentPel'] = $this->SEPJsonReq['request']['t_sep']['tujuanKunj'] == 0 || $this->SEPJsonReq['request']['t_sep']['tujuanKunj'] == 2 ? $id : "";
    //     $this->SEPJsonReq['request']['t_sep']['assesmentPelDesc'] = $this->SEPJsonReq['request']['t_sep']['tujuanKunj'] == 0 || $this->SEPJsonReq['request']['t_sep']['tujuanKunj'] == 2 ? $name : "";
    // }

    public function settujuanKunj($id, $name)
    {
        $this->SEPJsonReq['request']['t_sep']['tujuanKunj'] = $id;
        $this->SEPJsonReq['request']['t_sep']['tujuanKunjDesc'] = $name;
    }

    public function setflagProcedure($id, $name)
    {
        $this->SEPJsonReq['request']['t_sep']['flagProcedure'] = $id;
        $this->SEPJsonReq['request']['t_sep']['flagProcedureDesc'] = $name;
    }
    public function setkdPenunjang($id, $name)
    {
        $this->SEPJsonReq['request']['t_sep']['kdPenunjang'] = $id;
        $this->SEPJsonReq['request']['t_sep']['kdPenunjangDesc'] = $name;
    }
    public function setassesmentPel($id, $name)
    {
        $this->SEPJsonReq['request']['t_sep']['assesmentPel'] = $id;
        $this->SEPJsonReq['request']['t_sep']['assesmentPelDesc'] = $name;
    }

    public function cetakSEP()
    {
        // cek BPJS atau bukan
        if ($this->JenisKlaim['JenisKlaimId'] != 'JM') {
            $this->emit('toastr-error', 'Jenis Klaim ' . $this->JenisKlaim['JenisKlaimDesc']);
        } else {
            // cek ada resSep ada atau tidak
            if (!$this->dataDaftarPoliRJ['sep']['resSep']) {

                // Http cek sep by no SEP
                //////////////////////////////////////////////
                $HttpGetBpjs =  VclaimTrait::sep_nomor($this->dataDaftarPoliRJ['sep']['noSep'])->getOriginalContent();

                if ($HttpGetBpjs['metadata']['code'] == 200) {

                    $this->dataDaftarPoliRJ['sep']['resSep'] = $HttpGetBpjs['response'];
                    $this->dataDaftarPoliRJ['sep']['noSep'] = $HttpGetBpjs['response']['noSep'];

                    // update database
                    DB::table('rstxn_rjhdrs')
                        ->where('rj_no', $this->dataDaftarPoliRJ['rjNo'])
                        ->update([
                            'datadaftarpolirj_json' => json_encode($this->dataDaftarPoliRJ, true),
                            'datadaftarpolirj_xml' => ArrayToXml::convert($this->dataDaftarPoliRJ),
                        ]);


                    $this->emit('toastr-success', 'CetakSEP ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                } else {
                    $this->emit('toastr-error', 'CetakSEP ' . $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                }
            } else {

                // cetak PDF
                $data = [
                    'data' => $this->dataDaftarPoliRJ['sep']['resSep'],
                    'reqData' => $this->dataDaftarPoliRJ['sep']['reqSep'],

                ];
                $pdfContent = PDF::loadView('livewire.daftar-r-j.cetak-sep', $data)->output();
                $this->emit('toastr-success', 'CetakSEP');

                return response()->streamDownload(
                    fn() => print($pdfContent),
                    "filename.pdf"
                );
            }
        }
    }




    // callFormPasien
    public function callFormPasien(): void
    {
        // set Call MasterPasien True
        $this->callMasterPasien = true;
    }

    public function callRJskdp(): void
    {
        // set Call RJskdp True
        if ($this->dataDaftarPoliRJ['regNo']) {
            $this->callRJskdp = true;
        } else {
            $this->emit('toastr-error', "Data Tidak dapat di proses (Reg No Pasien Kosong)");
        }
    }



    // when new form instance
    public function mount()
    {

        // set date
        $this->dateRjRef = Carbon::now()->format('d/m/Y');
        // set shift
        $findShift = DB::table('rstxn_shiftctls')->select('shift')
            ->whereRaw("'" . Carbon::now()->format('H:i:s') . "' between shift_start and shift_end")
            ->first();
        $this->shiftRjRef['shiftId'] = isset($findShift->shift) && $findShift->shift ? $findShift->shift : 3;
        $this->shiftRjRef['shiftDesc'] = isset($findShift->shift) && $findShift->shift ? $findShift->shift : 3;
        // set data dokter ref
        $this->optionsdrRjRef();
    }




    // select data start////////////////
    public function render()
    {

        // render drRjRef
        // set data dokter ref
        $this->optionsdrRjRef();

        //////////////////////////////////////////
        // Query ///////////////////////////////
        //////////////////////////////////////////
        $query = DB::table('rsview_rjkasir')
            ->select(
                DB::raw("to_char(rj_date,'dd/mm/yyyy hh24:mi:ss') AS rj_date"),
                DB::raw("to_char(rj_date,'yyyymmddhh24miss') AS rj_date1"),
                'rj_no',
                'reg_no',
                'reg_name',
                'sex',
                'address',
                'thn',
                DB::raw("to_char(birth_date,'dd/mm/yyyy') AS birth_date"),
                'poli_id',
                'poli_desc',
                'dr_id',
                'dr_name',
                'klaim_id',
                'shift',
                'vno_sep',
                'no_antrian',
                'rj_status',
                'nobooking',
                'push_antrian_bpjs_status',
                'push_antrian_bpjs_json'
            )
            ->where('rj_status', '=', $this->statusRjRef['statusId'])
            ->where('shift', '=', $this->shiftRjRef['shiftId'])
            ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', $this->dateRjRef);

        //Jika where dokter tidak kosong
        if ($this->drRjRef['drId'] != 'All') {
            $query->where('dr_id', $this->drRjRef['drId']);
        }

        $query->where(function ($q) {
            $q->Where(DB::raw('upper(reg_name)'), 'like', '%' . strtoupper($this->search) . '%')
                ->orWhere(DB::raw('upper(reg_no)'), 'like', '%' . strtoupper($this->search) . '%')
                ->orWhere(DB::raw('upper(dr_name)'), 'like', '%' . strtoupper($this->search) . '%')
                ->orWhere(DB::raw('upper(poli_desc)'), 'like', '%' . strtoupper($this->search) . '%');
        })
            ->orderBy('dr_name',  'desc')
            ->orderBy('poli_desc',  'desc')
            ->orderBy('no_antrian',  'asc')
            ->orderBy('rj_date1',  'desc');

        ////////////////////////////////////////////////
        // end Query
        ///////////////////////////////////////////////



        return view(
            'livewire.daftar-r-j.daftar-r-j',
            [
                'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Data Pasien Rawat Jalan',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
                'myLimitPerPages' => [5, 10, 15, 20, 100],
            ]
        );
    }
    // select data end////////////////


}
