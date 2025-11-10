<?php

namespace App\Http\Livewire\Component\Cetak;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Component;

use App\Http\Traits\EmrRJ\EmrRJTrait;
use App\Http\Traits\MasterPasien\MasterPasienTrait;

class CetakEresepRJ extends Component
{
    use EmrRJTrait, MasterPasienTrait;

    public string $rjNoRef;
    public array $dataDaftarPoliRJ = [];
    public array $dataPasien = [];

    /** ----------------------------
     *  Loader: fresh RJ & master pasien
     *  ---------------------------- */
    private function loadFresh(string $rjNo): void
    {
        // Ambil JSON RJ terbaru via trait
        $wrap = $this->findDataRJ($rjNo);
        if (isset($wrap['errorMessages'])) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($wrap['errorMessages']);
            return;
        }

        $fresh = $wrap['dataDaftarRJ'] ?? [];
        if (!is_array($fresh)) $fresh = [];

        // Pastikan subtree ada
        foreach (['eresep', 'eresepRacikan'] as $k) {
            if (!isset($fresh[$k]) || !is_array($fresh[$k])) $fresh[$k] = [];
        }

        $this->dataDaftarPoliRJ = $fresh;

        // Ambil master pasien via trait (single source of truth)
        $regNo = $fresh['regNo'] ?? null;
        if ($regNo) {
            $mp = $this->findDataMasterPasien($regNo);
            // Jika trait mengembalikan array lengkap, langsung pakai.
            // Tambah umur “thn” (human readable) bila tanggal lahir valid.
            if (is_array($mp) && isset($mp['pasien'])) {
                try {
                    if (!empty($mp['pasien']['tglLahir'])) {
                        $mp['pasien']['thn'] = Carbon::createFromFormat('d/m/Y', $mp['pasien']['tglLahir'])
                            ->diff(Carbon::now(config('app.timezone')))
                            ->format('%y Thn, %m Bln %d Hr');
                    }
                } catch (\Throwable $e) {
                    // no-op, biarkan apa adanya
                }
                $this->dataPasien = $mp;
            } else {
                $this->dataPasien = ['pasien' => []]; // fallback minimal
            }
        } else {
            $this->dataPasien = ['pasien' => []];
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('RegNo tidak ditemukan pada data RJ.');
        }
    }

    /** ----------------------------
     *  Cetak PDF (selalu re-fetch fresh)
     *  ---------------------------- */
    public function cetak()
    {
        // Pastikan data paling baru
        $this->loadFresh($this->rjNoRef);

        // Identitas RS (boleh dari DB)
        $queryIdentitas = DB::table('dimst_identitases')
            ->select('int_name', 'int_phone1', 'int_phone2', 'int_fax', 'int_address', 'int_city')
            ->first();

        // Validasi minimal: ada TTD dokter & ada isi resep
        $adaTtdDokter = $this->dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['drPemeriksa'] ?? null;
        $adaResep = !empty($this->dataDaftarPoliRJ['eresep']) || !empty($this->dataDaftarPoliRJ['eresepRacikan']);

        if (!$adaTtdDokter) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Belum ada TTD pada Data Resep');
            return;
        }
        if (!$adaResep) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError('Data Resep Tidak ditemukan');
            return;
        }

        $data = [
            'myQueryIdentitas'  => $queryIdentitas,
            'dataPasien'        => $this->dataPasien,
            'dataDaftarPoliRJ'  => $this->dataDaftarPoliRJ,
        ];

        $pdfContent = Pdf::loadView('livewire.component.cetak.cetak-eresep-r-j-print', $data)->output();
        toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
            ->addSuccess('Cetak Eresep RJ');

        return response()->streamDownload(
            fn() => print($pdfContent),
            'eresep.pdf'
        );
    }

    /** ----------------------------
     *  Livewire lifecycle
     *  ---------------------------- */
    public function mount()
    {
        $this->loadFresh($this->rjNoRef);
    }

    public function render()
    {
        return view('livewire.component.cetak.cetak-eresep-r-j');
    }
}
