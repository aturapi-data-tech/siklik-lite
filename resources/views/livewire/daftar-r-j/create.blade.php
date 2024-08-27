@php
    $disabledProperty = true;

    // $disabledPropertyRjStatus = $statusRjRef['statusId'] !== 'A' ? true : false;
    $disabledPropertyRjStatus = false;

@endphp


<div class="fixed inset-0 z-40 ease-out duration-400">

    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

        <!-- This element is to trick the browser into transition-opacity. -->
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>



        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>


        <div class="inline-block overflow-auto text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:max-h-[35rem] sm:my-8 sm:align-middle sm:w-11/12"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">

            <div
                class="sticky top-0 flex items-center justify-between p-4 bg-opacity-75 border-b rounded-t bg-primary dark:border-gray-600">

                <h3 class="w-full text-2xl font-semibold text-white dark:text-white">
                    {{ $myTitle }}
                </h3>

                {{-- rjDate & Shift Input Rj --}}
                <div id="shiftTanggal" class="flex justify-end w-full mr-4">
                    <div>
                        <div class="flex items-center mb-2">
                            <x-text-input id="pasporidentitas" placeholder="Tanggal [ dd/mm/yyyy hh24:mi:ss ]"
                                class="mt-1 ml-2 sm:w-[160px]" :errorshas="__($errors->has('dataDaftarPoliRJ.rjDate'))" :disabled=$disabledPropertyRjStatus
                                wire:model.debounce.500ms="dataDaftarPoliRJ.rjDate" />
                        </div>
                        @error('dataDaftarPoliRJ.rjDate')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>

                    {{-- shift Input RJ --}}
                    <div class="mt-1 ml-2">
                        <x-dropdown align="right" width="48" class="mt-1 ml-2">
                            <x-slot name="trigger">
                                {{-- Button shift --}}
                                <x-alternative-button class="inline-flex">
                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                    <span class="">{{ 'Shift' . $dataDaftarPoliRJ['shift'] }}</span>
                                </x-alternative-button>
                            </x-slot>
                            {{-- Open shiftcontent --}}
                            <x-slot name="content">

                                @foreach ($shiftRjRef['shiftOptions'] as $shift)
                                    <x-dropdown-link
                                        wire:click="setShiftRJ({{ $shift['shiftId'] }},{{ $shift['shiftDesc'] }})">
                                        {{ __($shift['shiftDesc']) }}
                                    </x-dropdown-link>
                                @endforeach
                            </x-slot>
                        </x-dropdown>

                        @error('dataDaftarPoliRJ.shift')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>



                </div>


                {{-- Close Modal --}}
                <button wire:click="closeModal()"
                    class="text-gray-400 bg-gray-50 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>



            </div>



            <form class="scroll-smooth hover:scroll-auto">
                <div class="grid grid-cols-2">






                    {{-- Pasien --}}
                    <div id="DataPasien" class="px-4 bg-white">


                        <div class="px-4 bg-white snap-mandatory snap-y">
                            <div hidden>
                                <x-check-box value='1' :label="__('Pasien Tidak Dikenal')"
                                    wire:model.debounce.500ms="dataPasien.pasien.pasientidakdikenal" />
                            </div>
                            @php
                                $pasieenTitle =
                                    'Pasien RegNo : ' .
                                    $dataPasien['pasien']['regNo'] .
                                    ' Nomer Pelayanan :' .
                                    $dataDaftarPoliRJ['noAntrian'];
                            @endphp
                            <x-border-form :title="__($pasieenTitle)" :align="__('start')" class="">
                                <div>
                                    <x-input-label for="regName" :value="__('Nama Pasien')" :required="__($ruleDataPasien['pasien']['regName'])" />
                                    <div class="flex items-center mb-2">
                                        <x-text-input placeholder="Gelar depan" class="mt-1 ml-2 sm:w-1/4"
                                            :errorshas="__($ruleDataPasien['pasien']['gelarDepan'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.gelarDepan" />
                                        <x-text-input id="regName" placeholder="Nama" class="mt-1 ml-2 sm:w-3/4"
                                            :errorshas="__($ruleDataPasien['pasien']['regName'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.regName"
                                            style="text-transform:uppercase" />

                                        <x-text-input placeholder="Gelar Belakang" class="mt-1 ml-2 sm:w-1/4"
                                            :errorshas="__($ruleDataPasien['pasien']['gelarBelakang'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.gelarBelakang" />
                                        <span> {{ ' / ' }}</span>
                                        <x-text-input placeholder="Nama Panggilan" class="mt-1 ml-2 sm:w-1/4"
                                            :errorshas="__($ruleDataPasien['pasien']['namaPanggilan'])" :disabled=$disabledProperty :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.namaPanggilan" />
                                    </div>
                                    {{-- Error Message Start --}}
                                    <div class="flex items-center mb-2">
                                        <div class="mt-1 ml-2 truncate sm:w-1/4">

                                            {{-- @error('dataPasien.pasien.gelarDepan')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="mt-1 ml-2 truncate sm:w-3/4">
                                            {{-- @error('dataPasien.pasien.regName')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="mt-1 ml-2 truncate sm:w-1/4">
                                            {{-- @error('dataPasien.pasien.gelarBelakang')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="mt-1 ml-2 truncate sm:w-1/4">
                                            {{-- @error('dataPasien.pasien.namaPanggilan')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                    </div>
                                    {{-- Error Message End --}}
                                </div>

                                <div>
                                    <x-input-label for="tempatLahir" :value="__('Tempat Tanggal Lahir')" :required="__($ruleDataPasien['pasien']['tempatLahir'])" />

                                    <div class="flex items-center mb-2">
                                        <x-text-input id="tempatLahir" placeholder="Tempat Lahir"
                                            class="mt-1 ml-2 sm:w-1/2" :errorshas="__($ruleDataPasien['pasien']['tempatLahir'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.tempatLahir"
                                            style="text-transform:uppercase" />
                                        <x-text-input placeholder="Tgl Lahir [dd/mm/yyyy]" class="mt-1 ml-2 sm:w-1/2"
                                            :errorshas="__($ruleDataPasien['pasien']['tglLahir'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.tglLahir" />

                                        <span> {{ ' / ' }}</span>
                                        <x-text-input placeholder="Umur Thn" class="mt-1 ml-2 sm:w-1/6"
                                            :errorshas="__($ruleDataPasien['pasien']['thn'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.thn" />
                                        <x-text-input placeholder="Umur Bln" class="mt-1 ml-2 sm:w-1/6"
                                            :errorshas="__($ruleDataPasien['pasien']['bln'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.bln" />
                                        <x-text-input placeholder="Umur Hari" class="mt-1 ml-2 sm:w-1/6"
                                            :errorshas="__($ruleDataPasien['pasien']['hari'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.hari" />
                                    </div>
                                    {{-- Error Message Start --}}
                                    <div class="flex items-center mb-2">
                                        <div class="mt-1 ml-2 truncate sm:w-1/2">
                                            {{-- @error('dataPasien.pasien.tempatLahir')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="mt-1 ml-2 truncate sm:w-1/2">
                                            {{-- @error('dataPasien.pasien.tglLahir')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="mt-1 ml-2 truncate sm:w-1/6">
                                            {{-- @error('dataPasien.pasien.thn')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="mt-1 ml-2 truncate sm:w-1/6">
                                            {{-- @error('dataPasien.pasien.bln')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="mt-1 ml-2 truncate sm:w-1/6">
                                            {{-- @error('dataPasien.pasien.hari')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                    </div>
                                    {{-- Error Message End --}}
                                </div>

                                <x-border-form :title="__('Sosial')" :align="__('start')" :bgcolor="__('bg-gray-50')">
                                    <div class="flex items-center">
                                        <x-input-label for="JenisKelamin" :value="__('Jenis Kelamin')" :required="__($ruleDataPasien['pasien']['jenisKelamin']['jenisKelaminId'])"
                                            class="sm:w-1/5" />
                                        <x-input-label for="Agama" :value="__('Agama')" :required="__($ruleDataPasien['pasien']['agama']['agamaId'])"
                                            class="sm:w-1/5" />
                                        <x-input-label for="SPerkawinan" :value="__('Status Perkawinan')" :required="__(
                                            $ruleDataPasien['pasien']['statusPerkawinan']['statusPerkawinanId'],
                                        )"
                                            class="sm:w-1/5" />
                                        <x-input-label for="Pendidikan" :value="__('Pendidikan')" :required="__($ruleDataPasien['pasien']['pendidikan']['pendidikanId'])"
                                            class="sm:w-1/5" />
                                        <x-input-label for="Pekerjaan" :value="__('Pekerjaan')" :required="__($ruleDataPasien['pasien']['pekerjaan']['pekerjaanId'])"
                                            class="sm:w-1/5" />
                                    </div>

                                    <div class="flex items-center mb-2">

                                        <div class="mt-1 sm:w-1/5">
                                            <div class="flex ">
                                                <x-text-input placeholder="Jenis Kelamin"
                                                    class="sm:rounded-none sm:rounded-l-lg" :errorshas="__(
                                                        $ruleDataPasien['pasien']['jenisKelamin']['jenisKelaminId'],
                                                    )"
                                                    :disabled=true
                                                    value="{{ $dataPasien['pasien']['jenisKelamin']['jenisKelaminId'] . '. ' . $dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] }}" />



                                                <x-green-button hidden :disabled=$disabledProperty
                                                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                                    wire:click.prevent="clickJeniskelaminlov()">
                                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor"
                                                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                                        aria-hidden="true">
                                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                    </svg>
                                                </x-green-button>
                                            </div>

                                        </div>

                                        <div class="mt-1 ml-2 sm:w-1/5">
                                            <div class="flex ">
                                                <x-text-input placeholder="Agama"
                                                    class="sm:rounded-none sm:rounded-l-lg" :errorshas="__($ruleDataPasien['pasien']['agama']['agamaId'])"
                                                    :disabled=true
                                                    value="{{ $dataPasien['pasien']['agama']['agamaId'] . '. ' . $dataPasien['pasien']['agama']['agamaDesc'] }}" />
                                                <x-green-button hidden :disabled=$disabledProperty
                                                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                                    wire:click.prevent="clickagamalov()">
                                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor"
                                                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                                        aria-hidden="true">
                                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                    </svg>
                                                </x-green-button>
                                            </div>

                                        </div>

                                        <div class="mt-1 ml-2 sm:w-1/5">
                                            <div class="flex ">
                                                <x-text-input placeholder="Status Perkawinan"
                                                    class="sm:rounded-none sm:rounded-l-lg" :errorshas="__(
                                                        $ruleDataPasien['pasien']['statusPerkawinan'][
                                                            'statusPerkawinanId'
                                                        ],
                                                    )"
                                                    :disabled=true
                                                    value="{{ $dataPasien['pasien']['statusPerkawinan']['statusPerkawinanId'] . '. ' . $dataPasien['pasien']['statusPerkawinan']['statusPerkawinanDesc'] }}" />
                                                <x-green-button hidden :disabled=$disabledProperty
                                                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                                    wire:click.prevent="clickstatusPerkawinanlov()">
                                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor"
                                                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                                        aria-hidden="true">
                                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                    </svg>
                                                </x-green-button>
                                            </div>

                                        </div>

                                        <div class="mt-1 ml-2 sm:w-1/5">
                                            <div class="flex ">
                                                <x-text-input placeholder="Pendidikan"
                                                    class="sm:rounded-none sm:rounded-l-lg" :errorshas="__(
                                                        $ruleDataPasien['pasien']['pendidikan']['pendidikanId'],
                                                    )"
                                                    :disabled=true
                                                    value="{{ $dataPasien['pasien']['pendidikan']['pendidikanId'] . '. ' . $dataPasien['pasien']['pendidikan']['pendidikanDesc'] }}" />
                                                <x-green-button hidden :disabled=$disabledProperty
                                                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                                    wire:click.prevent="clickpendidikanlov()">
                                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor"
                                                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                                        aria-hidden="true">
                                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                    </svg>
                                                </x-green-button>
                                            </div>

                                        </div>

                                        <div class="mt-1 ml-2 sm:w-1/5">
                                            <div class="flex ">
                                                <x-text-input placeholder="pekerjaan"
                                                    class="sm:rounded-none sm:rounded-l-lg" :errorshas="__(
                                                        $ruleDataPasien['pasien']['pekerjaan']['pekerjaanId'],
                                                    )"
                                                    :disabled=true
                                                    value="{{ $dataPasien['pasien']['pekerjaan']['pekerjaanId'] . '. ' . $dataPasien['pasien']['pekerjaan']['pekerjaanDesc'] }}" />
                                                <x-green-button hidden :disabled=$disabledProperty
                                                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                                    wire:click.prevent="clickpekerjaanlov()">
                                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor"
                                                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                                        aria-hidden="true">
                                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                    </svg>
                                                </x-green-button>
                                            </div>

                                        </div>
                                    </div>
                                    {{-- Error Message Start --}}
                                    <div class="flex items-center mb-2">
                                        <div class="mt-1 ml-2 truncate sm:w-1/5">
                                            {{-- @error('dataPasien.pasien.jenisKelamin.jenisKelaminId')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="mt-1 ml-2 truncate sm:w-1/5">
                                            {{-- @error('dataPasien.pasien.agama.agamaId')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="mt-1 ml-2 truncate sm:w-1/5">
                                            {{-- @error('dataPasien.pasien.statusPerkawinan.statusPerkawinanId')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="mt-1 ml-2 truncate sm:w-1/5">
                                            {{-- @error('dataPasien.pasien.pendidikan.pendidikanId')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="mt-1 ml-2 truncate sm:w-1/5">
                                            {{-- @error('dataPasien.pasien.pekerjaan.pekerjaanId')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                    </div>
                                    {{-- Error Message End --}}
                                </x-border-form>


                                <x-border-form :title="__('Budaya')" :align="__('start')" :bgcolor="__('bg-gray-50')">
                                    <div>
                                        <div class="flex items-center mb-2">
                                            <x-input-label for="GolonganDarah" :value="__('Golongan Darah')" :required="__(
                                                $ruleDataPasien['pasien']['golonganDarah']['golonganDarahId'],
                                            )"
                                                class="sm:w-1/5" />
                                            <x-input-label for="Kewarganegaraan" :value="__('Kewarga Negaraan')" :required="__($ruleDataPasien['pasien']['kewarganegaraan'])"
                                                class="sm:w-1/5" />
                                            <x-input-label for="Suku" :value="__('Suku')" :required="__($ruleDataPasien['pasien']['suku'])"
                                                class="sm:w-1/5" />
                                            <x-input-label for="Bahasa" :value="__('Bahasa')" :required="__($ruleDataPasien['pasien']['bahasa'])"
                                                class="sm:w-1/5" />
                                            <x-input-label for="Status" :value="__('Status')" :required="__($ruleDataPasien['pasien']['status']['statusId'])"
                                                class="sm:w-1/5" />
                                        </div>
                                        <div class="flex items-center mb-2">

                                            <div class="mt-1 ml-2 sm:w-1/5">
                                                <div class="flex ">
                                                    <x-text-input placeholder="golonganDarah"
                                                        class="sm:rounded-none sm:rounded-l-lg" :errorshas="__(
                                                            $ruleDataPasien['pasien']['golonganDarah'][
                                                                'golonganDarahId'
                                                            ],
                                                        )"
                                                        :disabled=true
                                                        value="{{ $dataPasien['pasien']['golonganDarah']['golonganDarahId'] . '. ' . $dataPasien['pasien']['golonganDarah']['golonganDarahDesc'] }}" />
                                                    <x-green-button hidden :disabled=$disabledProperty
                                                        class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                                        wire:click.prevent="clickgolonganDarahlov()">
                                                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor"
                                                            viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                                            aria-hidden="true">
                                                            <path clip-rule="evenodd" fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                        </svg>
                                                    </x-green-button>
                                                </div>

                                            </div>

                                            <x-text-input id="Kewarganegaraan" placeholder="Kewarganegaraan"
                                                class="mt-1 ml-2 sm:w-1/5" :errorshas="__($ruleDataPasien['pasien']['kewarganegaraan'])"
                                                :disabled=$disabledProperty
                                                wire:model.debounce.500ms="dataPasien.pasien.kewarganegaraan" />

                                            <x-text-input id="Suku" placeholder="Suku"
                                                class="mt-1 ml-2 sm:w-1/4" :errorshas="__($ruleDataPasien['pasien']['suku'])"
                                                :disabled=$disabledProperty
                                                wire:model.debounce.500ms="dataPasien.pasien.suku" />

                                            <x-text-input id="Bahasa" placeholder="Bahasa yang digunakan"
                                                class="mt-1 ml-2 sm:w-1/5" :errorshas="__($ruleDataPasien['pasien']['bahasa'])"
                                                :disabled=$disabledProperty
                                                wire:model.debounce.500ms="dataPasien.pasien.bahasa" />

                                            <div class="mt-1 ml-2 sm:w-1/5">
                                                <div class="flex ">
                                                    <x-text-input placeholder="status"
                                                        class="sm:rounded-none sm:rounded-l-lg" :errorshas="__($ruleDataPasien['pasien']['status']['statusId'])"
                                                        :disabled=true
                                                        value="{{ $dataPasien['pasien']['status']['statusId'] . '. ' . $dataPasien['pasien']['status']['statusDesc'] }}" />
                                                    <x-green-button hidden :disabled=$disabledProperty
                                                        class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                                        wire:click.prevent="clickstatuslov()">
                                                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor"
                                                            viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                                            aria-hidden="true">
                                                            <path clip-rule="evenodd" fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                        </svg>
                                                    </x-green-button>
                                                </div>

                                            </div>

                                        </div>
                                        {{-- Error Message Start --}}
                                        <div class="flex items-center mb-2">
                                            <div class="mt-1 ml-2 truncate sm:w-1/5">
                                                {{-- @error('dataPasien.pasien.golonganDarah.golonganDarahId')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>
                                            <div class="mt-1 ml-2 truncate sm:w-1/5">
                                                {{-- @error('dataPasien.pasien.kewarganegaraan.kewarganegaraanId')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>
                                            <div class="mt-1 ml-2 truncate sm:w-1/5">
                                                {{-- @error('dataPasien.pasien.suku')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>
                                            <div class="mt-1 ml-2 truncate sm:w-1/5">
                                                {{-- @error('dataPasien.pasien.bahasa')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>
                                            <div class="mt-1 ml-2 truncate sm:w-1/5">
                                                {{-- @error('dataPasien.pasien.status.statusId')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>
                                        </div>
                                        {{-- Error Message End --}}
                                    </div>
                                </x-border-form>
                            </x-border-form>

                            <div id="AlamatIdentitas" class="flex ">
                                <x-border-form :title="__('Identitas')" :align="__('start')" :bgcolor="__('bg-gray-50')" class="mr-2">

                                    <div class="grid grid-cols-2">
                                        {{-- grid 1 Identitas --}}
                                        <div>
                                            <div>
                                                <x-input-label for="nikidentitas" :value="__('NIK')"
                                                    :required="__($ruleDataPasien['pasien']['identitas']['nik'])" />
                                                <div class="flex items-center mb-2">
                                                    <x-text-input id="nikidentitas" placeholder="NIK"
                                                        class="mt-1 ml-2" :errorshas="__($ruleDataPasien['pasien']['identitas']['nik'])"
                                                        :disabled=$disabledProperty
                                                        wire:model.debounce.500ms="dataPasien.pasien.identitas.nik" />
                                                </div>
                                                {{-- @error('dataPasien.pasien.identitas.nik')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>
                                            <div>
                                                <x-input-label for="idBpjsidentitas" :value="__('Id BPJS')"
                                                    :required="__($ruleDataPasien['pasien']['identitas']['idbpjs'])" />
                                                <div class="flex items-center mb-2">
                                                    <x-text-input id="idBpjsidentitas" placeholder="Id BPJS [13digit]"
                                                        class="mt-1 ml-2" :errorshas="__($ruleDataPasien['pasien']['identitas']['idbpjs'])"
                                                        :disabled=$disabledProperty
                                                        wire:model.debounce.500ms="dataPasien.pasien.identitas.idbpjs" />
                                                </div>
                                                {{-- @error('dataPasien.pasien.identitas.idbpjs')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>
                                            <div>
                                                <x-input-label for="pasporidentitas" :value="__('Paspor')"
                                                    :required="__($ruleDataPasien['pasien']['identitas']['pasport'])" />
                                                <div class="flex items-center mb-2">
                                                    <x-text-input id="pasporidentitas"
                                                        placeholder="Paspor [untuk WNA / WNI]" class="mt-1 ml-2"
                                                        :errorshas="__(
                                                            $ruleDataPasien['pasien']['identitas']['pasport'],
                                                        )" :disabled=$disabledProperty
                                                        wire:model.debounce.500ms="dataPasien.pasien.identitas.pasport" />
                                                </div>
                                                {{-- @error('dataPasien.pasien.identitas.pasport')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>
                                            <div>
                                                <x-input-label for="Alamatidentitas" :value="__('Alamat')"
                                                    :required="__($ruleDataPasien['pasien']['identitas']['alamat'])" />
                                                <div class="flex items-center mb-2">
                                                    <x-text-input id="Alamatidentitas" placeholder="Alamat"
                                                        class="mt-1 ml-2" :errorshas="__($ruleDataPasien['pasien']['identitas']['alamat'])"
                                                        :disabled=$disabledProperty
                                                        wire:model.debounce.500ms="dataPasien.pasien.identitas.alamat" />
                                                </div>
                                                {{-- @error('dataPasien.pasien.identitas.alamat')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>
                                            <div>
                                                <x-input-label for="rtrwidentitas" :value="__('RT/RW')"
                                                    :required="__($ruleDataPasien['pasien']['identitas']['rt'])" />
                                                <div class="flex items-center mb-2">

                                                    <x-text-input id="rtrwidentitas" placeholder="RT [3digit]"
                                                        class="mt-1 ml-2 sm:w-1/3" :errorshas="__($errors->has('dataPasien.pasien.identitas.rt'))"
                                                        :disabled=$disabledProperty
                                                        wire:model.debounce.500ms="dataPasien.pasien.identitas.rt" />

                                                    <x-text-input placeholder="RW [3digit]" class="mt-1 ml-2 sm:w-1/3"
                                                        :errorshas="__($errors->has('dataPasien.pasien.identitas.rw'))" :disabled=$disabledProperty
                                                        wire:model.debounce.500ms="dataPasien.pasien.identitas.rw" />
                                                    <x-text-input placeholder="Kode Pos" class="mt-1 ml-2 sm:w-1/3"
                                                        :errorshas="__(
                                                            $errors->has('dataPasien.pasien.identitas.kodepos'),
                                                        )" :disabled=$disabledProperty
                                                        wire:model.debounce.500ms="dataPasien.pasien.identitas.kodepos" />
                                                </div>
                                                {{-- Error Message Start --}}
                                                <div class="flex items-center mb-2">
                                                    <div class="mt-1 ml-2 truncate sm:w-1/3">
                                                        {{-- @error('dataPasien.pasien.identitas.rt')
                                                            <x-input-error :messages=$message />
                                                        @enderror --}}
                                                    </div>
                                                    <div class="mt-1 ml-2 truncate sm:w-1/3">
                                                        {{-- @error('dataPasien.pasien.identitas.rw')
                                                            <x-input-error :messages=$message />
                                                        @enderror --}}
                                                    </div>
                                                    <div class="mt-1 ml-2 truncate sm:w-1/3">
                                                        {{-- @error('dataPasien.pasien.identitas.kodepos')
                                                            <x-input-error :messages=$message />
                                                        @enderror --}}
                                                    </div>

                                                </div>
                                                {{-- Error Message End --}}

                                                <div hidden>
                                                    <p class="text-xs font-normal text-gray-500">Jika Pasien (Tidak
                                                        dikenal)
                                                        NIK
                                                        di isi
                                                        Kosong</p>
                                                    <p class="text-xs font-normal text-gray-500">* Isi alamat sesuai
                                                        dengan
                                                        ditemukannya
                                                        pasien</p>
                                                    <br>
                                                    <p class="text-xs font-normal text-gray-500">Untuk Pasien Bayi Baru
                                                        lahir
                                                    </p>
                                                    <p class="text-xs font-normal text-gray-500">* Isi NIK dgn "NIK Ibu
                                                        bayi"
                                                        dan nama bayi
                                                        dgn format "Bayi Ny(Nama Ibu)"
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- grid 2 Identitas --}}
                                        <div>
                                            <div>
                                                <x-input-label for="Desaidentitas" :value="__('Desa')"
                                                    :required="__($ruleDataPasien['pasien']['identitas']['desaName'])" />

                                                <div class="mt-1">

                                                    <div class="flex mb-2 ml-2 ">
                                                        <x-text-input placeholder="Desa"
                                                            class="sm:rounded-none sm:rounded-l-lg" :errorshas="__(
                                                                $ruleDataPasien['pasien']['identitas']['desaName'],
                                                            )"
                                                            :disabled=true
                                                            value="{{ $dataPasien['pasien']['identitas']['desaName'] }}" />
                                                        <x-green-button hidden :disabled=$disabledProperty
                                                            class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                                            wire:click.prevent="clickdesaIdentitaslov()">
                                                            <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor"
                                                                viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                                                aria-hidden="true">
                                                                <path clip-rule="evenodd" fill-rule="evenodd"
                                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                            </svg>
                                                        </x-green-button>

                                                    </div>


                                                </div>

                                                {{-- @error('dataPasien.pasien.identitas.desaId')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>

                                            <div>
                                                <x-input-label for="Kecamatanidentitas" :value="__('Kecamatan')"
                                                    :required="__(
                                                        $ruleDataPasien['pasien']['identitas']['kecamatanId'],
                                                    )" />
                                                <div class="flex items-center mb-2">
                                                    <x-text-input id="Kecamatanidentitas" placeholder="Kecamatan"
                                                        class="mt-1 ml-2" :errorshas="__(
                                                            $ruleDataPasien['pasien']['identitas']['kecamatanId'],
                                                        )" :disabled=true
                                                        value="{{ $dataPasien['pasien']['identitas']['kecamatanName'] }}" />
                                                </div>
                                                {{-- @error('dataPasien.pasien.identitas.kecamatanId')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>

                                            <div>
                                                <x-input-label for="kotaidentitas" :value="__('kota')"
                                                    :required="__($ruleDataPasien['pasien']['identitas']['kotaId'])" />

                                                <div class="mt-1">

                                                    <div class="flex mb-2 ml-2 ">
                                                        <x-text-input placeholder="kota"
                                                            class="sm:rounded-none sm:rounded-l-lg" :errorshas="__(
                                                                $ruleDataPasien['pasien']['identitas']['kotaId'],
                                                            )"
                                                            :disabled=true
                                                            value="{{ $dataPasien['pasien']['identitas']['kotaName'] }}" />
                                                        <x-green-button hidden :disabled=$disabledProperty
                                                            class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                                            wire:click.prevent="clickkotaIdentitaslov()">
                                                            <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor"
                                                                viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                                                aria-hidden="true">
                                                                <path clip-rule="evenodd" fill-rule="evenodd"
                                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                            </svg>
                                                        </x-green-button>

                                                    </div>


                                                </div>

                                                {{-- @error('dataPasien.pasien.identitas.kotaId')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>

                                            <div>
                                                <x-input-label for="Propinsiidentitas" :value="__('Propinsi')"
                                                    :required="__($ruleDataPasien['pasien']['identitas']['propinsiId'])" />
                                                <div class="flex items-center mb-2">
                                                    <x-text-input id="Propinsiidentitas" placeholder="Propinsi"
                                                        class="mt-1 ml-2" :errorshas="__(
                                                            $ruleDataPasien['pasien']['identitas']['propinsiId'],
                                                        )" :disabled=true
                                                        value="{{ $dataPasien['pasien']['identitas']['propinsiName'] }}" />
                                                </div>
                                                {{-- @error('dataPasien.pasien.identitas.propinsiId')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>

                                            <div>
                                                <x-input-label for="negaraidentitas" :value="__('Negara')"
                                                    :required="__($ruleDataPasien['pasien']['identitas']['negara'])" />
                                                <div class="flex items-center mb-2">
                                                    <x-text-input id="negaraidentitas"
                                                        placeholder="Negara [isi dgn ID]" class="mt-1 ml-2"
                                                        :errorshas="__($ruleDataPasien['pasien']['identitas']['negara'])" :disabled=$disabledProperty
                                                        wire:model.debounce.500ms="dataPasien.pasien.identitas.negara" />
                                                </div>
                                                {{-- @error('dataPasien.pasien.identitas.negara')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>
                                        </div>
                                    </div>
                                </x-border-form>

                                <x-border-form :title="__('Alamat Domisil')" :align="__('start')" :bgcolor="__('bg-gray-50')" class=""
                                    hidden>
                                    <div class="flex justify-end mb-6">
                                        <x-check-box value='1' :label="__('Sama dgn Identitas')"
                                            wire:model.debounce.500ms="dataPasien.pasien.domisil.samadgnidentitas" />
                                    </div>

                                    <div>
                                        <x-input-label for="AlamatDomisil" :value="__('Alamat')" :required="__($ruleDataPasien['pasien']['domisil']['alamat'])" />
                                        <div class="flex items-center mb-2">
                                            <x-text-input id="AlamatDomisil" placeholder="Alamat" class="mt-1 ml-2"
                                                :errorshas="__($ruleDataPasien['pasien']['domisil']['alamat'])" :disabled=$disabledProperty
                                                wire:model.debounce.500ms="dataPasien.pasien.domisil.alamat" />
                                        </div>
                                        {{-- @error('dataPasien.pasien.domisil.alamat')
                                            <x-input-error :messages=$message />
                                        @enderror --}}
                                    </div>
                                    <div>
                                        <x-input-label for="rtrwDomisil" :value="__('RT/RW')" :required="__($ruleDataPasien['pasien']['domisil']['alamat'])" />
                                        <div class="flex items-center mb-2">
                                            <x-text-input id="rtrwDomisil" placeholder="RT [3digit]"
                                                class="mt-1 ml-2 sm:w-1/3" :errorshas="__($errors->has('dataPasien.pasien.domisil.rt'))"
                                                :disabled=$disabledProperty
                                                wire:model.debounce.500ms="dataPasien.pasien.domisil.rt" />
                                            <x-text-input placeholder="RW [3digit]" class="mt-1 ml-2 sm:w-1/3"
                                                :errorshas="__($errors->has('dataPasien.pasien.domisil.rw'))" :disabled=$disabledProperty
                                                wire:model.debounce.500ms="dataPasien.pasien.domisil.rw" />
                                            <x-text-input placeholder="Kode Pos" class="mt-1 ml-2 sm:w-1/3"
                                                :errorshas="__($errors->has('dataPasien.pasien.domisil.kodepos'))" :disabled=$disabledProperty
                                                wire:model.debounce.500ms="dataPasien.pasien.domisil.kodepos" />
                                        </div>
                                        {{-- Error Message Start --}}
                                        <div class="flex items-center mb-2">
                                            <div class="mt-1 ml-2 truncate sm:w-1/3">
                                                {{-- @error('dataPasien.pasien.domisil.rt')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>
                                            <div class="mt-1 ml-2 truncate sm:w-1/3">
                                                {{-- @error('dataPasien.pasien.domisil.rw')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>
                                            <div class="mt-1 ml-2 truncate sm:w-1/3">
                                                {{-- @error('dataPasien.pasien.domisil.kodepos')
                                                    <x-input-error :messages=$message />
                                                @enderror --}}
                                            </div>

                                        </div>
                                        {{-- Error Message End --}}
                                    </div>
                                    <div>
                                        <x-input-label for="Desadomisil" :value="__('Desa')" :required="__($ruleDataPasien['pasien']['domisil']['desaId'])" />

                                        <div class="mt-1">

                                            <div class="flex mb-2 ml-2 ">
                                                <x-text-input placeholder="Desa"
                                                    class="sm:rounded-none sm:rounded-l-lg" :errorshas="__($ruleDataPasien['pasien']['domisil']['desaId'])"
                                                    :disabled=true
                                                    value="{{ $dataPasien['pasien']['domisil']['desaName'] }}" />
                                                <x-green-button hidden :disabled=$disabledProperty
                                                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                                    wire:click.prevent="clickDesaDomisillov()">
                                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor"
                                                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                                        aria-hidden="true">
                                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                    </svg>
                                                </x-green-button>

                                            </div>


                                        </div>

                                        {{-- @error('dataPasien.pasien.domisil.desaId')
                                            <x-input-error :messages=$message />
                                        @enderror --}}
                                    </div>

                                    <div>
                                        <x-input-label for="KecamatanDomisil" :value="__('Kecamatan')"
                                            :required="__($ruleDataPasien['pasien']['domisil']['kecamatanId'])" />
                                        <div class="flex items-center mb-2">
                                            <x-text-input id="KecamatanDomisil" placeholder="Kecamatan"
                                                class="mt-1 ml-2" :errorshas="__($ruleDataPasien['pasien']['domisil']['kecamatanId'])" :disabled=true
                                                value="{{ $dataPasien['pasien']['domisil']['kecamatanName'] }}" />
                                        </div>
                                        {{-- @error('dataPasien.pasien.domisil.kecamatanId')
                                            <x-input-error :messages=$message />
                                        @enderror --}}
                                    </div>

                                    <div>
                                        <x-input-label for="kotadomisil" :value="__('kota')" :required="__($ruleDataPasien['pasien']['domisil']['kotaId'])" />

                                        <div class="mt-1">

                                            <div class="flex mb-2 ml-2 ">
                                                <x-text-input placeholder="kota"
                                                    class="sm:rounded-none sm:rounded-l-lg" :errorshas="__($ruleDataPasien['pasien']['domisil']['kotaId'])"
                                                    :disabled=true
                                                    value="{{ $dataPasien['pasien']['domisil']['kotaName'] }}" />
                                                <x-green-button hidden :disabled=$disabledProperty
                                                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                                    wire:click.prevent="clickkotaDomisillov()">
                                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor"
                                                        viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                                        aria-hidden="true">
                                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                    </svg>
                                                </x-green-button>

                                            </div>


                                        </div>

                                        {{-- @error('dataPasien.pasien.domisil.kotaId')
                                            <x-input-error :messages=$message />
                                        @enderror --}}
                                    </div>

                                    <div>
                                        <x-input-label for="Propinsidomisil" :value="__('Propinsi')" :required="__($ruleDataPasien['pasien']['domisil']['propinsiId'])" />
                                        <div class="flex items-center mb-2">
                                            <x-text-input id="Propinsidomisil" placeholder="Propinsi"
                                                class="mt-1 ml-2" :errorshas="__($ruleDataPasien['pasien']['domisil']['propinsiId'])" :disabled=true
                                                value="{{ $dataPasien['pasien']['domisil']['propinsiName'] }}" />
                                        </div>
                                        {{-- @error('dataPasien.pasien.domisil.propinsiId')
                                            <x-input-error :messages=$message />
                                        @enderror --}}
                                    </div>

                                    <div>
                                        <x-input-label for="negaraidentitas" :value="__('Negara')" :required="__($ruleDataPasien['pasien']['identitas']['negara'])" />
                                        <div class="flex items-center mb-2">
                                            <x-text-input id="negaraidentitas" placeholder="Negara [isi dgn ID]"
                                                class="mt-1 ml-2" :errorshas="__($ruleDataPasien['pasien']['identitas']['negara'])" :disabled=$disabledProperty
                                                wire:model.debounce.500ms="dataPasien.pasien.identitas.negara" />
                                        </div>
                                        {{-- @error('dataPasien.pasien.identitas.negara')
                                            <x-input-error :messages=$message />
                                        @enderror --}}
                                    </div>

                                </x-border-form>

                            </div>

                            <x-border-form :title="__('Kontak')" :align="__('start')" :bgcolor="__('bg-gray-50')" class="">
                                <div>
                                    <x-input-label for="nohpPasien" :value="__('No HP Pasien')" :required="__($ruleDataPasien['pasien']['kontak']['kodenegara'])" />
                                    <div class="flex items-center mb-2">
                                        <x-text-input placeholder="No HP" class="mt-1 ml-2 sm:w-16"
                                            :errorshas="__($ruleDataPasien['pasien']['kontak']['kodenegara'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.kontak.kodenegara" />
                                        <x-text-input id="nohpPasien" placeholder="No HP" class="mt-1 ml-2 "
                                            :errorshas="__(
                                                $ruleDataPasien['pasien']['kontak']['nomerTelponSelulerPasien'],
                                            )" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.kontak.nomerTelponSelulerPasien" />
                                    </div>
                                    {{-- @error('dataPasien.pasien.kontak.nomerTelponSelulerPasien')
                                        <x-input-error :messages=$message />
                                    @enderror --}}

                                    <x-input-label for="nohpTelponLain" :value="__('No Lain')" :required="__($ruleDataPasien['pasien']['kontak']['kodenegara'])" />
                                    <div class="flex items-center mb-2">
                                        <x-text-input placeholder="No HP" class="mt-1 ml-2 sm:w-16"
                                            :errorshas="__($ruleDataPasien['pasien']['kontak']['kodenegara'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.kontak.kodenegara" />
                                        <x-text-input id="nohpTelponLain" placeholder="No HP" class="mt-1 ml-2 "
                                            :errorshas="__($ruleDataPasien['pasien']['kontak']['nomerTelponLain'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.kontak.nomerTelponLain" />
                                    </div>
                                    {{-- @error('dataPasien.pasien.kontak.nomerTelponLain')
                                        <x-input-error :messages=$message />
                                    @enderror --}}
                                </div>
                            </x-border-form>

                            <x-border-form :title="__('Hubungan')" :align="__('start')" :bgcolor="__('bg-gray-50')" class="">

                                <x-border-form :title="__('Penanggung Jawab')" :align="__('start')" :bgcolor="__('bg-yellow-100')">
                                    {{-- PenanggungJawab --}}
                                    <x-input-label for="PenanggungJawab" :value="__('Penanggung Jawab')" :required="__($ruleDataPasien['pasien']['hubungan']['namaPenanggungJawab'])" />
                                    {{-- nomerTelponSelulerPenanggungJawab --}}
                                    <div class="flex items-center mb-2">
                                        <x-text-input id="PenanggungJawab" placeholder="Nama Penanggung Jawab"
                                            class="mt-1 ml-2" :errorshas="__($ruleDataPasien['pasien']['hubungan']['namaPenanggungJawab'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.hubungan.namaPenanggungJawab"
                                            style="text-transform:uppercase" />
                                        <x-text-input placeholder="No HP" class="mt-1 ml-2 sm:w-16"
                                            :errorshas="__(
                                                $ruleDataPasien['pasien']['hubungan']['kodenegaraPenanggungJawab'],
                                            )" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.hubungan.kodenegaraPenanggungJawab" />
                                        <x-text-input id="nohpTelponLain" placeholder="No HP" class="mt-1 ml-2 "
                                            :errorshas="__(
                                                $ruleDataPasien['pasien']['hubungan'][
                                                    'nomerTelponSelulerPenanggungJawab'
                                                ],
                                            )" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.hubungan.nomerTelponSelulerPenanggungJawab" />
                                    </div>
                                    {{-- Error Message Start --}}
                                    <div class="flex items-center mb-2">
                                        <div class="w-full mt-1 ml-2 truncate">
                                            {{-- @error('dataPasien.pasien.hubungan.namaPenanggungJawab')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="w-16 mt-1 ml-2 truncate">
                                            {{-- @error('dataPasien.pasien.domisil.rw')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="w-full mt-1 ml-2 truncate">
                                            {{-- @error('dataPasien.pasien.hubungan.nomerTelponSelulerPenanggungJawab')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>

                                    </div>
                                    {{-- Error Message End --}}


                                    {{-- HungungandgnPHubasien --}}
                                    <x-input-label for="HungungandgnPasien" :value="__('Hungungan dgn Pasien')" :required="__(
                                        $ruleDataPasien['pasien']['hubungan']['hubunganDgnPasien'][
                                            'hubunganDgnPasienId'
                                        ],
                                    )" />

                                    <div class="mt-1 mb-2 sm:w-1/2">
                                        <div class="flex ">
                                            <x-text-input placeholder="hubunganDgnPasien"
                                                class="sm:rounded-none sm:rounded-l-lg" :errorshas="__(
                                                    $ruleDataPasien['pasien']['hubungan']['hubunganDgnPasien'][
                                                        'hubunganDgnPasienId'
                                                    ],
                                                )"
                                                :disabled=true
                                                value="{{ $dataPasien['pasien']['hubungan']['hubunganDgnPasien']['hubunganDgnPasienId'] . '. ' . $dataPasien['pasien']['hubungan']['hubunganDgnPasien']['hubunganDgnPasienDesc'] }}" />
                                            <x-green-button hidden :disabled=$disabledProperty
                                                class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                                wire:click.prevent="clickhubunganDgnPasienlov()">
                                                <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor"
                                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                                    aria-hidden="true">
                                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                </svg>
                                            </x-green-button>
                                        </div>

                                    </div>

                                    {{-- @error('dataPasien.pasien.hubungan.hubunganDgnPasienId')
                                        <x-input-error :messages=$message />
                                    @enderror --}}
                                </x-border-form>

                                <div>
                                    {{-- Ayah --}}
                                    <x-input-label for="Ayah" :value="__('Nama Ayah')" :required="__($ruleDataPasien['pasien']['hubungan']['namaAyah'])" />
                                    {{-- nomerTelponSelulerAyah --}}
                                    <div class="flex items-center mb-2">
                                        <x-text-input id="Ayah" placeholder="Nama Ayah" class="mt-1 ml-2"
                                            :errorshas="__($ruleDataPasien['pasien']['hubungan']['namaAyah'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.hubungan.namaAyah"
                                            style="text-transform:uppercase" />
                                        <x-text-input placeholder="No HP" class="mt-1 ml-2 sm:w-16"
                                            :errorshas="__($ruleDataPasien['pasien']['hubungan']['kodenegaraAyah'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.hubungan.kodenegaraAyah" />
                                        <x-text-input id="nohpTelponLain" placeholder="No HP" class="mt-1 ml-2 "
                                            :errorshas="__(
                                                $ruleDataPasien['pasien']['hubungan']['nomerTelponSelulerAyah'],
                                            )" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.hubungan.nomerTelponSelulerAyah" />
                                    </div>
                                    {{-- Error Message Start --}}
                                    <div class="flex items-center mb-2">
                                        <div class="w-full mt-1 ml-2 truncate">
                                            {{-- @error('dataPasien.pasien.hubungan.namaAyah')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="w-16 mt-1 ml-2 truncate">
                                            {{-- @error('dataPasien.pasien.domisil.rw')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="w-full mt-1 ml-2 truncate">
                                            {{-- @error('dataPasien.pasien.hubungan.nomerTelponSelulerAyah')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>

                                    </div>
                                    {{-- Error Message End --}}
                                </div>

                                <div>
                                    {{-- Ibu --}}
                                    <x-input-label for="Ibu" :value="__('Nama Ibu')" :required="__($ruleDataPasien['pasien']['hubungan']['namaIbu'])" />
                                    {{-- nomerTelponSelulerIbu --}}
                                    <div class="flex items-center mb-2">
                                        <x-text-input id="Ibu" placeholder="Nama Ibu" class="mt-1 ml-2"
                                            :errorshas="__($ruleDataPasien['pasien']['hubungan']['namaIbu'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.hubungan.namaIbu" />
                                        <x-text-input placeholder="No HP" class="mt-1 ml-2 sm:w-16"
                                            :errorshas="__($ruleDataPasien['pasien']['hubungan']['kodenegaraIbu'])" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.hubungan.kodenegaraIbu"
                                            style="text-transform:uppercase" />
                                        <x-text-input id="nohpTelponLain" placeholder="No HP" class="mt-1 ml-2 "
                                            :errorshas="__(
                                                $ruleDataPasien['pasien']['hubungan']['nomerTelponSelulerIbu'],
                                            )" :disabled=$disabledProperty
                                            wire:model.debounce.500ms="dataPasien.pasien.hubungan.nomerTelponSelulerIbu" />
                                    </div>
                                    {{-- Error Message Start --}}
                                    <div class="flex items-center mb-2">
                                        <div class="w-full mt-1 ml-2 truncate">
                                            {{-- @error('dataPasien.pasien.hubungan.namaIbu')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="w-16 mt-1 ml-2 truncate">
                                            {{-- @error('dataPasien.pasien.domisil.rw')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>
                                        <div class="w-full mt-1 ml-2 truncate">
                                            {{-- @error('dataPasien.pasien.hubungan.nomerTelponSelulerIbu')
                                                <x-input-error :messages=$message />
                                            @enderror --}}
                                        </div>

                                    </div>
                                    {{-- Error Message End --}}
                                </div>
                            </x-border-form>

                        </div>



                    </div>



                    {{-- Transasi Rawat Jalan --}}
                    <div id="TransaksiRawatJalan" class="px-4">
                        <x-border-form :title="__('Pendaftaran Rawat Jalan')" :align="__('start')" :bgcolor="__('bg-white')" class="mr-0">


                            <div>
                                <div class="flex justify-end -mb-4">
                                    <x-check-box value='N' :label="__('Pasien Baru')"
                                        wire:model.debounce.500ms="dataDaftarPoliRJ.passStatus" />
                                </div>

                                <x-input-label for="dataPasienLovSearch" :value="__('Cari Data Pasien dgn [ Nama / Reg No / NIK / Noka BPJS]')" :required="__(true)" />

                                <div class="flex items-center mb-2">
                                    <x-text-input id="dataPasienLovSearch"
                                        placeholder="Cari Data Pasien dgn [ Nama / Reg No / NIK / Noka BPJS]"
                                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.regNo'))" :disabled=$disabledPropertyRjStatus
                                        wire:model.debounce.500ms="dataPasienLovSearch" />

                                </div>
                                @error('dataDaftarPoliRJ.regNo')
                                    <x-input-error :messages=$message />
                                @enderror

                                {{-- @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach --}}

                                <div wire:loading wire:target="dataPasienLovSearch">
                                    <x-loading />
                                </div>
                                {{-- LOV Pasien --}}
                                <div class="mt-2">
                                    @include('livewire.daftar-r-j.list-of-value-caridatapasien')
                                </div>


                            </div>

                            <div>
                                <x-input-label :value="__('Jenis Klaim')" :required="__(true)" />
                                <div class="grid grid-cols-4 my-2">

                                    @foreach ($JenisKlaim['JenisKlaimOptions'] as $sRj)
                                        {{-- @dd($sRj) --}}
                                        <x-radio-button :label="__($sRj['JenisKlaimDesc'])" value="{{ $sRj['JenisKlaimId'] }}"
                                            wire:model="JenisKlaim.JenisKlaimId" />
                                    @endforeach

                                </div>
                                @error('JenisKlaim.JenisKlaimId')
                                    <x-input-error :messages=$message />
                                @enderror
                            </div>

                            <div>
                                <x-input-label :value="__('Jenis Kunjungan')" :required="__(true)" />
                                <div class="grid grid-cols-4 my-2">

                                    @foreach ($JenisKunjungan['JenisKunjunganOptions'] as $sRj)
                                        {{-- @dd($sRj) --}}
                                        <x-radio-button :label="__($sRj['JenisKunjunganDesc'])" value="{{ $sRj['JenisKunjunganId'] }}"
                                            wire:model="JenisKunjungan.JenisKunjunganId" />
                                    @endforeach

                                </div>
                                @error('JenisKunjungan.JenisKunjunganId')
                                    <x-input-error :messages=$message />
                                @enderror
                            </div>

                            <div>
                                @if ($JenisKunjungan['JenisKunjunganId'] === '3')
                                    <x-check-box value='1' :label="__('Post Inap')"
                                        wire:model="dataDaftarPoliRJ.postInap" />
                                @endif
                                <div class="grid grid-cols-2 mt-2">
                                    @if ($JenisKunjungan['JenisKunjunganId'] === '3' && !$dataDaftarPoliRJ['postInap'])
                                        @foreach ($dataDaftarPoliRJ['kontrol12Options'] as $kontrol12)
                                            {{-- @dd($sRj) --}}
                                            <x-radio-button :label="__($kontrol12['kontrol12Desc'])" value="{{ $kontrol12['kontrol12'] }}"
                                                wire:model="dataDaftarPoliRJ.kontrol12" />
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-2">
                                @if ($JenisKunjungan['JenisKunjunganId'] === '2')
                                    @foreach ($dataDaftarPoliRJ['internal12Options'] as $internal12)
                                        {{-- @dd($sRj) --}}
                                        <x-radio-button :label="__($internal12['internal12Desc'])" value="{{ $internal12['internal12'] }}"
                                            wire:model="dataDaftarPoliRJ.internal12" />
                                    @endforeach
                                @endif
                            </div>

                            <div>
                                <x-input-label :value="__('No Referensi')" :required="__(true)" />
                                <div class="flex items-center mb-2">
                                    <x-text-input placeholder="No Referensi" class="mt-1" :errorshas="__($errors->has('dataDaftarPoliRJ.noReferensi'))"
                                        :disabled=$disabledPropertyRjStatus
                                        wire:model.debounce.500ms="dataDaftarPoliRJ.noReferensi"
                                        wire:loading.attr="disabled" />
                                </div>

                                {{-- LOV --}}
                                <div class="mt-2">
                                    @include('livewire.daftar-r-j.list-of-value-rujukanRefBpjs')
                                </div>

                                <div>
                                    <div class="flex justify-between">
                                        <x-green-button :disabled=$disabledPropertyRjStatus
                                            wire:click.prevent="clickrujukanPeserta()" type="button"
                                            wire:loading.remove>No Referensi
                                        </x-green-button>

                                        <div wire:loading wire:target="clickrujukanPeserta">
                                            <x-loading />
                                        </div>

                                        <div class="">
                                            <x-primary-button :disabled=false wire:click.prevent="callRJskdp()"
                                                type="button" wire:loading.remove>Buat SKDP</x-primary-button>
                                            <div wire:loading wire:target="callRJskdp">
                                                <x-loading />
                                            </div>
                                        </div>

                                    </div>

                                    <p class="text-xs">di isi dgn : (No Rujukan untun FKTP /FKTL) (SKDP untuk
                                        Kontrol / Rujukan Internal)
                                    </p>
                                </div>





                            </div>


                            <div>
                                <x-input-label :value="__('Dokter')" :required="__(true)" />
                                <div class="mt-1 ml-2 ">
                                    <div class="flex ">
                                        <x-text-input placeholder="Dokter" class="sm:rounded-none sm:rounded-l-lg"
                                            :errorshas="__($errors->has('dataDaftarPoliRJ.drId'))" :disabled=true
                                            value="{{ $dataDaftarPoliRJ['drId'] . ' ' . $dataDaftarPoliRJ['drDesc'] }}" />
                                        <x-green-button :disabled=$disabledPropertyRjStatus
                                            class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                            wire:click.prevent="clickdataDokterlov()">
                                            <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                        </x-green-button>
                                    </div>

                                    {{-- <div wire:loading wire:target="dataDokterLovSearch">
                                        <x-loading />
                                    </div> --}}
                                    {{-- LOV Dokter --}}
                                    <div class="mt-2">
                                        @include('livewire.daftar-r-j.list-of-value-caridatadokter')
                                    </div>

                                </div>
                                @error('dataDaftarPoliRJ.drId')
                                    <x-input-error :messages=$message />
                                @enderror
                            </div>

                            <div>
                                <x-input-label :value="__('Poli')" :required="__(true)" />
                                <div class="flex items-center mb-2">
                                    <x-text-input placeholder="Poli" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.poliId'))"
                                        :disabled=$disabledProperty
                                        value="{{ $dataDaftarPoliRJ['poliId'] }}{{ isset($dataDaftarPoliRJ['poliDesc']) ? $dataDaftarPoliRJ['poliDesc'] : '' }}" />
                                </div>
                                @error('dataDaftarPoliRJ.poliId')
                                    <x-input-error :messages=$message />
                                @enderror
                            </div>

                            <div>
                                <x-input-label :value="__('NoSep')" :required="__(false)" />
                                <div class="flex items-center mb-2">
                                    <x-text-input placeholder="NoSep" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.sep.noSep'))"
                                        :disabled=$disabledPropertyRjStatus
                                        value="{{ isset($dataDaftarPoliRJ['sep']['noSep']) ? $dataDaftarPoliRJ['sep']['noSep'] : '-' }}" />
                                </div>

                                <div class="flex items-center justify-end mb-2">
                                    @php
                                        $dataPasienRegNo = $dataPasien['pasien']['regNo']
                                            ? $dataPasien['pasien']['regNo']
                                            : '110750Z';
                                    @endphp

                                    <livewire:cetak.cetak-etiket :regNo="$dataPasienRegNo" :wire:key="$dataPasienRegNo">

                                        <x-yellow-button wire:click.prevent="cetakSEP()" type="button"
                                            wire:loading.remove>
                                            Cetak SEP
                                        </x-yellow-button>
                                        <div wire:loading wire:target="cetakSEP">
                                            <x-loading />
                                        </div>
                                </div>


                                @error('dataDaftarPoliRJ.sep.noSep')
                                    <x-input-error :messages=$message />
                                @enderror
                            </div>




                        </x-border-form>
                    </div>



                </div>

                <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6">

                    <div class="">
                        <x-primary-button :disabled=$disabledPropertyRjStatus wire:click.prevent="callFormPasien()"
                            type="button" wire:loading.remove>
                            Master Pasien
                        </x-primary-button>
                        <div wire:loading wire:target="callFormPasien">
                            <x-loading />
                        </div>
                    </div>
                    <div>
                        @if ($isOpenMode !== 'tampil')
                            <div wire:loading wire:target="store">
                                <x-loading />
                            </div>

                            <x-green-button :disabled=$disabledPropertyRjStatus wire:click.prevent="store()"
                                type="button" wire:loading.remove>
                                Simpan
                            </x-green-button>
                        @endif
                        <x-light-button wire:click="closeModal()" type="button">Keluar</x-light-button>
                    </div>
                </div>


            </form>

        </div>



    </div>

</div>
