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

                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Ref Kesadaran BPJS telah diperbarui.');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Data Ref Kesadaran BPJS sekarang sudah akurat dan terbaru');
            }


            return;
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
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
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Ref Dokter BPJS telah diperbarui.');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Data Ref Dokter BPJS sekarang sudah akurat dan terbaru');
            }


            return;
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
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
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Ref Alergi Makanan BPJS telah diperbarui.');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Data Ref Alergi Makanan BPJS sekarang sudah akurat dan terbaru');
            }
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
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
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Ref Alergi Udara BPJS telah diperbarui.');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Data Ref Alergi Udara BPJS sekarang sudah akurat dan terbaru');
            }
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
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
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Ref Alergi Obat BPJS telah diperbarui.');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Data Ref Alergi Obat BPJS sekarang sudah akurat dan terbaru');
            }
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
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
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Ref Prognosa BPJS telah diperbarui.');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Data Ref Prognosa BPJS sekarang sudah akurat dan terbaru');
            }


            return;
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
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
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Ref PoliFktp BPJS telah diperbarui.');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Data Ref PoliFktp BPJS sekarang sudah akurat dan terbaru');
            }


            return;
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
            return;
        }
    }

    public function updateDataStatusPulang(): void
    {
        //Parameter 1 : Jika rawat inap maka diisi true, sebaliknya diisi false
        try {


            $getStatusPulang = $this->getStatusPulang(true)
                ->getOriginalContent()['response']['list'] ?? [];

            $checkDataStatusPulang =  $this->checkData('Status Pulang RI');



            if (
                json_encode($getStatusPulang, true) !== $checkDataStatusPulang
                &&
                $getStatusPulang !== []
            ) {
                $this->updateData('Status Pulang RI', $getStatusPulang);
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Ref Status Pulang RI BPJS telah diperbarui.');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Data Ref Status Pulang RI BPJS sekarang sudah akurat dan terbaru');
            }
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
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
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Ref Status Pulang RJ BPJS telah diperbarui.');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Data Ref Status Pulang RJ BPJS sekarang sudah akurat dan terbaru');
            }
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
        }
    }


    public function updateDataProvider(): void
    {
        //Parameter 1 : Row data awal yang akan ditampilkan

        // Parameter 2 : Limit jumlah data yang akan ditampilkan
        try {


            $getProviderRayonisasi = $this->getProviderRayonisasi(1, 99)
                ->getOriginalContent()['response']['list'] ?? [];

            $checkDataProviderRayonisasi =  $this->checkData('Provider');



            if (
                json_encode($getProviderRayonisasi, true) !== $checkDataProviderRayonisasi
                &&
                $getProviderRayonisasi !== []
            ) {
                $this->updateData('Provider', $getProviderRayonisasi);
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Ref Provider BPJS telah diperbarui.');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Data Ref Provider BPJS sekarang sudah akurat dan terbaru');
            }
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
        }
    }

    public function updateDataSarana(): void
    {
        //Parameter 1 : Row data awal yang akan ditampilkan

        // Parameter 2 : Limit jumlah data yang akan ditampilkan
        try {


            $getSarana = $this->getSarana()
                ->getOriginalContent()['response']['list'] ?? [];

            $checkDataSarana =  $this->checkData('Sarana');



            if (
                json_encode($getSarana, true) !== $checkDataSarana
                &&
                $getSarana !== []
            ) {
                $this->updateData('Sarana', $getSarana);
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Ref Sarana BPJS telah diperbarui.');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Data Ref Sarana BPJS sekarang sudah akurat dan terbaru');
            }
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
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
                toastr()->closeOnHover(true)->closeDuration(3)->positionClass('toast-top-left')
                    ->addSuccess('Data Ref Spesialis BPJS telah diperbarui.');
            } else {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(3)
                    ->positionClass('toast-top-left')
                    ->addError('Data Ref Spesialis BPJS sekarang sudah akurat dan terbaru');
            }


            return;
        } catch (\Exception $e) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(3)
                ->positionClass('toast-top-left')
                ->addError($e->getMessage());
            return;
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
