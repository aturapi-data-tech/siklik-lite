<div class="flex flex-col my-2">
    <div class="overflow-x-auto rounded-lg">
        <div class="inline-block min-w-full align-middle">
            <div class="mb-2 overflow-hidden shadow sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-700 table-fixed dark:text-gray-300">
                    <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800/60">
                        <tr>
                            <th scope="col" class="w-full px-4 py-3">
                                <x-sort-link :active="false" role="button" href="#" wire:click.prevent="">
                                    Resume Medis
                                </x-sort-link>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        @foreach ($myQueryData as $myQData)
                            @php
                                $json = json_decode($myQData->datadaftar_json ?? '[]', true) ?: [];
                                $terapi = trim(data_get($json, 'perencanaan.terapi.terapi', ''));
                                $terapiNonObat = trim(data_get($json, 'perencanaan.terapi.terapiNonObat', ''));
                                $diagnosis = data_get($json, 'diagnosis', []);
                                $isPrb = (bool) data_get($json, 'statusPRB.penanggungJawab.statusPRB', false);

                                $statusText = match ($myQData->layanan_status) {
                                    'RI' => 'Rawat Inap',
                                    'RJ' => 'Rawat Jalan',
                                    'UGD' => 'UGD',
                                    default => '-',
                                };
                            @endphp

                            <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/40">
                                <td class="px-4 py-3 text-gray-900 align-top dark:text-gray-100">

                                    {{-- Header Baris --}}
                                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                                        <span class="font-semibold text-primary">{{ $statusText }}</span>
                                        <span class="text-gray-600 dark:text-gray-400">/ {{ $myQData->reg_name }}</span>

                                        @if ($isPrb)
                                            <x-badge :badgecolor="'dark'">PRB</x-badge>
                                        @endif
                                    </div>

                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $myQData->txn_date }} / ({{ $myQData->reg_no }}) /
                                        {{ $myQData->nokartu_bpjs }}
                                    </div>
                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $myQData->poli }} {{ $myQData->kd_dr_bpjs }}
                                    </div>

                                    {{-- Konten --}}
                                    <div class="mt-2 ml-6 space-y-2">

                                        {{-- Diagnosis --}}
                                        <div>
                                            <div class="font-semibold">Diagnosis :</div>
                                            @if (!empty($diagnosis))
                                                <ul class="mt-1 list-disc pl-5 space-y-0.5">
                                                    @foreach ($diagnosis as $d)
                                                        <li class="break-words">
                                                            {{ ($d['diagId'] ?? '-') . ' - ' . ($d['diagDesc'] ?? '-') }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="text-gray-500">-</div>
                                            @endif
                                        </div>

                                        {{-- Terapi (Obat) --}}
                                        <div>
                                            <div class="font-semibold">Terapi (Obat) :</div>
                                            <div class="break-words whitespace-pre-line">
                                                {!! $terapi !== '' ? nl2br(e($terapi)) : '<span class="text-gray-500">-</span>' !!}
                                            </div>
                                        </div>

                                        {{-- Terapi Non Obat --}}
                                        <div>
                                            <div class="font-semibold">Terapi Non Obat :</div>
                                            <div class="break-words whitespace-pre-line">
                                                {!! $terapiNonObat !== '' ? nl2br(e($terapiNonObat)) : '<span class="text-gray-500">-</span>' !!}
                                            </div>
                                        </div>

                                    </div>

                                    {{-- Aksi --}}
                                    @role(['Dokter', 'Admin'])
                                        <div class="flex flex-wrap gap-2 mt-3">
                                            <x-yellow-button
                                                wire:click.prevent="copyResep({{ $myQData->txn_no }}, '{{ $myQData->layanan_status }}')"
                                                type="button" wire:loading.remove>
                                                Copy Resep
                                            </x-yellow-button>
                                            <div wire:loading wire:target="copyResep"><x-loading /></div>

                                            <x-light-button
                                                wire:click.prevent="myiCare('{{ $myQData->nokartu_bpjs }}','{{ data_get($json, 'sep.noSep', '') }}')"
                                                type="button" wire:loading.remove>
                                                i-Care
                                            </x-light-button>
                                            <div wire:loading wire:target="myiCare"><x-loading /></div>
                                        </div>
                                    @endrole

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- No data --}}
                @if ($myQueryData->count() == 0)
                    <div class="w-full p-4 text-sm text-center text-gray-700 dark:text-gray-300">
                        Data Layanan Tidak ditemukan
                    </div>
                @endif
            </div>

            {{ $myQueryData->links('vendor.livewire.simple-tailwind') }}
        </div>
    </div>
</div>
