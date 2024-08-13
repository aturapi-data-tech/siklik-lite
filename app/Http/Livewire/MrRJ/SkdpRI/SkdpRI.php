<?php

namespace App\Http\Livewire\MrRJ\SkdpRI;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\BPJS\AntrianTrait;
use App\Http\Traits\BPJS\VclaimTrait;


use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;


class SkdpRI extends Component
{
    use WithPagination;
    // listener from blade////////////////
    protected $listeners = [
        'syncronizeAssessmentPerawatRJFindData' => 'mount'

    ];

    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $riNoRef = '47864';



    // dataDaftarRi RJ
    public $dataDaftarRi = [];

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
            'riNoRef'
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
            ->where('rsmst_doctors.active_status', '1')

            ->first();

        if ($dataDokter) {
            $this->dataDaftarRi['kontrol']['drKontrol'] = $dataDokter->dr_id;
            $this->dataDaftarRi['kontrol']['drKontrolDesc'] = $dataDokter->dr_name;

            $this->dataDaftarRi['kontrol']['poliKontrol'] = $dataDokter->poli_id;
            $this->dataDaftarRi['kontrol']['poliKontrolDesc'] = $dataDokter->poli_desc;

            $this->dataDaftarRi['kontrol']['drKontrolBPJS'] = $dataDokter->kd_dr_bpjs;
            $this->dataDaftarRi['kontrol']['poliKontrolBPJS'] = $dataDokter->kd_poli_bpjs;

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
            $this->dataDaftarRi['kontrol']['drKontrol'] = "";
            $this->dataDaftarRi['kontrol']['drKontrolDesc'] = "";

            $this->dataDaftarRi['kontrol']['poliKontrol'] = "";
            $this->dataDaftarRi['kontrol']['poliKontrolDesc'] = "";

            $this->dataDaftarRi['kontrol']['drKontrolBPJS'] = "";
            $this->dataDaftarRi['kontrol']['poliKontrolBPJS'] = "";
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
        $this->dataDaftarRi['kontrol']['drKontrol'] = $dataDokter->dr_id;
        $this->dataDaftarRi['kontrol']['drKontrolDesc'] = $dataDokter->dr_name;

        $this->dataDaftarRi['kontrol']['poliKontrol'] = $dataDokter->poli_id;
        $this->dataDaftarRi['kontrol']['poliKontrolDesc'] = $dataDokter->poli_desc;

        $this->dataDaftarRi['kontrol']['drKontrolBPJS'] = $dataDokter->kd_dr_bpjs;
        $this->dataDaftarRi['kontrol']['poliKontrolBPJS'] = $dataDokter->kd_poli_bpjs;

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

            "dataDaftarRi.kontrol.noKontrolRS" => "required",

            "dataDaftarRi.kontrol.noSKDPBPJS" => "",
            "dataDaftarRi.kontrol.noAntrian" => "",

            "dataDaftarRi.kontrol.tglKontrol" => "bail|required|date_format:d/m/Y",

            "dataDaftarRi.kontrol.drKontrol" => "required",
            "dataDaftarRi.kontrol.drKontrolDesc" => "required",
            "dataDaftarRi.kontrol.drKontrolBPJS" => "",


            "dataDaftarRi.kontrol.poliKontrol" => "required",
            "dataDaftarRi.kontrol.poliKontrolDesc" => "required",
            "dataDaftarRi.kontrol.poliKontrolBPJS" => "",

            "dataDaftarRi.kontrol.catatan" => "",

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
        // set data RiHdrNo / NoBooking / NoAntrian / klaimId / kunjunganId
        $this->setDataPrimer();

        //  off sementara
        $this->pushSuratKontrolBPJS();

        // Validate RJ
        $this->validateDataRJ();

        // Logic update mode start //////////
        $this->updateDataRJ($this->dataDaftarRi['riHdrNo']);
        $this->emit('syncronizeAssessmentPerawatRJFindData');
    }

    private function updateDataRJ($riNo): void
    {

        // update table trnsaksi
        DB::table('rstxn_rihdrs')
            ->where('rihdr_no', $riNo)
            ->update([
                'datadaftarri_json' => json_encode($this->dataDaftarRi, true),
                'datadaftarRi_xml' => ArrayToXml::convert($this->dataDaftarRi),
            ]);

        $this->emit('toastr-success', "Surat Kontrol berhasil disimpan.");
    }
    // insert and update record end////////////////


    private function findData($rino): void
    {


        $findData = DB::table('rsview_rihdrs')
            ->select('datadaftarri_json', 'vno_sep')
            ->where('rihdr_no', $rino)
            ->first();

        $datadaftarRI_json = isset($findData->datadaftarri_json) ? $findData->datadaftarri_json : null;
        // if meta_data_pasien_json = null
        // then cari Data Pasien By Key Collection (exception when no data found)
        // 
        // else json_decode

        if ($datadaftarRI_json) {
            $this->dataDaftarRi = json_decode($findData->datadaftarri_json, true);



            // jika kontrol tidak ditemukan tambah variable kontrol pda array
            if (isset($this->dataDaftarRi['kontrol']) == false) {
                $this->dataDaftarRi['kontrol']['tglKontrol'] =  Carbon::now()->addDays(8)->format('d/m/Y');
                $this->dataDaftarRi['kontrol']['drKontrol'] =  (isset($this->dataDaftarRi['drId'])
                    ? ($this->dataDaftarRi['drId']
                        ? $this->dataDaftarRi['drId']
                        : '')
                    : '');
                $this->dataDaftarRi['kontrol']['drKontrolDesc'] = (isset($this->dataDaftarRi['drDesc'])
                    ? ($this->dataDaftarRi['drDesc']
                        ? $this->dataDaftarRi['drDesc']
                        : '')
                    : '');
                $this->dataDaftarRi['kontrol']['drKontrolBPJS'] = (isset($this->dataDaftarRi['kddrbpjs'])
                    ? ($this->dataDaftarRi['kddrbpjs']
                        ? $this->dataDaftarRi['kddrbpjs']
                        : '')
                    : '');
                $this->dataDaftarRi['kontrol']['poliKontrol'] = (isset($this->dataDaftarRi['poliId'])
                    ? ($this->dataDaftarRi['poliId']
                        ? $this->dataDaftarRi['poliId']
                        : '')
                    : '');
                $this->dataDaftarRi['kontrol']['poliKontrolDesc'] = (isset($this->dataDaftarRi['poliDesc'])
                    ? ($this->dataDaftarRi['poliDesc']
                        ? $this->dataDaftarRi['poliDesc']
                        : '')
                    : '');
                $this->dataDaftarRi['kontrol']['poliKontrolBPJS'] = (isset($this->dataDaftarRi['kdpolibpjs'])
                    ? ($this->dataDaftarRi['kdpolibpjs']
                        ? $this->dataDaftarRi['kdpolibpjs']
                        : '')
                    : '');
                $this->dataDaftarRi['kontrol']['noSEP'] = (isset($findData->vno_sep)
                    ? ($findData->vno_sep
                        ? $findData->vno_sep
                        : '')
                    : '');
            }
        } else {

            $this->emit('toastr-error', "Json Tidak ditemukan, Data sedang diproses ulang.");
            $dataDaftarRi = DB::table('rsview_rihdrs')
                ->select(
                    DB::raw("to_char(entry_date,'dd/mm/yyyy hh24:mi:ss') AS entry_date"),
                    DB::raw("to_char(exit_date,'dd/mm/yyyy hh24:mi:ss') AS exit_date"),
                    DB::raw("to_char(exit_date,'yyyymmddhh24miss') AS exit_date1"),

                    'rihdr_no',

                    'reg_no',
                    'reg_name',
                    'sex',
                    'address',
                    'thn',
                    DB::raw("to_char(birth_date,'dd/mm/yyyy') AS birth_date"),

                    'admin_status',
                    'admin_age',
                    'police_case',

                    'entry_id',
                    'entry_desc',

                    'room_id',
                    'room_name',
                    'bed_no',

                    'dr_id',
                    'dr_name',

                    'klaim_id',
                    'klaim_desc',

                    'vno_sep',
                    'ri_status',

                    'datadaftarri_json'
                )
                ->where('rihdr_no', '=', $rino)
                ->first();

            $this->dataDaftarRi = [
                "entryDate" => $dataDaftarRi->entry_date,
                "exitDate" => $dataDaftarRi->exit_date,

                "riHdrNo" => $dataDaftarRi->rihdr_no,

                "regNo" =>  $dataDaftarRi->reg_no,
                "k14th" => [$dataDaftarRi->admin_age ? true : false], //Kurang dari 14 Th
                "kPolisi" => [$dataDaftarRi->police_case == 'Y' ? true : false], //Kasus Polisi

                "entryId" => $dataDaftarRi->entry_id,
                "entryDesc" => $dataDaftarRi->entry_desc,

                "roomId" => $dataDaftarRi->room_id,
                "roomDesc" => $dataDaftarRi->room_name,

                "bedNo" => $dataDaftarRi->bed_no,

                "klaimId" => $dataDaftarRi->klaim_id == 'JM' ? 'JM' : 'UM',
                "klaimDesc" => $dataDaftarRi->klaim_id == 'JM' ? 'BPJS' : 'UMUM',

                "drId" =>  $dataDaftarRi->dr_id,
                "drDesc" =>  $dataDaftarRi->dr_name,

                'sep' => [
                    "noSep" =>  $dataDaftarRi->vno_sep,
                    "reqSep" => [],
                    "resSep" => [],
                ]
            ];



            // jika kontrol tidak ditemukan tambah variable kontrol pda array
            if (isset($this->dataDaftarRi['kontrol']) == false) {
                $this->dataDaftarRi['kontrol']['tglKontrol'] =  Carbon::now()->addDays(8)->format('d/m/Y');
                $this->dataDaftarRi['kontrol']['drKontrol'] =  (isset($this->dataDaftarRi['drId'])
                    ? ($this->dataDaftarRi['drId']
                        ? $this->dataDaftarRi['drId']
                        : '')
                    : '');
                $this->dataDaftarRi['kontrol']['drKontrolDesc'] = (isset($this->dataDaftarRi['drDesc'])
                    ? ($this->dataDaftarRi['drDesc']
                        ? $this->dataDaftarRi['drDesc']
                        : '')
                    : '');
                $this->dataDaftarRi['kontrol']['drKontrolBPJS'] = (isset($this->dataDaftarRi['kddrbpjs'])
                    ? ($this->dataDaftarRi['kddrbpjs']
                        ? $this->dataDaftarRi['kddrbpjs']
                        : '')
                    : '');
                $this->dataDaftarRi['kontrol']['poliKontrol'] = (isset($this->dataDaftarRi['poliId'])
                    ? ($this->dataDaftarRi['poliId']
                        ? $this->dataDaftarRi['poliId']
                        : '')
                    : '');
                $this->dataDaftarRi['kontrol']['poliKontrolDesc'] = (isset($this->dataDaftarRi['poliDesc'])
                    ? ($this->dataDaftarRi['poliDesc']
                        ? $this->dataDaftarRi['poliDesc']
                        : '')
                    : '');
                $this->dataDaftarRi['kontrol']['poliKontrolBPJS'] = (isset($this->dataDaftarRi['kdpolibpjs'])
                    ? ($this->dataDaftarRi['kdpolibpjs']
                        ? $this->dataDaftarRi['kdpolibpjs']
                        : '')
                    : '');
                $this->dataDaftarRi['kontrol']['noSEP'] = (isset($dataDaftarRi->vno_sep)
                    ? ($dataDaftarRi->vno_sep
                        ? $dataDaftarRi->vno_sep
                        : '')
                    : '');
            }
        }
    }

    // set data RiHdrNo / NoBooking / NoAntrian / klaimId / kunjunganId
    private function setDataPrimer(): void
    {
        $noKontrol = Carbon::now()->addDays(8)->format('dmY') . $this->dataDaftarRi['kontrol']['drKontrol'] . $this->dataDaftarRi['kontrol']['poliKontrol'];
        $this->dataDaftarRi['kontrol']['noKontrolRS'] = (isset($this->dataDaftarRi['kontrol']['noKontrolRS'])
            ? ($this->dataDaftarRi['kontrol']['noKontrolRS']
                ? $this->dataDaftarRi['kontrol']['noKontrolRS']
                : $noKontrol)
            : $noKontrol);
    }




    // ////////////////
    // Antrol Logic
    // ////////////////


    private function pushSuratKontrolBPJS(): void
    {


        //push data SuratKontrolBPJS
        if ($this->dataDaftarRi['klaimId'] = 'JM') {


            // jika SKDP kosong lakukan push data
            // insert
            if (!isset($this->dataDaftarRi['kontrol']['noSKDPBPJS'])) {

                $this->dataDaftarRi['kontrol']['noSKDPBPJS'] = '';

                if (!$this->dataDaftarRi['kontrol']['noSKDPBPJS']) {
                    $HttpGetBpjs =  VclaimTrait::suratkontrol_insert($this->dataDaftarRi['kontrol'])->getOriginalContent();

                    // 2 cek proses pada getHttp
                    if ($HttpGetBpjs['metadata']['code'] == 200) {
                        $this->emit('toastr-success', 'KONTROL Post Inap' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                        $this->dataDaftarRi['kontrol']['noSKDPBPJS'] = $HttpGetBpjs['response']['noSuratKontrol']; //status 200 201 400 ..

                        $this->emit('toastr-success', 'KONTROL Post Inap' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                    } else {
                        $this->emit('toastr-error', 'KONTROL Post Inap' . $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                    }
                }
            } else {
                // update
                $HttpGetBpjs =  VclaimTrait::suratkontrol_update($this->dataDaftarRi['kontrol'])->getOriginalContent();

                if ($HttpGetBpjs['metadata']['code'] == 200) {
                    $this->emit('toastr-success', 'UPDATEKONTROL ' .  $HttpGetBpjs['metadata']['code'] . ' ' . $HttpGetBpjs['metadata']['message']);
                    // $this->dataDaftarRi['kontrol']['noSKDPBPJS'] = $HttpGetBpjs['metadata']['response']['noSuratKontrol']; //status 200 201 400 ..

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
        $this->findData($this->riNoRef);
        // set data dokter ref
        // $this->store();
    }



    // select data start////////////////
    public function render()
    {

        return view(
            'livewire.mr-r-j.skdp-r-i.skdp-r-i',
            [
                // 'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Data SKDP Pasien Post Rawat Inap',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Post Rawat Inap',
            ]
        );
    }
    // select data end////////////////


}
