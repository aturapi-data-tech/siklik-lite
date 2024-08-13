<div>
    <div class="w-full mb-1">

        <div>
            <x-input-label for="dataDaftarPoliRJ.anamnesia.riwayatPenyakitDahulu.riwayatPenyakitDahulu" :value="__('Riwayat Penyakit Dahulu')"
                :required="__(true)" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarPoliRJ.anamnesia.riwayatPenyakitDahulu.riwayatPenyakitDahulu"
                    placeholder="Riwayat Perjalanan Penyakit" class="mt-1 ml-2" :errorshas="__(
                        $errors->has('dataDaftarPoliRJ.anamnesia.riwayatPenyakitDahulu.riwayatPenyakitDahulu'),
                    )"
                    :disabled=$disabledPropertyRjStatus :rows=7
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.riwayatPenyakitDahulu.riwayatPenyakitDahulu" />

            </div>
            @error('dataDaftarPoliRJ.anamnesia.riwayatPenyakitDahulu.riwayatPenyakitDahulu')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="dataDaftarPoliRJ.anamnesia.alergi.alergi" :value="__('Alergi')" :required="__(false)" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarPoliRJ.anamnesia.alergi.alergi"
                    placeholder="Jenis Alergi / Alergi [Makanan / Obat / Udara]" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.alergi.alergi'))"
                    :disabled=$disabledPropertyRjStatus :rows=7
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.alergi.alergi" />

            </div>
            @error('dataDaftarPoliRJ.anamnesia.alergi.alergi')
                <x-input-error :messages=$message />
            @enderror
        </div>


        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesia.obat.obat" :value="__('Pemberian Obat')" :required="__(false)" />
        </div>

        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesia.lainLain.lainLain" :value="__('Lain-Lain')" :required="__(false)" />

            <div class="grid grid-cols-2 pt-2">
                <x-check-box value='1' :label="__('Merokok')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.lainLain.merokok" />
                <x-check-box value='1' :label="__('Terpapar Rokok')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.lainLain.terpaparRokok" />
            </div>
        </div>

        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesia.faktorResiko.faktorResiko" :value="__('Faktor Resiko')"
                :required="__(false)" />

            <div class="grid grid-cols-5 gap-2 pt-2">
                <x-check-box value='1' :label="__('hipertensi')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.faktorResiko.hipertensi" />
                <x-check-box value='1' :label="__('diabetesMelitus')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.faktorResiko.diabetesMelitus" />


                <x-check-box value='1' :label="__('penyakitJantung')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.faktorResiko.penyakitJantung" />
                <x-check-box value='1' :label="__('asma')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.faktorResiko.asma" />
                <x-check-box value='1' :label="__('stroke')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.faktorResiko.stroke" />
                <x-check-box value='1' :label="__('liver')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.faktorResiko.liver" />

                <x-check-box value='1' :label="__('tuberculosisParu')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.faktorResiko.tuberculosisParu" />
                <x-check-box value='1' :label="__('rokok')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.faktorResiko.rokok" />
                <x-check-box value='1' :label="__('minumAlkohol')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.faktorResiko.minumAlkohol" />
                <x-check-box value='1' :label="__('ginjal')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.faktorResiko.ginjal" />

            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesia.faktorResiko.lainLain"
                    placeholder="Jenis Faktor Resiko Lain-Lain" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.faktorResiko.lainLain'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.faktorResiko.lainLain" />

            </div>
        </div>

        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesia.penyakitKeluarga.penyakitKeluarga" :value="__('Faktor Resiko')"
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
