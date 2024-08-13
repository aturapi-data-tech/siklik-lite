<div>
    <div class="w-full mb-1">

        <div>
            <x-input-label for="dataDaftarUgd.anamnesa.keluhanUtama.keluhanUtama" :value="__('Keluhan Utama')" :required="__(true)"
                class="pt-2 sm:text-xl" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarUgd.anamnesa.keluhanUtama.keluhanUtama" placeholder="Keluhan Utama"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.keluhanUtama.keluhanUtama'))" :disabled=$disabledPropertyRjStatus :rows=7
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.keluhanUtama.keluhanUtama" />

            </div>
            @error('dataDaftarUgd.anamnesa.keluhanUtama.keluhanUtama')
                <x-input-error :messages=$message />
            @enderror
        </div>

    </div>
</div>
