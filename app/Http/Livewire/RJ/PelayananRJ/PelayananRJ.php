<?php

namespace App\Http\Livewire\PelayananRJ;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;


use App\Http\Traits\BPJS\AntrianTrait;

use Spatie\ArrayToXml\ArrayToXml;


class PelayananRJ extends Component
{
    use WithPagination;



    //////////////////////////////
    // Ref on top bar start
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
    //////////////////////////////
    // Ref on top bar end
    //////////////////////////////

    public $dataDaftarPoliRJ = [];
    public  $dataPasien = [];
    public $taskIdPelayanan = [
        "taskId1" => "",
        "taskId2" => "",
        "taskId3" => "",
        "taskId4" => "",
        "taskId5" => "",
        "taskId6" => "",
        "taskId7" => "",
        "taskId99" => "",
    ];





    // limit record per page -resetExcept////////////////
    public $limitPerPage = 10;



    //



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
        'confirm_batal_poli_taskId' => 'batalPoli',
    ];



    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////





    // resert input private////////////////
    private function resetInputFields(): void
    {

        // resert validation
        $this->resetValidation();
        // resert input
        $this->resetExcept([
            'limitPerPage',
            'search',
            'dateRjRef',
            'shiftRjRef',
            'statusRjRef',
            'drRjRef'

        ]);
    }





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


    /////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////
    private function updateDataRJ($rjNo): void
    {

        // update table trnsaksi
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'datadaftarpolirj_json' => json_encode($this->dataDaftarPoliRJ, true),
                'datadaftarpolirj_xml' => ArrayToXml::convert($this->dataDaftarPoliRJ),
            ]);

        $this->emit('toastr-success', "Json Berhasil di update.");
    }

    private function findData($rjNo): void
    {


        $findData = DB::table('rsview_rjkasir')
            ->select('datadaftarpolirj_json', 'vno_sep', DB::raw("to_char(rj_date,'dd/mm/yyyy hh24:mi:ss') AS rj_date"))
            ->where('rj_no', $rjNo)
            ->first();


        if ($findData->datadaftarpolirj_json) {
            $this->dataDaftarPoliRJ = json_decode($findData->datadaftarpolirj_json, true);

            // jika taskId3 tidak ditemukan tambah variable kontrol pda array
            if (isset($this->dataDaftarPoliRJ['taskIdPelayanan']) == false) {
                $this->dataDaftarPoliRJ['taskIdPelayanan'] = $this->taskIdPelayanan;
                // update DB
                $this->updateDataRJ($rjNo);
            }

            $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId3'] = $findData->rj_date;
        } else {

            $this->emit('toastr-error', "Json Tidak ditemukan, Data sedang diproses ulang.");
            $dataDaftarPoliRJ = DB::table('rsview_rjkasir')
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

                    'nobooking',
                    'push_antrian_bpjs_status',
                    'push_antrian_bpjs_json',
                    'kd_dr_bpjs',
                    'kd_poli_bpjs',
                    'rj_status',
                    'txn_status',
                    'erm_status',
                )
                ->where('rj_no', '=', $rjNo)
                ->first();

            $this->dataDaftarPoliRJ = [
                "regNo" => "" . $dataDaftarPoliRJ->reg_no . "",

                "drId" => "" . $dataDaftarPoliRJ->dr_id . "",
                "drDesc" => "" . $dataDaftarPoliRJ->dr_name . "",

                "poliId" => "" . $dataDaftarPoliRJ->poli_id . "",
                "poliDesc" => "" . $dataDaftarPoliRJ->poli_desc . "",

                "kddrbpjs" => "" . $dataDaftarPoliRJ->kd_dr_bpjs . "",
                "kdpolibpjs" => "" . $dataDaftarPoliRJ->kd_poli_bpjs . "",

                "rjDate" => "" . $dataDaftarPoliRJ->rj_date . "",
                "rjNo" => "" . $dataDaftarPoliRJ->rj_no . "",
                "shift" => "" . $dataDaftarPoliRJ->shift . "",
                "noAntrian" => "" . $dataDaftarPoliRJ->no_antrian . "",
                "noBooking" => "" . $dataDaftarPoliRJ->nobooking . "",
                "slCodeFrom" => "02",
                "passStatus" => "",
                "rjStatus" => "" . $dataDaftarPoliRJ->rj_status . "",
                "txnStatus" => "" . $dataDaftarPoliRJ->txn_status . "",
                "ermStatus" => "" . $dataDaftarPoliRJ->erm_status . "",
                "cekLab" => "0",
                "kunjunganInternalStatus" => "0",
                "noReferensi" => "" . $dataDaftarPoliRJ->reg_no . "",
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
                    "taskId3" => "" . $dataDaftarPoliRJ->rj_date . "",
                    "taskId4" => "",
                    "taskId5" => "",
                    "taskId6" => "",
                    "taskId7" => "",
                    "taskId99" => "",
                ],
                'sep' => [
                    "noSep" => "" . $dataDaftarPoliRJ->vno_sep . "",
                    "reqSep" => [],
                    "resSep" => [],
                ]
            ];

            $this->dataDaftarPoliRJ['klaimId'] = $dataDaftarPoliRJ->klaim_id == 'JM' ? 'JM' : 'UM';
            $this->dataDaftarPoliRJ['JenisKlaimDesc'] = $dataDaftarPoliRJ->klaim_id == 'JM' ? 'BPJS' : 'UMUM';

            $this->dataDaftarPoliRJ['kunjunganId'] = '1';
            $this->dataDaftarPoliRJ['JenisKunjunganDesc'] = 'Rujukan FKTP';

            // jika kontrol tidak ditemukan tambah variable kontrol pda array
            // jika taskId3 tidak ditemukan tambah variable kontrol pda array
            if (isset($this->dataDaftarPoliRJ['taskIdPelayanan']) == false) {
                $this->dataDaftarPoliRJ['taskIdPelayanan'] = $this->taskIdPelayanan;
            }

            $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId3'] = $findData->rj_date;
            // update DB
            $this->updateDataRJ($rjNo);
        }

        $this->setDataPasien($this->dataDaftarPoliRJ['regNo']);
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

    public function masukPoli($rjNo)
    {

        $this->findData($rjNo);

        $sql = "select waktu_masuk_poli from rstxn_rjhdrs where rj_no=:rjNo";
        $cek_waktu_masuk_poli = DB::scalar($sql, ['rjNo' => $rjNo]);


        // ketika cek_waktu_masuk_poli kosong lalu update
        if (!$cek_waktu_masuk_poli) {
            $waktuMasukPoli = Carbon::now()->format('d/m/Y H:i:s');

            DB::table('rstxn_rjhdrs')
                ->where('rj_no', $rjNo)
                ->update([
                    'waktu_masuk_poli' => DB::raw("to_date('" . $waktuMasukPoli . "','dd/mm/yyyy hh24:mi:ss')"), //waktu masuk = rjdate
                ]);
        }

        /////////////////////////
        // Update TaskId 4
        /////////////////////////
        $sqlWaktuMasukPoli = "select to_char(waktu_masuk_poli,'dd/mm/yyyy hh24:mi:ss') as waktu_masuk_poli from rstxn_rjhdrs where rj_no=:rjNo";
        $waktuMasukPoli = DB::scalar($sqlWaktuMasukPoli, ['rjNo' => $rjNo]);

        if (!$this->dataDaftarPoliRJ['taskIdPelayanan']['taskId4']) {
            $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId4'] = $waktuMasukPoli;
            // update DB
            $this->updateDataRJ($rjNo);

            $this->emit('toastr-success', "Masuk Poli " . $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId4']);
        } else {
            $this->emit('toastr-error', "Masuk Poli " . $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId4']);
        }

        // cari no Booking
        $noBooking =  $this->dataDaftarPoliRJ['noBooking'];


        $waktu = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId4'])->timestamp * 1000; //waktu dalam timestamp milisecond
        $waktu = Carbon::now()->timestamp * 1000;
        $this->pushDataTaskId($noBooking, 4, $waktu);
    }


    public function keluarPoli($rjNo)
    {
        // SEMENTARA {WAKTU MASUK APT = WAKTU KELUAR POLI}
        $this->findData($rjNo);


        $sql = "select waktu_masuk_apt from rstxn_rjhdrs where rj_no=:rjNo";
        $cek_waktu_masuk_apt = DB::scalar($sql, ['rjNo' => $rjNo]);

        // ketika cek_waktu_masuk_apt kosong lalu update
        if (!$cek_waktu_masuk_apt) {
            $waktuMasukApotek = Carbon::now()->format('d/m/Y H:i:s');

            DB::table('rstxn_rjhdrs')
                ->where('rj_no', $rjNo)
                ->update([
                    'waktu_masuk_apt' => DB::raw("to_date('" . $waktuMasukApotek . "','dd/mm/yyyy hh24:mi:ss')"), //waktu masuk = rjdate
                ]);
        }

        /////////////////////////
        // Update TaskId 5         // SEMENTARA {WAKTU MASUK APT = WAKTU KELUAR POLI}
        /////////////////////////
        $sqlwaktuMasukApotek = "select to_char(waktu_masuk_apt,'dd/mm/yyyy hh24:mi:ss') as waktu_masuk_apt  from rstxn_rjhdrs where rj_no=:rjNo";
        $waktuMasukApotek = DB::scalar($sqlwaktuMasukApotek, ['rjNo' => $rjNo]);

        // check task Id 4 sudah dilakukan atau belum
        if ($this->dataDaftarPoliRJ['taskIdPelayanan']['taskId4']) {

            if (!$this->dataDaftarPoliRJ['taskIdPelayanan']['taskId5']) {
                $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId5'] = $waktuMasukApotek;
                // update DB
                $this->updateDataRJ($rjNo);

                $this->emit('toastr-success', "Keluar Poli " . $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId5']);
            } else {
                $this->emit('toastr-error', "Keluar Poli " . $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId5']);
            }

            // cari no Booking
            $noBooking =  $this->dataDaftarPoliRJ['noBooking'];

            // //////////////////////////
            // //////////////////////////
            // //////////////////////////

            // off kan jika memberatkan program
            // ulangi proses taskId start pushDataAntrian booking + task id 3
            // $this->pushDataAntrian($rjNo);

            // $waktu = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId3'])->timestamp * 1000; //waktu dalam timestamp milisecond
            // $this->pushDataTaskId($noBooking, 3, $waktu);

            // $waktu = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId4'])->timestamp * 1000; //waktu dalam timestamp milisecond
            // $this->pushDataTaskId($noBooking, 4, $waktu);
            // ulangi proses taskId end

            // //////////////////////////
            // //////////////////////////
            // //////////////////////////


            $waktu = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId5'])->timestamp * 1000; //waktu dalam timestamp milisecond
            $waktu = Carbon::now()->timestamp * 1000;
            $this->pushDataTaskId($noBooking, 5, $waktu);

            $this->emit('toastr-success', "Keluar Poli " . $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId5']);
        } else {
            $this->emit('toastr-error', "Satus Pasien Belum melalui pelayanan Poli");
        }
    }


    public function batalPoli($rjNo, $regName): void
    {

        $this->findData($rjNo);

        $waktuBatalPoli = Carbon::now()->format('d/m/Y H:i:s');

        /////////////////////////
        // Update TaskId 99 jika task id 5 sudah terisi maka tidak dapat dilakukan pembatalan
        /////////////////////////

        $waktu = Carbon::createFromFormat('d/m/Y H:i:s', $waktuBatalPoli)->timestamp * 1000; //waktu dalam timestamp milisecond

        if (!$this->dataDaftarPoliRJ['taskIdPelayanan']['taskId5']) {
            $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId99'] = $waktuBatalPoli;
            // cari no Booking
            $noBooking =  $this->dataDaftarPoliRJ['noBooking'];

            $this->pushDataTaskId($noBooking, 99, $waktu);

            // update DB
            $this->updateDataRJ($rjNo);

            $this->emit('toastr-success', "Pembatalan " . $regName . " pelayanan Poli berhasil dilakukan.");
        } else {
            $this->emit('toastr-error', "Pembatalan tidak dapat dilakukan, " . $regName . " sudak melakukan pelayanan Poli.");
        }
    }


    public function getListTaskId($noBooking): void
    {

        $HttpGetBpjs =  AntrianTrait::taskid_antrean($noBooking)->getOriginalContent();

        dd($HttpGetBpjs);
        $this->emit('toastr-success', 'Task Id' . $noBooking . ' ' . $HttpGetBpjs);
    }

    private function pushDataTaskId($noBooking, $taskId, $time): void
    {
        //////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////
        // Update Task Id $kodebooking, $taskid, $waktu, $jenisresep

        $waktu = $time;
        $HttpGetBpjs =  AntrianTrait::update_antrean($noBooking, $taskId, $waktu, "")->getOriginalContent();

        // set http response to public
        // $this->HttpGetBpjsStatus = $HttpGetBpjs['metadata']['code']; //status 200 201 400 ..
        // $this->HttpGetBpjsJson = json_encode($HttpGetBpjs, true); //Return Response Tambah Antrean

        // metadata d kecil
        if ($HttpGetBpjs['metadata']['code'] == 200) {
            $this->emit('toastr-success', 'Task Id' . $taskId . ' ' . $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
        } else {
            $this->emit('toastr-error', 'Task Id' . $taskId . ' ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);

            // Ulangi Proses pushTaskId;
            // $this->emit('rePush_Data_TaskId_Confirmation');
        }
    }



    private function pushDataAntrian($rjNo)
    {

        $this->findData($rjNo);
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
            $jadwal_estimasi = $hariLayananJamLayanan->addMinutes(10 * ($this->dataDaftarPoliRJ['noAntrian'] + 1)); // Hari Layanan||JamPraktek + 10menit
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
                "estimasidilayani" => $jadwal_estimasi->timestamp,
                "sisakuotajkn" => $JadwalPraktek['kuota'] - $this->dataDaftarPoliRJ['noAntrian'],
                "kuotajkn" => $JadwalPraktek['kuota'],
                "sisakuotanonjkn" => $JadwalPraktek['kuota'] - $this->dataDaftarPoliRJ['noAntrian'],
                "kuotanonjkn" => $JadwalPraktek['kuota'],
                "keterangan" => "Peserta harap 30 menit lebih awal guna pencatatan administrasi.",
            ];
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
        if ($cekAntrianAntreanBPJSStatus !== 200 || $cekAntrianAntreanBPJSStatus !== 208) {

            // Tambah Antrean
            $HttpGetBpjs =  AntrianTrait::tambah_antrean($antreanadd)->getOriginalContent();


            // 2 cek proses pada getHttp
            if ($HttpGetBpjs['metadata']['code'] == 200 || $HttpGetBpjs['metadata']['code'] == 208) {
                $this->emit('toastr-success', 'Tambah Antrian ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
            } else {
                $this->emit('toastr-error', 'Tambah Antrian ' . $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
            }
        }



        /////////////////////////
        // Update TaskId 3
        /////////////////////////
        if (!$this->dataDaftarPoliRJ['taskIdPelayanan']['taskId3']) {
            $waktu = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'])->timestamp * 1000; //waktu dalam timestamp milisecond
            // DB Json
            $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId3'] = $this->dataDaftarPoliRJ['rjDate'];
            $this->updateDataRJ($rjNo);
        }

        $waktu = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['taskIdPelayanan']['taskId3'])->timestamp * 1000; //waktu dalam timestamp milisecond
        $noBooking = $this->dataDaftarPoliRJ['noBooking'];
        $this->pushDataTaskId($noBooking, 3, $waktu);
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
                'push_antrian_bpjs_json',
                'waktu_masuk_poli',
                'waktu_masuk_apt',
                'datadaftarpolirj_json'
            )
            ->where('rj_status', '=', $this->statusRjRef['statusId'])
            // ->where('shift', '=', $this->shiftRjRef['shiftId'])
            ->where('klaim_id', '!=', 'KR')
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
            'livewire.pelayanan-r-j.pelayanan-r-j',
            [
                'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Antrian Pasien Rawat Jalan',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
                'myLimitPerPages' => [5, 10, 15, 20, 100],
            ]
        );
    }
    // select data end////////////////
}
