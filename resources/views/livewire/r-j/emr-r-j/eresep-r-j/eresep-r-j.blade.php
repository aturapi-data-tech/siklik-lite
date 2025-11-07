<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = $rjStatusRef == 'A' ? false : true;
    @endphp

    {{-- jika anamnesa kosong ngak usah di render --}}
    {{-- @if (isset($dataDaftarPoliRJ['diagnosis'])) --}}
    <div class="w-full mb-1 ">
        <div id="TransaksiRawatJalan" class="p-2">
            <div class="p-2 rounded-lg bg-gray-50">



                <div id="TransaksiRawatJalan" class="px-4">
                    <x-input-label for="" :value="__('Non Racikan')" :required="__(false)" class="pt-2 sm:text-xl" />
                    @role(['Dokter', 'Admin'])
                        @if (!$collectingMyProduct)
                            <div class="">
                                @include('livewire.component.l-o-v.list-of-value-product.list-of-value-product')
                            </div>
                        @else
                            {{-- formEntryResepNonRacikan / obat --}}
                            <div class="flex items-baseline space-x-2" x-data x-init="$nextTick(() => { $el.querySelector('[data-scope=&quot;entry&quot;] [data-seq=&quot;1&quot;]')?.focus() })">

                                {{-- scope buat selector enter navigation --}}
                                <div class="hidden" data-scope="entry"></div>

                                {{-- productId (hidden) --}}
                                <div class="hidden">
                                    <x-input-label for="formEntryResepNonRacikan.productId" :value="__('Kode Obat')"
                                        :required="true" />
                                    <x-text-input id="formEntryResepNonRacikan.productId" placeholder="Kode Obat"
                                        class="mt-1 ml-2" :errorshas="$errors->has('formEntryResepNonRacikan.productId')" :disabled="true"
                                        wire:model.debounce.500ms="formEntryResepNonRacikan.productId" />
                                    @error('formEntryResepNonRacikan.productId')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- Nama Obat --}}
                                <div class="basis-3/6">
                                    <x-input-label for="formEntryResepNonRacikan.productName" :value="__('Nama Obat')"
                                        :required="true" />
                                    <x-text-input id="formEntryResepNonRacikan.productName" placeholder="Nama Obat"
                                        class="mt-1 ml-2" :errorshas="$errors->has('formEntryResepNonRacikan.productName')" :disabled="true"
                                        wire:model.debounce.500ms="formEntryResepNonRacikan.productName" />
                                    @error('formEntryResepNonRacikan.productName')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- Qty --}}
                                <div class="basis-1/12">
                                    <x-input-label for="formEntryResepNonRacikan.qty" :value="__('Jml')"
                                        :required="true" />
                                    <x-text-input id="formEntryResepNonRacikan.qty" placeholder="Jml Obat" class="mt-1 ml-2"
                                        :errorshas="$errors->has('formEntryResepNonRacikan.qty')" :disabled="$disabledPropertyRjStatus"
                                        wire:model.debounce.500ms="formEntryResepNonRacikan.qty" data-seq="1"
                                        x-on:keydown.enter.prevent="
                                                                        $el.closest('[x-data]')?.querySelector('[data-seq=&quot;2&quot;]')?.focus()
                                                                    " />
                                    @error('formEntryResepNonRacikan.qty')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- Harga (hidden) --}}
                                <div class="hidden">
                                    <x-input-label for="formEntryResepNonRacikan.productPrice" :value="__('Harga Obat')"
                                        :required="true" />
                                    <x-text-input id="formEntryResepNonRacikan.productPrice" placeholder="Harga Obat"
                                        class="mt-1 ml-2" :errorshas="$errors->has('formEntryResepNonRacikan.productPrice')" :disabled="true"
                                        wire:model.debounce.500ms="formEntryResepNonRacikan.productPrice" />
                                    @error('formEntryResepNonRacikan.productPrice')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- Signa 1 --}}
                                <div class="basis-1/12">
                                    <x-input-label for="formEntryResepNonRacikan.signaX" :value="__('Signa')"
                                        :required="false" />
                                    <x-text-input id="formEntryResepNonRacikan.signaX" placeholder="Signa1"
                                        class="mt-1 ml-2" :errorshas="$errors->has('formEntryResepNonRacikan.signaX')" :disabled="$disabledPropertyRjStatus"
                                        wire:model="formEntryResepNonRacikan.signaX" data-seq="2"
                                        x-on:keydown.enter.prevent="
                                                                        $el.closest('[x-data]')?.querySelector('[data-seq=&quot;3&quot;]')?.focus()
                                                                    " />
                                    @error('formEntryResepNonRacikan.signaX')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                <div class="basis-[4%]">
                                    <x-input-label for="" :value="__('*')" :required="false" />
                                    <span class="text-sm">dd</span>
                                </div>

                                {{-- Signa 2 --}}
                                <div class="basis-1/12">
                                    <x-input-label for="formEntryResepNonRacikan.signaHari" :value="__('*')"
                                        :required="false" />
                                    <x-text-input id="formEntryResepNonRacikan.signaHari" placeholder="Signa2"
                                        class="mt-1 ml-2" :errorshas="$errors->has('formEntryResepNonRacikan.signaHari')" :disabled="$disabledPropertyRjStatus"
                                        wire:model="formEntryResepNonRacikan.signaHari" data-seq="3"
                                        x-on:keydown.enter.prevent="
                                                                        $el.closest('[x-data]')?.querySelector('[data-seq=&quot;4&quot;]')?.focus()
                                                                    " />
                                    @error('formEntryResepNonRacikan.signaHari')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- Catatan Khusus --}}
                                <div class="basis-3/6">
                                    <x-input-label for="formEntryResepNonRacikan.catatanKhusus" :value="__('Catatan Khusus')"
                                        :required="false" />
                                    <x-text-input id="formEntryResepNonRacikan.catatanKhusus" placeholder="Catatan Khusus"
                                        class="mt-1 ml-2" :errorshas="$errors->has('formEntryResepNonRacikan.catatanKhusus')" :disabled="$disabledPropertyRjStatus"
                                        wire:model="formEntryResepNonRacikan.catatanKhusus" data-seq="4"
                                        x-on:keydown.enter.prevent="
                                                                        $wire.insertProduct();
                                                                        $nextTick(() => {
                                                                            $el.closest('[x-data]')?.querySelector('[data-seq=&quot;1&quot;]')?.focus()
                                                                        })
                                                                    " />
                                    @error('formEntryResepNonRacikan.catatanKhusus')
                                        <x-input-error :messages="$message" />
                                    @enderror
                                </div>

                                {{-- Reset --}}
                                <div class="basis-1/6">
                                    <x-input-label for="" :value="__('Hapus')" :required="false" />
                                    <x-alternative-button class="inline-flex ml-2"
                                        wire:click.prevent="resetformEntryResepNonRacikan()"
                                        x-on:click="$nextTick(() => {
                                                                        $el.closest('[x-data]')?.querySelector('[data-seq=&quot;1&quot;]')?.focus()
                                                                    })">
                                        <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                            <path
                                                d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                        </svg>
                                    </x-alternative-button>
                                </div>
                            </div>
                            {{-- formEntryResepNonRacikan / obat --}}
                        @endif
                    @endrole

                    {{-- ///////////////////////////////// --}}
                    <div class="flex flex-col my-2">
                        <div class="overflow-x-auto rounded-lg">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden shadow sm:rounded-lg">
                                    <table class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-4 py-3">

                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        NonRacikan
                                                    </x-sort-link>

                                                </th>

                                                {{-- <th scope="col" class="px-4 py-3">
                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Kode Obat
                                                    </x-sort-link>
                                                </th> --}}

                                                <th scope="col" class="px-4 py-3 ">
                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Obat
                                                    </x-sort-link>
                                                </th>

                                                <th scope="col" class="px-4 py-3 ">
                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Jumlah
                                                    </x-sort-link>
                                                </th>

                                                <th scope="col" class="px-4 py-3 ">
                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Signa
                                                    </x-sort-link>
                                                </th>


                                                <th scope="col" class="w-8 px-4 py-3 text-center">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800">

                                            @isset($dataDaftarPoliRJ['eresep'])
                                                @foreach ($dataDaftarPoliRJ['eresep'] as $key => $eresep)
                                                    @role(['Dokter', 'Admin'])
                                                        <tr class="border-b group dark:border-gray-700">

                                                            <td
                                                                class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                {{ $eresep['jenisKeterangan'] }}
                                                            </td>

                                                            <td
                                                                class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                {{ $eresep['productName'] }}
                                                            </td>

                                                            <td
                                                                class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                {{-- {{ $eresep['qty'] }} --}}
                                                                <div>
                                                                    <x-text-input placeholder="Jumlah" class="w-24 mt-1"
                                                                        :disabled="$disabledPropertyRjStatus"
                                                                        wire:model="dataDaftarPoliRJ.eresep.{{ $key }}.qty"
                                                                        data-seq="1"
                                                                        x-on:keydown.enter.prevent="
                                                                                                        $el.closest('tr')?.querySelector('[data-seq=&quot;2&quot;]')?.focus()
                                                                                                    " />
                                                                </div>
                                                            </td>

                                                            <td
                                                                class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">


                                                                {{-- Signa (di dalam <td>) --}}
                                                                <div class="flex items-baseline space-x-2">
                                                                    <div class="basis-[20%]">
                                                                        <x-text-input placeholder="Signa1" class="mt-1 ml-2"
                                                                            :disabled="$disabledPropertyRjStatus"
                                                                            wire:model="dataDaftarPoliRJ.eresep.{{ $key }}.signaX"
                                                                            data-seq="2"
                                                                            x-on:keydown.enter.prevent="
                                                                                                            $el.closest('tr')?.querySelector('[data-seq=&quot;3&quot;]')?.focus()
                                                                                                        " />
                                                                    </div>

                                                                    <div class="basis-[4%]">
                                                                        <span class="text-sm">dd</span>
                                                                    </div>

                                                                    <div class="basis-[20%]">
                                                                        <x-text-input placeholder="Signa2" class="mt-1 ml-2"
                                                                            :disabled="$disabledPropertyRjStatus"
                                                                            wire:model="dataDaftarPoliRJ.eresep.{{ $key }}.signaHari"
                                                                            data-seq="3"
                                                                            x-on:keydown.enter.prevent="
                                                                                                            $el.closest('tr')?.querySelector('[data-seq=&quot;4&quot;]')?.focus()
                                                                                                        " />
                                                                    </div>

                                                                    <div class="basis-3/6">
                                                                        <x-text-input placeholder="Catatan Khusus"
                                                                            class="mt-1 ml-2" :disabled="$disabledPropertyRjStatus"
                                                                            wire:model="dataDaftarPoliRJ.eresep.{{ $key }}.catatanKhusus"
                                                                            data-seq="4"
                                                                            x-on:keydown.enter.prevent="
                                                                                                            $wire.updateProduct(
                                                                                                                '{{ $dataDaftarPoliRJ['eresep'][$key]['rjObatDtl'] ?? '' }}',
                                                                                                                '{{ $dataDaftarPoliRJ['eresep'][$key]['qty'] ?? '' }}',
                                                                                                                '{{ $dataDaftarPoliRJ['eresep'][$key]['signaX'] ?? '' }}',
                                                                                                                '{{ $dataDaftarPoliRJ['eresep'][$key]['signaHari'] ?? '' }}',
                                                                                                                '{{ $dataDaftarPoliRJ['eresep'][$key]['catatanKhusus'] ?? '' }}'
                                                                                                            );
                                                                                                            $nextTick(() => {
                                                                                                                $el.closest('tr')?.querySelector('[data-seq=&quot;1&quot;]')?.focus()
                                                                                                            })
                                                                                                        " />
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td
                                                                class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                @role(['Dokter', 'Admin'])
                                                                    <x-alternative-button class="inline-flex"
                                                                        :disabled=$disabledPropertyRjStatus
                                                                        wire:click.prevent="removeProduct('{{ $eresep['rjObatDtl'] }}')">
                                                                        <svg class="w-5 h-5 text-gray-800 dark:text-white"
                                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                            fill="currentColor" viewBox="0 0 18 20">
                                                                            <path
                                                                                d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                                                        </svg>
                                                                        {{ '' }}
                                                                    </x-alternative-button>
                                                                @endrole
                                                            </td>




                                                        </tr>
                                                    @endrole
                                                    {{--  --}}
                                                    @role(['Apoteker'])
                                                        <tr class="border-b group dark:border-gray-700">

                                                            <td
                                                                class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                {{ $eresep['jenisKeterangan'] }}
                                                            </td>

                                                            {{-- <td
                                                                class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                {{ $eresep['productId'] }}
                                                            </td> --}}

                                                            <td
                                                                class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                {{ $eresep['productName'] }}
                                                            </td>

                                                            <td
                                                                class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                {{-- {{ $eresep['qty'] }} --}}
                                                                <div>
                                                                    <x-text-input placeholder="Jml Racikan" class=""
                                                                        :disabled=true
                                                                        wire:model="dataDaftarPoliRJ.eresep.{{ $key }}.qty"
                                                                        x-ref="dataDaftarPoliRJeresep{{ $key }}qty"
                                                                        x-on:keyup.enter="$refs.dataDaftarPoliRJeresep{{ $key }}signaX.focus()" />
                                                                </div>
                                                            </td>

                                                            <td
                                                                class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                <div class="flex items-baseline space-x-2">

                                                                    <div class="basis-[20%]">

                                                                        <div>
                                                                            <x-text-input placeholder="Signa1"
                                                                                class="mt-1 ml-2" :disabled=true
                                                                                wire:model="dataDaftarPoliRJ.eresep.{{ $key }}.signaX"
                                                                                x-ref="dataDaftarPoliRJeresep{{ $key }}signaX"
                                                                                x-on:keyup.enter="$refs.dataDaftarPoliRJeresep{{ $key }}signaHari.focus()" />


                                                                        </div>
                                                                    </div>

                                                                    <div class="basis-[4%]">

                                                                        <div>
                                                                            <span class="text-sm">{{ 'dd' }}</span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="basis-[20%]">

                                                                        <div>
                                                                            <x-text-input placeholder="Signa2"
                                                                                class="mt-1 ml-2" :disabled=true
                                                                                wire:model="dataDaftarPoliRJ.eresep.{{ $key }}.signaHari"
                                                                                x-ref="dataDaftarPoliRJeresep{{ $key }}signaHari"
                                                                                x-on:keyup.enter="$refs.dataDaftarPoliRJeresep{{ $key }}catatanKhusus.focus()" />


                                                                        </div>
                                                                    </div>

                                                                    <div class="basis-3/6">

                                                                        <div>
                                                                            <x-text-input placeholder="Catatan Khusus"
                                                                                class="mt-1 ml-2" :disabled=true
                                                                                wire:model="dataDaftarPoliRJ.eresep.{{ $key }}.catatanKhusus"
                                                                                x-on:keyup.enter="$wire.updateProduct('{{ $dataDaftarPoliRJ['eresep'][$key]['rjObatDtl'] ? $dataDaftarPoliRJ['eresep'][$key]['rjObatDtl'] : null }}', '{{ $dataDaftarPoliRJ['eresep'][$key]['qty'] ? $dataDaftarPoliRJ['eresep'][$key]['qty'] : null }}','{{ $dataDaftarPoliRJ['eresep'][$key]['signaX'] ? $dataDaftarPoliRJ['eresep'][$key]['signaX'] : null }}', '{{ $dataDaftarPoliRJ['eresep'][$key]['signaHari'] ? $dataDaftarPoliRJ['eresep'][$key]['signaHari'] : null }}', '{{ $dataDaftarPoliRJ['eresep'][$key]['catatanKhusus'] ? $dataDaftarPoliRJ['eresep'][$key]['catatanKhusus'] : null }}')
                                                                        $refs.dataDaftarPoliRJeresep{{ $key }}qty.focus()"
                                                                                x-ref="dataDaftarPoliRJeresep{{ $key }}catatanKhusus" />


                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </td>

                                                            <td
                                                                class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                @role(['Dokter', 'Admin'])
                                                                    <x-alternative-button class="inline-flex" :disabled=true
                                                                        wire:click.prevent="removeProduct('{{ $eresep['rjObatDtl'] }}')">
                                                                        <svg class="w-5 h-5 text-gray-800 dark:text-white"
                                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                            fill="currentColor" viewBox="0 0 18 20">
                                                                            <path
                                                                                d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                                                        </svg>
                                                                        {{ '' }}
                                                                    </x-alternative-button>
                                                                @endrole
                                                            </td>




                                                        </tr>
                                                    @endrole
                                                    {{--  --}}
                                                @endforeach
                                            @endisset


                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ///////////////////////////////// --}}


                </div>





            </div>
        </div>



    </div>
</div>
