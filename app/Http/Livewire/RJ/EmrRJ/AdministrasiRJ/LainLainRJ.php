<?php

namespace App\Http\Livewire\EmrRJ\AdministrasiRJ;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\EmrRJ\EmrRJTrait;

// use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;
use Exception;


class LainLainRJ extends Component
{
    use WithPagination, EmrRJTrait;


    // listener from blade////////////////
    protected $listeners = [
        'storeAssessmentDokterRJ' => 'store',
        'syncronizeAssessmentDokterRJFindData' => 'mount',
        'syncronizeAssessmentPerawatRJFindData' => 'mount'
    ];


    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef;



    // dataDaftarPoliRJ RJ
    public array $dataDaftarPoliRJ = [];

    //////////////////////////////////////////////////////////////////////


    //  table LOV////////////////



    public $dataLainLainLov = [];
    public $dataLainLainLovStatus = 0;
    public $dataLainLainLovSearch = '';
    public $selecteddataLainLainLovIndex = 0;

    public $collectingMyLainLain = [];







    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////
    public function updated($propertyName)
    {
        // dd($propertyName);
        // $this->validateOnly($propertyName);
    }




    /////////////////////////////////////////////////
    // Lov dataLainLainLov //////////////////////
    ////////////////////////////////////////////////
    public function clickdataLainLainLov()
    {
        $this->dataLainLainLovStatus = true;
        $this->dataLainLainLov = [];
    }

    public function updateddataLainLainLovsearch()
    {

        // Reset index of LoV
        $this->reset(['selecteddataLainLainLovIndex', 'dataLainLainLov']);
        // Variable Search
        $search = $this->dataLainLainLovSearch;

        // check LOV by dr_id rs id
        $dataLainLainLovs = DB::table('rsmst_others  ')->select(
            'other_id',
            'other_desc',
            'other_price'
        )
            ->where('other_id', $search)
            ->where('active_status', '1')
            ->first();

        if ($dataLainLainLovs) {

            // set LainLain sep
            $this->addLainLain($dataLainLainLovs->other_id, $dataLainLainLovs->other_desc, $dataLainLainLovs->other_price);
            $this->resetdataLainLainLov();
        } else {

            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 1) {
                $this->dataLainLainLov = [];
            } else {
                $this->dataLainLainLov = json_decode(
                    DB::table('rsmst_others ')->select(
                        'other_id',
                        'other_desc',
                        'other_price'
                    )
                        ->where('active_status', '1')
                        ->where(DB::raw('upper(other_desc)'), 'like', '%' . strtoupper($search) . '%')
                        ->limit(10)
                        ->orderBy('other_id', 'ASC')
                        ->orderBy('other_desc', 'ASC')
                        ->get(),
                    true
                );
            }
            $this->dataLainLainLovStatus = true;
            // set doing nothing
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataLainLainLov($id)
    {
        $this->checkRjStatus();
        $dataLainLainLovs = DB::table('rsmst_others ')->select(
            'other_id',
            'other_desc',
            'other_price'
        )
            ->where('active_status', '1')
            ->where('other_id', $this->dataLainLainLov[$id]['other_id'])
            ->first();

        // set dokter sep
        $this->addLainLain($dataLainLainLovs->other_id, $dataLainLainLovs->other_desc, $dataLainLainLovs->other_price);
        $this->resetdataLainLainLov();
    }

    public function resetdataLainLainLov()
    {
        $this->reset(['dataLainLainLov', 'dataLainLainLovStatus', 'dataLainLainLovSearch', 'selecteddataLainLainLovIndex']);
    }

    public function selectNextdataLainLainLov()
    {
        if ($this->selecteddataLainLainLovIndex === "") {
            $this->selecteddataLainLainLovIndex = 0;
        } else {
            $this->selecteddataLainLainLovIndex++;
        }

        if ($this->selecteddataLainLainLovIndex === count($this->dataLainLainLov)) {
            $this->selecteddataLainLainLovIndex = 0;
        }
    }

    public function selectPreviousdataLainLainLov()
    {

        if ($this->selecteddataLainLainLovIndex === "") {
            $this->selecteddataLainLainLovIndex = count($this->dataLainLainLov) - 1;
        } else {
            $this->selecteddataLainLainLovIndex--;
        }

        if ($this->selecteddataLainLainLovIndex === -1) {
            $this->selecteddataLainLainLovIndex = count($this->dataLainLainLov) - 1;
        }
    }

    public function enterMydataLainLainLov($id)
    {
        $this->checkRjStatus();
        // jika JK belum siap maka toaster error
        if (isset($this->dataLainLainLov[$id]['other_id'])) {
            $this->addLainLain($this->dataLainLainLov[$id]['other_id'], $this->dataLainLainLov[$id]['other_desc'], $this->dataLainLainLov[$id]['other_price']);
            $this->resetdataLainLainLov();
        } else {
            $this->emit('toastr-error', "Lain-Lain belum tersedia.");
        }
    }


    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataLainLainLov //////////////////////
    ////////////////////////////////////////////////







    // insert and update record start////////////////
    public function store()
    {
        // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
        $this->setDataPrimer();

        // Logic update mode start //////////
        $this->updateDataRJ($this->dataDaftarPoliRJ['rjNo']);
        $this->emit('syncronizeAssessmentDokterRJFindData');
        $this->emit('syncronizeAssessmentPerawatRJFindData');
    }

    private function updateDataRJ($rjNo): void
    {

        // update table trnsaksi
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'dataDaftarPoliRJ_json' => json_encode($this->dataDaftarPoliRJ, true),
                'dataDaftarPoliRJ_xml' => ArrayToXml::convert($this->dataDaftarPoliRJ),
            ]);

        $this->emit('toastr-success', "Lain-Lain berhasil disimpan.");
    }
    // insert and update record end////////////////


    private function findData($rjno): void
    {
        $findDataRJ = $this->findDataRJ($rjno);
        $this->dataDaftarPoliRJ  = $findDataRJ['dataDaftarRJ'];

        // jika LainLain tidak ditemukan tambah variable LainLain pda array
        if (isset($this->dataDaftarPoliRJ['LainLain']) == false) {
            $this->dataDaftarPoliRJ['LainLain'] = [];
        }
    }


    private function setDataPrimer(): void {}



    private function addLainLain($LainLainId, $LainLainDesc, $salesPrice): void
    {

        $this->collectingMyLainLain = [
            'LainLainId' => $LainLainId,
            'LainLainDesc' => $LainLainDesc,
            'LainLainPrice' => $salesPrice,
        ];
    }

    public function insertLainLain(): void
    {

        // validate
        $this->checkRjStatus();
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();
        // require nik ketika pasien tidak dikenal
        $rules = [
            "collectingMyLainLain.LainLainId" => 'bail|required|exists:rsmst_others ,other_id',
            "collectingMyLainLain.LainLainDesc" => 'bail|required|',
            "collectingMyLainLain.LainLainPrice" => 'bail|required|numeric|',

        ];

        // Proses Validasi///////////////////////////////////////////
        $this->validate($rules, $messages);

        // validate


        // pengganti race condition
        // start:
        try {

            $lastInserted = DB::table('rstxn_rjothers')
                ->select(DB::raw("nvl(max(rjo_dtl)+1,1) as rjo_dtl_max"))
                ->first();
            // insert into table transaksi
            DB::table('rstxn_rjothers')
                ->insert([
                    'rjo_dtl' => $lastInserted->rjo_dtl_max,
                    'rj_no' => $this->rjNoRef,
                    'other_id' => $this->collectingMyLainLain['LainLainId'],
                    'other_price' => $this->collectingMyLainLain['LainLainPrice'],
                ]);


            $this->dataDaftarPoliRJ['LainLain'][] = [
                'LainLainId' => $this->collectingMyLainLain['LainLainId'],
                'LainLainDesc' => $this->collectingMyLainLain['LainLainDesc'],
                'LainLainPrice' => $this->collectingMyLainLain['LainLainPrice'],
                'rjotherDtl' => $lastInserted->rjo_dtl_max,
                'rjNo' => $this->rjNoRef,
                'userLog' => auth()->user()->myuser_name,
                'userLogDate' => Carbon::now()->format('d/m/Y H:i:s')
            ];

            $this->store();
            $this->reset(['collectingMyLainLain']);


            //
        } catch (Exception $e) {
            // display an error to user
            dd($e->getMessage());
        }
        // goto start;
    }

    public function removeLainLain($rjotherDtl)
    {

        $this->checkRjStatus();


        // pengganti race condition
        // start:
        try {
            // remove into table transaksi
            DB::table('rstxn_rjothers')
                ->where('rjo_dtl', $rjotherDtl)
                ->delete();


            $LainLain = collect($this->dataDaftarPoliRJ['LainLain'])->where("rjotherDtl", '!=', $rjotherDtl)->toArray();
            $this->dataDaftarPoliRJ['LainLain'] = $LainLain;
            $this->store();


            //
        } catch (Exception $e) {
            // display an error to user
            dd($e->getMessage());
        }
        // goto start;


    }

    public function resetcollectingMyLainLain()
    {
        $this->reset(['collectingMyLainLain']);
    }

    public function checkRjStatus()
    {
        $lastInserted = DB::table('rstxn_rjhdrs')
            ->select('rj_status')
            ->where('rj_no', $this->rjNoRef)
            ->first();

        if ($lastInserted->rj_status !== 'A') {
            $this->emit('toastr-error', "Pasien Sudah Pulang, Trasaksi Terkunci.");
            return (dd('Pasien Sudah Pulang, Trasaksi Terkuncixx.'));
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
            'livewire.emr-r-j.administrasi-r-j.lain-lain-r-j',
            [
                // 'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Data Pasien Rawat Jalan',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Lain Lain',
            ]
        );
    }
    // select data end////////////////


}
