<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: 21cm 34cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-top: 1cm;
        }
    </style>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link href="build/assets/sirus.css" rel="stylesheet">
</head>

<body class="font-serif">





    {{-- Content --}}
    <div class="bg-white ">

        {{-- surat keterangan istirahat isi --}}
        <div>
            <div>
                {{-- <table class="w-full table-auto">
                    <tbody>
                        <tr>
                            <td class="text-xs text-center border-2 border-black ">
                                <img src="madinahlogopersegi.png" class="object-fill h-32 mx-auto">
                                <br>
                                <span class="font-semibold">
                                    {!! $myQueryIdentitas->int_name . '</br>' !!}
                                </span>
                                {!! $myQueryIdentitas->int_address . '</br>' !!}
                                {!! $myQueryIdentitas->int_city . '</br>' !!}
                                {!! $myQueryIdentitas->int_phone1 . '-' !!}
                                {!! $myQueryIdentitas->int_phone2 . '' !!}
                            </td>
                        </tr>

                        <tr>
                            <td class="p-1 m-1 text-lg font-semibold text-center uppercase ">
                                surat keterangan istirahat
                            </td>
                        </tr>
                    </tbody>
                </table> --}}

                <table class="w-full mb-4 table-auto">
                    <tr>
                        <td class="w-2/3 align-top"></td>

                        <td class="w-1/3 text-right align-top">
                            <img src="madinahlogopersegi.png" class="object-fill ml-auto h-28">
                            <div class="mt-1 text-xs leading-tight text-right">
                                <span class="text-sm font-semibold">Klinik Madinah Pratama</span><br>
                                Jalan Jatiwayang Lk 2 Ds Ngunut<br>
                                Kec Ngunut, Kab Tulungagung<br>
                                Jawa Timur 66292<br>
                                Telp. 0813-8785-9218<br>
                                Fax. (0355) 396824<br>
                                klinikmadinahpratama@gmail.com
                            </div>
                        </td>
                    </tr>
                </table>

            </div>
            <div class="">
                <table class="w-full table-auto ">
                    <tbody>
                        <tr>
                            <td class="p-2 m-2 text-lg font-semibold text-center uppercase ">
                                surat keterangan istirahat
                            </td>
                        </tr>
                        <tr>
                            <td class="p-2 m-2 text-sm text-start">
                                <p>
                                    Yang bertanda tangan dibawah ini :
                                </p>
                                <br>
                                <div>
                                    <table class="w-full table-auto">
                                        <tbody>
                                            <tr>

                                                <td class="p-1 m-1">Nama</td>
                                                <td class="p-1 m-1">:</td>
                                                <td class="p-1 m-1 text-xs font-semibold">
                                                    {{ isset($dataDaftarTxn['perencanaan']['pengkajianMedis']['drPemeriksa'])
                                                        ? ($dataDaftarTxn['perencanaan']['pengkajianMedis']['drPemeriksa']
                                                            ? $dataDaftarTxn['perencanaan']['pengkajianMedis']['drPemeriksa']
                                                            : 'Dokter Pemeriksa')
                                                        : 'Dokter Pemeriksa' }}
                                                </td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1 text-lg font-semibold">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-1 m-1">Jabatan</td>
                                                <td class="p-1 m-1">:</td>
                                                <td class="p-1 m-1">
                                                    DOKTER PEMERIKSA
                                                </td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1">
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <p>
                                    Menyatakan dengan sesungguhnya bahwa :
                                </p>
                                <br>
                                <div>
                                    <table class="w-full table-auto">
                                        <tbody>
                                            <tr>

                                                <td class="p-1 m-1">Nama Pasien</td>
                                                <td class="p-1 m-1">:</td>
                                                <td class="p-1 m-1 text-xs font-semibold">
                                                    {{ isset($dataPasien['pasien']['regName']) ? strtoupper($dataPasien['pasien']['regName']) : '-' }}/
                                                    {{ isset($dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc']) ? $dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] : '-' }}/
                                                    {{ isset($dataPasien['pasien']['thn']) ? $dataPasien['pasien']['thn'] : '-' }}
                                                </td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1 text-lg font-semibold">
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="p-1 m-1">Tanggal Lahir</td>
                                                <td class="p-1 m-1">:</td>
                                                <td class="p-1 m-1">
                                                    {{ isset($dataPasien['pasien']['tglLahir']) ? $dataPasien['pasien']['tglLahir'] : '-' }}
                                                </td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1">


                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="p-1 m-1">Alamat</td>
                                                <td class="p-1 m-1">:</td>
                                                <td class="p-1 m-1">
                                                    {{ isset($dataPasien['pasien']['identitas']['alamat']) ? $dataPasien['pasien']['identitas']['alamat'] : '-' }}
                                                </td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1">
                                                </td>
                                            </tr>

                                            <tr>

                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"> </td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1"></td>
                                                <td class="p-1 m-1">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @inject('carbon', 'Carbon\Carbon')
                                @php
                                    // 1. Tanggal kunjungan sebagai dasar
                                    /** @var \Carbon\Carbon $tglRj */
                                    $tglRj = isset($dataDaftarTxn['rjDate'])
                                        ? $carbon::createFromFormat('d/m/Y H:i:s', $dataDaftarTxn['rjDate'])
                                        : $carbon::now(env('APP_TIMEZONE'));

                                    // 2. Lama istirahat (default 3 hari)
                                    $suketIstirahatHari =
                                        (int) ($dataDaftarTxn['suket']['suketIstirahat']['suketIstirahatHari'] ?? 3);

                                    // Safety: minimal 1 hari
                                    if ($suketIstirahatHari < 1) {
                                        $suketIstirahatHari = 1;
                                    }

                                    // 3. Mulai istirahat: 'hariIni' atau 'besok'
                                    $mulai =
                                        $dataDaftarTxn['suket']['suketIstirahat']['suketIstirahatMulai'] ?? 'hariIni';

                                    if ($mulai === 'besok') {
                                        // mulai besok
                                        $tglMulai = $tglRj->copy()->addDay();
                                    } else {
                                        // default: mulai hari ini
                                        $tglMulai = $tglRj->copy();
                                    }

                                    // 4. Akhir istirahat (inklusif)
                                    // contoh: mulai 10, lama 2 hari => 10 & 11 => + (2 - 1)
                                    $tglSelesai = $tglMulai->copy()->addDays($suketIstirahatHari - 1);

                                    // 5. Format untuk ditampilkan
                                    $tglRjAwal = $tglMulai->format('d/m/Y');
                                    $tglRjAkhir = $tglSelesai->format('d/m/Y');
                                @endphp
                                <br>
                                <p>
                                    Pada pemeriksa saya tanggal
                                    {{ $tglRjAwal ?? '-' }} secara klinis
                                    dalam keadaan sakit
                                    dan perlu istirahat selama {{ $suketIstirahatHari }} (hari)
                                    <br>
                                    dari tanggal {{ $tglRjAwal ?? '-' }} s/d
                                    {{ $tglRjAkhir ?? '-' }}
                                    <br><br>
                                    Demikian surat keterangan ini saya buat untuk dipergunakan
                                    sebagaimana mestinya.
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <td class="w-2/3"></td>
                            <td class="w-1/3 p-2 m-2 text-sm text-center ">
                                Tulungagung,
                                {{ $tglRjAwal }}
                                <br>
                                <br>
                                <br>
                                <br>
                                ttd
                                <br>
                                {{ isset($dataDaftarTxn['perencanaan']['pengkajianMedis']['drPemeriksa'])
                                    ? ($dataDaftarTxn['perencanaan']['pengkajianMedis']['drPemeriksa']
                                        ? $dataDaftarTxn['perencanaan']['pengkajianMedis']['drPemeriksa']
                                        : 'Dokter Pemeriksa')
                                    : 'Dokter Pemeriksa' }}
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- surat keterangan istirahat isi --}}

    </div>
    {{-- End Content --}}


</body>

</html>
