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
        @role(['Dokter', 'Admin'])
            <div class="grid grid-cols-1 gap-2 ">
                <x-yellow-button :disabled=false wire:click.prevent="openModalEresepRJ()" type="button" wire:loading.remove>
                    E-resep
                </x-yellow-button>


            </div>
            @if ($isOpenEresepRJ)
                @include('livewire.emr-r-j.create-emr-r-j-racikan-nonracikan')
            @endif
        @endrole


    </div>
</div>
