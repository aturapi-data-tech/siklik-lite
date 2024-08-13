<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: 11cm 17cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-top: 0.5cm;
        }
    </style>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link href="build/assets/sirus.css" rel="stylesheet">
</head>

<body class="font-serif">





    {{-- Content --}}
    <div class="bg-white ">

        {{-- surat keterangan sehat isi --}}
        <div>
            <div>
                <table class="w-full table-auto">
                    <tbody>
                        <tr>
                            <td class="text-xs text-center border-b-2 border-black ">

                                <table class="table-auto ">
                                    <tbody>
                                        <tr>
                                            <td class="">
                                                <img src="madinahlogopersegi.png" class="object-fill h-20 mx-4">
                                            </td>
                                            <td class="text-left ">
                                                <span class="font-semibold">
                                                    {!! $myQueryIdentitas->int_name . '</br>' !!}
                                                </span>
                                                {!! $myQueryIdentitas->int_address . '</br>' !!}
                                                {!! $myQueryIdentitas->int_city . '</br>' !!}
                                                {!! $myQueryIdentitas->int_phone1 . '-' !!}
                                                {!! $myQueryIdentitas->int_phone2 . '' !!}
                                                {{-- {!! $myQueryIdentitas->int_fax . '-' !!} --}}
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>

                            </td>
                        </tr>

                        <tr>
                            <td class="p-1 m-1 text-lg font-semibold text-center uppercase ">
                                Surat Rencana Kontrol
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div>
                <table class="w-full table-auto">
                    <tbody>
                        <tr>
                            <td class="text-xs text-cente">
                                Kepada Yth : dr
                                {{ isset($dataDaftarTxn['kontrol']['drKontrolDesc'])
                                    ? ($dataDaftarTxn['kontrol']['drKontrolDesc']
                                        ? $dataDaftarTxn['kontrol']['drKontrolDesc']
                                        : '-')
                                    : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="text-xs text-cente">
                                Mohon Pemeriksaan dan Penanganan Lebih Lanjut :
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>

            <br>

            <div>
                <table class="w-full table-auto">
                    <tbody>
                        <tr>
                            <td class="w-[100px] text-xs text-cente">
                                No SKDP
                            </td>
                            <td>:</td>
                            <td class="w-3/4 text-xs text-cente">
                                {{ isset($dataDaftarTxn['kontrol']['noSKDPBPJS'])
                                    ? ($dataDaftarTxn['kontrol']['noSKDPBPJS']
                                        ? $dataDaftarTxn['kontrol']['noSKDPBPJS']
                                        : '-')
                                    : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="w-[100px] text-xs text-cente">
                                Kode Reservasi RS
                            </td>
                            <td>:</td>
                            <td class="w-3/4 text-xs text-cente">
                                {{ isset($dataDaftarTxn['kontrol']['noKontrolRS'])
                                    ? ($dataDaftarTxn['kontrol']['noKontrolRS']
                                        ? $dataDaftarTxn['kontrol']['noKontrolRS']
                                        : '-')
                                    : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="w-[100px] text-xs text-cente">
                                No. BPJS
                            </td>
                            <td>:</td>
                            <td class="w-3/4 text-xs text-cente">
                                {{ isset($dataPasien['pasien']['identitas']['idbpjs'])
                                    ? ($dataPasien['pasien']['identitas']['idbpjs']
                                        ? $dataPasien['pasien']['identitas']['idbpjs']
                                        : '-')
                                    : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="w-[100px] text-xs text-cente">
                                No RM
                            </td>
                            <td>:</td>
                            <td class="w-3/4 text-xs text-cente">
                                {{ isset($dataPasien['pasien']['regNo'])
                                    ? ($dataPasien['pasien']['regNo']
                                        ? $dataPasien['pasien']['regNo']
                                        : '-')
                                    : '-' }}
                            </td>
                        </tr>


                        <tr>
                            <td class="w-[100px] text-xs text-cente">
                                Nama Peserta
                            </td>
                            <td>:</td>
                            <td class="w-3/4 text-xs uppercase text-cente">
                                {{ isset($dataPasien['pasien']['regName'])
                                    ? ($dataPasien['pasien']['regName']
                                        ? $dataPasien['pasien']['regName']
                                        : '-')
                                    : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="w-[100px] text-xs text-cente">
                                Tgl Lahir
                            </td>
                            <td>:</td>
                            <td class="w-3/4 text-xs text-cente">
                                {{ isset($dataPasien['pasien']['tglLahir'])
                                    ? ($dataPasien['pasien']['tglLahir']
                                        ? $dataPasien['pasien']['tglLahir']
                                        : '-')
                                    : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="w-[100px] text-xs text-cente">
                                Poli Tujuan
                            </td>
                            <td>:</td>
                            <td class="w-3/4 text-xs text-cente">
                                {{ isset($dataDaftarTxn['kontrol']['poliKontrolDesc'])
                                    ? ($dataDaftarTxn['kontrol']['poliKontrolDesc']
                                        ? $dataDaftarTxn['kontrol']['poliKontrolDesc']
                                        : '-')
                                    : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="w-[100px] text-xs text-cente">
                                Tgl Kontrol
                            </td>
                            <td>:</td>
                            <td class="w-3/4 text-xs text-cente">
                                {{ isset($dataDaftarTxn['kontrol']['tglKontrol'])
                                    ? ($dataDaftarTxn['kontrol']['tglKontrol']
                                        ? $dataDaftarTxn['kontrol']['tglKontrol']
                                        : '-')
                                    : '-' }}
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>



            <div>
                <table class="w-full table-auto">
                    <tbody>
                        <tr>
                            <td class="text-xs text-cente">
                                Demikian atas bantuannya, diucapkan banyak terimakasih.
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>



            <div>
                <table class="w-full table-auto">
                    <tbody>
                        <tr>
                            @php
                                $drDesc = isset($dataDaftarTxn['drDesc']) ? ($dataDaftarTxn['drDesc'] ? $dataDaftarTxn['drDesc'] : '-') : '--';
                            @endphp
                            <td class="w-1/2 text-white">
                                <span>{!! DNS2D::getBarcodeHTML($drDesc, 'QRCODE', 2, 2) !!}</span>
                            </td>

                            <td class="w-1/2 text-xs text-cente">
                                Mengetahui DPJP,
                                <br>
                                <br>
                                <br>
                                {{ isset($dataDaftarTxn['drDesc']) ? ($dataDaftarTxn['drDesc'] ? $dataDaftarTxn['drDesc'] : '-') : '-' }}
                                <br>
                                {{ isset($dataDaftarTxn['rjDate']) ? ($dataDaftarTxn['rjDate'] ? $dataDaftarTxn['rjDate'] : '-') : '-' }}
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>

        </div>
        {{-- surat keterangan sehat isi --}}

    </div>
    {{-- End Content --}}


</body>

</html>
