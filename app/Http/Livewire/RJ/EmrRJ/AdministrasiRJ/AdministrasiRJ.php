<?php

namespace App\Http\Livewire\RJ\EmrRJ\AdministrasiRJ;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use Illuminate\Contracts\Cache\LockTimeoutException;
use App\Http\Traits\EmrRJ\EmrRJTrait;


class AdministrasiRJ extends Component
{
    use WithPagination, EmrRJTrait;

    protected $listeners = [
        'rj:refresh-summary' => 'sumAll',
    ];

    // dataDaftarPoliRJ RJ
    public $rjNoRef;

    public int $sumRsAdmin;
    public int $sumRjAdmin;
    public int $sumPoliPrice;

    public int $sumJasaKaryawan;
    public int $sumJasaDokter;
    public int $sumJasaMedis;

    public int $sumObat;
    public int $sumLaboratorium;
    public int $sumRadiologi;

    public int $sumLainLain;

    public int $sumTotalRJ;


    public string $activeTabAdministrasi = "JasaKaryawan";
    public array $EmrMenuAdministrasi = [
        [
            'ermMenuId' => 'JasaKaryawan',
            'ermMenuName' => 'Jasa Karyawan'
        ],
        [
            'ermMenuId' => 'JasaDokter',
            'ermMenuName' => 'Jasa Dokter'
        ],
        [
            'ermMenuId' => 'JasaMedis',
            'ermMenuName' => 'Jasa Medis'
        ],
        [
            'ermMenuId' => 'Obat',
            'ermMenuName' => 'Obat'
        ],
        [
            'ermMenuId' => 'Laboratorium',
            'ermMenuName' => 'Laboratorium'
        ],
        [
            'ermMenuId' => 'Radiologi',
            'ermMenuName' => 'Radiologi'
        ],
        [
            'ermMenuId' => 'LainLain',
            'ermMenuName' => 'Lain-Lain'
        ],

    ];


    public function sumAll()
    {
        $this->sumAdmin();
    }

    private function sumAdmin()
    {
        $sumAdmin = $this->findData($this->rjNoRef);

        $this->sumRsAdmin = $sumAdmin['rsAdmin'] ? $sumAdmin['rsAdmin'] : 0;
        $this->sumRjAdmin = $sumAdmin['rjAdmin'] ? $sumAdmin['rjAdmin'] : 0;
        $this->sumPoliPrice = $sumAdmin['poliPrice'] ? $sumAdmin['poliPrice'] : 0;

        $this->sumJasaKaryawan = isset($sumAdmin['JasaKaryawan']) ? collect($sumAdmin['JasaKaryawan'])->sum('JasaKaryawanPrice') : 0;
        $this->sumJasaMedis = isset($sumAdmin['JasaMedis']) ? collect($sumAdmin['JasaMedis'])->sum('JasaMedisPrice') : 0;
        $this->sumJasaDokter = isset($sumAdmin['JasaDokter']) ? collect($sumAdmin['JasaDokter'])->sum('JasaDokterPrice') : 0;


        $this->sumObat = collect($sumAdmin['rjObat'])->sum((function ($obat) {
            return $obat['qty'] * $obat['price'];
        }));

        $this->sumLaboratorium = collect($sumAdmin['rjLab'])->sum((function ($obat) {
            return $obat['lab_price'];
        }));

        $this->sumRadiologi = collect($sumAdmin['rjRad'])->sum((function ($obat) {
            return $obat['rad_price'];
        }));


        $this->sumLainLain = isset($sumAdmin['LainLain']) ? collect($sumAdmin['LainLain'])->sum('LainLainPrice') : 0;


        $this->sumTotalRJ = $this->sumPoliPrice + $this->sumRjAdmin + $this->sumRsAdmin  + $this->sumJasaKaryawan + $this->sumJasaDokter + $this->sumJasaMedis + $this->sumLainLain + $this->sumObat + $this->sumLaboratorium + $this->sumRadiologi;
    }


    public function setSelesaiAdministrasiStatus(string $rjNo): void
    {
        if (empty($rjNo)) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                DB::transaction(function () use ($rjNo) {

                    // 1) Ambil data FRESH dari DB
                    $freshWrap = $this->findDataRJ($rjNo);
                    $fresh = $freshWrap['dataDaftarRJ'] ?? [];

                    // 2) Jika belum ada AdministrasiRj, set lalu simpan
                    if (!isset($fresh['AdministrasiRj']) || !is_array($fresh['AdministrasiRj'])) {

                        $now = Carbon::now(config('app.timezone', env('APP_TIMEZONE', 'Asia/Jakarta')));
                        $fresh['AdministrasiRj'] = [
                            'userLog'     => optional(auth()->user())->myuser_name ?? (string) auth()->id(),
                            'userLogDate' => $now->format('d/m/Y H:i:s'),
                        ];

                        // 3) Simpan JSON via helper agar subtree lain tidak ketimpa
                        $this->updateJsonRJ($rjNo, $fresh);

                        // 5) Notifikasi & refresh ringkasan
                        toastr()
                            ->closeOnHover(true)
                            ->closeDuration(3)
                            ->positionClass('toast-top-left')
                            ->addSuccess('Administrasi berhasil disimpan.');

                        $this->emit('rj:refresh-summary');
                    } else {
                        $user = $fresh['AdministrasiRj']['userLog']     ?? '-';
                        $date = $fresh['AdministrasiRj']['userLogDate'] ?? '-';

                        toastr()
                            ->closeOnHover(true)
                            ->closeDuration(3)
                            ->positionClass('toast-top-left')
                            ->addWarning("Administrasi sudah tersimpan oleh {$user} pada {$date}.");
                    }
                });
            });
        } catch (LockTimeoutException $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Sistem sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');
        } catch (\Throwable $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Gagal menyimpan Administrasi: ' . $e->getMessage());
        }
    }

    private function findData($rjNo): array
    {
        $dataRawatJalan = [];

        $findDataRJ = $this->findDataRJ($rjNo);
        $dataRawatJalan  = $findDataRJ['dataDaftarRJ'];



        $rsAdmin = DB::table('rstxn_rjhdrs')
            ->select('rs_admin', 'rj_admin', 'poli_price', 'klaim_id', 'pass_status')
            ->where('rj_no', $rjNo)
            ->first();

        $rsObat = DB::table('rstxn_rjobats')
            ->join('tkmst_products', 'tkmst_products.product_id', 'rstxn_rjobats.product_id')
            ->select('rstxn_rjobats.product_id as product_id', 'product_name', 'qty', 'price', 'rjobat_dtl')
            ->where('rj_no', $rjNo)
            ->get();

        $rsLab = DB::table('rstxn_rjlabs')
            ->select('lab_desc', 'lab_price', 'lab_dtl')
            ->where('rj_no', $rjNo)
            ->get();

        $rsRad = DB::table('rstxn_rjrads')
            ->join('rsmst_radiologis', 'rsmst_radiologis.rad_id', 'rstxn_rjrads.rad_id')
            ->select('rad_desc', 'rstxn_rjrads.rad_price as rad_price', 'rad_dtl')
            ->where('rj_no', $rjNo)
            ->get();



        // RJ Admin
        if ($rsAdmin->pass_status == 'N') {
            $rsAdminParameter = DB::table('rsmst_parameters')
                ->select('par_value')
                ->where('par_id', '1')
                ->first();
            if (isset($dataRawatJalan['rjAdmin'])) {
                $dataRawatJalan['rjAdmin'] = $rsAdmin->rj_admin;
            } else {
                $dataRawatJalan['rjAdmin'] = $rsAdminParameter->par_value;
                // update table trnsaksi
                DB::table('rstxn_rjhdrs')
                    ->where('rj_no', $rjNo)
                    ->update([
                        'rj_admin' => $dataRawatJalan['rjAdmin'],
                    ]);
            }
        } else {
            $dataRawatJalan['rjAdmin'] = 0;
        }

        // RS Admin
        $rsAdminDokter = DB::table('rsmst_doctors')
            ->select('rs_admin', 'poli_price')
            ->where('dr_id', $dataRawatJalan['drId'])
            ->first();


        if (isset($dataRawatJalan['rsAdmin'])) {
            $dataRawatJalan['rsAdmin'] = $rsAdmin->rs_admin ? $rsAdmin->rs_admin : 0;
        } else {
            $dataRawatJalan['rsAdmin'] = $rsAdminDokter->rs_admin ? $rsAdminDokter->rs_admin : 0;
            // update table trnsaksi
            DB::table('rstxn_rjhdrs')
                ->where('rj_no', $rjNo)
                ->update([
                    'rs_admin' => $dataRawatJalan['rsAdmin'],
                ]);
        }

        // PoliPrice
        if (isset($dataRawatJalan['poliPrice'])) {
            $dataRawatJalan['poliPrice'] = $rsAdmin->poli_price ? $rsAdmin->poli_price : 0;
        } else {
            $dataRawatJalan['poliPrice'] = $rsAdminDokter->poli_price ? $rsAdminDokter->poli_price : 0;
            // update table trnsaksi
            DB::table('rstxn_rjhdrs')
                ->where('rj_no', $rjNo)
                ->update([
                    'poli_price' => $dataRawatJalan['poliPrice'],
                ]);
        }

        // Ketika Kronis
        if ($rsAdmin->klaim_id == 'KR') {
            $dataRawatJalan['rjAdmin'] = 0;
            $dataRawatJalan['rsAdmin'] = 0;
            $dataRawatJalan['poliPrice'] = 0;
            // update table trnsaksi
            DB::table('rstxn_rjhdrs')
                ->where('rj_no', $rjNo)
                ->update([
                    'rj_admin' => $dataRawatJalan['rjAdmin'],
                    'rs_admin' => $dataRawatJalan['rsAdmin'],
                    'poli_price' => $dataRawatJalan['poliPrice'],
                ]);
        }

        $dataRawatJalan['rjObat'] = json_decode(json_encode($rsObat, true), true);
        $dataRawatJalan['rjLab'] = json_decode(json_encode($rsLab, true), true);
        $dataRawatJalan['rjRad'] = json_decode(json_encode($rsRad, true), true);

        return ($dataRawatJalan);
    }

    // when new form instance
    public function mount()
    {
        $this->sumAll();
    }



    // select data start////////////////
    public function render()
    {

        return view(
            'livewire.r-j.emr-r-j.administrasi-r-j.administrasi-r-j',
            [
                // 'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Administrasi RJ',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
            ]
        );
    }
    // select data end////////////////


}
