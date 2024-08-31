<?php

namespace App\Http\Livewire\RJ\DaftarRJx\FormEntryDaftarRJx;

use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Traits\customErrorMessagesTrait;
use Carbon\Carbon;


// use App\Http\Livewire\SatuSehat\Location\Location;
// use App\Http\Traits\BPJS\SatuSehatTrait;
use App\Http\Traits\EmrRJ\EmrRJTrait;

use App\Http\Traits\LOV\LOVDokter\LOVDokterTrait;
use App\Http\Traits\LOV\LOVPasien\LOVPasienTrait;

use Livewire\Component;

class FormEntryDaftarRJx extends Component
{
    use EmrRJTrait, LOVDokterTrait, LOVPasienTrait;
    // listener from blade////////////////
    protected $listeners = [];

    public string $rjNoRef;
    public bool $rjStatusRef = false;
    public string $isOpenMode = 'insert';

    public array $FormEntry = [];

    public array $jenisKlaim = [
        'JenisKlaimId' => 'UM',
        'JenisKlaimDesc' => 'UMUM',
        'JenisKlaimOptions' => [
            ['JenisKlaimId' => 'UM', 'JenisKlaimDesc' => 'UMUM'],
            ['JenisKlaimId' => 'JM', 'JenisKlaimDesc' => 'BPJS'],
            ['JenisKlaimId' => 'JML', 'JenisKlaimDesc' => 'Asuransi Lain'],
        ]
    ];


    // LOV Nested
    public array $pasien;
    public array $dokter;
    // LOV Nested





    // rules///////////////////
    protected $rules = [
        'FormEntry.rjDate' => 'bail|required|date_format:d/m/Y H:i:s',
        'FormEntry.rjNo' => 'bail|required',
        'FormEntry.passStatus' => '',
        'FormEntry.noAntrian' => 'bail|required',
        'FormEntry.noBooking' => 'bail|required',

        'FormEntry.regNo' => 'bail|required|exists:rsmst_pasiens,reg_no',

        'FormEntry.drId' => 'bail|required|exists:rsmst_doctors,dr_id',
        'FormEntry.drDesc' => 'bail|required',

        'FormEntry.poliId' => 'bail|required|exists:rsmst_polis,poli_id',
        'FormEntry.poliDesc' => 'bail|required',

        'FormEntry.klaimId' => 'bail|required|exists:rsmst_klaimtypes,klaim_id',

        'FormEntry.kddrbpjs' => '',
        'FormEntry.kdpolibpjs' => '',

        'FormEntry.rjStatus' => 'bail|required|in:A,L,F,I',
        'FormEntry.txnStatus' => 'bail|required|in:A,L,F,H',
        'FormEntry.ermStatus' => 'bail|required|in:A,L,F',
    ];

    protected $validationAttributes = [
        'FormEntry.rjDate' => 'Tanggal Rawat Jalan',
        'FormEntry.rjNo' => 'No Rawat Jalan',
        'FormEntry.passStatus' => 'Status Pasien Baru / Lama',
        'FormEntry.noAntrian' => 'Nomer Antrian',
        'FormEntry.noBooking' => 'Nomer Booking',

        'FormEntry.regNo' => 'Reg No',

        'FormEntry.drId' => 'Kode Dokter',
        'FormEntry.drDesc' => 'Nama Dokter',

        'FormEntry.poliId' => 'Kode Poli',
        'FormEntry.poliDesc' => 'Nama Poli',

        'FormEntry.klaimId' => 'Klaim',


        'FormEntry.kddrbpjs' => 'Kode Dokter BPJS',
        'FormEntry.kdpolibpjs' => 'Kode Poli BPJS',

        'FormEntry.rjStatus' => 'Status RJ',
        'FormEntry.txnStatus' => 'Status Transaksi',
        'FormEntry.ermStatus' => 'Status Rekam Medis',
    ];

    protected $messages = [];

    // rules///////////////////





    public function closeModal(): void
    {
        $this->emit('CloseModal');
    }

    private function findData($id): void
    {
        try {
            $findData = $this->findDataRJ($id);
            if (isset($findData['errorMessages'])) {
                // dd($findData['errorMessages']);
                $this->emit('toastr-error', $findData['errorMessages']);
                $this->emit('CloseModal');
                // return;
            }
            $this->FormEntry  = $findData['dataDaftarRJ'];
            $this->syncDataPrimer();
            $this->rjStatusRef = $this->checkRJStatus($id);
        } catch (Exception $e) {
            $this->emit('toastr-error', $e->getMessage());
            $this->emit('CloseModal');
            return;
        }
    }


    private function update($rjNo): void
    {
        // update table trnsaksi
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', '=', $rjNo)
            ->update([
                // 'rj_no' => $this->FormEntry['rjNo'],
                'rj_date' => DB::raw("to_date('" . $this->FormEntry['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"),
                'reg_no' => $this->FormEntry['regNo'],
                'nobooking' => $this->FormEntry['noBooking'],
                'no_antrian' => $this->FormEntry['noAntrian'],

                'klaim_id' => $this->FormEntry['klaimId'],
                'poli_id' => $this->FormEntry['poliId'],
                'dr_id' => $this->FormEntry['drId'],

                'txn_status' => $this->FormEntry['txnStatus'],
                'rj_status' => $this->FormEntry['rjStatus'],
                'erm_status' => $this->FormEntry['ermStatus'],

                'pass_status' => $this->FormEntry['passStatus'],
            ]);


        $this->emit('toastr-success', "Data berhasil diupdate.");
    }

    private function insert(): void
    {
        //insert
        DB::table('rstxn_rjhdrs')
            ->insert([
                'rj_no' => $this->FormEntry['rjNo'],
                'rj_date' => DB::raw("to_date('" . $this->FormEntry['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')"),
                'reg_no' => $this->FormEntry['regNo'],
                'nobooking' => $this->FormEntry['noBooking'],
                'no_antrian' => $this->FormEntry['noAntrian'],

                'klaim_id' => $this->FormEntry['klaimId'],
                'poli_id' => $this->FormEntry['poliId'],
                'dr_id' => $this->FormEntry['drId'],

                'txn_status' => $this->FormEntry['txnStatus'],
                'rj_status' => $this->FormEntry['rjStatus'],
                'erm_status' => $this->FormEntry['ermStatus'],

                'pass_status' => $this->FormEntry['passStatus'],
            ]);

        $this->emit('toastr-success', "Data berhasil dimasukkan.");
    }

    public function store(): void
    {
        // validate
        $this->setDataPrimer();
        $this->validateData();

        // Jika mode data //insert
        if ($this->isOpenMode == 'insert') {
            $this->insert();
            $this->isOpenMode = 'update';
        } else {
            // Jika mode data //update
            $this->update($this->rjNoRef);
        }

        $this->updateJsonRJ($this->FormEntry['rjNo'], $this->FormEntry);
        // $this->closeModal();
    }

    private function setDataPrimer(): void
    {
        // set data primer dilakukan ketika insert
        if ($this->isOpenMode == 'insert') {
            // rjNoMax
            if (!$this->FormEntry['rjNo']) {
                $sql = "select nvl(max(rj_no)+1,1) rjno_max from rstxn_rjhdrs";
                $this->FormEntry['rjNo'] = DB::scalar($sql);
            }


            // Klaim & Kunjungan
            $this->FormEntry['klaimId'] = $this->jenisKlaim['JenisKlaimId'];
            // noBooking
            if (!$this->FormEntry['noBooking']) {
                $this->FormEntry['noBooking'] = Carbon::now()->format('YmdHis') . 'KLIKM';
            }


            // noUrutAntrian (count all kecuali KRonis) if KR 999
            $sql = "select count(*) no_antrian
                    from rstxn_rjhdrs
                    where dr_id=:drId
                    and to_char(rj_date,'ddmmyyyy')=:tgl
                    and klaim_id!='KR'";


            // Antrian ketika data antrian kosong
            if (!$this->FormEntry['noAntrian']) {
                // proses antrian
                if ($this->FormEntry['klaimId'] != 'KR') {
                    $noUrutAntrian = DB::scalar($sql, [
                        "tgl" => Carbon::createFromFormat('d/m/Y H:i:s', $this->FormEntry['rjDate'])->format('dmY'),
                        "drId" => $this->FormEntry['drId']
                    ]);

                    $noAntrian = $noUrutAntrian + 1;
                } else {
                    // Kronis
                    $noAntrian = 999;
                }

                $this->FormEntry['noAntrian'] = $noAntrian;
            }

            // Convert Pasien Baru Lama
            $this->FormEntry['passStatus'] = $this->FormEntry['passStatus'] ? 'N' : 'O';
            $this->FormEntry['txnStatus'] = $this->FormEntry['txnStatus'] ? $this->FormEntry['txnStatus'] : 'A';
            $this->FormEntry['rjStatus'] = $this->FormEntry['rjStatus'] ? $this->FormEntry['rjStatus'] : 'A';
            $this->FormEntry['ermStatus'] = $this->FormEntry['ermStatus'] ? $this->FormEntry['ermStatus'] : 'A';
            $this->FormEntry['userLogs'][] =
                [
                    'userLogDesc' => 'Form Entry Daftar RJ (Insert Data)',
                    'userLog' => auth()->user()->myuser_name,
                    'userLogDate' => Carbon::now()->format('d/m/Y H:i:s')
                ];
        } else {
            // Klaim & Kunjungan
            $this->FormEntry['klaimId'] = $this->jenisKlaim['JenisKlaimId'];
            $this->FormEntry['passStatus'] = $this->FormEntry['passStatus'] ? 'N' : 'O';

            $this->FormEntry['userLogs'][] =
                [
                    'userLogDesc' => 'Form Entry Daftar RJ (Update Data)',
                    'userLog' => auth()->user()->myuser_name,
                    'userLogDate' => Carbon::now()->format('d/m/Y H:i:s')
                ];
        }
    }

    private function syncDataPrimer(): void
    {
        // sync data primer dilakukan ketika update
        if ($this->isOpenMode == 'update') {

            $this->jenisKlaim['JenisKlaimId'] = $this->FormEntry['klaimId'];

            $this->addDokter($this->FormEntry['drId'], $this->FormEntry['drDesc'], $this->FormEntry['poliId'], $this->FormEntry['poliDesc']);


            $findDataPasien = DB::table('rsmst_pasiens')
                ->select(
                    'reg_no',
                    'reg_name',
                    'sex',
                    'address',
                )
                ->where('reg_no', '=', $this->FormEntry['regNo'])
                ->first();
            $this->addPasien($findDataPasien->reg_no, $findDataPasien->reg_name, $findDataPasien->sex, $findDataPasien->address);
        }
    }

    // validate Data RJ//////////////////////////////////////////////////
    private function validateData(): void
    {
        // Proses Validasi///////////////////////////////////////////
        try {

            $this->validate($this->rules, customErrorMessagesTrait::messages(), $this->validationAttributes);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->emit('toastr-error', $e->getMessage());
            $this->validate($this->rules, customErrorMessagesTrait::messages(), $this->validationAttributes);
        }

        $this->resetValidation();
    }

    private function setCurrentDate(): void
    {
        $this->FormEntry['rjDate'] = Carbon::now()->format('d/m/Y H:i:s');
    }

    private function syncDataFormEntry(): void
    {
        // RJ Date Entry ketika Mont
        // Pasien Baru Lama di blade wire:model
        $this->FormEntry['passStatus'] = isset($this->FormEntry['passStatus']) ? ($this->FormEntry['passStatus'] ? true : false) : false;
        $this->FormEntry['regNo'] = isset($this->pasien['regNo']) ? $this->pasien['regNo'] : '';
        $this->FormEntry['drId'] = isset($this->dokter['DokterId']) ? $this->dokter['DokterId'] : '';
        $this->FormEntry['drDesc'] = isset($this->dokter['DokterDesc']) ? $this->dokter['DokterDesc'] : '';
        $this->FormEntry['poliId'] = isset($this->dokter['PoliId']) ? $this->dokter['PoliId'] : '';
        $this->FormEntry['poliDesc'] = isset($this->dokter['PoliDesc']) ? $this->dokter['PoliDesc'] : '';
    }

    private function syncLOV(): void
    {
        $this->dokter = $this->collectingMyDokter;
        $this->pasien = $this->collectingMyPasien;
    }

    public function mount()
    {
        $this->findData($this->rjNoRef);

        if ($this->isOpenMode == 'insert') {
            $this->setCurrentDate();
        }
    }

    public function render()
    {
        // LOV
        $this->syncLOV();
        // FormEntry
        $this->syncDataFormEntry();


        return view('livewire.r-j.daftar-r-jx.form-entry-daftar-r-jx.form-entry-daftar-r-jx');
    }
}
