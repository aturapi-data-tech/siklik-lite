<div>
    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.eeg.hasilPemeriksaan" :value="__('Hasil Pemeriksaan')" :required="__(false)" />


    <x-text-input-area id="dataDaftarPoliRJ.pemeriksaan.eeg.hasilPemeriksaan" placeholder="Hasil Pemeriksaan"
        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.eeg.hasilPemeriksaan'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.eeg.hasilPemeriksaan" :rows="__('6')" />
</div>

<div>
    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.eeg.hasilPemeriksaanSebelumnya" :value="__('Hasil Pemeriksaan Sebelumnya')"
        :required="__(false)" />


    <x-text-input-area id="dataDaftarPoliRJ.pemeriksaan.eeg.hasilPemeriksaanSebelumnya"
        placeholder="Hasil Pemeriksaan Sebelumnya" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.eeg.hasilPemeriksaanSebelumnya'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.eeg.hasilPemeriksaanSebelumnya" :rows="__('6')" />
</div>

<div>
    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.eeg.mriKepala" :value="__('MRI Kepala')" :required="__(false)" />


    <x-text-input-area id="dataDaftarPoliRJ.pemeriksaan.eeg.mriKepala" placeholder="MRI Kepala" class="mt-1 ml-2"
        :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.eeg.mriKepala'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.eeg.mriKepala" :rows="__('6')" />
</div>

<div>
    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.eeg.hasilPerekaman" :value="__('Hasil Perekaman')" :required="__(false)" />


    <x-text-input-area id="dataDaftarPoliRJ.pemeriksaan.eeg.hasilPerekaman" placeholder="Hasil Perekaman"
        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.eeg.hasilPerekaman'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.eeg.hasilPerekaman" :rows="__('6')" />
</div>

<div>
    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.eeg.saran" :value="__('Saran')" :required="__(false)" />


    <x-text-input-area id="dataDaftarPoliRJ.pemeriksaan.eeg.saran" placeholder="Saran" class="mt-1 ml-2"
        :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.eeg.saran'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.eeg.saran" :rows="__('6')" />
</div>

<div>
    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.eeg.kesimpulan" :value="__('Kesimpulan')" :required="__(false)" />


    <x-text-input-area id="dataDaftarPoliRJ.pemeriksaan.eeg.kesimpulan" placeholder="Kesimpulan" class="mt-1 ml-2"
        :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.eeg.kesimpulan'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.eeg.kesimpulan" :rows="__('6')" />
</div>
