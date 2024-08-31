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
                    <x-input-label for="" :value="__('Racikan')" :required="__(false)" class="pt-2 sm:text-xl" />


                    @role(['Dokter', 'Admin'])
                        {{-- collectingMyProduct / obat --}}
                        @if (!$collectingMyProduct)
                            <div class="grid grid-cols-8 gap-4" x-data="{ selecteddataProductLovIndex: @entangle('selecteddataProductLovIndex') }"
                                @click.outside="$wire.dataProductLovSearch = ''">
                                <div class="col-span-1">
                                    <x-input-label for="collectingMyProduct.noRacikan" :value="__('Racikan')"
                                        :required="__(true)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.noRacikan" placeholder="Racikan"
                                            class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyProduct.noRacikan'))" :disabled=$disabledPropertyRjStatus
                                            wire:model="noRacikan" x-ref="collectingMyProductnoRacikan"
                                            x-on:keyup.enter="$refs.dataProductLovSearchMain.focus()" />

                                        @error('collectingMyProduct.noRacikan')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-7">
                                    <x-input-label for="dataProductLovSearch" :value="__('Nama Obat')" :required="__(true)" />

                                    {{-- Lov dataProductLov --}}
                                    <div>
                                        <x-text-input id="dataProductLovSearchMain" placeholder="Nama Obat"
                                            class="mt-1 ml-2" :errorshas="__($errors->has('dataProductLovSearchMain'))" :disabled=$disabledPropertyRjStatus
                                            wire:model="dataProductLovSearch"
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
                            </div>
                        @endif

                        @if ($collectingMyProduct)
                            {{-- collectingMyProduct / obat --}}
                            <div class="inline-flex space-x-0.5" x-data>
                                <div class="basis-1/4">
                                    <x-input-label for="collectingMyProduct.noRacikan" :value="__('Racikan')"
                                        :required="__(true)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.noRacikan" placeholder="Racikan"
                                            class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyProduct.noRacikan'))" :disabled=$disabledPropertyRjStatus
                                            wire:model="noRacikan" x-ref="collectingMyProductnoRacikan"
                                            x-on:keyup.enter="$refs.collectingMyProductproductName.focus()" />

                                        @error('collectingMyProduct.noRacikan')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>

                                <div class="hidden">
                                    <x-input-label for="collectingMyProduct.productId" :value="__('Kode Obat')"
                                        :required="__(true)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.productId" placeholder="Kode Obat"
                                            class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyProduct.productId'))" :disabled=true
                                            wire:model="collectingMyProduct.productId" />

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
                                            wire:model="collectingMyProduct.productName" />

                                        @error('collectingMyProduct.productName')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>



                                <div class="basis-1/4">
                                    <x-input-label for="collectingMyProduct.dosis" :value="__('Dosis')" :required="__(true)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.dosis" placeholder="dosis" class="mt-1 ml-2"
                                            :errorshas="__($errors->has('collectingMyProduct.dosis'))" :disabled=$disabledPropertyRjStatus
                                            x-ref="collectingMyProductdosis" x-init="$refs.collectingMyProductdosis.focus()"
                                            x-on:keyup.enter="$refs.collectingMyProductqty.focus()"
                                            wire:model="collectingMyProduct.dosis" />

                                        @error('collectingMyProduct.dosis')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>



                                <div class="basis-2/4">
                                    <x-input-label for="collectingMyProduct.qty" :value="__('Jml Racikan')" :required="__(false)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.qty" placeholder="Jml Racikan"
                                            class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyProduct.qty'))" :disabled=$disabledPropertyRjStatus
                                            wire:model="collectingMyProduct.qty" x-ref="collectingMyProductqty"
                                            x-on:keyup.enter="$refs.collectingMyProductcatatan.focus()" />

                                        @error('collectingMyProduct.qty')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>

                                <div class="basis-1/4">
                                    <x-input-label for="collectingMyProduct.catatan" :value="__('Catatan')"
                                        :required="__(false)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.catatan" placeholder="Catatan"
                                            class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyProduct.catatan'))" :disabled=$disabledPropertyRjStatus
                                            x-ref="collectingMyProductcatatan"
                                            x-on:keyup.enter="$refs.collectingMyProductcatatanKhusus.focus()"
                                            wire:model="collectingMyProduct.catatan" />

                                        @error('collectingMyProduct.catatan')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>

                                <div class="basis-3/4">
                                    <x-input-label for="collectingMyProduct.catatanKhusus" :value="__('Signa')"
                                        :required="__(false)" />

                                    <div>
                                        <x-text-input id="collectingMyProduct.catatanKhusus" placeholder="Signa"
                                            class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyProduct.catatanKhusus'))" :disabled=$disabledPropertyRjStatus
                                            wire:model="collectingMyProduct.catatanKhusus"
                                            x-on:keyup.enter="$wire.insertProduct()
                                        $refs.collectingMyProductproductName.focus()"
                                            x-ref="collectingMyProductcatatanKhusus" />

                                        @error('collectingMyProduct.catatanKhusus')
                                            <x-input-error :messages=$message />
                                        @enderror
                                    </div>
                                </div>

                                <div class="basis-1/4">
                                    <x-input-label for="" :value="__('Hapus')" :required="__(false)" />

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

                        {{-- collectingMyProduct / obat --}}
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
                                                        Racikan
                                                    </x-sort-link>

                                                </th>

                                                <th scope="col" class="px-4 py-3 ">
                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Obat
                                                    </x-sort-link>
                                                </th>

                                                <th scope="col" class="px-4 py-3 ">
                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Dosis
                                                    </x-sort-link>
                                                </th>

                                                <th scope="col" class="px-4 py-3 ">
                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Jml Racikan
                                                    </x-sort-link>
                                                </th>

                                                <th scope="col" class="px-4 py-3 ">
                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Catatan
                                                    </x-sort-link>
                                                </th>

                                                <th scope="col" class="px-4 py-3 ">
                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Signa____
                                                    </x-sort-link>
                                                </th>

                                                <th scope="col" class="w-8 px-4 py-3 text-center">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800">

                                            @isset($dataDaftarPoliRJ['eresepRacikan'])
                                                @php
                                                    $myPreviousRow = '';
                                                @endphp
                                                @foreach ($dataDaftarPoliRJ['eresepRacikan'] as $key => $eresep)
                                                    @php
                                                        $myRacikanBorder =
                                                            $myPreviousRow !== $eresep['noRacikan']
                                                                ? 'border-t-2 '
                                                                : '';
                                                    @endphp

                                                    <tr class="{{ $myRacikanBorder }} group">

                                                        <td
                                                            class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                            {{ $eresep['jenisKeterangan'] . '  (' . $eresep['noRacikan'] . ')' }}
                                                        </td>


                                                        <td
                                                            class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                            {{ $eresep['productName'] }}
                                                        </td>

                                                        <td
                                                            class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                            {{-- {{ isset($eresep['dosis']) ? ($eresep['dosis'] ? $eresep['dosis'] : '-') : '-' }} --}}

                                                            <div>
                                                                <x-text-input placeholder="dosis" class=""
                                                                    :disabled=$disabledPropertyRjStatus
                                                                    x-ref="dataDaftarPoliRJeresepRacikan{{ $key }}dosis"
                                                                    x-on:keyup.enter="$refs.dataDaftarPoliRJeresepRacikan{{ $key }}qty.focus()"
                                                                    wire:model="dataDaftarPoliRJ.eresepRacikan.{{ $key }}.dosis" />

                                                            </div>




                                                        </td>

                                                        <td
                                                            class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                            {{-- {{ $eresep['qty'] }} --}}

                                                            <div>
                                                                <x-text-input placeholder="Jml Racikan" class=""
                                                                    :disabled=$disabledPropertyRjStatus
                                                                    wire:model="dataDaftarPoliRJ.eresepRacikan.{{ $key }}.qty"
                                                                    x-ref="dataDaftarPoliRJeresepRacikan{{ $key }}qty"
                                                                    x-on:keyup.enter="$refs.dataDaftarPoliRJeresepRacikan{{ $key }}catatan.focus()" />
                                                            </div>
                                                        </td>

                                                        <td
                                                            class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                            {{-- {{ $eresep['catatan'] }} --}}

                                                            <div>
                                                                <x-text-input placeholder="Catatan" class=""
                                                                    :disabled=$disabledPropertyRjStatus
                                                                    x-ref="dataDaftarPoliRJeresepRacikan{{ $key }}catatan"
                                                                    x-on:keyup.enter="$refs.dataDaftarPoliRJeresepRacikan{{ $key }}catatanKhusus.focus()"
                                                                    wire:model="dataDaftarPoliRJ.eresepRacikan.{{ $key }}.catatan" />


                                                            </div>
                                                        </td>

                                                        <td
                                                            class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                            {{-- {{ $eresep['catatanKhusus'] }} --}}
                                                            <div>
                                                                <x-text-input placeholder="Signa" class=""
                                                                    :disabled=$disabledPropertyRjStatus
                                                                    wire:model="dataDaftarPoliRJ.eresepRacikan.{{ $key }}.catatanKhusus"
                                                                    x-on:keyup.enter="$wire.updateProduct('{{ $dataDaftarPoliRJ['eresepRacikan'][$key]['rjObatDtl'] ? $dataDaftarPoliRJ['eresepRacikan'][$key]['rjObatDtl'] : null }}','{{ $dataDaftarPoliRJ['eresepRacikan'][$key]['dosis'] ? $dataDaftarPoliRJ['eresepRacikan'][$key]['dosis'] : null }}','{{ $dataDaftarPoliRJ['eresepRacikan'][$key]['qty'] ? $dataDaftarPoliRJ['eresepRacikan'][$key]['qty'] : null }}','{{ $dataDaftarPoliRJ['eresepRacikan'][$key]['catatan'] ? $dataDaftarPoliRJ['eresepRacikan'][$key]['catatan'] : null }}','{{ $dataDaftarPoliRJ['eresepRacikan'][$key]['catatanKhusus'] ? $dataDaftarPoliRJ['eresepRacikan'][$key]['catatanKhusus'] : null }}')"
                                                                    x-ref="dataDaftarPoliRJeresepRacikan{{ $key }}catatanKhusus" />

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
                                                                </x-alternative-button>
                                                            @endrole
                                                        </td>

                                                    </tr>

                                                    @php
                                                        $myPreviousRow = $eresep['noRacikan'];
                                                    @endphp
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
