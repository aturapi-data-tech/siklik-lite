<?php

namespace App\Http\Livewire\Emr\RekamMedis;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


use Spatie\ArrayToXml\ArrayToXml;


class RekamMedis extends Component
{
    use WithPagination;


    // listener from blade////////////////
    protected $listeners = [];

    // primitive Variable
    public string $myTitle = 'Data Pasien UGD';
    public string $mySnipt = 'Rekam Medis Pasien';
    public string $myProgram = 'Pasien UGD';


    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $regNoRef;

    public array $dataDaftarTxn;
    public array $dataPasien;




    public bool $isOpenRekamMedisUGD;
    public bool $isOpenRekamMedisRJ;


    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////

    // Layanan RJ/RI/UGD
    public function openModalLayanan($txnNo = null, $layananStatus = null, $dataDaftarTxn = []): void
    {

        if ($layananStatus === 'RJ') {
            $this->isOpenRekamMedisRJ = true;
            $this->dataDaftarTxn = $dataDaftarTxn;
            if (isset($this->dataDaftarTxn['regNo'])) {
                $this->setDataPasien($this->dataDaftarTxn['regNo']);
            }
        } else if ($layananStatus === 'UGD') {
            $this->isOpenRekamMedisUGD = true;
            $this->dataDaftarTxn = $dataDaftarTxn;

            if (isset($this->dataDaftarTxn['regNo'])) {
                $this->setDataPasien($this->dataDaftarTxn['regNo']);
            }
        } else if ($layananStatus === 'RI') {
            $this->emit('toastr-error', 'Rekam Medis (Rawat Inap) Fitur dalam masa pengembangan');
            // $this->dataDaftarTxn = $dataDaftarTxn;

            // if (isset($this->dataDaftarTxn['regNo'])) {
            //     $this->setDataPasien($this->dataDaftarTxn['regNo']);
            // }
        }
    }

    private function setDataPasien($value): void
    {
        $findData = DB::table('rsmst_pasiens')
            ->select('meta_data_pasien_json')
            ->where('reg_no', $value)
            ->first();


        $meta_data_pasien_json = isset($findData->meta_data_pasien_json) ? $findData->meta_data_pasien_json : null;
        // if meta_data_pasien_json = null
        // then cari Data Pasien By Key Collection (exception when no data found)
        // 
        // else json_decode
        if ($meta_data_pasien_json == null) {

            $findData = $this->cariDataPasienByKeyCollection('reg_no', $value);
            if ($findData) {
                $this->dataPasien['pasien']['regDate'] = $findData->reg_date;
                $this->dataPasien['pasien']['regNo'] = $findData->reg_no;
                $this->dataPasien['pasien']['regName'] = $findData->reg_name;
                $this->dataPasien['pasien']['identitas']['idbpjs'] = $findData->nokartu_bpjs;
                $this->dataPasien['pasien']['identitas']['nik'] = $findData->nik_bpjs;
                $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] = ($findData->sex == 'L') ? 1 : 2;
                $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] = ($findData->sex == 'L') ? 'Laki-laki' : 'Perempuan';
                $this->dataPasien['pasien']['tglLahir'] = $findData->birth_date;
                $this->dataPasien['pasien']['thn'] = Carbon::createFromFormat('d/m/Y', $findData->birth_date)->diff(Carbon::now())->format('%y Thn, %m Bln %d Hr'); //$findData->thn;
                $this->dataPasien['pasien']['bln'] = $findData->bln;
                $this->dataPasien['pasien']['hari'] = $findData->hari;
                $this->dataPasien['pasien']['tempatLahir'] = $findData->birth_place;
                $this->dataPasien['pasien']['golonganDarah']['golonganDarahId'] = '13';
                $this->dataPasien['pasien']['golonganDarah']['golonganDarahDesc'] = 'Tidak Tahu';
                $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanId'] = '1';
                $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanDesc'] = 'Belum Kawin';

                $this->dataPasien['pasien']['agama']['agamaId'] = $findData->rel_id;
                $this->dataPasien['pasien']['agama']['agamaDesc'] = $findData->rel_desc;

                $this->dataPasien['pasien']['pendidikan']['pendidikanId'] = $findData->edu_id;
                $this->dataPasien['pasien']['pendidikan']['pendidikanDesc'] = $findData->edu_desc;

                $this->dataPasien['pasien']['pekerjaan']['pekerjaanId'] = $findData->job_id;
                $this->dataPasien['pasien']['pekerjaan']['pekerjaanDesc'] = $findData->job_name;


                $this->dataPasien['pasien']['hubungan']['namaPenanggungJawab'] = $findData->reg_no;
                $this->dataPasien['pasien']['hubungan']['namaIbu'] = $findData->reg_no;

                $this->dataPasien['pasien']['identitas']['nik'] = $findData->nik_bpjs;
                $this->dataPasien['pasien']['identitas']['idBpjs'] = $findData->nokartu_bpjs;


                $this->dataPasien['pasien']['identitas']['alamat'] = $findData->address;

                $this->dataPasien['pasien']['identitas']['desaId'] = $findData->des_id;
                $this->dataPasien['pasien']['identitas']['desaName'] = $findData->des_name;

                $this->dataPasien['pasien']['identitas']['rt'] = $findData->rt;
                $this->dataPasien['pasien']['identitas']['rw'] = $findData->rw;
                $this->dataPasien['pasien']['identitas']['kecamatanId'] = $findData->kec_id;
                $this->dataPasien['pasien']['identitas']['kecamatanName'] = $findData->kec_name;

                $this->dataPasien['pasien']['identitas']['kotaId'] = $findData->kab_id;
                $this->dataPasien['pasien']['identitas']['kotaName'] = $findData->kab_name;

                $this->dataPasien['pasien']['identitas']['propinsiId'] = $findData->prop_id;
                $this->dataPasien['pasien']['identitas']['propinsiName'] = $findData->prop_name;

                $this->dataPasien['pasien']['kontak']['nomerTelponSelulerPasien'] = $findData->phone;

                $this->dataPasien['pasien']['hubungan']['namaPenanggungJawab'] = $findData->kk;
                $this->dataPasien['pasien']['hubungan']['namaIbu'] = $findData->nyonya;
                // $this->dataPasien['pasien']['hubungan']['noPenanggungJawab'] = $findData->no_kk;
            } else {
                // when no data found
                $this->dataPasien['pasien']['regDate'] = '-';
                $this->dataPasien['pasien']['regNo'] = '-';
                $this->dataPasien['pasien']['regName'] = '-';
                $this->dataPasien['pasien']['identitas']['idbpjs'] = '-';
                $this->dataPasien['pasien']['identitas']['nik'] = '-';
                $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] = '-';
                $this->dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] = '-';
                $this->dataPasien['pasien']['tglLahir'] = '-';
                $this->dataPasien['pasien']['thn'] = '-';
                $this->dataPasien['pasien']['bln'] = '-';
                $this->dataPasien['pasien']['hari'] = '-';
                $this->dataPasien['pasien']['tempatLahir'] = '-';
                $this->dataPasien['pasien']['golonganDarah']['golonganDarahId'] = '-';
                $this->dataPasien['pasien']['golonganDarah']['golonganDarahDesc'] = '-';
                $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanId'] = '-';
                $this->dataPasien['pasien']['statusPerkawinan']['statusPerkawinanDesc'] = '-';

                $this->dataPasien['pasien']['agama']['agamaId'] = '-';
                $this->dataPasien['pasien']['agama']['agamaDesc'] = '-';

                $this->dataPasien['pasien']['pendidikan']['pendidikanId'] = '-';
                $this->dataPasien['pasien']['pendidikan']['pendidikanDesc'] = '-';

                $this->dataPasien['pasien']['pekerjaan']['pekerjaanId'] = '-';
                $this->dataPasien['pasien']['pekerjaan']['pekerjaanDesc'] = '-';


                $this->dataPasien['pasien']['hubungan']['namaPenanggungJawab'] = '-';
                $this->dataPasien['pasien']['hubungan']['namaIbu'] = '-';

                $this->dataPasien['pasien']['identitas']['nik'] = '-';
                $this->dataPasien['pasien']['identitas']['idBpjs'] = '-';


                $this->dataPasien['pasien']['identitas']['alamat'] = '-';

                $this->dataPasien['pasien']['identitas']['desaId'] = '-';
                $this->dataPasien['pasien']['identitas']['desaName'] = '-';

                $this->dataPasien['pasien']['identitas']['rt'] = '-';
                $this->dataPasien['pasien']['identitas']['rw'] = '-';
                $this->dataPasien['pasien']['identitas']['kecamatanId'] = '-';
                $this->dataPasien['pasien']['identitas']['kecamatanName'] = '-';

                $this->dataPasien['pasien']['identitas']['kotaId'] = '-';
                $this->dataPasien['pasien']['identitas']['kotaName'] = '-';

                $this->dataPasien['pasien']['identitas']['propinsiId'] = '-';
                $this->dataPasien['pasien']['identitas']['propinsiName'] = '-';

                $this->dataPasien['pasien']['kontak']['nomerTelponSelulerPasien'] = '-';

                $this->dataPasien['pasien']['hubungan']['namaPenanggungJawab'] = '-';
                $this->dataPasien['pasien']['hubungan']['namaIbu'] = '-';
            }
        } else {
            // ubah data Pasien
            $this->dataPasien = json_decode($findData->meta_data_pasien_json, true);
            $this->dataPasien['pasien']['thn'] = Carbon::createFromFormat('d/m/Y', $this->dataPasien['pasien']['tglLahir'])->diff(Carbon::now())->format('%y Thn, %m Bln %d Hr'); //$findData->thn;


        }
    }

    private function cariDataPasienByKeyCollection($key, $search)
    {
        $findData = DB::table('rsmst_pasiens')
            ->select(
                DB::raw("to_char(reg_date,'dd/mm/yyyy hh24:mi:ss') as reg_date"),
                DB::raw("to_char(reg_date,'yyyymmddhh24miss') as reg_date1"),
                'reg_no',
                'reg_name',
                DB::raw("nvl(nokartu_bpjs,'-') as nokartu_bpjs"),
                DB::raw("nvl(nik_bpjs,'-') as nik_bpjs"),
                'sex',
                DB::raw("to_char(birth_date,'dd/mm/yyyy') as birth_date"),
                DB::raw("(select trunc( months_between( sysdate, birth_date ) /12 ) from dual) as thn"),
                'bln',
                'hari',
                'birth_place',
                'blood',
                'marital_status',
                'rsmst_religions.rel_id as rel_id',
                'rel_desc',
                'rsmst_educations.edu_id as edu_id',
                'edu_desc',
                'rsmst_jobs.job_id as job_id',
                'job_name',
                'kk',
                'nyonya',
                'no_kk',
                'address',
                'rsmst_desas.des_id as des_id',
                'des_name',
                'rt',
                'rw',
                'rsmst_kecamatans.kec_id as kec_id',
                'kec_name',
                'rsmst_kabupatens.kab_id as kab_id',
                'kab_name',
                'rsmst_propinsis.prop_id as prop_id',
                'prop_name',
                'phone'
            )->join('rsmst_religions', 'rsmst_religions.rel_id', 'rsmst_pasiens.rel_id')
            ->join('rsmst_educations', 'rsmst_educations.edu_id', 'rsmst_pasiens.edu_id')
            ->join('rsmst_jobs', 'rsmst_jobs.job_id', 'rsmst_pasiens.job_id')
            ->join('rsmst_desas', 'rsmst_desas.des_id', 'rsmst_pasiens.des_id')
            ->join('rsmst_kecamatans', 'rsmst_kecamatans.kec_id', 'rsmst_pasiens.kec_id')
            ->join('rsmst_kabupatens', 'rsmst_kabupatens.kab_id', 'rsmst_pasiens.kab_id')
            ->join('rsmst_propinsis', 'rsmst_propinsis.prop_id', 'rsmst_pasiens.prop_id')
            ->where($key, $search)
            ->first();
        return $findData;
    }


    public function closeModalLayanan(): void
    {
        $this->isOpenRekamMedisUGD = false;
        $this->isOpenRekamMedisRJ = false;
    }


    public function cetakRekamMedisUGD()
    {
        $queryIdentitas = DB::table('rsmst_identitases')
            ->select(
                'int_name',
                'int_phone1',
                'int_phone2',
                'int_fax',
                'int_address',
                'int_city',
            )
            ->first();
        // cetak PDF
        $data = [
            'myQueryIdentitas' => $queryIdentitas,
            'dataPasien' => $this->dataPasien,
            'dataDaftarTxn' => $this->dataDaftarTxn,

        ];
        $pdfContent = PDF::loadView('livewire.emr.rekam-medis.cetak-rekam-medis-u-g-d', $data)->output();
        $this->emit('toastr-success', 'Cetak RM IGD');

        return response()->streamDownload(
            fn () => print($pdfContent),
            "rmUGD.pdf"
        );
    }

    public function cetakRekamMedisRJ()
    {
        $queryIdentitas = DB::table('rsmst_identitases')
            ->select(
                'int_name',
                'int_phone1',
                'int_phone2',
                'int_fax',
                'int_address',
                'int_city',
            )
            ->first();
        // cetak PDF
        $data = [
            'myQueryIdentitas' => $queryIdentitas,
            'dataPasien' => $this->dataPasien,
            'dataDaftarTxn' => $this->dataDaftarTxn,

        ];
        $pdfContent = PDF::loadView('livewire.emr.rekam-medis.cetak-rekam-medis-r-j', $data)->output();
        $this->emit('toastr-success', 'Cetak RM RJ');

        return response()->streamDownload(
            fn () => print($pdfContent),
            "rmRJ.pdf"
        );
    }

    public function cetakRekamMedisRJGrid($txnNo = null, $layananStatus = null, $dataDaftarTxn = [])
    {
        $queryIdentitas = DB::table('rsmst_identitases')
            ->select(
                'int_name',
                'int_phone1',
                'int_phone2',
                'int_fax',
                'int_address',
                'int_city',
            )
            ->first();

        if ($dataDaftarTxn) {
            if ($layananStatus === 'RJ') {
                $this->dataDaftarTxn = $dataDaftarTxn;
                if (isset($this->dataDaftarTxn['regNo'])) {
                    $this->setDataPasien($this->dataDaftarTxn['regNo']);
                }

                // cetak PDF
                $data = [
                    'myQueryIdentitas' => $queryIdentitas,
                    'dataPasien' => $this->dataPasien,
                    'dataDaftarTxn' => $this->dataDaftarTxn,

                ];
                $pdfContent = PDF::loadView('livewire.emr.rekam-medis.cetak-rekam-medis-r-j', $data)->output();
                $this->emit('toastr-success', 'Cetak RM RJ');


                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "rmRJ.pdf"
                );
            } else if ($layananStatus === 'UGD') {
                $this->dataDaftarTxn = $dataDaftarTxn;

                if (isset($this->dataDaftarTxn['regNo'])) {
                    $this->setDataPasien($this->dataDaftarTxn['regNo']);
                }

                // cetak PDF
                $data = [
                    'myQueryIdentitas' => $queryIdentitas,
                    'dataPasien' => $this->dataPasien,
                    'dataDaftarTxn' => $this->dataDaftarTxn,

                ];
                $pdfContent = PDF::loadView('livewire.emr.rekam-medis.cetak-rekam-medis-u-g-d', $data)->output();
                $this->emit('toastr-success', 'Cetak RM IGD');

                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "rmUGD.pdf"
                );
            } else if ($layananStatus === 'RI') {
                $this->emit('toastr-error', 'Rekam Medis (Rawat Inap) Fitur dalam masa pengembangan');
                // $this->dataDaftarTxn = $dataDaftarTxn;

                // if (isset($this->dataDaftarTxn['regNo'])) {
                //     $this->setDataPasien($this->dataDaftarTxn['regNo']);
                // }
            }
        } else {
            $this->emit('toastr-error', 'Data Rekam Medis Tidak di Temukan');
        }
    }


    public function cetakRekamMedisRJSuketIstirahatGrid($txnNo = null, $layananStatus = null, $dataDaftarTxn = [])
    {
        $queryIdentitas = DB::table('rsmst_identitases')
            ->select(
                'int_name',
                'int_phone1',
                'int_phone2',
                'int_fax',
                'int_address',
                'int_city',
            )
            ->first();

        if ($dataDaftarTxn) {
            if ($layananStatus === 'RJ') {
                $this->dataDaftarTxn = $dataDaftarTxn;
                if (isset($this->dataDaftarTxn['regNo'])) {
                    $this->setDataPasien($this->dataDaftarTxn['regNo']);
                }

                // cetak PDF
                $data = [
                    'myQueryIdentitas' => $queryIdentitas,
                    'dataPasien' => $this->dataPasien,
                    'dataDaftarTxn' => $this->dataDaftarTxn,

                ];
                $pdfContent = PDF::loadView('livewire.emr.rekam-medis.cetak-rekam-medis-r-j-suket-istirahat', $data)->output();
                $this->emit('toastr-success', 'Cetak Suket Istirahat');


                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "rmRJ.pdf"
                );
            } else if ($layananStatus === 'UGD') {
                $this->dataDaftarTxn = $dataDaftarTxn;

                if (isset($this->dataDaftarTxn['regNo'])) {
                    $this->setDataPasien($this->dataDaftarTxn['regNo']);
                }

                // cetak PDF
                $data = [
                    'myQueryIdentitas' => $queryIdentitas,
                    'dataPasien' => $this->dataPasien,
                    'dataDaftarTxn' => $this->dataDaftarTxn,

                ];
                $pdfContent = PDF::loadView('livewire.emr.rekam-medis.cetak-rekam-medis-u-g-d', $data)->output();
                $this->emit('toastr-success', 'Cetak RM IGD');

                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "rmUGD.pdf"
                );
            } else if ($layananStatus === 'RI') {
                $this->emit('toastr-error', 'Rekam Medis (Rawat Inap) Fitur dalam masa pengembangan');
                // $this->dataDaftarTxn = $dataDaftarTxn;

                // if (isset($this->dataDaftarTxn['regNo'])) {
                //     $this->setDataPasien($this->dataDaftarTxn['regNo']);
                // }
            }
        } else {
            $this->emit('toastr-error', 'Data Rekam Medis Tidak di Temukan');
        }
    }


    public function cetakRekamMedisRJSuketSehatGrid($txnNo = null, $layananStatus = null, $dataDaftarTxn = [])
    {
        $queryIdentitas = DB::table('rsmst_identitases')
            ->select(
                'int_name',
                'int_phone1',
                'int_phone2',
                'int_fax',
                'int_address',
                'int_city',
            )
            ->first();

        if ($dataDaftarTxn) {
            if ($layananStatus === 'RJ') {
                $this->dataDaftarTxn = $dataDaftarTxn;
                if (isset($this->dataDaftarTxn['regNo'])) {
                    $this->setDataPasien($this->dataDaftarTxn['regNo']);
                }

                // cetak PDF
                $data = [
                    'myQueryIdentitas' => $queryIdentitas,
                    'dataPasien' => $this->dataPasien,
                    'dataDaftarTxn' => $this->dataDaftarTxn,

                ];
                $pdfContent = PDF::loadView('livewire.emr.rekam-medis.cetak-rekam-medis-r-j-suket-sehat', $data)->output();
                $this->emit('toastr-success', 'Cetak Suket Sehat');


                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "rmRJ.pdf"
                );
            } else if ($layananStatus === 'UGD') {
                $this->dataDaftarTxn = $dataDaftarTxn;

                if (isset($this->dataDaftarTxn['regNo'])) {
                    $this->setDataPasien($this->dataDaftarTxn['regNo']);
                }

                // cetak PDF
                $data = [
                    'myQueryIdentitas' => $queryIdentitas,
                    'dataPasien' => $this->dataPasien,
                    'dataDaftarTxn' => $this->dataDaftarTxn,

                ];
                $pdfContent = PDF::loadView('livewire.emr.rekam-medis.cetak-rekam-medis-u-g-d', $data)->output();
                $this->emit('toastr-success', 'Cetak RM IGD');

                return response()->streamDownload(
                    fn () => print($pdfContent),
                    "rmUGD.pdf"
                );
            } else if ($layananStatus === 'RI') {
                $this->emit('toastr-error', 'Rekam Medis (Rawat Inap) Fitur dalam masa pengembangan');
                // $this->dataDaftarTxn = $dataDaftarTxn;

                // if (isset($this->dataDaftarTxn['regNo'])) {
                //     $this->setDataPasien($this->dataDaftarTxn['regNo']);
                // }
            }
        } else {
            $this->emit('toastr-error', 'Data Rekam Medis Tidak di Temukan');
        }
    }


    // when new form instance
    public function mount()
    {
    }



    // select data start////////////////
    public function render()
    {

        //////////////////////////////////////////
        // Query ///////////////////////////////
        //////////////////////////////////////////
        $query = DB::table('rsview_ermstatus')
            ->select(
                DB::raw("to_char(txn_date,'dd/mm/yyyy hh24:mi:ss') AS txn_date"),
                DB::raw("to_char(txn_date,'yyyymmddhh24miss') AS txn_date1"),
                'txn_no',
                'reg_no',
                'erm_status',
                'layanan_status',
                'poli',
                DB::raw("(CASE WHEN layanan_status='RJ' THEN (select datadaftarpolirj_json from rsview_rjkasir where rj_no=txn_no)
                                        WHEN layanan_status='UGD' THEN (select datadaftarugd_json from rsview_ugdkasir where rj_no=txn_no)
                                            ELSE null END) as datadaftar_json")

            )
            ->where('reg_no', $this->regNoRef)
            ->orderBy('txn_date1',  'desc')
            ->orderBy('layanan_status',  'desc')
            ->orderBy('poli',  'asc');


        $queryIdentitas = DB::table('rsmst_identitases')
            ->select(
                'int_name',
                'int_phone1',
                'int_phone2',
                'int_fax',
                'int_address',
                'int_city',
            )
            ->first();
        ////////////////////////////////////////////////
        // end Query
        ///////////////////////////////////////////////

        return view(
            'livewire.emr.rekam-medis.rekam-medis',
            [
                'myQueryData' => $query->paginate(3),
                'myQueryIdentitas' => $queryIdentitas
            ]


        );
    }
    // select data end////////////////


}
