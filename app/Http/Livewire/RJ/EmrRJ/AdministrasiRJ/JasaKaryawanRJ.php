<?php

namespace App\Http\Livewire\EmrRJ\AdministrasiRJ;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\EmrRJ\EmrRJTrait;


// use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;
use Exception;


class JasaKaryawanRJ extends Component
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



    public $dataJasaKaryawanLov = [];
    public $dataJasaKaryawanLovStatus = 0;
    public $dataJasaKaryawanLovSearch = '';
    public $selecteddataJasaKaryawanLovIndex = 0;

    public $collectingMyJasaKaryawan = [];







    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////
    public function updated($propertyName)
    {
        // dd($propertyName);
        // $this->validateOnly($propertyName);
    }




    /////////////////////////////////////////////////
    // Lov dataJasaKaryawanLov //////////////////////
    ////////////////////////////////////////////////
    public function clickdataJasaKaryawanLov()
    {
        $this->dataJasaKaryawanLovStatus = true;
        $this->dataJasaKaryawanLov = [];
    }

    public function updateddataJasaKaryawanLovsearch()
    {

        // Reset index of LoV
        $this->reset(['selecteddataJasaKaryawanLovIndex', 'dataJasaKaryawanLov']);
        // Variable Search
        $search = $this->dataJasaKaryawanLovSearch;

        // check LOV by dr_id rs id
        $dataJasaKaryawanLovs = DB::table('rsmst_actemps ')->select(
            'acte_id',
            'acte_desc',
            'acte_price'
        )
            ->where('acte_id', $search)
            ->where('active_status', '1')
            ->first();

        if ($dataJasaKaryawanLovs) {

            // set JasaKaryawan sep
            $this->addJasaKaryawan($dataJasaKaryawanLovs->acte_id, $dataJasaKaryawanLovs->acte_desc, $dataJasaKaryawanLovs->acte_price);
            $this->resetdataJasaKaryawanLov();
        } else {

            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 1) {
                $this->dataJasaKaryawanLov = [];
            } else {
                $this->dataJasaKaryawanLov = json_decode(
                    DB::table('rsmst_actemps')->select(
                        'acte_id',
                        'acte_desc',
                        'acte_price'
                    )
                        ->where('active_status', '1')
                        ->where(DB::raw('upper(acte_desc)'), 'like', '%' . strtoupper($search) . '%')
                        ->limit(10)
                        ->orderBy('acte_id', 'ASC')
                        ->orderBy('acte_desc', 'ASC')
                        ->get(),
                    true
                );
            }
            $this->dataJasaKaryawanLovStatus = true;
            // set doing nothing
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataJasaKaryawanLov($id)
    {
        $this->checkRjStatus();
        $dataJasaKaryawanLovs = DB::table('rsmst_actemps')->select(
            'acte_id',
            'acte_desc',
            'acte_price'
        )
            ->where('active_status', '1')
            ->where('acte_id', $this->dataJasaKaryawanLov[$id]['acte_id'])
            ->first();

        // set dokter sep
        $this->addJasaKaryawan($dataJasaKaryawanLovs->acte_id, $dataJasaKaryawanLovs->acte_desc, $dataJasaKaryawanLovs->acte_price);
        $this->resetdataJasaKaryawanLov();
    }

    public function resetdataJasaKaryawanLov()
    {
        $this->reset(['dataJasaKaryawanLov', 'dataJasaKaryawanLovStatus', 'dataJasaKaryawanLovSearch', 'selecteddataJasaKaryawanLovIndex']);
    }

    public function selectNextdataJasaKaryawanLov()
    {
        if ($this->selecteddataJasaKaryawanLovIndex === "") {
            $this->selecteddataJasaKaryawanLovIndex = 0;
        } else {
            $this->selecteddataJasaKaryawanLovIndex++;
        }

        if ($this->selecteddataJasaKaryawanLovIndex === count($this->dataJasaKaryawanLov)) {
            $this->selecteddataJasaKaryawanLovIndex = 0;
        }
    }

    public function selectPreviousdataJasaKaryawanLov()
    {

        if ($this->selecteddataJasaKaryawanLovIndex === "") {
            $this->selecteddataJasaKaryawanLovIndex = count($this->dataJasaKaryawanLov) - 1;
        } else {
            $this->selecteddataJasaKaryawanLovIndex--;
        }

        if ($this->selecteddataJasaKaryawanLovIndex === -1) {
            $this->selecteddataJasaKaryawanLovIndex = count($this->dataJasaKaryawanLov) - 1;
        }
    }

    public function enterMydataJasaKaryawanLov($id)
    {
        $this->checkRjStatus();
        // jika JK belum siap maka toaster error
        if (isset($this->dataJasaKaryawanLov[$id]['acte_id'])) {
            $this->addJasaKaryawan($this->dataJasaKaryawanLov[$id]['acte_id'], $this->dataJasaKaryawanLov[$id]['acte_desc'], $this->dataJasaKaryawanLov[$id]['acte_price']);
            $this->resetdataJasaKaryawanLov();
        } else {
            $this->emit('toastr-error', "Jasa Karyawan belum tersedia.");
        }
    }


    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataJasaKaryawanLov //////////////////////
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

        $this->emit('toastr-success', "Jasa Karyawan berhasil disimpan.");
    }
    // insert and update record end////////////////


    private function findData($rjno): void
    {
        $findDataRJ = $this->findDataRJ($rjno);
        $this->dataDaftarPoliRJ  = $findDataRJ['dataDaftarRJ'];

        // jika JasaKaryawan tidak ditemukan tambah variable JasaKaryawan pda array
        if (isset($this->dataDaftarPoliRJ['JasaKaryawan']) == false) {
            $this->dataDaftarPoliRJ['JasaKaryawan'] = [];
        }
    }


    private function setDataPrimer(): void {}



    private function addJasaKaryawan($JasaKaryawanId, $JasaKaryawanDesc, $salesPrice): void
    {

        $this->collectingMyJasaKaryawan = [
            'JasaKaryawanId' => $JasaKaryawanId,
            'JasaKaryawanDesc' => $JasaKaryawanDesc,
            'JasaKaryawanPrice' => $salesPrice,
        ];
    }

    public function insertJasaKaryawan(): void
    {

        // validate
        $this->checkRjStatus();
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();
        // require nik ketika pasien tidak dikenal
        $rules = [
            "collectingMyJasaKaryawan.JasaKaryawanId" => 'bail|required|exists:rsmst_actemps,acte_id',
            "collectingMyJasaKaryawan.JasaKaryawanDesc" => 'bail|required|',
            "collectingMyJasaKaryawan.JasaKaryawanPrice" => 'bail|required|numeric|',

        ];

        // Proses Validasi///////////////////////////////////////////
        $this->validate($rules, $messages);

        // validate


        // pengganti race condition
        // start:
        try {

            $lastInserted = DB::table('rstxn_rjactemps')
                ->select(DB::raw("nvl(max(acte_dtl)+1,1) as acte_dtl_max"))
                ->first();
            // insert into table transaksi
            DB::table('rstxn_rjactemps')
                ->insert([
                    'acte_dtl' => $lastInserted->acte_dtl_max,
                    'rj_no' => $this->rjNoRef,
                    'acte_id' => $this->collectingMyJasaKaryawan['JasaKaryawanId'],
                    'acte_price' => $this->collectingMyJasaKaryawan['JasaKaryawanPrice'],
                ]);


            $this->dataDaftarPoliRJ['JasaKaryawan'][] = [
                'JasaKaryawanId' => $this->collectingMyJasaKaryawan['JasaKaryawanId'],
                'JasaKaryawanDesc' => $this->collectingMyJasaKaryawan['JasaKaryawanDesc'],
                'JasaKaryawanPrice' => $this->collectingMyJasaKaryawan['JasaKaryawanPrice'],
                'rjActeDtl' => $lastInserted->acte_dtl_max,
                'rjNo' => $this->rjNoRef,
                'userLog' => auth()->user()->myuser_name,
                'userLogDate' => Carbon::now()->format('d/m/Y H:i:s')
            ];

            $this->paketLainLainJasaKaryawan($this->collectingMyJasaKaryawan['JasaKaryawanId'], $this->rjNoRef, $lastInserted->acte_dtl_max);
            $this->paketObatJasaKaryawan($this->collectingMyJasaKaryawan['JasaKaryawanId'], $this->rjNoRef, $lastInserted->acte_dtl_max);

            $this->store();
            $this->reset(['collectingMyJasaKaryawan']);


            //
        } catch (Exception $e) {
            // display an error to user
            dd($e->getMessage());
        }
        // goto start;
    }

    public function removeJasaKaryawan($rjActeDtl)
    {

        $this->checkRjStatus();


        // pengganti race condition
        // start:
        try {

            $this->removepaketLainLainJasaKaryawan($rjActeDtl);
            $this->removepaketObatJasaKaryawan($rjActeDtl);

            // remove into table transaksi
            DB::table('rstxn_rjactemps')
                ->where('acte_dtl', $rjActeDtl)
                ->delete();


            $JasaKaryawan = collect($this->dataDaftarPoliRJ['JasaKaryawan'])->where("rjActeDtl", '!=', $rjActeDtl)->toArray();
            $this->dataDaftarPoliRJ['JasaKaryawan'] = $JasaKaryawan;


            $this->store();


            //
        } catch (Exception $e) {
            // display an error to user
            dd($e->getMessage());
        }
        // goto start;


    }

    // /////////////////////////////////////////////////////////////////
    // Paket Jasa Karyawan -> Lain lain
    private function paketLainLainJasaKaryawan($acteId, $rjNo, $acteDtl): void
    {
        $collection = DB::table('rsmst_acteothers')
            ->select('other_id', 'acteother_price')
            ->where('acte_id', $acteId)
            ->orderBy('acte_id')
            ->get();

        foreach ($collection as $item) {
            $this->insertLainLain($acteId, $rjNo, $acteDtl, $item->other_id, 'Paket JK', $item->acteother_price);
        }
    }

    private function insertLainLain($acteId, $rjNo, $acteDtl, $otherId, $otherDesc, $otherPrice): void
    {

        // validate
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();
        // require nik ketika pasien tidak dikenal
        $collectingMyLainLain =
            [
                "LainLainId" => $otherId,
                "LainLainDesc" => $otherDesc,
                "LainLainPrice" => $otherPrice,
                "acteId" => $acteId,
                "acteDtl" => $acteDtl,
                "rjNo" => $rjNo,

            ];

        $rules = [
            "LainLainId" => 'bail|required|exists:rsmst_others ,other_id',
            "LainLainDesc" => 'bail|required|',
            "LainLainPrice" => 'bail|required|numeric|',
            "acteId" => 'bail|required||',
            "acteDtl" => 'bail|required|numeric|',
            "rjNo" => 'bail|required|numeric|',



        ];

        // Proses Validasi///////////////////////////////////////////
        $validator = Validator::make($collectingMyLainLain, $rules, $messages);

        if ($validator->fails()) {
            dd($validator->validated());
        }


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
                    'acte_dtl' => $collectingMyLainLain['acteDtl'],
                    'rj_no' => $collectingMyLainLain['rjNo'],
                    'other_id' => $collectingMyLainLain['LainLainId'],
                    'other_price' => $collectingMyLainLain['LainLainPrice'],
                ]);


            $this->dataDaftarPoliRJ['LainLain'][] = [
                'LainLainId' => $collectingMyLainLain['LainLainId'],
                'LainLainDesc' => $collectingMyLainLain['LainLainDesc'],
                'LainLainPrice' => $collectingMyLainLain['LainLainPrice'],
                'rjotherDtl' => $lastInserted->rjo_dtl_max,
                'rjNo' => $collectingMyLainLain['rjNo'],
                'acte_dtl' => $collectingMyLainLain['acteDtl']
            ];

            $this->store();
            //
        } catch (Exception $e) {
            // display an error to user
            dd($e->getMessage());
        }
        // goto start;
    }

    private function removepaketLainLainJasaKaryawan($rjActeDtl): void
    {
        $collection = DB::table('rstxn_rjothers')
            ->select('rjo_dtl')
            ->where('acte_dtl', $rjActeDtl)
            ->orderBy('acte_dtl')
            ->get();

        foreach ($collection as $item) {
            $this->removeLainLain($item->rjo_dtl);
        }
    }

    private function removeLainLain($rjotherDtl): void
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
    // Paket Jasa Karyawan -> Lain lain


    // /////////////////////////////////////////////////////////////////
    // Paket Jasa Karyawan -> Obat
    private function paketObatJasaKaryawan($acteId, $rjNo, $acteDtl): void
    {
        $collection = DB::table('rsmst_acteprods')
            ->select(
                'immst_products.product_id as product_id',
                'acte_id',
                'acteprod_qty',
                'immst_products.product_name as product_name',
                'immst_products.sales_price as sales_price',

            )
            ->where('acte_id', $acteId)
            ->join('immst_products', 'immst_products.product_id', 'rsmst_acteprods.product_id')
            ->orderBy('acte_id')
            ->get();

        foreach ($collection as $item) {
            $this->insertObat($acteId, $rjNo, $acteDtl, $item->product_id, 'Paket JK' . $item->product_name, $item->sales_price, $item->acteprod_qty);
        }
    }

    private function insertObat($acteId, $rjNo, $acteDtl, $ObatId, $ObatDesc, $ObatPrice, $Obatqty): void
    {

        // validate
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();
        // require nik ketika pasien tidak dikenal
        $collectingMyObat = [
            "productId" => $ObatId,
            "productName" => $ObatDesc,
            "signaX" => 1,
            "signaHari" => 1,
            "qty" => $Obatqty,
            "productPrice" => $ObatPrice,
            "catatanKhusus" => '-',
            "acteDtl" => $acteDtl,
            "acteId" => $acteId,
            "rjNo" => $rjNo
        ];

        $rules = [
            "productId" => 'bail|required|exists:immst_products ,product_id',
            "productName" => 'bail|required|',
            "signaX" => 'bail|required|numeric|min:1|max:5',
            "signaHari" => 'bail|required|numeric|min:1|max:5',
            "qty" => 'bail|required|digits_between:1,3|',
            "productPrice" => 'bail|required|numeric|',
            "catatanKhusus" => 'bail|',
            "acteDtl" => 'bail|required|numeric|',
            "acteId" => 'bail|required|',
            "rjNo" => 'bail|required|numeric|',
        ];

        // Proses Validasi///////////////////////////////////////////
        $validator = Validator::make($collectingMyObat, $rules, $messages);

        if ($validator->fails()) {
            dd($validator->validated());
        }


        // pengganti race condition
        // start:
        try {

            $lastInserted = DB::table('rstxn_rjobats')
                ->select(DB::raw("nvl(max(rjobat_dtl)+1,1) as rjobat_dtl_max"))
                ->first();
            // insert into table transaksi
            DB::table('rstxn_rjobats')
                ->insert([
                    'rjobat_dtl' => $lastInserted->rjobat_dtl_max,
                    'acte_dtl' => $collectingMyObat['acteDtl'],
                    'rj_no' => $collectingMyObat['rjNo'],
                    'product_id' => $collectingMyObat['productId'],
                    'qty' => $collectingMyObat['qty'],
                    'price' => $collectingMyObat['productPrice'],
                    'rj_carapakai' => $collectingMyObat['signaX'],
                    'rj_kapsul' => $collectingMyObat['signaHari'],
                    'rj_takar' => 'Tablet',
                    'catatan_khusus' => $collectingMyObat['catatanKhusus'],
                    'exp_date' => DB::raw("to_date('" . $this->dataDaftarPoliRJ['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')+30"),
                    'etiket_status' => 0,
                ]);


            // $this->dataDaftarPoliRJ['eresep'][] = [
            //     'productId' => $this->collectingMyProduct['productId'],
            //     'productName' => $this->collectingMyProduct['productName'],
            //     'jenisKeterangan' => 'NonRacikan', //Racikan non racikan
            //     'signaX' => $this->collectingMyProduct['signaX'],
            //     'signaHari' => $this->collectingMyProduct['signaHari'],
            //     'qty' => $this->collectingMyProduct['qty'],
            //     'productPrice' => $this->collectingMyProduct['productPrice'],
            //     'catatanKhusus' => $this->collectingMyProduct['catatanKhusus'],
            //     'rjObatDtl' => $lastInserted->rjobat_dtl_max,
            //     'rjNo' => $this->rjNoRef,
            // ];

            $this->store();
            //
        } catch (Exception $e) {
            // display an error to user
            dd($e->getMessage());
        }
        // goto start;
    }

    private function removepaketObatJasaKaryawan($rjActeDtl): void
    {
        $collection = DB::table('rstxn_rjobats')
            ->select('rjobat_dtl')
            ->where('acte_dtl', $rjActeDtl)
            ->orderBy('acte_dtl')
            ->get();

        foreach ($collection as $item) {
            $this->removeObat($item->rjobat_dtl);
        }
    }

    private function removeObat($rjObatDtl): void
    {

        $this->checkRjStatus();


        // pengganti race condition
        // start:
        try {
            // remove into table transaksi
            DB::table('rstxn_rjobats')
                ->where('rjobat_dtl', $rjObatDtl)
                ->delete();


            // $LainLain = collect($this->dataDaftarPoliRJ['LainLain'])->where("rjotherDtl", '!=', $rjotherDtl)->toArray();
            // $this->dataDaftarPoliRJ['LainLain'] = $LainLain;

            $this->store();
            //
        } catch (Exception $e) {
            // display an error to user
            dd($e->getMessage());
        }
        // goto start;
    }
    // Paket Jasa Karyawan -> Obat
    // /////////////////////////////////////////////////////////////////


    public function resetcollectingMyJasaKaryawan()
    {
        $this->reset(['collectingMyJasaKaryawan']);
    }

    public function checkRjStatus()
    {
        $lastInserted = DB::table('rstxn_rjhdrs')
            ->select('rj_status')
            ->where('rj_no', $this->rjNoRef)
            ->first();

        if ($lastInserted->rj_status !== 'A') {
            $this->emit('toastr-error', "Pasien Sudah Pulang, Trasaksi Terkunci.");
            return (dd('Pasien Sudah Pulang, Trasaksi Terkuncixx.' . $this->rjNoRef));
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
            'livewire.emr-r-j.administrasi-r-j.jasa-karyawan-r-j',
            [
                // 'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Data Pasien Rawat Jalan',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Jasa Karyawan',
            ]
        );
    }
    // select data end////////////////


}
