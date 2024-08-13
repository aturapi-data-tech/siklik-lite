<div>
    <div class="w-full mb-1">


        <div class="pt-2">
            <x-input-label for="dataDaftarUgd.anamnesa.edukasi.edukasi" :value="__('Screening Batuk')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <div class="pt-2 ">

                <div class="grid grid-cols-2 gap-2 mt-2">

                    <x-check-box value='1' :label="__('Riwayat Demam?')"
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.batuk.riwayatDemam" />

                    <x-text-input id="dataDaftarUgd.anamnesa.edukasi.keteranganRiwayatDemam"
                        placeholder="Keterangan Riwayat Demam" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.edukasi.keteranganRiwayatDemam'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.batuk.keteranganRiwayatDemam" />
                </div>

                <div class="grid grid-cols-2 gap-2 mt-2">

                    <x-check-box value='1' :label="__('Riwayat Berkeringat Malam Hari Tanpa Aktifitas?')"
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.batuk.berkeringatMlmHari" />

                    <x-text-input id="dataDaftarUgd.anamnesa.edukasi.keteranganBerkeringatMlmHari"
                        placeholder="Keterangan Berkeringat Malam Hari Tanpa Aktifitas" class="mt-1 ml-2"
                        :errorshas="__($errors->has('dataDaftarUgd.anamnesa.edukasi.keteranganBerkeringatMlmHari'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.edukasi.keteranganBerkeringatMlmHari" />
                </div>

                <div class="grid grid-cols-2 gap-2 mt-2">

                    <x-check-box value='1' :label="__('Riwayat Bepergian Daerah Wabah?')"
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.batuk.bepergianDaerahWabah" />

                    <x-text-input id="dataDaftarUgd.anamnesa.edukasi.keteranganBepergianDaerahWabah"
                        placeholder="Keterangan Bepergian Daerah Wabah" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.edukasi.keteranganBepergianDaerahWabah'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.edukasi.keteranganBepergianDaerahWabah" />
                </div>

                <div class="grid grid-cols-2 gap-2 mt-2">

                    <x-check-box value='1' :label="__('Riwayat Pemakaian Obat dalam Jangka Panjang?')"
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.batuk.riwayatPakaiObatJangkaPanjangan" />

                    <x-text-input id="dataDaftarUgd.anamnesa.edukasi.keteranganRiwayatPakaiObatJangkaPanjangan"
                        placeholder="Keterangan Riwayat Demam" class="mt-1 ml-2" :errorshas="__(
                            $errors->has('dataDaftarUgd.anamnesa.edukasi.keteranganRiwayatPakaiObatJangkaPanjangan'),
                        )"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.edukasi.keteranganRiwayatPakaiObatJangkaPanjangan" />
                </div>

                <div class="grid grid-cols-2 gap-2 mt-2">

                    <x-check-box value='1' :label="__('Riwayat Berat Badan Turun Tanpa Sebab?')"
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.batuk.BBTurunTanpaSebab" />

                    <x-text-input id="dataDaftarUgd.anamnesa.edukasi.keteranganBBTurunTanpaSebab"
                        placeholder="Keterangan Berat Badan Turun Tanpa Sebab" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.edukasi.keteranganBBTurunTanpaSebab'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.edukasi.keteranganBBTurunTanpaSebab" />
                </div>

                <div class="grid grid-cols-2 gap-2 mt-2">

                    <x-check-box value='1' :label="__('Ada Pembesaran Kelenjar Getah Bening?')"
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.batuk.pembesaranGetahBening" />

                    <x-text-input id="dataDaftarUgd.anamnesa.edukasi.keteranganpembesaranGetahBening"
                        placeholder="Keterangan Pembesaran Kelenjar Getah Bening" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.edukasi.keteranganpembesaranGetahBening'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.edukasi.keteranganpembesaranGetahBening" />
                </div>


            </div>

        </div>


    </div>
</div>
