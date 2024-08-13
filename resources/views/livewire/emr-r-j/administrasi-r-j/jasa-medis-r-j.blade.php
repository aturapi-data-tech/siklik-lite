<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp

    {{-- jika anamnesa kosong ngak usah di render --}}
    {{-- @if (isset($dataDaftarPoliRJ['diagnosis'])) --}}
    <div class="w-full mb-1 ">

        <div id="TransaksiRawatJalan" class="">

            @if (!$collectingMyJasaMedis)
                <div>
                    <x-input-label for="dataJasaMedisLovSearch" :value="__('Jasa Medis')" :required="__(true)" />

                    {{-- Lov dataJasaMedisLov --}}
                    <div x-data="{ selecteddataJasaMedisLovIndex: @entangle('selecteddataJasaMedisLovIndex') }" @click.outside="$wire.dataJasaMedisLovSearch = ''">
                        <x-text-input id="dataJasaMedisLovSearch" placeholder="Jasa Medis" class="mt-1 ml-2"
                            :errorshas="__($errors->has('dataJasaMedisLovSearch'))" :disabled=$disabledPropertyRjStatus
                            wire:model.debounce.500ms="dataJasaMedisLovSearch"
                            x-on:click.outside="$wire.resetdataJasaMedisLov()"
                            x-on:keyup.escape="$wire.resetdataJasaMedisLov()"
                            x-on:keyup.down="$wire.selectNextdataJasaMedisLov()"
                            x-on:keyup.up="$wire.selectPreviousdataJasaMedisLov()"
                            x-on:keyup.enter="$wire.enterMydataJasaMedisLov(selecteddataJasaMedisLovIndex)"
                            x-ref="dataJasaMedisLovSearchfocus" x-init="$refs.dataJasaMedisLovSearchfocus.focus()
                            $watch('selecteddataJasaMedisLovIndex', (value, oldValue) => $refs.dataJasaMedisLovSearch.children[selecteddataJasaMedisLovIndex + 1].scrollIntoView({
                                block: 'nearest'
                            }))" />

                        {{-- Lov --}}
                        <div class="py-2 mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-64"
                            x-show="$wire.dataJasaMedisLovSearch.length>1 && $wire.dataJasaMedisLov.length>0"
                            x-transition x-ref="dataJasaMedisLovSearch">
                            {{-- alphine --}}
                            {{-- <template x-for="(dataJasaMedisLovx, index) in $wire.dataJasaMedisLov">
                                        <button x-text="dataJasaMedisLovx.pact_desc"
                                            class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                            :class="{
                                                'bg-gray-100 outline-none': index === $wire
                                                    .selecteddataJasaMedisLovIndex
                                            }"
                                            x-on:click.prevent="$wire.setMydataJasaMedisLov(index)"></button>
                                    </template> --}}

                            {{-- livewire --}}
                            @foreach ($dataJasaMedisLov as $key => $lov)
                                <li wire:key='dataJasaMedisLov{{ $lov['pact_desc'] }}'>
                                    <x-dropdown-link wire:click="setMydataJasaMedisLov('{{ $key }}')"
                                        class="text-base font-normal {{ $key === $selecteddataJasaMedisLovIndex ? 'bg-gray-100 outline-none' : '' }}">
                                        <div>
                                            {{ $lov['pact_desc'] . '/ ' . $lov['pact_price'] }}
                                        </div>
                                    </x-dropdown-link>
                                </li>
                            @endforeach

                        </div>


                        {{-- Start Lov exceptions --}}

                        @if (strlen($dataJasaMedisLovSearch) > 0 && strlen($dataJasaMedisLovSearch) < 1 && count($dataJasaMedisLov) == 0)
                            <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                {{ 'Masukkan minimal lebih dari 1  karakter' }}
                            </div>
                        @elseif(strlen($dataJasaMedisLovSearch) >= 1 && count($dataJasaMedisLov) == 0)
                            <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                {{ 'Data Tidak ditemukan' }}
                            </div>
                        @endif
                        {{-- End Lov exceptions --}}

                        @error('dataJasaMedisLovSearch')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>
                    {{-- Lov dataJasaMedisLov --}}
                </div>
            @endif

            @if ($collectingMyJasaMedis)
                {{-- collectingMyJasaMedis / obat --}}
                <div class="grid grid-cols-12 gap-2 " x-data>
                    <div class="col-span-1">
                        <x-input-label for="collectingMyJasaMedis.JasaMedisId" :value="__('Kode')" :required="__(true)" />

                        <div>
                            <x-text-input id="collectingMyJasaMedis.JasaMedisId" placeholder="Kode" class="mt-1 ml-2"
                                :errorshas="__($errors->has('collectingMyJasaMedis.JasaMedisId'))" :disabled=true
                                wire:model.debounce.500ms="collectingMyJasaMedis.JasaMedisId" />

                            @error('collectingMyJasaMedis.JasaMedisId')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-3">
                        <x-input-label for="collectingMyJasaMedis.JasaMedisDesc" :value="__('Jasa Medis')" :required="__(true)" />

                        <div>
                            <x-text-input id="collectingMyJasaMedis.JasaMedisDesc" placeholder="Jasa Medis"
                                class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyJasaMedis.JasaMedisDesc'))" :disabled=true
                                wire:model.debounce.500ms="collectingMyJasaMedis.JasaMedisDesc" />

                            @error('collectingMyJasaMedis.JasaMedisDesc')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-3">
                        <x-input-label for="collectingMyJasaMedis.JasaMedisPrice" :value="__('Tarif')"
                            :required="__(true)" />

                        <div>
                            <x-text-input id="collectingMyJasaMedis.JasaMedisPrice" placeholder="Tarif"
                                class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyJasaMedis.JasaMedisPrice'))" :disabled=$disabledPropertyRjStatus
                                wire:model.debounce.500ms="collectingMyJasaMedis.JasaMedisPrice" x-init="$refs.collectingMyJasaMedisJasaMedisPrice.focus()"
                                x-ref="collectingMyJasaMedisJasaMedisPrice"
                                x-on:keyup.enter="$wire.insertJasaMedis()
                                $refs.collectingMyJasaMedisJasaMedisPrice.focus()" />

                            @error('collectingMyJasaMedis.JasaMedisPrice')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>



                    <div class="col-span-1">
                        <x-input-label for="" :value="__('Hapus')" :required="__(true)" />

                        <x-alternative-button class="inline-flex ml-2" wire:click.prevent="resetcollectingMyJasaMedis()"
                            x-on:click="$refs.collectingMyJasaMedisJasaMedisDesc.focus()">
                            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path
                                    d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                            </svg>
                        </x-alternative-button>
                    </div>

                </div>
                {{-- collectingMyJasaMedis / obat --}}
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
                                                Jasa Medis
                                            </x-sort-link>
                                        </th>

                                        <th scope="col" class="px-4 py-3 ">
                                            <x-sort-link :active=false wire:click.prevent="" role="button"
                                                href="#">
                                                Tarif Jasa Medis
                                            </x-sort-link>
                                        </th>


                                        <th scope="col" class="w-8 px-4 py-3 text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">

                                    @isset($dataDaftarPoliRJ['JasaMedis'])
                                        @foreach ($dataDaftarPoliRJ['JasaMedis'] as $key => $JasaMedis)
                                            <tr class="border-b group dark:border-gray-700">

                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $JasaMedis['JasaMedisId'] }}
                                                </td>

                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $JasaMedis['JasaMedisDesc'] }}
                                                </td>


                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $JasaMedis['JasaMedisPrice'] }}
                                                </td>


                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">

                                                    <x-alternative-button class="inline-flex"
                                                        wire:click.prevent="removeJasaMedis('{{ $JasaMedis['rjpactDtl'] }}')">
                                                        <svg class="w-5 h-5 text-gray-800 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 18 20">
                                                            <path
                                                                d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                                        </svg>
                                                        {{ 'Hapus ' . $JasaMedis['JasaMedisId'] }}
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
