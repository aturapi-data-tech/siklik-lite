<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: 21cm 18cm;
            margin: 8px;
        }
    </style>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link href="build/assets/sirus.css" rel="stylesheet">
</head>

<body>

    {{-- Judul --}}
    <div>
        <table style="font-size: 12px " class="w-full table-auto">
            <tbody>
                <tr>
                    <td class="text-center border-b-2 border-black ">

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
                        resep ugd
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="relative">
        {{-- Identifikasi Pasien --}}
        <div class="absolute top-0 left-0 w-1/2 ">
            {{-- Identifikasi Pasien --}}
            <div>
                <table style="font-size: 10px "class="w-1/2 table-auto ">
                    <tbody>
                        <tr>
                            <td class="p-1 m-1">No. Resep / Tanggal</td>
                            <td class="p-1 m-1">:</td>
                            <td class="p-1 m-1 font-semibold">
                                {{ isset($dataDaftarUgd['rjNo']) ? $dataDaftarUgd['rjNo'] : '-' }} /
                                {{ isset($dataDaftarUgd['rjDate']) ? $dataDaftarUgd['rjDate'] : '-' }}
                                @isset($dataDaftarUgd['statusPRB']['penanggungJawab']['statusPRB'])
                                    @if ($dataDaftarUgd['statusPRB']['penanggungJawab']['statusPRB'])
                                        / PRB
                                    @else
                                        {{-- NonPRB --}}
                                    @endif
                                @else
                                    {{-- NonPRB --}}
                                @endisset
                            </td>
                        </tr>

                        <tr>

                            <td class="p-1 m-1">Pasien</td>
                            <td class="p-1 m-1">:</td>
                            <td class="p-1 m-1 font-semibold">
                                {{ isset($dataPasien['pasien']['regName']) ? strtoupper($dataPasien['pasien']['regName']) : '-' }}
                                <br>
                                {{ isset($dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc']) ? $dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] : '-' }}/
                                {{ isset($dataPasien['pasien']['thn']) ? $dataPasien['pasien']['thn'] : '-' }}/
                                {{ isset($dataPasien['pasien']['regNo']) ? $dataPasien['pasien']['regNo'] : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="p-1 m-1">Tanggal Lahir</td>
                            <td class="p-1 m-1">:</td>
                            <td class="p-1 m-1 font-semibold">
                                {{ isset($dataPasien['pasien']['tglLahir']) ? $dataPasien['pasien']['tglLahir'] : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="p-1 m-1">Alamat</td>
                            <td class="p-1 m-1">:</td>
                            <td class="p-1 m-1 font-semibold">
                                {{ isset($dataPasien['pasien']['identitas']['alamat']) ? $dataPasien['pasien']['identitas']['alamat'] : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="p-1 m-1">Klaim</td>
                            <td class="p-1 m-1">:</td>
                            <td class="p-1 m-1 font-semibold">
                                @isset($dataDaftarUgd['klaimId'])
                                    {{ $dataDaftarUgd['klaimId'] == 'UM'
                                        ? 'UMUM'
                                        : ($dataDaftarUgd['klaimId'] == 'JM'
                                            ? 'BPJS'
                                            : ($dataDaftarUgd['klaimId'] == 'KR'
                                                ? 'Kronis'
                                                : 'Asuransi Lain')) }}
                                    /
                                    {{ 'UGD' }}
                                @else
                                    '-' /
                                    {{ 'UGD' }}
                                @endisset

                            </td>
                        </tr>

                        <tr>
                            <td class="p-1 m-1">NIK/Id BPJS</td>
                            <td class="p-1 m-1">:</td>
                            <td class="p-1 m-1 font-semibold">
                                {{ isset($dataPasien['pasien']['identitas']['nik']) ? $dataPasien['pasien']['identitas']['nik'] : '-' }}
                                /
                                {{ isset($dataPasien['pasien']['identitas']['idbpjs']) ? $dataPasien['pasien']['identitas']['idbpjs'] : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="p-1 m-1">No SEP</td>
                            <td class="p-1 m-1">:</td>
                            <td class="p-1 m-1 font-semibold">
                                {{ isset($dataDaftarUgd['sep']['noSep']) ? $dataDaftarUgd['sep']['noSep'] : '-' }}
                            </td>
                        </tr>



                    </tbody>
                </table>
            </div>

            {{-- Obat --}}
            <div class="w-1/2 h-5 bg-blue-500 ">
                <table style="font-size: 10px " class="w-1/2 table-auto">
                    <thead class="text-gray-900 ">
                        <tr>
                            <th>
                                Jenis
                            </th>

                            <th class="text-start">
                                Nama Obat
                            </th>

                            <th>
                                Jumlah
                            </th>

                            <th>
                                Signa
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900 ">
                        @isset($dataDaftarUgd['eresep'])
                            @foreach ($dataDaftarUgd['eresep'] as $key => $eresep)
                                <tr class="border-b-2 border-black">
                                    <td class="w-1/5 text-center uppercase">
                                        {{ 'R/' }}
                                    </td>

                                    <td class="w-2/5 uppercase text-start">
                                        {{ $eresep['productName'] }}
                                    </td>

                                    <td class="w-1/5 text-center uppercase">
                                        {{ 'No. ' . $eresep['qty'] }}
                                    </td>

                                    <td class="w-1/5 text-center uppercase">
                                        {{ 'S ' . $eresep['signaX'] . 'dd' . $eresep['signaHari'] }}
                                        @if ($eresep['catatanKhusus'])
                                            {{ ' (' . $eresep['catatanKhusus'] . ')' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>

                    <tbody class="text-gray-900 ">
                        @isset($dataDaftarUgd['eresepRacikan'])
                            @php
                                $myPreviousRow = '';
                            @endphp
                            @foreach ($dataDaftarUgd['eresepRacikan'] as $key => $eresepRacikan)
                                @php
                                    $myRacikanBorder =
                                        $myPreviousRow !== $eresepRacikan['noRacikan'] ? 'border-t-2 border-black' : '';
                                @endphp

                                <tr class="{{ $myRacikanBorder }}">
                                    <td class="w-1/5 text-center uppercase">
                                        {{ $eresepRacikan['noRacikan'] . '/' }}
                                    </td>

                                    <td class="w-2/5 uppercase text-start">
                                        {{ $eresepRacikan['productName'] }}

                                        @isset($eresepRacikan['dosis'])
                                            {{ ' - ' . $eresepRacikan['dosis'] }}
                                        @endisset
                                    </td>

                                    <td class="w-1/5 text-center uppercase">
                                        @if ($eresepRacikan['qty'])
                                            {{ 'Jml Racikan ' . $eresepRacikan['qty'] }}
                                        @else
                                            {{ '' }}
                                        @endif
                                    </td>

                                    <td class="w-1/5 text-center uppercase">
                                        @if ($eresepRacikan['qty'])
                                            {{ '(' . $eresepRacikan['catatan'] . ') ' . 'S ' . $eresepRacikan['catatanKhusus'] }}
                                        @else
                                            {{ '' }}
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $myPreviousRow = $eresepRacikan['noRacikan'];
                                @endphp
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>

        {{-- telaah Resep / Obat --}}
        <div class="absolute top-0 right-0 w-1/2 ">
            <table style="font-size: 10px " class="w-1/2 table-auto ">
                <tbody class="text-gray-900 ">

                    <tr>
                        {{-- telaah Resep --}}
                        <td class="align-text-top ">
                            <table style="font-size: 10px " class="w-1/2 table-auto">
                                <thead class="text-gray-900 ">
                                    <tr>
                                        <th class="text-start">
                                            Telaah Resep
                                        </th>

                                        <th class="text-start">
                                            *
                                        </th>

                                        <th class="text-start">
                                            Ket.
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-900 ">

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Kejelasan Tulisan Resep' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['kejelasanTulisanResep']['kejelasanTulisanResep'])
                                                ? ($dataDaftarUgd['telaahResep']['kejelasanTulisanResep']['kejelasanTulisanResep']
                                                    ? $dataDaftarUgd['telaahResep']['kejelasanTulisanResep']['kejelasanTulisanResep']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['kejelasanTulisanResep']['desc'])
                                                ? ($dataDaftarUgd['telaahResep']['kejelasanTulisanResep']['desc']
                                                    ? $dataDaftarUgd['telaahResep']['kejelasanTulisanResep']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Tepat Obat' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['tepatObat']['tepatObat'])
                                                ? ($dataDaftarUgd['telaahResep']['tepatObat']['tepatObat']
                                                    ? $dataDaftarUgd['telaahResep']['tepatObat']['tepatObat']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['tepatObat']['desc'])
                                                ? ($dataDaftarUgd['telaahResep']['tepatObat']['desc']
                                                    ? $dataDaftarUgd['telaahResep']['tepatObat']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Tepat Dosis' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['tepatDosis']['tepatDosis'])
                                                ? ($dataDaftarUgd['telaahResep']['tepatDosis']['tepatDosis']
                                                    ? $dataDaftarUgd['telaahResep']['tepatDosis']['tepatDosis']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['tepatDosis']['desc'])
                                                ? ($dataDaftarUgd['telaahResep']['tepatDosis']['desc']
                                                    ? $dataDaftarUgd['telaahResep']['tepatDosis']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Tepat Rute' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['tepatRute']['tepatRute'])
                                                ? ($dataDaftarUgd['telaahResep']['tepatRute']['tepatRute']
                                                    ? $dataDaftarUgd['telaahResep']['tepatRute']['tepatRute']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['tepatRute']['desc'])
                                                ? ($dataDaftarUgd['telaahResep']['tepatRute']['desc']
                                                    ? $dataDaftarUgd['telaahResep']['tepatRute']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Tepat Waktu' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['tepatWaktu']['tepatWaktu'])
                                                ? ($dataDaftarUgd['telaahResep']['tepatWaktu']['tepatWaktu']
                                                    ? $dataDaftarUgd['telaahResep']['tepatWaktu']['tepatWaktu']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['tepatWaktu']['desc'])
                                                ? ($dataDaftarUgd['telaahResep']['tepatWaktu']['desc']
                                                    ? $dataDaftarUgd['telaahResep']['tepatWaktu']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Duplikasi' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['duplikasi']['duplikasi'])
                                                ? ($dataDaftarUgd['telaahResep']['duplikasi']['duplikasi']
                                                    ? $dataDaftarUgd['telaahResep']['duplikasi']['duplikasi']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['duplikasi']['desc'])
                                                ? ($dataDaftarUgd['telaahResep']['duplikasi']['desc']
                                                    ? $dataDaftarUgd['telaahResep']['duplikasi']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Alergi' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['alergi']['alergi'])
                                                ? ($dataDaftarUgd['telaahResep']['alergi']['alergi']
                                                    ? $dataDaftarUgd['telaahResep']['alergi']['alergi']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['alergi']['desc'])
                                                ? ($dataDaftarUgd['telaahResep']['alergi']['desc']
                                                    ? $dataDaftarUgd['telaahResep']['alergi']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Interaksi Obat' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['interaksiObat']['interaksiObat'])
                                                ? ($dataDaftarUgd['telaahResep']['interaksiObat']['interaksiObat']
                                                    ? $dataDaftarUgd['telaahResep']['interaksiObat']['interaksiObat']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['interaksiObat']['desc'])
                                                ? ($dataDaftarUgd['telaahResep']['interaksiObat']['desc']
                                                    ? $dataDaftarUgd['telaahResep']['interaksiObat']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Berat Badan Pasien Anak' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['bbPasienAnak']['bbPasienAnak'])
                                                ? ($dataDaftarUgd['telaahResep']['bbPasienAnak']['bbPasienAnak']
                                                    ? $dataDaftarUgd['telaahResep']['bbPasienAnak']['bbPasienAnak']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['bbPasienAnak']['desc'])
                                                ? ($dataDaftarUgd['telaahResep']['bbPasienAnak']['desc']
                                                    ? $dataDaftarUgd['telaahResep']['bbPasienAnak']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Kontra Indikasi Lain' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['kontraIndikasiLain']['kontraIndikasiLain'])
                                                ? ($dataDaftarUgd['telaahResep']['kontraIndikasiLain']['kontraIndikasiLain']
                                                    ? $dataDaftarUgd['telaahResep']['kontraIndikasiLain']['kontraIndikasiLain']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahResep']['kontraIndikasiLain']['desc'])
                                                ? ($dataDaftarUgd['telaahResep']['kontraIndikasiLain']['desc']
                                                    ? $dataDaftarUgd['telaahResep']['kontraIndikasiLain']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </td>

                        {{-- telaah Obat --}}
                        <td class="align-text-top">
                            <table style="font-size: 10px " class="w-1/2 ml-4 table-auto">
                                <thead class="text-gray-900 ">
                                    <tr>
                                        <th class="text-start">
                                            Telaah Obat
                                        </th>

                                        <th class="text-start">
                                            *
                                        </th>

                                        <th class="text-start">
                                            Ket.
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-900 ">

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Obat dgn resep' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahObat']['obatdgnResep']['obatdgnResep'])
                                                ? ($dataDaftarUgd['telaahObat']['obatdgnResep']['obatdgnResep']
                                                    ? $dataDaftarUgd['telaahObat']['obatdgnResep']['obatdgnResep']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahObat']['obatdgnResep']['desc'])
                                                ? ($dataDaftarUgd['telaahObat']['obatdgnResep']['desc']
                                                    ? $dataDaftarUgd['telaahObat']['obatdgnResep']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Jml / Dosis dgn resep' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahObat']['jmlDosisdgnResep']['jmlDosisdgnResep'])
                                                ? ($dataDaftarUgd['telaahObat']['jmlDosisdgnResep']['jmlDosisdgnResep']
                                                    ? $dataDaftarUgd['telaahObat']['jmlDosisdgnResep']['jmlDosisdgnResep']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahObat']['jmlDosisdgnResep']['desc'])
                                                ? ($dataDaftarUgd['telaahObat']['jmlDosisdgnResep']['desc']
                                                    ? $dataDaftarUgd['telaahObat']['jmlDosisdgnResep']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Ruter dgn resep' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahObat']['rutedgnResep']['rutedgnResep'])
                                                ? ($dataDaftarUgd['telaahObat']['rutedgnResep']['rutedgnResep']
                                                    ? $dataDaftarUgd['telaahObat']['rutedgnResep']['rutedgnResep']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahObat']['rutedgnResep']['desc'])
                                                ? ($dataDaftarUgd['telaahObat']['rutedgnResep']['desc']
                                                    ? $dataDaftarUgd['telaahObat']['rutedgnResep']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-3/5 text-start">
                                            {{ 'Waktu dan Frekuensi pemberian dgn resep' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahObat']['waktuFrekPemberiandgnResep']['waktuFrekPemberiandgnResep'])
                                                ? ($dataDaftarUgd['telaahObat']['waktuFrekPemberiandgnResep']['waktuFrekPemberiandgnResep']
                                                    ? $dataDaftarUgd['telaahObat']['waktuFrekPemberiandgnResep']['waktuFrekPemberiandgnResep']
                                                    : '-')
                                                : '-' }}
                                        </td>

                                        <td class="w-1/5 text-start">
                                            {{ isset($dataDaftarUgd['telaahObat']['waktuFrekPemberiandgnResep']['desc'])
                                                ? ($dataDaftarUgd['telaahObat']['waktuFrekPemberiandgnResep']['desc']
                                                    ? $dataDaftarUgd['telaahObat']['waktuFrekPemberiandgnResep']['desc']
                                                    : '-')
                                                : '-' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>

        {{-- ttd --}}
        <div class="absolute left-0 w-full bottom-32">
            <table style="font-size: 10px " class="w-full table-auto">
                <tbody>

                    @inject('carbon', 'Carbon\Carbon')
                    <td class="w-1/3 ">
                        <div class ="text-center">
                            <span>
                                Tulungagung,{{ isset($dataDaftarUgd['rjDate'])
                                    ? ($dataDaftarUgd['rjDate']
                                        ? $dataDaftarUgd['rjDate']
                                        : 'Tanggal')
                                    : 'Tanggal' }}
                            </span>
                            <div>
                                @isset($dataDaftarUgd['perencanaan']['pengkajianMedis']['drPemeriksa'])
                                    @if ($dataDaftarUgd['perencanaan']['pengkajianMedis']['drPemeriksa'])
                                        @isset(App\Models\User::where('myuser_code', $dataDaftarUgd['drId'])->first()->myuser_ttd_image)
                                            <img class="h-24 mx-auto"
                                                src="{{ 'storage/' . App\Models\User::where('myuser_code', $dataDaftarUgd['drId'])->first()->myuser_ttd_image }}"
                                                alt="">
                                        @endisset
                                    @endif
                                @endisset
                            </div>

                            <span>
                                {{ isset($dataDaftarUgd['perencanaan']['pengkajianMedis']['drPemeriksa'])
                                    ? ($dataDaftarUgd['perencanaan']['pengkajianMedis']['drPemeriksa']
                                        ? $dataDaftarUgd['perencanaan']['pengkajianMedis']['drPemeriksa']
                                        : 'Dokter Pemeriksa')
                                    : 'Dokter Pemeriksa' }}
                            </span>

                            <div>
                                @isset($dataDaftarUgd['perencanaan']['pengkajianMedis']['drPemeriksa'])
                                    @if ($dataDaftarUgd['perencanaan']['pengkajianMedis']['drPemeriksa'])
                                        @isset(App\Models\User::where('myuser_code', $dataDaftarUgd['drId'])->first()->myuser_sip)
                                            <span>
                                                {{ App\Models\User::where('myuser_code', $dataDaftarUgd['drId'])->first()->myuser_sip }}
                                            </span>
                                        @endisset
                                    @endif
                                @endisset
                            </div>

                        </div>
                    </td>



                    <td class="w-1/3 align-text-bottom">
                        <div class ="text-center">
                            <span>
                                {{ 'Telaah Resep' }}
                            </span>
                            <br>
                            <div>
                                @isset($dataDaftarUgd['telaahResep']['penanggungJawab']['userLog'])
                                    @if ($dataDaftarUgd['telaahResep']['penanggungJawab']['userLog'])
                                        @isset(App\Models\User::where('myuser_code', $dataDaftarUgd['telaahResep']['penanggungJawab']['userLogCode'])->first()->myuser_ttd_image)
                                            <img class="h-24 mx-auto"
                                                src="{{ 'storage/' . App\Models\User::where('myuser_code', $dataDaftarUgd['telaahResep']['penanggungJawab']['userLogCode'])->first()->myuser_ttd_image }}"
                                                alt="">
                                        @endisset
                                    @endif
                                @endisset
                            </div>
                            <br>
                            <span>
                                {{ isset($dataDaftarUgd['telaahResep']['penanggungJawab']['userLog'])
                                    ? ($dataDaftarUgd['telaahResep']['penanggungJawab']['userLog']
                                        ? $dataDaftarUgd['telaahResep']['penanggungJawab']['userLog']
                                        : 'Telaah Resep')
                                    : 'Telaah Resep' }}
                            </span>



                        </div>
                    </td>

                    <td class="w-1/3 align-text-bottom">
                        <div class ="text-center">
                            <span>
                                {{ 'Telaah Obat' }}
                            </span>
                            <br>
                            <div>
                                @isset($dataDaftarUgd['telaahObat']['penanggungJawab']['userLog'])
                                    @if ($dataDaftarUgd['telaahObat']['penanggungJawab']['userLog'])
                                        @isset(App\Models\User::where('myuser_code', $dataDaftarUgd['telaahObat']['penanggungJawab']['userLogCode'])->first()->myuser_ttd_image)
                                            <img class="h-24 mx-auto"
                                                src="{{ 'storage/' . App\Models\User::where('myuser_code', $dataDaftarUgd['telaahObat']['penanggungJawab']['userLogCode'])->first()->myuser_ttd_image }}"
                                                alt="">
                                        @endisset
                                    @endif
                                @endisset
                            </div>
                            <br>
                            <span>
                                {{ isset($dataDaftarUgd['telaahObat']['penanggungJawab']['userLog'])
                                    ? ($dataDaftarUgd['telaahObat']['penanggungJawab']['userLog']
                                        ? $dataDaftarUgd['telaahObat']['penanggungJawab']['userLog']
                                        : 'Telaah Obat')
                                    : 'Telaah Obat' }}
                            </span>



                        </div>
                    </td>

                </tbody>
            </table>
        </div>
    </div>










</body>

</html>
