<?php

namespace App\Http\Livewire\EmrRJ\MrRJ\Perencanaan;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\customErrorMessagesTrait;

use Carbon\Carbon;

use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;

class Perencanaan extends Component
{
    use WithPagination;

    // listener from blade////////////////
    protected $listeners = [
        'syncronizeAssessmentPerawatRJFindData' => 'mount',
    ];

    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef;

    // dataDaftarPoliRJ RJ
    public array $dataDaftarPoliRJ = [];

    // data SKDP / perencanaan=>[]
    public array $perencanaan = [
        'terapiTab' => 'Terapi',
        'terapi' => [
            'terapi' => '',
        ],

        'tindakLanjutTab' => 'Tindak Lanjut',
        'tindakLanjut' => [
            'tindakLanjut' => '',
            'keteranganTindakLanjut' => '',
            'tindakLanjutOptions' => [['tindakLanjut' => 'MRS'], ['tindakLanjut' => 'Kontrol'], ['tindakLanjut' => 'Rujuk'], ['tindakLanjut' => 'Perawatan Selesai'], ['tindakLanjut' => 'Lain-lain']],
        ],

        'pengkajianMedisTab' => 'Petugas Medis',
        'pengkajianMedis' => [
            'waktuPemeriksaan' => '',
            'selesaiPemeriksaan' => '',
            'drPemeriksa' => '',
        ],
        // Kontrol pakai program lama

        'rawatInapTab' => 'Rawat Inap',
        'rawatInap' => [
            'noRef' => '',
            'tanggal' => '', //dd/mm/yyyy
            'keterangan' => '',
        ],

        'dischargePlanningTab' => 'Discharge Planning',
        'dischargePlanning' => [
            'pelayananBerkelanjutan' => [
                'pelayananBerkelanjutan' => 'Tidak Ada',
                'pelayananBerkelanjutanOption' => [['pelayananBerkelanjutan' => 'Tidak Ada'], ['pelayananBerkelanjutan' => 'Ada']],
            ],
            'pelayananBerkelanjutanOpsi' => [
                'rawatLuka' => [],
                'dm' => [],
                'ppok' => [],
                'hivAids' => [],
                'dmTerapiInsulin' => [],
                'ckd' => [],
                'tb' => [],
                'stroke' => [],
                'kemoterapi' => [],
            ],

            'penggunaanAlatBantu' => [
                'penggunaanAlatBantu' => 'Tidak Ada',
                'penggunaanAlatBantuOption' => [['penggunaanAlatBantu' => 'Tidak Ada'], ['penggunaanAlatBantu' => 'Ada']],
            ],
            'penggunaanAlatBantuOpsi' => [
                'kateterUrin' => [],
                'ngt' => [],
                'traechotomy' => [],
                'colostomy' => [],
            ],
        ],
    ];
    //////////////////////////////////////////////////////////////////////

    protected $rules = [
        // 'dataDaftarPoliRJ.perencanaan.pengkajianMedis.waktuPemeriksaan' => 'required|date_format:d/m/Y H:i:s',
        // 'dataDaftarPoliRJ.perencanaan.pengkajianMedis.selesaiPemeriksaan' => 'required|date_format:d/m/Y H:i:s'
        'dataDaftarPoliRJ.perencanaan.pengkajianMedis.drPemeriksa' => '',
    ];

    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////
    public function updated($propertyName)
    {
        // dd($propertyName);
        $this->validateOnly($propertyName);
        if ($propertyName != 'activeTabRacikanNonRacikan') {
            $this->store();
        }
    }

    // resert input private////////////////
    private function resetInputFields(): void
    {
        // resert validation
        $this->resetValidation();
        // resert input kecuali
        $this->resetExcept(['rjNoRef']);
    }

    // ////////////////
    // RJ Logic
    // ////////////////

    // validate Data RJ//////////////////////////////////////////////////
    private function validateDataRJ(): void
    {
        // customErrorMessages
        // $messages = customErrorMessagesTrait::messages();
        $messages = [];

        // $rules = [];

        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($this->rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->emit('toastr-error', 'Lakukan Pengecekan kembali Input Data.');
            $this->validate($this->rules, $messages);
        }
    }

    // insert and update record start////////////////
    public function store()
    {
        // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
        $this->setDataPrimer();

        // Validate RJ
        $this->validateDataRJ();

        // Logic update mode start //////////
        $this->updateDataRJ($this->dataDaftarPoliRJ['rjNo']);
        $this->emit('syncronizeAssessmentPerawatRJFindData');
    }

    private function updateDataRJ($rjNo): void
    {
        // update table trnsaksi
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'dataDaftarPoliRJ_json' => json_encode($this->dataDaftarPoliRJ, true),
                'dataDaftarPoliRJ_xml' => ArrayToXml::convert($this->dataDaftarPoliRJ),
            ]);

        $this->emit('toastr-success', 'Perencanaan berhasil disimpan.');
    }
    // insert and update record end////////////////

    private function findData($rjno): void
    {
        $findData = DB::table('rsview_rjkasir')->select('datadaftarpolirj_json', 'vno_sep')->where('rj_no', $rjno)->first();

        $dataDaftarPoliRJ_json = isset($findData->datadaftarpolirj_json) ? $findData->datadaftarpolirj_json : null;
        // if meta_data_pasien_json = null
        // then cari Data Pasien By Key Collection (exception when no data found)
        //
        // else json_decode
        if ($dataDaftarPoliRJ_json) {
            $this->dataDaftarPoliRJ = json_decode($findData->datadaftarpolirj_json, true);

            // jika perencanaan tidak ditemukan tambah variable perencanaan pda array
            if (isset($this->dataDaftarPoliRJ['perencanaan']) == false) {
                $this->dataDaftarPoliRJ['perencanaan'] = $this->perencanaan;
            }
        } else {
            $this->emit('toastr-error', 'Data tidak dapat di proses json.');
            $dataDaftarPoliRJ = DB::table('rsview_rjkasir')
                ->select(
                    DB::raw("to_char(rj_date,'dd/mm/yyyy hh24:mi:ss') AS rj_date"),
                    DB::raw("to_char(rj_date,'yyyymmddhh24miss') AS rj_date1"),
                    'rj_no',
                    'reg_no',
                    'reg_name',
                    'sex',
                    'address',
                    'thn',
                    DB::raw("to_char(birth_date,'dd/mm/yyyy') AS birth_date"),
                    'poli_id',
                    'poli_desc',
                    'dr_id',
                    'dr_name',
                    'klaim_id',
                    // 'entry_id',
                    'shift',
                    'vno_sep',
                    'no_antrian',

                    'nobooking',
                    'push_antrian_bpjs_status',
                    'push_antrian_bpjs_json',
                    'kd_dr_bpjs',
                    'kd_poli_bpjs',
                    'rj_status',
                    'txn_status',
                    'erm_status',
                )
                ->where('rj_no', '=', $rjno)
                ->first();

            $this->dataDaftarPoliRJ = [
                'regNo' => $dataDaftarPoliRJ->reg_no,

                'drId' => $dataDaftarPoliRJ->dr_id,
                'drDesc' => $dataDaftarPoliRJ->dr_name,

                'poliId' => $dataDaftarPoliRJ->poli_id,
                'klaimId' => $dataDaftarPoliRJ->klaim_id,
                'poliDesc' => $dataDaftarPoliRJ->poli_desc,

                'kddrbpjs' => $dataDaftarPoliRJ->kd_dr_bpjs,
                'kdpolibpjs' => $dataDaftarPoliRJ->kd_poli_bpjs,

                'rjDate' => $dataDaftarPoliRJ->rj_date,
                'rjNo' => $dataDaftarPoliRJ->rj_no,
                'shift' => $dataDaftarPoliRJ->shift,
                'noAntrian' => $dataDaftarPoliRJ->no_antrian,
                'noBooking' => $dataDaftarPoliRJ->nobooking,
                'slCodeFrom' => '02',
                'passStatus' => '',
                'rjStatus' => $dataDaftarPoliRJ->rj_status,
                'txnStatus' => $dataDaftarPoliRJ->txn_status,
                'ermStatus' => $dataDaftarPoliRJ->erm_status,
                'cekLab' => '0',
                'kunjunganInternalStatus' => '0',
                'noReferensi' => $dataDaftarPoliRJ->reg_no,
                'postInap' => [],
                'internal12' => '1',
                'internal12Desc' => 'Faskes Tingkat 1',
                'internal12Options' => [
                    [
                        'internal12' => '1',
                        'internal12Desc' => 'Faskes Tingkat 1',
                    ],
                    [
                        'internal12' => '2',
                        'internal12Desc' => 'Faskes Tingkat 2 RS',
                    ],
                ],
                'kontrol12' => '1',
                'kontrol12Desc' => 'Faskes Tingkat 1',
                'kontrol12Options' => [
                    [
                        'kontrol12' => '1',
                        'kontrol12Desc' => 'Faskes Tingkat 1',
                    ],
                    [
                        'kontrol12' => '2',
                        'kontrol12Desc' => 'Faskes Tingkat 2 RS',
                    ],
                ],
                'taskIdPelayanan' => [
                    'taskId1' => '',
                    'taskId2' => '',
                    'taskId3' => $dataDaftarPoliRJ->rj_date,
                    'taskId4' => '',
                    'taskId5' => '',
                    'taskId6' => '',
                    'taskId7' => '',
                    'taskId99' => '',
                ],
                'sep' => [
                    'noSep' => $dataDaftarPoliRJ->vno_sep,
                    'reqSep' => [],
                    'resSep' => [],
                ],
            ];

            // jika perencanaan tidak ditemukan tambah variable perencanaan pda array
            if (isset($this->dataDaftarPoliRJ['perencanaan']) == false) {
                $this->dataDaftarPoliRJ['perencanaan'] = $this->perencanaan;
            }
        }
    }

    // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
    private function setDataPrimer(): void
    {
    }

    public function setWaktuPemeriksaan($myTime)
    {
        $this->dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['waktuPemeriksaan'] = $myTime;
    }

    public function setSelesaiPemeriksaan($myTime)
    {
        $this->dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['selesaiPemeriksaan'] = $myTime;
    }

    private function validateDrPemeriksa()
    {
        // Validasi dulu
        $messages = [];
        $myRules = [
            // 'dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik' => 'required|numeric',
            // 'dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik' => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi' => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas' => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu' => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.tandaVital.spo2' => 'numeric',
            'dataDaftarPoliRJ.pemeriksaan.tandaVital.gda' => 'numeric',

            'dataDaftarPoliRJ.pemeriksaan.nutrisi.bb' => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.nutrisi.tb' => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.nutrisi.imt' => 'required|numeric',
            'dataDaftarPoliRJ.pemeriksaan.nutrisi.lk' => 'numeric',
            'dataDaftarPoliRJ.pemeriksaan.nutrisi.lila' => 'numeric',

            'dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.jamDatang' => 'required|date_format:d/m/Y H:i:s',
        ];
        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($myRules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->emit('toastr-error', 'Anda tidak dapat melakukan TTD-E karena data pemeriksaan belum lengkap.');
            $this->validate($myRules, $messages);
        }
        // Validasi dulu
    }
    public function setDrPemeriksa()
    {
        // $myRoles = json_decode(auth()->user()->roles, true);
        $myUserCodeActive = auth()->user()->myuser_code;
        $myUserNameActive = auth()->user()->myuser_name;
        // $myUserTtdActive = auth()->user()->myuser_ttd_image;

        // Validasi dulu
        // cek apakah data pemeriksaan sudah dimasukkan atau blm
        $this->validateDrPemeriksa();

        if (auth()->user()->hasRole('Dokter')) {
            if ($this->dataDaftarPoliRJ['drId'] == $myUserCodeActive) {
                if (isset($this->dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['drPemeriksa'])) {
                    if (!$this->dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['drPemeriksa']) {
                        $this->dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['drPemeriksa'] = isset($this->dataDaftarPoliRJ['drDesc']) ? ($this->dataDaftarPoliRJ['drDesc'] ? $this->dataDaftarPoliRJ['drDesc'] : 'Dokter pemeriksa') : 'Dokter pemeriksa-';
                    }
                } else {
                    $this->dataDaftarPoliRJ['perencanaan']['pengkajianMedisTab'] = 'Pengkajian Medis';
                    $this->dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['drPemeriksa'] = isset($this->dataDaftarPoliRJ['drDesc']) ? ($this->dataDaftarPoliRJ['drDesc'] ? $this->dataDaftarPoliRJ['drDesc'] : 'Dokter pemeriksa') : 'Dokter pemeriksa-';
                }
                $this->store();
            } else {
                $this->emit('toastr-error', 'Anda tidak dapat melakukan TTD-E karena Bukan Pasien ' . $myUserNameActive);
            }
        } else {
            $this->emit('toastr-error', 'Anda tidak dapat melakukan TTD-E karena User Role ' . $myUserNameActive . ' Bukan Dokter');
        }
    }

    // /////////////////eresep open////////////////////////
    public bool $isOpenEresepRJ = false;
    public string $isOpenModeEresepRJ = 'insert';

    public function openModalEresepRJ(): void
    {
        $this->isOpenEresepRJ = true;
        $this->isOpenModeEresepRJ = 'insert';
    }

    public function closeModalEresepRJ(): void
    {
        $this->isOpenEresepRJ = false;
        $this->isOpenModeEresepRJ = 'insert';
    }

    public string $activeTabRacikanNonRacikan = 'NonRacikan';
    public array $EmrMenuRacikanNonRacikan = [
        [
            'ermMenuId' => 'NonRacikan',
            'ermMenuName' => 'NonRacikan',
        ],
        [
            'ermMenuId' => 'Racikan',
            'ermMenuName' => 'Racikan',
        ],
    ];

    public function simpanTerapi(): void
    {
        $eresep = '' . PHP_EOL;
        if (isset($this->dataDaftarPoliRJ['eresep'])) {

            foreach ($this->dataDaftarPoliRJ['eresep'] as $key => $value) {
                // NonRacikan
                $catatanKhusus = ($value['catatanKhusus']) ? ' (' . $value['catatanKhusus'] . ')' : '';
                $eresep .=  'R/' . ' ' . $value['productName'] . ' | No. ' . $value['qty'] . ' | S ' .  $value['signaX'] . 'dd' . $value['signaHari'] . $catatanKhusus . PHP_EOL;
            }
        }

        $eresepRacikan = '' . PHP_EOL;
        if (isset($this->dataDaftarPoliRJ['eresepRacikan'])) {
            // Racikan
            foreach ($this->dataDaftarPoliRJ['eresepRacikan'] as $key => $value) {
                $jmlRacikan = ($value['qty']) ? 'Jml Racikan ' . $value['qty'] . ' | ' . $value['catatan'] . ' | S ' . $value['catatanKhusus'] . PHP_EOL : '';
                $dosis = isset($value['dosis']) ? ($value['dosis'] ? $value['dosis'] : '') : '';
                $eresepRacikan .= $value['noRacikan'] . '/ ' . $value['productName'] . ' - ' . $dosis .  PHP_EOL . $jmlRacikan;
            };
        }
        $this->dataDaftarPoliRJ['perencanaan']['terapi']['terapi'] = $eresep . $eresepRacikan;

        $this->store();
        $this->closeModalEresepRJ();
    }

    public function setstatusPRB()
    {

        // status PRB
        if (isset($this->dataDaftarPoliRJ['statusPRB']['penanggungJawab']['statusPRB'])) {
            if ($this->dataDaftarPoliRJ['statusPRB']['penanggungJawab']['statusPRB']) {
                $statusPRB = 0;
            } else {
                $statusPRB = 1;
            }
        } else {
            $statusPRB = 1;
        }

        // setStatusPRB
        $this->dataDaftarPoliRJ['statusPRB']['penanggungJawab'] = [
            'statusPRB' => $statusPRB,
            'userLog' => auth()->user()->myuser_name,
            'userLogDate' => Carbon::now()->format('d/m/Y H:i:s'),
            'userLogCode' => auth()->user()->myuser_code
        ];

        // simpan
        $this->store();
    }
    // /////////////////////////////////////////

    // when new form instance
    public function mount()
    {
        $this->findData($this->rjNoRef);
    }

    // select data start////////////////
    public function render()
    {
        return view('livewire.emr-r-j.mr-r-j.perencanaan.perencanaan', [
            // 'RJpasiens' => $query->paginate($this->limitPerPage),
            'myTitle' => 'Perencanaan',
            'mySnipt' => 'Rekam Medis Pasien',
            'myProgram' => 'Pasien Rawat Jalan',
        ]);
    }
    // select data end////////////////
}
