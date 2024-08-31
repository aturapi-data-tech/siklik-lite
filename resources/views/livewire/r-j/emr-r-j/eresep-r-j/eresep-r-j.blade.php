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
                            <div>
                                <x-input-label for="dataProductLovSearch" :value="__('Nama Obat')" :required="__(true)" />

                                {{-- Lov dataProductLov --}}
                                <div x-data="{ selecteddataProductLovIndex: @entangle('selecteddataProductLovIndex') }" @click.outside="$wire.dataProductLovSearch = ''">
                                    <x-text-input id="dataProductLovSearchMain" placeholder="Nama Obat" class="mt-1 ml-2"
                                        :errorshas="__($errors->has('dataProductLovSearchMain'))" :disabled=$disabledPropertyRjStatus
                                        wire:model.debounce.500ms="dataProductLovSearch"
                                        x-on:click.outside="$wire.resetdataProductLov()"
                                        x-on:keyup.escape="$wire.resetdataProductLov()"
                                        x-on:keyup.down="$wire.selectNextdataProductLov()"
                                        x-on:keyup.up="$wire.selectPreviousdataProductLov()"
                                        x-on:keyup.enter="$wire.enterMydataProductLov(selecteddataProductLovIndex)"
                                        x-ref="dataProductLovSearchMain" x-init="$watch('selecteddataProductLovIndex', (value, oldValue) => $refs.dataProductLovSearch.children[selecteddataProductLovIndex + 1].scrollIntoView({
                                            block: 'nearest'
                                        }))
                                        $refs.dataProductLovSearchMain.focus()" />

                                    {{-- Lov --}}
                                    <div class="py-2 mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-64"
                                        x-show="$wire.dataProductLovSearch.length>3 && $wire.dataProductLov.length>0"
                                        x-transition x-ref="dataProductLovSearch">
                                        {{-- alphine --}}
                                        {{-- <template x-for="(dataProductLovx, index) in $wire.dataProductLov">
                                        <button x-text="dataProductLovx.product_name"
                                            class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                            :class="{
                                                'bg-gray-100 outline-none': index === $wire
                                                    .selecteddataProductLovIndex
                                            }"
                                            x-on:click.prevent="$wire.setMydataProductLov(index)"></button>
                                    </template> --}}

                                        {{-- livewire --}}
                                        @foreach ($dataProductLov as $key => $lov)
                                            <li wire:key='dataProductLov{{ $lov['product_name'] }}'>
                                                <x-dropdown-link wire:click="setMydataProductLov('{{ $key }}')"
                                                    class="text-base font-normal {{ $key === $selecteddataProductLovIndex ? 'bg-gray-100 outline-none' : '' }}">
                                                    <div>
                                                        {{ $lov['product_name'] . ' / ' . number_format($lov['sales_price']) }}
                                                    </div>
                                                    <div class="text-xs">
                                                        {{ '(' . $lov['product_content'] . ')' }}
                                                    </div>
                                                </x-dropdown-link>
                                            </li>
                                        @endforeach

                                    </div>


                                    {{-- Start Lov exceptions --}}

                                    @if (strlen($dataProductLovSearch) > 0 && strlen($dataProductLovSearch) < 3 && count($dataProductLov) == 0)
                                        <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                            {{ 'Masukkan minimal 3 karakter' }}
                                        </div>
                                    @elseif(strlen($dataProductLovSearch) >= 3 && count($dataProductLov) == 0)
                                        <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                            {{ 'Data Tidak ditemukan' }}
                                        </div>
                                    @endif
                                    {{-- End Lov exceptions --}}

                                    @error('dataProductLovSearch')
                                        <x-input-error :messages=$message />
                                    @enderror
                                </div>
                                {{-- Lov dataProductLov --}}
                            </div>
                        @endif

                        @if ($collectingMyProduct)
                            {{-- collectingMyProduct / obat --}}
                            <div class="flex items-baseline space-x-2" x-data>

                                <div class="hidden">
                                    <x-input-label for="collectingMyProduct.productId" :value="__('Kode Obat')"
                                        :required="__(true)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.productId" placeholder="Kode Obat"
                                            class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyProduct.productId'))" :disabled=true
                                            wire:model.debounce.500ms="collectingMyProduct.productId" />

                                        @error('collectingMyProduct.productId')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>

                                <div class="basis-3/6">
                                    <x-input-label for="collectingMyProduct.productName" :value="__('Nama Obat')"
                                        :required="__(true)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.productName" placeholder="Nama Obat"
                                            class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyProduct.productName'))" :disabled=true
                                            wire:model.debounce.500ms="collectingMyProduct.productName" />

                                        @error('collectingMyProduct.productName')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>

                                <div class="basis-1/12">
                                    <x-input-label for="collectingMyProduct.qty" :value="__('Jml')" :required="__(true)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.qty" placeholder="Jml Obat" class="mt-1 ml-2"
                                            :errorshas="__($errors->has('collectingMyProduct.qty'))" :disabled=$disabledPropertyRjStatus
                                            wire:model.debounce.500ms="collectingMyProduct.qty" x-init="$refs.collectingMyProductqty.focus()"
                                            x-ref="collectingMyProductqty"
                                            x-on:keyup.enter="$refs.collectingMyProductsignaX.focus()" />

                                        @error('collectingMyProduct.qty')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>


                                <div class="hidden ">
                                    <x-input-label for="collectingMyProduct.productPrice" :value="__('Harga Obat')"
                                        :required="__(true)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.productPrice" placeholder="Harga Obat"
                                            class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyProduct.productPrice'))" :disabled=true
                                            wire:model.debounce.500ms="collectingMyProduct.productPrice" />

                                        @error('collectingMyProduct.productPrice')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>

                                <div class="basis-1/12">
                                    <x-input-label for="collectingMyProduct.signaX" :value="__('Signa')" :required="__(false)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.signaX" placeholder="Signa1" class="mt-1 ml-2"
                                            :errorshas="__($errors->has('collectingMyProduct.signaX'))" :disabled=$disabledPropertyRjStatus
                                            wire:model="collectingMyProduct.signaX" x-ref="collectingMyProductsignaX"
                                            x-on:keyup.enter="$refs.collectingMyProductsignaHari.focus()" />

                                        @error('collectingMyProduct.signaX')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>

                                <div class="basis-[4%]">
                                    <x-input-label for="" :value="__('*')" :required="__(false)" />

                                    <div>
                                        <span class="text-sm">{{ 'dd' }}</span>
                                    </div>
                                </div>

                                <div class="basis-1/12">
                                    <x-input-label for="collectingMyProduct.signaHari" :value="__('*')"
                                        :required="__(false)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.signaHari" placeholder="Signa2"
                                            class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyProduct.signaHari'))" :disabled=$disabledPropertyRjStatus
                                            wire:model="collectingMyProduct.signaHari" x-ref="collectingMyProductsignaHari"
                                            x-on:keyup.enter="$refs.collectingMyProductcatatanKhusus.focus()" />

                                        @error('collectingMyProduct.signaHari')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>

                                <div class="basis-3/6">
                                    <x-input-label for="collectingMyProduct.catatanKhusus" :value="__('Catatan Khusus')"
                                        :required="__(true)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.catatanKhusus" placeholder="Catatan Khusus"
                                            class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyProduct.catatanKhusus'))" :disabled=$disabledPropertyRjStatus
                                            wire:model="collectingMyProduct.catatanKhusus"
                                            x-on:keyup.enter="$wire.insertProduct()
                                        $refs.collectingMyProductqty.focus()"
                                            x-ref="collectingMyProductcatatanKhusus" />

                                        @error('collectingMyProduct.catatanKhusus')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>

                                <div class="basis-1/6">
                                    <x-input-label for="" :value="__('Hapus')" :required="__(true)" />

                                    <x-alternative-button class="inline-flex ml-2"
                                        wire:click.prevent="resetcollectingMyProduct()"
                                        x-on:click="$refs.collectingMyProductproductName.focus()">
                                        <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                            <path
                                                d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                        </svg>
                                    </x-alternative-button>
                                </div>

                            </div>
                            {{-- collectingMyProduct / obat --}}
                        @endif
                    @endrole

                    {{-- ///////////////////////////////// --}}
                    <div class="flex flex-col my-2">
                        <div class="overflow-x-auto rounded-lg">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden shadow sm:rounded-lg">
                                    <table
                                        class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
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
                                                                    :disabled=$disabledPropertyRjStatus
                                                                    wire:model="dataDaftarPoliRJ.eresep.{{ $key }}.qty"
                                                                    x-ref="dataDaftarPoliRJeresep{{ $key }}qty"
                                                                    x-on:keyup.enter="$refs.dataDaftarPoliRJeresep{{ $key }}signaX.focus()" />
                                                            </div>
                                                        </td>

                                                        <td
                                                            class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                            {{-- {{ $eresep['signaX'] . 'dd' . $eresep['signaHari'] }}
                                                            @if ($eresep['catatanKhusus'])
                                                                {{ ' (' . $eresep['catatanKhusus'] . ')' }}
                                                            @endif --}}

                                                            <div class="flex items-baseline space-x-2">

                                                                <div class="basis-[20%]">

                                                                    <div>
                                                                        <x-text-input placeholder="Signa1"
                                                                            class="mt-1 ml-2"
                                                                            :disabled=$disabledPropertyRjStatus
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
                                                                            class="mt-1 ml-2"
                                                                            :disabled=$disabledPropertyRjStatus
                                                                            wire:model="dataDaftarPoliRJ.eresep.{{ $key }}.signaHari"
                                                                            x-ref="dataDaftarPoliRJeresep{{ $key }}signaHari"
                                                                            x-on:keyup.enter="$refs.dataDaftarPoliRJeresep{{ $key }}catatanKhusus.focus()" />


                                                                    </div>
                                                                </div>

                                                                <div class="basis-3/6">

                                                                    <div>
                                                                        <x-text-input placeholder="Catatan Khusus"
                                                                            class="mt-1 ml-2"
                                                                            :disabled=$disabledPropertyRjStatus
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
