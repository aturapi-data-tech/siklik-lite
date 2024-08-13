<div>
    <div class="w-full mb-1">


        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.screeningGizi.screeningGizi" :value="__('Screening Gizi')"
                :required="__(false)" class="pt-2 sm:text-xl" />

            <div class="pt-2 ">

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="" :value="__('Berkurangnya Berat Badan dlm 3 Bln Terakhir')" :required="__(false)" class="px-2" />

                    @foreach ($dataDaftarPoliRJ['anamnesa']['screeningGizi']['perubahanBB3BlnOptions'] as $screeningGiziOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($screeningGiziOption['perubahanBB3Bln'])" value="{{ $screeningGiziOption['perubahanBB3Bln'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.screeningGizi.perubahanBB3Bln" />
                    @endforeach

                </div>

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="" :value="__('Jml perubahan Berat Badan')" :required="__(false)" class="px-2" />

                    @foreach ($dataDaftarPoliRJ['anamnesa']['screeningGizi']['jmlPerubahabBBOptions'] as $screeningGiziOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($screeningGiziOption['jmlPerubahabBB'])" value="{{ $screeningGiziOption['jmlPerubahabBB'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.screeningGizi.jmlPerubahabBB" />
                    @endforeach

                </div>

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="" :value="__('Intake Makanan Berkurang Karena Tdk Nafsu Makan')" :required="__(false)" class="px-2" />

                    @foreach ($dataDaftarPoliRJ['anamnesa']['screeningGizi']['intakeMakananOptions'] as $screeningGiziOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($screeningGiziOption['intakeMakanan'])" value="{{ $screeningGiziOption['intakeMakanan'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.screeningGizi.intakeMakanan" />
                    @endforeach

                </div>

                <div class="mt-2 ml-2">
                    <x-input-label for="" :value="__('Kondisi Khusus')" :required="__(false)" class="px-2" />

                    <x-text-input id="dataDaftarPoliRJ.anamnesa.screeningGizi.keteranganScreeningGizi"
                        placeholder="Keterangan Screening Gizi" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.screeningGizi.keteranganScreeningGizi'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.screeningGizi.keteranganScreeningGizi" />
                </div>

                <div class="mt-2 ml-2">
                    <x-input-label for="" :value="__('Score')" :required="__(false)" class="px-2" />

                    <x-text-input id="dataDaftarPoliRJ.anamnesa.screeningGizi.scoreTotalScreeningGizi"
                        placeholder="Score Screening Gizi" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.screeningGizi.scoreTotalScreeningGizi'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.screeningGizi.scoreTotalScreeningGizi" />
                </div>



            </div>

        </div>








    </div>
</div>
