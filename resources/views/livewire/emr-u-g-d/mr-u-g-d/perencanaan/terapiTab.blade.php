<div>
    <div class="w-full mb-1">

        <div>
            <x-input-label for="dataDaftarUgd.perencanaan.terapi.terapi" :value="__('Terapi')" :required="__(true)" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarUgd.perencanaan.terapi.terapi" placeholder="Terapi" class="mt-1 ml-2"
                    :errorshas="__($errors->has('dataDaftarUgd.perencanaan.terapi.terapi'))" :disabled=$disabledPropertyRjStatus :rows=7
                    wire:model.debounce.500ms="dataDaftarUgd.perencanaan.terapi.terapi" />

            </div>
            @error('dataDaftarUgd.perencanaan.terapi.terapi')
                <x-input-error :messages=$message />
            @enderror
        </div>
        @role(['Dokter', 'Admin'])
            <div class="grid grid-cols-1 gap-2 ">
                <x-yellow-button :disabled=false wire:click.prevent="openModalEresepUGD()" type="button" wire:loading.remove>
                    E-resep
                </x-yellow-button>


            </div>
            @if ($isOpenEresepUGD)
                @include('livewire.emr-u-g-d.create-emr-u-g-d-racikan-nonracikan')
            @endif
        @endrole

    </div>
</div>
