<div>
    <div class="w-full mb-1">

        <div class="grid grid-cols-2 gap-2 mt-2 ml-2">
            <x-check-box value='1' :label="__('Auto-anamnesa')"
                wire:model.debounce.500ms="dataDaftarUgd.anamnesa.anamnesaDiperoleh.autoanamnesa" />
            <x-check-box value='1' :label="__('Allon-anamnesa')"
                wire:model.debounce.500ms="dataDaftarUgd.anamnesa.anamnesaDiperoleh.allonanamnesa" />
        </div>

        <div>
            <x-input-label for="dataDaftarUgd.anamnesa.anamnesaDiperoleh.anamnesaDiperolehDari" :value="__('Dari')"
                :required="__(false)" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarUgd.anamnesa.anamnesaDiperoleh.anamnesaDiperolehDari" placeholder="Dari"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.anamnesaDiperoleh.anamnesaDiperolehDari'))" :disabled=$disabledPropertyRjStatus :rows=7
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.anamnesaDiperoleh.anamnesaDiperolehDari" />

            </div>
            @error('dataDaftarUgd.anamnesa.anamnesaDiperoleh.anamnesaDiperolehDari')
                <x-input-error :messages=$message />
            @enderror
        </div>

    </div>
</div>
