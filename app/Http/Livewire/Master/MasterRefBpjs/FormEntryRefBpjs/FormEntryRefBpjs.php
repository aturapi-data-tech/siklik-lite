<?php

namespace App\Http\Livewire\Master\MasterRefBpjs\FormEntryRefBpjs;

use App\Http\Traits\BPJS\PcareTrait;
use Illuminate\Support\Facades\DB;



use Livewire\Component;

class FormEntryRefBpjs extends Component
{
    use PcareTrait;

    // listener from blade////////////////
    protected $listeners = [];

    public string $isOpenMode = 'insert';



    public function updateDataKesadaran(): void
    {
        try {

            $getKesadaran = $this->getKesadaran()
                ->getOriginalContent()['response']['list'] ?? [];

            $checkDataKesadaran = $this->checkData('Kesadaran');

            if (
                json_encode($getKesadaran, true) !== $checkDataKesadaran
                &&
                $getKesadaran !== []
            ) {
                $this->updateData('Kesadaran', $getKesadaran);

                $this->emit('toastr-success', 'Data Ref Kesadaran BPJS telah diperbarui.');
            } else {
                $this->emit('toastr-error', 'Data Ref Kesadaran BPJS sekarang sudah akurat dan terbaru');
            }


            return;
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            return;
        }
    }

    public function updateDataDokter(): void
    {
        try {

            $getDokter = $this->getDokter(1, 99)
                ->getOriginalContent()['response']['list'] ?? [];


            $checkDataDokter =  $this->checkData('Dokter');



            if (
                json_encode($getDokter, true) !== $checkDataDokter
                &&
                $getDokter !== []
            ) {
                $this->updateData('Dokter', $getDokter);
                $this->emit('toastr-success', 'Data Ref Dokter BPJS telah diperbarui.');
            } else {
                $this->emit('toastr-error', 'Data Ref Dokter BPJS sekarang sudah akurat dan terbaru');
            }


            return;
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            return;
        }
    }

    public function updateDataSpesialis(): void
    {
        try {

            $getSpesialis = $this->getSpesialis()
                ->getOriginalContent()['response']['list'] ?? [];


            $checkDataSpesialis =  $this->checkData('Spesialis');



            if (
                json_encode($getSpesialis, true) !== $checkDataSpesialis
                &&
                $getSpesialis !== []
            ) {
                $this->updateData('Spesialis', $getSpesialis);
                $this->emit('toastr-success', 'Data Ref Spesialis BPJS telah diperbarui.');
            } else {
                $this->emit('toastr-error', 'Data Ref Spesialis BPJS sekarang sudah akurat dan terbaru');
            }


            return;
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            return;
        }
    }

    public function updateDataAlergi(): void
    {
        //parameter 1: 01:Makanan, 02:Udara, 03:Obat
        try {

            $getAlergi = $this->getAlergi('01')
                ->getOriginalContent()['response']['list'] ?? [];;

            $checkDataAlergi =  $this->checkData('Alergi Makanan');



            if (
                json_encode($getAlergi, true) !== $checkDataAlergi
                &&
                $getAlergi !== []
            ) {
                $this->updateData('Alergi Makanan', $getAlergi);
                $this->emit('toastr-success', 'Data Ref Alergi Makanan BPJS telah diperbarui.');
            } else {
                $this->emit('toastr-error', 'Data Ref Alergi Makanan BPJS sekarang sudah akurat dan terbaru');
            }
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
        }
        //////////////////////////////////
        try {

            $getAlergi = $this->getAlergi('02')
                ->getOriginalContent()['response']['list'] ?? [];;

            $checkDataAlergi =  $this->checkData('Alergi Udara');



            if (
                json_encode($getAlergi, true) !== $checkDataAlergi
                &&
                $getAlergi !== []
            ) {
                $this->updateData('Alergi Udara', $getAlergi);
                $this->emit('toastr-success', 'Data Ref Alergi Udara BPJS telah diperbarui.');
            } else {
                $this->emit('toastr-error', 'Data Ref Alergi Udara BPJS sekarang sudah akurat dan terbaru');
            }
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
        }
        //////////////////////////////////
        try {

            $getAlergi = $this->getAlergi('03')
                ->getOriginalContent()['response']['list'] ?? [];;

            $checkDataAlergi =  $this->checkData('Alergi Obat');



            if (
                json_encode($getAlergi, true) !== $checkDataAlergi
                &&
                $getAlergi !== []
            ) {
                $this->updateData('Alergi Obat', $getAlergi);
                $this->emit('toastr-success', 'Data Ref Alergi Obat BPJS telah diperbarui.');
            } else {
                $this->emit('toastr-error', 'Data Ref Alergi Obat BPJS sekarang sudah akurat dan terbaru');
            }
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
        }
    }


    public function updateDataPrognosa(): void
    {
        try {

            $getPrognosa = $this->getPrognosa()
                ->getOriginalContent()['response']['list'] ?? [];


            $checkDataPrognosa =  $this->checkData('Prognosa');



            if (
                json_encode($getPrognosa, true) !== $checkDataPrognosa
                &&
                $getPrognosa !== []
            ) {
                $this->updateData('Prognosa', $getPrognosa);
                $this->emit('toastr-success', 'Data Ref Prognosa BPJS telah diperbarui.');
            } else {
                $this->emit('toastr-error', 'Data Ref Prognosa BPJS sekarang sudah akurat dan terbaru');
            }


            return;
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            return;
        }
    }

    public function updateDataPoliFktp(): void
    {
        try {

            $getPoliFktp = $this->getPoliFktp(1, 99)
                ->getOriginalContent()['response']['list'] ?? [];


            $checkDataPoliFktp =  $this->checkData('PoliFktp');



            if (
                json_encode($getPoliFktp, true) !== $checkDataPoliFktp
                &&
                $getPoliFktp !== []
            ) {
                $this->updateData('PoliFktp', $getPoliFktp);
                $this->emit('toastr-success', 'Data Ref PoliFktp BPJS telah diperbarui.');
            } else {
                $this->emit('toastr-error', 'Data Ref PoliFktp BPJS sekarang sudah akurat dan terbaru');
            }


            return;
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            return;
        }
    }

    public function updateDataStatusPulang(): void
    {
        //Parameter 1 : Jika rawat inap maka diisi true, sebaliknya diisi false
        try {


            $getStatusPulang = $this->getStatusPulang(true)
                ->getOriginalContent()['response']['list'] ?? [];

            $checkDataAlergi =  $this->checkData('Status Pulang RI');



            if (
                json_encode($getStatusPulang, true) !== $checkDataAlergi
                &&
                $getStatusPulang !== []
            ) {
                $this->updateData('Status Pulang RI', $getStatusPulang);
                $this->emit('toastr-success', 'Data Ref Status Pulang RI BPJS telah diperbarui.');
            } else {
                $this->emit('toastr-error', 'Data Ref Status Pulang RI BPJS sekarang sudah akurat dan terbaru');
            }
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
        }

        try {

            $getStatusPulang = $this->getStatusPulang(false)
                ->getOriginalContent()['response']['list'] ?? [];

            $checkDataAlergi =  $this->checkData('Status Pulang RJ');



            if (
                json_encode($getStatusPulang, true) !== $checkDataAlergi
                &&
                $getStatusPulang !== []
            ) {
                $this->updateData('Status Pulang RJ', $getStatusPulang);
                $this->emit('toastr-success', 'Data Ref Status Pulang RJ BPJS telah diperbarui.');
            } else {
                $this->emit('toastr-error', 'Data Ref Status Pulang RJ BPJS sekarang sudah akurat dan terbaru');
            }
        } catch (\Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
        }
    }



    private function checkData(string $refData): string
    {
        $checkData = DB::table('ref_bpjs_table')
            ->where('ref_keterangan', '=', $refData)
            ->first()->ref_json ?? '{}';

        return $checkData;
    }

    private function updateData(string $refData, array $refArr): void
    {
        DB::table('ref_bpjs_table')
            ->where('ref_keterangan', '=', $refData)
            ->delete();

        DB::table('ref_bpjs_table')
            ->insert(
                [
                    'ref_keterangan' => $refData,
                    'ref_json' => json_encode($refArr, true)
                ],
            );
    }
    public function closeModal(): void
    {
        $this->emit('masterRefBpjsCloseModal');
    }

    public function mount() {}

    public function render()
    {
        return view('livewire.master.master-ref-bpjs.form-entry-ref-bpjs.form-entry-ref-bpjs');
    }
}
