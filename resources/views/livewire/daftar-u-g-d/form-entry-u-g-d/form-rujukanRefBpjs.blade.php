@php
    $disabledProperty = true;

    $disabledPropertyRj = $isOpenMode === 'tampil' ? true : false;

    $disabledPropertyRjStatus = $statusRjRef['statusId'] !== 'A' ? true : false;
@endphp


<div class="fixed inset-0 z-40 ease-out duration-400">

    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

        <!-- This element is to trick the browser into transition-opacity. -->
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>



        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​

        {{-- click outsite close --}}
        <div x-data @click.outside="$wire.formRujukanRefBPJSStatus = false"
            class="inline-block overflow-auto text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:max-h-[35rem] sm:my-8 sm:align-middle sm:w-11/12"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">

            <div
                class="sticky top-0 flex items-center justify-between p-4 bg-opacity-75 border-b rounded-t bg-primary dark:border-gray-600">

                <h3 class="w-full text-2xl font-semibold text-white dark:text-white">
                    {{ 'Buat SEP UGD' }}
                </h3>




                {{-- Close Modal --}}
                <button wire:click="$set('formRujukanRefBPJSStatus',false)"
                    class="text-gray-400 bg-gray-50 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>



            </div>



            <form class="scroll-smooth hover:scroll-auto">

                <x-border-form :title="__('')" :align="__('start')" :bgcolor="__('bg-gray-50')" class="pb-4 mx-4">

                    <div class="flex">
                        <div class="flex items-center justify-end w-1/4 ">
                            <x-input-label for="regName" :value="__('Spesialis / SubSpesialis')" :required="__($errors->has('SEPJsonReq.request.t_sep.poli.tujuan'))" />
                        </div>

                        <div class="flex items-center justify-end w-full my-1 ml-2 mr-5">
                            {{ isset($SEPJsonReq['request']['t_sep']['poli']['eksekutif']) ? $SEPJsonReq['request']['t_sep']['poli']['eksekutif'] : 'Data tidak dapat di proses' }}
                            <x-check-box value='1' :label="__('Eksekutif')"
                                wire:model.debounce.500ms="SEPJsonReq.request.t_sep.poli.eksekutifRef"
                                wire:click="$set('SEPJsonReq.request.t_sep.poli.eksekutif',{{ (isset($SEPJsonReq['request']['t_sep']['poli']['eksekutif']) ? $SEPJsonReq['request']['t_sep']['poli']['eksekutif'] : '0') ? '0' : '1' }})" />


                            <x-text-input placeholder="Isi dgn data yang sesuai" class="mx-2 mt-1" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.poli.tujuan'))"
                                :disabled=$disabledProperty
                                value="{{ (isset($SEPJsonReq['request']['t_sep']['poli']['tujuan']) ? $SEPJsonReq['request']['t_sep']['poli']['tujuan'] : 'Data tidak dapat di proses') . '   ' . (isset($SEPJsonReq['request']['t_sep']['poli']['tujuanNama']) ? $SEPJsonReq['request']['t_sep']['poli']['tujuanNama'] : 'Data tidak dapat di proses') }}" />


                            @error('SEPJsonReq.request.t_sep.poli.tujuan')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>
                    <div class="">
                        <div class="flex">
                            <div class="flex items-center justify-end w-1/4 ">
                                <x-input-label for="regName" :value="__('DPJP yang melayani')" :required="__($errors->has('SEPJsonReq.request.t_sep.dpjpLayan'))" />
                            </div>

                            <div class="flex items-center justify-end w-full mr-5">
                                <x-text-input placeholder="Isi dgn data yang sesuai"
                                    class="ml-2 sm:rounded-none sm:rounded-l-lg" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.dpjpLayan'))"
                                    :disabled=$disabledProperty
                                    value="{{ (isset($SEPJsonReq['request']['t_sep']['dpjpLayan']) ? $SEPJsonReq['request']['t_sep']['dpjpLayan'] : 'Data tidak dapat di proses') . '   ' . (isset($SEPJsonReq['request']['t_sep']['kodeDPJP']['dpjpLayanNama']) ? $SEPJsonReq['request']['t_sep']['kodeDPJP']['dpjpLayanNama'] : '') }}" />

                                <x-green-button :disabled=false
                                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                    wire:click.prevent="clickdataDokterBPJSlov()">
                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </x-green-button>

                                @error('SEPJsonReq.request.t_sep.dpjpLayan')
                                    <x-input-error :messages=$message />
                                @enderror
                            </div>
                        </div>
                        {{-- LOV Dokter --}}
                        <div class="relative mt-0 bg-red-300">
                            @include('livewire.daftar-u-g-d.form-entry-u-g-d.list-of-value-caridatadokterBpjs')
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex items-center justify-end w-1/4 ">
                            <x-input-label for="regName" :value="__('Asal Rujukan')" :required="__($errors->has('SEPJsonReq.request.t_sep.rujukan.asalRujukan'))" />
                        </div>

                        <div class="flex items-center justify-end w-full mr-5">
                            <x-text-input placeholder="Isi dgn data yang sesuai" class="mx-2 mt-1" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.rujukan.asalRujukan'))"
                                :disabled=$disabledProperty
                                value="{{ (isset($SEPJsonReq['request']['t_sep']['rujukan']['asalRujukan']) ? $SEPJsonReq['request']['t_sep']['rujukan']['asalRujukan'] : 'Data tidak dapat di proses') . '   ' . (isset($SEPJsonReq['request']['t_sep']['rujukan']['asalRujukanNama']) ? $SEPJsonReq['request']['t_sep']['rujukan']['asalRujukanNama'] : 'Data tidak dapat di proses') }}" />
                            @error('SEPJsonReq.request.t_sep.rujukan.asalRujukan')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex items-center justify-end w-1/4 ">
                            <x-input-label for="regName" :value="__('PPK Asal Rujukan')" :required="__($errors->has('SEPJsonReq.request.t_sep.rujukan.ppkRujukan'))" />
                        </div>

                        <div class="flex items-center justify-end w-full mr-5">
                            <x-text-input placeholder="Isi dgn data yang sesuai" class="mx-2 mt-1" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.rujukan.ppkRujukan'))"
                                :disabled=$disabledProperty
                                value="{{ (isset($SEPJsonReq['request']['t_sep']['rujukan']['ppkRujukan']) ? $SEPJsonReq['request']['t_sep']['rujukan']['ppkRujukan'] : 'Data tidak dapat di proses') . '   ' . (isset($SEPJsonReq['request']['t_sep']['rujukan']['ppkRujukanNama']) ? $SEPJsonReq['request']['t_sep']['rujukan']['ppkRujukanNama'] : 'Data tidak dapat di proses') }}" />
                            @error('SEPJsonReq.request.t_sep.rujukan.ppkRujukan')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex items-center justify-end w-1/4 ">
                            <x-input-label for="regName" :value="__('Tanggal Rujukan')" :required="__($errors->has('SEPJsonReq.request.t_sep.rujukan.tglRujukan'))" />
                        </div>

                        <div class="flex items-center justify-end w-full mr-5">
                            <x-text-input placeholder="Isi dgn data yang sesuai" class="mx-2 mt-1" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.rujukan.tglRujukan'))"
                                :disabled=$disabledProperty
                                wire:model.debounce.500ms="SEPJsonReq.request.t_sep.rujukan.tglRujukan" />
                            @error('SEPJsonReq.request.t_sep.rujukan.tglRujukan')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="flex">
                        <div class="flex items-center justify-end w-1/4 ">
                            <x-input-label for="regName" :value="__('Nomer Rujukan')" :required="__($errors->has('SEPJsonReq.request.t_sep.rujukan.noRujukan'))" />
                        </div>

                        <div class="flex items-center justify-end w-full mr-5">
                            <x-text-input placeholder="Isi dgn data yang sesuai" class="mx-2 mt-1" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.rujukan.noRujukan'))"
                                :disabled=false
                                wire:model.debounce.500ms="SEPJsonReq.request.t_sep.rujukan.noRujukan" />
                            @error('SEPJsonReq.request.t_sep.rujukan.noRujukan')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div> --}}

                    @if ($JenisKunjungan['JenisKunjunganId'] == 3)
                        <div class="flex">
                            <div class="flex items-center justify-end w-1/4 ">
                                <x-input-label for="regName" :value="__('Nomer SKDP')" :required="__($errors->has('SEPJsonReq.request.t_sep.skdp.noSurat'))" />
                            </div>
                            <div class="flex items-center justify-end w-full mr-5">
                                <x-text-input placeholder="Isi dgn data yang sesuai" class="mx-2 mt-1"
                                    :errorshas="__($errors->has('SEPJsonReq.request.t_sep.skdp.noSurat'))" :disabled=false
                                    wire:model.debounce.500ms="SEPJsonReq.request.t_sep.skdp.noSurat" />
                                @error('SEPJsonReq.request.t_sep.skdp.noSurat')
                                    <x-input-error :messages=$message />
                                @enderror
                            </div>
                        </div>
                    @endif

                    <div class="flex">
                        <div class="flex items-center justify-end w-1/4 ">
                            <x-input-label for="regName" :value="__('Tanggal SEP')" :required="__($errors->has('SEPJsonReq.request.t_sep.tglSep'))" />
                        </div>

                        <div class="flex items-center justify-end w-full mr-5">
                            <x-text-input placeholder="Isi dgn data yang sesuai" class="mx-2 mt-1" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.tglSep'))"
                                :disabled=$disabledProperty
                                wire:model.debounce.500ms="SEPJsonReq.request.t_sep.tglSep" />
                            @error('SEPJsonReq.request.t_sep.tglSep')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex items-center justify-end w-1/4 ">
                            <x-input-label for="regName" :value="__('No MR')" :required="__($errors->has('SEPJsonReq.request.t_sep.noMR'))" />
                        </div>

                        <div class="flex items-center justify-start w-full mr-5">
                            <x-text-input placeholder="Isi dgn data yang sesuai" class="mx-2 mt-1 md:w-1/4"
                                :errorshas="__($errors->has('SEPJsonReq.request.t_sep.noMR'))" :disabled=false
                                wire:model.debounce.500ms="SEPJsonReq.request.t_sep.noMR" />
                            {{ isset($SEPJsonReq['request']['t_sep']['cob']['cob']) ? $SEPJsonReq['request']['t_sep']['cob']['cob'] : 'Data tidak dapat di proses' }}
                            <x-check-box value='1' :label="__('Peserta COB')"
                                wire:model.debounce.500ms="SEPJsonReq.request.t_sep.cob.cobRef"
                                wire:click="$set('SEPJsonReq.request.t_sep.cob.cob',{{ (isset($SEPJsonReq['request']['t_sep']['cob']['cob']) ? $SEPJsonReq['request']['t_sep']['cob']['cob'] : '0') ? '0' : '1' }})" />
                            @error('SEPJsonReq.request.t_sep.cob.cob')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="flex">
                            <div class="flex items-center justify-end w-1/4 ">
                                <x-input-label for="regName" :value="__('Diagnosa')" :required="__($errors->has('SEPJsonReq.request.t_sep.diagAwal'))" />
                            </div>

                            <div class="flex items-center justify-end w-full mr-5">
                                <x-text-input placeholder="Isi dgn data yang sesuai"
                                    class="mt-1 ml-2 sm:rounded-none sm:rounded-l-lg" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.diagAwal'))"
                                    :disabled=$disabledProperty
                                    value="{{ (isset($SEPJsonReq['request']['t_sep']['diagAwal']) ? $SEPJsonReq['request']['t_sep']['diagAwal'] : 'Data tidak dapat di proses') . '   ' . (isset($SEPJsonReq['request']['t_sep']['diagAwalNama']) ? $SEPJsonReq['request']['t_sep']['diagAwalNama'] : 'Data tidak dapat di proses') }}" />

                                <x-green-button :disabled=false
                                    class="mt-1 sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                    wire:click.prevent="clickdataDiagnosaBPJSlov()">
                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </x-green-button>
                                @error('SEPJsonReq.request.t_sep.diagAwal')
                                    <x-input-error :messages=$message />
                                @enderror
                            </div>
                        </div>
                        {{-- LOV Diagnosa --}}
                        <div class="relative mt-0 bg-red-300">
                            @include('livewire.daftar-u-g-d.form-entry-u-g-d.list-of-value-caridatadiagnosaBpjs')
                        </div>
                    </div>


                    <div class="flex">
                        <div class="flex items-center justify-end w-1/4 ">
                            <x-input-label for="regName" :value="__('Nomer Telpon')" :required="__($errors->has('SEPJsonReq.request.t_sep.noTelp'))" />
                        </div>

                        <div class="flex items-center justify-end w-full mr-5">
                            <x-text-input placeholder="Isi dgn data yang sesuai" class="mx-2 mt-1" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.noTelp'))"
                                :disabled=false wire:model.debounce.500ms="SEPJsonReq.request.t_sep.noTelp" />
                            @error('SEPJsonReq.request.t_sep.noTelp')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex items-center justify-end w-1/4 ">
                            <x-input-label for="regName" :value="__('Catatan')" :required="__($errors->has('SEPJsonReq.request.t_sep.catatan'))" />
                        </div>

                        <div class="flex items-center justify-end w-full mr-5">
                            <x-text-input placeholder="Isi dgn data yang sesuai" class="mx-2 mt-1" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.catatan'))"
                                :disabled=false wire:model.debounce.500ms="SEPJsonReq.request.t_sep.catatan" />
                            @error('SEPJsonReq.request.t_sep.catatan')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex items-center justify-end w-1/4 ">
                            <x-input-label for="regName" :value="__('Status Kecelakaan')" :required="__($errors->has('SEPJsonReq.request.t_sep.jaminan.lakaLantas'))" />
                        </div>

                        <div class="flex items-center justify-end w-full mr-5">
                            <x-text-input placeholder="Isi dgn data yang sesuai" class="mx-2 mt-1" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.jaminan.lakaLantas'))"
                                :disabled=$disabledProperty
                                wire:model.debounce.500ms="SEPJsonReq.request.t_sep.jaminan.lakaLantas" />
                            @error('SEPJsonReq.request.t_sep.jaminan.lakaLantas')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>


                    @if ($JenisKunjungan['JenisKunjunganId'] == 2 || $JenisKunjungan['JenisKunjunganId'] == 3)
                        <div class="flex pt-2">
                            <div class="flex items-center justify-end w-1/4 ">
                                <x-input-label for="regName" :value="__('tujuanKunj')" :required="__($errors->has('SEPJsonReq.request.t_sep.tujuanKunj'))" />
                            </div>

                            <x-dropdown align="right" :width="__('80')">
                                <x-slot name="trigger">
                                    {{-- Button myLimitPerPage --}}
                                    <x-alternative-button class="inline-flex w-96" wire:click.prevent="">
                                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                        ({{ (isset($SEPJsonReq['request']['t_sep']['tujuanKunj']) ? $SEPJsonReq['request']['t_sep']['tujuanKunj'] : 'Data tidak dapat di proses') . ' ' . (isset($SEPJsonReq['request']['t_sep']['tujuanKunjDesc']) ? $SEPJsonReq['request']['t_sep']['tujuanKunjDesc'] : 'Data tidak dapat diproses') }})
                                    </x-alternative-button>
                                </x-slot>
                                {{-- Open myLimitPerPagecontent --}}
                                <x-slot name="content">

                                    @foreach ($SEPQuestionnaire['tujuanKunj'] as $tujuanKunj)
                                        <x-dropdown-link
                                            wire:click="settujuanKunj('{{ $tujuanKunj['tujuanKunjId'] }}','{{ $tujuanKunj['tujuanKunjDesc'] }}')">
                                            {{ __($tujuanKunj['tujuanKunjId'] . ' ' . $tujuanKunj['tujuanKunjDesc']) }}
                                        </x-dropdown-link>
                                    @endforeach
                                </x-slot>
                            </x-dropdown>
                        </div>

                        @php
                            $myTujuanKunj = isset($SEPJsonReq['request']['t_sep']['tujuanKunj']) ? $SEPJsonReq['request']['t_sep']['tujuanKunj'] : '0';

                        @endphp

                        @if ($myTujuanKunj != '0')
                            <div class="flex">
                                <div class="flex items-center justify-end w-1/4 ">
                                    <x-input-label for="regName" :value="__('flagProcedure')" :required="__($errors->has('SEPJsonReq.request.t_sep.flagProcedure'))" />
                                </div>

                                <x-dropdown align="right" :width="__('80')">
                                    <x-slot name="trigger">
                                        {{-- Button myLimitPerPage --}}
                                        <x-alternative-button class="inline-flex w-96" wire:click.prevent="">
                                            <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                            ({{ (isset($SEPJsonReq['request']['t_sep']['flagProcedure']) ? $SEPJsonReq['request']['t_sep']['flagProcedure'] : 'Data tidak dapat di proses') . ' ' . (isset($SEPJsonReq['request']['t_sep']['flagProcedureDesc']) ? $SEPJsonReq['request']['t_sep']['flagProcedureDesc'] : 'Data tidak dapat di proses') }})
                                        </x-alternative-button>
                                    </x-slot>
                                    {{-- Open myLimitPerPagecontent --}}
                                    <x-slot name="content">

                                        @foreach ($SEPQuestionnaire['flagProcedure'] as $flagProcedure)
                                            <x-dropdown-link
                                                wire:click="setflagProcedure('{{ $flagProcedure['flagProcedureId'] }}','{{ $flagProcedure['flagProcedureDesc'] }}')">
                                                {{ __($flagProcedure['flagProcedureId'] . ' ' . $flagProcedure['flagProcedureDesc']) }}
                                            </x-dropdown-link>
                                        @endforeach
                                    </x-slot>
                                </x-dropdown>
                            </div>

                            <div class="flex">
                                <div class="flex items-center justify-end w-1/4 ">
                                    <x-input-label for="regName" :value="__('kdPenunjang')" :required="__($errors->has('SEPJsonReq.request.t_sep.kdPenunjang'))" />
                                </div>

                                <x-dropdown align="right" :width="__('80')">
                                    <x-slot name="trigger">
                                        {{-- Button myLimitPerPage --}}
                                        <x-alternative-button class="inline-flex w-96" wire:click.prevent="">
                                            <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                            ({{ (isset($SEPJsonReq['request']['t_sep']['kdPenunjang']) ? $SEPJsonReq['request']['t_sep']['kdPenunjang'] : 'Data tidak dapat diproses') . ' ' . (isset($SEPJsonReq['request']['t_sep']['kdPenunjangDesc']) ? $SEPJsonReq['request']['t_sep']['kdPenunjangDesc'] : 'Data tidak dapat di proses') }})
                                        </x-alternative-button>
                                    </x-slot>
                                    {{-- Open myLimitPerPagecontent --}}
                                    <x-slot name="content">

                                        @foreach ($SEPQuestionnaire['kdPenunjang'] as $kdPenunjang)
                                            <x-dropdown-link
                                                wire:click="setkdPenunjang('{{ $kdPenunjang['kdPenunjangId'] }}','{{ $kdPenunjang['kdPenunjangDesc'] }}')">
                                                {{ __($kdPenunjang['kdPenunjangId'] . ' ' . $kdPenunjang['kdPenunjangDesc']) }}
                                            </x-dropdown-link>
                                        @endforeach
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @endif

                        @if ($myTujuanKunj == '0' || $myTujuanKunj == '2')

                            <div class="flex">
                                <div class="flex items-center justify-end w-1/4 ">
                                    <x-input-label for="regName" :value="__('assesmentPel')" :required="__($errors->has('SEPJsonReq.request.t_sep.assesmentPel'))" />
                                </div>

                                <x-dropdown align="right" :width="__('80')">
                                    <x-slot name="trigger">
                                        {{-- Button myLimitPerPage --}}
                                        <x-alternative-button class="inline-flex w-96" wire:click.prevent="">
                                            <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                            </svg>
                                            ({{ (isset($SEPJsonReq['request']['t_sep']['assesmentPel']) ? $SEPJsonReq['request']['t_sep']['assesmentPel'] : 'Data tidak dapat di proses') . ' ' . (isset($SEPJsonReq['request']['t_sep']['assesmentPelDesc']) ? $SEPJsonReq['request']['t_sep']['assesmentPelDesc'] : 'Data tidak dapat di proses') }})
                                        </x-alternative-button>
                                    </x-slot>
                                    {{-- Open myLimitPerPagecontent --}}
                                    <x-slot name="content">

                                        @foreach ($SEPQuestionnaire['assesmentPel'] as $assesmentPel)
                                            <x-dropdown-link
                                                wire:click="setassesmentPel('{{ $assesmentPel['assesmentPelId'] }}','{{ $assesmentPel['assesmentPelDesc'] }}')">
                                                {{ __($assesmentPel['assesmentPelId'] . ' ' . $assesmentPel['assesmentPelDesc']) }}
                                            </x-dropdown-link>
                                        @endforeach
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @endif
                    @endif




                </x-border-form>




                <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6">

                    <div class="">
                        {{-- <x-primary-button :disabled=$disabledPropertyRj wire:click.prevent="callFormPasien()"
                            type="button" wire:loading.remove>
                            Master Pasien
                        </x-primary-button>
                        <div wire:loading wire:target="callFormPasien">
                            <x-loading />
                        </div> --}}
                    </div>
                    <div>
                        @if ($isOpenMode !== 'tampil')
                            <div wire:loading wire:target="storeDataSepReq">
                                <x-loading />
                            </div>


                            <x-green-button :disabled=$disabledPropertyRjStatus wire:click.prevent="storeDataSepReq()"
                                type="button" wire:loading.remove>
                                Simpan
                            </x-green-button>
                        @endif
                        <x-light-button wire:click.prevent="storeDataSepReq()" type="button">Keluar</x-light-button>
                    </div>
                </div>


            </form>

        </div>



    </div>

</div>
