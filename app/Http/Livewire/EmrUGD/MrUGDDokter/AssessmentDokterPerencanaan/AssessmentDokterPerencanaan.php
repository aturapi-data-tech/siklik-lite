<?php

namespace App\Http\Livewire\EmrUGD\MrUGDDokter\AssessmentDokterPerencanaan;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\customErrorMessagesTrait;
use App\Http\Traits\EmrUGD\EmrUGDTrait;

use Carbon\Carbon;

use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;


class AssessmentDokterPerencanaan extends Component
{
    use WithPagination, EmrUGDTrait;

    // listener from blade////////////////
    protected $listeners = [
        'storeAssessmentDokterUGD' => 'store',
        'storeAssessmentDokterUGDPerencanaan' => 'store',
        'syncronizeAssessmentDokterUGDFindData' => 'mount',
    ];


    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $rjNoRef;

    // dataDaftarUgd RJ
    public array $dataDaftarUgd = [];

    // data SKDP / perencanaan=>[]
    public array $perencanaan =
    [
        "terapiTab" => "Terapi",
        "terapi" => [
            "terapi" => ""
        ],

        "tindakLanjutTab" => "Tindak Lanjut",
        "tindakLanjut" => [
            "tindakLanjut" => "",
            "keteranganTindakLanjut" => "",
            "tindakLanjutOptions" => [
                ["tindakLanjut" => "MRS"],
                ["tindakLanjut" => "KRS"],
                ["tindakLanjut" => "APS"],
                ["tindakLanjut" => "Rujuk"],
                ["tindakLanjut" => "Lain-lain"],
            ],

        ],

        "pengkajianMedisTab" => "Petugas Medis",
        "pengkajianMedis" => [
            "waktuPemeriksaan" => "",
            "selesaiPemeriksaan" => "",
            "drPemeriksa" => "",
        ],
        // Kontrol pakai program lama

        "rawatInapTab" => "Rawat Inap",
        "rawatInap" => [
            "noRef" => "",
            "tanggal" => "", //dd/mm/yyyy
            "keterangan" => "",
        ],

        "dischargePlanningTab" => "Discharge Planning",
        "dischargePlanning" => [
            "pelayananBerkelanjutan" => [
                "pelayananBerkelanjutan" => "Tidak Ada",
                "pelayananBerkelanjutanOption" => [
                    ["pelayananBerkelanjutan" => "Tidak Ada"],
                    ["pelayananBerkelanjutan" => "Ada"],
                ],
            ],
            "pelayananBerkelanjutanOpsi" => [
                "rawatLuka" => [],
                "dm" => [],
                "ppok" => [],
                "hivAids" => [],
                "dmTerapiInsulin" => [],
                "ckd" => [],
                "tb" => [],
                "stroke" => [],
                "kemoterapi" => [],
            ],

            "penggunaanAlatBantu" => [
                "penggunaanAlatBantu" => "Tidak Ada",
                "penggunaanAlatBantuOption" => [
                    ["penggunaanAlatBantu" => "Tidak Ada"],
                    ["penggunaanAlatBantu" => "Ada"],
                ],
            ],
            "penggunaanAlatBantuOpsi" => [
                "kateterUrin" => [],
                "ngt" => [],
                "traechotomy" => [],
                "colostomy" => [],
            ],
        ]
    ];
    //////////////////////////////////////////////////////////////////////


    protected $rules = [

        'dataDaftarUgd.perencanaan.pengkajianMedis.waktuPemeriksaan' => 'required|date_format:d/m/Y H:i:s',
        'dataDaftarUgd.perencanaan.pengkajianMedis.selesaiPemeriksaan' => 'required|date_format:d/m/Y H:i:s'

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
        $this->resetExcept([
            'rjNoRef'
        ]);
    }





    // ////////////////
    // RJ Logic
    // ////////////////


    // validate Data RJ//////////////////////////////////////////////////
    private function validateDataUgd(): void
    {
        // customErrorMessages
        // $messages = customErrorMessagesTrait::messages();
        $messages = [];

        // Proses Validasi///////////////////////////////////////////
        try {
            $this->validate($this->rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $this->emit('toastr-error', "Lakukan Pengecekan kembali Input Data.");
            $this->validate($this->rules, $messages);
        }
    }


    // insert and update record start////////////////
    public function store()
    {
        // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
        $this->setDataPrimer();

        // Validate RJ
        $this->validateDataUgd();

        // Logic update mode start //////////
        $this->updateDataUgd($this->dataDaftarUgd['rjNo']);

        $this->emit('syncronizeAssessmentDokterUGDFindData');
    }

    private function updateDataUgd($rjNo): void
    {
        $p_status = (isset($this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['tingkatKegawatan']) ?
            ($this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['tingkatKegawatan'] ?
                $this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['tingkatKegawatan']
                : 'P0')
            : 'P0');

        $waktu_pasien_datang = (isset($this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang']) ?
            ($this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang'] ?
                $this->dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang']
                : Carbon::now()->format('d/m/Y H:i:s'))
            : Carbon::now()->format('d/m/Y H:i:s'));

        $waktu_pasien_dilayani = (isset($this->dataDaftarUgd['perencanaan']['pengkajianMedis']['waktuPemeriksaan']) ?
            ($this->dataDaftarUgd['perencanaan']['pengkajianMedis']['waktuPemeriksaan'] ?
                $this->dataDaftarUgd['perencanaan']['pengkajianMedis']['waktuPemeriksaan']
                : Carbon::now()->format('d/m/Y H:i:s'))
            : Carbon::now()->format('d/m/Y H:i:s'));

        // update table trnsaksi
        DB::table('rstxn_ugdhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'datadaftarugd_json' => json_encode($this->dataDaftarUgd, true),
                'datadaftarugd_xml' => ArrayToXml::convert($this->dataDaftarUgd),
                'p_status' => $p_status,
                'waktu_pasien_datang' => DB::raw("to_date('" . $waktu_pasien_datang . "','dd/mm/yyyy hh24:mi:ss')"),
                'waktu_pasien_dilayani' => DB::raw("to_date('" . $waktu_pasien_dilayani . "','dd/mm/yyyy hh24:mi:ss')"),
            ]);

        $this->emit('toastr-success', "Perencanaan berhasil disimpan.");
    }
    // insert and update record end////////////////


    private function findData($rjno): void
    {

        $this->dataDaftarUgd = $this->findDataUGD($rjno);
        // dd($this->dataDaftarUgd);
        // jika perencanaan tidak ditemukan tambah variable perencanaan pda array
        if (isset($this->dataDaftarUgd['perencanaan']) == false) {
            $this->dataDaftarUgd['perencanaan'] = $this->perencanaan;
        }
    }

    // set data RJno / NoBooking / NoAntrian / klaimId / kunjunganId
    private function setDataPrimer(): void
    {
    }

    public function setWaktuPemeriksaan($myTime)
    {
        $this->dataDaftarUgd['perencanaan']['pengkajianMedis']['waktuPemeriksaan'] = $myTime;
        $this->store();
    }

    public function setSelesaiPemeriksaan($myTime)
    {
        $this->dataDaftarUgd['perencanaan']['pengkajianMedis']['selesaiPemeriksaan'] = $myTime;
        $this->store();
    }

    private function validateDrPemeriksa()
    {
        // Validasi dulu
        $messages = [];
        $myRules = [
            // 'dataDaftarUgd.pemeriksaan.tandaVital.sistolik' => 'required|numeric',
            // 'dataDaftarUgd.pemeriksaan.tandaVital.distolik' => 'required|numeric',
            'dataDaftarUgd.pemeriksaan.tandaVital.frekuensiNadi' => 'required|numeric',
            'dataDaftarUgd.pemeriksaan.tandaVital.frekuensiNafas' => 'required|numeric',
            'dataDaftarUgd.pemeriksaan.tandaVital.suhu' => 'required|numeric',
            'dataDaftarUgd.pemeriksaan.tandaVital.spo2' => 'numeric',
            'dataDaftarUgd.pemeriksaan.tandaVital.gda' => 'numeric',

            'dataDaftarUgd.pemeriksaan.nutrisi.bb' => 'required|numeric',
            'dataDaftarUgd.pemeriksaan.nutrisi.tb' => 'required|numeric',
            'dataDaftarUgd.pemeriksaan.nutrisi.imt' => 'required|numeric',
            'dataDaftarUgd.pemeriksaan.nutrisi.lk' => 'numeric',
            'dataDaftarUgd.pemeriksaan.nutrisi.lila' => 'numeric',

            'dataDaftarUgd.anamnesa.pengkajianPerawatan.jamDatang' => 'required|date_format:d/m/Y H:i:s',
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
            if ($this->dataDaftarUgd['drId'] == $myUserCodeActive) {
                if (isset($this->dataDaftarUgd['perencanaan']['pengkajianMedis']['drPemeriksa'])) {
                    if (!$this->dataDaftarUgd['perencanaan']['pengkajianMedis']['drPemeriksa']) {
                        $this->dataDaftarUgd['perencanaan']['pengkajianMedis']['drPemeriksa'] = isset($this->dataDaftarUgd['drDesc']) ? ($this->dataDaftarUgd['drDesc'] ? $this->dataDaftarUgd['drDesc'] : 'Dokter pemeriksa') : 'Dokter pemeriksa-';
                    }
                } else {
                    $this->dataDaftarUgd['perencanaan']['pengkajianMedisTab'] = 'Pengkajian Medis';
                    $this->dataDaftarUgd['perencanaan']['pengkajianMedis']['drPemeriksa'] = isset($this->dataDaftarUgd['drDesc']) ? ($this->dataDaftarUgd['drDesc'] ? $this->dataDaftarUgd['drDesc'] : 'Dokter pemeriksa') : 'Dokter pemeriksa-';
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
    public bool $isOpenEresepUGD = false;
    public string $isOpenModeEresepUGD = 'insert';

    public function openModalEresepUGD(): void
    {
        $this->isOpenEresepUGD = true;
        $this->isOpenModeEresepUGD = 'insert';
    }

    public function closeModalEresepUGD(): void
    {
        $this->isOpenEresepUGD = false;
        $this->isOpenModeEresepUGD = 'insert';
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
        if (isset($this->dataDaftarUgd['eresep'])) {

            foreach ($this->dataDaftarUgd['eresep'] as $key => $value) {
                // NonRacikan
                $catatanKhusus = ($value['catatanKhusus']) ? ' (' . $value['catatanKhusus'] . ')' : '';
                $eresep .=  'R/' . ' ' . $value['productName'] . ' | No. ' . $value['qty'] . ' | S ' .  $value['signaX'] . 'dd' . $value['signaHari'] . $catatanKhusus . PHP_EOL;
            }
        }

        $eresepRacikan = '' . PHP_EOL;
        if (isset($this->dataDaftarUgd['eresepRacikan'])) {
            // Racikan
            foreach ($this->dataDaftarUgd['eresepRacikan'] as $key => $value) {
                $jmlRacikan = ($value['qty']) ? 'Jml Racikan ' . $value['qty'] . ' | ' . $value['catatan'] . ' | S ' . $value['catatanKhusus'] . PHP_EOL : '';
                $dosis = isset($value['dosis']) ? ($value['dosis'] ? $value['dosis'] : '') : '';
                $eresepRacikan .= $value['noRacikan'] . '/ ' . $value['productName'] . ' - ' . $dosis .  PHP_EOL . $jmlRacikan;
            };
        }
        $this->dataDaftarUgd['perencanaan']['terapi']['terapi'] = $eresep . $eresepRacikan;

        $this->store();
        $this->closeModalEresepUGD();
    }

    // /////////////////////////////////////////




    // when new form instance
    public function mount()
    {
        $this->findData($this->rjNoRef);

        // set dokter pemeriksa
        // $this->setDrPemeriksa();
    }



    // select data start////////////////
    public function render()
    {

        return view(
            'livewire.emr-u-g-d.mr-u-g-d-dokter.assessment-dokter-perencanaan.assessment-dokter-perencanaan',
            [
                // 'RJpasiens' => $query->paginate($this->limitPerPage),
                'myTitle' => 'Perencanaan',
                'mySnipt' => 'Rekam Medis Pasien',
                'myProgram' => 'Pasien Rawat Jalan',
            ]
        );
    }
    // select data end////////////////


}
