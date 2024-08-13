<div>
    <div class="w-full mb-1">

        <div>
            <x-input-label for="dataDaftarPoliRJ.anamnesia.keluhanUtama.keluhanUtama" :value="__('Riwayat Penyakit Sekarang')"
                :required="__(true)" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarPoliRJ.anamnesia.riwayatPenyakitSekarangUmum.riwayatPenyakitSekarangUmum" placeholder="Deskripsi Anamnesis"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.riwayatPenyakitSekarangUmum.riwayatPenyakitSekarangUmum'))" :disabled=$disabledPropertyRjStatus :rows=7
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.riwayatPenyakitSekarangUmum.riwayatPenyakitSekarangUmum" />

            </div>
            @error('dataDaftarPoliRJ.anamnesia.riwayatPenyakitSekarangUmum.riwayatPenyakitSekarangUmum')
                <x-input-error :messages=$message />
            @enderror
        </div>

    </div>
</div>
