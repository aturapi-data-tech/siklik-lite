@php
    $disabledProperty = false;
    $disabledPropertyId = $isOpenMode == 'insert' ? false : true;
@endphp

<div>


    {{-- FormMasterPoli --}}
    <div id="FormMasterPoli" class="px-4">

        <div>
            <x-input-label for="FormEntryPoli.poliId" :value="__('Kode Poli')" :required="__($errors->has('FormEntryPoli.poliId'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntryPoli.poliId" placeholder="Kode Poli" class="mt-1 ml-2" :errorshas="__($errors->has('FormEntryPoli.poliId'))"
                    :disabled=$disabledPropertyId wire:model="FormEntryPoli.poliId" />
            </div>
            @error('FormEntryPoli.poliId')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="FormEntryPoli.poliDesc" :value="__('Nama Poli')" :required="__($errors->has('FormEntryPoli.poliDesc'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntryPoli.poliDesc" placeholder="Nama Poli" class="mt-1 ml-2" :errorshas="__($errors->has('FormEntryPoli.poliDesc'))"
                    :disabled=$disabledProperty wire:model="FormEntryPoli.poliDesc" />
            </div>
            @error('FormEntryPoli.poliDesc')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="FormEntryPoli.poliIdBPJS" :value="__('Kode Poli BPJS')" :required="__($errors->has('FormEntryPoli.poliIdBPJS'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntryPoli.poliIdBPJS" placeholder="Kode Poli BPJS" class="mt-1 ml-2"
                    :errorshas="__($errors->has('FormEntryPoli.poliIdBPJS'))" :disabled=$disabledProperty wire:model="FormEntryPoli.poliIdBPJS" />
            </div>
            @error('FormEntryPoli.poliIdBPJS')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="FormEntryPoli.poliUuid" :value="__('UUID Satu Sehat')" :required="__($errors->has('FormEntryPoli.poliUuid'))" />
            <div class="grid grid-cols-4 gap-2">
                <div class="flex items-center col-span-3 mb-2">
                    <x-text-input id="FormEntryPoli.poliUuid" placeholder="UUID Satu Sehat" class="mt-1 ml-2"
                        :errorshas="__($errors->has('FormEntryPoli.poliUuid'))" :disabled=true wire:model="FormEntryPoli.poliUuid" />
                </div>

                <div wire:loading wire:target="UpdatelocationUuid">
                    <x-loading />
                </div>

                <x-green-button :disabled=$disabledProperty
                    wire:click.prevent="UpdatelocationUuid('{{ $FormEntryPoli['poliId'] }}','{{ $FormEntryPoli['poliDesc'] }}')"
                    type="button" wire:loading.remove>
                    UUID Poli
                </x-green-button>

            </div>
            @error('FormEntryPoli.poliUuid')
                <x-input-error :messages=$message />
            @enderror
        </div>














    </div>

    {{-- down bar --}}
    <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6">
        <div class="">

            <x-light-button wire:click="closeModal()" type="button">Keluar</x-light-button>



        </div>

        <div class="">
            <x-green-button :disabled=$disabledProperty wire:click.prevent="store()" type="button">Simpan
            </x-green-button>
        </div>
    </div>


</div>
