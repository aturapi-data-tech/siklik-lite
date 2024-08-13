@php
    $disabledProperty = false;
    $disabledPropertyId = $isOpenMode == 'insert' ? false : true;
@endphp

<div>


    {{-- FormMasterPoli --}}
    <div id="FormMasterPoli" class="px-4">

        <div>
            <x-input-label for="FormEntryDokter.dokterId" :value="__('Kode Dokter')" :required="__($errors->has('FormEntryDokter.dokterId'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntryDokter.dokterId" placeholder="Kode Dokter" class="mt-1 ml-2" :errorshas="__($errors->has('FormEntryDokter.dokterId'))"
                    :disabled=$disabledPropertyId wire:model="FormEntryDokter.dokterId" />
            </div>
            @error('FormEntryDokter.dokterId')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="FormEntryDokter.dokterName" :value="__('Nama Dokter')" :required="__($errors->has('FormEntryDokter.dokterName'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntryDokter.dokterName" placeholder="Nama Dokter" class="mt-1 ml-2"
                    :errorshas="__($errors->has('FormEntryDokter.dokterName'))" :disabled=$disabledProperty wire:model="FormEntryDokter.dokterName" />
            </div>
            @error('FormEntryDokter.dokterName')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="FormEntryDokter.dokterIdBPJS" :value="__('Kode Dokter BPJS')" :required="__($errors->has('FormEntryDokter.dokterIdBPJS'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntryDokter.dokterIdBPJS" placeholder="Kode Dokter BPJS" class="mt-1 ml-2"
                    :errorshas="__($errors->has('FormEntryDokter.dokterIdBPJS'))" :disabled=$disabledProperty wire:model="FormEntryDokter.dokterIdBPJS" />
            </div>
            @error('FormEntryDokter.dokterIdBPJS')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="FormEntryDokter.dokterNik" :value="__('Kode Dokter BPJS')" :required="__($errors->has('FormEntryDokter.dokterNik'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntryDokter.dokterNik" placeholder="Kode Dokter BPJS" class="mt-1 ml-2"
                    :errorshas="__($errors->has('FormEntryDokter.dokterNik'))" :disabled=$disabledProperty wire:model="FormEntryDokter.dokterNik" />
            </div>
            @error('FormEntryDokter.dokterNik')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="FormEntryDokter.dokterUuid" :value="__('UUID Satu Sehat')" :required="__($errors->has('FormEntryDokter.dokterUuid'))" />
            <div class="grid grid-cols-4 gap-2">
                <div class="flex items-center col-span-3 mb-2">
                    <x-text-input id="FormEntryDokter.dokterUuid" placeholder="UUID Satu Sehat" class="mt-1 ml-2"
                        :errorshas="__($errors->has('FormEntryDokter.dokterUuid'))" :disabled=true wire:model="FormEntryDokter.dokterUuid" />
                </div>

                <div wire:loading wire:target="UpdatePractitionerUuid">
                    <x-loading />
                </div>

                <x-green-button :disabled=$disabledProperty
                    wire:click.prevent="UpdatePractitionerUuid('{{ $FormEntryDokter['dokterNik'] }}')" type="button"
                    wire:loading.remove>
                    UUID Dokter
                </x-green-button>

            </div>
            @error('FormEntryDokter.dokterUuid')
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
