<?php

namespace App\Http\Livewire\Component\Cetak;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

use App\Http\Traits\MasterPasien\MasterPasienTrait;

class CetakEtiket extends Component
{
    use MasterPasienTrait;

    /** RegNo target etiket */
    public string $regNo = '001216A';

    /** Payload siap kirim ke view */
    public array $dataPasien = [
        'pasien' => []
    ];

    /** ----------------------------
     *  Loader: ambil data pasien via trait
     *  ---------------------------- */
    private function loadPasien(string $regNo): void
    {
        // Ambil dari trait (seharusnya format sudah konsisten dengan schema app kamu)
        $mp = $this->findDataMasterPasien($regNo);

        if (!is_array($mp) || !isset($mp['pasien'])) {
            // fallback minimal agar view tidak error
            $this->dataPasien = ['pasien' => [
                'regNo' => $regNo,
                'regName' => '-',
                'tglLahir' => '',
                'thn' => '-',
            ]];
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Data pasien tidak ditemukan.');
            return;
        }

        // Hitung umur human readable bila tgl lahir valid (format d/m/Y)
        try {
            if (!empty($mp['pasien']['tglLahir'])) {
                $mp['pasien']['thn'] = Carbon::createFromFormat('d/m/Y', $mp['pasien']['tglLahir'])
                    ->diff(Carbon::now(config('app.timezone')))
                    ->format('%y Thn, %m Bln %d Hr');
            } else {
                $mp['pasien']['thn'] = '-';
            }
        } catch (\Throwable $e) {
            $mp['pasien']['thn'] = '-';
        }

        // Pastikan beberapa key yang biasa dipakai view ada (biar nggak undefined index)
        $mp['pasien'] = array_merge([
            'regNo'   => $regNo,
            'regName' => $mp['pasien']['regName'] ?? '-',
            'jenisKelamin' => $mp['pasien']['jenisKelamin'] ?? [
                'jenisKelaminId' => null,
                'jenisKelaminDesc' => '-',
            ],
            'identitas' => $mp['pasien']['identitas'] ?? [
                'idbpjs' => '',
                'nik'    => '',
                'alamat' => '',
            ],
        ], $mp['pasien']);

        $this->dataPasien = $mp;
    }

    /** ----------------------------
     *  Cetak PDF
     *  ---------------------------- */
    public function cetak()
    {
        // Pastikan data pasien paling baru
        $this->loadPasien($this->regNo);

        $data = [
            'data' => $this->dataPasien['pasien'],
        ];

        $pdfContent = Pdf::loadView('livewire.component.cetak.cetak-etiket-print', $data)->output();

        return response()->streamDownload(
            fn() => print($pdfContent),
            'etiket.pdf'
        );
    }

    /** ----------------------------
     *  Livewire lifecycle
     *  ---------------------------- */
    public function mount()
    {
        $this->loadPasien($this->regNo);
    }

    public function render()
    {
        return view('livewire.component.cetak.cetak-etiket');
    }
}
