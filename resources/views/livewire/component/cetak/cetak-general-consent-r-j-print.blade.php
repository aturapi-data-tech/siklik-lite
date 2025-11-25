<!DOCTYPE html>
<html lang="id">

<head>
    <style>
        @page {
            size: A4;
            margin: 15px;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Tailwind bundle kamu --}}
    <link href="build/assets/sirus.css" rel="stylesheet">
</head>


<body class="text-xs">

    @php
        // --- Data RS ---
        $rs = $identitasRs ?? null;

        // --- Data pasien (support 2 bentuk: ['pasien'=>[]] atau langsung []) ---
        $rawPasien = $dataPasien['pasien'] ?? ($dataPasien ?? []);
        $pasien = (array) $rawPasien;

        $rm = (string) ($pasien['regNo'] ?? '');
        $nama = (string) ($pasien['regName'] ?? '');
        $nik = (string) data_get($pasien, 'identitas.nik', '');
        $alamat = (string) data_get($pasien, 'identitas.alamat', '');
        $bpjs = (string) data_get($pasien, 'identitas.idbpjs', '');

        // --- Data kunjungan Rawat Jalan ---
        $dataRj = (array) ($dataRJ ?? []);
        $klaim = (string) ($dataRj['klaim'] ?? ($dataRj['klaim_id'] ?? 'BPJS'));
        $tglKunjungan = (string) ($dataRj['entryDate'] ?? ($dataRj['rjDate'] ?? '-'));
        $noKunjungan = (string) ($dataRj['rjNo'] ?? $rm);

        // --- Data General Consent Rawat Jalan ---
        $consent = (array) ($consent ?? ($dataRj['generalConsentPasienRJ'] ?? []));

        $namaPenandatangan = (string) ($consent['wali'] ?? $nama);
        $hubunganPenandatangan = 'Pasien / Wali';
        $tglPersetujuan = (string) ($consent['signatureDate'] ?? ($tglKunjungan ?? '-'));

        // tanda tangan pasien/wali (SVG string dari canvas)
        $sigRaw = trim((string) ($consent['signature'] ?? ''));
        if (\Illuminate\Support\Str::startsWith($sigRaw, '<svg')) {
            $sigSrc = 'data:image/svg+xml;base64,' . base64_encode($sigRaw);
        } else {
            $sigSrc = $sigRaw; // bisa sudah base64 png/jpg atau kosong
        }

        // data petugas pemeriksa
        $petugasName = (string) ($consent['petugasPemeriksa'] ?? '');
        $petugasCode = (string) ($consent['petugasPemeriksaCode'] ?? '');
        $petugasDate = (string) ($consent['petugasPemeriksaDate'] ?? '');

        $ttdPetugas = null;
        if (!empty($petugasCode)) {
            $user = App\Models\User::where('myuser_code', $petugasCode)->first();
            if ($user && $user->myuser_ttd_image) {
                $ttdPetugas = asset('storage/' . $user->myuser_ttd_image);
            }
        }
    @endphp

    {{-- =========================================
         HEADER: IDENTITAS RS + PASIEN
    ========================================== --}}
    <table class="w-full p-1 border border-separate border-black rounded-md">
        <tr>
            {{-- Kanan: identitas pasien & kunjungan --}}
            <td class="align-top border-0">
                <table class="w-full border-0 border-collapse text-[11px]">
                    <tr class="border-b">
                        <td class="w-[140px] py-1 pr-2 text-gray-700">Nama Pasien</td>
                        <td class="py-1">
                            <span class="font-bold">{{ strtoupper($nama ?: '-') }}</span>
                            <span class="font-normal">
                                / {{ $pasien['jenisKelamin']['jenisKelaminDesc'] ?? '-' }} /
                                {{ $pasien['thn'] ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-1 pr-2 text-gray-700">No Rekam Medis</td>
                        <td class="py-1 font-extrabold text-[13px]">{{ $rm ?: '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-1 pr-2 text-gray-700">NIK</td>
                        <td class="py-1">{{ $nik ?: '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-1 pr-2 text-gray-700">Alamat</td>
                        <td class="py-1">{{ $alamat ?: '-' }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-1 pr-2 text-gray-700">ID BPJS</td>
                        <td class="py-1">
                            {{ $bpjs ?: '-' }}
                            <span class="ml-6 text-gray-700">Klaim :</span>
                            <span class="ml-1">{{ $klaim }}</span>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-1 pr-2 text-gray-700">Tanggal / Jam Kunjungan</td>
                        <td class="py-1">{{ $tglKunjungan ?? '-' }}</td>
                    </tr>
                </table>
            </td>

            {{-- Kiri: logo & identitas RS --}}
            <td class="align-top w-[180px] border-0">
                {{-- <table class="w-full border-0 border-collapse">
                    <tr>
                        <td class="pb-1 text-center">
                            <img src="madinahlogopersegi.png" alt="Logo"
                                class="inline-block object-contain w-auto h-20">
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center leading-tight text-[10px]">
                            <div class="font-bold uppercase">
                                {{ $rs->int_name ?? 'RUMAH SAKIT' }}
                            </div>
                            <div class="mt-1">
                                {{ trim($rs->int_address ?? '-') }}<br>
                                {{ strtoupper($rs->int_city ?? '') }}
                            </div>
                            @php
                                $tel1 = $rs->int_phone1 ?? null;
                                $tel2 = $rs->int_phone2 ?? null;
                                $fax = $rs->int_fax ?? null;
                            @endphp
                            @if ($tel1)
                                <div>{{ $tel1 }}</div>
                            @endif
                            @if ($tel2)
                                <div>{{ $tel2 }}</div>
                            @endif
                            @if ($fax)
                                <div>Fax: {{ $fax }}</div>
                            @endif
                        </td>
                    </tr>
                </table> --}}
                <table class="w-full mb-2 table-auto">
                    <tr>
                        <td class="w-2/3 align-top"></td>

                        <td class="w-1/3 text-right align-top">
                            <img src="madinahlogopersegi.png" class="object-fill h-16 ml-auto">
                            <div class="mt-1 text-xs leading-tight text-right">
                                <span class="text-sm font-bold">Klinik Madinah Pratama</span><br>
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
            </td>


        </tr>
    </table>


    {{-- =========================================
         JUDUL FORM
    ========================================== --}}
    <div class="mt-2 mb-1 text-sm font-bold text-center underline">
        FORMULIR PERSETUJUAN UMUM RAWAT JALAN
    </div>

    {{-- =========================================
         ISI FORM
    ========================================== --}}

    {{-- A. PERNYATAAN PERSETUJUAN --}}
    <div class="mt-1 font-bold text-[11px]">
        A. Pernyataan Persetujuan
    </div>
    <ol class="mt-1 pl-4 text-[10px] leading-snug list-decimal text-justify">
        <li>
            Dengan ini, saya memberikan persetujuan untuk menerima pelayanan kesehatan di
            Pelayanan Rawat Jalan sesuai dengan kondisi saya.
        </li>
        <li>
            Saya telah menerima penjelasan mengenai hak dan kewajiban saya sebagai pasien
            sebagaimana diatur dalam peraturan perundang-undangan yang berlaku.
        </li>
    </ol>

    {{-- <div class="mt-1 text-[9px] leading-snug text-justify">
        Dasar hukum:
    </div>
    <ol class="mt-1 pl-6 text-[9px] leading-snug list-[lower-alpha] text-justify">
        <li>Undang-Undang Nomor 17 Tahun 2023 tentang Hak dan Kewajiban Pasien. Permenkes Nomor 4 Tahun 2018 tentang
            Kewajiban Klinik dan Kewajiban Pasien.</li>
    </ol> --}}

    {{-- B. HAK SEBAGAI PASIEN --}}
    <div class="mt-2 font-bold text-[11px]">
        B. Hak Sebagai Pasien
    </div>
    <ol class="mt-1 pl-4 text-[10px] leading-snug list-decimal text-justify">
        <li>Mendapatkan informasi mengenai kesehatan dirinya.</li>
        <li>Mendapatkan kejelasan yang memadai mengenai pelayanan kesehatan yang diterimanya.</li>
        <li>
            Mendapatkan pelayanan kesehatan sesuai dengan kebutuhan medis,
            standar profesi, dan pelayanan yang bermutu.
        </li>
        <li>
            Menolak atau menyetujui tindakan medis, kecuali untuk tindakan medis
            yang diperlukan dalam rangka pencegahan penyakit menular dan penanggulangan KLB atau wabah.
        </li>
        <li>Mendapatkan akses terhadap informasi yang terdapat dalam rekam medis.</li>
        <li>Menerima pendapat tenaga medis atau tenaga kesehatan lainnya (second opinion).</li>
        <li>Mendapatkan hak-hak lain sesuai dengan ketentuan peraturan perundang-undangan.</li>
    </ol>

    {{-- C. KEWAJIBAN SEBAGAI PASIEN --}}
    <div class="mt-2 font-bold text-[11px]">
        C. Kewajiban Sebagai Pasien
    </div>
    <ol class="mt-1 pl-4 text-[10px] leading-snug list-decimal text-justify">
        <li>Memberikan informasi yang lengkap dan jujur tentang masalah kesehatannya.</li>
        <li>Mematuhi nasihat dan petunjuk tenaga medis dan tenaga kesehatan.</li>
        <li>Mematuhi ketentuan dan tata tertib yang berlaku pada fasilitas pelayanan kesehatan.</li>
        <li>Memberikan imbalan jasa atas pelayanan yang diterima sesuai dengan ketentuan yang berlaku.</li>
    </ol>

    {{-- D. PEMAHAMAN --}}
    <div class="mt-2 font-bold text-[11px]">
        D. Pemahaman
    </div>
    <ol class="mt-1 pl-4 text-[10px] leading-snug list-decimal text-justify">
        <li>
            Saya telah menerima penjelasan singkat mengenai hak dan kewajiban saya sebagai pasien Rawat Jalan.
        </li>
        <li>
            Saya memahami risiko tindakan medis yang mungkin diperlukan.
        </li>
    </ol>

    {{-- E. PERSETUJUAN --}}
    <div class="mt-2 font-bold text-[11px]">
        E. Persetujuan
    </div>
    <ol class="mt-1 pl-4 text-[10px] leading-snug list-decimal text-justify">
        <li>
            Saya menyetujui pemeriksaan, pengobatan, atau tindakan medis yang dianggap perlu oleh tim medis Rawat Jalan.
        </li>
        <li>
            Termasuk tindakan medis dalam situasi darurat atau untuk menyelamatkan nyawa saya.
        </li>
    </ol>

    {{-- F. PELEPASAN INFORMASI --}}
    <div class="mt-2 font-bold text-[11px]">
        F. Pelepasan Informasi
    </div>
    <ol class="mt-1 pl-4 text-[10px] leading-snug list-decimal text-justify">
        <li>
            Saya memberikan izin kepada rumah sakit untuk berbagi informasi medis saya kepada pihak-pihak terkait
            untuk kepentingan penanganan medis, antara lain:
        </li>
    </ol>
    <ol class="mt-1 pl-6 text-[10px] leading-snug list-[lower-alpha] text-justify">
        <div>
            <span class="inline-block pr-2"><strong>a.</strong> Keluarga</span>
            <span class="inline-block pr-2"><strong>b.</strong> Dokter rujukan</span>
            <span class="inline-block pr-2"><strong>c.</strong> Penyedia asuransi</span>
            <span class="inline-block"><strong>d.</strong> Pihak lain yang berwenang sesuai ketentuan peraturan
                perundang-undangan</span>
        </div>
    </ol>

    {{-- G. BARANG BENDA --}}
    <div class="mt-2 font-bold text-[11px]">
        G. Barang Benda
    </div>
    <ol class="mt-1 pl-4 text-[10px] leading-snug list-decimal text-justify">
        <li>
            Saya memahami bahwa rumah sakit tidak bertanggung jawab atas kehilangan atau kerusakan barang berharga
            yang saya bawa ke Rawat Jalan.
        </li>
    </ol>

    {{-- H. BIAYA --}}
    <div class="mt-2 font-bold text-[11px]">
        H. Biaya
    </div>
    <ol class="mt-1 pl-4 text-[10px] leading-snug list-decimal text-justify">
        <li>
            Saya memahami bahwa saya bertanggung jawab atas biaya yang timbul selama perawatan di Rawat Jalan,
            sesuai dengan ketentuan yang berlaku.
        </li>
    </ol>

    {{-- =========================================
         TANDA TANGAN PASIEN/WALI & PETUGAS
    ========================================== --}}
    <table class="w-full mt-4">
        <tr>
            {{-- Kolom pasien / wali --}}
            <td class="w-1/2 pr-4 align-top">
                <div class="text-[10px]">
                    Tanggal: {{ $tglPersetujuan ?: '-' }}
                </div>
                <div class="mt-1 text-[10px]">
                    Pasien / Keluarga,
                </div>

                <div class="flex items-center justify-center h-16 mt-2 bg-white border border-black">
                    @if (!empty($sigSrc))
                        {{-- Kalau mau tampilkan signature, hilangkan komentar di bawah --}}
                        {{-- <img src="{{ $sigSrc }}" alt="TTD Pasien/Keluarga"
                             class="block object-contain w-auto mx-auto max-h-16" /> --}}
                    @else
                        <span class="text-[9px] text-gray-600">TTD Pasien / Keluarga</span>
                    @endif
                </div>

                <div class="mt-1 text-center text-[10px]">
                    ( {{ $namaPenandatangan ?: '................................' }} )
                    <div class="text-[9px] text-gray-600">
                        {{ $hubunganPenandatangan ?: 'Pasien / Wali' }}
                    </div>
                </div>
            </td>

            {{-- Kolom petugas pemeriksa --}}
            <td class="w-1/2 pl-4 align-top">
                <div class="text-[10px]">
                    Tanggal: {{ $petugasDate ?: '-' }}
                </div>
                <div class="mt-1 text-[10px]">
                    Petugas Pemeriksa,
                </div>

                <div class="flex items-center justify-center h-16 mt-2 bg-white border border-black">
                    @if ($ttdPetugas)
                        {{-- Kalau mau tampilkan TTD petugas, hilangkan komentar di bawah --}}
                        {{-- <img src="{{ $ttdPetugas }}" alt="TTD Petugas"
                             class="block object-contain w-auto mx-auto max-h-16" /> --}}
                    @else
                        <span class="text-[9px] text-gray-600">TTD Petugas Pemeriksa</span>
                    @endif
                </div>

                <div class="mt-1 text-center text-[10px]">
                    ( {{ $petugasName ?: '................................' }} )
                    <div class="text-[9px] text-gray-600">
                        {{-- Kode: {{ $petugasCode ?: '-' }} --}}
                    </div>
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
