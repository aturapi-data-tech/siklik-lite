<div>
    <div class="w-full mb-1">

        <div>
            <x-input-label for="dataDaftarPoliRJ.suket.suketSehat.suketSehat" :value="__('Suket Sehat Digunakan Untuk ?')" :required="__(true)" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarPoliRJ.suket.suketSehat.suketSehat"
                    placeholder="Suket Sehat Digunakan Untuk ?" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.suket.suketSehat.suketSehat'))"
                    :disabled=$disabledPropertyRjStatus :rows=7
                    wire:model.debounce.500ms="dataDaftarPoliRJ.suket.suketSehat.suketSehat" />

            </div>
            @error('dataDaftarPoliRJ.suket.suketSehat.suketSehat')
                <x-input-error :messages=$message />
            @enderror
        </div>

    </div>
</div>
