<div>
    <div class="w-full mb-1">

        <div>
            <x-input-label for="dataDaftarPoliRJ.anamnesia.keluhanUtama.keluhanUtama" :value="__('Keluhan Utama')"
                :required="__(true)" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarPoliRJ.anamnesia.keluhanUtama.keluhanUtama" placeholder="Keluhan Utama"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.keluhanUtama.keluhanUtama'))" :disabled=$disabledPropertyRjStatus :rows=7
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.keluhanUtama.keluhanUtama" />

            </div>
            @error('dataDaftarPoliRJ.anamnesia.keluhanUtama.keluhanUtama')
                <x-input-error :messages=$message />
            @enderror
        </div>

    </div>
</div>
