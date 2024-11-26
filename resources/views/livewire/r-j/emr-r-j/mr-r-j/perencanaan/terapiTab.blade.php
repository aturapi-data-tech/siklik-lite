<div>
    <div class="w-full mb-1">

        <div>
            <x-input-label for="dataDaftarPoliRJ.perencanaan.terapi.terapi" :value="__('Terapi')" :required="__(true)" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarPoliRJ.perencanaan.terapi.terapi" placeholder="Terapi" class="mt-1 ml-2"
                    :errorshas="__($errors->has('dataDaftarPoliRJ.perencanaan.terapi.terapi'))" :disabled=$disabledPropertyRjStatus :rows=7
                    wire:model.debounce.500ms="dataDaftarPoliRJ.perencanaan.terapi.terapi" />

            </div>
            @error('dataDaftarPoliRJ.perencanaan.terapi.terapi')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="dataDaftarPoliRJ.perencanaan.terapi.terapiNonObat" :value="__('Terapi Non Obat')" :required="__(true)" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarPoliRJ.perencanaan.terapi.terapiNonObat" placeholder="Terapi Non Obat"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.perencanaan.terapi.terapiNonObat'))" :disabled=$disabledPropertyRjStatus :rows=7
                    wire:model.debounce.500ms="dataDaftarPoliRJ.perencanaan.terapi.terapiNonObat" :rows="__('2')" />

            </div>
            @error('dataDaftarPoliRJ.perencanaan.terapi.terapiNonObat')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="dataDaftarPoliRJ.perencanaan.prognosa.prognosa" :value="__('Prognosa')" :required="__(true)"
                class="pt-2" />
            <div class="flex ">
                <x-text-input placeholder="Prognosa" class="sm:rounded-none sm:rounded-l-lg" :errorshas="__($errors->has('dataDaftarPoliRJ.perencanaan.prognosa.prognosa'))"
                    :disabled=true
                    value="{{ $dataDaftarPoliRJ['perencanaan']['prognosa']['prognosa'] ?? '' }}{{ ' / ' }}{{ $dataDaftarPoliRJ['perencanaan']['prognosa']['prognosaDesc'] ?? '' }}" />

                <x-green-button :disabled=$disabledPropertyRjStatus
                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                    wire:click.prevent="clickprognosalov()">
                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                </x-green-button>
            </div>
            {{-- LOV prognosa --}}
            @include('livewire.component.l-o-v.p-care.list-of-value-prognosa.list-of-value-prognosa')
        </div>




        @role(['Dokter', 'Admin'])
            <div class="grid grid-cols-1 gap-2 my-2">
                <x-yellow-button :disabled=false wire:click.prevent="openModalEresepRJ()" type="button"
                    wire:loading.remove>
                    E-resep
                </x-yellow-button>


            </div>
            @if ($isOpenEresepRJ)
                @include('livewire.r-j.emr-r-j.create-emr-r-j-racikan-nonracikan')
            @endif
        @endrole


    </div>
</div>
