<?php

namespace App\Http\Livewire\RJ\EmrRJ\PostSatuDataKesehatanRJ;


use App\Http\Traits\EmrRJ\EmrRJTrait;
use Carbon\Carbon;

use App\Http\Traits\SATUDATAKESEHATAN\SatuDataKesehatanTrait;
use App\Http\Traits\customErrorMessagesTrait;
use Illuminate\Support\Facades\Validator;

use Livewire\Component;

class PostSatuDataKesehatanRJ extends Component
{
    use EmrRJTrait;


    public $rjNoRef;

    public array $dataDaftarPoliRJ = [];
    public array $dataPasienRJ = [];
    public string $EncounterID;

    protected $listeners = [
        'syncronizepostSatuDataKesehatanRJRJ' => 'mount',
    ];

    private function findData($rjno): void
    {
        $this->dataDaftarPoliRJ = $this->findDataRJ($rjno)['dataDaftarRJ'];

        if (isset($this->dataDaftarPoliRJ['satuDataKesehatanTulungagung'])) {


            $this->EncounterID = $this->dataDaftarPoliRJ['satuDataKesehatanTulungagung']['metadata']['message'];
        } else {
            $this->EncounterID = '';
        }
    }

    public function PostSatuDataKesehatan()
    {

        $findDataRJ = $this->findDataRJ($this->rjNoRef);
        $dataDaftarPoliRJ = $findDataRJ['dataDaftarRJ'];
        $dataPasienRJ = $findDataRJ['dataPasienRJ'];

        // cek data satu sehat dikirim atau belum
        if (isset($dataDaftarPoliRJ['satuDataKesehatanTulungagung'])) {
            $this->emit('toastr-error', 'Data Pasien ' . $dataPasienRJ['regName'] . ' sudah dikirim ke Satu Data Kesehatan Tulungagung');
            return;
        }

        // cek
        // if task id null batal proses 3 4 5
        // if pasien uuid null -> then get uuid -> if fail batal proses if ok
        // proses
        // if dokter uuid null -> then get uuid -> if fail batal proses if ok
        // proses
        // if// if poli uuid null -> then get uuid -> if fail batal proses if ok
        // proses
        if (!isset($dataDaftarPoliRJ['diagnosis'])) {
            $this->emit('toastr-error', 'Data diagnosis kosong');
            return;
        }

        if (collect($dataDaftarPoliRJ['diagnosis'])->count() == 0) {
            $this->emit('toastr-error', 'Data diagnosis kosong');
            return;
        }

        foreach ($dataDaftarPoliRJ['diagnosis'] as $diag) {

            $r = [
                "tanggal" => Carbon::createFromFormat('d/m/Y H:i:s', $dataDaftarPoliRJ['rjDate'], env('APP_TIMEZONE'))->format('d-m-Y'),

                "nik" => $dataPasienRJ['nik'],
                "nama" => $dataPasienRJ['regName'],
                "alamat" => $dataPasienRJ['address'],
                "desa" => $dataPasienRJ['desa'],
                "kecamatan" => $dataPasienRJ['kecamatan'],
                "icdx" => $diag['icdX'],
                "kunjungan" => "Baru",
                "kasus" => "Baru",
            ];



            $rules = [
                "tanggal" => 'required',
                "nik" => 'required',
                "nama" => 'required',
                "alamat" => 'required',
                "desa" => 'required',
                "kecamatan" => 'required',
                "icdx" => 'required',
                "kunjungan" => 'required',
                "kasus" => 'required',

            ];
            $customErrorMessagesTrait = customErrorMessagesTrait::messages();
            $attribute = [
                "tanggal" => 'Tanggal',
                "nik" => 'NIK',
                "nama" => 'Nama Pasien',
                "alamat" => 'Alamat',
                "desa" => 'Desa',
                "kecamatan" => 'Kecamatan',
                "icdx" => 'ICD10',
                "kunjungan" => 'Kunjungan',
                "kasus" => 'Kasus',
            ];

            $validator = Validator::make($r, $rules, $customErrorMessagesTrait, $attribute);

            if ($validator->fails()) {
                $this->emit('toastr-error', $validator->messages()->all());
                return;
            }


            // Proses Validasi///////////////////////////////////////////
            try {

                $postSatuDataKesehatanRJ = SatuDataKesehatanTrait::PostPortalSatuDataTulungagung($r);

                if ($postSatuDataKesehatanRJ->getOriginalContent()['metadata']['code'] == 200) {
                    // Jika 200
                    $dataDaftarPoliRJ['satuDataKesehatanTulungagung'] = $postSatuDataKesehatanRJ->getOriginalContent();
                    // update Json ke database
                    $this->updateJsonRJ($this->rjNoRef, $dataDaftarPoliRJ);
                    $this->emit('syncronizepostSatuDataKesehatanRJRJ');
                } else {

                    // dd($postSatuDataKesehatanRJ->getOriginalContent());
                    $this->emit('toastr-error', json_encode($postSatuDataKesehatanRJ->getOriginalContent(), true));
                    return;
                }
            } catch (\Illuminate\Validation\ValidationException $e) {
                // dd($validator->fails());
                $this->emit('toastr-error', 'Errors "' . $e->getMessage());
                return;
            }
        }
    }


    public function mount()
    {
        $this->findData($this->rjNoRef);
    }
    public function render()
    {
        return view('livewire.r-j.emr-r-j.post-satu-data-kesehatan-r-j.post-satu-data-kesehatan-r-j');
    }
}
