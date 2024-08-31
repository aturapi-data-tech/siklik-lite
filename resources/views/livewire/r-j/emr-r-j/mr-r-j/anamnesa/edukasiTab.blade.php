<div>
    <div class="w-full mb-1">


        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.edukasi.edukasi" :value="__('Pasien dan Keluarga')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <div class="pt-2 ">

                <div class="grid grid-cols-4 gap-2 mt-2 ml-2">
                    <x-input-label for="" :value="__('Kesediaan Pasien / Keluarga Menerima Informasi')" :required="__(false)" class="px-2" />

                    @foreach ($dataDaftarPoliRJ['anamnesa']['edukasi']['pasienKeluargaMenerimaInformasiOptions'] as $edukasiOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($edukasiOption['pasienKeluargaMenerimaInformasi'])" value="{{ $edukasiOption['pasienKeluargaMenerimaInformasi'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.edukasi.pasienKeluargaMenerimaInformasi" />
                    @endforeach

                </div>

                <div class="grid grid-cols-4 gap-2 mt-2 ml-2">
                    <x-input-label for="" :value="__('Terdapat Hambatan Terhadap Edukasi')" :required="__(false)" class="px-2" />

                    @foreach ($dataDaftarPoliRJ['anamnesa']['edukasi']['hambatanEdukasiOptions'] as $edukasiOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($edukasiOption['hambatanEdukasi'])" value="{{ $edukasiOption['hambatanEdukasi'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.edukasi.hambatanEdukasi" />
                    @endforeach

                    <x-text-input id="dataDaftarPoliRJ.anamnesa.edukasi.keteranganHambatanEdukasi"
                        placeholder="Keterangan Hambatan Terhadap Edukasi" class="mt-1 ml-2 " :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.edukasi.keteranganHambatanEdukasi'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.edukasi.keteranganHambatanEdukasi" />
                </div>

                <div class="grid grid-cols-4 gap-2 mt-2 ml-2">
                    <x-input-label for="" :value="__('Dibutuhkan Penerjemah')" :required="__(false)" class="px-2" />

                    @foreach ($dataDaftarPoliRJ['anamnesa']['edukasi']['penerjemahOptions'] as $edukasiOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($edukasiOption['penerjemah'])" value="{{ $edukasiOption['penerjemah'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.edukasi.penerjemah" />
                    @endforeach

                    <x-text-input id="dataDaftarPoliRJ.anamnesa.edukasi.keteranganPenerjemah"
                        placeholder="Keterangan Penerjemah" class="mt-1 ml-2 " :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.edukasi.keteranganPenerjemah'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.edukasi.keteranganPenerjemah" />
                </div>

            </div>

        </div>


        <div class="pt-2">
            <x-input-label for="" :value="__('Kebutuhan Edukasi')" :required="__(false)" class="pt-2 sm:text-xl" />

            <div class="grid grid-cols-4 gap-2 pt-2">
                <x-check-box value='1' :label="__('diagPenyakit')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.edukasi.diagPenyakit" />

                <x-check-box value='1' :label="__('obat')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.edukasi.obat" />

                <x-check-box value='1' :label="__('dietNutrisi')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.edukasi.dietNutrisi" />

                <x-check-box value='1' :label="__('rehabMedik')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.edukasi.rehabMedik" />

                <x-check-box value='1' :label="__('managemenNyeri')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.edukasi.managemenNyeri" />

                <x-check-box value='1' :label="__('penggunaanAlatMedis')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.edukasi.penggunaanAlatMedis" />

                <x-check-box value='1' :label="__('hakKewajibanPasien')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.edukasi.hakKewajibanPasien" />

            </div>

        </div>


        <x-input-label for="" :value="__('Emergensi')" :required="__(false)" class="pt-2 sm:text-xl" />

        <div class="grid grid-cols-2 gap-2 pt-2">

            <div class="pt-2 ml-2">
                <x-input-label for="dataDaftarPoliRJ.anamnesa.edukasi.edukasiFollowUp" :value="__('Edukasi Followup')"
                    :required="__(false)" />

                <div class="mb-2">
                    <x-text-input-area id="dataDaftarPoliRJ.anamnesa.edukasi.edukasiFollowUp"
                        placeholder="Edukasi Followup" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.edukasi.edukasiFollowUp'))"
                        :disabled=$disabledPropertyRjStatus :rows=7
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.edukasi.edukasiFollowUp" />

                </div>
                @error('dataDaftarPoliRJ.anamnesa.edukasi.edukasiFollowUp')
                    <x-input-error :messages=$message />
                @enderror
            </div>

            <div class="pt-2 ml-2">
                <x-input-label for="dataDaftarPoliRJ.anamnesa.edukasi.segeraKembaliIGDjika" :value="__('Segera Kembali ke Gawat Darurat Jika')"
                    :required="__(false)" />

                <div class="mb-2 ">
                    <x-text-input-area id="dataDaftarPoliRJ.anamnesa.edukasi.edukasi"
                        placeholder="Segera Kembali ke Gawat Darurat Jika" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.edukasi.segeraKembaliIGDjika'))"
                        :disabled=$disabledPropertyRjStatus :rows=7
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.edukasi.segeraKembaliIGDjika" />

                </div>
                @error('dataDaftarPoliRJ.anamnesa.edukasi.segeraKembaliIGDjika')
                    <x-input-error :messages=$message />
                @enderror
            </div>

        </div>





    </div>
</div>
