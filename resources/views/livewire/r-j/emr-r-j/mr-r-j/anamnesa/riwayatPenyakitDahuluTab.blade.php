<div>
    <div class="w-full mb-1">

        <div>
            <x-input-label for="dataDaftarPoliRJ.anamnesa.riwayatPenyakitDahulu.riwayatPenyakitDahulu" :value="__('Riwayat Penyakit Dahulu')"
                :required="__(true)" class="pt-2 sm:text-xl" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarPoliRJ.anamnesa.riwayatPenyakitDahulu.riwayatPenyakitDahulu"
                    placeholder="Riwayat Perjalanan Penyakit" class="mt-1 ml-2" :errorshas="__(
                        $errors->has('dataDaftarPoliRJ.anamnesa.riwayatPenyakitDahulu.riwayatPenyakitDahulu'),
                    )"
                    :disabled=$disabledPropertyRjStatus :rows=3
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.riwayatPenyakitDahulu.riwayatPenyakitDahulu" />

            </div>
            @error('dataDaftarPoliRJ.anamnesa.riwayatPenyakitDahulu.riwayatPenyakitDahulu')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="dataDaftarPoliRJ.anamnesa.alergi.alergi" :value="__('Alergi')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarPoliRJ.anamnesa.alergi.alergi"
                    placeholder="Jenis Alergi / Alergi [Makanan / Obat / Udara]" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.alergi.alergi'))"
                    :disabled=$disabledPropertyRjStatus :rows=3
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.alergi.alergi" />

            </div>
            @error('dataDaftarPoliRJ.anamnesa.alergi.alergi')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="dataDaftarPoliRJ.anamnesa.alergi.alergiMakanan" :value="__('Alergi Makanan')" :required="__(true)"
                class="pt-2" />
            <div class="flex ">
                <x-text-input placeholder="Alergi Makanan" class="sm:rounded-none sm:rounded-l-lg" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.alergi.alergiMakanan'))"
                    :disabled=true
                    value="{{ $dataDaftarPoliRJ['anamnesa']['alergi']['alergiMakanan'] ?? '' }}{{ ' / ' }}{{ $dataDaftarPoliRJ['anamnesa']['alergi']['alergiMakananDesc'] ?? '' }}" />

                <x-green-button :disabled=$disabledPropertyRjStatus
                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                    wire:click.prevent="clickalergiMakananlov()">
                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                </x-green-button>
            </div>
            {{-- LOV alergi-makanan --}}
            @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.list-of-value-alergi-makanan')
        </div>

        <div>
            <x-input-label for="dataDaftarPoliRJ.anamnesa.alergi.alergiObat" :value="__('Alergi Obat')" :required="__(true)"
                class="pt-2" />
            <div class="flex ">
                <x-text-input placeholder="Alergi Obat" class="sm:rounded-none sm:rounded-l-lg" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.alergi.alergiObat'))"
                    :disabled=true
                    value="{{ $dataDaftarPoliRJ['anamnesa']['alergi']['alergiObat'] ?? '' }}{{ ' / ' }}{{ $dataDaftarPoliRJ['anamnesa']['alergi']['alergiObatDesc'] ?? '' }}" />

                <x-green-button :disabled=$disabledPropertyRjStatus
                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                    wire:click.prevent="clickalergiObatlov()">
                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                </x-green-button>
            </div>
            {{-- LOV alergi-Obat --}}
            @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.list-of-value-alergi-obat')
        </div>

        <div>
            <x-input-label for="dataDaftarPoliRJ.anamnesa.alergi.alergiUdara" :value="__('Alergi Udara')" :required="__(true)"
                class="pt-2" />
            <div class="flex ">
                <x-text-input placeholder="Alergi Udara" class="sm:rounded-none sm:rounded-l-lg" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.alergi.alergiUdara'))"
                    :disabled=true
                    value="{{ $dataDaftarPoliRJ['anamnesa']['alergi']['alergiUdara'] ?? '' }}{{ ' / ' }}{{ $dataDaftarPoliRJ['anamnesa']['alergi']['alergiUdaraDesc'] ?? '' }}" />

                <x-green-button :disabled=$disabledPropertyRjStatus
                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                    wire:click.prevent="clickalergiUdaralov()">
                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                </x-green-button>
            </div>
            {{-- LOV alergi-udara --}}
            @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.list-of-value-alergi-udara')
        </div>




        {{-- <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.obat.obat" :value="__('Rekonsiliasi Obat')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            @include('livewire.emr-r-j.mr-r-j.anamnesa.rekonsiliasiObat')
        </div> --}}

        {{-- <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.lainLain.lainLain" :value="__('Lain-Lain')" :required="__(false)" />

            <div class="grid grid-cols-2 pt-2">
                <x-check-box value='1' :label="__('Merokok')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.lainLain.merokok" />
                <x-check-box value='1' :label="__('Terpapar Rokok')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.lainLain.terpaparRokok" />
            </div>
        </div>

        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.faktorResiko.faktorResiko" :value="__('Faktor Resiko')"
                :required="__(false)" />

            <div class="grid grid-cols-5 gap-2 pt-2">
                <x-check-box value='1' :label="__('hipertensi')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.faktorResiko.hipertensi" />
                <x-check-box value='1' :label="__('diabetesMelitus')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.faktorResiko.diabetesMelitus" />


                <x-check-box value='1' :label="__('penyakitJantung')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.faktorResiko.penyakitJantung" />
                <x-check-box value='1' :label="__('asma')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.faktorResiko.asma" />
                <x-check-box value='1' :label="__('stroke')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.faktorResiko.stroke" />
                <x-check-box value='1' :label="__('liver')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.faktorResiko.liver" />

                <x-check-box value='1' :label="__('tuberculosisParu')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.faktorResiko.tuberculosisParu" />
                <x-check-box value='1' :label="__('rokok')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.faktorResiko.rokok" />
                <x-check-box value='1' :label="__('minumAlkohol')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.faktorResiko.minumAlkohol" />
                <x-check-box value='1' :label="__('ginjal')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.faktorResiko.ginjal" />

            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesa.faktorResiko.lainLain"
                    placeholder="Jenis Faktor Resiko Lain-Lain" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.faktorResiko.lainLain'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.faktorResiko.lainLain" />

            </div>
        </div>

        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.penyakitKeluarga" :value="__('Penyakit Keluarga')"
                :required="__(false)" />

            <div class="grid grid-cols-5 gap-2 pt-2">
                <x-check-box value='1' :label="__('hipertensi')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.hipertensi" />
                <x-check-box value='1' :label="__('diabetesMelitus')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.diabetesMelitus" />
                <x-check-box value='1' :label="__('penyakitJantung')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.penyakitJantung" />
                <x-check-box value='1' :label="__('asma')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.asma" />
            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.lainLain"
                    placeholder="Jenis Faktor Resiko Lain-Lain" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.penyakitKeluarga.lainLain'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.lainLain" />

            </div>
        </div> --}}



    </div>
</div>
