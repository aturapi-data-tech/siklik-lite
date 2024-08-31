<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp

    {{-- jika anamnesa kosong ngak usah di render --}}
    {{-- @if (isset($dataDaftarPoliRJ['diagnosis'])) --}}
    <div class="w-full mb-1 ">

        <div id="TransaksiRawatJalan" class="">

            @if (!$collectingMyJasaKaryawan)
                <div>
                    <x-input-label for="dataJasaKaryawanLovSearch" :value="__('Jasa Karyawan')" :required="__(true)" />

                    {{-- Lov dataJasaKaryawanLov --}}
                    <div x-data="{ selecteddataJasaKaryawanLovIndex: @entangle('selecteddataJasaKaryawanLovIndex') }" @click.outside="$wire.dataJasaKaryawanLovSearch = ''">
                        <x-text-input id="dataJasaKaryawanLovSearch" placeholder="Jasa Karyawan" class="mt-1 ml-2"
                            :errorshas="__($errors->has('dataJasaKaryawanLovSearch'))" :disabled=$disabledPropertyRjStatus
                            wire:model.debounce.500ms="dataJasaKaryawanLovSearch"
                            x-on:click.outside="$wire.resetdataJasaKaryawanLov()"
                            x-on:keyup.escape="$wire.resetdataJasaKaryawanLov()"
                            x-on:keyup.down="$wire.selectNextdataJasaKaryawanLov()"
                            x-on:keyup.up="$wire.selectPreviousdataJasaKaryawanLov()"
                            x-on:keyup.enter="$wire.enterMydataJasaKaryawanLov(selecteddataJasaKaryawanLovIndex)"
                            x-ref="dataJasaKaryawanLovSearchfocus" x-init="$refs.dataJasaKaryawanLovSearchfocus.focus()
                            $watch('selecteddataJasaKaryawanLovIndex', (value, oldValue) => $refs.dataJasaKaryawanLovSearch.children[selecteddataJasaKaryawanLovIndex + 1].scrollIntoView({
                                block: 'nearest'
                            }))" />

                        {{-- Lov --}}
                        <div class="py-2 mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-64"
                            x-show="$wire.dataJasaKaryawanLovSearch.length>1 && $wire.dataJasaKaryawanLov.length>0"
                            x-transition x-ref="dataJasaKaryawanLovSearch">
                            {{-- alphine --}}
                            {{-- <template x-for="(dataJasaKaryawanLovx, index) in $wire.dataJasaKaryawanLov">
                                        <button x-text="dataJasaKaryawanLovx.acte_desc"
                                            class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                            :class="{
                                                'bg-gray-100 outline-none': index === $wire
                                                    .selecteddataJasaKaryawanLovIndex
                                            }"
                                            x-on:click.prevent="$wire.setMydataJasaKaryawanLov(index)"></button>
                                    </template> --}}

                            {{-- livewire --}}
                            @foreach ($dataJasaKaryawanLov as $key => $lov)
                                <li wire:key='dataJasaKaryawanLov{{ $lov['acte_desc'] }}'>
                                    <x-dropdown-link wire:click="setMydataJasaKaryawanLov('{{ $key }}')"
                                        class="text-base font-normal {{ $key === $selecteddataJasaKaryawanLovIndex ? 'bg-gray-100 outline-none' : '' }}">
                                        <div>
                                            {{ $lov['acte_desc'] . '/ ' . $lov['acte_price'] }}
                                        </div>
                                    </x-dropdown-link>
                                </li>
                            @endforeach

                        </div>


                        {{-- Start Lov exceptions --}}

                        @if (strlen($dataJasaKaryawanLovSearch) > 0 &&
                                strlen($dataJasaKaryawanLovSearch) < 1 &&
                                count($dataJasaKaryawanLov) == 0)
                            <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                {{ 'Masukkan minimal lebih dari 1  karakter' }}
                            </div>
                        @elseif(strlen($dataJasaKaryawanLovSearch) >= 1 && count($dataJasaKaryawanLov) == 0)
                            <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                {{ 'Data Tidak ditemukan' }}
                            </div>
                        @endif
                        {{-- End Lov exceptions --}}

                        @error('dataJasaKaryawanLovSearch')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>
                    {{-- Lov dataJasaKaryawanLov --}}
                </div>
            @endif

            @if ($collectingMyJasaKaryawan)
                {{-- collectingMyJasaKaryawan / obat --}}
                <div class="grid grid-cols-12 gap-2 " x-data>
                    <div class="col-span-1">
                        <x-input-label for="collectingMyJasaKaryawan.JasaKaryawanId" :value="__('Kode')"
                            :required="__(true)" />

                        <div>
                            <x-text-input id="collectingMyJasaKaryawan.JasaKaryawanId" placeholder="Kode"
                                class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyJasaKaryawan.JasaKaryawanId'))" :disabled=true
                                wire:model.debounce.500ms="collectingMyJasaKaryawan.JasaKaryawanId" />

                            @error('collectingMyJasaKaryawan.JasaKaryawanId')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-3">
                        <x-input-label for="collectingMyJasaKaryawan.JasaKaryawanDesc" :value="__('Jasa Karyawan')"
                            :required="__(true)" />

                        <div>
                            <x-text-input id="collectingMyJasaKaryawan.JasaKaryawanDesc" placeholder="Jasa Karyawan"
                                class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyJasaKaryawan.JasaKaryawanDesc'))" :disabled=true
                                wire:model.debounce.500ms="collectingMyJasaKaryawan.JasaKaryawanDesc" />

                            @error('collectingMyJasaKaryawan.JasaKaryawanDesc')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-3">
                        <x-input-label for="collectingMyJasaKaryawan.JasaKaryawanPrice" :value="__('Tarif')"
                            :required="__(true)" />

                        <div>
                            <x-text-input id="collectingMyJasaKaryawan.JasaKaryawanPrice" placeholder="Tarif"
                                class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyJasaKaryawan.JasaKaryawanPrice'))" :disabled=$disabledPropertyRjStatus
                                wire:model.debounce.500ms="collectingMyJasaKaryawan.JasaKaryawanPrice"
                                x-init="$refs.collectingMyJasaKaryawanJasaKaryawanPrice.focus()" x-ref="collectingMyJasaKaryawanJasaKaryawanPrice"
                                x-on:keyup.enter="$wire.insertJasaKaryawan()
                                $refs.collectingMyJasaKaryawanJasaKaryawanPrice.focus()" />

                            @error('collectingMyJasaKaryawan.JasaKaryawanPrice')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>



                    <div class="col-span-1">
                        <x-input-label for="" :value="__('Hapus')" :required="__(true)" />

                        <x-alternative-button class="inline-flex ml-2"
                            wire:click.prevent="resetcollectingMyJasaKaryawan()"
                            x-on:click="$refs.collectingMyJasaKaryawanJasaKaryawanDesc.focus()">
                            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path
                                    d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                            </svg>
                        </x-alternative-button>
                    </div>

                </div>
                {{-- collectingMyJasaKaryawan / obat --}}
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
                                                Jasa Karyawan
                                            </x-sort-link>
                                        </th>

                                        <th scope="col" class="px-4 py-3 ">
                                            <x-sort-link :active=false wire:click.prevent="" role="button"
                                                href="#">
                                                Tarif Jasa Karyawan
                                            </x-sort-link>
                                        </th>


                                        <th scope="col" class="w-8 px-4 py-3 text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">

                                    @isset($dataDaftarPoliRJ['JasaKaryawan'])
                                        @foreach ($dataDaftarPoliRJ['JasaKaryawan'] as $key => $JasaKaryawan)
                                            <tr class="border-b group dark:border-gray-700">

                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $JasaKaryawan['JasaKaryawanId'] }}
                                                </td>

                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $JasaKaryawan['JasaKaryawanDesc'] }}
                                                </td>


                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $JasaKaryawan['JasaKaryawanPrice'] }}
                                                </td>


                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">

                                                    <x-alternative-button class="inline-flex"
                                                        wire:click.prevent="removeJasaKaryawan('{{ $JasaKaryawan['rjActeDtl'] }}')">
                                                        <svg class="w-5 h-5 text-gray-800 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 18 20">
                                                            <path
                                                                d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                                        </svg>
                                                        {{ 'Hapus ' . $JasaKaryawan['JasaKaryawanId'] }}
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
