<?php

namespace App\Http\Traits\MasterPasien;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Exception;


trait MasterPasienTrait
{

    protected function findDataMasterPasien($regNo): array
    {
        try {
            $findData = DB::table('rsmst_pasiens')
                ->select('meta_data_pasien_json')
                ->where('reg_no', $regNo)
                ->first();

            $findDataMetaDataPasienJson = isset($findData->meta_data_pasien_json) ? $findData->meta_data_pasien_json : null;
            // if meta_data_pasien_json = null
            // then cari Data Pasien By Key Collection (exception when no data found)
            //
            // else json_decode
            if ($findDataMetaDataPasienJson) {
                $dataPasien = json_decode($findData->meta_data_pasien_json, true);
            } else {

                $this->emit('toastr-error', "Data tidak dapat di proses json.");

                $dataPasien = [
                    "pasien" => [
                        "pasientidakdikenal" => [],  //status pasien tdak dikenal 0 false 1 true
                        "regNo" => "", //harus diisi
                        "gelarDepan" => "",
                        "regName" => "", //harus diisi / (Sesuai KTP)
                        "gelarBelakang" => "",
                        "namaPanggilan" => "",
                        "tempatLahir" => "", //harus diisi
                        "tglLahir" => "", //harus diisi / (dd/mm/yyyy)
                        "thn" => "",
                        "bln" => "",
                        "hari" => "",
                        "jenisKelamin" => [ //harus diisi (saveid)
                            "jenisKelaminId" => 1,
                            "jenisKelaminDesc" => "Laki-laki",
                            "jenisKelaminOptions" => [
                                ["jenisKelaminId" => 0, "jenisKelaminDesc" => "Tidak diketaui"],
                                ["jenisKelaminId" => 1, "jenisKelaminDesc" => "Laki-laki"],
                                ["jenisKelaminId" => 2, "jenisKelaminDesc" => "Perempuan"],
                                ["jenisKelaminId" => 3, "jenisKelaminDesc" => "Tidak dapat di tentukan"],
                                ["jenisKelaminId" => 4, "jenisKelaminDesc" => "Tidak Mengisi"],
                            ],
                        ],
                        "agama" => [ //harus diisi (save id+nama)
                            "agamaId" => "1",
                            "agamaDesc" => "Islam",
                            "agamaOptions" => [
                                ["agamaId" => 1, "agamaDesc" => "Islam"],
                                ["agamaId" => 2, "agamaDesc" => "Kristen (Protestan)"],
                                ["agamaId" => 3, "agamaDesc" => "Katolik"],
                                ["agamaId" => 4, "agamaDesc" => "Hindu"],
                                ["agamaId" => 5, "agamaDesc" => "Budha"],
                                ["agamaId" => 6, "agamaDesc" => "Konghucu"],
                                ["agamaId" => 7, "agamaDesc" => "Penghayat"],
                                ["agamaId" => 8, "agamaDesc" => "Lain-lain"], //Free text
                            ],
                        ],
                        "statusPerkawinan" => [ //harus diisi (save id)
                            "statusPerkawinanId" => "1",
                            "statusPerkawinanDesc" => "Belum Kawin",
                            "statusPerkawinanOptions" => [
                                ["statusPerkawinanId" => 1, "statusPerkawinanDesc" => "Belum Kawin"],
                                ["statusPerkawinanId" => 2, "statusPerkawinanDesc" => "Kawin"],
                                ["statusPerkawinanId" => 3, "statusPerkawinanDesc" => "Cerai Hidup"],
                                ["statusPerkawinanId" => 4, "statusPerkawinanDesc" => "Cerai Mati"],
                            ],
                        ],
                        "pendidikan" =>  [ //harus diisi (save id)
                            "pendidikanId" => "3",
                            "pendidikanDesc" => "SLTA Sederajat",
                            "pendidikanOptions" => [
                                ["pendidikanId" => 0, "pendidikanDesc" => "Tidak Sekolah"],
                                ["pendidikanId" => 1, "pendidikanDesc" => "SD"],
                                ["pendidikanId" => 2, "pendidikanDesc" => "SLTP Sederajat"],
                                ["pendidikanId" => 3, "pendidikanDesc" => "SLTA Sederajat"],
                                ["pendidikanId" => 4, "pendidikanDesc" => "D1-D3"],
                                ["pendidikanId" => 5, "pendidikanDesc" => "D4"],
                                ["pendidikanId" => 6, "pendidikanDesc" => "S1"],
                                ["pendidikanId" => 7, "pendidikanDesc" => "S2"],
                                ["pendidikanId" => 8, "pendidikanDesc" => "S3"],
                            ],
                        ],
                        "pekerjaan" => [ //harus diisi (save id)
                            "pekerjaanId" => "4",
                            "pekerjaanDesc" => "Pegawai Swasta/ Wiraswasta",
                            "pekerjaanOptions" => [
                                ["pekerjaanId" => 0, "pekerjaanDesc" => "Tidak Bekerja"],
                                ["pekerjaanId" => 1, "pekerjaanDesc" => "PNS"],
                                ["pekerjaanId" => 2, "pekerjaanDesc" => "TNI/POLRI"],
                                ["pekerjaanId" => 3, "pekerjaanDesc" => "BUMN"],
                                ["pekerjaanId" => 4, "pekerjaanDesc" => "Pegawai Swasta/ Wiraswasta"],
                                ["pekerjaanId" => 5, "pekerjaanDesc" => "Lain-Lain"], //Free text
                            ],
                        ],
                        "golonganDarah" => [ //harus diisi (save id+nama) (default Tidak Tahu)
                            "golonganDarahId" => "13",
                            "golonganDarahDesc" => "Tidak Tahu",
                            "golonganDarahOptions" => [
                                ["golonganDarahId" => 1, "golonganDarahDesc" => "A"],
                                ["golonganDarahId" => 2, "golonganDarahDesc" => "B"],
                                ["golonganDarahId" => 3, "golonganDarahDesc" => "AB"],
                                ["golonganDarahId" => 4, "golonganDarahDesc" => "O"],
                                ["golonganDarahId" => 5, "golonganDarahDesc" => "A+"],
                                ["golonganDarahId" => 6, "golonganDarahDesc" => "A-"],
                                ["golonganDarahId" => 7, "golonganDarahDesc" => "B+"],
                                ["golonganDarahId" => 8, "golonganDarahDesc" => "B-"],
                                ["golonganDarahId" => 9, "golonganDarahDesc" => "AB+"],
                                ["golonganDarahId" => 10, "golonganDarahDesc" => "AB-"],
                                ["golonganDarahId" => 11, "golonganDarahDesc" => "O+"],
                                ["golonganDarahId" => 12, "golonganDarahDesc" => "O-"],
                                ["golonganDarahId" => 13, "golonganDarahDesc" => "Tidak Tahu"],
                                ["golonganDarahId" => 14, "golonganDarahDesc" => "O Rhesus"],
                                ["golonganDarahId" => 15, "golonganDarahDesc" => "#"],
                            ],
                        ],

                        "kewarganegaraan" => 'INDONESIA', //Free text (defult INDONESIA)
                        "suku" => 'Jawa', //Free text (defult Jawa)
                        "bahasa" => 'Indonesia / Jawa', //Free text (defult Indonesia / Jawa)
                        "status" => [
                            "statusId" => "1",
                            "statusDesc" => "Aktif / Hidup",
                            "statusOptions" => [
                                ["statusId" => 0, "statusDesc" => "Tidak Aktif / Batal"],
                                ["statusId" => 1, "statusDesc" => "Aktif / Hidup"],
                                ["statusId" => 2, "statusDesc" => "Meninggal"],
                            ]
                        ],
                        "domisil" => [
                            "samadgnidentitas" => [], //status samadgn domisil 0 false 1 true (auto entry = domisil)
                            "alamat" => "", //harus diisi
                            "rt" => "", //harus diisi
                            "rw" => "", //harus diisi
                            "kodepos" => "", //harus diisi
                            "desaId" => "", //harus diisi (Kode data Kemendagri)
                            "kecamatanId" => "", //harus diisi (Kode data Kemendagri)
                            "kotaId" => "3504", //harus diisi (Kode data Kemendagri)
                            "propinsiId" => "35", //harus diisi (Kode data Kemendagri)
                            "desaName" => "", //harus diisi (Kode data Kemendagri)
                            "kecamatanName" => "", //harus diisi (Kode data Kemendagri)
                            "kotaName" => "TULUNGAGUNG", //harus diisi (Kode data Kemendagri)
                            "propinsiName" => "JAWA TIMUR", //harus diisi (Kode data Kemendagri)

                        ],
                        "identitas" => [
                            "nik" => "", //harus diisi
                            "idbpjs" => "",
                            "patientUuid" => "", //UUID SATUSEHAT
                            "pasport" => "", //untuk WNA / WNI yang memiliki passport
                            "alamat" => "", //harus diisi
                            "rt" => "", //harus diisi
                            "rw" => "", //harus diisi
                            "kodepos" => "", //harus diisi
                            "desaId" => "", //harus diisi (Kode data Kemendagri)
                            "kecamatanId" => "", //harus diisi (Kode data Kemendagri)
                            "kotaId" => "3504", //harus diisi (Kode data Kemendagri)
                            "propinsiId" => "35", //harus diisi (Kode data Kemendagri)
                            "desaName" => "", //harus diisi (Kode data Kemendagri)
                            "kecamatanName" => "", //harus diisi (Kode data Kemendagri)
                            "kotaName" => "TULUNGAGUNG", //harus diisi (Kode data Kemendagri)
                            "propinsiName" => "JAWA TIMUR", //harus diisi (Kode data Kemendagri)
                            "negara" => "ID" //harus diisi (ISO 3166) ID 	IDN 	360 	ISO 3166-2:ID 	.id
                        ],
                        "kontak" => [
                            "kodenegara" => "62", //+(62) Indonesia
                            "nomerTelponSelulerPasien" => "", //+(kode negara) no telp
                            "nomerTelponLain" => "" //+(kode negara) no telp
                        ],
                        "hubungan" => [
                            "namaAyah" => "", //
                            "kodenegaraAyah" => "62", //+(62) Indonesia
                            "nomerTelponSelulerAyah" => "", //+(kode negara) no telp
                            "namaIbu" => "", //
                            "kodenegaraIbu" => "62", //+(62) Indonesia
                            "nomerTelponSelulerIbu" => "", //+(kode negara) no telp

                            "namaPenanggungJawab" => "", // di isi untuk pasien (Tidak dikenal / Hal Lain)
                            "kodenegaraPenanggungJawab" => "62", //+(62) Indonesia
                            "nomerTelponSelulerPenanggungJawab" => "", //+(kode negara) no telp
                            "hubunganDgnPasien" => [
                                "hubunganDgnPasienId" => 5, //Default 5 Kerabat / Saudara
                                "hubunganDgnPasienDesc" => "Kerabat / Saudara",
                                "hubunganDgnPasienOptions" => [
                                    ["hubunganDgnPasienId" => 1, "hubunganDgnPasienDesc" => "Diri Sendiri"],
                                    ["hubunganDgnPasienId" => 2, "hubunganDgnPasienDesc" => "Orang Tua"],
                                    ["hubunganDgnPasienId" => 3, "hubunganDgnPasienDesc" => "Anak"],
                                    ["hubunganDgnPasienId" => 4, "hubunganDgnPasienDesc" => "Suami / Istri"],
                                    ["hubunganDgnPasienId" => 5, "hubunganDgnPasienDesc" => "Kerabaat / Saudara"],
                                    ["hubunganDgnPasienId" => 6, "hubunganDgnPasienDesc" => "Lain-lain"] //Free text
                                ]
                            ]
                        ],

                    ]
                ];

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
                    ->where('reg_no', $regNo)
                    ->first();


                $dataPasien['pasien']['regDate'] = $findData->reg_date;
                $dataPasien['pasien']['regNo'] = $findData->reg_no;
                $dataPasien['pasien']['regName'] = $findData->reg_name;
                $dataPasien['pasien']['identitas']['idbpjs'] = $findData->nokartu_bpjs;
                $dataPasien['pasien']['identitas']['nik'] = $findData->nik_bpjs;
                $dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] = ($findData->sex == 'L') ? 1 : 2;
                $dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] = ($findData->sex == 'L') ? 'Laki-laki' : 'Perempuan';
                $dataPasien['pasien']['tglLahir'] = $findData->birth_date;
                $dataPasien['pasien']['thn'] = $findData->thn;
                $dataPasien['pasien']['bln'] = $findData->bln;
                $dataPasien['pasien']['hari'] = $findData->hari;
                $dataPasien['pasien']['tempatLahir'] = $findData->birth_place;
                $dataPasien['pasien']['golonganDarah']['golonganDarahId'] = '13';
                $dataPasien['pasien']['golonganDarah']['golonganDarahDesc'] = 'Tidak Tahu';
                $dataPasien['pasien']['statusPerkawinan']['statusPerkawinanId'] = '1';
                $dataPasien['pasien']['statusPerkawinan']['statusPerkawinanDesc'] = 'Belum Kawin';

                $dataPasien['pasien']['agama']['agamaId'] = $findData->rel_id;
                $dataPasien['pasien']['agama']['agamaDesc'] = $findData->rel_desc;

                $dataPasien['pasien']['pendidikan']['pendidikanId'] = $findData->edu_id;
                $dataPasien['pasien']['pendidikan']['pendidikanDesc'] = $findData->edu_desc;

                $dataPasien['pasien']['pekerjaan']['pekerjaanId'] = $findData->job_id;
                $dataPasien['pasien']['pekerjaan']['pekerjaanDesc'] = $findData->job_name;


                $dataPasien['pasien']['hubungan']['namaPenanggungJawab'] = $findData->reg_no;
                $dataPasien['pasien']['hubungan']['namaIbu'] = $findData->reg_no;

                $dataPasien['pasien']['identitas']['nik'] = $findData->nik_bpjs;
                $dataPasien['pasien']['identitas']['idBpjs'] = $findData->nokartu_bpjs;


                $dataPasien['pasien']['identitas']['alamat'] = $findData->address;

                $dataPasien['pasien']['identitas']['desaId'] = $findData->des_id;
                $dataPasien['pasien']['identitas']['desaName'] = $findData->des_name;

                $dataPasien['pasien']['identitas']['rt'] = $findData->rt;
                $dataPasien['pasien']['identitas']['rw'] = $findData->rw;
                $dataPasien['pasien']['identitas']['kecamatanId'] = $findData->kec_id;
                $dataPasien['pasien']['identitas']['kecamatanName'] = $findData->kec_name;

                $dataPasien['pasien']['identitas']['kotaId'] = $findData->kab_id;
                $dataPasien['pasien']['identitas']['kotaName'] = $findData->kab_name;

                $dataPasien['pasien']['identitas']['propinsiId'] = $findData->prop_id;
                $dataPasien['pasien']['identitas']['propinsiName'] = $findData->prop_name;

                $dataPasien['pasien']['kontak']['nomerTelponSelulerPasien'] = $findData->phone;

                $dataPasien['pasien']['hubungan']['namaPenanggungJawab'] = $findData->kk;
                $dataPasien['pasien']['hubungan']['namaIbu'] = $findData->nyonya;
            }

            return $dataPasien;
        } catch (Exception $e) {
            dd($e->getMessage());
            return ["errorMessages" => $e->getMessage()];
        }
    }

    protected function checkMasterPasienStatus($regNo): bool
    {
        return false;
    }

    public static function updateJsonMasterPasien($regNo, array $rjArr): void
    {
        DB::table('rsmst_pasiens')
            ->where('reg_no', $regNo)
            ->update([
                'meta_data_pasien_json' => json_encode($rjArr, true),
            ]);
    }
}
