<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: 6cm 4cm;
            margin: 2px;
        }
    </style>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link href="build/assets/sirus.css" rel="stylesheet">
</head>

<body>
    <table class="w-full">
        <tr>
            <td class="text-start">
                <img src="madinahlogo.png" class="object-fill h-8">
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




    <table style="font-size: 9px">
        <tr class="font-bold">
            <td>
                <p><span>RegNo</span></p>
            </td>
            <td>
                <p>
                    <span>:
                        {{ isset($data['regNo']) ? ($data['regNo'] ? $data['regNo'] : '-') : '--' }}
                    </span>
                    <span class="ml-16">

                    </span>
                </p>
            </td>
        </tr>
        {{-- <tr class="font-bold">
            <td>
                <p><span>NIK</span></p>
            </td>
            <td>
                <p>
                    <span>:
                        {{ isset($data['identitas']['nik']) ? ($data['identitas']['nik'] ? $data['identitas']['nik'] : '-') : '--' }}
                    </span>
                    <span class="ml-16">

                    </span>
                </p>
            </td>
        </tr> --}}
        <tr class="font-bold">
            <td>
                <p><span>Pasien</span></p>
            </td>
            <td>
                <p style="font-size: 11px">
                    <span>:
                        {{ isset($data['regName']) ? ($data['regName'] ? $data['regName'] : '-') : '--' }}
                    </span>
                    <span>/
                        {{ isset($data['jenisKelamin']['jenisKelaminDesc']) ? ($data['jenisKelamin']['jenisKelaminDesc'] ? $data['jenisKelamin']['jenisKelaminDesc'] : '-') : '--' }}
                    </span>
                </p>
            </td>

        </tr>
        <tr>
            <td>
                <p><span>TTL</span></p>
            </td>
            <td>
                <p>
                    <span>:
                        {{ isset($data['tglLahir']) ? ($data['tglLahir'] ? $data['tglLahir'] : '-') : '--' }}
                    </span>
                    <span>/
                        {{ isset($data['thn']) ? ($data['thn'] ? $data['thn'] : '-') : '--' }}
                    </span>
                    <span>/
                        {{ isset($data['tempatLahir']) ? ($data['tempatLahir'] ? $data['tempatLahir'] : '-') : '--' }}
                    </span>
                </p>
            </td>

        </tr>
        {{-- <tr>
            <td>
                <p><span>Hp</span></p>
            </td>
            <td>
                <p>
                    <span>:
                        {{ isset($data['kontak']['nomerTelponSelulerPasien']) ? ($data['kontak']['nomerTelponSelulerPasien'] ? $data['kontak']['nomerTelponSelulerPasien'] : '-') : '--' }}
                    </span>
                </p>
            </td>
        </tr> --}}
        <tr>
            <td>
                <p><span>Alamat</span></p>
            </td>
            <td>
                <p>
                    <span>:
                        {{ isset($data['identitas']['alamat']) ? ($data['identitas']['alamat'] ? $data['identitas']['alamat'] : '-') : '--' }}
                    </span>
                </p>
            </td>
        </tr>

    </table>

    <table class="w-full">
        <tr>
            @php
                $regNo = isset($data['regNo']) ? ($data['regNo'] ? $data['regNo'] : '-') : '--';
            @endphp
            <td class="w-1/2 text-white">
                <span>{!! DNS1D::getBarcodeHTML($regNo, 'C39', 1) !!}</span>
            </td>
            <td class="w-1/3">
                <p>
                    <span>{!! DNS2D::getBarcodeHTML($regNo, 'QRCODE', 1.5, 1.5) !!}</span>
                </p>
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
</body>

</html>
