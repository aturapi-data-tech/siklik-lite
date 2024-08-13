<?php

namespace App\Http\Livewire\DaftarUGD\FormEntryUGD;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Traits\customErrorMessagesTrait;
use Spatie\ArrayToXml\ArrayToXml;

use Barryvdh\DomPDF\Facade\Pdf;


use App\Http\Traits\BPJS\VclaimTrait;



use Livewire\Component;

class FormEntryUGD extends Component
{
    // listener from blade////////////////
    protected $listeners = [
        'confirm_doble_record_UGDp' => 'setforceInsertRecord',
        // 'ListeneropenModalEditUgd' => 'openModalEditUgd'
    ];

    // public function openModalEditUgd($openModalEditUgd)
    // {
    //     $this->isOpen = $openModalEditUgd['isOpen'];
    //     $this->isOpenMode =  $openModalEditUgd['isOpenMode'];
    //     $this->findData($openModalEditUgd['rjNo']);
    // }


    public bool $isOpen = false;
    public string $isOpenMode = 'insert';
    public bool $forceInsertRecord = false;
    public int $rjNo;





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

    public $entryUgd = [
        'entryId' => '5',
        'entryDesc' => 'Datang Sendiri',
        'entryOptions' => [
            ['entryId' => '5', 'entryDesc' => 'Datang Sendiri'],
        ]
    ];

    public $dataDaftarUgd = [
        "regNo" => '',

        "drId" => '',
        "drDesc" => '',

        "entryId" => '',
        "entryDesc" => '',

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

    //////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////
    // Lov Pasien //////////////////////
    ////////////////////////////////////////////////
    public function updateddataPasienlovsearch()
    {
        // Variable Search
        $search = $this->dataPasienLovSearch;

        // check LOV by id 


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
        $this->emit('listenerRegNo', $id);
        $this->setDataPasien($id);

        $this->dataDaftarUgd['regNo'] = $id;
        $this->dataPasienLovStatus = false;
        $this->dataPasienLov = [];
        $this->dataPasienLovSearch = $id;
    }
    ////////////////////////////////////////////////
    // Lov Pasien //////////////////////
    ////////////////////////////////////////////////

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


    public function closeModal(): void
    {
        $this->isOpen = false;
        $this->isOpenMode = 'insert';

        $this->emit('ListenerisOpenUgd', ['isOpen' => $this->isOpen, 'isOpenMode' => $this->isOpenMode]);
    }


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
            $this->dataDaftarUgd['drId'] = $dataDokter->dr_id;
            $this->dataDaftarUgd['drDesc'] = $dataDokter->dr_name;

            $this->dataDaftarUgd['poliId'] = $dataDokter->poli_id;
            $this->dataDaftarUgd['poliDesc'] = $dataDokter->poli_desc;

            $this->dataDaftarUgd['kddrbpjs'] = $dataDokter->kd_dr_bpjs;
            $this->dataDaftarUgd['kdpolibpjs'] = $dataDokter->kd_poli_bpjs;

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
            $this->dataDaftarUgd['drId'] = '';
            $this->dataDaftarUgd['drDesc'] = '';
            $this->dataDaftarUgd['poliId'] = '';
            $this->dataDaftarUgd['poliDesc'] = '';
            $this->dataDaftarUgd['kddrbpjs'] = '';
            $this->dataDaftarUgd['kdpolibpjs'] = '';
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
        $this->dataDaftarUgd['drId'] = $dataDokter->dr_id;
        $this->dataDaftarUgd['drDesc'] = $dataDokter->dr_name;

        $this->dataDaftarUgd['poliId'] = $dataDokter->poli_id;
        $this->dataDaftarUgd['poliDesc'] = $dataDokter->poli_desc;

        $this->dataDaftarUgd['kddrbpjs'] = $dataDokter->kd_dr_bpjs;
        $this->dataDaftarUgd['kdpolibpjs'] = $dataDokter->kd_poli_bpjs;

        $this->dataDokterLovStatus = false;
        $this->dataDokterLovSearch = '';
    }
    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataDokterRJ //////////////////////
    ////////////////////////////////////////////////



    public function store()
    {


        // dd($this->SEPJsonReq);
        // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
        $this->setDataPrimer();
        // Validate RJ
        $this->validateDataRJ();

        if ($this->JenisKlaim['JenisKlaimId'] == 'JM') {
            $this->pushInsertSEP($this->SEPJsonReq);
        }


        // Logic insert and update mode start //////////
        if ($this->isOpenMode == 'insert') {

            // cari data berdasarkan regno pada tgl tsb dgn status selain 'F'
            // fungsi dasar untuk memperbaiki data EMR
            $cekDoblePendaftaran = DB::table('rsview_ugdkasir')
                ->where('rj_status', '!=', 'F')
                ->where(DB::raw("to_char(rj_date,'dd/mm/yyyy')"), '=', Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarUgd['rjDate'])->format('d/m/Y'))
                ->where("reg_no", '=', $this->dataDaftarUgd['regNo'])
                ->count();


            //cek Doble Pendaftaran
            if ($cekDoblePendaftaran > 0) {
                $this->emit('confirm_doble_recordUGD', $this->dataDaftarUgd['regNo'], $this->dataDaftarUgd['regNo']);
            } else {
                $this->forceInsertRecord = '1';
            }


            // forceInsert record by default is flase true when cekDoblePendaftaran=0 or confirmation from user
            if ($this->forceInsertRecord) {
                $this->insertDataRJ();
                $this->isOpenMode = 'update';
            }
        } else if ($this->isOpenMode == 'update') {
            $this->updateDataRJ($this->dataDaftarUgd['rjNo']);
        }




        // Opstional (Jika ingin fast Entry resert setelah proses diatas)
        // Jika ingin auto close resert dan close aktifkan
        // $this->resetInputFields();
        // $this->closeModal();

    }

    // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
    private function setDataPrimer(): void
    {

        // Klaim & Kunjungan 
        // dd($this->dataDaftarUgd['klaimId']);
        $this->dataDaftarUgd['klaimId'] = $this->JenisKlaim['JenisKlaimId'];
        $this->dataDaftarUgd['kunjunganId'] = $this->JenisKunjungan['JenisKunjunganId'];

        $this->dataDaftarUgd['entryId'] = $this->entryUgd['entryId'];
        $this->dataDaftarUgd['entryDesc'] = $this->entryUgd['entryDesc'];

        // JenisKunjungan Internal 
        if ($this->JenisKunjungan['JenisKunjunganId'] == 2) {
            $this->dataDaftarUgd['kunjunganInternalStatus'] = "1";
        }

        // noBooking
        if (!$this->dataDaftarUgd['noBooking']) {
            $this->dataDaftarUgd['noBooking'] = Carbon::now()->format('YmdHis') . 'RSIM';
        }

        // rjNoMax
        if (!$this->dataDaftarUgd['rjNo']) {
            $sql = "select nvl(max(rj_no)+1,1) rjno_max from rstxn_ugdhdrs";
            $this->dataDaftarUgd['rjNo'] = DB::scalar($sql);
        }

        // ermStatus
        if (!$this->dataDaftarUgd['ermStatus']) {
            $this->dataDaftarUgd['ermStatus'] = $this->dataDaftarUgd['ermStatus'] ? $this->dataDaftarUgd['ermStatus'] : 'A';
        }

        // noUrutAntrian (count all kecuali KRonis) if KR 999
        $sql = "select count(*) no_antrian 
      from rstxn_ugdhdrs 
      where dr_id=:drId
      and to_char(rj_date,'ddmmyyyy')=:tgl
      and klaim_id!='KR'";

        // Antrian ketika data antrian kosong
        if (!$this->dataDaftarUgd['noAntrian']) {
            // proses antrian
            if ($this->dataDaftarUgd['klaimId'] != 'KR') {
                $noUrutAntrian = DB::scalar($sql, [
                    "tgl" => Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarUgd['rjDate'])->format('dmY'),
                    "drId" => $this->dataDaftarUgd['drId']
                ]);

                $noAntrian = $noUrutAntrian + 1;
            } else {
                // Kronis
                $noAntrian = 999;
            }

            $this->dataDaftarUgd['noAntrian'] = $noAntrian;
        }
    }

    private function setShiftnCurrentDate(): void
    {
        // dd/mm/yyyy hh24:mi:ss
        $this->dataDaftarUgd['rjDate'] = $this->dataDaftarUgd['rjDate'] ? $this->dataDaftarUgd['rjDate'] : Carbon::now()->format('d/m/Y H:i:s');

        // shift
        $findShift = DB::table('rstxn_shiftctls')->select('shift')
            ->whereRaw("'" . Carbon::now()->format('H:i:s') . "' between
            shift_start and shift_end")
            ->first();
        $this->dataDaftarUgd['shift'] = $this->dataDaftarUgd['shift']
            ? $this->dataDaftarUgd['shift']
            : (isset($findShift->shift) && $findShift->shift
                ? $findShift->shift
                : 3);
    }

    // validate Data RJ//////////////////////////////////////////////////
    private function validateDataRJ(): void
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // require nik ketika pasien tidak dikenal



        $rules = [

            "dataDaftarUgd.regNo" => "bail|required|exists:rsmst_pasiens,reg_no",

            "dataDaftarUgd.drId" => "required",
            "dataDaftarUgd.drDesc" => "required",

            // "dataDaftarUgd.poliId" => "required",
            // "dataDaftarUgd.poliDesc" => "required",

            "dataDaftarUgd.kddrbpjs" => '',
            "dataDaftarUgd.kdpolibpjs" => '',


            "dataDaftarUgd.rjDate" => "required",
            "dataDaftarUgd.rjNo" => "required",

            "dataDaftarUgd.shift" => "required",

            "dataDaftarUgd.noAntrian" => "required",
            "dataDaftarUgd.noBooking" => "required",

            "dataDaftarUgd.slCodeFrom" => "required",
            "dataDaftarUgd.passStatus" => "",

            "dataDaftarUgd.rjStatus" => "required",
            "dataDaftarUgd.txnStatus" => "required",
            "dataDaftarUgd.ermStatus" => "required",

            "dataDaftarUgd.cekLab" => "required",

            "dataDaftarUgd.kunjunganInternalStatus" => "required",

            "dataDaftarUgd.noReferensi" => "",

        ];

        // gabunga array noReferensi jika BPJS harus di isi
        if ($this->JenisKlaim['JenisKlaimId'] == 'JM') {
            $rules['dataDaftarUgd.noReferensi'] =  'bail|min:3|max:19';
        } else {
            $rules['dataDaftarUgd.noReferensi'] =  'bail|min:3|max:19';
        }

        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $this->emit('toastr-error', "Lakukan Pengecekan kembali Input Data Pasien." . json_encode($e->errors(), true));
            $this->validate($rules, $messages);
        }
    }

    private function insertDataRJ(): void
    {

        // insert into table transaksi
        DB::table('rstxn_ugdhdrs')->insert([
            'rj_no' => $this->dataDaftarUgd['rjNo'],
            'rj_date' => DB::raw("to_date('" . $this->dataDaftarUgd['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"),
            'reg_no' => $this->dataDaftarUgd['regNo'],
            'nobooking' => $this->dataDaftarUgd['noBooking'],
            'no_antrian' => $this->dataDaftarUgd['noAntrian'],

            'klaim_id' => $this->dataDaftarUgd['klaimId'],
            'entry_id' => $this->dataDaftarUgd['entryId'],

            'poli_id' => $this->dataDaftarUgd['poliId'],
            'dr_id' => $this->dataDaftarUgd['drId'],
            'shift' => $this->dataDaftarUgd['shift'],

            'death_on_igd_status' => 'N',
            'before_after' => 'B',
            'out_desc' => 'RAWAT',
            'status_lanjutan' => 'BS',



            'txn_status' => $this->dataDaftarUgd['txnStatus'],
            'rj_status' => $this->dataDaftarUgd['rjStatus'],
            'erm_status' => $this->dataDaftarUgd['ermStatus'] ? $this->dataDaftarUgd['ermStatus'] : 'A',

            'pass_status' => $this->dataDaftarUgd['passStatus'] == 'N' ? 'N' : 'O', //Baru lama

            'cek_lab' => $this->dataDaftarUgd['cekLab'],
            'sl_codefrom' => $this->dataDaftarUgd['slCodeFrom'],
            'kunjungan_internal_status' => $this->dataDaftarUgd['kunjunganInternalStatus'],
            'push_antrian_bpjs_status' => $this->HttpGetBpjsStatus, //status push antrian 200 /201/ 400
            'push_antrian_bpjs_json' => $this->HttpGetBpjsJson,  // response json
            'datadaftarUgd_json' => json_encode($this->dataDaftarUgd, true),
            'datadaftarUgd_xml' => ArrayToXml::convert($this->dataDaftarUgd),

            'waktu_masuk_pelayanan' => DB::raw("to_date('" . $this->dataDaftarUgd['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"), //waktu masuk = rjdate

            'vno_sep' => isset($this->dataDaftarUgd['sep']['noSep']) ? $this->dataDaftarUgd['sep']['noSep'] : "",

        ]);

        $this->emit('toastr-success', "Data sudah tersimpan.");
    }

    private function updateDataRJ($rjNo): void
    {

        // update table trnsaksi
        DB::table('rstxn_ugdhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                // 'rj_no' => $this->dataDaftarUgd['rjNo'],
                'rj_date' => DB::raw("to_date('" . $this->dataDaftarUgd['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"),
                'reg_no' => $this->dataDaftarUgd['regNo'],
                'nobooking' => $this->dataDaftarUgd['noBooking'],
                'no_antrian' => $this->dataDaftarUgd['noAntrian'],

                'klaim_id' => $this->dataDaftarUgd['klaimId'],
                'entry_id' => $this->dataDaftarUgd['entryId'],

                'poli_id' => $this->dataDaftarUgd['poliId'],
                'dr_id' => $this->dataDaftarUgd['drId'],
                'shift' => $this->dataDaftarUgd['shift'],

                // <!-- 'death_on_igd_status' => 'N',
                // 'before_after' => 'B',
                // 'out_desc' => 'RAWAT',
                // 'status_lanjutan' => 'BS', -->

                'txn_status' => $this->dataDaftarUgd['txnStatus'],
                'rj_status' => $this->dataDaftarUgd['rjStatus'],
                'erm_status' => $this->dataDaftarUgd['ermStatus'] ? $this->dataDaftarUgd['ermStatus'] : 'A',

                'pass_status' => $this->dataDaftarUgd['passStatus'] == 'N' ? 'N' : 'O', //Baru lama

                'cek_lab' => $this->dataDaftarUgd['cekLab'],
                'sl_codefrom' => $this->dataDaftarUgd['slCodeFrom'],
                'kunjungan_internal_status' => $this->dataDaftarUgd['kunjunganInternalStatus'],
                'push_antrian_bpjs_status' => $this->HttpGetBpjsStatus, //status push antrian 200 /201/ 400
                'push_antrian_bpjs_json' => $this->HttpGetBpjsJson,  // response json
                'datadaftarUgd_json' => json_encode($this->dataDaftarUgd, true),
                'datadaftarUgd_xml' => ArrayToXml::convert($this->dataDaftarUgd),

                'waktu_masuk_pelayanan' => DB::raw("to_date('" . $this->dataDaftarUgd['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"), //waktu masuk = rjdate

                'vno_sep' => isset($this->dataDaftarUgd['sep']['noSep']) ? $this->dataDaftarUgd['sep']['noSep'] : "",
            ]);

        $this->emit('toastr-success', "Data berhasil diupdate.");
    }


    public function setforceInsertRecord()
    {
        $this->forceInsertRecord = '1';

        if ($this->forceInsertRecord) {
            $this->insertDataRJ();
            $this->isOpenMode = 'update';
        }
    }




    public function resetInputFields(): void
    {

        // resert validation
        $this->resetValidation();
        // resert input 
        $this->reset(
            [
                'dataPasienLovSearch',
                'isOpenMode',
                'forceInsertRecord',
                'dataPasien',
                'shiftRjRef',
                'statusRjRef',
                'drRjRef',
                'JenisKlaim',
                'JenisKunjungan',
                'dataDaftarUgd',
                'HttpGetBpjsStatus',
                'HttpGetBpjsJson',
                'SEPJsonReq',
                'SEPQuestionnaire',
            ]
        );
        $this->emit('listenerRegNo', '');
        // $this->setDataPasien($this->dataDaftarUgd['regNo']);
    }


    private function findData($rjno): void
    {



        $findData = DB::table('rsview_ugdkasir')
            ->select('datadaftarugd_json', 'vno_sep')
            ->where('rj_no', $rjno)
            ->first();

        $datadaftarugd_json = isset($findData->datadaftarugd_json) ? $findData->datadaftarugd_json : null;
        // if meta_data_pasien_json = null
        // then cari Data Pasien By Key Collection (exception when no data found)
        // 
        // else json_decode
        if ($datadaftarugd_json) {
            $this->dataDaftarUgd = json_decode($findData->datadaftarugd_json, true);

            // jika sep tidak ditemukan tambah variable sep pda array
            if (isset($this->dataDaftarUgd['sep']) == false) {
                $this->dataDaftarUgd['sep'] = [
                    "noSep" => $findData->vno_sep,
                    "reqSep" => [],
                    "resSep" => [],
                ];
            }

            // jika sep ditemukan tetapi variable kosong set sep pda array
            $this->dataDaftarUgd['sep']['noSep'] = isset($findData->vno_sep) ? $findData->vno_sep : "";
            $this->emit('listenerRegNo', $this->dataDaftarUgd['regNo']);
            $this->setDataPasien($this->dataDaftarUgd['regNo']);

            // dd(isset($this->dataDaftarUgd['klaimId']));
            if (!isset($this->dataDaftarUgd['klaimId'])) {
                $this->emit('toastr-error', "Data Klaim tidak ditemukan, Reset Data Ke UMUM");
            }
            if (!isset($this->dataDaftarUgd['kunjunganId'])) {
                $this->emit('toastr-error', "Data Kunjungan tidak ditemukan, Reset Data Ke FKTP");
            }

            $this->dataPasienLovSearch = $this->dataDaftarUgd['regNo'];
            $this->JenisKlaim['JenisKlaimId'] = isset($this->dataDaftarUgd['klaimId']) ? $this->dataDaftarUgd['klaimId'] : "UM";
            $this->JenisKunjungan['JenisKunjunganId'] = isset($this->dataDaftarUgd['kunjunganId']) ? $this->dataDaftarUgd['kunjunganId'] : '1';
        } else {
            $this->emit('toastr-error', "Data tidak dapat di proses json.");
            $dataDaftarUgd = DB::table('rsview_ugdkasir')
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
                    // 'poli_desc',
                    'dr_id',
                    'dr_name',
                    'klaim_id',
                    'entry_id',
                    'shift',
                    'vno_sep',
                    'no_antrian',

                    'nobooking',
                    'push_antrian_bpjs_status',
                    'push_antrian_bpjs_json',
                    // 'kd_dr_bpjs',
                    // 'kd_poli_bpjs',
                    'rj_status',
                    'txn_status',
                    'erm_status',
                )
                ->where('rj_no', '=', $rjno)
                ->first();

            $this->dataDaftarUgd = [
                "regNo" =>  $dataDaftarUgd->reg_no,

                "drId" =>  $dataDaftarUgd->dr_id,
                "drDesc" =>  $dataDaftarUgd->dr_name,

                "poliId" =>  $dataDaftarUgd->poli_id,
                "klaimId" => $dataDaftarUgd->klaim_id,
                // "poliDesc" =>  $dataDaftarUgd->poli_desc ,

                // "kddrbpjs" =>  $dataDaftarUgd->kd_dr_bpjs ,
                // "kdpolibpjs" =>  $dataDaftarUgd->kd_poli_bpjs ,

                "rjDate" =>  $dataDaftarUgd->rj_date,
                "rjNo" =>  $dataDaftarUgd->rj_no,
                "shift" =>  $dataDaftarUgd->shift,
                "noAntrian" =>  $dataDaftarUgd->no_antrian,
                "noBooking" =>  $dataDaftarUgd->nobooking,
                "slCodeFrom" => "02",
                "passStatus" => "",
                "rjStatus" =>  $dataDaftarUgd->rj_status,
                "txnStatus" =>  $dataDaftarUgd->txn_status,
                "ermStatus" => ($dataDaftarUgd->erm_status) ? $dataDaftarUgd->erm_status : 'A',
                "cekLab" => "0",
                "kunjunganInternalStatus" => "0",
                "noReferensi" =>  $dataDaftarUgd->reg_no,
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
                    ]
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
                    "taskId3" =>  $dataDaftarUgd->rj_date,
                    "taskId4" => "",
                    "taskId5" => "",
                    "taskId6" => "",
                    "taskId7" => "",
                    "taskId99" => "",
                ],
                'sep' => [
                    "noSep" =>  $dataDaftarUgd->vno_sep,
                    "reqSep" => [],
                    "resSep" => [],
                ]
            ];

            $this->emit('listenerRegNo', $this->dataDaftarUgd['regNo']);
            $this->setDataPasien($this->dataDaftarUgd['regNo']);


            $this->dataPasienLovSearch = $this->dataDaftarUgd['regNo'];
            $this->JenisKlaim['JenisKlaimId'] = $dataDaftarUgd->klaim_id == 'JM' ? 'JM' : 'UM';
            $this->JenisKlaim['JenisKlaimDesc'] = $dataDaftarUgd->klaim_id == 'JM' ? 'BPJS' : 'UMUM';

            $this->JenisKlaim['JenisKlaimId'] = $dataDaftarUgd->klaim_id == 'JM' ? 'JM' : 'UM';
            $this->JenisKlaim['JenisKlaimDesc'] = $dataDaftarUgd->klaim_id == 'JM' ? 'BPJS' : 'UMUM';

            $this->JenisKunjungan['JenisKunjunganId'] = '1';
            $this->JenisKunjungan['JenisKunjunganDesc'] = 'Rujukan FKTP';
        }


        // 

        // return $findData;
    }





    public function setShiftRJ($id, $desc): void
    {
        $this->dataDaftarUgd['shift'] = $id;
    }



    public function clickrujukanPeserta(): void
    {
        // Cek jika bukan BPJS
        if ($this->JenisKlaim['JenisKlaimId'] != 'JM') {
            $this->emit('toastr-error', 'Jenis Klaim ' . $this->JenisKlaim['JenisKlaimDesc']);
        } else {
            // Cek Apakah reqSep ada datanya apa blm
            // if (isset($this->dataDaftarUgd['sep']['reqSep']['request']) && isset($this->dataDaftarUgd['sep']['noSep'])) {
            if ($this->dataDaftarUgd['sep']['noSep']) {

                $this->SEPJsonReq = $this->dataDaftarUgd['sep']['reqSep'];
                // set formRujukanRefBPJSStatus true (open form)
                $this->formRujukanRefBPJSStatus = true;
            } else {

                $tanggal = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarUgd['rjDate'])->format('Y-m-d');
                $this->pesertaNomorKartu($this->dataPasien['pasien']['identitas']['idbpjs'], $tanggal);
            }
        }
    }


    private function pesertaNomorKartu($idBpjs, $tanggal): void
    {
        $HttpGetBpjs =  VclaimTrait::peserta_nomorkartu($idBpjs, $tanggal)->getOriginalContent();
        // metadata d kecil
        if ($HttpGetBpjs['metadata']['code'] == 200) {
            $peserta = $HttpGetBpjs['response'];
            $this->setSEPJsonReqUgd($peserta);
            $this->formRujukanRefBPJSStatus = true;
            $this->emit('toastr-success', $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        } else {
            $this->dataRefBPJSLovStatus = false;
            $this->dataRefBPJSLov = [];
            $this->emit('toastr-error', $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        }
    }


    private function setDataPasien($value): void
    {
        $findData = DB::table('rsmst_pasiens')
            ->select('meta_data_pasien_json')
            ->where('reg_no', $value)
            ->first();


        $meta_data_pasien_json = isset($findData->meta_data_pasien_json) ? $findData->meta_data_pasien_json : null;
        // if meta_data_pasien_json = null
        // then cari Data Pasien By Key Collection (exception when no data found)
        // 
        // else json_decode
        if ($meta_data_pasien_json == null) {

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


    private function setSEPJsonReqUgd($dataRefPeserta): void
    {



        $this->SEPJsonReq = [
            "request" =>  [
                "t_sep" =>  [
                    "noKartu" => "" . $dataRefPeserta['peserta']['noKartu'] . "",
                    "tglSep" => "" . Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarUgd['rjDate'])->format('Y-m-d') . "", //Y-m-d =tgl rj
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
                        "tglRujukan" => "" . Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarUgd['rjDate'])->format('Y-m-d') . "", //Y-m-d
                        "noRujukan" => "" . '' . "",
                        "ppkRujukan" => "" . '0184R006' . "", //{kode faskes rujukam -> baca di referensi faskes}
                        "ppkRujukanNama" => "" . 'MADINAH' . "", //{kode faskes rujukam -> baca di referensi faskes}
                    ],
                    "catatan" => "-",
                    "diagAwal" => "" . '' . "",
                    "diagAwalNama" => "" . '' . "",
                    "poli" =>  [
                        "tujuan" => "IGD" . '' . "", //Untuk Kunjungan Internal beda poli dgn rujukan
                        "tujuanNama" => "Instalasi Gawat Darurat" . '' . "",
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
            $this->dataDaftarUgd['drId'] = $dataDokterBPJS->dr_id;
            $this->dataDaftarUgd['drDesc'] = $dataDokterBPJS->dr_name;

            $this->dataDaftarUgd['poliId'] = $dataDokterBPJS->poli_id;
            $this->dataDaftarUgd['poliDesc'] = $dataDokterBPJS->poli_desc;

            $this->dataDaftarUgd['kddrbpjs'] = $dataDokterBPJS->kd_dr_bpjs;
            $this->dataDaftarUgd['kdpolibpjs'] = $dataDokterBPJS->kd_poli_bpjs;

            // set dokter sep
            $this->SEPJsonReq['request']['t_sep']['dpjpLayan'] = $dataDokterBPJS->kd_dr_bpjs;
            $this->SEPJsonReq['request']['t_sep']['dpjpLayanNama'] = $dataDokterBPJS->dr_name;
            // $this->SEPJsonReq['request']['t_sep']['poli']['tujuan'] = $dataDokterBPJS->kd_poli_bpjs;
            // $this->SEPJsonReq['request']['t_sep']['poli']['tujuanNama'] = $dataDokterBPJS->poli_desc;


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

            $this->dataDaftarUgd['drId'] = '';
            $this->dataDaftarUgd['drDesc'] = '';
            $this->dataDaftarUgd['poliId'] = '';
            $this->dataDaftarUgd['poliDesc'] = '';
            $this->dataDaftarUgd['kddrbpjs'] = '';
            $this->dataDaftarUgd['kdpolibpjs'] = '';

            // set dokter sep
            $this->SEPJsonReq['request']['t_sep']['dpjpLayan'] = '';
            $this->SEPJsonReq['request']['t_sep']['dpjpLayanNama'] = '';
            // $this->SEPJsonReq['request']['t_sep']['poli']['tujuan'] = '';
            // $this->SEPJsonReq['request']['t_sep']['poli']['tujuanNama'] = '';
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
        $this->dataDaftarUgd['drId'] = $dataDokterBPJS->dr_id;
        $this->dataDaftarUgd['drDesc'] = $dataDokterBPJS->dr_name;

        $this->dataDaftarUgd['poliId'] = $dataDokterBPJS->poli_id;
        $this->dataDaftarUgd['poliDesc'] = $dataDokterBPJS->poli_desc;

        $this->dataDaftarUgd['kddrbpjs'] = $dataDokterBPJS->kd_dr_bpjs;
        $this->dataDaftarUgd['kdpolibpjs'] = $dataDokterBPJS->kd_poli_bpjs;

        // set dokter sep
        $this->SEPJsonReq['request']['t_sep']['dpjpLayan'] = $dataDokterBPJS->kd_dr_bpjs;

        $this->SEPJsonReq['request']['t_sep']['kodeDPJP']['dpjpLayanNama'] = $dataDokterBPJS->dr_name;
        // $this->SEPJsonReq['request']['t_sep']['poli']['tujuan'] = $dataDokterBPJS->kd_poli_bpjs;
        // $this->SEPJsonReq['request']['t_sep']['poli']['tujuanNama'] = $dataDokterBPJS->poli_desc;


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



    public function storeDataSepReq(): void
    {
        // jika jenis klaim JM (BPJS)
        if ($this->JenisKlaim['JenisKlaimId'] == 'JM') {

            //tambah logic untuk antrol
            //jika 1 kunjungan awal set data noRujukan
            //jika 2 internal set data -----
            //jika 3 kontrol set data no SKDP
            //jika 4 kunjungan awal dari RS set data noRujukan

            $this->dataDaftarUgd['noReferensi'] =
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

        $this->dataDaftarUgd['sep']['reqSep'] = $this->SEPJsonReq;
    }


    private function pushInsertSEP($SEPJsonReq)
    {
        // if sep kosong
        if (!$this->dataDaftarUgd['sep']['noSep']) {
            //ketika Push Tambah Antrean Berhasil buat SEP
            //////////////////////////////////////////////
            $HttpGetBpjs =  VclaimTrait::sep_insert($SEPJsonReq)->getOriginalContent();
            if ($HttpGetBpjs['metadata']['code'] == 200) {
                // dd($HttpGetBpjs);
                $this->dataDaftarUgd['sep']['resSep'] = $HttpGetBpjs['response']['sep'];
                $this->dataDaftarUgd['sep']['noSep'] = $HttpGetBpjs['response']['sep']['noSep'];

                $this->emit('toastr-success', 'SEP ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
            } else {
                $this->emit('toastr-error', 'SEP ' . $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
            }
        }
        // response sep value
        //ketika Push Tambah Antrean Berhasil buat SEP
        //////////////////////////////////////////////
    }


    public function cetakSEP()
    {
        // cek BPJS atau bukan
        if ($this->JenisKlaim['JenisKlaimId'] != 'JM') {
            $this->emit('toastr-error', 'Jenis Klaim ' . $this->JenisKlaim['JenisKlaimDesc']);
        } else {
            // cek ada resSep ada atau tidak
            if (!$this->dataDaftarUgd['sep']['resSep']) {

                // Http cek sep by no SEP
                //////////////////////////////////////////////
                $HttpGetBpjs =  VclaimTrait::sep_nomor($this->dataDaftarUgd['sep']['noSep'])->getOriginalContent();

                if ($HttpGetBpjs['metadata']['code'] == 200) {

                    $this->dataDaftarUgd['sep']['resSep'] = $HttpGetBpjs['response'];
                    $this->dataDaftarUgd['sep']['noSep'] = $HttpGetBpjs['response']['noSep'];

                    // update database
                    DB::table('rstxn_rjhdrs')
                        ->where('rj_no', $this->dataDaftarUgd['rjNo'])
                        ->update([
                            'datadaftarUgd_json' => json_encode($this->dataDaftarUgd, true),
                            'datadaftarUgd_xml' => ArrayToXml::convert($this->dataDaftarUgd),
                        ]);


                    $this->emit('toastr-success', 'CetakSEP ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                } else {
                    $this->emit('toastr-error', 'CetakSEP ' . $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                }
            } else {

                // cetak PDF
                $data = [
                    'data' => $this->dataDaftarUgd['sep']['resSep'],
                    'reqData' => $this->dataDaftarUgd['sep']['reqSep'],

                ];
                $pdfContent = PDF::loadView('livewire.daftar-r-j.cetak-sep', $data)->output();
                $this->emit('toastr-success', 'CetakSEP');

                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "filename.pdf"
                );
            }
        }
    }


    public function mount()
    {

        $this->setShiftnCurrentDate();
        if ($this->rjNo) {
            $this->findData($this->rjNo);
            $this->isOpenMode = 'update';
        }
    }

    public function render()
    {
        return view('livewire.daftar-u-g-d.form-entry-u-g-d.form-entry-u-g-d');
    }
}
