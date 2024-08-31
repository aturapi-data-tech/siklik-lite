<?php

namespace App\Http\Livewire\Emr\RekamMedis;

use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;

use App\Http\Traits\BPJS\iCareTrait;


use Spatie\ArrayToXml\ArrayToXml;
use Exception;


class RekamMedisDisplay extends Component
{
    use WithPagination, iCareTrait;


    // listener from blade////////////////
    protected $listeners = [
        'syncronizeAssessmentDokterRJFindData' => 'mount',
        'syncronizeAssessmentDokterUGDFindData' => 'mount'
    ];

    // primitive Variable
    public string $myTitle = 'Resume Medis Pasien';
    public string $mySnipt = 'Resume Medis Pasien';
    public string $myProgram = 'Resume Medis Pasien';


    //////////////////////////////
    // Ref on top bar
    //////////////////////////////
    public $regNoRef;
    public $rjNoRefCopyTo; //dari sini ke sana -> $rjNoRefCopyTo


    public array $dataDaftarTxn;
    public array $dataPasien;





    public bool $isOpenRekamMedisicare;
    public string $icareUrlResponse;


    ////////////////////////////////////////////////
    ///////////begin////////////////////////////////
    ////////////////////////////////////////////////

    public function openModalicare(): void
    {

        $this->isOpenRekamMedisicare = true;
    }

    public function closeModalicare(): void
    {
        $this->isOpenRekamMedisicare = false;
    }


    public function copyResep($NoRefCopyFrom, $txnStatus)
    {

        if ($txnStatus == 'RJ') {

            // cek status transaksi
            $checkRjStatus = $this->checkRjStatus($this->rjNoRefCopyTo);
            if ($checkRjStatus) {
                $this->emit('toastr-error', "Pasien Sudah Pulang, Trasaksi Terkunci.");
                return;
            }

            // 1 cari data to
            // 2 cari data from
            $to = $this->cariResepRJ($this->rjNoRefCopyTo);
            $from = $this->cariResepRJ($NoRefCopyFrom);

            $myResepFrom = $this->prosesDataArray(isset($from['eresep']) ? $from['eresep'] : [], 'EResepFrom');

            // 3 if eresep from (true) then update data eresep to
            if ($myResepFrom) {

                // hapus data obat
                try {
                    // remove into table transaksi
                    DB::table('rstxn_rjobats')
                        ->where('rj_no', $this->rjNoRefCopyTo)
                        ->delete();
                } catch (Exception $e) {
                    // display an error to user
                    // dd($e->getMessage());
                    $this->emit('toastr-error', $e->getMessage());
                    return;
                }

                $to['eresep'] = $myResepFrom;

                // insert data obat loop
                try {
                    // ?\
                    // select nvl(max(rjobat_dtl)+1,1) into :rstxn_rjobats.rjobat_dtl from rstxn_rjobats;
                    foreach ($to['eresep']  as $key => $toEresep) {

                        $lastInserted = DB::table('rstxn_rjobats')
                            ->select(DB::raw("nvl(max(rjobat_dtl)+1,1) as rjobat_dtl_max"))
                            ->first();

                        // insert into table transaksi
                        DB::table('rstxn_rjobats')
                            ->insert([
                                'rjobat_dtl' => $lastInserted->rjobat_dtl_max,
                                'rj_no' => $this->rjNoRefCopyTo,
                                'product_id' => $toEresep['productId'],
                                'qty' => $toEresep['qty'],
                                'price' => $toEresep['productPrice'],
                                'rj_carapakai' => $toEresep['signaX'],
                                'rj_kapsul' => $toEresep['signaHari'],
                                'rj_takar' => 'Tablet',
                                'catatan_khusus' => $toEresep['catatanKhusus'],
                                'rj_ket' => $toEresep['catatanKhusus'],
                                'exp_date' => DB::raw("to_date('" . $to['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')+30"),
                                'etiket_status' => 1,
                            ]);

                        // replace rjobatdtl dan rjno ke obat yang baru
                        $to['eresep'][$key]['rjObatDtl'] = $lastInserted->rjobat_dtl_max;
                        $to['eresep'][$key]['rjNo'] = $this->rjNoRefCopyTo;
                    }
                    //
                } catch (Exception $e) {
                    // display an error to user
                    // dd($e->getMessage());
                    $this->emit('toastr-error', $e->getMessage());
                    return;
                }

                // 4update database to
            }


            // racikan

            $myResepRacikanFrom = $this->prosesDataArray(isset($from['eresepRacikan']) ? $from['eresepRacikan'] : [], 'EResepRacikanFrom');

            // 3if eresepRacikan from (true) then update data eresepRacikan to
            if ($myResepRacikanFrom) {

                // hapus data obat
                try {
                    // remove into table transaksi
                    DB::table('rstxn_rjobatracikans')
                        ->where('rj_no', $this->rjNoRefCopyTo)
                        ->delete();
                } catch (Exception $e) {
                    // display an error to user
                    // dd($e->getMessage());
                    $this->emit('toastr-error', $e->getMessage());
                    return;
                }

                $to['eresepRacikan'] = $myResepRacikanFrom;

                // insert data obat loop
                try {
                    // ?\
                    // select nvl(max(rjobat_dtl)+1,1) into :rstxn_rjobatracikans.rjobat_dtl from rstxn_rjobatracikans;
                    foreach ($to['eresepRacikan']  as $toEresepRacikan) {
                        $lastInserted = DB::table('rstxn_rjobatracikans')
                            ->select(DB::raw("nvl(max(rjobat_dtl)+1,1) as rjobat_dtl_max"))
                            ->first();
                        // insert into table transaksi
                        DB::table('rstxn_rjobatracikans')
                            ->insert([
                                'rjobat_dtl' => $lastInserted->rjobat_dtl_max,
                                'rj_no' => $this->rjNoRefCopyTo,
                                // 'product_id' => $toEresepRacikan['productId'],
                                'product_name' => $toEresepRacikan['productName'],
                                'sedia' => $toEresepRacikan['sedia'],
                                'dosis' => isset($toEresepRacikan['dosis']) ? ($toEresepRacikan['dosis'] ? $toEresepRacikan['dosis'] : '') : '',
                                'qty' => $toEresepRacikan['qty'],
                                // 'price' => $toEresepRacikan['productPrice'],
                                // 'rj_carapakai' => $toEresepRacikan['signaX'],
                                // 'rj_kapsul' => $toEresepRacikan['signaHari'],
                                'catatan' => $toEresepRacikan['catatan'],
                                'catatan_khusus' => $toEresepRacikan['catatanKhusus'],
                                'no_racikan' => $toEresepRacikan['noRacikan'],

                                'rj_takar' => 'Tablet',
                                'exp_date' => DB::raw("to_date('" . $to['rjDate'] . "','dd/mm/yyyy hh24:mi:ss')+30"),
                                'etiket_status' => 1,
                            ]);

                        // replace rjobatdtl dan rjno ke obat yang baru
                        $to['eresepRacikan'][$key]['rjObatDtl'] = $lastInserted->rjobat_dtl_max;
                        $to['eresepRacikan'][$key]['rjNo'] = $this->rjNoRefCopyTo;
                    }
                    //
                } catch (Exception $e) {
                    // display an error to user
                    // dd($e->getMessage());
                    $this->emit('toastr-error', $e->getMessage());
                    return;
                }

                // 4update database to
            }







            // Jika array perencanaan belum terbentuk
            if (!isset($to['perencanaan'])) {
                $this->emit('storeAssessmentDokterRJPerencanaan');
                $this->emit('syncronizeAssessmentDokterRJFindData');
                $to = $this->cariResepRJ($this->rjNoRefCopyTo);
            }

            // terapi
            if (isset($to['eresep'])) {
                $eresep = '';
                foreach ($to['eresep'] as  $value) {
                    $catatanKhusus = ($value['catatanKhusus']) ? ' (' . $value['catatanKhusus'] . ')' : '';
                    $eresep .=  'R/' . ' ' . $value['productName'] . ' | No. ' . $value['qty'] . ' | S ' .  $value['signaX'] . 'dd' . $value['signaHari'] . $catatanKhusus . PHP_EOL;
                }
                $to['perencanaan']['terapi']['terapi'] = $eresep;
            }

            if (isset($to['eresepRacikan'])) {
                $eresepRacikan = '' . PHP_EOL;
                foreach ($to['eresepRacikan'] as  $value) {
                    $jmlRacikan = ($value['qty']) ? 'Jml Racikan ' . $value['qty'] . ' | ' . $value['catatan'] . ' | S ' . $value['catatanKhusus'] . PHP_EOL : '';
                    $dosis = isset($value['dosis']) ? ($value['dosis'] ? $value['dosis'] : '') : '';
                    $eresepRacikan .= $value['noRacikan'] . '/ ' . $value['productName'] . ' - ' . $dosis .  PHP_EOL . $jmlRacikan;
                }
                $to['perencanaan']['terapi']['terapi'] = $eresepRacikan;
            }




            $this->updateDataRj($this->rjNoRefCopyTo, $to);
        } else {
            $this->emit('toastr-error', "Fitur Copy Terapi pasien masih dalam proses pengembangan.");
            return;
        }
    }

    private function cariResepRJ($rjNo): array
    {
        // update table trnsaksi
        $cari = DB::table('rstxn_rjhdrs')
            ->select('datadaftarpolirj_json')
            ->where('rj_no', $rjNo)
            ->first();

        if (isset($cari->datadaftarpolirj_json)) {
            if ($cari->datadaftarpolirj_json) {
                return json_decode($cari->datadaftarpolirj_json, true);
            }
        }
        return [];
    }

    private function updateDataRj($rjNo, $dataDaftarPoliRJArr): void
    {
        // update table trnsaksi
        DB::table('rstxn_rjhdrs')
            ->where('rj_no', $rjNo)
            ->update([
                'datadaftarpolirj_json' => json_encode($dataDaftarPoliRJArr, true),
                'datadaftarpolirj_xml' => ArrayToXml::convert($dataDaftarPoliRJArr),
            ]);

        $this->emit('syncronizeAssessmentDokterRJFindData');
        $this->emit('toastr-success', "Data Resep berhasil disimpan.");
    }

    private function prosesDataArray(array $arr, string $arrName)
    {
        $myArr = $arr ? $arr : [];

        if (!$myArr) {
            $this->emit('toastr-error', "Data " . $arrName . " tidak ditemukan.");
            return;
        }

        return $myArr;
    }

    private function checkRjStatus($rjNo): bool
    {
        $lastInserted = DB::table('rstxn_rjhdrs')
            ->select('rj_status')
            ->where('rj_no', $rjNo)
            ->first();

        if ($lastInserted->rj_status !== 'A') {
            return true;
        }
        return false;
    }


    public function myiCare($nomorKartu, $sep)
    {
        if (!$sep) {
            $this->emit('toastr-error', "Belum Terbit SEP.");
            return;
        }

        $kodeDokter = DB::table('rsmst_doctors')
            ->select('kd_dr_bpjs')
            ->where('rsmst_doctors.dr_id', auth()->user()->myuser_code)
            ->first();


        // dd($kodeDokter);
        if ($kodeDokter->kd_dr_bpjs == null) {
            $this->emit('toastr-error', "Dokter tidak memiliki hak akses untuk I-Care.");
            return;
        }

        // trait
        $HttpGetBpjs  = $this->icare($nomorKartu, $kodeDokter->kd_dr_bpjs)->getOriginalContent();
        // $HttpGetBpjs =  iCareTrait::icare($nomorKartu, $kodeDokter)->getOriginalContent();
        // set http response to public
        $HttpGetBpjsStatus = $HttpGetBpjs['metadata']['code']; //status 200 201 400 ..
        $HttpGetBpjsJson = $HttpGetBpjs; //Return Response
        if ($HttpGetBpjsStatus == 200) {
            $this->icareUrlResponse = $HttpGetBpjsJson['response']['url'];
            $this->openModalicare();
            // return redirect()->to($HttpGetBpjsJson['response']['url']);
        } else {
            $this->emit('toastr-error', json_encode($HttpGetBpjsJson['metadata']['message'], true));
            return;
        }
    }


    // when new form instance
    public function mount()
    {
        $this->render();
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
                'reg_name',
                'erm_status',
                'layanan_status',
                'poli',
                'kd_dr_bpjs',
                'nokartu_bpjs',
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
            'livewire.emr.rekam-medis.rekam-medis-display',
            [
                'myQueryData' => $query->paginate(3),
                'myQueryIdentitas' => $queryIdentitas
            ]


        );
    }
    // select data end////////////////


}
