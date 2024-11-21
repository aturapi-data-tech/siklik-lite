<div class="bg-white ">

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

    <div>
        @php
            $statusBPJS = $checkStatusKlaimPasien['metadata']['code'] ?? '';
            $messageBPJS = $checkStatusKlaimPasien['metadata']['message'] ?? '';
        @endphp

        @if ($statusBPJS === 200)
            <div class="text-2xl font-semibold text-gray-700">Status BPJS</div>

            <div class="font-normal text-gray-700">
                NoKa :{{ $checkStatusKlaimPasien['response']['noKartu'] ?? '' }}
                /
                NIK :{{ $checkStatusKlaimPasien['response']['noKTP'] ?? '' }}
            </div>
            <div class="font-normal text-gray-700">
                {{ $checkStatusKlaimPasien['response']['nama'] ?? '' }}
                /
                {{ $checkStatusKlaimPasien['response']['sex'] ?? '' }}
                /
                {{ $checkStatusKlaimPasien['response']['hubunganKeluarga'] ?? '' }}
            </div>
            <div class="font-normal text-gray-700">
                Provider :{{ $checkStatusKlaimPasien['response']['kdProviderPst']['kdProvider'] ?? '' }}
                {{ $checkStatusKlaimPasien['response']['kdProviderPst']['nmProvider'] ?? '' }}
            </div>
            <div class="font-normal text-gray-700">
                Provider Gigi:{{ $checkStatusKlaimPasien['response']['kdProviderGigi']['kdProvider'] ?? '' }}
                {{ $checkStatusKlaimPasien['response']['kdProviderGigi']['nmProvider'] ?? '' }}
            </div>
            <div class="font-normal text-gray-700">
                {{ $checkStatusKlaimPasien['response']['jnsKelas']['nama'] ?? '' }}
            </div>
            <div class="font-normal text-gray-700">
                {{ $checkStatusKlaimPasien['response']['jnsPeserta']['nama'] ?? '' }}
            </div>
            <div class="font-normal text-gray-700">
                No HP :{{ $checkStatusKlaimPasien['response']['noHP'] ?? '' }}
            </div>
            <div class="font-normal text-gray-700">
                @php
                    $statusPasien = $checkStatusKlaimPasien['response']['aktif'] ?? false;
                    $statusPasienDesc = $statusPasien ? 'Aktif' : 'Tidak Aktif';
                    $statusPasienbgColor = $statusPasien ? 'green' : 'red';
                @endphp
                <x-badge :badgecolor="__($statusPasienbgColor)">
                    Status : {{ $statusPasienDesc }}
                </x-badge>
            </div>
            <div class="font-normal text-gray-700">
                Tunggakan :{{ $checkStatusKlaimPasien['response']['tunggakan'] ?? '' }}
            </div>
        @else
            <div class="italic font-normal text-gray-700 my-7">
                {{ $messageBPJS }}
                {{ json_encode($checkStatusKlaimPasien) }}
            </div>
        @endif
    </div>

</div>
