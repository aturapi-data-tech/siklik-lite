<div>
    <div class="w-full mb-1">



        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesia.statusFungsional.statusFungsional" :value="__('Penggunaan Alat Bantu')"
                :required="__(false)" />

            <div class="grid grid-cols-4 gap-2 pt-2">
                <x-check-box value='1' :label="__('tongkat')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusFungsional.tongkat" />
                <x-check-box value='1' :label="__('kursiRoda')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusFungsional.kursiRoda" />

                <x-check-box value='1' :label="__('brankard')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusFungsional.brankard" />

                <x-check-box value='1' :label="__('walker')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusFungsional.walker" />
            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesia.statusFungsional.statusFungsional"
                    placeholder="Penggunaan Alat Lain" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.statusFungsional.lainLain'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusFungsional.lainLain" />

            </div>
        </div>

        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesia.cacatTubuh.cacatTubuh" :value="__('Cacat Tubuh')" :required="__(false)" />

            <div class="grid grid-cols-4 gap-2 pt-2">
                <x-check-box value='1' :label="__('Cacat Tubuh')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.cacatTubuh.cacatTubuh" />

            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesia.cacatTubuh.cacatTubuh" placeholder="Sebutkan Cacat Tubuh"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.cacatTubuh.sebutCacatTubuh'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.cacatTubuh.sebutCacatTubuh" />

            </div>
        </div>



    </div>
</div>
