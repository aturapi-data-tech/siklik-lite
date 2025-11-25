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

        // --- Data pasien (bisa ['pasien'=>[]] atau langsung []) ---
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

        // --- Data persetujuan tindakan medis (1 entri) ---
        $consent = (array) ($consent ?? []);

        // flag persetujuan / penolakan
        $isSetuju = ($consent['agreement'] ?? '1') === '1';

        // data TTD pasien/wali
        $namaPenandatangan = (string) ($consent['wali'] ?? $nama);
        $hubunganPenandatangan = (string) ($consent['hubungan'] ?? 'Pasien / Wali');
        $tglSignature = (string) ($consent['signatureDate'] ?? ($tglKunjungan ?? '-'));

        $sigRaw = trim((string) ($consent['signature'] ?? ''));
        if (\Illuminate\Support\Str::startsWith($sigRaw, '<svg')) {
            $sigPasienSrc = 'data:image/svg+xml;base64,' . base64_encode($sigRaw);
        } else {
            $sigPasienSrc = $sigRaw; // bisa base64 png/jpg atau kosong
        }

        // data TTD saksi (opsional)
        $namaSaksi = (string) ($consent['saksi'] ?? '');
        $tglSignatureS = (string) ($consent['signatureSaksiDate'] ?? '');
        $sigSaksiRaw = trim((string) ($consent['signatureSaksi'] ?? ''));
        if (\Illuminate\Support\Str::startsWith($sigSaksiRaw, '<svg')) {
            $sigSaksiSrc = 'data:image/svg+xml;base64,' . base64_encode($sigSaksiRaw);
        } else {
            $sigSaksiSrc = $sigSaksiRaw;
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
         HEADER: IDENTITAS PASIEN & KLINIK
    ========================================== --}}
    <table class="w-full p-1 border border-separate border-black rounded-md">
        <tr>
            {{-- Kiri: identitas pasien & kunjungan --}}
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
                    <tr>
                        <td class="py-1 pr-2 text-gray-700">No Kunjungan RJ</td>
                        <td class="py-1">{{ $noKunjungan ?: '-' }}</td>
                    </tr>
                </table>
            </td>

            {{-- Kanan: logo & identitas Klinik --}}
            <td class="align-top w-[180px] border-0">
                <table class="w-full mb-2 table-auto">
                    <tr>
                        <td class="w-2/3 align-top"></td>
                        <td class="w-1/3 text-right align-top">
                            <img src="madinahlogopersegi.png" class="object-fill h-16 ml-auto">
                            <div class="mt-1 text-xs leading-tight text-right">
                                <span class="text-sm font-bold">
                                    {{ $rs->int_name ?? 'Klinik Madinah Pratama' }}
                                </span><br>
                                {{ trim($rs->int_address ?? 'Jalan Jatiwayang Lk 2 Ds Ngunut') }}<br>
                                {{ strtoupper($rs->int_city ?? 'Kec Ngunut, Kab Tulungagung') }}<br>
                                Jawa Timur 66292<br>
                                Telp. {{ $rs->int_phone1 ?? '0813-8785-9218' }}<br>
                                @if ($rs && $rs->int_fax)
                                    Fax. {{ $rs->int_fax }}<br>
                                @else
                                    Fax. (0355) 396824<br>
                                @endif
                                klinikmadinahpratama@gmail.com
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- =========================================
         JUDUL FORM (SETUJU / MENOLAK)
    ========================================== --}}
    <div class="mt-2 mb-1 text-sm font-bold text-center">
        @if ($isSetuju)
            FORMULIR PERSETUJUAN TINDAKAN MEDIS
        @else
            FORMULIR PENOLAKAN TINDAKAN MEDIS
        @endif
    </div>
    <div class="mb-2 text-[11px] font-semibold text-center">
        RAWAT JALAN
    </div>

    {{-- =========================================
         A. INFORMASI TINDAKAN
    ========================================== --}}
    <div class="mt-1 font-bold text-[11px]">
        A. Informasi Tindakan
    </div>
    <div class="mt-1 border border-black rounded-md">
        <table class="w-full text-[10px] border-collapse">
            <tr>
                <td class="px-2 py-1 w-[25%]">Tindakan Medis</td>
                <td class="w-[2%]">:</td>
                <td class="py-1">{{ $consent['tindakan'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="px-2 py-1">Tujuan</td>
                <td>:</td>
                <td class="py-1">{{ $consent['tujuan'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="px-2 py-1">Risiko</td>
                <td>:</td>
                <td class="py-1">{{ $consent['resiko'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="px-2 py-1">Alternatif</td>
                <td>:</td>
                <td class="py-1">{{ $consent['alternatif'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="px-2 py-1">Dokter Penanggung Jawab</td>
                <td>:</td>
                <td class="py-1">{{ $consent['dokter'] ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- =========================================
         B. HAK DAN KEWAJIBAN PASIEN
    ========================================== --}}
    <div class="mt-2 font-bold text-[11px]">
        B. Hak dan Kewajiban Pasien
    </div>
    <div class="mt-1 border border-black rounded-md">
        <div class="px-2 py-1 text-[10px] text-justify leading-snug">
            Hak dan kewajiban saya sebagai pasien sebagaimana telah dijelaskan dalam
            <strong>Formulir Persetujuan Umum Rawat Jalan</strong>
            tetap berlaku dan menjadi satu kesatuan yang tidak terpisahkan dari dokumen ini.
        </div>
    </div>

    {{-- =========================================
         C. PERNYATAAN (PERSETUJUAN / PENOLAKAN)
    ========================================== --}}
    @if ($isSetuju)
        <div class="mt-2 font-bold text-[11px]">
            C. Pernyataan Persetujuan Tindakan Medis
        </div>
        <div class="mt-1 border border-black rounded-md">
            <ol class="px-4 py-2 text-[10px] leading-snug list-decimal text-justify">
                <li>
                    Saya telah menerima penjelasan yang jelas dan lengkap dari petugas medis mengenai
                    tindakan medis yang akan dilakukan, termasuk tujuan, risiko, manfaat, dan alternatifnya.
                </li>
                <li>
                    Saya memahami bahwa tindakan medis memiliki risiko dan komplikasi yang dapat terjadi,
                    namun semua upaya terbaik akan dilakukan untuk keselamatan saya.
                </li>
                <li>
                    Saya menyetujui untuk menjalani tindakan medis yang direncanakan sesuai dengan standar
                    prosedur operasional yang berlaku di fasilitas pelayanan kesehatan ini.
                </li>
                <li>
                    Saya memberikan izin kepada fasilitas pelayanan kesehatan untuk mengungkapkan informasi
                    medis saya kepada pihak-pihak terkait untuk kepentingan penanganan medis, antara lain:
                </li>
            </ol>

            {{-- a, b, c, d sejajar --}}
            <div class="px-8 pb-2 text-[10px] leading-snug text-justify">
                <span class="inline-block pr-2"><strong>a.</strong> Keluarga</span>
                <span class="inline-block pr-2"><strong>b.</strong> Dokter rujukan</span>
                <span class="inline-block pr-2"><strong>c.</strong> Penyedia asuransi</span>
                <span class="inline-block">
                    <strong>d.</strong> Pihak lain yang berwenang sesuai dengan ketentuan peraturan perundang-undangan
                </span>
            </div>
        </div>
    @else
        <div class="mt-2 font-bold text-[11px]">
            C. Pernyataan Penolakan Tindakan Medis
        </div>
        <div class="mt-1 border border-black rounded-md">
            <ol class="px-4 py-2 text-[10px] leading-snug list-decimal text-justify">
                <li>
                    Saya telah menerima penjelasan yang jelas dan lengkap dari petugas medis mengenai tindakan
                    medis yang direncanakan, termasuk tujuan, risiko, manfaat, dan alternatifnya.
                </li>
                <li>
                    Saya memahami bahwa dengan menolak tindakan medis ini, saya dapat menghadapi konsekuensi atau
                    risiko terhadap kesehatan saya, termasuk komplikasi atau kondisi yang memburuk.
                </li>
                <li>
                    Saya secara sadar dan tanpa paksaan memutuskan untuk menolak tindakan medis yang direncanakan,
                    dan saya bertanggung jawab penuh atas segala konsekuensi yang mungkin timbul dari keputusan ini.
                </li>
            </ol>
        </div>
    @endif

    {{-- =========================================
         D. TANDA TANGAN
    ========================================== --}}
    <div class="mt-2 font-bold text-[11px]">
        D. Tanda Tangan
    </div>

    <table class="w-full mt-1 text-[10px]">
        <tr>
            {{-- Pasien / Wali --}}
            <td class="w-1/3 pr-2 align-top">
                <div>Pasien / Wali</div>
                <div class="mt-1">Tanggal/Jam: {{ $tglSignature ?: '-' }}</div>
                <div class="flex items-center justify-center h-16 mt-2 bg-white border border-black">
                    @if (!empty($sigPasienSrc))
                        {{-- <img src="{{ $sigPasienSrc }}" alt="TTD Pasien/Wali"
                             class="block object-contain w-auto mx-auto max-h-16" /> --}}
                    @else
                        <span class="text-[9px] text-gray-600">TTD Pasien / Wali</span>
                    @endif
                </div>
                <div class="mt-1 text-center">
                    ( {{ $namaPenandatangan ?: '................................' }} )<br>
                    {{-- <span class="text-[9px] text-gray-600">{{ $hubunganPenandatangan }}</span> --}}
                </div>
            </td>

            {{-- Saksi --}}
            <td class="w-1/3 px-2 align-top">
                <div>Saksi</div>
                <div class="mt-1">
                    Tanggal/Jam: {{ $tglSignatureS ?: '-' }}
                </div>
                <div class="flex items-center justify-center h-16 mt-2 bg-white border border-black">
                    @if (!empty($sigSaksiSrc))
                        {{-- <img src="{{ $sigSaksiSrc }}" alt="TTD Saksi"
                             class="block object-contain w-auto mx-auto max-h-16" /> --}}
                    @else
                        <span class="text-[9px] text-gray-600">TTD Saksi</span>
                    @endif
                </div>
                <div class="mt-1 text-center">
                    ( {{ $namaSaksi ?: '................................' }} )
                </div>
            </td>

            {{-- Petugas Pemeriksa --}}
            <td class="w-1/3 pl-2 align-top">
                <div>Petugas Pemeriksa</div>
                <div class="mt-1">
                    Tanggal/Jam: {{ $petugasDate ?: '-' }}
                </div>
                <div class="flex items-center justify-center h-16 mt-2 bg-white border border-black">
                    @if ($ttdPetugas)
                        {{-- <img src="{{ $ttdPetugas }}" alt="TTD Petugas"
                             class="block object-contain w-auto mx-auto max-h-16" /> --}}
                    @else
                        <span class="text-[9px] text-gray-600">TTD Petugas Pemeriksa</span>
                    @endif
                </div>
                <div class="mt-1 text-center">
                    ( {{ $petugasName ?: '................................' }} )<br>
                    {{-- <span class="text-[9px] text-gray-600">Kode: {{ $petugasCode ?: '-' }}</span> --}}
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
