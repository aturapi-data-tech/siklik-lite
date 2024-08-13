<div>
    <div class="w-full mb-1">


        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesia.penyakitKeluarga.penyakitKeluarga" :value="__('Penyakit Keluarga')"
                :required="__(false)" />

            <div class="grid grid-cols-5 gap-2 pt-2">
                <x-check-box value='1' :label="__('hipertensi')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.penyakitKeluarga.hipertensi" />
                <x-check-box value='1' :label="__('diabetesMelitus')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.penyakitKeluarga.diabetesMelitus" />


                <x-check-box value='1' :label="__('penyakitJantung')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.penyakitKeluarga.penyakitJantung" />
                <x-check-box value='1' :label="__('asma')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.penyakitKeluarga.asma" />

            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesia.penyakitKeluarga.lainLain"
                    placeholder="Jenis Faktor Resiko Lain-Lain" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.penyakitKeluarga.lainLain'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.penyakitKeluarga.lainLain" />

            </div>
        </div>


    </div>
</div>
