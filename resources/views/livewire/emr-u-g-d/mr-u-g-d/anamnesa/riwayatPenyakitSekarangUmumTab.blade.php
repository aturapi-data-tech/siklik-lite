<div>
    <div class="w-full mb-1">

        <div>
            <x-input-label for="dataDaftarUgd.anamnesa.keluhanUtama.keluhanUtama" :value="__('Riwayat Penyakit Sekarang')" :required="__(true)"
                class="pt-2 sm:text-xl" />

            <div class="mb-2 ">
                <x-text-input-area id="dataDaftarUgd.anamnesa.riwayatPenyakitSekarangUmum.riwayatPenyakitSekarangUmum"
                    placeholder="Deskripsi Anamnesis" class="mt-1 ml-2" :errorshas="__(
                        $errors->has('dataDaftarUgd.anamnesa.riwayatPenyakitSekarangUmum.riwayatPenyakitSekarangUmum'),
                    )"
                    :disabled=$disabledPropertyRjStatus :rows=3
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.riwayatPenyakitSekarangUmum.riwayatPenyakitSekarangUmum" />

            </div>
            @error('dataDaftarUgd.anamnesa.riwayatPenyakitSekarangUmum.riwayatPenyakitSekarangUmum')
                <x-input-error :messages=$message />
            @enderror
        </div>

    </div>
</div>
