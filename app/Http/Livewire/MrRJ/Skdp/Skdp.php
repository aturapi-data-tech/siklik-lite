<?php

namespace App\Http\Livewire\MrRJ\Skdp;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\BPJS\AntrianTrait;
use App\Http\Traits\BPJS\VclaimTrait;


use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;


class Skdp extends Component
{
    use WithPagination;


    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef = '430269';



    // dataDaftarPoliRJ RJ
    public $dataDaftarPoliRJ = [];

    // data SKDP / kontrol=>[] 
    public $kontrol = [
        'noKontrolRS' => "",
        'noSKDPBPJS' => "",
        'noAntrian' => "",
        'tglKontrol' => "",
        'poliKontrol' => "",
        'poliKontrolBPJS' => "",
        'poliKontrolDesc' => "",
        'drKontrol' => "",
        'drKontrolBPJS' => "",
        'drKontrolDesc' => "",
        'catatan' => "",
        'noSEP' => "",
    ];
    //////////////////////////////////////////////////////////////////////


    //  table LOV////////////////

    public $dataDokterLov = [];
    public $dataDokterLovStatus = 0;
    public $dataDokterLovSearch = '';


    // listener from blade////////////////
    protected $listeners = [
        'xxxxx' => 'xxxxx',
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
            'rjNoRef'
        ]);
    }





    // ////////////////
    // RJ Logic
    // ////////////////

    //////////////////////////////////////////////
    // updated when change Record ////////////////
    ///////////////////////////////////////////////



    //////////////////////////////////////////////
    // updated when change Record ////////////////
    ///////////////////////////////////////////////

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


        if ($findData->datadaftarpolirj_json) {
            $this->dataDaftarPoliRJ = json_decode($findData->datadaftarpolirj_json, true);

            // jika kontrol tidak ditemukan tambah variable kontrol pda array
            if (isset($this->dataDaftarPoliRJ['kontrol']) == false) {
                $this->dataDaftarPoliRJ['kontrol'] = $this->kontrol;
            }

            $this->dataDaftarPoliRJ['kontrol']['tglKontrol'] = $this->dataDaftarPoliRJ['kontrol']['tglKontrol']
                ? $this->dataDaftarPoliRJ['kontrol']['tglKontrol']
                : Carbon::now()->addDays(8)->format('d/m/Y');
            $this->dataDaftarPoliRJ['kontrol']['drKontrol'] = $this->dataDaftarPoliRJ['kontrol']['drKontrol']
                ? $this->dataDaftarPoliRJ['kontrol']['drKontrol']
                : $this->dataDaftarPoliRJ['drId'];
            $this->dataDaftarPoliRJ['kontrol']['drKontrolDesc'] = $this->dataDaftarPoliRJ['kontrol']['drKontrolDesc']
                ? $this->dataDaftarPoliRJ['kontrol']['drKontrolDesc']
                : $this->dataDaftarPoliRJ['drDesc'];
            $this->dataDaftarPoliRJ['kontrol']['drKontrolBPJS'] =  $this->dataDaftarPoliRJ['kontrol']['drKontrolBPJS']
                ? $this->dataDaftarPoliRJ['kontrol']['drKontrolBPJS']
                : $this->dataDaftarPoliRJ['kddrbpjs'];
            $this->dataDaftarPoliRJ['kontrol']['poliKontrol'] = $this->dataDaftarPoliRJ['kontrol']['poliKontrol']
                ? $this->dataDaftarPoliRJ['kontrol']['poliKontrol']
                : $this->dataDaftarPoliRJ['poliId'];
            $this->dataDaftarPoliRJ['kontrol']['poliKontrolDesc'] = $this->dataDaftarPoliRJ['kontrol']['poliKontrolDesc']
                ? $this->dataDaftarPoliRJ['kontrol']['poliKontrolDesc']
                : $this->dataDaftarPoliRJ['poliDesc'];
            $this->dataDaftarPoliRJ['kontrol']['poliKontrolBPJS'] = $this->dataDaftarPoliRJ['kontrol']['poliKontrolBPJS']
                ? $this->dataDaftarPoliRJ['kontrol']['poliKontrolBPJS']
                : $this->dataDaftarPoliRJ['kdpolibpjs'];
            $this->dataDaftarPoliRJ['kontrol']['noSEP'] = $this->dataDaftarPoliRJ['kontrol']['noSEP']
                ? $this->dataDaftarPoliRJ['kontrol']['noSEP']
                : $findData->vno_sep;
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

            $this->dataDaftarPoliRJ['klaimId'] = $dataDaftarPoliRJ->klaim_id == 'JM' ? 'JM' : 'UM';
            $this->dataDaftarPoliRJ['JenisKlaimDesc'] = $dataDaftarPoliRJ->klaim_id == 'JM' ? 'BPJS' : 'UMUM';

            $this->dataDaftarPoliRJ['kunjunganId'] = '1';
            $this->dataDaftarPoliRJ['JenisKunjunganDesc'] = 'Rujukan FKTP';


            // jika kontrol tidak ditemukan tambah variable kontrol pda array
            if (isset($this->dataDaftarPoliRJ['kontrol']) == false) {
                $this->dataDaftarPoliRJ['kontrol'] = $this->kontrol;
            }



            // setDataKontrol
            $this->dataDaftarPoliRJ['kontrol']['tglKontrol'] = $this->dataDaftarPoliRJ['kontrol']['tglKontrol']
                ? $this->dataDaftarPoliRJ['kontrol']['tglKontrol']
                : Carbon::now()->addDays(8)->format('d/m/Y');
            $this->dataDaftarPoliRJ['kontrol']['drKontrol'] = $this->dataDaftarPoliRJ['kontrol']['drKontrol']
                ? $this->dataDaftarPoliRJ['kontrol']['drKontrol']
                : $dataDaftarPoliRJ->dr_id;
            $this->dataDaftarPoliRJ['kontrol']['drKontrolDesc'] = $this->dataDaftarPoliRJ['kontrol']['drKontrolDesc']
                ? $this->dataDaftarPoliRJ['kontrol']['drKontrolDesc']
                : $dataDaftarPoliRJ->dr_name;
            $this->dataDaftarPoliRJ['kontrol']['drKontrolBPJS'] =  $this->dataDaftarPoliRJ['kontrol']['drKontrolBPJS']
                ? $this->dataDaftarPoliRJ['kontrol']['drKontrolBPJS']
                : $dataDaftarPoliRJ->kd_dr_bpjs;
            $this->dataDaftarPoliRJ['kontrol']['poliKontrol'] = $this->dataDaftarPoliRJ['kontrol']['poliKontrol']
                ? $this->dataDaftarPoliRJ['kontrol']['poliKontrol']
                : $dataDaftarPoliRJ->poli_id;
            $this->dataDaftarPoliRJ['kontrol']['poliKontrolDesc'] = $this->dataDaftarPoliRJ['kontrol']['poliKontrolDesc']
                ? $this->dataDaftarPoliRJ['kontrol']['poliKontrolDesc']
                : $dataDaftarPoliRJ->poli_desc;
            $this->dataDaftarPoliRJ['kontrol']['poliKontrolBPJS'] = $this->dataDaftarPoliRJ['kontrol']['poliKontrolBPJS']
                ? $this->dataDaftarPoliRJ['kontrol']['poliKontrolBPJS']
                : $dataDaftarPoliRJ->kd_poli_bpjs;
            $this->dataDaftarPoliRJ['kontrol']['noSEP'] = $this->dataDaftarPoliRJ['kontrol']['noSEP']
                ? $this->dataDaftarPoliRJ['kontrol']['noSEP']
                : $dataDaftarPoliRJ->vno_sep;
        }
    }

    // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
    private function setDataPrimer(): void
    {
        $noKontrol = Carbon::now()->addDays(8)->format('dmY') . $this->dataDaftarPoliRJ['kontrol']['drKontrol'] . $this->dataDaftarPoliRJ['kontrol']['poliKontrol'];
        $this->dataDaftarPoliRJ['kontrol']['noKontrolRS'] =  $this->dataDaftarPoliRJ['kontrol']['noKontrolRS'] ? $this->dataDaftarPoliRJ['kontrol']['noKontrolRS'] : $noKontrol;
    }




    // ////////////////
    // Antrol Logic
    // ////////////////


    private function pushSuratKontrolBPJS(): void
    {


        //push data SuratKontrolBPJS
        if ($this->dataDaftarPoliRJ['klaimId'] = 'JM') {


            // jika SKDP kosong lakukan push data
            // insert
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
            'livewire.mr-r-j.skdp.skdp',
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
