<div>
    <x-input-label for="dataDaftarUgd.pemeriksaan.ravenTest.skoring" :value="__('Skoring')" :required="__(false)" />


    <x-text-input id="dataDaftarUgd.pemeriksaan.ravenTest.skoring" placeholder="Skoring" class="mt-1 ml-2"
        :errorshas="__($errors->has('dataDaftarUgd.pemeriksaan.ravenTest.skoring'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarUgd.pemeriksaan.ravenTest.skoring" />
</div>

<div>
    <x-input-label for="dataDaftarUgd.pemeriksaan.ravenTest.presentil" :value="__('Presentil')" :required="__(false)" />


    <x-text-input id="dataDaftarUgd.pemeriksaan.ravenTest.presentil" placeholder="Presentil" class="mt-1 ml-2"
        :errorshas="__($errors->has('dataDaftarUgd.pemeriksaan.ravenTest.presentil'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarUgd.pemeriksaan.ravenTest.presentil" />
</div>

<div>
    <x-input-label for="dataDaftarUgd.pemeriksaan.ravenTest.interpretasi" :value="__('Interpretasi')" :required="__(false)" />


    <x-text-input-area id="dataDaftarUgd.pemeriksaan.ravenTest.interpretasi" placeholder="Interpretasi"
        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.pemeriksaan.ravenTest.interpretasi'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarUgd.pemeriksaan.ravenTest.interpretasi" :rows="__('6')" />
</div>

<div>
    <x-input-label for="dataDaftarUgd.pemeriksaan.ravenTest.anjuran" :value="__('Anjuran')" :required="__(false)" />


    <x-text-input-area id="dataDaftarUgd.pemeriksaan.ravenTest.anjuran" placeholder="Anjuran" class="mt-1 ml-2"
        :errorshas="__($errors->has('dataDaftarUgd.pemeriksaan.ravenTest.anjuran'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarUgd.pemeriksaan.ravenTest.anjuran" :rows="__('6')" />
</div>
