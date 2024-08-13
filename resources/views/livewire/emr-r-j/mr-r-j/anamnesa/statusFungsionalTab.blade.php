<div>
    <div class="w-full mb-1">



        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.statusFungsional.statusFungsional" :value="__('Penggunaan Alat Bantu')"
                :required="__(false)" class="pt-2 sm:text-xl" />

            <div class="grid grid-cols-4 gap-2 pt-2">
                <x-check-box value='1' :label="__('tongkat')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusFungsional.tongkat" />
                <x-check-box value='1' :label="__('kursiRoda')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusFungsional.kursiRoda" />

                <x-check-box value='1' :label="__('brankard')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusFungsional.brankard" />

                <x-check-box value='1' :label="__('walker')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusFungsional.walker" />
            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesa.statusFungsional.statusFungsional"
                    placeholder="Penggunaan Alat Lain" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.statusFungsional.lainLain'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusFungsional.lainLain" />

            </div>
        </div>

        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.cacatTubuh.cacatTubuh" :value="__('Cacat Tubuh')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <div class="grid grid-cols-4 gap-2 pt-2">
                <x-check-box value='1' :label="__('Cacat Tubuh')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.cacatTubuh.cacatTubuh" />

            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesa.cacatTubuh.cacatTubuh" placeholder="Sebutkan Cacat Tubuh"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.cacatTubuh.sebutCacatTubuh'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.cacatTubuh.sebutCacatTubuh" />

            </div>
        </div>



    </div>
</div>
