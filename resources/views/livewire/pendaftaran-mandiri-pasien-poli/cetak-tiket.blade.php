<html>

<head>
    <style>
        @page {
            size: 8cm 10cm;
        }

        html {
            margin: 8px
        }

        p {
            margin: 0;
            padding: 0;
        }
    </style>


</head>

<body>

    <p style="text-align: center;"><strong><span style="font-size: 18px; font-family: Arial, Helvetica, sans-serif;">Rumah
                Sakit Islam Madinah
            </span>
        </strong>
    </p>
    <p style="text-align: center;"><span style="font-family: Arial, Helvetica, sans-serif;"><em><span
                    style="font-size: 12px;">Jl. Jatiwayang Lk. 2 - Ngunut Tulungagung
                </span>
            </em>
        </span>
    </p>
    <p style="text-align: center;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">(0355) 349
            1131 / WA : 0858 0720 1634
        </span>
    </p>
    <br />
    <p style="text-align: center;"><span
            style="font-family: Arial, Helvetica, sans-serif; font-size: 14px;"><strong>Antrian Poli
            </strong>
        </span>
    </p>
    <p style="text-align: center;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><strong>
                {{ 'Pasien : ' . $dataDaftarPasienPoli['regNo'] . ' / ' . $dataDaftarPasienPoli['regName'] }}
            </strong>
        </span>
    </p>
    <p style="text-align: center;">
        <span style="font-family: Arial, Helvetica, sans-serif; font-size: 96px;">
            <strong>
                {{ $dataDaftarPasienPoli['noAntrian'] }}
            </strong>
        </span>
    </p>
    <p style="text-align: center;">
        <span style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
            {{ $dataDaftarPasienPoli['rjDate'] }}
        </span>
    </p>
    <p style="text-align: center;"><span style="font-family: Georgia, serif; font-size: 14px;">
            <strong>
                {{ $dataDaftarPasienPoli['poliDesc'] }}
            </strong>
        </span>
    </p>
    <p style="text-align: center;"><span style="font-family: Georgia, serif; font-size: 12px;">
            {{ $dataDaftarPasienPoli['drName'] }}
        </span>
    </p>

</body>


</html>
