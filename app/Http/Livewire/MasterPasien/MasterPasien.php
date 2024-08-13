<?php

namespace App\Http\Livewire\MasterPasien;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Spatie\ArrayToXml\ArrayToXml;
use Carbon\Carbon;

use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\BPJS\VclaimTrait;
use App\Http\Traits\BPJS\SatuSehatTrait;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class MasterPasien extends Component
{
    use WithPagination, customErrorMessagesTrait, VclaimTrait;


    //  table data//////////////// reser
    public $dataPasien = [
        "pasien" => [
            "pasientidakdikenal" => [],  //status pasien tdak dikenal 0 false 1 true
            "regNo" => "", //harus diisi
            "gelarDepan" => "",
            "regName" => "", //harus diisi / (Sesuai KTP)
            "gelarBelakang" => "",
            "namaPanggilan" => "",
            "tempatLahir" => "", //harus diisi
            "tglLahir" => "", //harus diisi / (dd/mm/yyyy)
            "thn" => "",
            "bln" => "",
            "hari" => "",
            "jenisKelamin" => [ //harus diisi (saveid)
                "jenisKelaminId" => 1,
                "jenisKelaminDesc" => "Laki-laki",
                "jenisKelaminOptions" => [
                    ["jenisKelaminId" => 0, "jenisKelaminDesc" => "Tidak diketaui"],
                    ["jenisKelaminId" => 1, "jenisKelaminDesc" => "Laki-laki"],
                    ["jenisKelaminId" => 2, "jenisKelaminDesc" => "Perempuan"],
                    ["jenisKelaminId" => 3, "jenisKelaminDesc" => "Tidak dapat di tentukan"],
                    ["jenisKelaminId" => 4, "jenisKelaminDesc" => "Tidak Mengisi"],
                ],
            ],
            "agama" => [ //harus diisi (save id+nama)
                "agamaId" => "1",
                "agamaDesc" => "Islam",
                "agamaOptions" => [
                    ["agamaId" => 1, "agamaDesc" => "Islam"],
                    ["agamaId" => 2, "agamaDesc" => "Kristen (Protestan)"],
                    ["agamaId" => 3, "agamaDesc" => "Katolik"],
                    ["agamaId" => 4, "agamaDesc" => "Hindu"],
                    ["agamaId" => 5, "agamaDesc" => "Budha"],
                    ["agamaId" => 6, "agamaDesc" => "Konghucu"],
                    ["agamaId" => 7, "agamaDesc" => "Penghayat"],
                    ["agamaId" => 8, "agamaDesc" => "Lain-lain"], //Free text
                ],
            ],
            "statusPerkawinan" => [ //harus diisi (save id)
                "statusPerkawinanId" => "1",
                "statusPerkawinanDesc" => "Belum Kawin",
                "statusPerkawinanOptions" => [
                    ["statusPerkawinanId" => 1, "statusPerkawinanDesc" => "Belum Kawin"],
                    ["statusPerkawinanId" => 2, "statusPerkawinanDesc" => "Kawin"],
                    ["statusPerkawinanId" => 3, "statusPerkawinanDesc" => "Cerai Hidup"],
                    ["statusPerkawinanId" => 4, "statusPerkawinanDesc" => "Cerai Mati"],
                ],
            ],
            "pendidikan" =>  [ //harus diisi (save id)
                "pendidikanId" => "3",
                "pendidikanDesc" => "SLTA Sederajat",
                "pendidikanOptions" => [
                    ["pendidikanId" => 0, "pendidikanDesc" => "Tidak Sekolah"],
                    ["pendidikanId" => 1, "pendidikanDesc" => "SD"],
                    ["pendidikanId" => 2, "pendidikanDesc" => "SLTP Sederajat"],
                    ["pendidikanId" => 3, "pendidikanDesc" => "SLTA Sederajat"],
                    ["pendidikanId" => 4, "pendidikanDesc" => "D1-D3"],
                    ["pendidikanId" => 5, "pendidikanDesc" => "D4"],
                    ["pendidikanId" => 6, "pendidikanDesc" => "S1"],
                    ["pendidikanId" => 7, "pendidikanDesc" => "S2"],
                    ["pendidikanId" => 8, "pendidikanDesc" => "S3"],
                ],
            ],
            "pekerjaan" => [ //harus diisi (save id)
                "pekerjaanId" => "4",
                "pekerjaanDesc" => "Pegawai Swasta/ Wiraswasta",
                "pekerjaanOptions" => [
                    ["pekerjaanId" => 0, "pekerjaanDesc" => "Tidak Bekerja"],
                    ["pekerjaanId" => 1, "pekerjaanDesc" => "PNS"],
                    ["pekerjaanId" => 2, "pekerjaanDesc" => "TNI/POLRI"],
                    ["pekerjaanId" => 3, "pekerjaanDesc" => "BUMN"],
                    ["pekerjaanId" => 4, "pekerjaanDesc" => "Pegawai Swasta/ Wiraswasta"],
                    ["pekerjaanId" => 5, "pekerjaanDesc" => "Lain-Lain"], //Free text
                ],
            ],
            "golonganDarah" => [ //harus diisi (save id+nama) (default Tidak Tahu)
                "golonganDarahId" => "13",
                "golonganDarahDesc" => "Tidak Tahu",
                "golonganDarahOptions" => [
                    ["golonganDarahId" => 1, "golonganDarahDesc" => "A"],
                    ["golonganDarahId" => 2, "golonganDarahDesc" => "B"],
                    ["golonganDarahId" => 3, "golonganDarahDesc" => "AB"],
                    ["golonganDarahId" => 4, "golonganDarahDesc" => "O"],
                    ["golonganDarahId" => 5, "golonganDarahDesc" => "A+"],
                    ["golonganDarahId" => 6, "golonganDarahDesc" => "A-"],
                    ["golonganDarahId" => 7, "golonganDarahDesc" => "B+"],
                    ["golonganDarahId" => 8, "golonganDarahDesc" => "B-"],
                    ["golonganDarahId" => 9, "golonganDarahDesc" => "AB+"],
                    ["golonganDarahId" => 10, "golonganDarahDesc" => "AB-"],
                    ["golonganDarahId" => 11, "golonganDarahDesc" => "O+"],
                    ["golonganDarahId" => 12, "golonganDarahDesc" => "O-"],
                    ["golonganDarahId" => 13, "golonganDarahDesc" => "Tidak Tahu"],
                    ["golonganDarahId" => 14, "golonganDarahDesc" => "O Rhesus"],
                    ["golonganDarahId" => 15, "golonganDarahDesc" => "#"],
                ],
            ],

            "kewarganegaraan" => 'INDONESIA', //Free text (defult INDONESIA)
            "suku" => 'Jawa', //Free text (defult Jawa)
            "bahasa" => 'Indonesia / Jawa', //Free text (defult Indonesia / Jawa)
            "status" => [
                "statusId" => "1",
                "statusDesc" => "Aktif / Hidup",
                "statusOptions" => [
                    ["statusId" => 0, "statusDesc" => "Tidak Aktif / Batal"],
                    ["statusId" => 1, "statusDesc" => "Aktif / Hidup"],
                    ["statusId" => 2, "statusDesc" => "Meninggal"],
                ]
            ],
            "domisil" => [
                "samadgnidentitas" => [], //status samadgn domisil 0 false 1 true (auto entry = domisil)
                "alamat" => "", //harus diisi
                "rt" => "", //harus diisi
                "rw" => "", //harus diisi
                "kodepos" => "", //harus diisi
                "desaId" => "", //harus diisi (Kode data Kemendagri)
                "kecamatanId" => "", //harus diisi (Kode data Kemendagri)
                "kotaId" => "3504", //harus diisi (Kode data Kemendagri)
                "propinsiId" => "35", //harus diisi (Kode data Kemendagri)
                "desaName" => "", //harus diisi (Kode data Kemendagri)
                "kecamatanName" => "", //harus diisi (Kode data Kemendagri)
                "kotaName" => "TULUNGAGUNG", //harus diisi (Kode data Kemendagri)
                "propinsiName" => "JAWA TIMUR", //harus diisi (Kode data Kemendagri)

            ],
            "identitas" => [
                "nik" => "", //harus diisi
                "idbpjs" => "",
                "patientUuid" => "", //UUID SATUSEHAT
                "pasport" => "", //untuk WNA / WNI yang memiliki passport
                "alamat" => "", //harus diisi
                "rt" => "", //harus diisi
                "rw" => "", //harus diisi
                "kodepos" => "", //harus diisi
                "desaId" => "", //harus diisi (Kode data Kemendagri)
                "kecamatanId" => "", //harus diisi (Kode data Kemendagri)
                "kotaId" => "3504", //harus diisi (Kode data Kemendagri)
                "propinsiId" => "35", //harus diisi (Kode data Kemendagri)
                "desaName" => "", //harus diisi (Kode data Kemendagri)
                "kecamatanName" => "", //harus diisi (Kode data Kemendagri)
                "kotaName" => "TULUNGAGUNG", //harus diisi (Kode data Kemendagri)
                "propinsiName" => "JAWA TIMUR", //harus diisi (Kode data Kemendagri)
                "negara" => "ID" //harus diisi (ISO 3166) ID 	IDN 	360 	ISO 3166-2:ID 	.id
            ],
            "kontak" => [
                "kodenegara" => "62", //+(62) Indonesia
                "nomerTelponSelulerPasien" => "", //+(kode negara) no telp
                "nomerTelponLain" => "" //+(kode negara) no telp
            ],
            "hubungan" => [
                "namaAyah" => "", //
                "kodenegaraAyah" => "62", //+(62) Indonesia
                "nomerTelponSelulerAyah" => "", //+(kode negara) no telp
                "namaIbu" => "", //
                "kodenegaraIbu" => "62", //+(62) Indonesia
                "nomerTelponSelulerIbu" => "", //+(kode negara) no telp

                "namaPenanggungJawab" => "", // di isi untuk pasien (Tidak dikenal / Hal Lain)
                "kodenegaraPenanggungJawab" => "62", //+(62) Indonesia
                "nomerTelponSelulerPenanggungJawab" => "", //+(kode negara) no telp
                "hubunganDgnPasien" => [
                    "hubunganDgnPasienId" => 5, //Default 5 Kerabat / Saudara
                    "hubunganDgnPasienDesc" => "Kerabat / Saudara",
                    "hubunganDgnPasienOptions" => [
                        ["hubunganDgnPasienId" => 1, "hubunganDgnPasienDesc" => "Diri Sendiri"],
                        ["hubunganDgnPasienId" => 2, "hubunganDgnPasienDesc" => "Orang Tua"],
                        ["hubunganDgnPasienId" => 3, "hubunganDgnPasienDesc" => "Anak"],
                        ["hubunganDgnPasienId" => 4, "hubunganDgnPasienDesc" => "Suami / Istri"],
                        ["hubunganDgnPasienId" => 5, "hubunganDgnPasienDesc" => "Kerabaat / Saudara"],
                        ["hubunganDgnPasienId" => 6, "hubunganDgnPasienDesc" => "Lain-lain"] //Free text
                    ]
                ]
            ],

        ]
    ];
    public $ruleDataPasien =
    [
        'pasien' => [
            'regNo' => true,
            'gelarDepan' => false,
            'regName' => true,
            'gelarBelakang' => false,
            'namaPanggilan' => false,
            'tempatLahir' => true,
            'tglLahir' => true,
            'thn' => false,
            'bln' => false,
            'hari' => false,

            'jenisKelamin' => [
                'jenisKelaminId' => true,
                'jenisKelaminDesc' => true,
            ],
            'agama' => [
                'agamaId' => true,
                'agamaagamaDesc' => true,
            ],

            'statusPerkawinan' => [
                'statusPerkawinanId' => true,
                'statusPerkawinanDesc' => true,
            ],

            'pendidikan' => [
                'pendidikanId' => true,
                'pendidikanDesc' => true,
            ],

            'pekerjaan' => [
                'pekerjaanId' => true,
                'pekerjaanDesc' => true,
            ],

            'golonganDarah' => [
                'golonganDarahId' => false,
                'golonganDarahDesc' => false,
            ],

            'kewarganegaraan' => true,
            'suku' => false,
            'bahasa' => false,
            'status' => [
                'statusId' => true,
                'statusDesc' => true,
            ],

            'domisil' => [
                'alamat' => true,
                'rt' => true,
                'rw' => true,
                'kodepos' => true,
                'desaId' => true,
                'kecamatanId' => true,
                'kotaId' => true,
                'propinsiId' => true,
                'desaName' => true,
                'kecamatanName' => true,
                'kotaName' => true,
                'propinsiName' => true,
            ],

            'identitas' => [
                'nik' => true,
                'idbpjs' => false,
                'pasport' => false,
                'alamat' => true,
                'rt' => true,
                'rw' => true,
                'kodepos' => true,
                'desaId' => true,
                'kecamatanId' => true,
                'kotaId' => true,
                'propinsiId' => true,
                'desaName' => true,
                'kecamatanName' => true,
                'kotaName' => true,
                'propinsiName' => true,
                'negara' => true,
            ],

            'kontak' => [
                'kodenegara' => true,
                'nomerTelponSelulerPasien' => true,
                'nomerTelponLain' => false,
            ],

            'hubungan' => [
                'namaAyah' => false,
                'kodenegaraAyah' => false,
                'nomerTelponSelulerAyah' => false,

                'namaIbu' => false,
                'kodenegaraIbu' => false,
                'nomerTelponSelulerIbu' => false,

                'namaPenanggungJawab' => true,
                'kodenegaraPenanggungJawab' => true,
                'nomerTelponSelulerPenanggungJawab' => true,
                'hubunganDgnPasien' => [
                    'hubunganDgnPasienId' => true,
                    'hubunganDgnPasienDesc' => true,
                ]
            ]
        ]
    ];

    public $dataPasienBPJS = [];
    public $dataPasienBPJSSearch = "";

    // limit record per page -resetExcept////////////////
    public $limitPerPage = 10;

    //  table LOV////////////////
    public $jenisKelaminLov = [];
    public $jenisKelaminLovStatus = 0;
    public $jenisKelaminLovSearch = '';

    public $agamaLov = [];
    public $agamaLovStatus = 0;
    public $agamaLovSearch = '';

    public $statusPerkawinanLov = [];
    public $statusPerkawinanLovStatus = 0;
    public $statusPerkawinanLovSearch = '';

    public $pendidikanLov = [];
    public $pendidikanLovStatus = 0;
    public $pendidikanLovSearch = '';

    public $pekerjaanLov = [];
    public $pekerjaanLovStatus = 0;
    public $pekerjaanLovSearch = '';

    public $golonganDarahLov = [];
    public $golonganDarahLovStatus = 0;
    public $golonganDarahLovSearch = '';

    public $statusLov = [];
    public $statusLovStatus = 0;
    public $statusLovSearch = '';

    public $hubunganDgnPasienLov = [];
    public $hubunganDgnPasienLovStatus = 0;
    public $hubunganDgnPasienLovSearch = '';

    public $desaIdentitasLov = [];
    public $desaIdentitasLovStatus = 0;
    public $desaIdentitasLovSearch = '';

    public $kotaIdentitasLov = [];
    public $kotaIdentitasLovStatus = 0;
    public $kotaIdentitasLovSearch = '';

    public $desaDomisilLov = [];
    public $desaDomisilLovStatus = 0;
    public $desaDomisilLovSearch = '';

    public $kotaDomisilLov = [];
    public $kotaDomisilLovStatus = 0;
    public $kotaDomisilLovSearch = '';

    //  table LOV////////////////

    //  modal status////////////////
    public $isOpen = 0;
    public $isOpenMode = 'insert';


    // search logic -resetExcept////////////////
    public $search;
    protected $queryString = [
        'search' => ['except' => '', 'as' => 'cariData'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];



    // listener from blade////////////////
    protected $listeners = [
        'confirm_remove_record_pasiens' => 'delete',
    ];




    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////





    // resert semu input  kecuali////////////////
    private function resetInputFields(): void
    {
        // resert validation
        $this->resetValidation();
        // resert input
        $this->resetExcept([
            'limitPerPage',
            'search',

        ]);
    }




    // open and close modal start////////////////
    private function openModal(): void
    {
        $this->resetInputFields();
        $this->isOpen = true;
        $this->isOpenMode = 'insert';
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

    public function closeModal()
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




    // resert page pagination when coloumn search change ////////////////
    public function updatedSearch(): void
    {
        $this->resetPage();
        $this->resetValidation();
    }






    // logic LOV start////////////////
    // jenis kelamin LOV

    // /////////Jeniskelamin////////////
    public function clickJeniskelaminlov()
    {
        $this->jenisKelaminLovStatus = true;
        $this->jenisKelaminLov = $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminOptions'];
    }
    public function updatedJeniskelaminlovsearch()
    {
        // Variable Search
        $search = $this->jenisKelaminLovSearch;

        // check LOV by id
        $Jeniskelamin = collect($this->dataPasien['pasien']['jenisKelamin']['jenisKelaminOptions'])
            ->where('jenisKelaminId', '=', $search)
            ->first();

        if ($Jeniskelamin) {
            $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] = $Jeniskelamin['jenisKelaminId'];
            $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] = $Jeniskelamin['jenisKelaminDesc'];
            $this->jenisKelaminLovStatus = false;
            $this->jenisKelaminLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->jenisKelaminLov = $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminOptions'];
            } else {
                $this->jenisKelaminLov = collect($this->dataPasien['pasien']['jenisKelamin']['jenisKelaminOptions'])
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['jenisKelaminDesc'], $search);
                    });
            }
            $this->jenisKelaminLovStatus = true;
            $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] = '';
            $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMyjenisKelaminLov($id, $name)
    {
        $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] = $id;
        $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] = $name;
        $this->jenisKelaminLovStatus = false;
        $this->jenisKelaminLovSearch = '';
    }
    // LOV selected end
    // /////////////////////


    // /////////Agama////////////
    public function clickagamalov()
    {
        $this->agamaLovStatus = true;
        $this->agamaLov = $this->dataPasien['pasien']['agama']['agamaOptions'];
    }
    public function updatedagamalovsearch()
    {
        // Variable Search
        $search = $this->agamaLovSearch;

        // check LOV by id
        $agama = collect($this->dataPasien['pasien']['agama']['agamaOptions'])
            ->where('agamaId', '=', $search)
            ->first();

        if ($agama) {
            $this->dataPasien['pasien']['agama']['agamaId'] = $agama['agamaId'];
            $this->dataPasien['pasien']['agama']['agamaDesc'] = $agama['agamaDesc'];
            $this->agamaLovStatus = false;
            $this->agamaLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->agamaLov = $this->dataPasien['pasien']['agama']['agamaOptions'];
            } else {
                $this->agamaLov = collect($this->dataPasien['pasien']['agama']['agamaOptions'])
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['agamaDesc'], $search);
                    });
            }
            $this->agamaLovStatus = true;
            $this->dataPasien['pasien']['agama']['agamaId'] = '';
            $this->dataPasien['pasien']['agama']['agamaDesc'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMyagamaLov($id, $name)
    {
        $this->dataPasien['pasien']['agama']['agamaId'] = $id;
        $this->dataPasien['pasien']['agama']['agamaDesc'] = $name;
        $this->agamaLovStatus = false;
        $this->agamaLovSearch = '';
    }
    // LOV selected end
    // /////////////////////

    // /////////statusPerkawinan////////////
    public function clickstatusPerkawinanlov()
    {
        $this->statusPerkawinanLovStatus = true;
        $this->statusPerkawinanLov = $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanOptions'];
    }
    public function updatedstatusPerkawinanlovsearch()
    {
        // Variable Search
        $search = $this->statusPerkawinanLovSearch;

        // check LOV by id
        $statusPerkawinan = collect($this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanOptions'])
            ->where('statusPerkawinanId', '=', $search)
            ->first();

        if ($statusPerkawinan) {
            $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanId'] = $statusPerkawinan['statusPerkawinanId'];
            $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanDesc'] = $statusPerkawinan['statusPerkawinanDesc'];
            $this->statusPerkawinanLovStatus = false;
            $this->statusPerkawinanLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->statusPerkawinanLov = $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanOptions'];
            } else {
                $this->statusPerkawinanLov = collect($this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanOptions'])
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['statusPerkawinanDesc'], $search);
                    });
            }
            $this->statusPerkawinanLovStatus = true;
            $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanId'] = '';
            $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanDesc'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMystatusPerkawinanLov($id, $name)
    {
        $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanId'] = $id;
        $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanDesc'] = $name;
        $this->statusPerkawinanLovStatus = false;
        $this->statusPerkawinanLovSearch = '';
    }
    // LOV selected end
    // /////////////////////

    // /////////pendidikan////////////
    public function clickpendidikanlov()
    {
        $this->pendidikanLovStatus = true;
        $this->pendidikanLov = $this->dataPasien['pasien']['pendidikan']['pendidikanOptions'];
    }
    public function updatedpendidikanlovsearch()
    {
        // Variable Search
        $search = $this->pendidikanLovSearch;

        // check LOV by id
        $pendidikan = collect($this->dataPasien['pasien']['pendidikan']['pendidikanOptions'])
            ->where('pendidikanId', '=', $search)
            ->first();

        if ($pendidikan) {
            $this->dataPasien['pasien']['pendidikan']['pendidikanId'] = $pendidikan['pendidikanId'];
            $this->dataPasien['pasien']['pendidikan']['pendidikanDesc'] = $pendidikan['pendidikanDesc'];
            $this->pendidikanLovStatus = false;
            $this->pendidikanLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->pendidikanLov = $this->dataPasien['pasien']['pendidikan']['pendidikanOptions'];
            } else {
                $this->pendidikanLov = collect($this->dataPasien['pasien']['pendidikan']['pendidikanOptions'])
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['pendidikanDesc'], $search);
                    });
            }
            $this->pendidikanLovStatus = true;
            $this->dataPasien['pasien']['pendidikan']['pendidikanId'] = '';
            $this->dataPasien['pasien']['pendidikan']['pendidikanDesc'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMypendidikanLov($id, $name)
    {
        $this->dataPasien['pasien']['pendidikan']['pendidikanId'] = $id;
        $this->dataPasien['pasien']['pendidikan']['pendidikanDesc'] = $name;
        $this->pendidikanLovStatus = false;
        $this->pendidikanLovSearch = '';
    }
    // LOV selected end
    // /////////////////////

    // /////////pekerjaan////////////
    public function clickpekerjaanlov()
    {
        $this->pekerjaanLovStatus = true;
        $this->pekerjaanLov = $this->dataPasien['pasien']['pekerjaan']['pekerjaanOptions'];
    }
    public function updatedpekerjaanlovsearch()
    {
        // Variable Search
        $search = $this->pekerjaanLovSearch;

        // check LOV by id
        $pekerjaan = collect($this->dataPasien['pasien']['pekerjaan']['pekerjaanOptions'])
            ->where('pekerjaanId', '=', $search)
            ->first();

        if ($pekerjaan) {
            $this->dataPasien['pasien']['pekerjaan']['pekerjaanId'] = $pekerjaan['pekerjaanId'];
            $this->dataPasien['pasien']['pekerjaan']['pekerjaanDesc'] = $pekerjaan['pekerjaanDesc'];
            $this->pekerjaanLovStatus = false;
            $this->pekerjaanLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->pekerjaanLov = $this->dataPasien['pasien']['pekerjaan']['pekerjaanOptions'];
            } else {
                $this->pekerjaanLov = collect($this->dataPasien['pasien']['pekerjaan']['pekerjaanOptions'])
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['pekerjaanDesc'], $search);
                    });
            }
            $this->pekerjaanLovStatus = true;
            $this->dataPasien['pasien']['pekerjaan']['pekerjaanId'] = '';
            $this->dataPasien['pasien']['pekerjaan']['pekerjaanDesc'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMypekerjaanLov($id, $name)
    {
        $this->dataPasien['pasien']['pekerjaan']['pekerjaanId'] = $id;
        $this->dataPasien['pasien']['pekerjaan']['pekerjaanDesc'] = $name;
        $this->pekerjaanLovStatus = false;
        $this->pekerjaanLovSearch = '';
    }
    // LOV selected end
    // /////////////////////

    // /////////golonganDarah////////////
    public function clickgolonganDarahlov()
    {
        $this->golonganDarahLovStatus = true;
        $this->golonganDarahLov = $this->dataPasien['pasien']['golonganDarah']['golonganDarahOptions'];
    }
    public function updatedgolonganDarahlovsearch()
    {
        // Variable Search
        $search = $this->golonganDarahLovSearch;

        // check LOV by id
        $golonganDarah = collect($this->dataPasien['pasien']['golonganDarah']['golonganDarahOptions'])
            ->where('golonganDarahId', '=', $search)
            ->first();

        if ($golonganDarah) {
            $this->dataPasien['pasien']['golonganDarah']['golonganDarahId'] = $golonganDarah['golonganDarahId'];
            $this->dataPasien['pasien']['golonganDarah']['golonganDarahDesc'] = $golonganDarah['golonganDarahDesc'];
            $this->golonganDarahLovStatus = false;
            $this->golonganDarahLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->golonganDarahLov = $this->dataPasien['pasien']['golonganDarah']['golonganDarahOptions'];
            } else {
                $this->golonganDarahLov = collect($this->dataPasien['pasien']['golonganDarah']['golonganDarahOptions'])
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['golonganDarahDesc'], $search);
                    });
            }
            $this->golonganDarahLovStatus = true;
            $this->dataPasien['pasien']['golonganDarah']['golonganDarahId'] = '';
            $this->dataPasien['pasien']['golonganDarah']['golonganDarahDesc'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMygolonganDarahLov($id, $name)
    {
        $this->dataPasien['pasien']['golonganDarah']['golonganDarahId'] = $id;
        $this->dataPasien['pasien']['golonganDarah']['golonganDarahDesc'] = $name;
        $this->golonganDarahLovStatus = false;
        $this->golonganDarahLovSearch = '';
    }
    // LOV selected end
    // /////////////////////

    // /////////status////////////
    public function clickstatuslov()
    {
        $this->statusLovStatus = true;
        $this->statusLov = $this->dataPasien['pasien']['status']['statusOptions'];
    }
    public function updatedstatuslovsearch()
    {
        // Variable Search
        $search = $this->statusLovSearch;

        // check LOV by id
        $status = collect($this->dataPasien['pasien']['status']['statusOptions'])
            ->where('statusId', '=', $search)
            ->first();

        if ($status) {
            $this->dataPasien['pasien']['status']['statusId'] = $status['statusId'];
            $this->dataPasien['pasien']['status']['statusDesc'] = $status['statusDesc'];
            $this->statusLovStatus = false;
            $this->statusLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->statusLov = $this->dataPasien['pasien']['status']['statusOptions'];
            } else {
                $this->statusLov = collect($this->dataPasien['pasien']['status']['statusOptions'])
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['statusDesc'], $search);
                    });
            }
            $this->statusLovStatus = true;
            $this->dataPasien['pasien']['status']['statusId'] = '';
            $this->dataPasien['pasien']['status']['statusDesc'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMystatusLov($id, $name)
    {
        $this->dataPasien['pasien']['status']['statusId'] = $id;
        $this->dataPasien['pasien']['status']['statusDesc'] = $name;
        $this->statusLovStatus = false;
        $this->statusLovSearch = '';
    }
    // LOV selected end
    // /////////////////////

    // /////////hubunganDgnPasien////////////
    public function clickhubunganDgnPasienlov()
    {
        $this->hubunganDgnPasienLovStatus = true;
        $this->hubunganDgnPasienLov = $this->dataPasien['pasien']['hubungan']['hubunganDgnPasien']['hubunganDgnPasienOptions'];
    }
    public function updatedhubunganDgnPasienlovsearch()
    {
        // Variable Search
        $search = $this->hubunganDgnPasienLovSearch;

        // check LOV by id
        $hubunganDgnPasien = collect($this->dataPasien['pasien']['hubungan']['hubunganDgnPasien']['hubunganDgnPasienOptions'])
            ->where('hubunganDgnPasienId', '=', $search)
            ->first();

        if ($hubunganDgnPasien) {
            $this->dataPasien['pasien']['hubungan']['hubunganDgnPasien']['hubunganDgnPasienId'] = $hubunganDgnPasien['hubunganDgnPasienId'];
            $this->dataPasien['pasien']['hubungan']['hubunganDgnPasien']['hubunganDgnPasienDesc'] = $hubunganDgnPasien['hubunganDgnPasienDesc'];
            $this->hubunganDgnPasienLovStatus = false;
            $this->hubunganDgnPasienLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->hubunganDgnPasienLov = $this->dataPasien['pasien']['hubungan']['hubunganDgnPasien']['hubunganDgnPasienOptions'];
            } else {
                $this->hubunganDgnPasienLov = collect($this->dataPasien['pasien']['hubungan']['hubunganDgnPasien']['hubunganDgnPasienOptions'])
                    ->filter(function ($item) use ($search) {
                        return false !== stristr($item['hubunganDgnPasienDesc'], $search);
                    });
            }
            $this->hubunganDgnPasienLovStatus = true;
            $this->dataPasien['pasien']['hubungan']['hubunganDgnPasien']['hubunganDgnPasienId'] = '';
            $this->dataPasien['pasien']['hubungan']['hubunganDgnPasien']['hubunganDgnPasienDesc'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMyhubunganDgnPasienLov($id, $name)
    {
        $this->dataPasien['pasien']['hubungan']['hubunganDgnPasien']['hubunganDgnPasienId'] = $id;
        $this->dataPasien['pasien']['hubungan']['hubunganDgnPasien']['hubunganDgnPasienDesc'] = $name;
        $this->hubunganDgnPasienLovStatus = false;
        $this->hubunganDgnPasienLovSearch = '';
    }
    // LOV selected end
    // /////////////////////

    // /////////desaIdentitas////////////
    public function clickdesaIdentitaslov()
    {
        $this->desaIdentitasLovStatus = true;
        $this->desaIdentitasLov = [];
    }
    public function updatedDesaidentitaslovsearch()
    {
        // Variable Search
        $search = $this->desaIdentitasLovSearch;

        // check LOV by id
        $desaIdentitas = DB::table('rsmst_desas')
            ->select(
                'rsmst_desas.des_id  as des_id',
                'rsmst_kecamatans.kec_id  as kec_id',
                'rsmst_kabupatens.kab_id  as kab_id',
                'rsmst_propinsis.prop_id  as prop_id',
                'des_name  as des_name',
                'kec_name  as kec_name',
                'kab_name  as kab_name',
                'prop_name  as prop_name',

            )->join('rsmst_kecamatans', 'rsmst_kecamatans.kec_id', 'rsmst_desas.kec_id')
            ->join('rsmst_kabupatens', 'rsmst_kabupatens.kab_id', 'rsmst_kecamatans.kab_id')
            ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_kabupatens.prop_id')
            ->where(DB::raw("to_char(rsmst_desas.des_id)"), $search)
            ->first();


        if ($desaIdentitas) {
            $this->dataPasien['pasien']['identitas']['desaId'] = $desaIdentitas->des_id;
            $this->dataPasien['pasien']['identitas']['desaName'] = $desaIdentitas->des_name;
            $this->dataPasien['pasien']['identitas']['kecamatanId'] = $desaIdentitas->kec_id;
            $this->dataPasien['pasien']['identitas']['kecamatanName'] = $desaIdentitas->kec_name;
            $this->dataPasien['pasien']['identitas']['kotaId'] = $desaIdentitas->kab_id;
            $this->dataPasien['pasien']['identitas']['kotaName'] = $desaIdentitas->kab_name;
            $this->dataPasien['pasien']['identitas']['propinsiId'] = $desaIdentitas->prop_id;
            $this->dataPasien['pasien']['identitas']['propinsiName'] = $desaIdentitas->prop_name;
            $this->desaIdentitasLovStatus = false;
            $this->desaIdentitasLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->desaIdentitasLov = [];
            } else {
                $this->desaIdentitasLov = DB::table('rsmst_desas')
                    ->select(
                        'rsmst_desas.des_id  as des_id',
                        'rsmst_kecamatans.kec_id  as kec_id',
                        'rsmst_kabupatens.kab_id  as kab_id',
                        'rsmst_propinsis.prop_id  as prop_id',
                        'des_name  as des_name',
                        'kec_name  as kec_name',
                        'kab_name  as kab_name',
                        'prop_name  as prop_name',

                    )->join('rsmst_kecamatans', 'rsmst_kecamatans.kec_id', 'rsmst_desas.kec_id')
                    ->join('rsmst_kabupatens', 'rsmst_kabupatens.kab_id', 'rsmst_kecamatans.kab_id')
                    ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_kabupatens.prop_id')
                    ->where('rsmst_kabupatens.kab_id', $this->dataPasien['pasien']['identitas']['kotaId'])
                    ->where('rsmst_propinsis.prop_id', $this->dataPasien['pasien']['identitas']['propinsiId'])
                    ->where(
                        function ($q) use ($search) {
                            $q->Where(
                                DB::raw("replace(upper('ds'||des_name),' ','')"),
                                'like',
                                '%' . str_replace(' ', '', strtoupper($search)) . '%'
                            )
                                ->OrWhere(
                                    DB::raw("replace(upper('kec'||kec_name),' ','')"),
                                    'like',
                                    '%' . str_replace(' ', '', strtoupper($search)) . '%'
                                );
                        }
                    )
                    ->orderBy('prop_name')
                    ->orderBy('kab_name')
                    ->orderBy('kec_name')
                    ->orderBy('des_name')
                    ->limit(30)->get();
            }
            $this->desaIdentitasLovStatus = true;
            $this->dataPasien['pasien']['identitas']['desaId'] = '';
            $this->dataPasien['pasien']['identitas']['desaName'] = '';
            $this->dataPasien['pasien']['identitas']['kecamatanId'] = '';
            $this->dataPasien['pasien']['identitas']['kecamatanName'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydesaIdentitasLov($desaId, $desaName, $kecId, $kecName)
    {
        $this->dataPasien['pasien']['identitas']['desaId'] = $desaId;
        $this->dataPasien['pasien']['identitas']['desaName'] = $desaName;
        $this->dataPasien['pasien']['identitas']['kecamatanId'] = $kecId;
        $this->dataPasien['pasien']['identitas']['kecamatanName'] = $kecName;
        $this->desaIdentitasLovStatus = false;
        $this->desaIdentitasLovSearch = '';
    }
    // LOV selected end
    // /////////////////////

    // /////////kotaIdentitas////////////
    public function clickkotaIdentitaslov()
    {
        $this->kotaIdentitasLovStatus = true;
        $this->kotaIdentitasLov = [];
    }
    public function updatedkotaidentitaslovsearch()
    {
        // Variable Search
        $search = $this->kotaIdentitasLovSearch;

        // check LOV by id
        $kotaIdentitas = DB::table('rsmst_kabupatens')
            ->select(

                'rsmst_kabupatens.kab_id  as kab_id',
                'rsmst_propinsis.prop_id  as prop_id',
                'kab_name  as kab_name',
                'prop_name  as prop_name',

            )
            ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_kabupatens.prop_id')
            ->where(DB::raw("to_char(rsmst_kabupatens.kab_id)"), $search)
            ->first();


        if ($kotaIdentitas) {
            $this->dataPasien['pasien']['identitas']['desaId'] = '';
            $this->dataPasien['pasien']['identitas']['desaName'] = '';
            $this->dataPasien['pasien']['identitas']['kecamatanId'] = '';
            $this->dataPasien['pasien']['identitas']['kecamatanName'] = '';
            $this->dataPasien['pasien']['identitas']['kotaId'] = $kotaIdentitas->kab_id;
            $this->dataPasien['pasien']['identitas']['kotaName'] = $kotaIdentitas->kab_name;
            $this->dataPasien['pasien']['identitas']['propinsiId'] = $kotaIdentitas->prop_id;
            $this->dataPasien['pasien']['identitas']['propinsiName'] = $kotaIdentitas->prop_name;
            $this->kotaIdentitasLovStatus = false;
            $this->kotaIdentitasLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->kotaIdentitasLov = [];
            } else {
                $this->kotaIdentitasLov = DB::table('rsmst_kabupatens')
                    ->select(
                        'rsmst_kabupatens.kab_id  as kab_id',
                        'rsmst_propinsis.prop_id  as prop_id',
                        'kab_name  as kab_name',
                        'prop_name  as prop_name',
                    )
                    ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_kabupatens.prop_id')
                    ->where(
                        function ($q) use ($search) {
                            $q->Where(
                                DB::raw("replace(upper('kab'||kab_name),' ','')"),
                                'like',
                                '%' . str_replace(' ', '', strtoupper($search)) . '%'
                            )
                                ->OrWhere(
                                    DB::raw("replace(upper('prop'||prop_name),' ','')"),
                                    'like',
                                    '%' . str_replace(' ', '', strtoupper($search)) . '%'
                                );
                        }
                    )
                    ->orderBy('prop_name')
                    ->orderBy('kab_name')
                    ->limit(30)->get();
            }
            $this->kotaIdentitasLovStatus = true;
            $this->dataPasien['pasien']['identitas']['desaId'] = '';
            $this->dataPasien['pasien']['identitas']['desaName'] = '';
            $this->dataPasien['pasien']['identitas']['kecamatanId'] = '';
            $this->dataPasien['pasien']['identitas']['kecamatanName'] = '';
            $this->dataPasien['pasien']['identitas']['kotaId'] = '';
            $this->dataPasien['pasien']['identitas']['kotaName'] = '';
            $this->dataPasien['pasien']['identitas']['propinsiId'] = '';
            $this->dataPasien['pasien']['identitas']['propinsiName'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMykotaIdentitasLov($kotaId, $kotaName, $propinsiId, $propinsiName)
    {
        $this->dataPasien['pasien']['identitas']['desaId'] = '';
        $this->dataPasien['pasien']['identitas']['desaName'] = '';
        $this->dataPasien['pasien']['identitas']['kecamatanId'] = '';
        $this->dataPasien['pasien']['identitas']['kecamatanName'] = '';
        $this->dataPasien['pasien']['identitas']['kotaId'] = $kotaId;
        $this->dataPasien['pasien']['identitas']['kotaName'] = $kotaName;
        $this->dataPasien['pasien']['identitas']['propinsiId'] = $propinsiId;
        $this->dataPasien['pasien']['identitas']['propinsiName'] = $propinsiName;
        $this->kotaIdentitasLovStatus = false;
        $this->kotaIdentitasLovSearch = '';
    }
    // LOV selected end
    // /////////////////////


    // /////////desaDomisil////////////
    public function clickDesaDomisillov()
    {
        $this->desaDomisilLovStatus = true;
        $this->desaDomisilLov = [];
    }
    public function updatedDesaDomisillovsearch()
    {
        // Variable Search
        $search = $this->desaDomisilLovSearch;

        // check LOV by id
        $desaDomisil = DB::table('rsmst_desas')
            ->select(
                'rsmst_desas.des_id  as des_id',
                'rsmst_kecamatans.kec_id  as kec_id',
                'rsmst_kabupatens.kab_id  as kab_id',
                'rsmst_propinsis.prop_id  as prop_id',
                'des_name  as des_name',
                'kec_name  as kec_name',
                'kab_name  as kab_name',
                'prop_name  as prop_name',

            )->join('rsmst_kecamatans', 'rsmst_kecamatans.kec_id', 'rsmst_desas.kec_id')
            ->join('rsmst_kabupatens', 'rsmst_kabupatens.kab_id', 'rsmst_kecamatans.kab_id')
            ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_kabupatens.prop_id')
            ->where(DB::raw("to_char(rsmst_desas.des_id)"), $search)
            ->first();


        if ($desaDomisil) {
            $this->dataPasien['pasien']['domisil']['desaId'] = $desaDomisil->des_id;
            $this->dataPasien['pasien']['domisil']['desaName'] = $desaDomisil->des_name;
            $this->dataPasien['pasien']['domisil']['kecamatanId'] = $desaDomisil->kec_id;
            $this->dataPasien['pasien']['domisil']['kecamatanName'] = $desaDomisil->kec_name;
            $this->dataPasien['pasien']['domisil']['kotaId'] = $desaDomisil->kab_id;
            $this->dataPasien['pasien']['domisil']['kotaName'] = $desaDomisil->kab_name;
            $this->dataPasien['pasien']['domisil']['propinsiId'] = $desaDomisil->prop_id;
            $this->dataPasien['pasien']['domisil']['propinsiName'] = $desaDomisil->prop_name;
            $this->desaDomisilLovStatus = false;
            $this->desaDomisilLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->desaDomisilLov = [];
            } else {
                $this->desaDomisilLov = DB::table('rsmst_desas')
                    ->select(
                        'rsmst_desas.des_id  as des_id',
                        'rsmst_kecamatans.kec_id  as kec_id',
                        'rsmst_kabupatens.kab_id  as kab_id',
                        'rsmst_propinsis.prop_id  as prop_id',
                        'des_name  as des_name',
                        'kec_name  as kec_name',
                        'kab_name  as kab_name',
                        'prop_name  as prop_name',

                    )->join('rsmst_kecamatans', 'rsmst_kecamatans.kec_id', 'rsmst_desas.kec_id')
                    ->join('rsmst_kabupatens', 'rsmst_kabupatens.kab_id', 'rsmst_kecamatans.kab_id')
                    ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_kabupatens.prop_id')
                    ->where('rsmst_kabupatens.kab_id', $this->dataPasien['pasien']['domisil']['kotaId'])
                    ->where('rsmst_propinsis.prop_id', $this->dataPasien['pasien']['domisil']['propinsiId'])
                    ->where(
                        function ($q) use ($search) {
                            $q->Where(
                                DB::raw("replace(upper('ds'||des_name),' ','')"),
                                'like',
                                '%' . str_replace(' ', '', strtoupper($search)) . '%'
                            )
                                ->OrWhere(
                                    DB::raw("replace(upper('kec'||kec_name),' ','')"),
                                    'like',
                                    '%' . str_replace(' ', '', strtoupper($search)) . '%'
                                );
                        }
                    )
                    ->orderBy('prop_name')
                    ->orderBy('kab_name')
                    ->orderBy('kec_name')
                    ->orderBy('des_name')
                    ->limit(30)->get();
            }
            $this->desaDomisilLovStatus = true;
            $this->dataPasien['pasien']['domisil']['desaId'] = '';
            $this->dataPasien['pasien']['domisil']['desaName'] = '';
            $this->dataPasien['pasien']['domisil']['kecamatanId'] = '';
            $this->dataPasien['pasien']['domisil']['kecamatanName'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydesaDomisilLov($desaId, $desaName, $kecId, $kecName)
    {
        $this->dataPasien['pasien']['domisil']['desaId'] = $desaId;
        $this->dataPasien['pasien']['domisil']['desaName'] = $desaName;
        $this->dataPasien['pasien']['domisil']['kecamatanId'] = $kecId;
        $this->dataPasien['pasien']['domisil']['kecamatanName'] = $kecName;
        $this->desaDomisilLovStatus = false;
        $this->desaDomisilLovSearch = '';
    }
    // LOV selected end
    // /////////////////////

    // /////////kotaDomisil////////////
    public function clickkotaDomisillov()
    {
        $this->kotaDomisilLovStatus = true;
        $this->kotaDomisilLov = [];
    }
    public function updatedkotaDomisillovsearch()
    {
        // Variable Search
        $search = $this->kotaDomisilLovSearch;

        // check LOV by id
        $kotaDomisil = DB::table('rsmst_kabupatens')
            ->select(

                'rsmst_kabupatens.kab_id  as kab_id',
                'rsmst_propinsis.prop_id  as prop_id',
                'kab_name  as kab_name',
                'prop_name  as prop_name',

            )
            ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_kabupatens.prop_id')
            ->where(DB::raw("to_char(rsmst_kabupatens.kab_id)"), $search)
            ->first();


        if ($kotaDomisil) {
            $this->dataPasien['pasien']['domisil']['desaId'] = '';
            $this->dataPasien['pasien']['domisil']['desaName'] = '';
            $this->dataPasien['pasien']['domisil']['kecamatanId'] = '';
            $this->dataPasien['pasien']['domisil']['kecamatanName'] = '';
            $this->dataPasien['pasien']['domisil']['kotaId'] = $kotaDomisil->kab_id;
            $this->dataPasien['pasien']['domisil']['kotaName'] = $kotaDomisil->kab_name;
            $this->dataPasien['pasien']['domisil']['propinsiId'] = $kotaDomisil->prop_id;
            $this->dataPasien['pasien']['domisil']['propinsiName'] = $kotaDomisil->prop_name;
            $this->kotaDomisilLovStatus = false;
            $this->kotaDomisilLovSearch = '';
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->kotaDomisilLov = [];
            } else {
                $this->kotaDomisilLov = DB::table('rsmst_kabupatens')
                    ->select(
                        'rsmst_kabupatens.kab_id  as kab_id',
                        'rsmst_propinsis.prop_id  as prop_id',
                        'kab_name  as kab_name',
                        'prop_name  as prop_name',
                    )
                    ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_kabupatens.prop_id')
                    ->where(
                        function ($q) use ($search) {
                            $q->Where(
                                DB::raw("replace(upper('kab'||kab_name),' ','')"),
                                'like',
                                '%' . str_replace(' ', '', strtoupper($search)) . '%'
                            )
                                ->OrWhere(
                                    DB::raw("replace(upper('prop'||prop_name),' ','')"),
                                    'like',
                                    '%' . str_replace(' ', '', strtoupper($search)) . '%'
                                );
                        }
                    )
                    ->orderBy('prop_name')
                    ->orderBy('kab_name')
                    ->limit(30)->get();
            }
            $this->kotaDomisilLovStatus = true;
            $this->dataPasien['pasien']['domisil']['desaId'] = '';
            $this->dataPasien['pasien']['domisil']['desaName'] = '';
            $this->dataPasien['pasien']['domisil']['kecamatanId'] = '';
            $this->dataPasien['pasien']['domisil']['kecamatanName'] = '';
            $this->dataPasien['pasien']['domisil']['kotaId'] = '';
            $this->dataPasien['pasien']['domisil']['kotaName'] = '';
            $this->dataPasien['pasien']['domisil']['propinsiId'] = '';
            $this->dataPasien['pasien']['domisil']['propinsiName'] = '';
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMykotaDomisilLov($kotaId, $kotaName, $propinsiId, $propinsiName)
    {
        $this->dataPasien['pasien']['domisil']['desaId'] = '';
        $this->dataPasien['pasien']['domisil']['desaName'] = '';
        $this->dataPasien['pasien']['domisil']['kecamatanId'] = '';
        $this->dataPasien['pasien']['domisil']['kecamatanName'] = '';
        $this->dataPasien['pasien']['domisil']['kotaId'] = $kotaId;
        $this->dataPasien['pasien']['domisil']['kotaName'] = $kotaName;
        $this->dataPasien['pasien']['domisil']['propinsiId'] = $propinsiId;
        $this->dataPasien['pasien']['domisil']['propinsiName'] = $propinsiName;
        $this->kotaDomisilLovStatus = false;
        $this->kotaDomisilLovSearch = '';
    }
    // LOV selected end
    // /////////////////////

    // logic LOV end



    ////////////////////////////logic lain/////////////////////////////////////

    // update usia berdasarkan tgl lahir dan sebaliknya y m d ////////////////
    //////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////
    public function updatedDatapasienPasienTgllahir(): void
    {
        $this->hitungUsiaPasien($this->dataPasien['pasien']['tglLahir']);
    }

    public function updatedDatapasienPasienThn(): void
    {
        $this->hitungBirthdatePasien($this->dataPasien['pasien']['thn']);
    }


    // checkbox start//////////////////////////////////////////////
    // sama dgn identitas///////////////////////////////////////////
    /////////////////////////////////////////////////////////////////
    public function updatedDatapasienPasienDomisilSamadgnidentitas(): void
    {
        if ($this->dataPasien['pasien']['domisil']['samadgnidentitas']) {
            $this->dataPasien['pasien']['domisil']['alamat'] = $this->dataPasien['pasien']['identitas']['alamat'];
            $this->dataPasien['pasien']['domisil']['rt'] = $this->dataPasien['pasien']['identitas']['rt'];
            $this->dataPasien['pasien']['domisil']['rw'] = $this->dataPasien['pasien']['identitas']['rw'];
            $this->dataPasien['pasien']['domisil']['kodepos'] = $this->dataPasien['pasien']['identitas']['kodepos'];

            $this->dataPasien['pasien']['domisil']['desaId'] = $this->dataPasien['pasien']['identitas']['desaId'];
            $this->dataPasien['pasien']['domisil']['desaName'] = $this->dataPasien['pasien']['identitas']['desaName'];
            $this->dataPasien['pasien']['domisil']['kecamatanId'] = $this->dataPasien['pasien']['identitas']['kecamatanId'];
            $this->dataPasien['pasien']['domisil']['kecamatanName'] = $this->dataPasien['pasien']['identitas']['kecamatanName'];
            $this->dataPasien['pasien']['domisil']['kotaId'] = $this->dataPasien['pasien']['identitas']['kotaId'];
            $this->dataPasien['pasien']['domisil']['kotaName'] = $this->dataPasien['pasien']['identitas']['kotaName'];
            $this->dataPasien['pasien']['domisil']['propinsiId'] = $this->dataPasien['pasien']['identitas']['propinsiId'];
            $this->dataPasien['pasien']['domisil']['propinsiName'] = $this->dataPasien['pasien']['identitas']['propinsiName'];
        } else {
            $this->dataPasien['pasien']['domisil']['alamat'] = '';
            $this->dataPasien['pasien']['domisil']['rt'] = '';
            $this->dataPasien['pasien']['domisil']['rw'] = '';
            $this->dataPasien['pasien']['domisil']['kodepos'] = '';

            $this->dataPasien['pasien']['domisil']['desaId'] = '';
            $this->dataPasien['pasien']['domisil']['desaName'] = '';
            $this->dataPasien['pasien']['domisil']['kecamatanId'] = '';
            $this->dataPasien['pasien']['domisil']['kecamatanName'] = '';
            $this->dataPasien['pasien']['domisil']['kotaId'] = '3504';
            $this->dataPasien['pasien']['domisil']['kotaName'] = 'TULUNGAGUNG';
            $this->dataPasien['pasien']['domisil']['propinsiId'] = '35';
            $this->dataPasien['pasien']['domisil']['propinsiName'] = 'JAWA TIMUR';
        }
    }

    // pasien tidak dikenal
    public function updatedDatapasienPasienPasientidakdikenal(): void
    {
        if ($this->dataPasien['pasien']['pasientidakdikenal']) {
            $this->ruleDataPasien['pasien']['identitas']['nik'] = false;
        } else {
            $this->ruleDataPasien['pasien']['identitas']['nik'] = true;
        }
    }

    // reg No Pasien//////////////////////////////////////////////////
    // ///////////////////////////////////////////////////////////////
    // ///////////////////////////////////////////////////////////////
    private function createRegNoPasien()
    {
        $jmlpasien = DB::table('rsmst_pasiens')->count();
        $this->dataPasien['pasien']['regNo'] = sprintf("%07s", $jmlpasien) . 'Z';
    }

    // validate Data Pasien//////////////////////////////////////////////////
    // ///////////////////////////////////////////////////////////////
    // ///////////////////////////////////////////////////////////////
    private function validateDataPasien(): void
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // require nik ketika pasien tidak dikenal



        $rules = [
            'dataPasien.pasien.pasientidakdikenal' => '',
            'dataPasien.pasien.regNo' => '',
            'dataPasien.pasien.gelarDepan' => '',
            'dataPasien.pasien.regName' => 'bail|required|min:3|max:200',
            'dataPasien.pasien.gelarBelakang' => '',
            'dataPasien.pasien.namaPanggilan' => '',
            'dataPasien.pasien.tempatLahir' => 'bail|required',
            'dataPasien.pasien.tglLahir' => 'bail|required|date_format:d/m/Y',
            'dataPasien.pasien.thn' => 'bail|numeric',
            'dataPasien.pasien.bln' => 'bail|numeric',
            'dataPasien.pasien.hari' => 'bail|numeric',
            'dataPasien.pasien.jenisKelamin.jenisKelaminId' => 'bail|required',
            'dataPasien.pasien.jenisKelamin.jenisKelaminDesc' => 'bail|required',

            'dataPasien.pasien.agama.agamaId' => 'bail|required',
            'dataPasien.pasien.agama.agamaDesc' => 'bail|required',

            'dataPasien.pasien.statusPerkawinan.statusPerkawinanId' => 'bail|required',
            'dataPasien.pasien.statusPerkawinan.statusPerkawinanDesc' => 'bail|required',

            'dataPasien.pasien.pendidikan.pendidikanId' => 'bail|required',
            'dataPasien.pasien.pendidikan.pendidikanDesc' => 'bail|required',

            'dataPasien.pasien.pekerjaan.pekerjaanId' => 'bail|required',
            'dataPasien.pasien.pekerjaan.pekerjaanDesc' => 'bail|required',

            'dataPasien.pasien.golonganDarah.golonganDarahId' => '',
            'dataPasien.pasien.golonganDarah.golonganDarahDesc' => '',

            'dataPasien.pasien.kewarganegaraan' => 'bail|required',
            'dataPasien.pasien.suku' => '',
            'dataPasien.pasien.bahasa' => '',
            'dataPasien.pasien.status.statusId' => 'bail|required',
            'dataPasien.pasien.status.statusDesc' => 'bail|required',

            'dataPasien.pasien.domisil.samadgnidentitas' => '',
            'dataPasien.pasien.domisil.alamat' => 'bail|required',
            'dataPasien.pasien.domisil.rt' => 'bail|required',
            'dataPasien.pasien.domisil.rw' => 'bail|required',
            'dataPasien.pasien.domisil.kodepos' => 'bail|required',
            'dataPasien.pasien.domisil.desaId' => 'bail|required|exists:rsmst_desas,des_id',
            'dataPasien.pasien.domisil.kecamatanId' => 'bail|required|exists:rsmst_kecamatans,kec_id',
            'dataPasien.pasien.domisil.kotaId' => 'bail|required|exists:rsmst_kabupatens,kab_id',
            'dataPasien.pasien.domisil.propinsiId' => 'bail|required|exists:rsmst_propinsis,prop_id',
            'dataPasien.pasien.domisil.desaName' => 'bail|required',
            'dataPasien.pasien.domisil.kecamatanName' => 'bail|required',
            'dataPasien.pasien.domisil.kotaName' => 'bail|required',
            'dataPasien.pasien.domisil.propinsiName' => 'bail|required',


            'dataPasien.pasien.identitas.idbpjs' => 'digits:13',
            'dataPasien.pasien.identitas.pasport' => '',
            'dataPasien.pasien.identitas.alamat' => '',
            'dataPasien.pasien.identitas.rt' => 'bail|required',
            'dataPasien.pasien.identitas.rw' => 'bail|required',
            'dataPasien.pasien.identitas.kodepos' => 'bail|required',
            'dataPasien.pasien.identitas.desaId' => 'bail|required|exists:rsmst_desas,des_id',
            'dataPasien.pasien.identitas.kecamatanId' => 'bail|required|exists:rsmst_kecamatans,kec_id',
            'dataPasien.pasien.identitas.kotaId' => 'bail|required|exists:rsmst_kabupatens,kab_id',
            'dataPasien.pasien.identitas.propinsiId' => 'bail|required|exists:rsmst_propinsis,prop_id',
            'dataPasien.pasien.identitas.desaName' => 'bail|required',
            'dataPasien.pasien.identitas.kecamatanName' => 'bail|required',
            'dataPasien.pasien.identitas.kotaName' => 'bail|required',
            'dataPasien.pasien.identitas.propinsiName' => 'bail|required',
            'dataPasien.pasien.identitas.negara' => 'bail|required',

            'dataPasien.pasien.kontak.kodenegara' => 'bail|required',
            'dataPasien.pasien.kontak.nomerTelponSelulerPasien' => 'bail|required|digits_between:6,15',
            'dataPasien.pasien.kontak.nomerTelponLain' => '',

            'dataPasien.pasien.hubungan.namaAyah' => 'min:3|max:200',
            'dataPasien.pasien.hubungan.kodenegaraAyah' => '',
            'dataPasien.pasien.hubungan.nomerTelponSelulerAyah' => 'min:3|max:200',

            'dataPasien.pasien.hubungan.namaIbu' => 'min:3|max:200',
            'dataPasien.pasien.hubungan.kodenegaraIbu' => '',
            'dataPasien.pasien.hubungan.nomerTelponSelulerIbu' => 'min:3|max:200',

            'dataPasien.pasien.hubungan.namaPenanggungJawab' => 'bail|required|min:3|max:200',
            'dataPasien.pasien.hubungan.kodenegaraPenanggungJawab' => 'bail|required',
            'dataPasien.pasien.hubungan.nomerTelponSelulerPenanggungJawab' => 'bail|required|digits_between:6,15',

            'dataPasien.pasien.hubungan.hubunganDgnPasien.hubunganDgnPasienId' => 'bail|required',
            'dataPasien.pasien.hubungan.hubunganDgnPasien.hubunganDgnPasienDesc' => 'bail|required',
        ];

        // gabunga array nik jika pasien tidak dikenal
        if ($this->dataPasien['pasien']['pasientidakdikenal']) {
            $rules['dataPasien.pasien.identitas.nik'] =  'digits:16';
        } else {
            $rules['dataPasien.pasien.identitas.nik'] =  'required|digits:16';
        }

        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {

            // dd($validator->fails());
            $this->emit('toastr-error', "Lakukan Pengecekan kembali Input Data Pasien.");
            $this->validate($rules, $messages);
        }
    }

    // Insert Data Pasien//////////////////////////////////////////////////
    // ///////////////////////////////////////////////////////////////
    // ///////////////////////////////////////////////////////////////
    private function insertDataPasien(): void
    {
        DB::table('rsmst_pasiens')->insert([
            'reg_date' => Carbon::now(),
            'reg_no' => $this->dataPasien['pasien']['regNo'], //primarykey insert when select max
            'reg_name' => strtoupper($this->dataPasien['pasien']['regName']),
            'nokartu_bpjs' => $this->dataPasien['pasien']['identitas']['idbpjs'],
            'nik_bpjs' => $this->dataPasien['pasien']['identitas']['nik'],
            'sex' => $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] == 1 ? 'L' : 'P',
            'birth_date' => DB::raw("to_date('" . $this->dataPasien['pasien']['tglLahir'] . "','dd/mm/yyyy')"),
            'thn' => $this->dataPasien['pasien']['thn'],
            'bln' => $this->dataPasien['pasien']['bln'],
            'hari' => $this->dataPasien['pasien']['hari'],
            'birth_place' => strtoupper($this->dataPasien['pasien']['tempatLahir']),
            'blood' => $this->dataPasien['pasien']['golonganDarah']['golonganDarahId'],
            'marital_status' => $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanId'],
            'rel_id' => $this->dataPasien['pasien']['agama']['agamaId'],
            'edu_id' => $this->dataPasien['pasien']['pendidikan']['pendidikanId'],
            'job_id' => $this->dataPasien['pasien']['pekerjaan']['pekerjaanId'],
            'kk' => strtoupper($this->dataPasien['pasien']['hubungan']['namaPenanggungJawab']),
            'nyonya' => strtoupper($this->dataPasien['pasien']['hubungan']['namaIbu']),
            // 'no_kk' => $this->dataPasien['pasien']['identitas']['nik'],
            'patient_uuid' => isset($this->dataPasien['pasien']['identitas']['patientUuid']) ? $this->dataPasien['pasien']['identitas']['patientUuid'] : '',
            'address' => $this->dataPasien['pasien']['identitas']['alamat'],
            'des_id' => $this->dataPasien['pasien']['identitas']['desaId'],
            'rt' => $this->dataPasien['pasien']['identitas']['rt'],
            'rw' => $this->dataPasien['pasien']['identitas']['rw'],
            'kec_id' => $this->dataPasien['pasien']['identitas']['kecamatanId'],
            'kab_id' => $this->dataPasien['pasien']['identitas']['kotaId'],
            'prop_id' => $this->dataPasien['pasien']['identitas']['propinsiId'],
            'phone' => $this->dataPasien['pasien']['kontak']['nomerTelponSelulerPasien'],
            'meta_data_pasien_json' => json_encode($this->dataPasien, true),
            'meta_data_pasien_xml' => ArrayToXml::convert($this->dataPasien)

        ]);
        $this->emit('toastr-success', "Data " .  $this->dataPasien['pasien']['regName'] . " berhasil disimpan.");
    }

    // update Data Pasien//////////////////////////////////////////////////
    // ///////////////////////////////////////////////////////////////
    // ///////////////////////////////////////////////////////////////
    private function updateDataPasien($regNo): void
    {
        DB::table('rsmst_pasiens')->where('reg_no', $regNo)
            ->update([
                'reg_date' => Carbon::now(),
                // 'reg_no' => $this->dataPasien['pasien']['regNo'], //primarykey insert when select max
                'reg_name' => strtoupper($this->dataPasien['pasien']['regName']),
                'nokartu_bpjs' => $this->dataPasien['pasien']['identitas']['idbpjs'],
                'nik_bpjs' => $this->dataPasien['pasien']['identitas']['nik'],
                'sex' => $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] == 1 ? 'L' : 'P',
                'birth_date' => DB::raw("to_date('" . $this->dataPasien['pasien']['tglLahir'] . "','dd/mm/yyyy')"),
                'thn' => $this->dataPasien['pasien']['thn'],
                'bln' => $this->dataPasien['pasien']['bln'],
                'hari' => $this->dataPasien['pasien']['hari'],
                'birth_place' => strtoupper($this->dataPasien['pasien']['tempatLahir']),
                'blood' => $this->dataPasien['pasien']['golonganDarah']['golonganDarahId'],
                'marital_status' => $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanId'],
                'rel_id' => $this->dataPasien['pasien']['agama']['agamaId'],
                'edu_id' => $this->dataPasien['pasien']['pendidikan']['pendidikanId'],
                'job_id' => $this->dataPasien['pasien']['pekerjaan']['pekerjaanId'],
                'kk' => strtoupper($this->dataPasien['pasien']['hubungan']['namaPenanggungJawab']),
                'nyonya' => strtoupper($this->dataPasien['pasien']['hubungan']['namaIbu']),
                // 'no_kk' => $this->dataPasien['pasien']['identitas']['nik'],
                'patient_uuid' => isset($this->dataPasien['pasien']['identitas']['patientUuid']) ? $this->dataPasien['pasien']['identitas']['patientUuid'] : '',
                'address' => $this->dataPasien['pasien']['identitas']['alamat'],
                'des_id' => $this->dataPasien['pasien']['identitas']['desaId'],
                'rt' => $this->dataPasien['pasien']['identitas']['rt'],
                'rw' => $this->dataPasien['pasien']['identitas']['rw'],
                'kec_id' => $this->dataPasien['pasien']['identitas']['kecamatanId'],
                'kab_id' => $this->dataPasien['pasien']['identitas']['kotaId'],
                'prop_id' => $this->dataPasien['pasien']['identitas']['propinsiId'],
                'phone' => $this->dataPasien['pasien']['kontak']['nomerTelponSelulerPasien'],
                'meta_data_pasien_json' => json_encode($this->dataPasien, true),
                'meta_data_pasien_xml' => ArrayToXml::convert($this->dataPasien)

            ]);

        $this->emit('toastr-success', "Data " . $this->dataPasien['pasien']['regName'] . " berhasil diupdate.");
    }

    // update Data Pasien BPJS Search//////////////////////////////////////////////////
    // ///////////////////////////////////////////////////////////////
    // ///////////////////////////////////////////////////////////////
    public function updatedDatapasienbpjssearch()
    {

        // 1.Cari berdasarkan nik ->if null DB
        // 2.Cari berdasarkan reg_no ->if null DB
        // 2.Cari berdasarkan nokaBPJS ->if null DB

        // 4. Goto Pasien Baru berdasarkan nik apiBPJS ->if null
        // 5. Entry Manual Pasien Baru

        // by reg_no
        $cariDataPasienRegNo = $this->findDataByKey('reg_no', $this->dataPasienBPJSSearch);
        if ($cariDataPasienRegNo) {
            $this->emit('toastr-success', "Data " . $this->dataPasien['pasien']['regName'] . " berhasil ditampilkan.");
        } else {

            // by nik
            $cariDataPasienNik = $this->findDataByKey('nik_bpjs', $this->dataPasienBPJSSearch);
            if ($cariDataPasienNik) {
                $this->emit('toastr-success', "Data " . $this->dataPasien['pasien']['regName'] . " berhasil ditampilkan.");
            } else {
                // by nokaBPJS
                $cariDataPasienNokaBpjs = $this->findDataByKey('nokartu_bpjs', $this->dataPasienBPJSSearch);
                if ($cariDataPasienNokaBpjs) {
                    $this->emit('toastr-success', "Data " . $this->dataPasien['pasien']['regName'] . " berhasil ditampilkan.");
                } else {
                    // resert variable dataPasien otomatis (insert mode) cek data dari bpjs server
                    $this->reset('dataPasien');

                    $CaridataVclaim = VclaimTrait::peserta_nik($this->dataPasienBPJSSearch, Carbon::now()
                        ->format('Y-m-d'))
                        ->getOriginalContent();

                    if ($CaridataVclaim['metadata']['code'] == 200) {
                        $CaridataVclaim = $CaridataVclaim['response']['peserta'];

                        // set dataPasien
                        $this->dataPasien['pasien']['regDate'] = Carbon::now();
                        $this->dataPasien['pasien']['regName'] = $CaridataVclaim['nama'];
                        $this->dataPasien['pasien']['identitas']['idbpjs'] = $CaridataVclaim['noKartu'];
                        $this->dataPasien['pasien']['identitas']['nik'] = $CaridataVclaim['nik'];
                        $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] = ($CaridataVclaim['sex'] == 'L') ? 1 : 2;
                        $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] = ($CaridataVclaim['sex'] == 'L') ? 'Laki-laki' : 'Perempuan';

                        $this->dataPasien['pasien']['tglLahir'] = Carbon::createFromFormat('Y-m-d', $CaridataVclaim['tglLahir'])->format('d/m/Y');

                        $this->emit('toastr-success', $CaridataVclaim['nama'] . ' ' . $CaridataVclaim['nik']);
                    } else {
                        // dd($CaridataVclaim);
                        $this->emit('toastr-error', $CaridataVclaim['metadata']['code'] . ' ' . $CaridataVclaim['metadata']['message']);
                    }
                }
            }
        }
    }



    // ///////////////////////////////////////////////////////////////
    // Find data by key and set data pasien
    // ///////////////////////////////////////////////////////////////
    // ///////////////////////////////////////////////////////////////
    private function findDatabyKey($key, $search)
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






        if ($findData) {
            // resert variable dataPasien
            $this->reset('dataPasien');
            $this->isOpenMode = 'update';

            // cari meta data berdasarkan regno (primary key)
            $findDataMetaDataPasienJson = DB::table('rsmst_pasiens')
                ->select('meta_data_pasien_json')
                ->where('reg_no', $findData->reg_no)
                ->first();


            // jika json tidak ditemukan -> cari berdasarkan regno (primary key) set data berdasarkan DB per kolom
            if ($findDataMetaDataPasienJson->meta_data_pasien_json) {

                $this->dataPasien = json_decode($findData->meta_data_pasien_json, true);
            } else {

                // cari meta data berdasarkan regno (primary key)
                $findData = $findData = DB::table('rsmst_pasiens')
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
                    ->where('reg_no', $findData->reg_no)
                    ->first();


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

            }

            return true;
        } else {
            return false;
        }
    }




    // Find data from table start////////////////
    // syncronize array and table_json Pasien
    private function findData($value)
    {
        $findData = DB::table('rsmst_pasiens')
            ->select('meta_data_pasien_json')
            ->where('reg_no', $value)
            ->first();

        if ($findData->meta_data_pasien_json == null) {

            $findData = $this->findDataByKey('reg_no', $value);
        } else {
            // ubah data Pasien
            $this->dataPasien = json_decode($findData->meta_data_pasien_json, true);
        }
        return $findData;
    }
    // Find data from table end////////////////


    // hitungUsiaPasien
    /////////////////////////////////////
    /////////////////////////////////////
    private function hitungUsiaPasien($birthDate): void
    {

        $mybirthDate = date('d/m/Y', strtotime($birthDate));

        $birthDate = new \DateTime($mybirthDate);
        $today = Carbon::now();

        if ($birthDate > $today) {
            $this->dataPasien['pasien']['thn'] = 0;
            $this->dataPasien['pasien']['bln'] = 0;
            $this->dataPasien['pasien']['hari'] = 0;
        } else {
            $y = $today->diff($birthDate)->y;
            $m = $today->diff($birthDate)->m;
            $d = $today->diff($birthDate)->d;
            $this->dataPasien['pasien']['thn'] = $y;
            $this->dataPasien['pasien']['bln'] = $m;
            $this->dataPasien['pasien']['hari'] = $d;
        }
    }
    /////////////////////////////////////
    private function hitungBirthdatePasien($thn): void
    {
        if ($this->dataPasien['pasien']['tglLahir'] == null) {
            $this->dataPasien['pasien']['tglLahir'] = Carbon::now()->subYears($thn)->format('d/m/Y');
        }
    }
    /////////////////////////////////////

    //////////////////////////logic lain///////////////////////////////////////







    // is going to insert data////////////////
    public function create()
    {
        $this->openModal();
    }


    // insert record start////////////////
    public function store()
    {


        $this->validateDataPasien();


        // Logic insert and update mode start //////////
        if ($this->isOpenMode == 'insert') {
            $this->createRegNoPasien();
            $this->insertDataPasien();
            $this->isOpenMode = 'update';
        } else if ($this->isOpenMode == 'update') {
            $this->updateDataPasien($this->dataPasien['pasien']['regNo']);
        }


        // Opstional (Jika ingin fast Entry resert setelah proses diatas)
        // Jika ingin auto close resert dan close aktifkan
        // $this->resetInputFields();
        // $this->closeModal();
    }


    // show edit record start////////////////
    public function edit($id)
    {
        $this->openModalEdit();
        $this->findData($id);
    }
    // show edit record end////////////////


    // tampil record start////////////////
    public function tampil($id)
    {
        $this->openModalTampil();
        $this->findData($id);
    }
    // tampil record end////////////////


    // delete record start////////////////
    public function delete($id, $name)
    {

        // Hapus data Steps
        // 1.Resert dataPasien
        // 2. set id
        // 3. Lakukan Validasi Child Record
        // 4 Hapus

        $this->reset('dataPasien');

        $this->dataPasien['pasien']['regNo'] = $id;



        // customErrorMessages
        $messages = array(
            'unique' => 'Anda tidak dapat menghapus data ini, Data "' . $id . ' / ' . $name . '" sudah di pakai di dalam transaksi.', // mencari referensi pada table tertentu
        );

        $rules = ['dataPasien.pasien.regNo' => 'bail|unique:rstxn_rjhdrs,reg_no|unique:rstxn_ugdhdrs,reg_no|unique:rstxn_rihdrs,reg_no'];

        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // dd($validator->fails());
            $this->emit('toastr-error', 'Anda tidak dapat menghapus data ini, Data "' . $id . ' / ' . $name . '" sudah di pakai di dalam transaksi.');
            $this->validate($rules, $messages);
        }


        DB::table('rsmst_pasiens')
            ->where('reg_no', $id)
            ->delete();
        $this->emit('toastr-success', "Hapus data " . $name . " berhasil.");
    }
    // delete record end////////////////

    public function UpdatepatientUuid(string $nik = '')
    {

        $messages = array(
            'required' => 'Data NIK tidak boleh kosong.', // mencari referensi pada table tertentu
        );

        $rules = ['dataPasien.pasien.identitas.nik' => 'bail|required|digits:16'];

        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($rules, $messages);

            $PatientByNIK = SatuSehatTrait::PatientByNIK($nik);

            // Jika uuid tidak ditemukan
            if (!isset($PatientByNIK->getOriginalContent()['response']['entry'][0]['resource']['id'])) {
                $this->emit('toastr-error', 'UUID tidak dapat ditemukan.' . $PatientByNIK->getOriginalContent()['metadata']['message']);
                return;
            }

            $this->dataPasien['pasien']['identitas']['patientUuid'] = $PatientByNIK->getOriginalContent()['response']['entry'][0]['resource']['id'];
            $this->store();
            $this->emit('toastr-success', $PatientByNIK->getOriginalContent()['response']['entry'][0]['resource']['id'] . ' / ' . $PatientByNIK->getOriginalContent()['response']['entry'][0]['resource']['name'][0]['text']);

            // dd($PatientByNIK->getOriginalContent());
            // dd($PatientByNIK->getOriginalContent()['response']['entry'][0]['resource']['id']);
            // dd($PatientByNIK->getOriginalContent()['response']['entry'][0]['resource']['name'][0]['text']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // dd($validator->fails());
            $this->emit('toastr-error', 'Errors "' . $e->getMessage());
            return;
        }
    }

    public function mount()
    {
    }

    // select data start////////////////
    public function render()
    {


        $myQuery = DB::table('rsmst_pasiens')->select(
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
            'rel_id',
            'edu_id',
            'job_id',
            'kk',
            'nyonya',
            'no_kk',
            'address',
            'des_id',
            'rt',
            'rw',
            'kec_id',
            'kab_id',
            'prop_id',
            'phone'
        );

        $myMultipleSearch = explode('%', $this->search);

        foreach ($myMultipleSearch as $key => $myMS) {
            // key 0  mencari regno dan reg name
            if ($key == 0) {
                $myQuery->where(function ($myQuery) use ($myMS) {
                    $myQuery
                        ->where(DB::raw('upper(reg_no)'), 'like', '%' . strtoupper($myMS) . '%')
                        ->orWhere(DB::raw('upper(reg_name)'), 'like', '%' . strtoupper($myMS) . '%');
                });
            }
            // key 1  mencari alamat
            if ($key == 1) {
                $myQuery->where(function ($myQuery) use ($myMS) {
                    $myQuery
                        ->where(DB::raw('upper(address)'), 'like', '%' . strtoupper($myMS) . '%');
                });
            }
        }

        $myQuery->orderBy('reg_date1', 'desc');


        return view(
            'livewire.master-pasien.master-pasien',
            [
                'ruleDataPasien' => $this->ruleDataPasien,
                'pasiens' => $myQuery->paginate($this->limitPerPage),
                'myTitle' => 'Master Pasien',
                'mySnipt' => 'Tambah Data Pasien',
                'myProgram' => 'Pasien',
                'myLimitPerPages' => [5, 10, 15, 20, 100]
            ]
        );
    }
    // select data end////////////////



}
