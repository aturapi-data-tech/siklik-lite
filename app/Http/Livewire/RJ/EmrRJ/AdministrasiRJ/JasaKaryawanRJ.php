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

class JasaKaryawanRJ extends Component
{
    use EmrRJTrait;
    protected $listeners = [
        'rj:refresh-data-admin' => 'mount'
    ];
    ////////////////////////////////////////////////
    // Refs & State
    ////////////////////////////////////////////////
    public $rjNoRef;                 // set dari parent/route
    public string $rjStatusRef = 'A';

    public array $dataDaftarPoliRJ = []; // payload JSON besar

    // LOV
    public array $dataJasaKaryawanLov = [];
    public int $dataJasaKaryawanLovStatus = 0;
    public string $dataJasaKaryawanLovSearch = '';
    public $selecteddataJasaKaryawanLovIndex = 0;

    ////////////////////////////////////////////////
    // Lifecycle
    ////////////////////////////////////////////////
    public function mount()
    {
        $this->findData($this->rjNoRef);
    }

    public function render()
    {
        return view('livewire.r-j.emr-r-j.administrasi-r-j.jasa-karyawan-r-j', [
            'myTitle'   => 'Data Pasien Rawat Jalan',
            'mySnipt'   => 'Rekam Medis Pasien',
            'myProgram' => 'Jasa Karyawan',
        ]);
    }

    ////////////////////////////////////////////////
    // Form Entry JK
    ////////////////////////////////////////////////
    public $formEntryJasaKaryawan = [
        'JasaKaryawanId'    => '',
        'JasaKaryawanDesc'  => '',
        'JasaKaryawanPrice' => '',
    ];

    private function addJasaKaryawan($id, $desc, $price): void
    {
        $this->formEntryJasaKaryawan = [
            'JasaKaryawanId'    => $id,
            'JasaKaryawanDesc'  => $desc,
            'JasaKaryawanPrice' => $price,
        ];
    }

    ////////////////////////////////////////////////
    // LOV JK
    ////////////////////////////////////////////////
    public function clickdataJasaKaryawanLov()
    {
        $this->dataJasaKaryawanLovStatus = 1;
        $this->dataJasaKaryawanLov = [];
    }

    public function updateddataJasaKaryawanLovsearch()
    {
        $this->reset(['selecteddataJasaKaryawanLovIndex', 'dataJasaKaryawanLov']);
        $search = $this->dataJasaKaryawanLovSearch;

        $row = DB::table('rsmst_actemps')
            ->select('acte_id', 'acte_desc', 'acte_price')
            ->where('acte_id', $search)
            ->where('active_status', '1')
            ->first();

        if ($row) {
            $this->addJasaKaryawan($row->acte_id, $row->acte_desc, $row->acte_price);
            $this->resetdataJasaKaryawanLov();
        } else {
            if (strlen($search) < 1) {
                $this->dataJasaKaryawanLov = [];
            } else {
                $this->dataJasaKaryawanLov = json_decode(
                    DB::table('rsmst_actemps')
                        ->select('acte_id', 'acte_desc', 'acte_price')
                        ->where('active_status', '1')
                        ->where(DB::raw('upper(acte_desc)'), 'like', '%' . strtoupper($search) . '%')
                        ->limit(10)
                        ->orderBy('acte_id')
                        ->orderBy('acte_desc')
                        ->get(),
                    true
                );
            }
            $this->dataJasaKaryawanLovStatus = 1;
        }
    }

    public function setMydataJasaKaryawanLov($id)
    {
        if (!$this->checkRjStatus($this->rjNoRef)) return;
        $row = DB::table('rsmst_actemps')
            ->select('acte_id', 'acte_desc', 'acte_price')
            ->where('active_status', '1')
            ->where('acte_id', $this->dataJasaKaryawanLov[$id]['acte_id'] ?? null)
            ->first();

        if ($row) {
            $this->addJasaKaryawan($row->acte_id, $row->acte_desc, $row->acte_price);
            $this->resetdataJasaKaryawanLov();
        } else {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Data tidak ditemukan.');
        }
    }

    public function resetdataJasaKaryawanLov()
    {
        $this->reset(['dataJasaKaryawanLov', 'dataJasaKaryawanLovStatus', 'dataJasaKaryawanLovSearch', 'selecteddataJasaKaryawanLovIndex']);
    }
    public function selectNextdataJasaKaryawanLov()
    {
        $this->selecteddataJasaKaryawanLovIndex = ($this->selecteddataJasaKaryawanLovIndex === '' ? 0 : $this->selecteddataJasaKaryawanLovIndex + 1) % max(1, count($this->dataJasaKaryawanLov));
    }
    public function selectPreviousdataJasaKaryawanLov()
    {
        $n = count($this->dataJasaKaryawanLov);
        $this->selecteddataJasaKaryawanLovIndex = ($this->selecteddataJasaKaryawanLovIndex === '' ? $n - 1 : ($this->selecteddataJasaKaryawanLovIndex - 1 + $n) % max(1, $n));
    }
    public function enterMydataJasaKaryawanLov($id)
    {
        if (!$this->checkRjStatus($this->rjNoRef)) return;
        if (isset($this->dataJasaKaryawanLov[$id]['acte_id'])) {
            $this->addJasaKaryawan(
                $this->dataJasaKaryawanLov[$id]['acte_id'],
                $this->dataJasaKaryawanLov[$id]['acte_desc'],
                $this->dataJasaKaryawanLov[$id]['acte_price']
            );
            $this->resetdataJasaKaryawanLov();
        } else {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Jasa Karyawan belum tersedia.');
        }
    }

    ////////////////////////////////////////////////
    // CRUD Detail JK (race-safe ala EresepRJ)
    ////////////////////////////////////////////////
    public function insertJasaKaryawan(): void
    {
        if (!$this->checkRjStatus($this->rjNoRef)) return;

        $rules = [
            'formEntryJasaKaryawan.JasaKaryawanId'    => 'bail|required|exists:rsmst_actemps,acte_id',
            'formEntryJasaKaryawan.JasaKaryawanDesc'  => 'bail|required',
            'formEntryJasaKaryawan.JasaKaryawanPrice' => 'bail|required|numeric|min:0',
        ];
        $messages = customErrorMessagesTrait::messages();
        $attributes = [
            'formEntryJasaKaryawan.JasaKaryawanId'    => 'Kode JK',
            'formEntryJasaKaryawan.JasaKaryawanDesc'  => 'Nama JK',
            'formEntryJasaKaryawan.JasaKaryawanPrice' => 'Harga JK',
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
                    // lock header (optimistic guard)


                    // Insert induk JK – gunakan generator id yang aman.
                    // Jika DB Anda punya sequence/identity, ganti blok ini menjadi insertGetId.
                    $last = DB::table('rstxn_rjactemps')->select(DB::raw('nvl(max(acte_dtl)+1,1) as next_id'))->first();
                    $acteDtl = (int)($last->next_id ?? 1);

                    DB::table('rstxn_rjactemps')->insert([
                        'acte_dtl'  => $acteDtl,
                        'rj_no'     => $rjNo,
                        'acte_id'   => $this->formEntryJasaKaryawan['JasaKaryawanId'],
                        'acte_price' => $this->formEntryJasaKaryawan['JasaKaryawanPrice'],
                    ]);

                    // Paket Lain‑Lain
                    $this->paketLainLainJasaKaryawan(
                        $this->formEntryJasaKaryawan['JasaKaryawanId'],
                        $rjNo,
                        $acteDtl
                    );

                    // Paket Obat
                    $this->paketObatJasaKaryawan(
                        $this->formEntryJasaKaryawan['JasaKaryawanId'],
                        $rjNo,
                        $acteDtl
                    );

                    // Patch state lokal (untuk UI)
                    $this->dataDaftarPoliRJ['JasaKaryawan'][] = [
                        'JasaKaryawanId'    => $this->formEntryJasaKaryawan['JasaKaryawanId'],
                        'JasaKaryawanDesc'  => $this->formEntryJasaKaryawan['JasaKaryawanDesc'],
                        'JasaKaryawanPrice' => $this->formEntryJasaKaryawan['JasaKaryawanPrice'],
                        'rjActeDtl'         => $acteDtl,
                        'rjNo'              => $rjNo,
                        'userLog'           => auth()->user()->myuser_name ?? 'system',
                        'userLogDate'       => Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s'),
                    ];
                });
            });

            // commit JSON (PATCH subtree JK + LainLain)
            $this->store();
            $this->emit('rj:refresh-summary');
            $this->emit('rj:refresh-data-admin');
            $this->reset(['formEntryJasaKaryawan']);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addSuccess('Jasa Karyawan ditambahkan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            report($e);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Gagal menambah Jasa Karyawan: ' . $e->getMessage());
        }
    }

    public function removeJasaKaryawan($rjActeDtl): void
    {
        if (!$this->checkRjStatus($this->rjNoRef)) return;

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";

        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo, $rjActeDtl) {
                DB::transaction(function () use ($rjNo, $rjActeDtl) {


                    // Hapus anak dulu
                    DB::table('rstxn_rjothers')->where('acte_dtl', $rjActeDtl)->delete();
                    DB::table('rstxn_rjobats')->where('acte_dtl', $rjActeDtl)->delete();

                    // Hapus induk
                    DB::table('rstxn_rjactemps')->where('acte_dtl', $rjActeDtl)->delete();

                    // Sinkron state lokal
                    $this->dataDaftarPoliRJ['JasaKaryawan'] = collect($this->dataDaftarPoliRJ['JasaKaryawan'] ?? [])
                        ->reject(fn($i) => (string)($i['rjActeDtl'] ?? '') === (string)$rjActeDtl)
                        ->values()->all();

                    if (!empty($this->dataDaftarPoliRJ['LainLain'])) {
                        $this->dataDaftarPoliRJ['LainLain'] = collect($this->dataDaftarPoliRJ['LainLain'])
                            ->reject(fn($i) => (string)($i['acte_dtl'] ?? '') === (string)$rjActeDtl)
                            ->values()->all();
                    }
                });
            });

            $this->store();
            $this->emit('rj:refresh-summary');
            $this->emit('rj:refresh-data-admin');
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addSuccess('Jasa Karyawan dihapus.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            report($e);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Gagal menghapus Jasa Karyawan: ' . $e->getMessage());
        }
    }

    ////////////////////////////////////////////////
    // Paket JK → Lain‑Lain
    ////////////////////////////////////////////////
    private function paketLainLainJasaKaryawan($acteId, $rjNo, $acteDtl): void
    {
        $rows = DB::table('rsmst_acteothers')
            ->select('other_id', 'acteother_price')
            ->where('acte_id', $acteId)
            ->orderBy('acte_id')
            ->get();

        foreach ($rows as $it) {
            $this->insertLainLain($acteId, $rjNo, $acteDtl, $it->other_id, 'Paket JK', $it->acteother_price);
        }
    }

    private function insertLainLain($acteId, $rjNo, $acteDtl, $otherId, $otherDesc, $otherPrice): void
    {
        $payload = [
            'LainLainId'   => $otherId,
            'LainLainDesc' => $otherDesc,
            'LainLainPrice' => $otherPrice,
            'acteId'       => $acteId,
            'acteDtl'      => $acteDtl,
            'rjNo'         => $rjNo,
        ];

        $rules = [
            'LainLainId'    => 'bail|required|exists:rsmst_others,other_id',
            'LainLainDesc'  => 'bail|required',
            'LainLainPrice' => 'bail|required|numeric',
            'acteId'        => 'bail|required',
            'acteDtl'       => 'bail|required|numeric',
            'rjNo'          => 'bail|required|numeric',
        ];

        $validator = Validator::make($payload, $rules, customErrorMessagesTrait::messages());
        if ($validator->fails()) throw new \InvalidArgumentException('Validasi paket lain-lain gagal');

        // id detail anak – jika tersedia pakai identity/sequence Anda
        $last = DB::table('rstxn_rjothers')->select(DB::raw('nvl(max(rjo_dtl)+1,1) as next_id'))->first();
        $rjoDtl = (int)($last->next_id ?? 1);

        DB::table('rstxn_rjothers')->insert([
            'rjo_dtl'    => $rjoDtl,
            'acte_dtl'   => $payload['acteDtl'],
            'rj_no'      => $payload['rjNo'],
            'other_id'   => $payload['LainLainId'],
            'other_price' => $payload['LainLainPrice'],
        ]);

        // patch state lokal
        $this->dataDaftarPoliRJ['LainLain'][] = [
            'LainLainId'   => $payload['LainLainId'],
            'LainLainDesc' => $payload['LainLainDesc'],
            'LainLainPrice' => $payload['LainLainPrice'],
            'rjotherDtl'   => $rjoDtl,
            'rjNo'         => $payload['rjNo'],
            'acte_dtl'     => $payload['acteDtl'],
        ];
    }

    ////////////////////////////////////////////////
    // Paket JK → Obat (tidak memodifikasi subtree JSON 'eresep')
    ////////////////////////////////////////////////
    private function paketObatJasaKaryawan($acteId, $rjNo, $acteDtl): void
    {
        $rows = DB::table('rsmst_acteprods')
            ->select(
                'tkmst_products.product_id as product_id',
                'acte_id',
                'acteprod_qty',
                'tkmst_products.product_name as product_name',
                'tkmst_products.sales_price as sales_price'
            )
            ->join('tkmst_products', 'tkmst_products.product_id', '=', 'rsmst_acteprods.product_id')
            ->where('acte_id', $acteId)
            ->orderBy('acte_id')
            ->get();

        foreach ($rows as $it) {
            $this->insertObat(
                $acteId,
                $rjNo,
                $acteDtl,
                $it->product_id,
                'Paket JK ' . $it->product_name,
                $it->sales_price,
                $it->acteprod_qty
            );
        }
    }

    private function insertObat($acteId, $rjNo, $acteDtl, $obatId, $obatDesc, $obatPrice, $obatQty): void
    {
        $payload = [
            'productId'    => $obatId,
            'productName'  => $obatDesc,
            'signaX'       => 1,
            'signaHari'    => 1,
            'qty'          => $obatQty,
            'productPrice' => $obatPrice,
            'catatanKhusus' => '-',
            'acteDtl'      => $acteDtl,
            'acteId'       => $acteId,
            'rjNo'         => $rjNo,
        ];

        $rules = [
            'productId'    => 'bail|required|exists:tkmst_products,product_id',
            'productName'  => 'bail|required',
            'signaX'       => 'bail|required|numeric|min:1|max:5',
            'signaHari'    => 'bail|required|numeric|min:1|max:5',
            'qty'          => 'bail|required|digits_between:1,3',
            'productPrice' => 'bail|required|numeric',
            'acteDtl'      => 'bail|required|numeric',
            'acteId'       => 'bail|required',
            'rjNo'         => 'bail|required|numeric',
        ];

        $validator = Validator::make($payload, $rules, customErrorMessagesTrait::messages());
        if ($validator->fails()) throw new \InvalidArgumentException('Validasi paket obat gagal');

        // exp_date: rjDate +30 hari
        try {
            $expDate = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'] ?? '')
                ->addDays(30)->format('Y-m-d H:i:s');
        } catch (\Throwable $e) {
            $expDate = Carbon::now()->addDays(30)->format('Y-m-d H:i:s');
        }

        $last = DB::table('rstxn_rjobats')->select(DB::raw('nvl(max(rjobat_dtl)+1,1) as next_id'))->first();
        $rjObatDtl = (int)($last->next_id ?? 1);

        DB::table('rstxn_rjobats')->insert([
            'rjobat_dtl'   => $rjObatDtl,
            'acte_dtl'     => $payload['acteDtl'],
            'rj_no'        => $payload['rjNo'],
            'product_id'   => $payload['productId'],
            'qty'          => $payload['qty'],
            'price'        => $payload['productPrice'],
            'rj_carapakai' => $payload['signaX'],
            'rj_kapsul'    => $payload['signaHari'],
            'rj_takar'     => 'Tablet',
            'catatan_khusus' => $payload['catatanKhusus'],
            'exp_date'     => $expDate,
            'etiket_status' => 0,
        ]);
        // Tidak menyentuh subtree JSON 'eresep'
    }

    ////////////////////////////////////////////////
    // Simpan JSON besar (PATCH JK + LainLain saja)
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
                    // ambil fresh supaya subtree lain aman
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!is_array($fresh)) $fresh = [];

                    foreach (['JasaKaryawan', 'LainLain'] as $key) {
                        if (!isset($fresh[$key]) || !is_array($fresh[$key])) $fresh[$key] = [];
                    }

                    $fresh['JasaKaryawan'] = array_values($this->dataDaftarPoliRJ['JasaKaryawan'] ?? []);
                    $fresh['LainLain']     = array_values($this->dataDaftarPoliRJ['LainLain'] ?? []);

                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarPoliRJ = $fresh; // sync local
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addSuccess('Jasa Karyawan berhasil disimpan.');
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
        $wrap = $this->findDataRJ($rjNo);
        $this->dataDaftarPoliRJ = $wrap['dataDaftarRJ'] ?? [];
        foreach (['JasaKaryawan', 'LainLain'] as $k) if (!isset($this->dataDaftarPoliRJ[$k])) $this->dataDaftarPoliRJ[$k] = [];
    }

    ////////////////////////////////////////////////
    // Guard ringan untuk UI
    ////////////////////////////////////////////////


    ////////////////////////////////////////////////
    // Util
    ////////////////////////////////////////////////
    public function resetcollectingMyJasaKaryawan()
    {
        $this->reset(['formEntryJasaKaryawan']);
    }
    public function resetFormEntryJasaKaryawan(): void
    {
        $this->reset(['formEntryJasaKaryawan']);
    }
}
