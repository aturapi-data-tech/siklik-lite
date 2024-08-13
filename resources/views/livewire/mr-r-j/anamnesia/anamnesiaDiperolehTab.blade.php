<div>
    <div class="w-full mb-1">

        <div class="grid grid-cols-2">
            <x-check-box value='1' :label="__('Auto-anamnesia')"
                wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.anamnesiaDiperoleh.autoanamnesia" />
            <x-check-box value='1' :label="__('Allon-anamnesia')"
                wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.anamnesiaDiperoleh.allonanamnesia" />
        </div>

        <div>
            <x-input-label for="dataDaftarPoliRJ.anamnesia.anamnesiaDiperoleh.anamnesiaDiperolehDari" :value="__('Dari')"
                :required="__(false)" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarPoliRJ.anamnesia.anamnesiaDiperoleh.anamnesiaDiperolehDari"
                    placeholder="Dari" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.anamnesiaDiperoleh.anamnesiaDiperolehDari'))" :disabled=$disabledPropertyRjStatus :rows=7
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.anamnesiaDiperoleh.anamnesiaDiperolehDari" />

            </div>
            @error('dataDaftarPoliRJ.anamnesia.anamnesiaDiperoleh.anamnesiaDiperolehDari')
                <x-input-error :messages=$message />
            @enderror
        </div>

    </div>
</div>
