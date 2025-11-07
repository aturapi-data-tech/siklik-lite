<?php

namespace App\Http\Traits\LOV\LOVProduct;


use Illuminate\Support\Facades\DB;

trait LOVProductTrait
{

    public array $dataProductLov = [];
    public int $dataProductLovStatus = 0;
    public string $dataProductLovSearch = '';
    public int $selecteddataProductLovIndex = 0;
    public array $collectingMyProduct = [];

    /////////////////////////////////////////////////
    // Lov dataProductLov //////////////////////
    ////////////////////////////////////////////////

    public function updateddataProductLovsearch()
    {

        // Reset index of LoV
        $this->reset(['selecteddataProductLovIndex', 'dataProductLov']);
        // Variable Search
        $search = $this->dataProductLovSearch;

        // check LOV by product_id rs id
        $dataProductLovs = DB::table('tkmst_products ')
            ->select(
                'product_id',
                'product_name',
                'sales_price',
                DB::raw("(select replace(string_agg(cont_desc),',','')||product_name
                                            from immst_productcontents z,immst_contents x
                                            where z.product_id=tkmst_products.product_id
                                            and z.cont_id=x.cont_id) as elasticSearch"),
                DB::raw("(select string_agg(cont_desc)
                                            from immst_productcontents z,immst_contents x
                                            where z.product_id=tkmst_products.product_id
                                            and z.cont_id=x.cont_id) as product_content"),
            )
            ->where('product_id', '=', $search)
            ->where('active_status', '1')
            ->first();

        if ($dataProductLovs) {

            // set Product sep
            $this->addProduct($dataProductLovs->product_id, $dataProductLovs->product_name, $dataProductLovs->sales_price);
            $this->resetdataProductLov();
        } else {

            // if there is no id found and check (min 1 char on search)
            if (strlen($search) < 1) {
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

                    from tkmst_products a
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
        // $this->checkRjStatus();
        $dataProductLovs = DB::table('tkmst_products')
            ->select(
                'product_id',
                'product_name',
                'sales_price',
                DB::raw("(select replace(string_agg(cont_desc),',','')||product_name
                                            from immst_productcontents z,immst_contents x
                                            where z.product_id=tkmst_products.product_id
                                            and z.cont_id=x.cont_id) as elasticSearch"),
                DB::raw("(select string_agg(cont_desc)
                                            from immst_productcontents z,immst_contents x
                                            where z.product_id=tkmst_products.product_id
                                            and z.cont_id=x.cont_id) as product_content"),
            )
            ->where('product_id', $this->dataProductLov[$id]['product_id'])
            ->first();

        // set lain sep
        $this->addProduct($dataProductLovs->product_id, $dataProductLovs->product_name, $dataProductLovs->sales_price);
        $this->resetdataProductLov();
    }

    public function resetdataProductLov()
    {
        $this->reset(['dataProductLov', 'dataProductLovStatus', 'dataProductLovSearch', 'selecteddataProductLovIndex']);
    }

    public function selectNextdataProductLov()
    {
        if ($this->selecteddataProductLovIndex === "") {
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

        if ($this->selecteddataProductLovIndex === "") {
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
        // dd($this->dataProductLov);
        // $this->checkRjStatus();
        // jika JK belum siap maka toaster error
        if (isset($this->dataProductLov[$id]['product_id'])) {
            $this->addProduct($this->dataProductLov[$id]['product_id'], $this->dataProductLov[$id]['product_name'], $this->dataProductLov[$id]['sales_price']);
            $this->resetdataProductLov();
        } else {
            $this->emit('toastr-error', "Kode belum tersedia.");
            return;
        }
    }


    private function addProduct($productId, $productName, $productPrice): void
    {
        $this->collectingMyProduct = [
            'productId' => $productId,
            'productName' => $productName,
            'productPrice' => $productPrice,
        ];
    }


    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataProductLov //////////////////////
    ////////////////////////////////////////////////
}
