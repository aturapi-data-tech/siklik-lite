<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp

    {{-- jika anamnesa kosong ngak usah di render --}}
    {{-- @if (isset($dataDaftarPoliRJ['diagnosis'])) --}}
    <div class="w-full mb-1 ">

        <div id="TransaksiRawatJalan" class="">

            @if (!$collectingMyJasaDokter)
                <div>
                    <x-input-label for="dataJasaDokterLovSearch" :value="__('Jasa Dokter')" :required="__(true)" />

                    {{-- Lov dataJasaDokterLov --}}
                    <div x-data="{ selecteddataJasaDokterLovIndex: @entangle('selecteddataJasaDokterLovIndex') }" @click.outside="$wire.dataJasaDokterLovSearch = ''">
                        <x-text-input id="dataJasaDokterLovSearch" placeholder="Jasa Dokter" class="mt-1 ml-2"
                            :errorshas="__($errors->has('dataJasaDokterLovSearch'))" :disabled=$disabledPropertyRjStatus
                            wire:model.debounce.500ms="dataJasaDokterLovSearch"
                            x-on:click.outside="$wire.resetdataJasaDokterLov()"
                            x-on:keyup.escape="$wire.resetdataJasaDokterLov()"
                            x-on:keyup.down="$wire.selectNextdataJasaDokterLov()"
                            x-on:keyup.up="$wire.selectPreviousdataJasaDokterLov()"
                            x-on:keyup.enter="$wire.enterMydataJasaDokterLov(selecteddataJasaDokterLovIndex)"
                            x-ref="dataJasaDokterLovSearchfocus" x-init="$refs.dataJasaDokterLovSearchfocus.focus()
                            $watch('selecteddataJasaDokterLovIndex', (value, oldValue) => $refs.dataJasaDokterLovSearch.children[selecteddataJasaDokterLovIndex + 1].scrollIntoView({
                                block: 'nearest'
                            }))" />

                        {{-- Lov --}}
                        <div class="py-2 mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-64"
                            x-show="$wire.dataJasaDokterLovSearch.length>1 && $wire.dataJasaDokterLov.length>0"
                            x-transition x-ref="dataJasaDokterLovSearch">
                            {{-- alphine --}}
                            {{-- <template x-for="(dataJasaDokterLovx, index) in $wire.dataJasaDokterLov">
                                        <button x-text="dataJasaDokterLovx.accdoc_desc"
                                            class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                            :class="{
                                                'bg-gray-100 outline-none': index === $wire
                                                    .selecteddataJasaDokterLovIndex
                                            }"
                                            x-on:click.prevent="$wire.setMydataJasaDokterLov(index)"></button>
                                    </template> --}}

                            {{-- livewire --}}
                            @foreach ($dataJasaDokterLov as $key => $lov)
                                <li wire:key='dataJasaDokterLov{{ $lov['accdoc_desc'] }}'>
                                    <x-dropdown-link wire:click="setMydataJasaDokterLov('{{ $key }}')"
                                        class="text-base font-normal {{ $key === $selecteddataJasaDokterLovIndex ? 'bg-gray-100 outline-none' : '' }}">
                                        <div>
                                            {{ $lov['accdoc_desc'] . '/ ' . $lov['accdoc_price'] }}
                                        </div>
                                    </x-dropdown-link>
                                </li>
                            @endforeach

                        </div>


                        {{-- Start Lov exceptions --}}

                        @if (strlen($dataJasaDokterLovSearch) > 0 && strlen($dataJasaDokterLovSearch) < 1 && count($dataJasaDokterLov) == 0)
                            <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                {{ 'Masukkan minimal lebih dari 1  karakter' }}
                            </div>
                        @elseif(strlen($dataJasaDokterLovSearch) >= 1 && count($dataJasaDokterLov) == 0)
                            <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                {{ 'Data Tidak ditemukan' }}
                            </div>
                        @endif
                        {{-- End Lov exceptions --}}

                        @error('dataJasaDokterLovSearch')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>
                    {{-- Lov dataJasaDokterLov --}}
                </div>
            @endif

            @if ($collectingMyJasaDokter)
                {{-- collectingMyJasaDokter / obat --}}
                <div class="grid grid-cols-12 gap-2 " x-data>
                    <div class="col-span-1">
                        <x-input-label for="collectingMyJasaDokter.JasaDokterId" :value="__('Kode')" :required="__(true)" />

                        <div>
                            <x-text-input id="collectingMyJasaDokter.JasaDokterId" placeholder="Kode" class="mt-1 ml-2"
                                :errorshas="__($errors->has('collectingMyJasaDokter.JasaDokterId'))" :disabled=true
                                wire:model.debounce.500ms="collectingMyJasaDokter.JasaDokterId" />

                            @error('collectingMyJasaDokter.JasaDokterId')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-3">
                        <x-input-label for="collectingMyJasaDokter.JasaDokterDesc" :value="__('Jasa Dokter')"
                            :required="__(true)" />

                        <div>
                            <x-text-input id="collectingMyJasaDokter.JasaDokterDesc" placeholder="Jasa Dokter"
                                class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyJasaDokter.JasaDokterDesc'))" :disabled=true
                                wire:model.debounce.500ms="collectingMyJasaDokter.JasaDokterDesc" />

                            @error('collectingMyJasaDokter.JasaDokterDesc')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-3">
                        <x-input-label for="collectingMyJasaDokter.JasaDokterPrice" :value="__('Tarif')"
                            :required="__(true)" />

                        <div>
                            <x-text-input id="collectingMyJasaDokter.JasaDokterPrice" placeholder="Tarif"
                                class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyJasaDokter.JasaDokterPrice'))" :disabled=$disabledPropertyRjStatus
                                wire:model.debounce.500ms="collectingMyJasaDokter.JasaDokterPrice"
                                x-init="$refs.collectingMyJasaDokterJasaDokterPrice.focus()" x-ref="collectingMyJasaDokterJasaDokterPrice"
                                x-on:keyup.enter="$wire.insertJasaDokter()
                                $refs.collectingMyJasaDokterJasaDokterPrice.focus()" />

                            @error('collectingMyJasaDokter.JasaDokterPrice')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>



                    <div class="col-span-1">
                        <x-input-label for="" :value="__('Hapus')" :required="__(true)" />

                        <x-alternative-button class="inline-flex ml-2"
                            wire:click.prevent="resetcollectingMyJasaDokter()"
                            x-on:click="$refs.collectingMyJasaDokterJasaDokterDesc.focus()">
                            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path
                                    d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                            </svg>
                        </x-alternative-button>
                    </div>

                </div>
                {{-- collectingMyJasaDokter / obat --}}
            @endif



            {{-- ///////////////////////////////// --}}
            <div class="flex flex-col my-2">
                <div class="overflow-x-auto rounded-lg">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden shadow sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>

                                        <th scope="col" class="px-4 py-3 ">
                                            <x-sort-link :active=false wire:click.prevent="" role="button"
                                                href="#">
                                                Kode
                                            </x-sort-link>
                                        </th>

                                        <th scope="col" class="px-4 py-3 ">
                                            <x-sort-link :active=false wire:click.prevent="" role="button"
                                                href="#">
                                                Jasa Dokter
                                            </x-sort-link>
                                        </th>

                                        <th scope="col" class="px-4 py-3 ">
                                            <x-sort-link :active=false wire:click.prevent="" role="button"
                                                href="#">
                                                Tarif Jasa Dokter
                                            </x-sort-link>
                                        </th>


                                        <th scope="col" class="w-8 px-4 py-3 text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">

                                    @isset($dataDaftarPoliRJ['JasaDokter'])
                                        @foreach ($dataDaftarPoliRJ['JasaDokter'] as $key => $JasaDokter)
                                            <tr class="border-b group dark:border-gray-700">

                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $JasaDokter['JasaDokterId'] }}
                                                </td>

                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $JasaDokter['JasaDokterDesc'] }}
                                                </td>


                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $JasaDokter['JasaDokterPrice'] }}
                                                </td>


                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">

                                                    <x-alternative-button class="inline-flex"
                                                        wire:click.prevent="removeJasaDokter('{{ $JasaDokter['rjaccdocDtl'] }}')">
                                                        <svg class="w-5 h-5 text-gray-800 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 18 20">
                                                            <path
                                                                d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                                        </svg>
                                                        {{ 'Hapus ' . $JasaDokter['JasaDokterId'] }}
                                                    </x-alternative-button>

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
