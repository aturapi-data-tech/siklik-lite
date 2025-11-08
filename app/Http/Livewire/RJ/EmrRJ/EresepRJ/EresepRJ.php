<?php

namespace App\Http\Livewire\RJ\EmrRJ\EresepRJ;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Exception;
use App\Http\Traits\EmrRJ\EmrRJTrait;
use App\Http\Traits\LOV\LOVProduct\LOVProductTrait;


class EresepRJ extends Component
{
    use EmrRJTrait, LOVProductTrait;

    // Listener dari blade
    protected $listeners = ['emr:rj:store' => 'store'];

    //////////////////////////////
    // Refs & State
    //////////////////////////////
    public $rjNoRef;                 // set dari parent/route
    public string $rjStatusRef = 'A';

    public array $dataDaftarPoliRJ = []; // payload JSON besar


    ////////////////////////////////////////////////
    // Lifecycle
    ////////////////////////////////////////////////
    public function mount()
    {
        $this->findData($this->rjNoRef);
    }

    public function render()
    {
        // LOV
        $this->syncLOV();
        // FormEntry
        $this->syncDataFormEntry();

        return view('livewire.r-j.emr-r-j.eresep-r-j.eresep-r-j', [
            'myTitle'  => 'Data Pasien Rawat Jalan',
            'mySnipt'  => 'Rekam Medis Pasien',
            'myProgram' => 'Resep Non Racikan',
        ]);
    }

    ////////////////////////////////////////////////
    // CRUD Detail Eresep (aman dari race)
    ////////////////////////////////////////////////
    public $formEntryResepNonRacikan = [
        'productId'      => '',
        'productName'    => '',
        'qty'            => '',
        'signaX'         => '',
        'signaHari'      => '',
        'productPrice'   => '',
        'catatanKhusus'  => '',
    ];


    public function insertProduct(): void
    {
        if (!$this->checkRjStatus()) return;

        // Validasi draft
        $rules = [
            'formEntryResepNonRacikan.productId'    => 'bail|required',
            'formEntryResepNonRacikan.productName'  => 'bail|required',
            'formEntryResepNonRacikan.signaX'       => 'bail|required|numeric|min:1',
            'formEntryResepNonRacikan.signaHari'    => 'bail|required|numeric|min:1',
            'formEntryResepNonRacikan.qty'          => 'bail|required|integer|min:1|max:999',
            'formEntryResepNonRacikan.productPrice' => 'bail|required|numeric|min:0',
            'formEntryResepNonRacikan.catatanKhusus' => 'bail|nullable|string',
        ];
        $messages = [
            // productId
            'formEntryResepNonRacikan.productId.required' => ':attribute wajib diisi.',

            // productName
            'formEntryResepNonRacikan.productName.required' => ':attribute wajib diisi.',

            // signaX
            'formEntryResepNonRacikan.signaX.required' => ':attribute wajib diisi.',
            'formEntryResepNonRacikan.signaX.numeric'  => ':attribute harus berupa angka.',
            'formEntryResepNonRacikan.signaX.min'      => ':attribute minimal :min.',

            // signaHari
            'formEntryResepNonRacikan.signaHari.required' => ':attribute wajib diisi.',
            'formEntryResepNonRacikan.signaHari.numeric'  => ':attribute harus berupa angka.',
            'formEntryResepNonRacikan.signaHari.min'      => ':attribute minimal :min.',

            // qty
            'formEntryResepNonRacikan.qty.required' => ':attribute wajib diisi.',
            'formEntryResepNonRacikan.qty.integer'  => ':attribute harus bilangan bulat.',
            'formEntryResepNonRacikan.qty.min'      => ':attribute minimal :min.',
            'formEntryResepNonRacikan.qty.max'      => ':attribute maksimal :max.',

            // productPrice
            'formEntryResepNonRacikan.productPrice.required' => ':attribute wajib diisi.',
            'formEntryResepNonRacikan.productPrice.numeric'  => ':attribute harus berupa angka.',
            'formEntryResepNonRacikan.productPrice.min'      => ':attribute minimal :min.',

            // catatanKhusus
            'formEntryResepNonRacikan.catatanKhusus.string'  => ':attribute harus berupa teks.',
        ];

        $attributes = [
            'formEntryResepNonRacikan.productId'     => 'ID Obat',
            'formEntryResepNonRacikan.productName'   => 'Nama Obat',
            'formEntryResepNonRacikan.signaX'        => 'Signa (kali sehari)',
            'formEntryResepNonRacikan.signaHari'     => 'Lama hari pemakaian',
            'formEntryResepNonRacikan.qty'           => 'Jumlah obat',
            'formEntryResepNonRacikan.productPrice'  => 'Harga satuan',
            'formEntryResepNonRacikan.catatanKhusus' => 'Catatan khusus',
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
                    // 2) Insert detail pakai identity
                    $expDate = null;
                    try {
                        $expDate = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'])
                            ->addDays(30)->format('Y-m-d H:i:s');
                    } catch (\Throwable $e) {
                        $expDate = Carbon::now()->addDays(30)->format('Y-m-d H:i:s');
                    }


                    $lastInserted = DB::table('rstxn_rjobats')->select(DB::raw('nvl(max(rjobat_dtl)+1,1) as rjobat_dtl_max'))->first();

                    DB::table('rstxn_rjobats')->insert([
                        'rj_no'          => $rjNo,
                        'product_id'     => $this->formEntryResepNonRacikan['productId'],
                        'qty'            => $this->formEntryResepNonRacikan['qty'],
                        'price'          => $this->formEntryResepNonRacikan['productPrice'],
                        'rj_carapakai'   => $this->formEntryResepNonRacikan['signaX'],
                        'rj_kapsul'      => $this->formEntryResepNonRacikan['signaHari'],
                        'rj_takar'       => 'Tablet',
                        'catatan_khusus' => $this->formEntryResepNonRacikan['catatanKhusus'],
                        'rj_ket'         => $this->formEntryResepNonRacikan['catatanKhusus'],
                        'exp_date'       => $expDate,
                        'etiket_status'  => 1,
                        'rjobat_dtl' => $lastInserted->rjobat_dtl_max,
                    ]);

                    // 3) Patch state lokal (biar UI langsung update)
                    $this->dataDaftarPoliRJ['eresep'][] = [
                        'productId'      => $this->formEntryResepNonRacikan['productId'],
                        'productName'    => $this->formEntryResepNonRacikan['productName'],
                        'jenisKeterangan' => 'NonRacikan',
                        'signaX'         => $this->formEntryResepNonRacikan['signaX'],
                        'signaHari'      => $this->formEntryResepNonRacikan['signaHari'],
                        'qty'            => $this->formEntryResepNonRacikan['qty'],
                        'productPrice'   => $this->formEntryResepNonRacikan['productPrice'],
                        'catatanKhusus'  => $this->formEntryResepNonRacikan['catatanKhusus'],
                        'rjObatDtl'      => $lastInserted->rjobat_dtl_max,
                        'rjNo'           => $rjNo,
                    ];
                });
            });

            // commit JSON besar sekali jalan (mutex lagi, tapi ringan)
            $this->store();
            $this->reset(['formEntryResepNonRacikan', 'collectingMyProduct']);
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal menambahkan obat: ' . $e->getMessage());
        }
    }

    public function updateProduct($rjobat_dtl, $qty = null, $signaX = null, $signaHari = null, $catatanKhusus = null): void
    {
        if (!$this->checkRjStatus()) return;

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        // Validasi payload
        $messages = [
            'qty.required' => 'Jumlah obat wajib diisi.',
            'qty.integer'  => 'Jumlah obat harus berupa bilangan bulat.',
            'qty.min'      => 'Jumlah obat minimal :min.',
            'qty.max'      => 'Jumlah obat maksimal :max.',

            'signaX.required' => 'Signa (kali sehari) wajib diisi.',
            'signaX.numeric'  => 'Signa (kali sehari) harus berupa angka.',
            'signaX.min'      => 'Signa (kali sehari) minimal :min.',

            'signaHari.required' => 'Lama hari pemakaian wajib diisi.',
            'signaHari.numeric'  => 'Lama hari pemakaian harus berupa angka.',
            'signaHari.min'      => 'Lama hari pemakaian minimal :min.',

            'catatanKhusus.string' => 'Catatan khusus harus berupa teks.',
            'catatanKhusus.max'    => 'Catatan khusus maksimal :max karakter.',
        ];

        $payload = [
            'qty'           => $qty,
            'signaX'        => $signaX,
            'signaHari'     => $signaHari,
            'catatanKhusus' => $catatanKhusus,
        ];

        $rules = [
            'qty'           => 'bail|required|integer|min:1|max:999',
            'signaX'        => 'bail|required|numeric|min:1',
            'signaHari'     => 'bail|required|numeric|min:1',
            'catatanKhusus' => 'bail|nullable|string|max:200',
        ];

        $validator = Validator::make($payload, $rules, $messages);

        if ($validator->fails()) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError($validator->errors()->first());
            return;
        }

        $lockKey = "rj:{$rjNo}";

        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo, $rjobat_dtl, $payload) {
                DB::transaction(function () use ($rjNo, $rjobat_dtl, $payload) {

                    $affected = DB::table('rstxn_rjobats')
                        ->where('rjobat_dtl', $rjobat_dtl)
                        ->where('rj_no', $rjNo)
                        ->update([
                            'qty'            => $payload['qty'],
                            'rj_carapakai'   => $payload['signaX'],
                            'rj_kapsul'      => $payload['signaHari'],
                            'catatan_khusus' => $payload['catatanKhusus'],
                            'rj_ket'         => $payload['catatanKhusus'],
                        ]);

                    if (!$affected) {
                        throw new \RuntimeException('Data obat tidak ditemukan.');
                    }

                    // Update state lokal
                    if (!empty($this->dataDaftarPoliRJ['eresep'])) {
                        foreach ($this->dataDaftarPoliRJ['eresep'] as &$it) {
                            if (($it['rjObatDtl'] ?? null) == $rjobat_dtl) {
                                $it['qty']           = $payload['qty'];
                                $it['signaX']        = $payload['signaX'];
                                $it['signaHari']     = $payload['signaHari'];
                                $it['catatanKhusus'] = $payload['catatanKhusus'];
                                break;
                            }
                        }
                        unset($it);
                    }
                });
            });

            $this->store();
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Resep diperbarui.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal memperbarui obat: ' . $e->getMessage());
        }
    }

    public function removeProduct($rjObatDtl)
    {
        if (!$this->checkRjStatus()) return;

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";

        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo, $rjObatDtl) {
                DB::transaction(function () use ($rjNo, $rjObatDtl) {

                    $deleted = DB::table('rstxn_rjobats')
                        ->where('rjobat_dtl', $rjObatDtl)
                        ->where('rj_no', $rjNo)
                        ->delete();

                    if (!$deleted) {
                        throw new \RuntimeException('Data obat tidak ditemukan atau sudah dihapus.');
                    }

                    $this->dataDaftarPoliRJ['eresep'] = collect($this->dataDaftarPoliRJ['eresep'] ?? [])
                        ->reject(fn($i) => (string)($i['rjObatDtl'] ?? '') === (string)$rjObatDtl)
                        ->values()->all();
                });
            });

            $this->store();
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addSuccess('Obat dihapus.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                ->addError('Gagal menghapus obat: ' . $e->getMessage());
        }
    }

    ////////////////////////////////////////////////
    // Simpan JSON besar (PATCH hanya eresep)
    ////////////////////////////////////////////////
    public function store()
    {
        // RJ No
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
                    // Ambil fresh dari DB supaya subtree lain tidak ketimpa
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];
                    if (!is_array($fresh)) $fresh = [];

                    if (!isset($fresh['eresep']) || !is_array($fresh['eresep'])) {
                        $fresh['eresep'] = [];
                    }

                    // PATCH hanya subtree eresep dari state lokal
                    $fresh['eresep'] = array_values($this->dataDaftarPoliRJ['eresep'] ?? []);

                    $this->updateJsonRJ($rjNo, $fresh);

                    // Sinkron state komponen
                    $this->dataDaftarPoliRJ = $fresh;
                });
            });

            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addSuccess('Eresep berhasil disimpan.');
        } catch (LockTimeoutException $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
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

        if (!isset($this->dataDaftarPoliRJ['eresep'])) {
            $this->dataDaftarPoliRJ['eresep'] = [];
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
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Pasien Sudah Pulang, Transaksi Terkunci.');
            return false;
        }
        return true;
    }



    private function syncDataFormEntry(): void
    {
        // Synk Lov Product (PAKAI lowercase)
        $this->formEntryResepNonRacikan['productId']   = $this->product['productId']   ?? '';
        $this->formEntryResepNonRacikan['productName'] = $this->product['productName'] ?? '';
        // qty default
        if (empty($this->formEntryResepNonRacikan['qty'])) {
            $this->formEntryResepNonRacikan['qty'] = 1;
        }

        // price default: ambil dari tkmst_products berdasarkan productId (lowercase)
        if (empty($this->formEntryResepNonRacikan['productPrice']) && !empty($this->formEntryResepNonRacikan['productId'])) {
            $productPrice = DB::table('tkmst_products')
                ->where('product_id', $this->formEntryResepNonRacikan['productId'])
                ->value('sales_price');

            $this->formEntryResepNonRacikan['productPrice'] = $productPrice ?? 0;
        }
    }

    public array $product = [];
    private function syncLOV(): void
    {
        $this->product = $this->collectingMyProduct;
    }


    public function resetformEntryResepNonRacikan()
    {
        $this->reset(['formEntryResepNonRacikan', 'collectingMyProduct']);
    }
}
