<div>
    <div class="w-full mb-1">


        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.penyakitKeluarga" :value="__('Penyakit Keluarga')"
                :required="__(false)" />

            <div class="grid grid-cols-5 gap-2 pt-2">
                <x-check-box value='1' :label="__('hipertensi')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.hipertensi" />
                <x-check-box value='1' :label="__('diabetesMelitus')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.diabetesMelitus" />


                <x-check-box value='1' :label="__('penyakitJantung')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.penyakitJantung" />
                <x-check-box value='1' :label="__('asma')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.asma" />

            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.lainLain"
                    placeholder="Jenis Faktor Resiko Lain-Lain" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.penyakitKeluarga.lainLain'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.penyakitKeluarga.lainLain" />

            </div>
        </div>


    </div>
</div>
