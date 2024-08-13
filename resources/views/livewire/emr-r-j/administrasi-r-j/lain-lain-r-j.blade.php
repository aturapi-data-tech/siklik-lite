<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp

    {{-- jika anamnesa kosong ngak usah di render --}}
    {{-- @if (isset($dataDaftarPoliRJ['diagnosis'])) --}}
    <div class="w-full mb-1 ">

        <div id="TransaksiRawatJalan" class="">

            @if (!$collectingMyLainLain)
                <div>
                    <x-input-label for="dataLainLainLovSearch" :value="__('Lain Lain')" :required="__(true)" />

                    {{-- Lov dataLainLainLov --}}
                    <div x-data="{ selecteddataLainLainLovIndex: @entangle('selecteddataLainLainLovIndex') }" @click.outside="$wire.dataLainLainLovSearch = ''">
                        <x-text-input id="dataLainLainLovSearch" placeholder="Lain Lain" class="mt-1 ml-2"
                            :errorshas="__($errors->has('dataLainLainLovSearch'))" :disabled=$disabledPropertyRjStatus
                            wire:model.debounce.500ms="dataLainLainLovSearch"
                            x-on:click.outside="$wire.resetdataLainLainLov()"
                            x-on:keyup.escape="$wire.resetdataLainLainLov()"
                            x-on:keyup.down="$wire.selectNextdataLainLainLov()"
                            x-on:keyup.up="$wire.selectPreviousdataLainLainLov()"
                            x-on:keyup.enter="$wire.enterMydataLainLainLov(selecteddataLainLainLovIndex)"
                            x-ref="dataLainLainLovSearchfocus" x-init="$refs.dataLainLainLovSearchfocus.focus()
                            $watch('selecteddataLainLainLovIndex', (value, oldValue) => $refs.dataLainLainLovSearch.children[selecteddataLainLainLovIndex + 1].scrollIntoView({
                                block: 'nearest'
                            }))" />

                        {{-- Lov --}}
                        <div class="py-2 mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-64"
                            x-show="$wire.dataLainLainLovSearch.length>1 && $wire.dataLainLainLov.length>0" x-transition
                            x-ref="dataLainLainLovSearch">
                            {{-- alphine --}}
                            {{-- <template x-for="(dataLainLainLovx, index) in $wire.dataLainLainLov">
                                        <button x-text="dataLainLainLovx.other_desc"
                                            class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                            :class="{
                                                'bg-gray-100 outline-none': index === $wire
                                                    .selecteddataLainLainLovIndex
                                            }"
                                            x-on:click.prevent="$wire.setMydataLainLainLov(index)"></button>
                                    </template> --}}

                            {{-- livewire --}}
                            @foreach ($dataLainLainLov as $key => $lov)
                                <li wire:key='dataLainLainLov{{ $lov['other_desc'] }}'>
                                    <x-dropdown-link wire:click="setMydataLainLainLov('{{ $key }}')"
                                        class="text-base font-normal {{ $key === $selecteddataLainLainLovIndex ? 'bg-gray-100 outline-none' : '' }}">
                                        <div>
                                            {{ $lov['other_desc'] . '/ ' . $lov['other_price'] }}
                                        </div>
                                    </x-dropdown-link>
                                </li>
                            @endforeach

                        </div>


                        {{-- Start Lov exceptions --}}

                        @if (strlen($dataLainLainLovSearch) > 0 && strlen($dataLainLainLovSearch) < 1 && count($dataLainLainLov) == 0)
                            <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                {{ 'Masukkan minimal lebih dari 1  karakter' }}
                            </div>
                        @elseif(strlen($dataLainLainLovSearch) >= 1 && count($dataLainLainLov) == 0)
                            <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                {{ 'Data Tidak ditemukan' }}
                            </div>
                        @endif
                        {{-- End Lov exceptions --}}

                        @error('dataLainLainLovSearch')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>
                    {{-- Lov dataLainLainLov --}}
                </div>
            @endif

            @if ($collectingMyLainLain)
                {{-- collectingMyLainLain / obat --}}
                <div class="grid grid-cols-12 gap-2 " x-data>
                    <div class="col-span-1">
                        <x-input-label for="collectingMyLainLain.LainLainId" :value="__('Kode')" :required="__(true)" />

                        <div>
                            <x-text-input id="collectingMyLainLain.LainLainId" placeholder="Kode" class="mt-1 ml-2"
                                :errorshas="__($errors->has('collectingMyLainLain.LainLainId'))" :disabled=true
                                wire:model.debounce.500ms="collectingMyLainLain.LainLainId" />

                            @error('collectingMyLainLain.LainLainId')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-3">
                        <x-input-label for="collectingMyLainLain.LainLainDesc" :value="__('Lain Lain')" :required="__(true)" />

                        <div>
                            <x-text-input id="collectingMyLainLain.LainLainDesc" placeholder="Lain Lain"
                                class="mt-1 ml-2" :errorshas="__($errors->has('collectingMyLainLain.LainLainDesc'))" :disabled=true
                                wire:model.debounce.500ms="collectingMyLainLain.LainLainDesc" />

                            @error('collectingMyLainLain.LainLainDesc')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-3">
                        <x-input-label for="collectingMyLainLain.LainLainPrice" :value="__('Tarif')" :required="__(true)" />

                        <div>
                            <x-text-input id="collectingMyLainLain.LainLainPrice" placeholder="Tarif" class="mt-1 ml-2"
                                :errorshas="__($errors->has('collectingMyLainLain.LainLainPrice'))" :disabled=$disabledPropertyRjStatus
                                wire:model.debounce.500ms="collectingMyLainLain.LainLainPrice" x-init="$refs.collectingMyLainLainLainLainPrice.focus()"
                                x-ref="collectingMyLainLainLainLainPrice"
                                x-on:keyup.enter="$wire.insertLainLain()
                                $refs.collectingMyLainLainLainLainPrice.focus()" />

                            @error('collectingMyLainLain.LainLainPrice')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>



                    <div class="col-span-1">
                        <x-input-label for="" :value="__('Hapus')" :required="__(true)" />

                        <x-alternative-button class="inline-flex ml-2" wire:click.prevent="resetcollectingMyLainLain()"
                            x-on:click="$refs.collectingMyLainLainLainLainDesc.focus()">
                            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path
                                    d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                            </svg>
                        </x-alternative-button>
                    </div>

                </div>
                {{-- collectingMyLainLain / obat --}}
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
                                                Lain Lain
                                            </x-sort-link>
                                        </th>

                                        <th scope="col" class="px-4 py-3 ">
                                            <x-sort-link :active=false wire:click.prevent="" role="button"
                                                href="#">
                                                Tarif Lain Lain
                                            </x-sort-link>
                                        </th>


                                        <th scope="col" class="w-8 px-4 py-3 text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">

                                    @isset($dataDaftarPoliRJ['LainLain'])
                                        @foreach ($dataDaftarPoliRJ['LainLain'] as $key => $LainLain)
                                            <tr class="border-b group dark:border-gray-700">

                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $LainLain['LainLainId'] }}
                                                </td>

                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $LainLain['LainLainDesc'] }}
                                                </td>


                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $LainLain['LainLainPrice'] }}
                                                </td>


                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">

                                                    <x-alternative-button class="inline-flex"
                                                        wire:click.prevent="removeLainLain('{{ $LainLain['rjotherDtl'] }}')">
                                                        <svg class="w-5 h-5 text-gray-800 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 18 20">
                                                            <path
                                                                d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                                        </svg>
                                                        {{ 'Hapus ' . $LainLain['LainLainId'] }}
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
