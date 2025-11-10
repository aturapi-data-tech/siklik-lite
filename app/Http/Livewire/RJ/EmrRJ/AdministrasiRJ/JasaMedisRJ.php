<?php

namespace App\Http\Livewire\RJ\EmrRJ\AdministrasiRJ;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Exception;

use App\Http\Traits\EmrRJ\EmrRJTrait;


class JasaMedisRJ extends Component
{
    use EmrRJTrait;

    ////////////////////////////////////////////////
    // Refs & State
    ////////////////////////////////////////////////
    public $rjNoRef;
    public string $rjStatusRef = 'A';
    public array $dataDaftarPoliRJ = [];

    //  table LOV////////////////

    public $dataJasaMedisLov = [];
    public $dataJasaMedisLovStatus = 0;
    public $dataJasaMedisLovSearch = '';
    public $selecteddataJasaMedisLovIndex = 0;








    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////



    /////////////////////////////////////////////////
    // Lov dataJasaMedisLov //////////////////////
    ////////////////////////////////////////////////
    private function addJasaMedis($JasaMedisId, $JasaMedisDesc, $salesPrice): void
    {

        $this->formEntryJasaMedis = [
            'JasaMedisId' => $JasaMedisId,
            'JasaMedisDesc' => $JasaMedisDesc,
            'JasaMedisPrice' => $salesPrice,
        ];
    }

    public function clickdataJasaMedisLov()
    {
        $this->dataJasaMedisLovStatus = true;
        $this->dataJasaMedisLov = [];
    }

    public function updateddataJasaMedisLovsearch()
    {

        // Reset index of LoV
        $this->reset(['selecteddataJasaMedisLovIndex', 'dataJasaMedisLov']);
        // Variable Search
        $search = $this->dataJasaMedisLovSearch;

        // check LOV by dr_id rs id
        $dataJasaMedisLovs = DB::table('rsmst_actparamedics  ')->select(
            'pact_id',
            'pact_desc',
            'pact_price'
        )
            ->where('pact_id', $search)
            ->where('active_status', '1')
            ->first();

        if ($dataJasaMedisLovs) {

            // set JasaMedis sep
            $this->addJasaMedis($dataJasaMedisLovs->pact_id, $dataJasaMedisLovs->pact_desc, $dataJasaMedisLovs->pact_price);
            $this->resetdataJasaMedisLov();
        } else {

            // if there is no id found and check (min 3 char on search)
            if (strlen($search) < 1) {
                $this->dataJasaMedisLov = [];
            } else {
                $this->dataJasaMedisLov = json_decode(
                    DB::table('rsmst_actparamedics ')->select(
                        'pact_id',
                        'pact_desc',
                        'pact_price'
                    )
                        ->where('active_status', '1')
                        ->where(DB::raw('upper(pact_desc)'), 'like', '%' . strtoupper($search) . '%')
                        ->limit(10)
                        ->orderBy('pact_id', 'ASC')
                        ->orderBy('pact_desc', 'ASC')
                        ->get(),
                    true
                );
            }
            $this->dataJasaMedisLovStatus = true;
            // set doing nothing
        }
    }
    // /////////////////////
    // LOV selected start
    public function setMydataJasaMedisLov($id)
    {
        if (!$this->checkRjStatus($this->rjNoRef)) return;

        $dataJasaMedisLovs = DB::table('rsmst_actparamedics ')->select(
            'pact_id',
            'pact_desc',
            'pact_price'
        )
            ->where('active_status', '1')
            ->where('pact_id', $this->dataJasaMedisLov[$id]['pact_id'])
            ->first();

        // set dokter sep
        $this->addJasaMedis($dataJasaMedisLovs->pact_id, $dataJasaMedisLovs->pact_desc, $dataJasaMedisLovs->pact_price);
        $this->resetdataJasaMedisLov();
    }

    public function resetdataJasaMedisLov()
    {
        $this->reset(['dataJasaMedisLov', 'dataJasaMedisLovStatus', 'dataJasaMedisLovSearch', 'selecteddataJasaMedisLovIndex']);
    }

    public function selectNextdataJasaMedisLov()
    {
        if ($this->selecteddataJasaMedisLovIndex === "") {
            $this->selecteddataJasaMedisLovIndex = 0;
        } else {
            $this->selecteddataJasaMedisLovIndex++;
        }

        if ($this->selecteddataJasaMedisLovIndex === count($this->dataJasaMedisLov)) {
            $this->selecteddataJasaMedisLovIndex = 0;
        }
    }

    public function selectPreviousdataJasaMedisLov()
    {

        if ($this->selecteddataJasaMedisLovIndex === "") {
            $this->selecteddataJasaMedisLovIndex = count($this->dataJasaMedisLov) - 1;
        } else {
            $this->selecteddataJasaMedisLovIndex--;
        }

        if ($this->selecteddataJasaMedisLovIndex === -1) {
            $this->selecteddataJasaMedisLovIndex = count($this->dataJasaMedisLov) - 1;
        }
    }

    public function enterMydataJasaMedisLov($id)
    {
        if (!$this->checkRjStatus($this->rjNoRef)) return;

        // jika JK belum siap maka toaster error
        if (isset($this->dataJasaMedisLov[$id]['pact_id'])) {
            $this->addJasaMedis($this->dataJasaMedisLov[$id]['pact_id'], $this->dataJasaMedisLov[$id]['pact_desc'], $this->dataJasaMedisLov[$id]['pact_price']);
            $this->resetdataJasaMedisLov();
        } else {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError("Jasa Medis belum tersedia.");
        }
    }


    // LOV selected end
    /////////////////////////////////////////////////
    // Lov dataJasaMedisLov //////////////////////
    ////////////////////////////////////////////////







    ////////////////////////////////////////////////
    // Lifecycle
    ////////////////////////////////////////////////
    public function mount()
    {
        $this->findData($this->rjNoRef);
    }

    public function render()
    {
        return view('livewire.r-j.emr-r-j.administrasi-r-j.jasa-medis-r-j', [
            'myTitle'   => 'Data Pasien Rawat Jalan',
            'mySnipt'   => 'Rekam Medis Pasien',
            'myProgram' => 'Jasa Medis',
        ]);
    }

    ////////////////////////////////////////////////
    // Form Entry JM
    ////////////////////////////////////////////////
    public $formEntryJasaMedis = [
        'JasaMedisId'    => '',
        'JasaMedisDesc'  => '',
        'JasaMedisPrice' => '',
    ];


    ////////////////////////////////////////////////
    // CRUD Detail JM (race-safe ala EresepRJ)
    ////////////////////////////////////////////////
    public function insertJasaMedis(): void
    {
        if (!$this->checkRjStatus($this->rjNoRef)) return;


        // Validasi draft
        $rules = [
            'formEntryJasaMedis.JasaMedisId'    => 'bail|required|exists:rsmst_actparamedics,pact_id',
            'formEntryJasaMedis.JasaMedisDesc'  => 'bail|required',
            'formEntryJasaMedis.JasaMedisPrice' => 'bail|required|numeric|min:0',
        ];
        $messages = [
            'formEntryJasaMedis.JasaMedisId.required'    => 'Kode tindakan wajib diisi.',
            'formEntryJasaMedis.JasaMedisId.exists'      => 'Kode tindakan tidak valid.',
            'formEntryJasaMedis.JasaMedisDesc.required'  => 'Nama tindakan wajib diisi.',
            'formEntryJasaMedis.JasaMedisPrice.required' => 'Harga wajib diisi.',
            'formEntryJasaMedis.JasaMedisPrice.numeric'  => 'Harga harus angka.',
        ];
        $attributes = [
            'formEntryJasaMedis.JasaMedisId'    => 'Kode Tindakan',
            'formEntryJasaMedis.JasaMedisDesc'  => 'Nama Tindakan',
            'formEntryJasaMedis.JasaMedisPrice' => 'Harga Tindakan',
        ];
        $this->validate($rules, $messages, $attributes);

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";

        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {
                    // LOCK header agar status tidak berubah di tengah proses
                    DB::table('rstxn_rjhdrs')
                        ->where('rj_no', $rjNo)
                        ->first();

                    // 1) Insert JM utama pakai identity/sequence (NO MAX+1)
                    //    Oracle (yajra-oci8) mendukung arg kedua nama kolom id
                    $lastInserted = DB::table('rstxn_rjactparams')
                        ->select(DB::raw("nvl(max(pact_dtl)+1,1) as pact_dtl_max"))
                        ->first();
                    DB::table('rstxn_rjactparams')->insert([
                        'rj_no'      => $rjNo,
                        'pact_id'    => $this->formEntryJasaMedis['JasaMedisId'],
                        'pact_price' => $this->formEntryJasaMedis['JasaMedisPrice'],
                        'pact_dtl' => $lastInserted->pact_dtl_max,
                    ]);

                    // 2) Tambahkan paket Lain-Lain (jika ada mapping)
                    $this->paketLainLainJasaMedis(
                        $this->formEntryJasaMedis['JasaMedisId'],
                        $rjNo,
                        $lastInserted->pact_dtl_max
                    );

                    // 3) Tambahkan paket Obat (hanya ke tabel obat; tidak memodifikasi subtree eresep)
                    $this->paketObatJasaMedis(
                        $this->formEntryJasaMedis['JasaMedisId'],
                        $rjNo,
                        $lastInserted->pact_dtl_max
                    );

                    // 4) Patch state lokal JM + LainLain (untuk UI)
                    $this->dataDaftarPoliRJ['JasaMedis'][] = [
                        'JasaMedisId'    => $this->formEntryJasaMedis['JasaMedisId'],
                        'JasaMedisDesc'  => $this->formEntryJasaMedis['JasaMedisDesc'],
                        'JasaMedisPrice' => $this->formEntryJasaMedis['JasaMedisPrice'],
                        'rjpactDtl'      => $lastInserted->pact_dtl_max,
                        'rjNo'           => $rjNo,
                        'userLog'        => auth()->user()->myuser_name ?? 'system',
                        'userLogDate'    => Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s'),
                    ];
                });
            });

            // Simpan JSON besar sekali jalan (PATCH JM + LainLain saja)
            $this->store();
            $this->emit('rj:refresh-summary');

            $this->reset(['formEntryJasaMedis']);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Jasa Medis ditambahkan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            report($e);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal menambah Jasa Medis: ' . $e->getMessage());
        }
    }

    public function removeJasaMedis($rjpactDtl): void
    {
        if (!$this->checkRjStatus($this->rjNoRef)) return;

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";

        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo, $rjpactDtl) {
                DB::transaction(function () use ($rjNo, $rjpactDtl) {
                    // LOCK header
                    DB::table('rstxn_rjhdrs')
                        ->where('rj_no', $rjNo)
                        ->first();

                    // Hapus anak dulu (atau gunakan FK ON DELETE CASCADE bila ada)
                    DB::table('rstxn_rjothers')->where('pact_dtl', $rjpactDtl)->delete();
                    DB::table('rstxn_rjobats')->where('pact_dtl', $rjpactDtl)->delete();

                    // Hapus induk JM
                    DB::table('rstxn_rjactparams')->where('pact_dtl', $rjpactDtl)->delete();

                    // Sinkron state lokal JSON
                    $this->dataDaftarPoliRJ['JasaMedis'] = collect($this->dataDaftarPoliRJ['JasaMedis'] ?? [])
                        ->reject(fn($i) => (string)($i['rjpactDtl'] ?? '') === (string)$rjpactDtl)
                        ->values()->all();

                    if (!empty($this->dataDaftarPoliRJ['LainLain'])) {
                        $this->dataDaftarPoliRJ['LainLain'] = collect($this->dataDaftarPoliRJ['LainLain'])
                            ->reject(fn($i) => (string)($i['pact_dtl'] ?? '') === (string)$rjpactDtl)
                            ->values()->all();
                    }
                });
            });

            $this->store();
            $this->emit('rj:refresh-summary');
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Jasa Medis dihapus.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            report($e);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal menghapus Jasa Medis: ' . $e->getMessage());
        }
    }

    ////////////////////////////////////////////////
    // Paket Jasa Medis (atomic, tanpa MAX+1)
    ////////////////////////////////////////////////
    private function paketLainLainJasaMedis($pactId, $rjNo, $pactDtl): void
    {
        $collection = DB::table('rsmst_actparothers')
            ->select('other_id', 'acto_price')
            ->where('pact_id', $pactId)
            ->orderBy('pact_id')
            ->get();

        foreach ($collection as $item) {
            $this->insertLainLain($pactId, $rjNo, $pactDtl, $item->other_id, 'Paket JM', $item->acto_price);
        }
    }

    private function insertLainLain($pactId, $rjNo, $pactDtl, $otherId, $otherDesc, $otherPrice): void
    {
        $messages = []; // gunakan trait customErrorMessagesTrait bila tersedia

        $payload = [
            'LainLainId'   => $otherId,
            'LainLainDesc' => $otherDesc,
            'LainLainPrice' => $otherPrice,
            'pactId'       => $pactId,
            'pactDtl'      => $pactDtl,
            'rjNo'         => $rjNo,
        ];

        $rules = [
            'LainLainId'   => 'bail|required|exists:rsmst_others,other_id',
            'LainLainDesc' => 'bail|required',
            'LainLainPrice' => 'bail|required|numeric',
            'pactId'       => 'bail|required',
            'pactDtl'      => 'bail|required|numeric',
            'rjNo'         => 'bail|required|numeric',
        ];

        $validator = Validator::make($payload, $rules, $messages);
        if ($validator->fails()) {
            throw new \InvalidArgumentException('Validasi paket lain-lain gagal');
        }

        $lastInserted = DB::table('rstxn_rjothers')
            ->select(DB::raw("nvl(max(rjo_dtl)+1,1) as rjo_dtl_max"))
            ->first();
        // Insert pakai identity/sequence
        DB::table('rstxn_rjothers')->insert([
            'pact_dtl'    => $payload['pactDtl'],
            'rj_no'       => $payload['rjNo'],
            'other_id'    => $payload['LainLainId'],
            'other_price' => $payload['LainLainPrice'],
            'rjo_dtl' => $lastInserted->rjo_dtl_max
        ]);

        // Patch state lokal untuk subtree LainLain
        $this->dataDaftarPoliRJ['LainLain'][] = [
            'LainLainId'   => $payload['LainLainId'],
            'LainLainDesc' => $payload['LainLainDesc'],
            'LainLainPrice' => $payload['LainLainPrice'],
            'rjotherDtl'   => $lastInserted->rjo_dtl_max,
            'rjNo'         => $payload['rjNo'],
            'pact_dtl'     => $payload['pactDtl'],
        ];
    }

    private function paketObatJasaMedis($pactId, $rjNo, $pactDtl): void
    {
        $collection = DB::table('rsmst_actparproducts')
            ->select(
                'tkmst_products.product_id as product_id',
                'pact_id',
                'actprod_qty',
                'tkmst_products.product_name as product_name',
                'tkmst_products.sales_price as sales_price'
            )
            ->join('tkmst_products', 'tkmst_products.product_id', '=', 'rsmst_actparproducts.product_id')
            ->where('pact_id', $pactId)
            ->orderBy('pact_id')
            ->get();

        foreach ($collection as $item) {
            $this->insertObat($pactId, $rjNo, $pactDtl, $item->product_id, 'Paket JM ' . $item->product_name, $item->sales_price, $item->actprod_qty);
        }
    }

    private function insertObat($pactId, $rjNo, $pactDtl, $ObatId, $ObatDesc, $ObatPrice, $Obatqty): void
    {
        $messages = [];

        $payload = [
            'productId'    => $ObatId,
            'productName'  => $ObatDesc,
            'signaX'       => 1,
            'signaHari'    => 1,
            'qty'          => $Obatqty,
            'productPrice' => $ObatPrice,
            'catatanKhusus' => '-',
            'pactDtl'      => $pactDtl,
            'pactId'       => $pactId,
            'rjNo'         => $rjNo,
        ];

        $rules = [
            'productId'    => 'bail|required|exists:tkmst_products,product_id',
            'productName'  => 'bail|required',
            'signaX'       => 'bail|required|numeric|min:1|max:5',
            'signaHari'    => 'bail|required|numeric|min:1|max:5',
            'qty'          => 'bail|required|digits_between:1,3',
            'productPrice' => 'bail|required|numeric',
            'pactDtl'      => 'bail|required|numeric',
            'pactId'       => 'bail|required',
            'rjNo'         => 'bail|required|numeric',
        ];

        $validator = Validator::make($payload, $rules, $messages);
        if ($validator->fails()) {
            throw new \InvalidArgumentException('Validasi paket obat gagal');
        }

        // exp_date dari rjDate + 30 hari (fallback now+30)
        try {
            $expDate = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'] ?? '')
                ->addDays(30)->format('Y-m-d H:i:s');
        } catch (\Throwable $e) {
            $expDate = Carbon::now()->addDays(30)->format('Y-m-d H:i:s');
        }
        $lastInserted = DB::table('rstxn_rjobats')
            ->select(DB::raw("nvl(max(rjobat_dtl)+1,1) as rjobat_dtl_max"))
            ->first();

        DB::table('rstxn_rjobats')->insert([
            'pact_dtl'      => $payload['pactDtl'],
            'rj_no'         => $payload['rjNo'],
            'product_id'    => $payload['productId'],
            'qty'           => $payload['qty'],
            'price'         => $payload['productPrice'],
            'rj_carapakai'  => $payload['signaX'],
            'rj_kapsul'     => $payload['signaHari'],
            'rj_takar'      => 'Tablet',
            'catatan_khusus' => $payload['catatanKhusus'],
            'exp_date'      => $expDate,
            'etiket_status' => 0,
            'rjobat_dtl' => $lastInserted->rjobat_dtl_max
        ]);
        // Tidak memodifikasi subtree JSON 'eresep' agar terpisah dari fitur resep manual
    }

    ////////////////////////////////////////////////
    // Simpan JSON besar (PATCH hanya JM + LainLain)
    ////////////////////////////////////////////////
    public function store()
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";

        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {
                    // Ambil fresh dari DB supaya subtree lain (anamnesis, vital, dll) tidak ketimpa
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!is_array($fresh)) $fresh = [];

                    foreach (['JasaMedis', 'LainLain'] as $key) {
                        if (!isset($fresh[$key]) || !is_array($fresh[$key])) {
                            $fresh[$key] = [];
                        }
                    }

                    // PATCH: replace subtree dengan state lokal
                    $fresh['JasaMedis'] = array_values($this->dataDaftarPoliRJ['JasaMedis'] ?? []);
                    $fresh['LainLain']  = array_values($this->dataDaftarPoliRJ['LainLain']  ?? []);

                    $this->updateJsonRJ($rjNo, $fresh);
                    // Sinkron state komponen
                    $this->dataDaftarPoliRJ = $fresh;
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Jasa Medis berhasil disimpan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            report($e);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal menyimpan: ' . $e->getMessage());
        }
    }

    ////////////////////////////////////////////////
    // Load awal
    ////////////////////////////////////////////////
    private function findData($rjNo): void
    {
        $findDataRJ = $this->findDataRJ($rjNo);
        $this->dataDaftarPoliRJ = $findDataRJ['dataDaftarRJ'] ?? [];

        foreach (['JasaMedis', 'LainLain'] as $key) {
            if (!isset($this->dataDaftarPoliRJ[$key])) {
                $this->dataDaftarPoliRJ[$key] = [];
            }
        }
    }



    ////////////////////////////////////////////////
    // Util: reset form
    ////////////////////////////////////////////////
    public function resetFormEntryJasaMedis(): void
    {
        $this->reset(['formEntryJasaMedis']);
    }
}
