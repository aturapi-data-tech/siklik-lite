<div>
    @php
        $disabledPropertyRjStatus = $rjStatusRef !== 'A';
    @endphp

    <div class="w-full mb-1">
        <div id="TransaksiRawatJalan" class="p-2">
            <div class="p-2 rounded-lg bg-gray-50">

                <div id="TransaksiRawatJalanRacikan" class="px-4">
                    <x-input-label :value="__('Racikan')" :required="false" class="pt-2 sm:text-xl" />

                    @role(['Dokter', 'Admin'])
                        {{-- Jika belum pilih produk, tampilkan LOV --}}
                        @if (empty($formEntryRacikan) || empty($formEntryRacikan['productId']))
                            {{-- LOV Product (dari trait) --}}
                            <div class="">
                                @include('livewire.component.l-o-v.list-of-value-product.list-of-value-product')
                            </div>
                        @else
                            {{-- Form entry (pakai formEntryRacikan) --}}
                            <div class="flex items-baseline space-x-2" x-data x-init="$nextTick(() => { $el.querySelector('[data-scope=&quot;entry-racikan&quot;] [data-seq=&quot;2&quot;]')?.focus() })">

                                {{-- Scope untuk enter navigation --}}
                                <div class="hidden" data-scope="entry-racikan"></div>

                                {{-- productId (hidden) --}}
                                <div class="hidden">
                                    <x-input-label for="formEntryRacikan.productId" :value="__('Kode Obat')" />
                                    <x-text-input id="formEntryRacikan.productId" class="mt-1 ml-2" :disabled="true"
                                        wire:model="formEntryRacikan.productId" />
                                    @error('formEntryRacikan.productId')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- Nama Obat --}}
                                <div class="basis-3/6">
                                    <x-input-label for="formEntryRacikan.productName" :value="__('Nama Obat')" :required="true" />
                                    <x-text-input id="formEntryRacikan.productName" class="mt-1 ml-2" :disabled="true"
                                        wire:model="formEntryRacikan.productName" />
                                    @error('formEntryRacikan.productName')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- No Racikan --}}
                                <div class="basis-1/12">
                                    <x-input-label for="formEntryRacikan.noRacikan" :value="__('Racikan')" :required="true" />
                                    <x-text-input id="formEntryRacikan.noRacikan" class="w-24 mt-1 ml-2" :disabled="$disabledPropertyRjStatus"
                                        wire:model="formEntryRacikan.noRacikan" data-seq="1"
                                        x-on:keydown.enter.prevent="$el.closest('[x-data]')?.querySelector('[data-seq=&quot;2&quot;]')?.focus()" />
                                    @error('formEntryRacikan.noRacikan')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- Dosis --}}
                                <div class="basis-2/12">
                                    <x-input-label for="formEntryRacikan.dosis" :value="__('Dosis')" :required="true" />
                                    <x-text-input id="formEntryRacikan.dosis" class="mt-1 ml-2" :disabled="$disabledPropertyRjStatus"
                                        wire:model="formEntryRacikan.dosis" data-seq="2"
                                        x-on:keydown.enter.prevent="$el.closest('[x-data]')?.querySelector('[data-seq=&quot;3&quot;]')?.focus()" />
                                    @error('formEntryRacikan.dosis')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- Qty --}}
                                <div class="basis-1/12">
                                    <x-input-label for="formEntryRacikan.qty" :value="__('Jml Racikan')" />
                                    <x-text-input id="formEntryRacikan.qty" class="w-24 mt-1 ml-2" :disabled="$disabledPropertyRjStatus"
                                        wire:model="formEntryRacikan.qty" data-seq="3"
                                        x-on:keydown.enter.prevent="$el.closest('[x-data]')?.querySelector('[data-seq=&quot;4&quot;]')?.focus()" />
                                    @error('formEntryRacikan.qty')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- Catatan --}}
                                <div class="basis-2/12">
                                    <x-input-label for="formEntryRacikan.catatan" :value="__('Catatan')" />
                                    <x-text-input id="formEntryRacikan.catatan" class="mt-1 ml-2" :disabled="$disabledPropertyRjStatus"
                                        wire:model="formEntryRacikan.catatan" data-seq="4"
                                        x-on:keydown.enter.prevent="$el.closest('[x-data]')?.querySelector('[data-seq=&quot;5&quot;]')?.focus()" />
                                    @error('formEntryRacikan.catatan')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- Signa (catatanKhusus) --}}
                                <div class="basis-3/6">
                                    <x-input-label for="formEntryRacikan.catatanKhusus" :value="__('Signa')" />
                                    <x-text-input id="formEntryRacikan.catatanKhusus" class="mt-1 ml-2" :disabled="$disabledPropertyRjStatus"
                                        wire:model="formEntryRacikan.catatanKhusus" data-seq="5"
                                        x-on:keydown.enter.prevent="
                                                 $wire.insertProduct();
                                                 $nextTick(() => {
                                                     $el.closest('[x-data]')?.querySelector('[data-seq=&quot;3&quot;]')?.focus()
                                                 })
                                             " />
                                    @error('formEntryRacikan.catatanKhusus')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- Reset --}}
                                <div class="basis-1/6">
                                    <x-input-label :value="__('Hapus')" />
                                    <x-alternative-button class="inline-flex ml-2"
                                        wire:click.prevent="resetformEntryRacikan()"
                                        x-on:click="$nextTick(() => { $el.closest('[x-data]')?.querySelector('[data-seq=&quot;3&quot;]')?.focus() })">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 18 20">
                                            <path
                                                d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                        </svg>
                                    </x-alternative-button>
                                </div>
                            </div>
                        @endif
                    @endrole

                    {{-- ===================== TABEL RACIKAN ===================== --}}
                    <div class="flex flex-col my-2">
                        <div class="overflow-x-auto rounded-lg">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden shadow sm:rounded-lg">
                                    <table class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th class="px-4 py-3">Racikan</th>
                                                <th class="px-4 py-3">Obat</th>
                                                <th class="px-4 py-3">Dosis</th>
                                                <th class="px-4 py-3">Jml Racikan</th>
                                                <th class="px-4 py-3">Catatan</th>
                                                <th class="px-4 py-3">Signa</th>
                                                <th class="w-8 px-4 py-3 text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800">
                                            @isset($dataDaftarPoliRJ['eresepRacikan'])
                                                @php $myPreviousRow = ''; @endphp
                                                @foreach ($dataDaftarPoliRJ['eresepRacikan'] as $key => $eresep)
                                                    @php
                                                        $myRacikanBorder =
                                                            $myPreviousRow !== ($eresep['noRacikan'] ?? '')
                                                                ? 'border-t-2 '
                                                                : '';
                                                    @endphp

                                                    <tr class="{{ $myRacikanBorder }} group">
                                                        <td
                                                            class="px-4 py-3 text-gray-700 group-hover:bg-gray-50 dark:text-white">
                                                            {{ ($eresep['jenisKeterangan'] ?? 'Racikan') . ' (' . ($eresep['noRacikan'] ?? '-') . ')' }}
                                                        </td>

                                                        <td
                                                            class="px-4 py-3 text-gray-700 group-hover:bg-gray-50 dark:text-white">
                                                            {{ $eresep['productName'] ?? '-' }}
                                                        </td>

                                                        {{-- Dosis --}}
                                                        <td
                                                            class="px-4 py-3 text-gray-700 group-hover:bg-gray-50 dark:text-white">
                                                            <x-text-input placeholder="Dosis" class="w-full mt-1"
                                                                :disabled="$disabledPropertyRjStatus"
                                                                wire:model="dataDaftarPoliRJ.eresepRacikan.{{ $key }}.dosis"
                                                                data-seq="1"
                                                                x-on:keydown.enter.prevent="$el.closest('tr')?.querySelector('[data-seq=&quot;2&quot;]')?.focus()" />
                                                        </td>

                                                        {{-- Qty --}}
                                                        <td
                                                            class="px-4 py-3 text-gray-700 group-hover:bg-gray-50 dark:text-white">
                                                            <x-text-input placeholder="Jumlah" class="mt-1 w-28"
                                                                :disabled="$disabledPropertyRjStatus"
                                                                wire:model="dataDaftarPoliRJ.eresepRacikan.{{ $key }}.qty"
                                                                data-seq="2"
                                                                x-on:keydown.enter.prevent="$el.closest('tr')?.querySelector('[data-seq=&quot;3&quot;]')?.focus()" />
                                                        </td>

                                                        {{-- Catatan --}}
                                                        <td
                                                            class="px-4 py-3 text-gray-700 group-hover:bg-gray-50 dark:text-white">
                                                            <x-text-input placeholder="Catatan" class="w-full mt-1"
                                                                :disabled="$disabledPropertyRjStatus"
                                                                wire:model="dataDaftarPoliRJ.eresepRacikan.{{ $key }}.catatan"
                                                                data-seq="3"
                                                                x-on:keydown.enter.prevent="$el.closest('tr')?.querySelector('[data-seq=&quot;4&quot;]')?.focus()" />
                                                        </td>

                                                        {{-- Signa (catatanKhusus) --}}
                                                        <td
                                                            class="px-4 py-3 text-gray-700 group-hover:bg-gray-50 dark:text-white">
                                                            <x-text-input placeholder="Signa" class="w-full mt-1"
                                                                :disabled="$disabledPropertyRjStatus"
                                                                wire:model="dataDaftarPoliRJ.eresepRacikan.{{ $key }}.catatanKhusus"
                                                                data-seq="4"
                                                                x-on:keydown.enter.prevent="
                                                                    $wire.updateProduct(
                                                                        '{{ $dataDaftarPoliRJ['eresepRacikan'][$key]['rjObatDtl'] ?? '' }}',
                                                                        '{{ $dataDaftarPoliRJ['eresepRacikan'][$key]['dosis'] ?? '' }}',
                                                                        '{{ $dataDaftarPoliRJ['eresepRacikan'][$key]['qty'] ?? '' }}',
                                                                        '{{ $dataDaftarPoliRJ['eresepRacikan'][$key]['catatan'] ?? '' }}',
                                                                        '{{ $dataDaftarPoliRJ['eresepRacikan'][$key]['catatanKhusus'] ?? '' }}'
                                                                    );
                                                                    $nextTick(() => {
                                                                        $el.closest('tr')?.querySelector('[data-seq=&quot;2&quot;]')?.focus()
                                                                    })
                                                                " />
                                                        </td>

                                                        <td
                                                            class="px-4 py-3 text-center text-gray-700 group-hover:bg-gray-50 dark:text-white">
                                                            @role(['Dokter', 'Admin'])
                                                                <x-alternative-button class="inline-flex" :disabled="$disabledPropertyRjStatus"
                                                                    wire:click.prevent="removeProduct('{{ $eresep['rjObatDtl'] ?? '' }}')">
                                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                                        fill="currentColor" viewBox="0 0 18 20">
                                                                        <path
                                                                            d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                                                    </svg>
                                                                </x-alternative-button>
                                                            @endrole
                                                        </td>
                                                    </tr>

                                                    @php $myPreviousRow = $eresep['noRacikan'] ?? ''; @endphp
                                                @endforeach
                                            @endisset
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- =================== /TABEL RACIKAN =================== --}}
                </div>

            </div>
        </div>
    </div>
</div>
