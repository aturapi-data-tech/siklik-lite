<?php

namespace App\Http\Livewire\RJ\EmrRJ\MrRJ\Suket;

use Illuminate\Support\Facades\DB;

use Livewire\Component;

use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\LockTimeoutException;
use App\Http\Traits\EmrRJ\EmrRJTrait;


class Suket extends Component
{
    use EmrRJTrait;

    // listener from blade////////////////
    protected $listeners = ['emr:rj:store' => 'store'];



    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef;

    // dataDaftarPoliRJ RJ
    public array $dataDaftarPoliRJ = [];

    // data SKDP / suket=>[]
    public array $suket =
    [
        "suketSehatTab" => "Suket Sehat",
        "suketSehat" => [
            "suketSehat" => ""
        ],
        "suketIstirahatTab" => "Suket Istirahat",
        "suketIstirahat" => [
            "suketIstirahatHari" => "",
            "suketIstirahat" => ""
        ],

    ];
    //////////////////////////////////////////////////////////////////////


    protected $rules = [
        // angka hari istirahat, boleh kosong tapi kalau diisi harus number wajar
        'dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahatHari' => 'nullable|numeric|min:1|max:60',

        // tambahkan bila mau:
        'dataDaftarPoliRJ.suket.suketSehat.suketSehat'             => 'nullable|string|max:2000',
        'dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahat'     => 'nullable|string|max:2000',
    ];

    protected $messages = [
        'dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahatHari.numeric' => ':attribute harus berupa angka.',
        'dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahatHari.min'     => ':attribute minimal :min hari.',
        'dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahatHari.max'     => ':attribute maksimal :max hari.',
        'dataDaftarPoliRJ.suket.suketSehat.suketSehat.max'                  => ':attribute maksimal :max karakter.',
        'dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahat.max'          => ':attribute maksimal :max karakter.',
    ];

    protected $validationAttributes = [
        'dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahatHari' => 'Lama istirahat',
        'dataDaftarPoliRJ.suket.suketSehat.suketSehat'             => 'Isi Surat Keterangan Sehat',
        'dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahat'     => 'Isi Surat Istirahat',
    ];




    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////
    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'dataDaftarPoliRJ.suket.')) {
            $this->validateOnly($propertyName);
        }
    }




    // resert input private////////////////
    private function resetInputFields(): void
    {

        // resert validation
        $this->resetValidation();
        // resert input kecuali
        $this->resetExcept([
            'rjNoRef'
        ]);
    }





    // ////////////////
    // RJ Logic
    // ////////////////


    // insert and update record start////////////////
    public function store(): void
    {
        $rjNo = $this->dataDaftarPoliRJ['rjNo'] ?? $this->rjNoRef ?? null;
        if (!$rjNo) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Nomor RJ kosong.');
            return;
        }

        // Validasi form (opsional: cukup subtree yang berubah)
        try {
            $this->validate(
                $this->rules,
                $this->messages,
                $this->validationAttributes
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Lakukan pengecekan kembali input data.');
            throw $e;
        }

        $lockKey = "rj:{$rjNo}";
        try {
            Cache::lock($lockKey, 5)->block(3, function () use ($rjNo) {
                // 1) Baca fresh dari DB (pakai helper di trait)
                $wrap  = $this->findDataRJ($rjNo);            // EmrRJTrait
                $fresh = $wrap['dataDaftarRJ'] ?? [];
                if (!is_array($fresh)) $fresh = [];

                // 2) Bootstrap subtree jika belum ada
                if (!isset($fresh['suket']) || !is_array($fresh['suket'])) {
                    $fresh['suket'] = $this->suket;
                }

                // 3) PATCH hanya subtree suket dari state komponen
                $fresh['suket'] = $this->dataDaftarPoliRJ['suket'] ?? $this->suket;

                // 4) Commit via single-writer
                DB::transaction(function () use ($rjNo, $fresh) {
                    $this->updateJsonRJ($rjNo, $fresh);       // EmrRJTrait: update rstxn_rjhdrs.dataDaftarPoliRJ_json
                });

                // 5) Sync state komponen
                $this->dataDaftarPoliRJ = $fresh;
            });


            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addSuccess('Suket berhasil disimpan.');
        } catch (LockTimeoutException $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Sistem sibuk. Gagal memperoleh kunci data (lock). Silakan coba lagi.');
        }
    }


    // insert and update record end////////////////


    private function findData($rjNo): void
    {
        $wrap = $this->findDataRJ($rjNo); // dari EmrRJTrait
        $this->dataDaftarPoliRJ = $wrap['dataDaftarRJ'] ?? [];

        if (!isset($this->dataDaftarPoliRJ['suket']) || !is_array($this->dataDaftarPoliRJ['suket'])) {
            $this->dataDaftarPoliRJ['suket'] = $this->suket;
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
            'livewire.r-j.emr-r-j.mr-r-j.suket.suket',
            [
                'myTitle' => 'suket',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
            ]
        );
    }
}
