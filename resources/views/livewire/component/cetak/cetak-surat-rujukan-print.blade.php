<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: 21cm 29.7cm;
            margin: 8px;
        }
    </style>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="build/assets/sirus.css" rel="stylesheet">
</head>

<body class="text-xs">

    <table class="w-full">
        <tr>
            <td class="mr-2 w-44">
                <img src="bpjslogo.png" class="object-fill h-8">
            </td>
        </tr>
    </table>

    <table class="w-full table-fixed">
        <tr class="">
            <td class="">

            </td>
            <td class="">

            </td>

            <td class="text-right">
                Divisi Regional
            </td>
            <td class="pl-4">
                KABUPATEN WILAYAH VII
            </td>
        </tr>
        <tr>
            <td class="">

            </td>
            <td class="">

            </td>

            <td class="text-right">
                Kantor Cabang
            </td>
            <td class="pl-4">
                TULUNGAGUNG
            </td>
        </tr>
    </table>


    <table class="w-full table-fixed">
        <tr>
            <td class="mr-2 text-lg font-bold text-center">
                SURAT RUJUKAN FKTP
            </td>
        </tr>
    </table>


    <table class="w-full border border-gray-900 table-fixed ">
        <tr class="">
            <div class="p-2 m-2 border border-gray-900">
                <table class="w-full table-fixed ">
                    <tr>
                        <td>
                            No. Rujukan
                        </td>

                        <td>
                            <span class="text-center">:</span>
                            {{ $data['noKunjungan'] ?? '-' }}
                        </td>
                        <td>
                        </td>
                        <td>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            Puskesmas/Dokter Keluarga
                        </td>
                        <td>
                            <span class="text-center">:</span>
                            {{ env('SATUSEHAT_ORGANIZATION_NAME') }}
                        </td>
                        <td>
                            <span class="text-center">{!! DNS1D::getBarcodeHTML($data['noKunjungan'] ?? '-', 'C39', 1) !!}</span>
                        </td>
                        <td>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Kabupaten/Kota
                        </td>
                        <td>
                            <span class="text-center">:</span>
                            {{ $data['dataDaftarPoliRJ']['addKunjungan']['rujukLanjut']['nmkc'] ?? '-' }}
                        </td>
                        <td>
                        </td>
                        <td>
                            {{-- {{ $data['dataDaftarPoliRJ']['addKunjungan']['rujukLanjut']['kdppk'] ?? '-' }} --}}
                        </td>
                    </tr>
                </table>
            </div>
        </tr>

        <tr>
            <div class="ml-4 ">
                <table class="w-full table-fixed ">
                    <tr>
                        <td>
                            Kepada Yth. TS dr. Poli
                        </td>

                        <td>
                            <span class="text-center">:</span>
                            {{ $data['dataDaftarPoliRJ']['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialisDesc'] ?? '-' }}

                        </td>
                        <td>
                        </td>
                        <td>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            Di RSU
                        </td>
                        <td>
                            <span class="text-center">:</span>
                            {{ $data['dataDaftarPoliRJ']['addKunjungan']['rujukLanjut']['nmppk'] ?? '-' }}
                        </td>
                        <td class="text-right">
                            Kode
                            <span class="text-center">:</span>
                        </td>
                        <td>
                            {{ $data['dataDaftarPoliRJ']['addKunjungan']['rujukLanjut']['kdppk'] ?? '-' }}
                        </td>
                    </tr>
                </table>
            </div>
        </tr>

        <tr>
            <div class="my-1 ml-4">
                <table class="w-full table-fixed ">
                    <tr>
                        <td>
                            Mohon pemeriksaan dan penanganan lebih lanjut penderita :
                        </td>
                    </tr>
            </div>
        </tr>

        <tr>

            <div class="ml-4 ">
                <table class="w-full table-fixed ">
                    <tr>
                        <td>
                            Nama
                        </td>

                        <td>
                            <span class="text-center">:</span>
                            {{ strtoupper($data['dataPasien']['regName'] ?? '-') }}

                        </td>
                        <td>
                        </td>
                        <td>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            Umur
                        </td>
                        <td>
                            <span class="text-center">:</span>
                            {{ $data['dataPasien']['thn'] ?? '-' }}
                            {{ $data['dataPasien']['tglLahir'] ?? '-' }}

                        </td>
                        <td>
                        </td>
                        <td>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            No. Kartu BPJS
                        </td>
                        <td>
                            <span class="text-center">:</span>
                            {{ $data['dataDaftarPoliRJ']['addKunjungan']['noKartu'] ?? '-' }}

                        </td>
                        <td class="text-right">
                            Status
                        </td>
                        <td>
                            <span class="text-center">:</span>
                            Utama / Tanggungan
                            {{ $data['dataPasien']['jenisKelamin']['jenisKelaminDesc'] ?? '-' }}

                        </td>
                    </tr>

                    <tr>
                        <td>
                            Diagnosa
                        </td>
                        <td>
                            <span class="text-center">:</span>
                            {{ $data['dataDaftarPoliRJ']['diagnosis'][0]['diagDesc'] ?? '-' }}{{ '(' }}{{ $data['dataDaftarPoliRJ']['diagnosis'][0]['diagId'] ?? '-' }}{{ ')' }}
                        </td>
                        <td class="text-right">
                            Catatan
                        </td>
                        <td>
                            <span class="text-center">:</span>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            Telah diberikan
                        </td>
                        <td>
                            <span class="text-center">:</span>

                        </td>
                        <td>
                        </td>
                        <td>

                        </td>
                    </tr>
                </table>

                <div class="mb-8">
                    {{-- Jarak Telah diberikan --}}
                </div>
            </div>
        </tr>

        <tr>
            <div class="my-1 ml-4">
                <table class="w-full table-fixed ">
                    <tr>
                        <td>
                            Atas bantuannya, diucapkan banyak terima kasih
                        </td>
                    </tr>
            </div>
        </tr>

        <tr>
            <div class="my-1 ml-4">
                <table class="w-full table-fixed ">
                    <tr>
                        <td>
                            Tgl Rencana Berkunjung
                        </td>
                        <td>
                            <span class="text-center">:</span>
                            {{ $data['dataDaftarPoliRJ']['addKunjungan']['rujukLanjut']['tglEstRujuk'] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Jadwal Praktek
                        </td>
                        <td>
                            <span class="text-center">:</span>
                            {{ $data['dataDaftarPoliRJ']['addKunjungan']['rujukLanjut']['jadwal'] ?? '-' }}
                        </td>
                    </tr>
                </table>

                <table class="w-full table-fixed ">
                    <tr>
                        <td>
                            Surat rujukan ini berlaku 1[satu] kali kunjungan berlaku sampai dengan :
                            @inject('carbon', 'Carbon\Carbon')
                            @php
                                $tglEstRujuk =
                                    $data['dataDaftarPoliRJ']['addKunjungan']['rujukLanjut']['tglEstRujuk'] ??
                                    Carbon::now(env('APP_TIMEZONE'))->format('d-m-Y');
                                $tglEstRujukHabis = $carbon
                                    ::createFromFormat('d-m-Y', $tglEstRujuk, env('APP_TIMEZONE'))
                                    ->addMonths(3)
                                    ->format('d-m-Y');

                            @endphp
                            {{ $tglEstRujukHabis ?? '-' }}

                        </td>
                    </tr>
                </table>
            </div>
        </tr>


        <tr>
            <div class="my-1">
                <table class="w-full table-fixed">
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-center">Salam sejawat,
                            {{ $data['dataDaftarPoliRJ']['drDesc'] ?? '-' }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mt-10 mb-2">
                <table class="w-full table-fixed">
                    <tr class="">
                        <td></td>
                        <td></td>
                        <td class="text-center "> {{ $data['dataDaftarPoliRJ']['addKunjungan']['tglDaftar'] ?? '-' }}
                        </td>
                    </tr>

                </table>
            </div>
        </tr>
    </table>



    <table class="w-full mt-4 border border-gray-900 table-fixed">
        <tr>
            <td class="mt-2 mr-2 text-base font-semibold text-center">
                SURAT RUJUKAN BALIK
            </td>
        </tr>

        <tr class="">
            <div class="p-2 m-2 ">
                <table class="w-full table-fixed ">
                    <tr>
                        <td>
                            Teman sejawat Yth.
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Mohon kontrol selanjutnya penderita
                        </td>
                    </tr>
                </table>
            </div>
        </tr>

        <tr>
            <div class="ml-4 ">
                <table class="w-full table-fixed ">
                    <tr>
                        <td>
                            Nama
                        </td>

                        <td>
                            <span class="text-center">:</span>
                            {{ strtoupper($data['dataPasien']['regName'] ?? '-') }}

                        </td>
                        <td>
                        </td>
                        <td>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            Diagnosa
                        </td>
                        <td>
                            <span class="text-center">:</span>

                        </td>
                        <td class="text-right">
                        </td>
                        <td>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Terapi
                        </td>
                        <td>
                            <span class="text-center">:</span>

                        </td>
                        <td class="text-right">
                        </td>
                        <td>
                        </td>
                    </tr>
                </table>
            </div>
        </tr>

        <tr>
            <div class="my-1 ml-4">
                <table class="w-full table-fixed ">
                    <tr>
                        <td>
                            Tindak lanjut yang dianjurkan :
                        </td>
                    </tr>
            </div>
        </tr>

        <tr>

            <div class="mt-2 ml-4">
                <table class="w-full table-fixed ">
                    <tr>
                        <td class="align-middle">
                            <div class="inline-block w-6 h-6 mr-2 align-middle border border-gray-900"></div> Pengobatan
                            dengan
                            obat-obatan
                        </td>
                        <td class="align-middle">
                            <div class="inline-block w-6 h-6 mr-2 align-middle border border-gray-900"></div>Perlu rawat
                            inap
                        </td>

                    </tr>

                    <tr>
                        <td class="align-middle">
                            <div class="inline-block w-6 h-6 mr-2 align-middle border border-gray-900"></div>Kontrol
                            kembali
                            ke RS tangga
                        </td>
                        <td class="align-middle">
                            <div class="inline-block w-6 h-6 mr-2 align-middle border border-gray-900"></div>Konsultasi
                            selesai
                        </td>

                    </tr>

                    <tr>
                        <td class="align-middle">
                            <div class="inline-block w-6 h-6 mr-2 align-middle border border-gray-900"></div>Lain-lain
                        </td>
                        <td>
                        </td>
                    </tr>
                </table>
            </div>
        </tr>
        <tr>
            <div class="my-1">
                <table class="w-full table-fixed">
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-center">...........Tgl......................</td>
                    </tr>
                </table>
            </div>
        </tr>

        <tr>
            <div class="my-1">
                <table class="w-full table-fixed">
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-center">Dokter RS,</td>
                    </tr>
                </table>
            </div>
            <div class="mt-10 mb-2">
                <table class="w-full table-fixed">
                    <tr class="">
                        <td></td>
                        <td></td>
                        <td class="text-center ">(..............................)</td>
                    </tr>

                </table>
            </div>
        </tr>

    </table>









</body>

</html>
