<div>
    <div class="w-full mb-1">


        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesia.edukasi.edukasi" :value="__('Screening Batuk')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <div class="pt-2 ">

                <div class="flex items-center mt-2 ml-2">

                    <x-check-box value='1' :label="__('Riwayat Demam?')"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.batuk.riwayatDemam" />

                    <x-text-input id="dataDaftarPoliRJ.anamnesia.edukasi.keteranganRiwayatDemam"
                        placeholder="Keterangan Riwayat Demam" class="mt-1 ml-2 sm:w-1/2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.edukasi.keteranganRiwayatDemam'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.batuk.keteranganRiwayatDemam" />
                </div>

                <div class="flex items-center mt-2 ml-2">

                    <x-check-box value='1' :label="__('Riwayat Berkeringat Malam Hari Tanpa Aktifitas?')"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.batuk.berkeringatMlmHari" />

                    <x-text-input id="dataDaftarPoliRJ.anamnesia.edukasi.keteranganBerkeringatMlmHari"
                        placeholder="Keterangan Berkeringat Malam Hari Tanpa Aktifitas" class="mt-1 ml-2 sm:w-1/2"
                        :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.edukasi.keteranganBerkeringatMlmHari'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.edukasi.keteranganBerkeringatMlmHari" />
                </div>

                <div class="flex items-center mt-2 ml-2">

                    <x-check-box value='1' :label="__('Riwayat Bepergian Daerah Wabah?')"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.batuk.bepergianDaerahWabah" />

                    <x-text-input id="dataDaftarPoliRJ.anamnesia.edukasi.keteranganBepergianDaerahWabah"
                        placeholder="Keterangan Bepergian Daerah Wabah" class="mt-1 ml-2 sm:w-1/2" :errorshas="__(
                            $errors->has('dataDaftarPoliRJ.anamnesia.edukasi.keteranganBepergianDaerahWabah'),
                        )"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.edukasi.keteranganBepergianDaerahWabah" />
                </div>

                <div class="flex items-center mt-2 ml-2">

                    <x-check-box value='1' :label="__('Riwayat Pemakaian Obat dalam Jangka Panjang?')"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.batuk.riwayatPakaiObatJangkaPanjangan" />

                    <x-text-input id="dataDaftarPoliRJ.anamnesia.edukasi.keteranganRiwayatPakaiObatJangkaPanjangan"
                        placeholder="Keterangan Riwayat Demam" class="mt-1 ml-2 sm:w-1/2" :errorshas="__(
                            $errors->has(
                                'dataDaftarPoliRJ.anamnesia.edukasi.keteranganRiwayatPakaiObatJangkaPanjangan',
                            ),
                        )"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.edukasi.keteranganRiwayatPakaiObatJangkaPanjangan" />
                </div>

                <div class="flex items-center mt-2 ml-2">

                    <x-check-box value='1' :label="__('Riwayat Berat Badan Turun Tanpa Sebab?')"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.batuk.BBTurunTanpaSebab" />

                    <x-text-input id="dataDaftarPoliRJ.anamnesia.edukasi.keteranganBBTurunTanpaSebab"
                        placeholder="Keterangan Berat Badan Turun Tanpa Sebab" class="mt-1 ml-2 sm:w-1/2"
                        :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.edukasi.keteranganBBTurunTanpaSebab'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.edukasi.keteranganBBTurunTanpaSebab" />
                </div>


            </div>

        </div>


    </div>
</div>
