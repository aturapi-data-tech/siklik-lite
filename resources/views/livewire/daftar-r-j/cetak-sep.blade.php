<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: 28cm 15cm;
            margin: 8px;
        }
    </style>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link href="build/assets/sirus.css" rel="stylesheet">
</head>

<body>
    <table class="w-full">

        <tr>
            <td class="mr-2 w-44">
                <img src="bpjslogo.png" class="object-fill h-8">
            </td>

            <td>
                <p class="ml-2 text-base font-bold text-start"><span>SURAT ELEGIBILITAS PESERTA</span></p>
                <p class="ml-2 text-base font-bold text-start"><span>MADINAH (JST)</span></p>
            </td>

        </tr>

        {{-- <tr style="background-color : rgb(42, 194, 37)">
            <td ></td>
            <td></td>
        </tr>
        <tr style="background-color : rgb(110, 50, 160)">
            <td ></td>
            <td></td>
        </tr> --}}
    </table>




    <table class="text-sm">
        <tr>
            <td>
                <p><span>No.SEP</span></p>
            </td>
            <td>
                <p>
                    <span>:
                        {{ isset($data['noSep']) ? ($data['noSep'] ? $data['noSep'] : '-') : '--' }}
                    </span>
                    <span class="ml-16">
                        {{ isset($data['informasi']['prolanisPRB'])
                            ? ($data['informasi']['prolanisPRB']
                                ? 'PRB : Ya'
                                : 'PRB : Tidak')
                            : 'PRB :--Tidak' }}
                    </span>
                </p>
            </td>
            <td colspan="2"></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p><span>Tgl.SEP</span></p>
            </td>
            <td>
                <p><span>: {{ isset($data['tglSep']) ? ($data['tglSep'] ? $data['tglSep'] : '-') : '--' }}</span></p>
            </td>
            <td>
                <p><span>Peserta</span></p>
            </td>
            <td>
                <p><span>:
                        {{ isset($data['peserta']['jnsPeserta'])
                            ? ($data['peserta']['jnsPeserta']
                                ? $data['peserta']['jnsPeserta']
                                : '-')
                            : '--' }}</span>
                </p>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p><span>No.Kartu</span></p>
            </td>
            <td>
                <p><span>:
                        {{ isset($data['peserta']['noKartu'])
                            ? ($data['peserta']['noKartu']
                                ? $data['peserta']['noKartu']
                                : '-')
                            : '--' }}
                        ( MR.
                        {{ isset($data['peserta']['noMr']) ? ($data['peserta']['noMr'] ? $data['peserta']['noMr'] : '-') : '--' }}
                        )</span></p>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p><span>Nama Peserta</span></p>
            </td>
            <td>
                <p><span>:
                        {{ isset($data['peserta']['nama']) ? ($data['peserta']['nama'] ? $data['peserta']['nama'] : '-') : '--' }}</span>
                </p>
            </td>
            <td>
                <p><span>Jns.Rawat</span></p>
            </td>
            <td>
                <p><span>:
                        {{ (isset($data['jnsPelayanan']) ? ($data['jnsPelayanan'] ? $data['jnsPelayanan'] : '-') : '--') == 1
                            ? 'Rawat Inap'
                            : 'Rawat Jalan' }}</span>
                </p>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p><span>Tgl.Lahir</span></p>
            </td>
            <td>
                <p><span>:
                        {{ isset($data['peserta']['tglLahir'])
                            ? ($data['peserta']['tglLahir']
                                ? $data['peserta']['tglLahir']
                                : '-')
                            : '--' }}
                        Kelamin
                        :{{ isset($data['peserta']['kelamin'])
                            ? ($data['peserta']['kelamin']
                                ? $data['peserta']['kelamin']
                                : '-')
                            : '--' }}</span>
                </p>
            </td>
            <td>
                <p><span>Jns.Kunjungan</span></p>
            </td>
            <td>
                <p><span>:
                        {{ isset($reqData['request']['t_sep']['tujuanKunjDesc'])
                            ? ($reqData['request']['t_sep']['tujuanKunjDesc']
                                ? $reqData['request']['t_sep']['tujuanKunjDesc']
                                : '-')
                            : '--' }}</span>
                </p>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p><span>No.Telepon</span></p>
            </td>
            <td>
                <p><span>:
                        {{ isset($reqData['request']['t_sep']['noTelp'])
                            ? ($reqData['request']['t_sep']['noTelp']
                                ? $reqData['request']['t_sep']['noTelp']
                                : '-')
                            : '--' }}</span>
                </p>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p><span>Sub/Spesialis</span></p>
            </td>
            <td>
                <p><span>: {{ isset($data['poli']) ? ($data['poli'] ? $data['poli'] : '-') : '--' }}</span></p>
            </td>
            <td>
                <p><span>Poli Perujuk</span></p>
            </td>
            <td>
                <p><span>:</span></p>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p><span>Dokter</span></p>
            </td>
            <td>
                <p><span>:
                        {{ isset($reqData['request']['t_sep']['dpjpLayanNama'])
                            ? ($reqData['request']['t_sep']['dpjpLayanNama']
                                ? $reqData['request']['t_sep']['dpjpLayanNama']
                                : '-')
                            : '--' }}</span>
                </p>
            </td>
            <td>
                <p><span>Kls.Hak</span></p>
            </td>
            <td>
                <p><span>:
                        {{ isset($reqData['request']['t_sep']['klsRawat']['klsRawatHak'])
                            ? ($reqData['request']['t_sep']['klsRawat']['klsRawatHak']
                                ? $reqData['request']['t_sep']['klsRawat']['klsRawatHak']
                                : '-')
                            : '--' }}</span>
                </p>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p><span>Faskes Perujuk</span></p>
            </td>
            <td>
                <p><span>:
                        {{ isset($reqData['request']['t_sep']['rujukan']['ppkRujukanNama'])
                            ? ($reqData['request']['t_sep']['rujukan']['ppkRujukanNama']
                                ? $reqData['request']['t_sep']['rujukan']['ppkRujukanNama']
                                : '-')
                            : '--' }}</span>
                </p>
            </td>
            <td>
                <p><span>Kls.Rawat</span></p>
            </td>
            <td>
                <p><span>:
                        {{ isset($data['kelasRawat']) ? ($data['kelasRawat'] ? $data['kelasRawat'] : '-') : '--' }}</span>
                </p>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p><span>Diagnosa Awal</span></p>
            </td>
            <td>
                <p><span>: {{ isset($data['diagnosa']) ? ($data['diagnosa'] ? $data['diagnosa'] : '-') : '--' }}</span>
                </p>
            </td>
            <td>
                <p><span>Penjamin</span></p>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p><span>Catatan</span></p>
            </td>
            <td>
                <p><span>: {{ isset($data['catatan']) ? ($data['catatan'] ? $data['catatan'] : '-') : '--' }}</span>
                </p>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table class="text-xs ">

        <tr>
            <td>
                <p><span>*Saya menyetujui BPJS Kesehatan untuk :</span></p>
                <p><span>a. membuka dan atau menggunakan informasi medis Pasien untuk keperluan
                        administrasi,
                        pembayaran asuransi atau jaminan pembiayaan kesehatan</span></p>
                <p><span>b. memberikan akses informasi medis atau riwayat pelayanan kepada dokter/tenaga
                        medis pada MADINAH (JST) untuk kepentingan pemeliharaan kesehatan, pengobatan, penyembuhan, dan
                        perawatan Pasien</span></p>
                <p><span>*Saya mengetahui dan memahami :</span></p>
                <p><span>a. Rumah Sakit dapat melakukan koordinasi dengan PT Jasa Raharja / PT Taspen /
                        PT
                        ASABRI / BPJS Ketenagakerjaan atau Penjamin lainnya, jika Peserta merupakan pasien yang
                        mengalami kecelakaan lalulintas dan / atau kecelakaan kerja</span></p>
                <p><span>b. SEP bukan sebagai bukti penjaminan peserta</span></p>
                <p><span>** Dengan tampilnya luaran SEP elektronik ini merupakan hasil validasi terhadap
                        eligibilitas Pasien secara elektronik (validasi finger print atau biometrik / sistem validasi
                        lain)</span></p>
                <p><span>dan selanjutnya Pasien dapat mengakses pelayanan kesehatan rujukan sesuai
                        ketentuan
                        berlaku. Kebenaran dan keaslian atas informasi data Pasien menjadi tanggung jawab penuh
                        FKRTL</span></p>
            </td>
            <td>
                <p><span>Persetujuan Pasien/Keluarga Pasien</span></p>
                <p><span>{{ isset($data['peserta']['nama']) ? ($data['peserta']['nama'] ? $data['peserta']['nama'] : '-') : '--' }}</span>
                </p>
                @inject('carbon', 'Carbon\Carbon')
                <p><span>Cetakan ke 1 {{ $carbon::now()->format('d/m/Y H:i:s') }}</span></p>

                @php
                    $tglRujukan = isset($reqData['request']['t_sep']['rujukan']['tglRujukan']) ? ($reqData['request']['t_sep']['rujukan']['tglRujukan'] ? $reqData['request']['t_sep']['rujukan']['tglRujukan'] : $carbon::now()->format('Y-m-d')) : $carbon::now()->format('Y-m-d');
                    $tglRujukanAwal = $carbon::createFromFormat('Y-m-d', $tglRujukan);
                    $tglBatasRujukan = $carbon::createFromFormat('Y-m-d', $tglRujukan)->addMonths(3);
                    
                    $diffInDays = $tglBatasRujukan->diffInDays($carbon::now());
                    $propertyDiffInDays = $diffInDays <= 20 ? 'red' : ($diffInDays <= 30 ? 'yellow' : '');
                @endphp

                <div>
                    <p class="italic font-bold ">Masa berlaku {{ $tglRujukanAwal->format('d/m/Y') }} s/d
                        {{ $tglBatasRujukan->format('d/m/Y') }}{{ '- - - sisa :' . $diffInDays . ' hari' }}
                    </p>
                    @php
                        $noSep = isset($data['noSep']) ? ($data['noSep'] ? $data['noSep'] : '-') : '--';
                    @endphp
                    {!! DNS2D::getBarcodeHTML($noSep, 'QRCODE', 3, 3) !!}
                </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</body>

</html>
