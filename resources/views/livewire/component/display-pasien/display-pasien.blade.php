<div class="flex justify-between bg-white">

    <div>
        <div class="text-base font-semibold text-gray-700">
            {{ $displayPasien['pasien']['regNo'] }}
        </div>

        <div class="text-2xl font-semibold text-primary">
            {{ strtoupper($displayPasien['pasien']['regName']) . ' / (' . $displayPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] . ')' . ' / ' . $displayPasien['pasien']['thn'] }}
        </div>

        <div class="font-normal text-gray-700">
            {{ $displayPasien['pasien']['identitas']['alamat'] }}
        </div>

        <div class="font-normal text-gray-700">
            {{ $displayPasien['pasien']['identitas']['nik'] }}
        </div>

        <div class="font-normal text-gray-700">
            {{ isset($displayPasien['pasien']['identitas']['idBpjs']) ? $displayPasien['pasien']['identitas']['idBpjs'] : '-' }}
        </div>

        <div class="font-normal text-gray-700">
            {{ $displayPasien['pasien']['kontak']['nomerTelponSelulerPasien'] }}
        </div>

        <div class="font-normal text-gray-700">
            {{ $displayPasien['pasien']['hubungan']['namaPenanggungJawab'] }}
        </div>



    </div>



</div>
