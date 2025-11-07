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
use App\Http\Traits\customErrorMessagesTrait;

class JasaDokterRJ extends Component
{
    use EmrRJTrait;


    ////////////////////////////////////////////////
    // Refs & State
    ////////////////////////////////////////////////
    public $rjNoRef;
    public string $rjStatusRef = 'A';
    public array $dataDaftarPoliRJ = [];

    // LOV
    public $dataJasaDokterLov = [];
    public $dataJasaDokterLovStatus = 0;
    public $dataJasaDokterLovSearch = '';
    public $selecteddataJasaDokterLovIndex = 0;

    ////////////////////////////////////////////////
    // Lifecycle
    ////////////////////////////////////////////////
    public function mount()
    {
        $this->findData($this->rjNoRef);
    }

    public function render()
    {
        return view('livewire.r-j.emr-r-j.administrasi-r-j.jasa-dokter-r-j', [
            'myTitle'   => 'Data Pasien Rawat Jalan',
            'mySnipt'   => 'Rekam Medis Pasien',
            'myProgram' => 'Jasa Dokter',
        ]);
    }

    ////////////////////////////////////////////////
    // Form Entry JD
    ////////////////////////////////////////////////
    public $formEntryJasaDokter = [
        'JasaDokterId'    => '',
        'JasaDokterDesc'  => '',
        'JasaDokterPrice' => '',
    ];

    private function setJDFromLov($accdocId, $accdocDesc, $price): void
    {
        $this->formEntryJasaDokter = [
            'JasaDokterId'    => $accdocId,
            'JasaDokterDesc'  => $accdocDesc,
            'JasaDokterPrice' => $price,
        ];
    }

    ////////////////////////////////////////////////
    // LOV JD
    ////////////////////////////////////////////////
    public function clickdataJasaDokterLov()
    {
        $this->dataJasaDokterLovStatus = true;
        $this->dataJasaDokterLov = [];
    }

    public function updateddataJasaDokterLovsearch()
    {
        $this->reset(['selecteddataJasaDokterLovIndex', 'dataJasaDokterLov']);
        $search = $this->dataJasaDokterLovSearch;

        $exact = DB::table('rsmst_accdocs')
            ->select('accdoc_id', 'accdoc_desc', 'accdoc_price')
            ->where('active_status', '1')
            ->where('accdoc_id', $search)
            ->first();

        if ($exact) {
            $this->setJDFromLov($exact->accdoc_id, $exact->accdoc_desc, $exact->accdoc_price);
            $this->resetdataJasaDokterLov();
        } else {
            if (strlen($search) < 1) {
                $this->dataJasaDokterLov = [];
            } else {
                $this->dataJasaDokterLov = json_decode(
                    DB::table('rsmst_accdocs')
                        ->select('accdoc_id', 'accdoc_desc', 'accdoc_price')
                        ->where('active_status', '1')
                        ->where(DB::raw('upper(accdoc_desc)'), 'like', '%' . strtoupper($search) . '%')
                        ->limit(10)
                        ->orderBy('accdoc_id', 'ASC')
                        ->orderBy('accdoc_desc', 'ASC')
                        ->get(),
                    true
                );
            }
            $this->dataJasaDokterLovStatus = true;
        }
    }

    public function setMydataJasaDokterLov($id)
    {
        if (!$this->checkRjStatus()) return;
        $row = DB::table('rsmst_accdocs')
            ->select('accdoc_id', 'accdoc_desc', 'accdoc_price')
            ->where('active_status', '1')
            ->where('accdoc_id', $this->dataJasaDokterLov[$id]['accdoc_id'] ?? null)
            ->first();
        if ($row) {
            $this->setJDFromLov($row->accdoc_id, $row->accdoc_desc, $row->accdoc_price);
            $this->resetdataJasaDokterLov();
        }
    }

    public function resetdataJasaDokterLov()
    {
        $this->reset(['dataJasaDokterLov', 'dataJasaDokterLovStatus', 'dataJasaDokterLovSearch', 'selecteddataJasaDokterLovIndex']);
    }

    public function selectNextdataJasaDokterLov()
    {
        if ($this->selecteddataJasaDokterLovIndex === "") {
            $this->selecteddataJasaDokterLovIndex = 0;
        } else {
            $this->selecteddataJasaDokterLovIndex++;
        }
        if ($this->selecteddataJasaDokterLovIndex === count($this->dataJasaDokterLov)) {
            $this->selecteddataJasaDokterLovIndex = 0;
        }
    }

    public function selectPreviousdataJasaDokterLov()
    {
        if ($this->selecteddataJasaDokterLovIndex === "") {
            $this->selecteddataJasaDokterLovIndex = count($this->dataJasaDokterLov) - 1;
        } else {
            $this->selecteddataJasaDokterLovIndex--;
        }
        if ($this->selecteddataJasaDokterLovIndex === -1) {
            $this->selecteddataJasaDokterLovIndex = count($this->dataJasaDokterLov) - 1;
        }
    }

    public function enterMydataJasaDokterLov($id)
    {
        if (!$this->checkRjStatus()) return;
        if (isset($this->dataJasaDokterLov[$id]['accdoc_id'])) {
            $row = $this->dataJasaDokterLov[$id];
            $this->setJDFromLov($row['accdoc_id'], $row['accdoc_desc'], $row['accdoc_price']);
            $this->resetdataJasaDokterLov();
        } else {
            $this->emit('toastr-error', 'Jasa Dokter belum tersedia.');
        }
    }

    ////////////////////////////////////////////////
    // CRUD JD (race-safe ala JM/Eresep)
    ////////////////////////////////////////////////
    public function insertJasaDokter(): void
    {
        if (!$this->checkRjStatus()) return;

        $rules = [
            'formEntryJasaDokter.JasaDokterId'    => 'bail|required|exists:rsmst_accdocs,accdoc_id',
            'formEntryJasaDokter.JasaDokterDesc'  => 'bail|required',
            'formEntryJasaDokter.JasaDokterPrice' => 'bail|required|numeric|min:0',
        ];
        $messages = [
            'formEntryJasaDokter.JasaDokterId.required'    => 'Kode tindakan wajib diisi.',
            'formEntryJasaDokter.JasaDokterId.exists'      => 'Kode tindakan tidak valid.',
            'formEntryJasaDokter.JasaDokterDesc.required'  => 'Nama tindakan wajib diisi.',
            'formEntryJasaDokter.JasaDokterPrice.required' => 'Harga wajib diisi.',
            'formEntryJasaDokter.JasaDokterPrice.numeric'  => 'Harga harus angka.',
        ];
        $attributes = [
            'formEntryJasaDokter.JasaDokterId'    => 'Kode Tindakan',
            'formEntryJasaDokter.JasaDokterDesc'  => 'Nama Tindakan',
            'formEntryJasaDokter.JasaDokterPrice' => 'Harga Tindakan',
        ];
        $this->validate($rules, $messages, $attributes);

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";

        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {
                    // LOCK header
                    DB::table('rstxn_rjhdrs')->where('rj_no', $rjNo)->lockForUpdate()->first();

                    // Insert JD parent (tanpa MAX+1) -> ambil rjhn_dtl
                    $lastInserted = DB::table('rstxn_rjaccdocs')
                        ->select(DB::raw("nvl(max(rjhn_dtl)+1,1) as rjhn_dtl_max"))
                        ->first();

                    $accdocDtl = DB::table('rstxn_rjaccdocs')->insert([
                        'rj_no'       => $rjNo,
                        'accdoc_id'   => $this->formEntryJasaDokter['JasaDokterId'],
                        'accdoc_price' => $this->formEntryJasaDokter['JasaDokterPrice'],
                        'rjhn_dtl' => $lastInserted->rjhn_dtl_max
                    ]);

                    // Paket lain-lain
                    $this->paketLainLainJasaDokter(
                        $this->formEntryJasaDokter['JasaDokterId'],
                        $rjNo,
                        $accdocDtl
                    );

                    // Paket obat
                    $this->paketObatJasaDokter(
                        $this->formEntryJasaDokter['JasaDokterId'],
                        $rjNo,
                        $accdocDtl
                    );

                    // Patch state lokal JSON
                    $this->dataDaftarPoliRJ['JasaDokter'][] = [
                        'JasaDokterId'    => $this->formEntryJasaDokter['JasaDokterId'],
                        'JasaDokterDesc'  => $this->formEntryJasaDokter['JasaDokterDesc'],
                        'JasaDokterPrice' => $this->formEntryJasaDokter['JasaDokterPrice'],
                        'rjaccdocDtl'     => $accdocDtl,
                        'rjNo'            => $rjNo,
                        'userLog'         => auth()->user()->myuser_name ?? 'system',
                        'userLogDate'     => Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s'),
                    ];
                });
            });

            $this->store();
            $this->emit('rj:refresh-summary');
            $this->reset(['formEntryJasaDokter']);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addSuccess('Jasa Dokter ditambahkan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            report($e);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Gagal menambah Jasa Dokter: ' . $e->getMessage());
        }
    }

    public function removeJasaDokter($rjaccdocDtl): void
    {
        if (!$this->checkRjStatus()) return;

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";

        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo, $rjaccdocDtl) {
                DB::transaction(function () use ($rjNo, $rjaccdocDtl) {
                    DB::table('rstxn_rjhdrs')->where('rj_no', $rjNo)->lockForUpdate()->first();

                    // Hapus anak
                    DB::table('rstxn_rjothers')->where('rjhn_dtl', $rjaccdocDtl)->delete();
                    DB::table('rstxn_rjobats')->where('rjhn_dtl', $rjaccdocDtl)->delete();

                    // Hapus induk
                    DB::table('rstxn_rjaccdocs')->where('rjhn_dtl', $rjaccdocDtl)->delete();

                    // Patch state
                    $this->dataDaftarPoliRJ['JasaDokter'] = collect($this->dataDaftarPoliRJ['JasaDokter'] ?? [])
                        ->reject(fn($i) => (string)($i['rjaccdocDtl'] ?? '') === (string)$rjaccdocDtl)
                        ->values()->all();

                    if (!empty($this->dataDaftarPoliRJ['LainLain'])) {
                        $this->dataDaftarPoliRJ['LainLain'] = collect($this->dataDaftarPoliRJ['LainLain'])
                            ->reject(fn($i) => (string)($i['rjhn_dtl'] ?? '') === (string)$rjaccdocDtl)
                            ->values()->all();
                    }
                });
            });

            $this->store();
            $this->emit('rj:refresh-summary');
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addSuccess('Jasa Dokter dihapus.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            report($e);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Gagal menghapus Jasa Dokter: ' . $e->getMessage());
        }
    }

    ////////////////////////////////////////////////
    // Paket JasaDokter -> Lain lain
    ////////////////////////////////////////////////
    private function paketLainLainJasaDokter($accdocId, $rjNo, $accdocDtl): void
    {
        $collection = DB::table('rsmst_accdocothers')
            ->select('other_id', 'accdother_price')
            ->where('accdoc_id', $accdocId)
            ->orderBy('accdoc_id')
            ->get();

        foreach ($collection as $item) {
            $this->insertLainLainJD($accdocId, $rjNo, $accdocDtl, $item->other_id, 'Paket JD', $item->accdother_price);
        }
    }

    private function insertLainLainJD($accdocId, $rjNo, $accdocDtl, $otherId, $otherDesc, $otherPrice): void
    {
        $messages = customErrorMessagesTrait::messages();
        $payload = [
            'LainLainId'    => $otherId,
            'LainLainDesc'  => $otherDesc,
            'LainLainPrice' => $otherPrice,
            'accdocId'      => $accdocId,
            'accdocDtl'     => $accdocDtl,
            'rjNo'          => $rjNo,
        ];
        $rules = [
            'LainLainId'    => 'bail|required|exists:rsmst_others,other_id',
            'LainLainDesc'  => 'bail|required',
            'LainLainPrice' => 'bail|required|numeric',
            'accdocId'      => 'bail|required',
            'accdocDtl'     => 'bail|required|numeric',
            'rjNo'          => 'bail|required|numeric',
        ];
        $validator = Validator::make($payload, $rules, $messages);
        if ($validator->fails()) {
            throw new \InvalidArgumentException('Validasi paket lain-lain JD gagal');
        }
        $lastInserted = DB::table('rstxn_rjothers')
            ->select(DB::raw("nvl(max(rjo_dtl)+1,1) as rjo_dtl_max"))
            ->first();

        $rjoDtl = DB::table('rstxn_rjothers')->insertGetId([
            'rjhn_dtl'    => $payload['accdocDtl'],
            'rj_no'       => $payload['rjNo'],
            'other_id'    => $payload['LainLainId'],
            'other_price' => $payload['LainLainPrice'],
            'rjo_dtl' => $lastInserted->rjo_dtl_max,
        ]);

        $this->dataDaftarPoliRJ['LainLain'][] = [
            'LainLainId'    => $payload['LainLainId'],
            'LainLainDesc'  => $payload['LainLainDesc'],
            'LainLainPrice' => $payload['LainLainPrice'],
            'rjotherDtl'    => $rjoDtl,
            'rjNo'          => $payload['rjNo'],
            'rjhn_dtl'      => $payload['accdocDtl'],
        ];
    }

    ////////////////////////////////////////////////
    // Paket JasaDokter -> Obat
    ////////////////////////////////////////////////
    private function paketObatJasaDokter($accdocId, $rjNo, $accdocDtl): void
    {
        $collection = DB::table('rsmst_accdocproducts')
            ->select(
                'tkmst_products.product_id as product_id',
                'accdoc_id',
                'accdprod_qty',
                'tkmst_products.product_name as product_name',
                'tkmst_products.sales_price as sales_price'
            )
            ->join('tkmst_products', 'tkmst_products.product_id', '=', 'rsmst_accdocproducts.product_id')
            ->where('accdoc_id', $accdocId)
            ->orderBy('accdoc_id')
            ->get();

        foreach ($collection as $item) {
            $this->insertObatJD($accdocId, $rjNo, $accdocDtl, $item->product_id, 'Paket JD ' . $item->product_name, $item->sales_price, $item->accdprod_qty);
        }
    }

    private function insertObatJD($accdocId, $rjNo, $accdocDtl, $ObatId, $ObatDesc, $ObatPrice, $Obatqty): void
    {
        $messages = customErrorMessagesTrait::messages();
        $payload = [
            'productId'    => $ObatId,
            'productName'  => $ObatDesc,
            'signaX'       => 1,
            'signaHari'    => 1,
            'qty'          => $Obatqty,
            'productPrice' => $ObatPrice,
            'catatanKhusus' => '-',
            'accdocDtl'    => $accdocDtl,
            'accdocId'     => $accdocId,
            'rjNo'         => $rjNo,
        ];
        $rules = [
            'productId'    => 'bail|required|exists:tkmst_products,product_id',
            'productName'  => 'bail|required',
            'signaX'       => 'bail|required|numeric|min:1|max:5',
            'signaHari'    => 'bail|required|numeric|min:1|max:5',
            'qty'          => 'bail|required|digits_between:1,3',
            'productPrice' => 'bail|required|numeric',
            'accdocDtl'    => 'bail|required|numeric',
            'accdocId'     => 'bail|required',
            'rjNo'         => 'bail|required|numeric',
        ];
        $validator = Validator::make($payload, $rules, $messages);
        if ($validator->fails()) {
            throw new \InvalidArgumentException('Validasi paket obat JD gagal');
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
            'rjhn_dtl'      => $payload['accdocDtl'],
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
            'rjobat_dtl' => $lastInserted->rjobat_dtl_max,
        ]);
    }

    ////////////////////////////////////////////////
    // Simpan JSON besar (PATCH JD + LainLain)
    ////////////////////////////////////////////////
    public function store()
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";

        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!is_array($fresh)) $fresh = [];

                    foreach (['JasaDokter', 'LainLain'] as $key) {
                        if (!isset($fresh[$key]) || !is_array($fresh[$key])) {
                            $fresh[$key] = [];
                        }
                    }

                    $fresh['JasaDokter'] = array_values($this->dataDaftarPoliRJ['JasaDokter'] ?? []);
                    $fresh['LainLain']   = array_values($this->dataDaftarPoliRJ['LainLain']   ?? []);

                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarPoliRJ = $fresh;
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addSuccess('Jasa Dokter berhasil disimpan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            report($e);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Gagal menyimpan: ' . $e->getMessage());
        }
    }

    ////////////////////////////////////////////////
    // Load awal
    ////////////////////////////////////////////////
    private function findData($rjNo): void
    {
        $findDataRJ = $this->findDataRJ($rjNo);
        $this->dataDaftarPoliRJ = $findDataRJ['dataDaftarRJ'] ?? [];

        foreach (['JasaDokter', 'LainLain'] as $key) {
            if (!isset($this->dataDaftarPoliRJ[$key])) {
                $this->dataDaftarPoliRJ[$key] = [];
            }
        }
    }

    ////////////////////////////////////////////////
    // Guard ringan untuk UI
    ////////////////////////////////////////////////
    public function checkRjStatus(): bool
    {
        $row = DB::table('rstxn_rjhdrs')
            ->select('rj_status')
            ->where('rj_no', $this->rjNoRef)
            ->first();

        if (!$row || $row->rj_status !== 'A') {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Pasien Sudah Pulang, Transaksi Terkunci.');
            return false;
        }
        return true;
    }

    ////////////////////////////////////////////////
    // Util: reset form
    ////////////////////////////////////////////////
    public function resetFormEntryJasaDokter(): void
    {
        $this->reset(['formEntryJasaDokter']);
    }
}
