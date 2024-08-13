<?php

namespace App\Http\Livewire\Emr\Laborat;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


use Spatie\ArrayToXml\ArrayToXml;


class Laborat extends Component
{
    use WithPagination;


    // listener from blade////////////////
    protected $listeners = [];

    // primitive Variable
    public string $myTitle = 'Laboratorium';
    public string $mySnipt = 'Pemeriksaan Laboratorium Pasien';
    public string $myProgram = 'Pemeriksaan Laboratorium Pasien';


    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public string $regNoRef;

    public array $dataDaftarTxn;
    public array $dataDaftarTxnLuar;
    public array $dataDaftarTxnHeader;
    public array $dataPasien;




    public bool $isOpenRekamMedisLaborat;


    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////

    // Layanan RJ/RI/UGD
    public function openModalLayanan($txnNo = null, $regNo = null): void
    {

        $this->isOpenRekamMedisLaborat = true;

        $dataDaftarTxnHeader  = collect(DB::select("select distinct a.emp_id,a.checkup_no,checkup_date,a.reg_no,reg_name,a.dr_id,dr_name,'dr. KRISTINA DYAH LESTARI, Sp. PK' as dr_penanggungjawab,sex,birth_date,c.address,emp_name,waktu_selesai_pelayanan,checkup_kesimpulan
        from lbtxn_checkuphdrs a,
        rsmst_pasiens c,
        rsmst_doctors f,
        immst_employers g
        
        where a.dr_id=f.dr_id
        and a.emp_id=g.emp_id
        and a.reg_no=c.reg_no
        and a.checkup_no =:cno", ['cno' => $txnNo]))->first();
        $this->dataDaftarTxnHeader = collect($dataDaftarTxnHeader)->toArray();


        $dataDaftarTxn  = DB::select("select a.emp_id,a.checkup_no,checkup_date,a.reg_no,reg_name,a.dr_id,dr_name,sex,birth_date,c.address,emp_name,app_seq,clab_desc,
        b.clabitem_id,('  '||clabitem_desc)clabitem_desc,checkup_kesimpulan,
        normal_f,normal_m,lab_result,item_seq,
        unit_desc,unit_convert,
        item_code,high_limit_m,high_limit_f,low_limit_m,low_limit_f,normal_m,normal_f,
        lowhigh_status,lab_result_status,
        to_char(checkup_date,'dd/mm/yyyy')checkup_date1x,WAKTU_SELESAI_PELAYANAN,
        
        
        (SELECT count(*)
        FROM lbtxn_checkupdtls z,LBMST_CLABITEMS x 
        where a.checkup_no=z.checkup_no 
        and z.clabitem_id=x.clabitem_id  
        
        and x.LOW_LIMIT_K is not null
        and x.HIGH_LIMIT_K is not null
        and to_number(lab_result)<=to_number(LOW_LIMIT_K))+
        (SELECT count(*)
        FROM lbtxn_checkupdtls z,LBMST_CLABITEMS x 
        where a.checkup_no=z.checkup_no 
        and z.clabitem_id=x.clabitem_id  
        
        and x.LOW_LIMIT_K is not null
        and x.HIGH_LIMIT_K is not null
        and to_number(lab_result)>=to_number(HIGH_LIMIT_K))
        K_1
        
        
        
        from lbtxn_checkuphdrs a,lbtxn_checkupdtls b,
        rsmst_pasiens c,lbmst_clabitems d,
        lbmst_clabs e,rsmst_doctors f,
        immst_employers g
        
        where a.checkup_no=b.checkup_no
        and d.clab_id=e.clab_id
        and a.dr_id=f.dr_id
        and a.emp_id=g.emp_id
        and a.reg_no=c.reg_no
        and b.clabitem_id=d.clabitem_id
        and a.checkup_no =:cno
        and nvl(hidden_status,'N')='N'
        order by app_seq,item_seq,clabitem_desc", ['cno' => $txnNo]);
        $this->dataDaftarTxn = $dataDaftarTxn;


        $dataDaftarTxnLuar  = DB::select("select a.emp_id,a.checkup_no,checkup_date,a.reg_no,reg_name,a.dr_id,dr_name,sex,birth_date,emp_name,
        ('  '||labout_desc)labout_desc,labout_result,labout_normal
        from lbtxn_checkuphdrs a,lbtxn_checkupoutdtls b,
        rsmst_pasiens c,rsmst_doctors d,
        immst_employers e
        
        where a.checkup_no=b.checkup_no
        and a.dr_id=d.dr_id
        and a.emp_id=e.emp_id
        and a.reg_no=c.reg_no
        and a.checkup_no =:cno
        order by checkup_no,labout_dtl,labout_desc", ['cno' => $txnNo]);
        $this->dataDaftarTxnLuar = $dataDaftarTxnLuar;



        // dd($this->dataDaftarTxn);
        if (isset($regNo)) {
            $this->setDataPasien($regNo);
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
        $this->isOpenRekamMedisLaborat = false;
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
        $query = DB::table('rsview_checkups')
            ->select(
                DB::raw("to_char(checkup_date,'dd/mm/yyyy hh24:mi:ss') AS checkup_date"),
                DB::raw("to_number(to_char(checkup_date,'yyyymmddhh24miss')) AS checkup_date1"),
                'checkup_no',
                'reg_no',
                'reg_name',
                'sex',
                'birth_date',
                'address',
                'checkup_status',
                'checkup_rjri',
                DB::raw(" (select string_agg(clabitem_desc) from lbtxn_checkupdtls a,lbmst_clabitems b 
                where a.clabitem_id=b.clabitem_id 
                and checkup_no=rsview_checkups.checkup_no
                and a.price is not null) AS checkup_dtl_pasien
                
                ")

            )
            ->where('reg_no', $this->regNoRef)
            ->orderBy('checkup_date1',  'desc')
            ->orderBy('checkup_status',  'desc');


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
            'livewire.emr.laborat.laborat',
            [
                'myQueryData' => $query->paginate(3),
                'myQueryIdentitas' => $queryIdentitas
            ]


        );
    }
    // select data end////////////////


}
