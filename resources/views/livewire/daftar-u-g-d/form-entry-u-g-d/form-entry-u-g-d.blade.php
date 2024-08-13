@php
    $disabledProperty = true;
    $disabledPropertyRjStatus = $statusRjRef['statusId'] !== 'A' ? true : false;

    // $disabledPropertyRjStatus = $statusRjRef['statusId'] !== 'A' ? true : false;

@endphp

<div>
    {{-- Stop trying to control. --}}
    @if ($formRujukanRefBPJSStatus)
        @include('livewire.daftar-u-g-d.form-entry-u-g-d.form-rujukanRefBpjs')
    @endif

    {{-- Transasi Rawat Jalan --}}
    <div id="TransaksiRawatJalan" class="px-4">
        <x-border-form :title="__('Pendaftaran UGD')" :align="__('start')" :bgcolor="__('bg-white')" class="mr-0">

            {{-- rjDate & Shift Input Rj --}}
            <div id="shiftTanggal" class="flex justify-end w-full mr-4">
                <div>
                    <div class="flex items-center mb-2">
                        <x-text-input id="pasporidentitas" placeholder="Tanggal [ dd/mm/yyyy hh24:mi:ss ]"
                            class="mt-1 ml-2 sm:w-[160px]" :errorshas="__($errors->has('dataDaftarUgd.rjDate'))" :disabled=$disabledPropertyRjStatus
                            wire:model.debounce.500ms="dataDaftarUgd.rjDate" />
                    </div>
                    @error('dataDaftarUgd.rjDate')
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
                                <span class="">{{ 'Shift' . $dataDaftarUgd['shift'] }}</span>
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

                    @error('dataDaftarUgd.shift')
                        <x-input-error :messages=$message />
                    @enderror
                </div>



            </div>


            <div>
                <div class="flex justify-end -mb-4">
                    <x-check-box value='N' :label="__('Pasien Baru')"
                        wire:model.debounce.500ms="dataDaftarUgd.passStatus" />
                </div>

                <x-input-label for="dataPasienLovSearch" :value="__('Cari Data Pasien dgn [ Nama / Reg No / NIK / Noka BPJS]')" :required="__(true)" />

                <div class="flex items-center mb-2">
                    <x-text-input id="dataPasienLovSearch"
                        placeholder="Cari Data Pasien dgn [ Nama / Reg No / NIK / Noka BPJS]" class="mt-1 ml-2"
                        :errorshas="__($errors->has('dataDaftarUgd.regNo'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataPasienLovSearch" />

                </div>
                @error('dataDaftarUgd.regNo')
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
                    @include('livewire.daftar-u-g-d.form-entry-u-g-d.list-of-value-caridatapasien')
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
                <x-input-label :value="__('No Referensi')" :required="__(true)" />
                <div class="flex items-center mb-2">
                    <x-text-input placeholder="No Referensi" class="mt-1" :errorshas="__($errors->has('dataDaftarUgd.noReferensi'))"
                        :disabled=$disabledPropertyRjStatus wire:model.debounce.500ms="dataDaftarUgd.noReferensi"
                        wire:loading.attr="disabled" />
                </div>

                {{-- LOV --}}
                <div class="mt-2">
                    @include('livewire.daftar-u-g-d.form-entry-u-g-d.list-of-value-rujukanRefBpjs')
                </div>

                <div>
                    <div class="flex justify-between">
                        <x-green-button :disabled=$disabledPropertyRjStatus wire:click.prevent="clickrujukanPeserta()"
                            type="button" wire:loading.remove>No Referensi
                        </x-green-button>

                        <div wire:loading wire:target="clickrujukanPeserta">
                            <x-loading />
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
                        <x-text-input placeholder="Dokter" class="sm:rounded-none sm:rounded-l-lg" :errorshas="__($errors->has('dataDaftarUgd.drId'))"
                            :disabled=true value="{{ $dataDaftarUgd['drId'] . ' ' . $dataDaftarUgd['drDesc'] }}" />
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
                        @include('livewire.daftar-u-g-d.form-entry-u-g-d.list-of-value-caridatadokter')
                    </div>

                </div>
                @error('dataDaftarUgd.drId')
                    <x-input-error :messages=$message />
                @enderror
            </div>


            <div>
                <x-input-label :value="__('Keterangan Masuk')" :required="__(true)" />
                <div class="grid grid-cols-4 my-2">

                    @foreach ($entryUgd['entryOptions'] as $sRj)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($sRj['entryDesc'])" value="{{ $sRj['entryId'] }}"
                            wire:model="entryUgd.entryId" />
                    @endforeach

                </div>
                @error('entryUgd.entryId')
                    <x-input-error :messages=$message />
                @enderror
            </div>

            <div>
                <x-input-label :value="__('NoSep')" :required="__(false)" />
                <div class="flex items-center mb-2">
                    <x-text-input placeholder="NoSep" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.sep.noSep'))"
                        :disabled=$disabledPropertyRjStatus
                        value="{{ isset($dataDaftarUgd['sep']['noSep']) ? $dataDaftarUgd['sep']['noSep'] : '-' }}" />
                </div>

                <div class="flex items-center justify-end mb-2">
                    @php
                        $dataPasienRegNo = $dataPasien['pasien']['regNo'] ? $dataPasien['pasien']['regNo'] : '110750Z';
                    @endphp

                    <livewire:cetak.cetak-etiket :regNo="$dataPasienRegNo" :wire:key="$dataPasienRegNo">

                        <x-yellow-button wire:click.prevent="cetakSEP()" type="button" wire:loading.remove>
                            Cetak SEP
                        </x-yellow-button>
                        <div wire:loading wire:target="cetakSEP">
                            <x-loading />
                        </div>
                </div>


                @error('dataDaftarUgd.sep.noSep')
                    <x-input-error :messages=$message />
                @enderror
            </div>




        </x-border-form>
    </div>

    {{-- down bar --}}
    <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6">

        <div class="">


            <x-yellow-button :disabled=$disabledPropertyRjStatus wire:click.prevent="resetInputFields()" type="button"
                wire:loading.remove>
                Resert Kolom
            </x-yellow-button>
            <div wire:loading wire:target="resetInputFields">
                <x-loading />
            </div>
        </div>
        <div>
            @if ($isOpenMode !== 'tampil')
                <div wire:loading wire:target="store">
                    <x-loading />
                </div>

                <x-green-button :disabled=$disabledPropertyRjStatus wire:click.prevent="store()" type="button"
                    wire:loading.remove>
                    {{ $isOpenMode == 'insert' ? 'Simpan' : 'Update' }}
                </x-green-button>
            @endif
            <x-light-button wire:click="closeModal()" type="button">Keluar</x-light-button>
        </div>
    </div>














</div>
