<?php

namespace App\Http\Livewire\EmrUGD\EresepUGD;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
// use Carbon\Carbon;

use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\EmrUGD\EmrUGDTrait;

// use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;
use Exception;
use Illuminate\Support\Facades\Validator;

class EresepUGD extends Component
{
    use WithPagination, EmrUGDTrait;

    // listener from blade////////////////
    protected $listeners = [
        'storeAssessmentDokterUGD' => 'store',
        'syncronizeAssessmentDokterUGDFindData' => 'mount',
        'syncronizeAssessmentPerawatUGDFindData' => 'mount'
    ];

    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef = 472309;
    public string $rjStatusRef;

    // dataDaftarUgd RJ
    public array $dataDaftarUgd = [];

    //////////////////////////////////////////////////////////////////////

    //  table LOV////////////////

    public $dataProductLov = [];
    public $dataProductLovStatus = 0;
    public $dataProductLovSearch = '';
    public $selecteddataProductLovIndex = 0;

    public $collectingMyProduct = [];

    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////
    public function updated($propertyName)
    {
        // dd($propertyName);
        // $this->validateOnly($propertyName);
    }

    /////////////////////////////////////////////////
    // Lov dataProductLov //////////////////////
    ////////////////////////////////////////////////
    public function clickdataProductLov()
    {
        $this->dataProductLovStatus = true;
        $this->dataProductLov = [];
    }

    public function updateddataProductLovsearch()
    {
        // Reset index of LoV
        $this->reset(['selecteddataProductLovIndex', 'dataProductLov']);
        // Variable Search
        $search = $this->dataProductLovSearch;

        // check LOV by dr_id rs id
        $dataProductLovs = DB::table('immst_products')
            ->select(
                'product_id',
                'product_name',
                'sales_price',
                DB::raw("(select replace(string_agg(cont_desc),',','')||product_name
                                            from immst_productcontents z,immst_contents x
                                            where z.product_id=immst_products.product_id
                                            and z.cont_id=x.cont_id) as elasticSearch"),
                DB::raw("(select string_agg(cont_desc)
                                            from immst_productcontents z,immst_contents x
                                            where z.product_id=immst_products.product_id
                                            and z.cont_id=x.cont_id) as product_content"),
            )
            ->where('active_status', '1')
            ->where('product_id', $search)
            ->first();

        if ($dataProductLovs) {
            // set product sep
            $this->addProduct($dataProductLovs->product_id, $dataProductLovs->product_name, $dataProductLovs->sales_price);
            $this->resetdataProductLov();
        } else {
            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 3) {
                $this->dataProductLov = [];
            } else {
                $this->dataProductLov = DB::select(
                    "select * from (
                    select product_id,
                    product_name,
                    sales_price,

                    (select replace(string_agg(cont_desc),',','')||product_name
                    from immst_productcontents z,immst_contents x
                    where z.product_id=a.product_id
                    and z.cont_id=x.cont_id)elasticsearch,

                    (select string_agg(cont_desc)
                    from immst_productcontents z,immst_contents x
                    where z.product_id=a.product_id
                    and z.cont_id=x.cont_id)product_content

                    from immst_products a
                    where active_status='1'
                    group by product_id,product_name, sales_price
                    order by product_name)

                where upper(elasticsearch) like '%'||:search||'%'
                    ",
                    ['search' => strtoupper($search)],
                );

                $this->dataProductLov = json_decode(json_encode($this->dataProductLov, true), true);
            }
            $this->dataProductLovStatus = true;
            // set doing nothing
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataProductLov($id)
    {
        $this->checkUgdStatus();
        $dataProductLovs = DB::table('immst_products')
            ->select(
                'product_id',
                'product_name',
                'sales_price',
                DB::raw("(select replace(string_agg(cont_desc),',','')||product_name
                                                            from immst_productcontents z,immst_contents x
                                                            where z.product_id=immst_products.product_id
                                                            and z.cont_id=x.cont_id) as elasticSearch"),
                DB::raw("(select string_agg(cont_desc)
                                                            from immst_productcontents z,immst_contents x
                                                            where z.product_id=immst_products.product_id
                                                            and z.cont_id=x.cont_id) as product_content"),
            )
            ->where('active_status', '1')
            ->where('product_id', $this->dataProductLov[$id]['product_id'])
            ->first();

        // set dokter sep
        $this->addProduct($dataProductLovs->product_id, $dataProductLovs->product_name, $dataProductLovs->sales_price);
        $this->resetdataProductLov();
    }

    public function resetdataProductLov()
    {
        $this->reset(['dataProductLov', 'dataProductLovStatus', 'dataProductLovSearch', 'selecteddataProductLovIndex']);
    }

    public function selectNextdataProductLov()
    {
        if ($this->selecteddataProductLovIndex === '') {
            $this->selecteddataProductLovIndex = 0;
        } else {
            $this->selecteddataProductLovIndex++;
        }

        if ($this->selecteddataProductLovIndex === count($this->dataProductLov)) {
            $this->selecteddataProductLovIndex = 0;
        }
    }

    public function selectPreviousdataProductLov()
    {
        if ($this->selecteddataProductLovIndex === '') {
            $this->selecteddataProductLovIndex = count($this->dataProductLov) - 1;
        } else {
            $this->selecteddataProductLovIndex--;
        }

        if ($this->selecteddataProductLovIndex === -1) {
            $this->selecteddataProductLovIndex = count($this->dataProductLov) - 1;
        }
    }

    public function enterMydataProductLov($id)
    {
        $this->checkUgdStatus();
        // jika data obat belum siap maka toaster error
        if (isset($this->dataProductLov[$id]['product_id'])) {
            $this->addProduct($this->dataProductLov[$id]['product_id'], $this->dataProductLov[$id]['product_name'], $this->dataProductLov[$id]['sales_price']);
            $this->resetdataProductLov();
        } else {
            $this->emit('toastr-error', 'Data Obat belum tersedia.');
        }
    }

    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataProductLov //////////////////////
    ////////////////////////////////////////////////

    // insert and update record start////////////////
    public function store()
    {
        // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
        $this->setDataPrimer();

        // Logic update mode start //////////
        $this->updateDataRJ($this->dataDaftarUgd['rjNo']);
        $this->emit('syncronizeAssessmentDokterUGDFindData');
        $this->emit('syncronizeAssessmentPerawatUGDFindData');
    }

    private function updateDataRJ($rjNo): void
    {
        // update table trnsaksi
        DB::table('rstxn_ugdhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'datadaftarugd_json' => json_encode($this->dataDaftarUgd, true),
                'datadaftarugd_xml' => ArrayToXml::convert($this->dataDaftarUgd),
            ]);

        $this->emit('toastr-success', 'Eresep berhasil disimpan.');
    }
    // insert and update record end////////////////

    private function findData($rjno): void
    {
        $this->rjStatusRef = DB::table('rstxn_ugdhdrs')->select('rj_status')->where('rj_no', $rjno)->first()->rj_status;

        $this->dataDaftarUgd = $this->findDataUGD($rjno);
        // dd($this->dataDaftarUgd);
        // jika eresep tidak ditemukan tambah variable eresep pda array
        if (isset($this->dataDaftarUgd['eresep']) == false) {
            $this->dataDaftarUgd['eresep'] = [];
        }
    }

    private function setDataPrimer(): void
    {
    }

    private function addProduct($productId, $productName, $salesPrice): void
    {
        $this->collectingMyProduct = [
            'productId' => $productId,
            'productName' => $productName,
            'jenisKeterangan' => 'NonRacikan', //Racikan non racikan
            'signaX' => 1,
            'signaHari' => 1,
            'qty' => 1,
            'productPrice' => $salesPrice,
            'catatanKhusus' => '',
        ];
    }

    public function insertProduct(): void
    {
        // validate
        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();
        // require nik ketika pasien tidak dikenal
        $rules = [
            'collectingMyProduct.productId' => 'bail|required|',
            'collectingMyProduct.productName' => 'bail|required|',
            'collectingMyProduct.signaX' => 'bail|required|',
            'collectingMyProduct.signaHari' => 'bail|required|',
            'collectingMyProduct.qty' => 'bail|required|digits_between:1,3|',
            'collectingMyProduct.productPrice' => 'bail|required|numeric|',
            'collectingMyProduct.catatanKhusus' => 'bail|',
        ];

        // Proses Validasi///////////////////////////////////////////
        $this->validate($rules, $messages);

        // validate

        // pengganti race condition
        // start:
        try {
            // select nvl(max(rjobat_dtl)+1,1) into :rstxn_ugdobats.rjobat_dtl from rstxn_ugdobats;

            $lastInserted = DB::table('rstxn_ugdobats')->select(DB::raw('nvl(max(rjobat_dtl)+1,1) as rjobat_dtl_max'))->first();
            // insert into table transaksi
            DB::table('rstxn_ugdobats')->insert([
                'rjobat_dtl' => $lastInserted->rjobat_dtl_max,
                'rj_no' => $this->rjNoRef,
                'product_id' => $this->collectingMyProduct['productId'],
                'qty' => $this->collectingMyProduct['qty'],
                'price' => $this->collectingMyProduct['productPrice'],
                'ugd_carapakai' => $this->collectingMyProduct['signaX'],
                'ugd_kapsul' => $this->collectingMyProduct['signaHari'],
                'ugd_takar' => 'Tablet',
                'catatan_khusus' => $this->collectingMyProduct['catatanKhusus'],
                'ugd_ket' => $this->collectingMyProduct['catatanKhusus'],
                'exp_date' => DB::raw("to_date('" . $this->dataDaftarUgd['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')+30"),
                'etiket_status' => 1,
            ]);

            $this->dataDaftarUgd['eresep'][] = [
                'productId' => $this->collectingMyProduct['productId'],
                'productName' => $this->collectingMyProduct['productName'],
                'jenisKeterangan' => 'NonRacikan', //Racikan non racikan
                'signaX' => $this->collectingMyProduct['signaX'],
                'signaHari' => $this->collectingMyProduct['signaHari'],
                'qty' => $this->collectingMyProduct['qty'],
                'productPrice' => $this->collectingMyProduct['productPrice'],
                'catatanKhusus' => $this->collectingMyProduct['catatanKhusus'],
                'rjObatDtl' => $lastInserted->rjobat_dtl_max,
                'rjNo' => $this->rjNoRef,
            ];

            $this->store();
            $this->reset(['collectingMyProduct']);

            //
        } catch (Exception $e) {
            // display an error to user
            dd($e->getMessage());
        }
        // goto start;
    }

    public function updateProduct($rjobat_dtl, $qty = null, $signaX = null, $signaHari = null, $catatanKhusus = null): void
    {
        // validate
        $this->checkUgdStatus();

        $r = [
            'qty' => $qty,
            'signaX' => $signaX,
            'signaHari' => $signaHari,
            'catatanKhusus' => $catatanKhusus,
        ];

        // customErrorMessages
        $messages = customErrorMessagesTrait::messages();
        // require nik ketika pasien tidak dikenal
        $rules = [
            'qty' => 'bail|required|digits_between:1,3|',
            'signaX' => 'bail|required|',
            'signaHari' => 'bail|required|',
            'catatanKhusus' => 'bail|',
        ];
        // Proses Validasi///////////////////////////////////////////
        $validator = Validator::make($r, $rules, $messages);

        if ($validator->fails()) {
            dd($validator->errors()->first());
        }
        // validate

        // pengganti race condition
        // start:
        try {
            // insert into table transaksi
            DB::table('rstxn_ugdobats')
                ->where('rjobat_dtl', $rjobat_dtl)
                ->update([
                    'qty' => $r['qty'],
                    'ugd_carapakai' => $r['signaX'],
                    'ugd_kapsul' => $r['signaHari'],
                    'catatan_khusus' => $r['catatanKhusus'],
                    'ugd_ket' => $r['catatanKhusus'],
                ]);


            $this->store();

            //
        } catch (Exception $e) {
            // display an error to user
            dd($e->getMessage());
        }
        // goto start;
    }

    public function removeProduct($rjObatDtl)
    {
        $this->checkUgdStatus();

        // pengganti race condition
        // start:
        try {
            // remove into table transaksi
            DB::table('rstxn_ugdobats')->where('rjobat_dtl', $rjObatDtl)->delete();

            $Product = collect($this->dataDaftarUgd['eresep'])
                ->where('rjObatDtl', '!=', $rjObatDtl)
                ->toArray();
            $this->dataDaftarUgd['eresep'] = $Product;
            $this->store();

            //
        } catch (Exception $e) {
            // display an error to user
            dd($e->getMessage());
        }
        // goto start;
    }

    public function resetcollectingMyProduct()
    {
        $this->reset(['collectingMyProduct']);
    }

    public function checkUgdStatus()
    {
        $lastInserted = DB::table('rstxn_ugdhdrs')
            ->select('rj_status')
            ->where('rj_no', $this->rjNoRef)
            ->first();

        if ($lastInserted->rj_status !== 'A') {
            $this->emit('toastr-error', 'Pasien Sudah Pulang, Trasaksi Terkunci.');
            return dd('Pasien Sudah Pulang, Trasaksi Terkuncixx.');
        }
    }

    // when new form instance
    public function mount()
    {
        $this->findData($this->rjNoRef);
        // set data dokter ref
    }

    // select data start////////////////
    public function render()
    {
        return view('livewire.emr-u-g-d.eresep-u-g-d.eresep-u-g-d', [
            // 'RJpasiens' => $query->paginate($this->limitPerPage),
            'myTitle' => 'Data Pasien Rawat Jalan',
            'mySnipt' => 'Rekam Medis Pasien',
            'myProgram' => 'Eresep',
        ]);
    }
    // select data end////////////////
}
