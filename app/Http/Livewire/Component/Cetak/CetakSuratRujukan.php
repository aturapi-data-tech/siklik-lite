<?php

namespace App\Http\Livewire\Component\Cetak;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Traits\EmrRJ\EmrRJTrait;
use App\Http\Traits\MasterPasien\MasterPasienTrait;




use Livewire\Component;

class CetakSuratRujukan extends Component
{
    use EmrRJTrait, MasterPasienTrait;






    public $rjNoRef;

    public array $dataDaftarPoliRJ = [];


    public function cetak()
    {
        if (isset($this->dataDaftarPoliRJ['dataKunjungan'])) {
            // cetak PDF
            $noKunjungan = collect($this->dataDaftarPoliRJ['dataKunjungan'])
                ->where('field', '=', 'noKunjungan')
                ->first()['message'] ?? null;
            $dataPasien = $this->findDataMasterPasien($this->dataDaftarPoliRJ['regNo']);
            $data = [
                'data' => [
                    'noKunjungan' => $noKunjungan ?? '',
                    'dataDaftarPoliRJ' => $this->dataDaftarPoliRJ ?? [],
                    'dataPasien' => $dataPasien['pasien'] ?? []
                ]
            ];
            // $pdfContent = PDF::loadView('livewire.cetak.cetak-etiket', $data)->output();
            $pdfContent = PDF::loadView('livewire.component.cetak.cetak-surat-rujukan-print', $data)->output();

            return response()->streamDownload(
                fn() => print($pdfContent),
                "surat-rujukan.pdf"
            );
        } else {
            $this->emit('toastr-error', 'No Rujukan Tidak Ditemukan');
        }
    }

    private function findData($rjno): void
    {
        $findDataRJ = $this->findDataRJ($rjno);
        $this->dataDaftarPoliRJ  = $findDataRJ['dataDaftarRJ'];
    }


    public function mount()
    {
        $this->findData($this->rjNoRef);
    }
    public function render()
    {
        return view('livewire.component.cetak.cetak-surat-rujukan');
    }
}
