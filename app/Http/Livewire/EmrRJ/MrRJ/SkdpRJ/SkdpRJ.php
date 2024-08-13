<?php

namespace App\Http\Livewire\EmrRJ\MrRJ\SkdpRJ;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\BPJS\AntrianTrait;
use App\Http\Traits\BPJS\VclaimTrait;


use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;
use Barryvdh\DomPDF\Facade\Pdf;



class SkdpRJ extends Component
{
    use WithPagination;

    // listener from blade////////////////
    protected $listeners = [
        'syncronizeAssessmentPerawatRJFindData' => 'mount'

    ];

    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef;



    // dataDaftarPoliRJ RJ
    public array $dataDaftarPoliRJ = [];
    public array $dataPasien = [];

    // data SKDP / kontrol=>[] 
    public $kontrol = [
        // 'noKontrolRS' => "",
        // 'noSKDPBPJS' => "",
        // 'noAntrian' => "",
        // 'tglKontrol' => "",
        // 'poliKontrol' => "",
        // 'poliKontrolBPJS' => "",
        // 'poliKontrolDesc' => "",
        // 'drKontrol' => "",
        // 'drKontrolBPJS' => "",
        // 'drKontrolDesc' => "",
        // 'catatan' => "",
        // 'noSEP' => "",
    ];
    //////////////////////////////////////////////////////////////////////


    //  table LOV////////////////

    public $dataDokterLov = [];
    public $dataDokterLovStatus = 0;
    public $dataDokterLovSearch = '';





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
            'rjNoRef'
        ]);
    }





    // ////////////////
    // RJ Logic
    // ////////////////

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
            $this->dataDaftarPoliRJ['kontrol']['drKontrol'] = $dataDokter->dr_id;
            $this->dataDaftarPoliRJ['kontrol']['drKontrolDesc'] = $dataDokter->dr_name;

            $this->dataDaftarPoliRJ['kontrol']['poliKontrol'] = $dataDokter->poli_id;
            $this->dataDaftarPoliRJ['kontrol']['poliKontrolDesc'] = $dataDokter->poli_desc;

            $this->dataDaftarPoliRJ['kontrol']['drKontrolBPJS'] = $dataDokter->kd_dr_bpjs;
            $this->dataDaftarPoliRJ['kontrol']['poliKontrolBPJS'] = $dataDokter->kd_poli_bpjs;

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
            $this->dataDaftarPoliRJ['kontrol']['drKontrol'] = '';
            $this->dataDaftarPoliRJ['kontrol']['drKontrolDesc'] = '';

            $this->dataDaftarPoliRJ['kontrol']['poliKontrol'] = '';
            $this->dataDaftarPoliRJ['kontrol']['poliKontrolDesc'] = '';

            $this->dataDaftarPoliRJ['kontrol']['drKontrolBPJS'] = '';
            $this->dataDaftarPoliRJ['kontrol']['poliKontrolBPJS'] = '';
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
        $this->dataDaftarPoliRJ['kontrol']['drKontrol'] = $dataDokter->dr_id;
        $this->dataDaftarPoliRJ['kontrol']['drKontrolDesc'] = $dataDokter->dr_name;

        $this->dataDaftarPoliRJ['kontrol']['poliKontrol'] = $dataDokter->poli_id;
        $this->dataDaftarPoliRJ['kontrol']['poliKontrolDesc'] = $dataDokter->poli_desc;

        $this->dataDaftarPoliRJ['kontrol']['drKontrolBPJS'] = $dataDokter->kd_dr_bpjs;
        $this->dataDaftarPoliRJ['kontrol']['poliKontrolBPJS'] = $dataDokter->kd_poli_bpjs;

        $this->dataDokterLovStatus = false;
        $this->dataDokterLovSearch = '';
    }
    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataDokterRJ //////////////////////
    ////////////////////////////////////////////////


    // validate Data RJ//////////////////////////////////////////////////
    private function validateDataRJ(): void
    {
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();

        // require nik ketika pasien tidak dikenal



        $rules = [

            "dataDaftarPoliRJ.kontrol.noKontrolRS" => "required",

            "dataDaftarPoliRJ.kontrol.noSKDPBPJS" => "",
            "dataDaftarPoliRJ.kontrol.noAntrian" => "",

            "dataDaftarPoliRJ.kontrol.tglKontrol" => "bail|required|date_format:d/m/Y",

            "dataDaftarPoliRJ.kontrol.drKontrol" => "required",
            "dataDaftarPoliRJ.kontrol.drKontrolDesc" => "required",
            "dataDaftarPoliRJ.kontrol.drKontrolBPJS" => "",


            "dataDaftarPoliRJ.kontrol.poliKontrol" => "required",
            "dataDaftarPoliRJ.kontrol.poliKontrolDesc" => "required",
            "dataDaftarPoliRJ.kontrol.poliKontrolBPJS" => "",

            "dataDaftarPoliRJ.kontrol.catatan" => "",

        ];



        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $this->emit('toastr-error', "Lakukan Pengecekan kembali Input Data.");
            $this->validate($rules, $messages);
        }
    }


    // insert and update record start////////////////
    public function store()
    {
        // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
        $this->setDataPrimer();

        //  off sementara
        $this->pushSuratKontrolBPJS();

        // Validate RJ
        $this->validateDataRJ();

        // Logic update mode start //////////
        $this->updateDataRJ($this->dataDaftarPoliRJ['rjNo']);
        $this->emit('syncronizeAssessmentPerawatRJFindData');
    }

    private function updateDataRJ($rjNo): void
    {

        // update table trnsaksi
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'datadaftarpolirj_json' => json_encode($this->dataDaftarPoliRJ, true),
                'datadaftarpolirj_xml' => ArrayToXml::convert($this->dataDaftarPoliRJ),
            ]);

        $this->emit('toastr-success', "Surat Kontrol berhasil disimpan.");
    }
    // insert and update record end////////////////


    private function findData($rjno): void
    {


        $findData = DB::table('rsview_rjkasir')
            ->select('datadaftarpolirj_json', 'vno_sep')
            ->where('rj_no', $rjno)
            ->first();


        $dataDaftarPoliRJ_json = isset($findData->datadaftarpolirj_json) ? $findData->datadaftarpolirj_json : null;
        // if meta_data_pasien_json = null
        // then cari Data Pasien By Key Collection (exception when no data found)
        // 
        // else json_decode

        if ($dataDaftarPoliRJ_json) {
            $this->dataDaftarPoliRJ = json_decode($findData->datadaftarpolirj_json, true);

            // jika kontrol tidak ditemukan tambah variable kontrol pda array
            if (isset($this->dataDaftarPoliRJ['kontrol']) == false) {

                $this->dataDaftarPoliRJ['kontrol']['tglKontrol'] =  Carbon::now()->addDays(8)->format('d/m/Y');
                $this->dataDaftarPoliRJ['kontrol']['drKontrol'] =  (isset($this->dataDaftarPoliRJ['drId'])
                    ? ($this->dataDaftarPoliRJ['drId']
                        ? $this->dataDaftarPoliRJ['drId']
                        : '')
                    : '');
                $this->dataDaftarPoliRJ['kontrol']['drKontrolDesc'] = (isset($this->dataDaftarPoliRJ['drDesc'])
                    ? ($this->dataDaftarPoliRJ['drDesc']
                        ? $this->dataDaftarPoliRJ['drDesc']
                        : '')
                    : '');
                $this->dataDaftarPoliRJ['kontrol']['drKontrolBPJS'] = (isset($this->dataDaftarPoliRJ['kddrbpjs'])
                    ? ($this->dataDaftarPoliRJ['kddrbpjs']
                        ? $this->dataDaftarPoliRJ['kddrbpjs']
                        : '')
                    : '');
                $this->dataDaftarPoliRJ['kontrol']['poliKontrol'] = (isset($this->dataDaftarPoliRJ['poliId'])
                    ? ($this->dataDaftarPoliRJ['poliId']
                        ? $this->dataDaftarPoliRJ['poliId']
                        : '')
                    : '');
                $this->dataDaftarPoliRJ['kontrol']['poliKontrolDesc'] = (isset($this->dataDaftarPoliRJ['poliDesc'])
                    ? ($this->dataDaftarPoliRJ['poliDesc']
                        ? $this->dataDaftarPoliRJ['poliDesc']
                        : '')
                    : '');
                $this->dataDaftarPoliRJ['kontrol']['poliKontrolBPJS'] = (isset($this->dataDaftarPoliRJ['kdpolibpjs'])
                    ? ($this->dataDaftarPoliRJ['kdpolibpjs']
                        ? $this->dataDaftarPoliRJ['kdpolibpjs']
                        : '')
                    : '');
                $this->dataDaftarPoliRJ['kontrol']['noSEP'] = (isset($findData->vno_sep)
                    ? ($findData->vno_sep
                        ? $findData->vno_sep
                        : '')
                    : '');
            }
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
                ->where('rj_no', '=', $rjno)
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


            // jika kontrol tidak ditemukan tambah variable kontrol pda array
            if (isset($this->dataDaftarPoliRJ['kontrol']) == false) {

                $this->dataDaftarPoliRJ['kontrol']['tglKontrol'] =  Carbon::now()->addDays(8)->format('d/m/Y');
                $this->dataDaftarPoliRJ['kontrol']['drKontrol'] =  (isset($this->dataDaftarPoliRJ['drId'])
                    ? ($this->dataDaftarPoliRJ['drId']
                        ? $this->dataDaftarPoliRJ['drId']
                        : '')
                    : '');
                $this->dataDaftarPoliRJ['kontrol']['drKontrolDesc'] = (isset($this->dataDaftarPoliRJ['drDesc'])
                    ? ($this->dataDaftarPoliRJ['drDesc']
                        ? $this->dataDaftarPoliRJ['drDesc']
                        : '')
                    : '');
                $this->dataDaftarPoliRJ['kontrol']['drKontrolBPJS'] = (isset($this->dataDaftarPoliRJ['kddrbpjs'])
                    ? ($this->dataDaftarPoliRJ['kddrbpjs']
                        ? $this->dataDaftarPoliRJ['kddrbpjs']
                        : '')
                    : '');
                $this->dataDaftarPoliRJ['kontrol']['poliKontrol'] = (isset($this->dataDaftarPoliRJ['poliId'])
                    ? ($this->dataDaftarPoliRJ['poliId']
                        ? $this->dataDaftarPoliRJ['poliId']
                        : '')
                    : '');
                $this->dataDaftarPoliRJ['kontrol']['poliKontrolDesc'] = (isset($this->dataDaftarPoliRJ['poliDesc'])
                    ? ($this->dataDaftarPoliRJ['poliDesc']
                        ? $this->dataDaftarPoliRJ['poliDesc']
                        : '')
                    : '');
                $this->dataDaftarPoliRJ['kontrol']['poliKontrolBPJS'] = (isset($this->dataDaftarPoliRJ['kdpolibpjs'])
                    ? ($this->dataDaftarPoliRJ['kdpolibpjs']
                        ? $this->dataDaftarPoliRJ['kdpolibpjs']
                        : '')
                    : '');
                $this->dataDaftarPoliRJ['kontrol']['noSEP'] = (isset($dataDaftarPoliRJ->vno_sep)
                    ? ($dataDaftarPoliRJ->vno_sep
                        ? $dataDaftarPoliRJ->vno_sep
                        : '')
                    : '');
            }
        }
    }

    // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
    private function setDataPrimer(): void
    {
        $noKontrol = Carbon::now()->addDays(8)->format('dmY') . $this->dataDaftarPoliRJ['kontrol']['drKontrol'] . $this->dataDaftarPoliRJ['kontrol']['poliKontrol'];
        $this->dataDaftarPoliRJ['kontrol']['noKontrolRS'] = (isset($this->dataDaftarPoliRJ['kontrol']['noKontrolRS'])
            ? ($this->dataDaftarPoliRJ['kontrol']['noKontrolRS']
                ? $this->dataDaftarPoliRJ['kontrol']['noKontrolRS']
                : $noKontrol)
            : $noKontrol);
    }




    // ////////////////
    // Antrol Logic
    // ////////////////


    private function pushSuratKontrolBPJS(): void
    {


        //push data SuratKontrolBPJS
        if ($this->dataDaftarPoliRJ['klaimId'] == 'JM') {

            // jika SKDP kosong lakukan push data
            // insert
            if (!isset($this->dataDaftarPoliRJ['kontrol']['noSKDPBPJS'])) {

                $this->dataDaftarPoliRJ['kontrol']['noSKDPBPJS'] = '';

                if (!$this->dataDaftarPoliRJ['kontrol']['noSKDPBPJS']) {
                    $HttpGetBpjs =  VclaimTrait::suratkontrol_insert($this->dataDaftarPoliRJ['kontrol'])->getOriginalContent();

                    // 2 cek proses pada getHttp
                    if ($HttpGetBpjs['metadata']['code'] == 200) {
                        $this->emit('toastr-success', 'KONTROL ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                        $this->dataDaftarPoliRJ['kontrol']['noSKDPBPJS'] = $HttpGetBpjs['response']['noSuratKontrol']; //status 200 201 400 ..

                        $this->emit('toastr-success', 'KONTROL ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                    } else {
                        $this->emit('toastr-error', 'KONTROL ' . $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                    }
                }
            } else {
                // update
                $HttpGetBpjs =  VclaimTrait::suratkontrol_update($this->dataDaftarPoliRJ['kontrol'])->getOriginalContent();

                if ($HttpGetBpjs['metadata']['code'] == 200) {
                    $this->emit('toastr-success', 'UPDATEKONTROL ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                    // $this->dataDaftarPoliRJ['kontrol']['noSKDPBPJS'] = $HttpGetBpjs['metadata']['response']['noSuratKontrol']; //status 200 201 400 ..

                    $this->emit('toastr-success', 'UPDATEKONTROL ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                } else {
                    $this->emit('toastr-error', 'UPDATEKONTROL ' . $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                }
            }
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
            if ($findData) {
                $this->dataPasien['pasien']['regDate'] = $findData->reg_date;
                $this->dataPasien['pasien']['regNo'] = $findData->reg_no;
                $this->dataPasien['pasien']['regName'] = $findData->reg_name;
                $this->dataPasien['pasien']['identitas']['idbpjs'] = $findData->nokartu_bpjs;
                $this->dataPasien['pasien']['identitas']['nik'] = $findData->nik_bpjs;
                $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] = ($findData->sex == 'L') ? 1 : 2;
                $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] = ($findData->sex == 'L') ? 'Laki-laki' : 'Perempuan';
                $this->dataPasien['pasien']['tglLahir'] = $findData->birth_date;
                $this->dataPasien['pasien']['thn'] = Carbon::createFromFormat('d/m/Y', $findData->birth_date)->diff(Carbon::now())->format('%y Thn, %m Bln %d Hr'); //$findData->thn;
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
            } else {
                // when no data found
                $this->dataPasien['pasien']['regDate'] = '-';
                $this->dataPasien['pasien']['regNo'] = '-';
                $this->dataPasien['pasien']['regName'] = '-';
                $this->dataPasien['pasien']['identitas']['idbpjs'] = '-';
                $this->dataPasien['pasien']['identitas']['nik'] = '-';
                $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] = '-';
                $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] = '-';
                $this->dataPasien['pasien']['tglLahir'] = '-';
                $this->dataPasien['pasien']['thn'] = '-';
                $this->dataPasien['pasien']['bln'] = '-';
                $this->dataPasien['pasien']['hari'] = '-';
                $this->dataPasien['pasien']['tempatLahir'] = '-';
                $this->dataPasien['pasien']['golonganDarah']['golonganDarahId'] = '-';
                $this->dataPasien['pasien']['golonganDarah']['golonganDarahDesc'] = '-';
                $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanId'] = '-';
                $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanDesc'] = '-';

                $this->dataPasien['pasien']['agama']['agamaId'] = '-';
                $this->dataPasien['pasien']['agama']['agamaDesc'] = '-';

                $this->dataPasien['pasien']['pendidikan']['pendidikanId'] = '-';
                $this->dataPasien['pasien']['pendidikan']['pendidikanDesc'] = '-';

                $this->dataPasien['pasien']['pekerjaan']['pekerjaanId'] = '-';
                $this->dataPasien['pasien']['pekerjaan']['pekerjaanDesc'] = '-';


                $this->dataPasien['pasien']['hubungan']['namaPenanggungJawab'] = '-';
                $this->dataPasien['pasien']['hubungan']['namaIbu'] = '-';

                $this->dataPasien['pasien']['identitas']['nik'] = '-';
                $this->dataPasien['pasien']['identitas']['idBpjs'] = '-';


                $this->dataPasien['pasien']['identitas']['alamat'] = '-';

                $this->dataPasien['pasien']['identitas']['desaId'] = '-';
                $this->dataPasien['pasien']['identitas']['desaName'] = '-';

                $this->dataPasien['pasien']['identitas']['rt'] = '-';
                $this->dataPasien['pasien']['identitas']['rw'] = '-';
                $this->dataPasien['pasien']['identitas']['kecamatanId'] = '-';
                $this->dataPasien['pasien']['identitas']['kecamatanName'] = '-';

                $this->dataPasien['pasien']['identitas']['kotaId'] = '-';
                $this->dataPasien['pasien']['identitas']['kotaName'] = '-';

                $this->dataPasien['pasien']['identitas']['propinsiId'] = '-';
                $this->dataPasien['pasien']['identitas']['propinsiName'] = '-';

                $this->dataPasien['pasien']['kontak']['nomerTelponSelulerPasien'] = '-';

                $this->dataPasien['pasien']['hubungan']['namaPenanggungJawab'] = '-';
                $this->dataPasien['pasien']['hubungan']['namaIbu'] = '-';
            }
        } else {
            // ubah data Pasien
            $this->dataPasien = json_decode($findData->meta_data_pasien_json, true);
            $this->dataPasien['pasien']['thn'] = Carbon::createFromFormat('d/m/Y', $this->dataPasien['pasien']['tglLahir'])->diff(Carbon::now())->format('%y Thn, %m Bln %d Hr'); //$findData->thn;


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


    public function cetakSKDP()
    {
        $queryIdentitas = DB::table('rsmst_identitases')
            ->select(
                'int_name',
                'int_phone1',
                'int_phone2',
                'int_fax',
                'int_address',
                'int_city',
            )
            ->first();

        // cek ada resSep ada atau tidak
        if (isset($this->dataDaftarPoliRJ['kontrol'])) {
            if ($this->dataDaftarPoliRJ['kontrol']) {

                if (isset($this->dataDaftarPoliRJ['regNo'])) {
                    $this->setDataPasien($this->dataDaftarPoliRJ['regNo']);
                }

                $data = [
                    'myQueryIdentitas' => $queryIdentitas,
                    'dataPasien' => $this->dataPasien,
                    'dataDaftarTxn' => $this->dataDaftarPoliRJ,

                ];
                $pdfContent = PDF::loadView('livewire.emr-r-j.mr-r-j.skdp-r-j.cetak-skdp-rj', $data)->output();
                $this->emit('toastr-success', 'CetakSKDP');

                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "filename.pdf"
                );
            }
        }
    }


    // when new form instance
    public function mount()
    {
        $this->findData($this->rjNoRef);
        // set data dokter ref
        // $this->store();
    }



    // select data start////////////////
    public function render()
    {

        return view(
            'livewire.emr-r-j.mr-r-j.skdp-r-j.skdp-r-j',
            [
                // 'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Data SKDP Pasien Rawat Jalan',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
            ]
        );
    }
    // select data end////////////////


}
