<?php

namespace App\Http\Livewire\RJ\EmrRJ\AdministrasiRJ;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Exception;

use App\Http\Traits\EmrRJ\EmrRJTrait;

class LainLainRJ extends Component
{
    use WithPagination, EmrRJTrait;

    //////////////////////////////
    // Refs & State
    //////////////////////////////
    public $rjNoRef;
    public array $dataDaftarPoliRJ = [];

    // LOV state
    public $dataLainLainLov = [];
    public $dataLainLainLovStatus = 0;
    public $dataLainLainLovSearch = '';
    public $selecteddataLainLainLovIndex = 0;

    public $formEntryLainLain = [];

    ////////////////////////////////////////////////
    // Lifecycle
    ////////////////////////////////////////////////
    public function mount()
    {
        $this->findData($this->rjNoRef);
    }

    public function render()
    {
        return view('livewire.r-j.emr-r-j.administrasi-r-j.lain-lain-r-j', [
            'myTitle'  => 'Data Pasien Rawat Jalan',
            'mySnipt'  => 'Rekam Medis Pasien',
            'myProgram' => 'Lain Lain',
        ]);
    }

    /////////////////////////////////////////////////
    // LOV handlers (tetap seperti versi kamu)
    /////////////////////////////////////////////////
    public function clickdataLainLainLov()
    {
        $this->dataLainLainLovStatus = true;
        $this->dataLainLainLov = [];
    }

    public function updateddataLainLainLovsearch()
    {
        $this->reset(['selecteddataLainLainLovIndex', 'dataLainLainLov']);
        $search = $this->dataLainLainLovSearch;

        $row = DB::table('rsmst_others')
            ->select('other_id', 'other_desc', 'other_price')
            ->where('other_id', $search)
            ->where('active_status', '1')
            ->first();

        if ($row) {
            $this->addLainLain($row->other_id, $row->other_desc, $row->other_price);
            $this->resetdataLainLainLov();
        } else {
            if (strlen($search) < 1) {
                $this->dataLainLainLov = [];
            } else {
                $this->dataLainLainLov = json_decode(
                    DB::table('rsmst_others')
                        ->select('other_id', 'other_desc', 'other_price')
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
        }
    }

    public function setMydataLainLainLov($id)
    {
        if (!$this->checkRjStatus($this->rjNoRef)) return;

        $row = DB::table('rsmst_others')
            ->select('other_id', 'other_desc', 'other_price')
            ->where('active_status', '1')
            ->where('other_id', $this->dataLainLainLov[$id]['other_id'] ?? null)
            ->first();

        if ($row) {
            $this->addLainLain($row->other_id, $row->other_desc, $row->other_price);
            $this->resetdataLainLainLov();
        } else {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Data tidak ditemukan.');
        }
    }

    public function resetdataLainLainLov()
    {
        $this->reset(['dataLainLainLov', 'dataLainLainLovStatus', 'dataLainLainLovSearch', 'selecteddataLainLainLovIndex']);
    }

    public function selectNextdataLainLainLov()
    {
        if ($this->selecteddataLainLainLovIndex === "") $this->selecteddataLainLainLovIndex = 0;
        else $this->selecteddataLainLainLovIndex++;
        if ($this->selecteddataLainLainLovIndex === count($this->dataLainLainLov)) $this->selecteddataLainLainLovIndex = 0;
    }

    public function selectPreviousdataLainLainLov()
    {
        if ($this->selecteddataLainLainLovIndex === "") $this->selecteddataLainLainLovIndex = count($this->dataLainLainLov) - 1;
        else $this->selecteddataLainLainLovIndex--;
        if ($this->selecteddataLainLainLovIndex === -1) $this->selecteddataLainLainLovIndex = count($this->dataLainLainLov) - 1;
    }

    public function enterMydataLainLainLov($id)
    {
        if (!$this->checkRjStatus($this->rjNoRef)) return;

        if (isset($this->dataLainLainLov[$id]['other_id'])) {
            $this->addLainLain($this->dataLainLainLov[$id]['other_id'], $this->dataLainLainLov[$id]['other_desc'], $this->dataLainLainLov[$id]['other_price']);
            $this->resetdataLainLainLov();
        } else {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Lain-Lain belum tersedia.');
        }
    }

    /////////////////////////////////////////////////
    // Helpers
    /////////////////////////////////////////////////
    private function addLainLain($LainLainId, $LainLainDesc, $salesPrice): void
    {
        $this->formEntryLainLain = [
            'LainLainId'    => $LainLainId,
            'LainLainDesc'  => $LainLainDesc,
            'LainLainPrice' => $salesPrice,
        ];
    }

    /////////////////////////////////////////////////
    // INSERT (race-safe)
    /////////////////////////////////////////////////
    public function insertLainLain(): void
    {
        if (!$this->checkRjStatus($this->rjNoRef)) return;


        $messages = [
            'required' => ':attribute wajib diisi.',
            'exists'   => ':attribute tidak ditemukan di master data.',
            'numeric'  => ':attribute harus berupa angka.',
            'min'      => ':attribute tidak boleh kurang dari :min.',
            'max'      => ':attribute tidak boleh lebih dari :max.',
        ];

        $attributes = [
            'formEntryLainLain.LainLainId'    => 'Kode Lain-Lain',
            'formEntryLainLain.LainLainDesc'  => 'Nama Lain-Lain',
            'formEntryLainLain.LainLainPrice' => 'Harga Lain-Lain',
        ];
        $rules = [
            'formEntryLainLain.LainLainId'    => 'bail|required|exists:rsmst_others,other_id',
            'formEntryLainLain.LainLainDesc'  => 'bail|required',
            'formEntryLainLain.LainLainPrice' => 'bail|required|numeric',
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
                    // Lock header supaya status tak berubah


                    // INSERT tanpa MAX+1 → gunakan identity/sequence
                    $lastInserted = DB::table('rstxn_rjothers')
                        ->select(DB::raw("nvl(max(rjo_dtl)+1,1) as rjo_dtl_max"))
                        ->first();
                    $rjoDtl = DB::table('rstxn_rjothers')->insert([
                        'rj_no'       => $rjNo,
                        'other_id'    => $this->formEntryLainLain['LainLainId'],
                        'other_price' => $this->formEntryLainLain['LainLainPrice'],
                        'rjo_dtl' => $lastInserted->rjo_dtl_max
                    ]);

                    // Patch state lokal untuk UI
                    $this->dataDaftarPoliRJ['LainLain'][] = [
                        'LainLainId'    => $this->formEntryLainLain['LainLainId'],
                        'LainLainDesc'  => $this->formEntryLainLain['LainLainDesc'],
                        'LainLainPrice' => $this->formEntryLainLain['LainLainPrice'],
                        'rjotherDtl'    => $rjoDtl,
                        'rjNo'          => $rjNo,
                        'userLog'       => auth()->user()->myuser_name ?? 'system',
                        'userLogDate'   => Carbon::now(env('APP_TIMEZONE'))->format('d/m/Y H:i:s'),
                    ];
                });
            });

            $this->store();
            $this->emit('rj:refresh-summary');
            $this->reset(['formEntryLainLain']);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addSuccess('Lain-Lain ditambahkan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            report($e);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Gagal menambah Lain-Lain: ' . $e->getMessage());
        }
    }

    /////////////////////////////////////////////////
    // DELETE (race-safe)
    /////////////////////////////////////////////////
    public function removeLainLain($rjotherDtl)
    {
        if (!$this->checkRjStatus($this->rjNoRef)) return;

        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";

        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo, $rjotherDtl) {
                DB::transaction(function () use ($rjNo, $rjotherDtl) {


                    DB::table('rstxn_rjothers')->where('rjo_dtl', $rjotherDtl)->delete();

                    $this->dataDaftarPoliRJ['LainLain'] = collect($this->dataDaftarPoliRJ['LainLain'] ?? [])
                        ->reject(fn($i) => (string)($i['rjotherDtl'] ?? '') === (string)$rjotherDtl)
                        ->values()->all();
                });
            });

            $this->store();
            $this->emit('rj:refresh-summary');
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addSuccess('Lain-Lain dihapus.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            report($e);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Gagal menghapus Lain-Lain: ' . $e->getMessage());
        }
    }

    /////////////////////////////////////////////////
    // Persist JSON besar (PATCH hanya LainLain)
    /////////////////////////////////////////////////
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

                    if (!isset($fresh['LainLain']) || !is_array($fresh['LainLain'])) {
                        $fresh['LainLain'] = [];
                    }

                    $fresh['LainLain'] = array_values($this->dataDaftarPoliRJ['LainLain'] ?? []);

                    $this->updateJsonRJ($rjNo, $fresh);
                    $this->dataDaftarPoliRJ = $fresh;
                });
            });

            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addSuccess('Lain-Lain berhasil disimpan.');
        } catch (LockTimeoutException $e) {
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Sistem sibuk, gagal memperoleh lock. Coba lagi.');
        } catch (Exception $e) {
            report($e);
            toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')->addError('Gagal menyimpan: ' . $e->getMessage());
        }
    }

    /////////////////////////////////////////////////
    // Load awal
    /////////////////////////////////////////////////
    private function findData($rjNo): void
    {
        $findDataRJ = $this->findDataRJ($rjNo);
        $this->dataDaftarPoliRJ = $findDataRJ['dataDaftarRJ'] ?? [];
        if (!isset($this->dataDaftarPoliRJ['LainLain'])) {
            $this->dataDaftarPoliRJ['LainLain'] = [];
        }
    }



    public function resetformEntryLainLain()
    {
        $this->reset(['formEntryLainLain']);
    }
}
