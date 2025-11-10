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

class EresepRJRacikan extends Component
{
    use LOVProductTrait, EmrRJTrait;

    protected $listeners = ['emr:rj:store' => 'store'];

    public $rjNoRef = null;
    public string $rjStatusRef = 'A';
    public array $dataDaftarPoliRJ = [];
    public string $noRacikan = 'R1';

    public array $product = [];
    public array $formEntryRacikan = [
        'productId'      => '',
        'productName'    => '',
        'sedia'          => 1,
        'dosis'          => '',
        'qty'            => '',
        'signaX'         => 1,
        'signaHari'      => 1,
        'productPrice'   => 0,
        'catatan'        => '',
        'catatanKhusus'  => '',
        'noRacikan'      => 'R1',
    ];

    public function mount(): void
    {
        $this->findData($this->rjNoRef);
    }

    public function render()
    {
        $this->syncLOV();
        $this->syncDataFormEntryRacikan();

        return view('livewire.r-j.emr-r-j.eresep-r-j.eresep-r-j-racikan', [
            'myTitle'   => 'Data Pasien Rawat Jalan',
            'mySnipt'   => 'Rekam Medis Pasien',
            'myProgram' => 'E-Resep Racikan',
        ]);
    }

    private function syncLOV(): void
    {
        $this->product = $this->collectingMyProduct ?? [];
    }

    private function syncDataFormEntryRacikan(): void
    {
        $this->formEntryRacikan['productId']   = $this->product['productId']   ?? '';
        $this->formEntryRacikan['productName'] = $this->product['productName'] ?? '';
        $this->formEntryRacikan['sedia']       = $this->formEntryRacikan['sedia'] ?: 1;
        $this->formEntryRacikan['signaX']      = $this->formEntryRacikan['signaX'] ?: 1;
        $this->formEntryRacikan['signaHari']   = $this->formEntryRacikan['signaHari'] ?: 1;
        $this->formEntryRacikan['noRacikan']   = $this->noRacikan;

        if (empty($this->formEntryRacikan['productPrice']) && !empty($this->formEntryRacikan['productId'])) {
            $price = DB::table('tkmst_products')
                ->where('product_id', $this->formEntryRacikan['productId'])
                ->value('sales_price');
            $this->formEntryRacikan['productPrice'] = $price ?? 0;
        }
    }

    public function insertProduct(): void
    {
        if (!$this->checkRjStatus()) return;

        $rules = [
            'formEntryRacikan.productId'     => 'bail|required',
            'formEntryRacikan.productName'   => 'bail|required',
            'formEntryRacikan.dosis'         => 'bail|required|max:150',
            'formEntryRacikan.qty'           => 'bail|nullable|digits_between:1,3',
            'formEntryRacikan.signaX'        => 'nullable',
            'formEntryRacikan.signaHari'     => 'nullable',
            'formEntryRacikan.productPrice'  => 'bail|numeric|min:0',
            'formEntryRacikan.catatan'       => 'bail|nullable|max:150',
            'formEntryRacikan.catatanKhusus' => 'bail|nullable|max:150',
        ];

        $messages = [
            'formEntryRacikan.productId.required'   => 'ID Obat wajib diisi.',
            'formEntryRacikan.productName.required' => 'Nama obat wajib diisi.',
            'formEntryRacikan.dosis.required'       => 'Dosis wajib diisi.',
        ];

        $attributes = [
            'formEntryRacikan.productId'     => 'ID Obat',
            'formEntryRacikan.productName'   => 'Nama Obat',
            'formEntryRacikan.dosis'         => 'Dosis',
            'formEntryRacikan.qty'           => 'Jumlah (Qty)',
            'formEntryRacikan.signaX'        => 'Signa X',
            'formEntryRacikan.signaHari'     => 'Signa Hari',
            'formEntryRacikan.productPrice'  => 'Harga Obat',
            'formEntryRacikan.catatan'       => 'Catatan',
            'formEntryRacikan.catatanKhusus' => 'Catatan Khusus',
        ];

        $this->validate($rules, $messages, $attributes);

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {
                    try {
                        $expDate = Carbon::createFromFormat('d/m/Y H:i:s', $this->dataDaftarPoliRJ['rjDate'] ?? '')
                            ->addDays(30)->format('Y-m-d H:i:s');
                    } catch (\Throwable $e) {
                        $expDate = Carbon::now()->addDays(30)->format('Y-m-d H:i:s');
                    }

                    $nextDtl = (int) DB::table('rstxn_rjobatracikans')
                        ->where('rj_no', $rjNo)->max('rjobat_dtl');
                    $nextDtl = $nextDtl ? $nextDtl + 1 : 1;

                    DB::table('rstxn_rjobatracikans')->insert([
                        'rjobat_dtl'     => $nextDtl,
                        'rj_no'          => $rjNo,
                        'product_name'   => $this->formEntryRacikan['productName'],
                        'sedia'          => $this->formEntryRacikan['sedia'],
                        'dosis'          => $this->formEntryRacikan['dosis'],
                        'qty'            => $this->formEntryRacikan['qty'] ?: null,
                        'catatan'        => $this->formEntryRacikan['catatan'] ?: null,
                        'catatan_khusus' => $this->formEntryRacikan['catatanKhusus'] ?: null,
                        'no_racikan'     => $this->formEntryRacikan['noRacikan'],
                        'rj_takar'       => 'Tablet',
                        'exp_date'       => $expDate,
                        'etiket_status'  => 1,
                    ]);

                    $this->dataDaftarPoliRJ['eresepRacikan'][] = [
                        'jenisKeterangan' => 'Racikan',
                        'productName'     => $this->formEntryRacikan['productName'],
                        'sedia'           => $this->formEntryRacikan['sedia'],
                        'dosis'           => $this->formEntryRacikan['dosis'],
                        'qty'             => $this->formEntryRacikan['qty'] ?? '',
                        'catatan'         => $this->formEntryRacikan['catatan'] ?? '',
                        'catatanKhusus'   => $this->formEntryRacikan['catatanKhusus'] ?? '',
                        'noRacikan'       => $this->formEntryRacikan['noRacikan'],
                        'signaX'          => $this->formEntryRacikan['signaX'],
                        'signaHari'       => $this->formEntryRacikan['signaHari'],
                        'productPrice'    => $this->formEntryRacikan['productPrice'],
                        'rjObatDtl'       => $nextDtl,
                        'rjNo'            => $rjNo,
                    ];
                });
            });

            $this->store();
            $this->reset(['formEntryRacikan', 'collectingMyProduct']);
            toastr()->closeOnHover(true)->closeDuration(3)->addSuccess('Racikan ditambahkan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Gagal menambahkan racikan: ' . $e->getMessage());
        }
    }

    public function updateProduct($rjobat_dtl, $dosis = null, $qty = null, $catatan = null, $catatanKhusus = null): void
    {
        if (!$this->checkRjStatus()) return;
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Nomor RJ kosong.');
            return;
        }

        $payload = compact('qty', 'dosis', 'catatan', 'catatanKhusus');
        $v = Validator::make($payload, [
            'qty' => 'bail|nullable|digits_between:1,3',
            'dosis' => 'bail|required|max:150',
            'catatan' => 'bail|nullable|max:150',
            'catatanKhusus' => 'bail|nullable|max:150',
        ], ['dosis.required' => 'Dosis wajib diisi.']);

        if ($v->fails()) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError($v->errors()->first());
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo, $rjobat_dtl, $payload) {
                DB::transaction(function () use ($rjNo, $rjobat_dtl, $payload) {
                    $affected = DB::table('rstxn_rjobatracikans')
                        ->where('rj_no', $rjNo)
                        ->where('rjobat_dtl', $rjobat_dtl)
                        ->update([
                            'qty' => $payload['qty'],
                            'dosis' => $payload['dosis'],
                            'catatan' => $payload['catatan'],
                            'catatan_khusus' => $payload['catatanKhusus'],
                        ]);

                    if (!$affected) throw new \RuntimeException('Data racikan tidak ditemukan.');

                    foreach ($this->dataDaftarPoliRJ['eresepRacikan'] ?? [] as &$it) {
                        if (($it['rjObatDtl'] ?? null) == $rjobat_dtl) {
                            $it = array_merge($it, $payload);
                            break;
                        }
                    }
                    unset($it);
                });
            });

            $this->store();
            toastr()->closeOnHover(true)->closeDuration(3)->addSuccess('Racikan diperbarui.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Gagal memperbarui racikan: ' . $e->getMessage());
        }
    }

    public function removeProduct($rjObatDtl): void
    {
        if (!$this->checkRjStatus()) return;

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo, $rjObatDtl) {
                DB::transaction(function () use ($rjNo, $rjObatDtl) {
                    $deleted = DB::table('rstxn_rjobatracikans')
                        ->where('rj_no', $rjNo)
                        ->where('rjobat_dtl', $rjObatDtl)
                        ->delete();

                    if (!$deleted) throw new \RuntimeException('Data racikan tidak ditemukan atau sudah dihapus.');

                    $this->dataDaftarPoliRJ['eresepRacikan'] = collect($this->dataDaftarPoliRJ['eresepRacikan'] ?? [])
                        ->reject(fn($i) => (string)($i['rjObatDtl'] ?? '') === (string)$rjObatDtl)
                        ->values()->all();
                });
            });

            $this->store();
            toastr()->closeOnHover(true)->closeDuration(3)->addSuccess('Racikan dihapus.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Gagal menghapus racikan: ' . $e->getMessage());
        }
    }

    public function store(): void
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {
                    $wrap = $this->findDataRJ($rjNo);
                    $fresh = $wrap['dataDaftarRJ'] ?? [];
                    if (!is_array($fresh)) $fresh = [];
                    if (!isset($fresh['eresepRacikan']) || !is_array($fresh['eresepRacikan'])) {
                        $fresh['eresepRacikan'] = [];
                    }

                    $fresh['eresepRacikan'] = array_values($this->dataDaftarPoliRJ['eresepRacikan'] ?? []);
                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarPoliRJ = $fresh;
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->addSuccess('Eresep Racikan berhasil disimpan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (\Throwable $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Gagal menyimpan: ' . $e->getMessage());
        }
    }

    private function findData($rjNo): void
    {
        $findDataRJ = $this->findDataRJ($rjNo);
        $this->dataDaftarPoliRJ = $findDataRJ['dataDaftarRJ'] ?? [];
        if (!isset($this->dataDaftarPoliRJ['eresepRacikan'])) {
            $this->dataDaftarPoliRJ['eresepRacikan'] = [];
        }
    }

    public function checkRjStatus(): bool
    {
        $status = DB::table('rstxn_rjhdrs')->where('rj_no', $this->rjNoRef)->value('rj_status');
        if ($status !== 'A') {
            toastr()->closeOnHover(true)->closeDuration(3)->addError('Pasien Sudah Pulang, Transaksi Terkunci.');
            return false;
        }
        return true;
    }

    public function resetformEntryRacikan()
    {
        $this->reset(['formEntryRacikan', 'collectingMyProduct']);
    }
}
