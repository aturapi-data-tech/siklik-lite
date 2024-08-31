<div>
    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.ravenTest.skoring" :value="__('Skoring')" :required="__(false)" />


    <x-text-input id="dataDaftarPoliRJ.pemeriksaan.ravenTest.skoring" placeholder="Skoring" class="mt-1 ml-2"
        :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.ravenTest.skoring'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.ravenTest.skoring" />
</div>

<div>
    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.ravenTest.presentil" :value="__('Presentil')" :required="__(false)" />


    <x-text-input id="dataDaftarPoliRJ.pemeriksaan.ravenTest.presentil" placeholder="Presentil" class="mt-1 ml-2"
        :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.ravenTest.presentil'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.ravenTest.presentil" />
</div>

<div>
    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.ravenTest.interpretasi" :value="__('Interpretasi')" :required="__(false)" />


    <x-text-input-area id="dataDaftarPoliRJ.pemeriksaan.ravenTest.interpretasi" placeholder="Interpretasi"
        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.ravenTest.interpretasi'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.ravenTest.interpretasi" :rows="__('6')" />
</div>

<div>
    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.ravenTest.anjuran" :value="__('Anjuran')" :required="__(false)" />


    <x-text-input-area id="dataDaftarPoliRJ.pemeriksaan.ravenTest.anjuran" placeholder="Anjuran" class="mt-1 ml-2"
        :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.ravenTest.anjuran'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.ravenTest.anjuran" :rows="__('6')" />
</div>
