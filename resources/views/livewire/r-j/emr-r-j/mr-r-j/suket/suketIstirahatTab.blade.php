<div>
    <div class="w-full mb-1">

        <div class="">
            <x-input-label for="dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahatHari" :value="__('Istirahat Selama ?')"
                :required="__(false)" />

            <x-text-input-mou id="dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahatHari"
                placeholder="Istirahat Selama ?" class="" :errorshas="__($errors->has('dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahatHari'))" :disabled=$disabledPropertyRjStatus
                :mou_label="__('Hari')" wire:model.debounce.500ms="dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahatHari" />
        </div>
        @error('dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahatHari')
            <x-input-error :messages=$message />
        @enderror
    </div>


    <div class="w-full mb-1">

        <div>
            <x-input-label for="dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahat" :value="__('Suket Istirahat Digunakan Untuk ?')"
                :required="__(true)" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahat"
                    placeholder="Suket Istirahat Digunakan Untuk ?" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahat'))"
                    :disabled=$disabledPropertyRjStatus :rows=7
                    wire:model.debounce.500ms="dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahat" />

            </div>
            @error('dataDaftarPoliRJ.suket.suketIstirahat.suketIstirahat')
                <x-input-error :messages=$message />
            @enderror
        </div>

    </div>


</div>
