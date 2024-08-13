<?php

namespace App\Http\Livewire\PendaftaranMandiriPasienPoli;

use Livewire\Component;
use App\Models\Pasien;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\WithPagination;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;

class PendaftaranMandiriPasienPoli extends Component
{
    use WithPagination;

    //  table data////////////////
    public $regNo;
    public $dataPasien = [
        "regNo" => "",
        "regName" => "",
        "sex" => "",
        "birthDate" => "",
        "thn" => "",
        "birthPlace" => "",
        "maritalStatus" => "",
        "address" => ""
    ];
    public $dataJadwalPoli;
    public $klaimType = "UM";
    public $hariIni = 1;

    public $steperStatus = 1;

    public $dataDaftarPasienPoli = [
        "regNo" => "",
        "regName" => "",
        "sex" => "",
        "birthDate" => "",
        "thn" => "",
        "birthPlace" => "",
        "maritalStatus" => "",
        "address" => "",
        "drId" => "",
        "drName" => "",
        "poliId" => "",
        "poliDesc" => "",
        "klaimId" => "",
        "klaimDesc" => "",
        "rjDate" => "",
        "rjNo" => "",
        "shift" => "",
        "noAntrian" => "",
        "noBooking" => "",
        "slCodeFrom" => "02",
        "passStatus" => "O",
        "rjStatus" => "A",
        "txnStatus" => "A",
        "ermStatus" => "A",
    ];




    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////





    // resert input private////////////////
    private function resetInputFields(): void
    {
        $this->reset([
            'dataPasien',
            'dataDaftarPasienPoli',
            'steperStatus',
            'klaimType',
            'regNo',

        ]);
    }




    // Find data from table start////////////////
    private function findData($value)
    {
        $findData = Pasien::find($value);
        return $findData;
    }

    private function findDataJadwalPoli($value)
    {
        // $findData = MasterJadwalPoli::select(
        //     'scmst_scpolis.dr_id as dr_id',
        //     'rsmst_doctors.dr_name as dr_name',
        //     'scmst_scpolis.sc_poli_ket as sc_poli_ket',
        //     'scmst_scpolis.poli_id as poli_id',
        //     'rsmst_polis.poli_desc as poli_desc',

        // )
        //     ->Join('rsmst_doctors', 'rsmst_doctors.dr_id', 'scmst_scpolis.dr_id')
        //     ->Join('rsmst_polis', 'rsmst_polis.poli_id', 'scmst_scpolis.poli_id')
        //     ->Where('day_id', $value)
        //     ->Where('sc_poli_status_', 1)
        //     ->orderBy('scmst_scpolis.no_urut', 'ASC')
        //     ->orderBy('scmst_scpolis.poli_id', 'ASC')
        //     ->get();
        $sql = "select a.dr_id as dr_id,
            b.dr_name as dr_name,
            nvl(a.sc_poli_ket,'-') as sc_poli_ket,
            a.poli_id as poli_id,
            c.poli_desc as poli_desc 

            from scmst_scpolis a, rsmst_doctors b,rsmst_polis c
            where day_id='$value'
            and sc_poli_status_=1
            and a.dr_id=b.dr_id
            and a.poli_id=c.poli_id
            order by a.no_urut,a.poli_id";

        $findData = DB::select($sql);
        return $findData;
    }


    // Find data from table end////////////////

    // add SteperStatus number
    public function counterSteper()
    {

        if ($this->dataPasien["regNo"] !== "") {

            if ($this->steperStatus == 1) {
                $this->steperStatus++;

                // cariHariIni
                $hariIniHariApa = strtoupper(Carbon::now()->isoFormat('dddd'));
                $sql = "select day_id 
                from scmst_scdays
                where day_desc=:dayDesc";
                $findDataHariIni = DB::scalar($sql, ["dayDesc" => $hariIniHariApa]);
                $this->hariIni = $findDataHariIni;


                $this->cariDataJadwalPoli($this->hariIni);
            }
        } else {
            $this->emit('toastr-error', "Data Pasien tidak ditemukan, tempelkan kartu pasien anda ke mesin pemindai.");
        }
    }



    // logic stepper 1 start///// cari data pasien / Jadwal Poli if not resert///////////
    private function cariDataPasien($id)
    {

        $pasien = $this->findData($id);
        if ($pasien) {
            $this->dataPasien["regNo"] = $pasien->reg_no;
            $this->dataPasien["regName"] = $pasien->reg_name;
            $this->dataPasien["sex"] = $pasien->sex;
            $this->dataPasien["birthDate"] = $pasien->birth_date;
            $this->dataPasien["thn"] = $pasien->thn;
            $this->dataPasien["birthPlace"] = $pasien->birth_place;
            $this->dataPasien["maritalStatus"] = $pasien->marital_status;
            $this->dataPasien["address"] = $pasien->address;
        } else {
            $this->resetInputFields();
            $this->emit('toastr-error', "Data Pasien dgn No Reg " . $id . " tidak ditemukan.");
        }
    }

    private function cariDataJadwalPoli($day): void
    {

        $jadwalPoli = $this->findDataJadwalPoli($day);
        $this->dataJadwalPoli = $jadwalPoli;
    }

    public function updatedRegNo(): void
    {
        $this->cariDataPasien($this->regNo);
    }
    // logic stepper 1 end////////////////

    // logic stepper 2 start////////////////
    private function updateDataDaftarPasien(): void
    {
        $this->dataDaftarPasienPoli["regNo"] = $this->dataPasien["regNo"];
        $this->dataDaftarPasienPoli["regName"] = $this->dataPasien["regName"];
        $this->dataDaftarPasienPoli["sex"] = $this->dataPasien["sex"];
        $this->dataDaftarPasienPoli["birthDate"] = $this->dataPasien["birthDate"];
        $this->dataDaftarPasienPoli["thn"] = $this->dataPasien["thn"];
        $this->dataDaftarPasienPoli["birthPlace"] = $this->dataPasien["birthPlace"];
        $this->dataDaftarPasienPoli["maritalStatus"] = $this->dataPasien["maritalStatus"];
        $this->dataDaftarPasienPoli["address"] = $this->dataPasien["address"];
    }

    public function setDataPoli($poliId, $poliDesc, $drId, $drName, $klaimType): void
    {
        $this->updateDataDaftarPasien();

        $this->dataDaftarPasienPoli["poliId"] = $poliId;
        $this->dataDaftarPasienPoli["poliDesc"] = $poliDesc;
        $this->dataDaftarPasienPoli["drId"] = $drId;
        $this->dataDaftarPasienPoli["drName"] = $drName;
        $this->dataDaftarPasienPoli["klaimId"] = $klaimType;

        $this->steperStatus++;
    }
    // logic stepper 2 end////////////////

    public function rjNoMax()
    {
        // SetTanggal
        $this->dataDaftarPasienPoli["rjDate"] = Carbon::now();
        $tglNoantrian = Carbon::now()->format('dmY');


        //SetNoBooking
        $this->dataDaftarPasienPoli["noBooking"] = Carbon::now()->format('YmdHis') . 'RS';

        // rjNoMax
        $sql = "select nvl(max(rj_no)+1,1) rjno_max from rstxn_rjhdrs";
        $findDataRjNo = DB::scalar($sql);
        $this->dataDaftarPasienPoli["rjNo"] = $findDataRjNo;

        // noUrutAntrian
        $sql = "select count(*) no_antrian 
		from rstxn_rjhdrs 
        where dr_id=:drId
        and to_char(rj_date,'ddmmyyyy')=:tgl
        and klaim_id!='KR'";
        $findDataNoUrut = DB::scalar($sql, ["tgl" => $tglNoantrian, "drId" => $this->dataDaftarPasienPoli["drId"]]);

        if ($findDataNoUrut == 0) {
            $noAntrian = 4;
        } else if ($findDataNoUrut == 1) {
            $noAntrian = 5;
        } else if ($findDataNoUrut == 2) {
            $noAntrian = 6;
        } else if ($findDataNoUrut > 2) {
            $noAntrian = $findDataNoUrut + 3 + 1;
        }

        $this->dataDaftarPasienPoli["noAntrian"] = $noAntrian;



        // insert into table transaksi
        DB::table('rstxn_rjhdrs')->insert([
            'rj_no' => $this->dataDaftarPasienPoli["rjNo"],
            'reg_no' => $this->dataDaftarPasienPoli["regNo"],
            'rj_date' => $this->dataDaftarPasienPoli["rjDate"],
            'sl_codefrom' => $this->dataDaftarPasienPoli["slCodeFrom"],
            'pass_status' => $this->dataDaftarPasienPoli["passStatus"],
            'klaim_id' => $this->dataDaftarPasienPoli["klaimId"],
            'poli_id' => $this->dataDaftarPasienPoli["poliId"],
            'dr_id' => $this->dataDaftarPasienPoli["drId"],
            'shift' => $this->dataDaftarPasienPoli["shift"],
            'rj_status' => $this->dataDaftarPasienPoli["rjStatus"],
            'txn_status' => $this->dataDaftarPasienPoli["txnStatus"],
            'no_antrian' => $this->dataDaftarPasienPoli["noAntrian"],
            'nobooking' => $this->dataDaftarPasienPoli["noBooking"]

        ]);


        // cetak PDF
        $data = [
            'dataDaftarPasienPoli' => $this->dataDaftarPasienPoli

        ];

        $pdfContent = PDF::loadView('livewire.pendaftaran-mandiri-pasien-poli.cetak-tiket', $data)->output();

        $this->resetInputFields();
        $this->emit('toastr-success', "Data sudah tersimpan.");

        return response()->streamDownload(
            fn () => print($pdfContent),
            "filename.pdf"
        );
    }
    // logic stepper 2 end////////////////















    // select data start////////////////
    public function render()
    {

        $this->cariDataJadwalPoli($this->hariIni);


        return view(
            'livewire.pendaftaran-mandiri-pasien-poli.pendaftaran-mandiri-pasien-poli',
            [
                'myTitle' => 'Pendaftaran Mandiri',
                'mySnipt' => 'Pasien dapat mendaftar secara mandiri pada setiap poli',
                'myProgram' => 'Poli',
            ]
        );
    }
    // select data end////////////////
}
