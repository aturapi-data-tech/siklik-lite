<div class="fixed inset-0 z-40 flex items-center justify-center bg-gray-500/75">
    <div class="relative w-full max-w-6xl max-h-[95vh] overflow-y-auto bg-white rounded-lg shadow-xl">
        {{-- Topbar --}}
        <div class="sticky top-0 z-10 flex items-center justify-between p-4 text-white border-b rounded-t-lg bg-primary">
            <h3 class="text-2xl font-semibold">{{ $myTitle }}</h3>
            <button wire:click="closeModalLayanan()"
                class="text-white bg-gray-100/20 hover:bg-gray-200 hover:text-gray-900 rounded-lg p-1.5">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293
                        4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293
                        4.293a1 1 0 01-1.414-1.414L8.586 10
                        4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        {{-- BODY (scrollable) --}}
        <div class="h-full overflow-y-auto bg-white">

            {{-- IDENTITAS PASIEN --}}
            <div class="px-4 pt-4">
                <div class="grid gap-3 p-3 border border-gray-900 rounded-lg md:grid-cols-4">
                    <div class="flex flex-col items-center justify-start text-center md:col-span-1">
                        <img src="madinahlogopersegi.png" alt="Logo" class="object-contain h-28" />
                        <div class="mt-2 text-xs leading-5">
                            {{-- {!! $myQueryIdentitas->int_name . '</br>' !!} --}}
                            {!! $myQueryIdentitas->int_address . '</br>' !!}
                            {!! $myQueryIdentitas->int_city . '</br>' !!}
                            {!! $myQueryIdentitas->int_phone1 . '</br>' !!}
                            {!! $myQueryIdentitas->int_phone2 . '</br>' !!}
                            {!! $myQueryIdentitas->int_fax . '</br>' !!}
                        </div>
                    </div>

                    <div class="md:col-span-3">
                        <div class="grid grid-cols-12 text-sm gap-x-2 gap-y-1">
                            {{-- row 1 --}}
                            <div class="col-span-3 py-1">Nama Pasien</div>
                            <div class="col-span-1 py-1 text-center">:</div>
                            <div class="col-span-7 py-1 font-semibold">
                                {{ strtoupper($dataPasien['pasien']['regName'] ?? '-') }} /
                                {{ $dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] ?? '-' }} /
                                {{ $dataPasien['pasien']['thn'] ?? '-' }}
                            </div>
                            <div class="col-span-1 py-1 text-center">•</div>

                            {{-- row 2 --}}
                            <div class="col-span-3 py-1">No RM</div>
                            <div class="col-span-1 py-1 text-center">:</div>
                            <div class="col-span-8 py-1 text-lg font-semibold">
                                {{ $dataPasien['pasien']['regNo'] ?? '-' }}
                            </div>

                            {{-- row 3 --}}
                            <div class="col-span-3 py-1">Tanggal Lahir</div>
                            <div class="col-span-1 py-1 text-center">:</div>
                            <div class="col-span-3 py-1">{{ $dataPasien['pasien']['tglLahir'] ?? '-' }}</div>
                            <div class="col-span-1 py-1 text-center">•</div>
                            <div class="col-span-3 py-1">NIK</div>
                            <div class="col-span-1 py-1 text-center">:</div>
                            <div class="col-span-0 md:col-span-0"></div>
                            <div class="col-span-12 py-1 md:col-span-0">
                                {{ $dataPasien['pasien']['identitas']['nik'] ?? '-' }}</div>

                            {{-- row 4 --}}
                            <div class="col-span-3 py-1">Alamat</div>
                            <div class="col-span-1 py-1 text-center">:</div>
                            <div class="col-span-8 py-1">
                                {{ $dataPasien['pasien']['identitas']['alamat'] ?? '-' }}</div>

                            {{-- row 5 --}}
                            <div class="col-span-3 py-1">ID BPJS</div>
                            <div class="col-span-1 py-1 text-center">:</div>
                            <div class="col-span-3 py-1">
                                {{ $dataPasien['pasien']['identitas']['idbpjs'] ?? '-' }}</div>
                            <div class="col-span-1 py-1 text-center">•</div>
                            <div class="col-span-3 py-1">Klaim</div>
                            <div class="col-span-1 py-1 text-center">:</div>
                            <div class="col-span-0 md:col-span-0"></div>
                            <div class="col-span-12 py-1 md:col-span-0">
                                @isset($dataDaftarTxn['klaimId'])
                                    {{ $dataDaftarTxn['klaimId'] == 'UM' ? 'UMUM' : ($dataDaftarTxn['klaimId'] == 'JM' ? 'BPJS' : ($dataDaftarTxn['klaimId'] == 'KR' ? 'Kronis' : 'Asuransi Lain')) }}
                                @endisset
                            </div>

                            {{-- row 6 --}}
                            <div class="col-span-3 py-1">Tanggal Masuk</div>
                            <div class="col-span-1 py-1 text-center">:</div>
                            <div class="col-span-8 py-1">{{ $dataDaftarTxn['rjDate'] ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION TITLE (pakai utilitas Tailwind) --}}
            <div class="px-4 mt-4">
                <div
                    class="px-3 py-2 text-2xl font-semibold text-center uppercase border-t border-gray-900 rounded-t-md border-x bg-gray-50">
                    assesment awal rawat jalan
                </div>
            </div>

            {{-- PENGKAJIAN PERAWAT --}}
            <div class="px-4">
                <div class="border-b border-gray-900 rounded-b-md border-x">
                    <div class="grid gap-0 md:grid-cols-4">
                        <div class="p-3 text-sm font-semibold uppercase">pengkajian perawat</div>
                        <div class="p-3 text-sm leading-6 md:col-span-3">
                            <span class="font-semibold">Status Psikologis :</span>
                            {{ isset($dataDaftarTxn['anamnesa']['statusPsikologis']['tidakAdaKelainan']) && $dataDaftarTxn['anamnesa']['statusPsikologis']['tidakAdaKelainan'] ? 'Tidak ada kelainan' : '-' }}
                            /
                            {{ isset($dataDaftarTxn['anamnesa']['statusPsikologis']['marah']) && $dataDaftarTxn['anamnesa']['statusPsikologis']['marah'] ? 'Marah' : '-' }}
                            /
                            {{ isset($dataDaftarTxn['anamnesa']['statusPsikologis']['ccemas']) && $dataDaftarTxn['anamnesa']['statusPsikologis']['ccemas'] ? 'Cemas' : '-' }}
                            /
                            {{ isset($dataDaftarTxn['anamnesa']['statusPsikologis']['takut']) && $dataDaftarTxn['anamnesa']['statusPsikologis']['takut'] ? 'Takut' : '-' }}
                            /
                            {{ isset($dataDaftarTxn['anamnesa']['statusPsikologis']['sedih']) && $dataDaftarTxn['anamnesa']['statusPsikologis']['sedih'] ? 'Sedih' : '-' }}
                            /
                            {{ isset($dataDaftarTxn['anamnesa']['statusPsikologis']['cenderungBunuhDiri']) && $dataDaftarTxn['anamnesa']['statusPsikologis']['cenderungBunuhDiri'] ? 'Resiko Bunuh Diri' : '-' }}
                            /
                            <span class="font-semibold">Keterangan Status Psikologis</span>
                            {{ $dataDaftarTxn['anamnesa']['statusPsikologis']['sebutstatusPsikologis'] ?? '-' }}
                            <br>
                            <span class="font-semibold">Status Mental :</span>
                            {{ $dataDaftarTxn['anamnesa']['statusMental']['statusMental'] ?? '-' }} /
                            <span class="font-semibold">Keterangan Status Mental :</span>
                            {{ $dataDaftarTxn['anamnesa']['statusMental']['sebutstatusPsikologis'] ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- ANAMNESA & PEMERIKSAAN FISIK (grid + table utilitas) --}}
            <div class="grid gap-0 px-4 mt-4 md:grid-cols-4">
                {{-- kiri 3/4 --}}
                <div class="border border-gray-900 md:col-span-3 rounded-l-md">
                    <div class="text-sm divide-y divide-gray-200">
                        {{-- Anamnesa: Keluhan Utama --}}
                        <div class="grid grid-cols-4 gap-2 p-3">
                            <div class="col-span-1 font-semibold uppercase">Anamnesa</div>
                            <div class="col-span-1">Keluhan Utama :</div>
                            <div class="col-span-2 break-words whitespace-pre-line">
                                {!! nl2br(e($dataDaftarTxn['anamnesa']['keluhanUtama']['keluhanUtama'] ?? '-')) !!}
                            </div>
                        </div>

                        {{-- Screening Batuk --}}
                        <div class="grid grid-cols-4 gap-2 p-3">
                            <div></div>
                            <div>Screening Batuk :</div>
                            <div class="col-span-2">
                                @php $b = $dataDaftarTxn['anamnesa']['batuk'] ?? []; @endphp
                                @if ($b['riwayatDemam'] ?? false)
                                    Riwayat Demam? : Ya / {{ $b['keteranganriwayatDemam'] ?? '-' }}<br>
                                @endif
                                @if ($b['berkeringatMlmHari'] ?? false)
                                    Berkeringat Malam Tanpa Aktivitas? : Ya /
                                    {{ $b['keteranganberkeringatMlmHari'] ?? '-' }}<br>
                                @endif
                                @if ($b['bepergianDaerahWabah'] ?? false)
                                    Bepergian ke Daerah Wabah? : Ya /
                                    {{ $b['KeteranganbepergianDaerahWabah'] ?? '-' }}<br>
                                @endif
                                @if ($b['riwayatPakaiObatJangkaPanjangan'] ?? false)
                                    Pemakaian Obat Jangka Panjang? : Ya /
                                    {{ $b['keteranganriwayatPakaiObatJangkaPanjangan'] ?? '-' }}<br>
                                @endif
                                @if ($b['BBTurunTanpaSebab'] ?? false)
                                    BB Turun Tanpa Sebab? : Ya /
                                    {{ $b['keteranganBBTurunTanpaSebab'] ?? '-' }}<br>
                                @endif
                                @if ($b['pembesaranGetahBening'] ?? false)
                                    Pembesaran KGB? : Ya /
                                    {{ $b['keteranganpembesaranGetahBening'] ?? '-' }}<br>
                                @endif
                                -
                            </div>
                        </div>

                        {{-- Skala Nyeri --}}
                        <div class="grid grid-cols-4 gap-2 p-3">
                            <div></div>
                            <div>Skala Nyeri :</div>
                            <div class="col-span-2">
                                VAS : {{ $dataDaftarTxn['penilaian']['nyeri']['vas']['vas'] ?? '-' }} /
                                Pencetus : {{ $dataDaftarTxn['penilaian']['nyeri']['pencetus'] ?? '-' }} /
                                Durasi : {{ $dataDaftarTxn['penilaian']['nyeri']['durasi'] ?? '-' }} /
                                Lokasi : {{ $dataDaftarTxn['penilaian']['nyeri']['lokasi'] ?? '-' }}
                            </div>
                        </div>

                        {{-- Resiko Jatuh --}}
                        <div class="grid grid-cols-4 gap-2 p-3">
                            <div></div>
                            <div>Resiko Jatuh :</div>
                            <div class="col-span-2">
                                Skala Humpty Dumpty / Total Skor :
                                {{ $this->dataDaftarTxn['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyScore'] ?? '-' }}
                                /
                                {{ $this->dataDaftarTxn['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyDesc'] ?? '-' }}
                                <br>
                                Skala Morse / Total Skor :
                                {{ $this->dataDaftarTxn['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseScore'] ?? '-' }}
                                /
                                {{ $this->dataDaftarTxn['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseDesc'] ?? '-' }}
                            </div>
                        </div>

                        {{-- Riwayat + Alergi --}}
                        <div class="grid grid-cols-4 gap-2 p-3">
                            <div></div>
                            <div>Riwayat Penyakit Sekarang :</div>
                            <div class="col-span-2 break-words whitespace-pre-line">
                                {!! nl2br(e($dataDaftarTxn['anamnesa']['riwayatPenyakitSekarangUmum']['riwayatPenyakitSekarangUmum'] ?? '-')) !!}
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-2 p-3">
                            <div></div>
                            <div>Riwayat Penyakit Dahulu :</div>
                            <div class="col-span-2 break-words whitespace-pre-line">
                                {!! nl2br(e($dataDaftarTxn['anamnesa']['riwayatPenyakitDahulu']['riwayatPenyakitDahulu'] ?? '-')) !!}
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-2 p-3">
                            <div></div>
                            <div>Alergi :</div>
                            <div class="col-span-2 break-words whitespace-pre-line">
                                {!! nl2br(e($dataDaftarTxn['anamnesa']['alergi']['alergi'] ?? '-')) !!}
                            </div>
                        </div>

                        {{-- Rekonsiliasi Obat (table utilitas) --}}
                        <div class="grid grid-cols-4 gap-2 p-3">
                            <div></div>
                            <div>Rekonsiliasi Obat :</div>
                            <div class="col-span-2">
                                <div class="overflow-hidden rounded-md ring-1 ring-gray-300">
                                    <table class="w-full table-fixed">
                                        <thead class="text-xs uppercase bg-gray-50">
                                            <tr class="divide-x divide-gray-200">
                                                <th class="px-2 py-1 text-left">Nama Obat</th>
                                                <th class="px-2 py-1 text-left">Dosis</th>
                                                <th class="px-2 py-1 text-left">Rute</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm divide-y divide-gray-200">
                                            @isset($dataDaftarTxn['anamnesa']['rekonsiliasiObat'])
                                                @foreach ($dataDaftarTxn['anamnesa']['rekonsiliasiObat'] as $rek)
                                                    <tr class="divide-x divide-gray-200">
                                                        <td class="px-2 py-1">{{ $rek['namaObat'] }}</td>
                                                        <td class="px-2 py-1">{{ $rek['dosis'] }}</td>
                                                        <td class="px-2 py-1">{{ $rek['rute'] }}</td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- kanan 1/4 --}}
                <div class="border border-gray-900 md:col-span-1 rounded-r-md">
                    <div class="p-3 space-y-1 text-sm">
                        <div class="font-semibold uppercase">Perawat / Terapis :</div>
                        <div class="text-center">
                            @php
                                $imgPerawat = optional(
                                    App\Models\User::where(
                                        'myuser_code',
                                        $dataDaftarTxn['anamnesa']['pengkajianPerawatan']['perawatPenerimaCode'] ??
                                            null,
                                    )->first(),
                                )->myuser_ttd_image;
                            @endphp
                            @if ($imgPerawat)
                                <img class="h-24 mx-auto" src="{{ asset('storage/' . $imgPerawat) }}"
                                    alt="TTD Perawat" />
                            @endif
                            <div class="mt-2">ttd</div>
                            <div class="font-semibold">
                                {{ strtoupper($dataDaftarTxn['anamnesa']['pengkajianPerawatan']['perawatPenerima'] ?? 'Perawat Penerima') }}
                            </div>
                        </div>

                        <div class="pt-2 font-semibold uppercase">Tanda Vital :</div>
                        <div class="grid grid-cols-2 gap-x-3">
                            <div class="text-right">TD :</div>
                            <div>{{ $dataDaftarTxn['pemeriksaan']['tandaVital']['sistolik'] ?? '-' }} /
                                {{ $dataDaftarTxn['pemeriksaan']['tandaVital']['distolik'] ?? '-' }} mmHg</div>

                            <div class="text-right">Nadi :</div>
                            <div>{{ $dataDaftarTxn['pemeriksaan']['tandaVital']['frekuensiNadi'] ?? '-' }}
                                x/mnt</div>

                            <div class="text-right">Suhu :</div>
                            <div>{{ $dataDaftarTxn['pemeriksaan']['tandaVital']['suhu'] ?? '-' }} °C</div>

                            <div class="text-right">Pernafasan :</div>
                            <div>{{ $dataDaftarTxn['pemeriksaan']['tandaVital']['frekuensiNafas'] ?? '-' }}
                                x/mnt</div>

                            <div class="text-right">SPO₂ :</div>
                            <div>{{ $dataDaftarTxn['pemeriksaan']['tandaVital']['spo2'] ?? '-' }} %</div>

                            <div class="text-right">GDA :</div>
                            <div>{{ $dataDaftarTxn['pemeriksaan']['tandaVital']['gda'] ?? '-' }} mg/dL</div>
                        </div>

                        <div class="pt-2 font-semibold uppercase">Nutrisi :</div>
                        <div class="grid grid-cols-2 gap-x-3">
                            <div class="text-right">Berat Badan :</div>
                            <div>{{ $dataDaftarTxn['pemeriksaan']['nutrisi']['bb'] ?? '-' }} kg</div>

                            <div class="text-right">Tinggi Badan :</div>
                            <div>{{ $dataDaftarTxn['pemeriksaan']['nutrisi']['tb'] ?? '-' }} cm</div>

                            <div class="text-right">IMT :</div>
                            <div>{{ $dataDaftarTxn['pemeriksaan']['nutrisi']['imt'] ?? '-' }} Kg/M²</div>

                            <div class="text-right">Lingkar Kepala :</div>
                            <div>{{ $dataDaftarTxn['pemeriksaan']['nutrisi']['lk'] ?? '-' }} cm</div>

                            <div class="text-right">LILA :</div>
                            <div>{{ $dataDaftarTxn['pemeriksaan']['nutrisi']['lila'] ?? '-' }} cm</div>

                            <div class="text-right">Lingkar Perut :</div>
                            <div>{{ $dataDaftarTxn['pemeriksaan']['nutrisi']['liPerut'] ?? '-' }} cm</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KEADAAN UMUM --}}
            <div class="px-4 mt-4">
                <div
                    class="px-3 py-2 text-sm font-semibold uppercase border-t border-gray-900 rounded-t-md border-x bg-gray-50">
                    keadaan umum</div>
                <div class="px-3 py-2 text-sm text-center border-b border-gray-900 rounded-b-md border-x">
                    {{ $dataDaftarTxn['pemeriksaan']['tandaVital']['keadaanUmum'] ?? '-' }} /
                    <span class="font-semibold">Tingkat Kesadaran :</span>
                    {{ $dataDaftarTxn['pemeriksaan']['tandaVital']['tingkatKesadaran'] ?? '-' }}
                </div>
            </div>

            {{-- PEMERIKSAAN FISIK & UJI FUNGSI --}}
            <div class="px-4 mt-2">
                <div
                    class="px-3 py-2 text-sm font-semibold uppercase border-t border-gray-900 rounded-t-md border-x bg-gray-50">
                    pemeriksaan fisik dan uji fungsi</div>
                <div class="px-3 py-2 text-sm border-b border-gray-900 rounded-b-md border-x">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <span class="font-semibold">Fisik dan Uji Fungsi:</span><br>
                            {!! nl2br(e($dataDaftarTxn['pemeriksaan']['fisik'] ?? '-')) !!}<br>
                            {!! nl2br(e($dataDaftarTxn['pemeriksaan']['FisikujiFungsi']['FisikujiFungsi'] ?? '-')) !!}
                        </div>
                        <div>
                            <span class="font-semibold">Anatomi :</span><br>
                            @isset($dataDaftarTxn['pemeriksaan']['anatomi'])
                                @foreach ($dataDaftarTxn['pemeriksaan']['anatomi'] as $key => $a)
                                    @php $kelainan = $a['kelainan'] ?? false; @endphp
                                    @if ($kelainan && $kelainan !== 'Tidak Diperiksa')
                                        <span class="font-normal">{{ strtoupper($key) }} :
                                            {{ $kelainan }}</span> /
                                        {!! nl2br(e($a['desc'] ?? '-')) !!}<br>
                                    @endif
                                @endforeach
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

            {{-- PENUNJANG --}}
            <div class="px-4 mt-2">
                <div
                    class="px-3 py-2 text-sm font-semibold uppercase border-t border-gray-900 rounded-t-md border-x bg-gray-50">
                    pemeriksaan penunjang</div>
                <div class="px-3 py-2 text-sm border-b border-gray-900 rounded-b-md border-x">
                    <span class="font-semibold">Pemeriksaan Penunjang Lab / Foto / EKG / Lain-lain :</span><br>
                    {!! nl2br(e($dataDaftarTxn['pemeriksaan']['penunjang'] ?? '-')) !!}
                </div>
            </div>

            {{-- DIAGNOSIS --}}
            <div class="px-4 mt-2">
                <div
                    class="px-3 py-2 text-sm font-semibold uppercase border-t border-gray-900 rounded-t-md border-x bg-gray-50">
                    diagnosis</div>
                <div class="px-3 py-2 border-b border-gray-900 rounded-b-md border-x">
                    <div class="overflow-hidden rounded-md ring-1 ring-gray-300">
                        <table class="w-full table-fixed">
                            <thead class="text-sm bg-gray-50">
                                <tr class="divide-x divide-gray-200">
                                    <th class="px-2 py-1 text-left">Kode (ICD 10)</th>
                                    <th class="px-2 py-1 text-left">Diagnosa</th>
                                    <th class="px-2 py-1 text-left">Kategori</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-200">
                                @isset($dataDaftarTxn['diagnosis'])
                                    @foreach ($dataDaftarTxn['diagnosis'] as $diag)
                                        <tr class="divide-x divide-gray-200">
                                            <td class="px-2 py-1">{{ $diag['icdX'] }}</td>
                                            <td class="px-2 py-1">{{ $diag['diagDesc'] }}</td>
                                            <td class="px-2 py-1">{{ $diag['kategoriDiagnosa'] }}</td>
                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- PROSEDUR --}}
            <div class="px-4 mt-2">
                <div
                    class="px-3 py-2 text-sm font-semibold uppercase border-t border-gray-900 rounded-t-md border-x bg-gray-50">
                    prosedur</div>
                <div class="px-3 py-2 border-b border-gray-900 rounded-b-md border-x">
                    <div class="overflow-hidden rounded-md ring-1 ring-gray-300">
                        <table class="w-full table-fixed">
                            <thead class="text-sm bg-gray-50">
                                <tr class="divide-x divide-gray-200">
                                    <th class="px-2 py-1 text-left">Kode (ICD 9 CM)</th>
                                    <th class="px-2 py-1 text-left">Prosedur</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-200">
                                @isset($dataDaftarTxn['procedure'])
                                    @foreach ($dataDaftarTxn['procedure'] as $procedure)
                                        <tr class="divide-x divide-gray-200">
                                            <td class="px-2 py-1">{{ $procedure['procedureId'] }}</td>
                                            <td class="px-2 py-1">{{ $procedure['procedureDesc'] }}</td>
                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- TINDAK LANJUT + TERAPI + TTD DOKTER --}}
            <div class="px-4 mt-2 mb-16">
                <div
                    class="px-3 py-2 text-sm font-semibold uppercase border-t border-gray-900 rounded-t-md border-x bg-gray-50">
                    tindak lanjut</div>
                <div class="px-3 py-2 text-sm border-b border-gray-900 rounded-b-md border-x">
                    <div class="mb-3">
                        <span class="font-semibold">Tindak Lanjut :</span>
                        {{ $dataDaftarTxn['perencanaan']['tindakLanjut']['tindakLanjut'] ?? '-' }} /
                        {{ $dataDaftarTxn['perencanaan']['tindakLanjut']['keteranganTindakLanjut'] ?? '-' }}
                    </div>

                    <div class="grid gap-4 md:grid-cols-4">
                        <div class="md:col-span-3">
                            <x-input-label for="dataDaftarPoliRJ.perencanaan.terapi.terapi" :value="__('Terapi (Obat)')"
                                class="font-semibold" />
                            <div
                                class="p-2 break-words whitespace-pre-line border border-gray-200 rounded-md bg-gray-50">
                                {!! nl2br(e($dataDaftarTxn['perencanaan']['terapi']['terapi'] ?? '-')) !!}
                            </div>

                            <x-input-label for="dataDaftarPoliRJ.perencanaan.terapi.terapiNonObat" :value="__('Terapi Non Obat')"
                                class="mt-2 font-semibold" />
                            <div
                                class="p-2 break-words whitespace-pre-line border border-gray-200 rounded-md bg-gray-50">
                                {!! nl2br(e($dataDaftarTxn['perencanaan']['terapi']['terapiNonObat'] ?? '-')) !!}
                            </div>
                        </div>

                        <div class="flex flex-col justify-end text-center md:col-span-1">
                            @inject('carbon', 'Carbon\Carbon')
                            <div>
                                Tulungagung,<br>
                                {{ $dataDaftarTxn['perencanaan']['pengkajianMedis']['selesaiPemeriksaan'] ?? 'Tanggal' }}
                            </div>

                            @php
                                $drImg = optional(
                                    App\Models\User::where('myuser_code', $dataDaftarTxn['drId'] ?? null)->first(),
                                )->myuser_ttd_image;
                            @endphp

                            @if ($drImg)
                                <img class="h-24 mx-auto my-1" src="{{ asset('storage/' . $drImg) }}"
                                    alt="TTD Dokter" />
                            @endif

                            <div class="mt-1">
                                <span class="text-xs italic text-gray-500">ttd</span><br>
                                <span class="text-xs font-semibold">
                                    {{ $dataDaftarTxn['perencanaan']['pengkajianMedis']['drPemeriksa'] ?? 'Dokter Pemeriksa' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="sticky bottom-0 flex justify-end px-4 py-3 border-t bg-gray-50">
            <div wire:loading wire:target="cetakRekamMedisRJ">
                <x-loading />
            </div>
            <x-green-button wire:click.prevent="cetakRekamMedisRJ()" wire:loading.remove>
                Cetak RM RJ
            </x-green-button>
        </div>
    </div>
</div>
