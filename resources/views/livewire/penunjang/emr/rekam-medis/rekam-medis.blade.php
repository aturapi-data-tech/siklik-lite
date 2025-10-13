<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp

    <div class="w-full mb-1 ">

        <div class="grid grid-cols-1">

            <div id="TransaksiRawatJalan" class="px-4">
                <x-input-label for="" :value="__('Rekam Medis Pasien')" :required="__(false)" class="pt-2 sm:text-xl" />



                <!-- Table -->
                <div class="flex flex-col my-2">
                    <div class="overflow-x-auto rounded-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-2 py-2 ">


                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Layanan
                                                </x-sort-link>

                                            </th>


                                            <th scope="col" class="px-2 py-2 ">

                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Terapi
                                                </x-sort-link>
                                            </th>

                                            <th scope="col" class="px-2 py-2 ">

                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Diagnosis
                                                </x-sort-link>
                                            </th>

                                            <th scope="col" class="px-2 py-2 ">

                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    TTV
                                                </x-sort-link>
                                            </th>

                                            <th scope="col" class="w-8 px-2 py-2 text-center">
                                                RekamMedis
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">

                                        @foreach ($myQueryData as $myQData)
                                            @php
                                                $datadaftar_json =
                                                    json_decode($myQData->datadaftar_json ?? '[]', true) ?: [];

                                                $status = $myQData->layanan_status;
                                                $statusText = match ($status) {
                                                    'RI' => 'Rawat Inap',
                                                    'RJ' => 'Rawat Jalan',
                                                    'UGD' => 'UGD',
                                                    default => '-',
                                                };
                                                $terapiObat = data_get(
                                                    $datadaftar_json,
                                                    'perencanaan.terapi.terapi',
                                                    '',
                                                );
                                                $terapiNonObat = data_get(
                                                    $datadaftar_json,
                                                    'perencanaan.terapi.terapiNonObat',
                                                    '',
                                                );
                                                $diagnosisList = data_get($datadaftar_json, 'diagnosis', []);
                                                $tindakLanjut =
                                                    data_get(
                                                        $datadaftar_json,
                                                        'perencanaan.tindakLanjut.tindakLanjut',
                                                        '-',
                                                    ) ?:
                                                    '-';
                                                $ketTindakLanjut =
                                                    data_get(
                                                        $datadaftar_json,
                                                        'perencanaan.tindakLanjut.keteranganTindakLanjut',
                                                        '-',
                                                    ) ?:
                                                    '-';
                                                $sistolik = data_get(
                                                    $datadaftar_json,
                                                    'pemeriksaan.tandaVital.sistolik',
                                                    '',
                                                );
                                                $diastolik = data_get(
                                                    $datadaftar_json,
                                                    'pemeriksaan.tandaVital.distolik',
                                                    '',
                                                );
                                                $spo2 = data_get($datadaftar_json, 'pemeriksaan.tandaVital.spo2', '');
                                                $gda = data_get($datadaftar_json, 'pemeriksaan.tandaVital.gda', '');
                                                $tanggal = $myQData->txn_date;
                                            @endphp

                                            <tr
                                                class="align-top border-b border-gray-200 group hover:bg-gray-50 dark:border-gray-700">
                                                {{-- LAYANAN / KUNJUNGAN --}}
                                                <td class="px-3 py-3">
                                                    <div class="flex flex-col gap-1 w-full max-w-[280px]">
                                                        <x-badge :badgecolor="match ($myQData->layanan_status) {
                                                            'RI' => 'blue',
                                                            'RJ' => 'green',
                                                            'UGD' => 'red',
                                                            default => 'dark',
                                                        }">
                                                            {{ $statusText }}
                                                        </x-badge>

                                                        <div class="font-semibold text-gray-900">
                                                            {{ $tanggal }}
                                                            <span class="text-gray-500">/
                                                                ({{ $myQData->reg_no }})</span>
                                                        </div>
                                                        <div class="text-gray-700">{{ $myQData->poli }}</div>
                                                    </div>
                                                </td>

                                                {{-- TERAPI --}}
                                                <td class="px-3 py-3">
                                                    <div class="space-y-3">
                                                        {{-- Terapi (Obat) --}}
                                                        <div class="w-full">
                                                            <x-input-label
                                                                for="dataDaftarPoliRJ.perencanaan.terapi.terapi"
                                                                :value="__('Terapi (Obat)')" :required="__(true)" />
                                                            <div
                                                                class="mt-1 text-gray-900 break-words whitespace-pre-line">
                                                                {!! nl2br(e($terapiObat)) !!}
                                                            </div>
                                                        </div>

                                                        {{-- Terapi Non Obat --}}
                                                        <div class="w-full">
                                                            <x-input-label
                                                                for="dataDaftarPoliRJ.perencanaan.terapi.terapiNonObat"
                                                                :value="__('Terapi Non Obat')" :required="__(true)" />
                                                            <div
                                                                class="mt-1 text-gray-900 break-words whitespace-pre-line">
                                                                {!! nl2br(e($terapiNonObat)) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- DIAGNOSIS & TINDAK LANJUT --}}
                                                <td class="px-3 py-3">
                                                    <div class="w-full max-w-[340px]">
                                                        @if (!empty($diagnosisList))
                                                            <div class="mb-2 font-semibold text-gray-700">Diagnosis
                                                            </div>
                                                            <ul class="pl-5 space-y-1 list-disc">
                                                                @foreach ($diagnosisList as $diagnosis)
                                                                    <li class="break-words whitespace-pre-line">
                                                                        {{ ($diagnosis['diagId'] ?? '') . ' - ' . ($diagnosis['diagDesc'] ?? '') }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif

                                                        <div class="mt-3">
                                                            <div class="font-semibold text-gray-700">Tindak Lanjut</div>
                                                            <div class="text-gray-900">
                                                                {{ $tindakLanjut }} / {{ $ketTindakLanjut }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- TANDA VITAL --}}
                                                <td class="px-3 py-3">
                                                    <div class="space-y-1 text-gray-900">
                                                        <div>TD: {{ $sistolik }} / {{ $diastolik }} <span
                                                                class="text-gray-500">(mmHg)</span></div>
                                                        <div>SPO₂: {{ $spo2 }} <span
                                                                class="text-gray-500">(%)</span></div>
                                                        <div>GDA: {{ $gda }} <span
                                                                class="text-gray-500">(mg/dL)</span></div>
                                                    </div>
                                                </td>

                                                {{-- AKSI --}}
                                                <td class="px-3 py-3">
                                                    <div class="flex flex-col gap-2">
                                                        <x-yellow-button
                                                            wire:click.prevent="openModalLayanan('{{ $myQData->txn_no }}','{{ $myQData->layanan_status }}', {{ $myQData->datadaftar_json }})"
                                                            type="button" wire:loading.remove>
                                                            Resume Medis
                                                        </x-yellow-button>
                                                        <div wire:loading wire:target="openModalLayanan">
                                                            <x-loading />
                                                        </div>

                                                        <x-green-button
                                                            wire:click.prevent="cetakRekamMedisRJGrid('{{ $myQData->txn_no }}','{{ $myQData->layanan_status }}', {{ $myQData->datadaftar_json }})"
                                                            type="button" wire:loading.remove>
                                                            Cetak Resume Medis
                                                        </x-green-button>
                                                        <div wire:loading wire:target="cetakRekamMedisRJGrid">
                                                            <x-loading />
                                                        </div>

                                                        <x-green-button
                                                            wire:click.prevent="cetakRekamMedisRJSuketIstirahatGrid('{{ $myQData->txn_no }}','{{ $myQData->layanan_status }}', {{ $myQData->datadaftar_json }})"
                                                            type="button" wire:loading.remove>
                                                            Cetak Surat Istirahat
                                                        </x-green-button>
                                                        <div wire:loading
                                                            wire:target="cetakRekamMedisRJSuketIstirahatGrid">
                                                            <x-loading />
                                                        </div>

                                                        <x-green-button
                                                            wire:click.prevent="cetakRekamMedisRJSuketSehatGrid('{{ $myQData->txn_no }}','{{ $myQData->layanan_status }}', {{ $myQData->datadaftar_json }})"
                                                            type="button" wire:loading.remove>
                                                            Cetak Surat Sehat
                                                        </x-green-button>
                                                        <div wire:loading wire:target="cetakRekamMedisRJSuketSehatGrid">
                                                            <x-loading />
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach



                                    </tbody>
                                </table>
                                {{-- no data found start --}}
                                @if ($myQueryData->count() == 0)
                                    <div class="w-full p-4 text-sm text-center text-gray-900 dark:text-gray-400">
                                        {{ 'Data Layanan Tidak ditemukan' }}
                                    </div>
                                @endif
                                {{-- no data found end --}}

                            </div>

                            {{ $myQueryData->links() }}

                        </div>
                    </div>
                    @if ($isOpenRekamMedisRJ)
                        @include('livewire.penunjang.emr.rekam-medis.create-rekam-medis-r-j')
                    @endif
                </div>
            </div>



        </div>
    </div>
</div>
