<div>
    <div class="w-full mb-1">

        <div class="grid grid-cols-1">

            <div id="TransaksiRawatJalan" class="px-4">

                {{-- Rekonsiliasi Obat --}}
                <div>
                    <div class="grid grid-cols-4 gap-2">
                        <x-input-label for="rekonsiliasiObat.namaObat" :value="__('Nama Obat')" :required="__(true)" />
                        <x-input-label for="rekonsiliasiObat.dosis" :value="__('Dosis')" :required="__(true)" />
                        <x-input-label for="rekonsiliasiObat.rute" :value="__('Rute')" :required="__(true)" />
                        <x-input-label for="rekonsiliasiObat.rute" :value="__('Action')" :required="__(true)" />


                    </div>
                    <div class="grid grid-cols-4 gap-2">
                        <div>

                            <div class="mb-2 ">
                                <x-text-input id="rekonsiliasiObat.namaObat" placeholder="Nama Obat" class="mt-1 ml-2"
                                    :errorshas="__($errors->has('rekonsiliasiObat.namaObat'))" :disabled=$disabledPropertyRjStatus
                                    wire:model.debounce.500ms="rekonsiliasiObat.namaObat" />

                            </div>

                            @error('rekonsiliasiObat.namaObat')
                                <x-input-error :messages=$message />
                            @enderror

                        </div>

                        <div>

                            <div class="mb-2 ">
                                <x-text-input id="rekonsiliasiObat.dosis" placeholder="Dosis" class="mt-1 ml-2"
                                    :errorshas="__($errors->has('rekonsiliasiObat.dosis'))" :disabled=$disabledPropertyRjStatus
                                    wire:model.debounce.500ms="rekonsiliasiObat.dosis" />


                            </div>
                            @error('rekonsiliasiObat.dosis')
                                <x-input-error :messages=$message />
                            @enderror

                        </div>

                        <div>

                            <div class="mb-2 ">
                                <x-text-input id="rekonsiliasiObat.rute" placeholder="Rute" class="mt-1 ml-2"
                                    :errorshas="__($errors->has('rekonsiliasiObat.rute'))" :disabled=$disabledPropertyRjStatus
                                    wire:model.debounce.500ms="rekonsiliasiObat.rute" />

                            </div>

                            @error('rekonsiliasiObat.rute')
                                <x-input-error :messages=$message />
                            @enderror

                        </div>

                        <div class="grid grid-cols-1 ml-2">
                            <div wire:loading wire:target="addRekonsiliasiObat">
                                <x-loading />
                            </div>

                            <x-green-button :disabled=$disabledPropertyRjStatus
                                wire:click.prevent="addRekonsiliasiObat()" type="button" wire:loading.remove>
                                Simpan
                            </x-green-button>
                        </div>
                    </div>


                </div>

                <!-- Table -->

                <table class="w-full text-sm text-left text-gray-500 table-auto ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 ">
                        <tr>
                            <th scope="col" class="px-4 py-3">


                                <x-sort-link :active=false wire:click.prevent="" role="button" href="#">
                                    Nama Obat
                                </x-sort-link>

                            </th>

                            <th scope="col" class="px-4 py-3 ">
                                <x-sort-link :active=false wire:click.prevent="" role="button" href="#">
                                    Dosis
                                </x-sort-link>
                            </th>

                            <th scope="col" class="px-4 py-3">

                                <x-sort-link :active=false wire:click.prevent="" role="button" href="#">
                                    Rute
                                </x-sort-link>
                            </th>

                            <th scope="col" class="w-8 px-4 py-3 text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white ">

                        @isset($dataDaftarUgd['anamnesa']['rekonsiliasiObat'])
                            @foreach ($dataDaftarUgd['anamnesa']['rekonsiliasiObat'] as $key => $rekonsiliasiObat)
                                <tr class="border-b group ">

                                    <td
                                        class="w-1/4 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                        {{ $rekonsiliasiObat['namaObat'] }}
                                    </td>

                                    <td
                                        class="w-1/4 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                        {{ $rekonsiliasiObat['dosis'] }}
                                    </td>

                                    <td
                                        class="w-1/4 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                        {{ $rekonsiliasiObat['rute'] }}
                                    </td>


                                    <td
                                        class="w-1/4 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">

                                        <x-alternative-button class="inline-flex"
                                            wire:click.prevent="removeRekonsiliasiObat('{{ $rekonsiliasiObat['namaObat'] }}')">
                                            <svg class="w-5 h-5 text-gray-800" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                                <path
                                                    d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                            </svg>
                                            {{ 'Hapus ' . $rekonsiliasiObat['namaObat'] }}
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
