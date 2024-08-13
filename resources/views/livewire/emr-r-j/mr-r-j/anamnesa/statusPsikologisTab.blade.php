<div>
    <div class="w-full mb-1">



        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.statusPsikologis.statusPsikologis" :value="__('Status Psikologis')"
                :required="__(false)" class="pt-2 sm:text-xl" />

            <div class="grid grid-cols-4 gap-2 pt-2">
                <x-check-box value='1' :label="__('Tidak Ada Kelainan')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusPsikologis.tidakAdaKelainan" />

                <x-check-box value='1' :label="__('Marah')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusPsikologis.marah" />

                <x-check-box value='1' :label="__('Cemas')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusPsikologis.ccemas" />

                <x-check-box value='1' :label="__('Takut')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusPsikologis.takut" />

                <x-check-box value='1' :label="__('Sedih')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusPsikologis.sedih" />

                <x-check-box value='1' :label="__('Resiko Bunuh Diri')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusPsikologis.cenderungBunuhDiri" />
            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesa.statusPsikologis.statusPsikologis" placeholder="Lainnya"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.statusPsikologis.sebutstatusPsikologis'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusPsikologis.sebutstatusPsikologis" />

            </div>
        </div>

        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.statusMental.statusMental" :value="__('Status Mental')"
                :required="__(false)" class="pt-2 sm:text-xl" />

            <div class="pt-2 ">

                <div class="flex mt-2 ml-2">
                    @foreach ($dataDaftarPoliRJ['anamnesa']['statusMental']['statusMentalOption'] as $statusMentalOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($statusMentalOption['statusMental'])" value="{{ $statusMentalOption['statusMental'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.statusMental.statusMental" />
                    @endforeach

                </div>
            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesa.statusMental.statusMental" placeholder="Lainnya"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.statusMental.statusMental'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.statusMental.sebutstatusPsikologis" />

            </div>
        </div>

        {{-- <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.hubunganDgnKeluarga.hubunganDgnKeluarga" :value="__('Sosial')"
                :required="__(false)" />


            
            <div class="pt-2 ">

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="dataDaftarPoliRJ.anamnesa.hubunganDgnKeluarga.hubunganDgnKeluarga"
                        :value="__('Hubungan Dgn Keluarga')" :required="__(false)" class="mr-2" />

                    @foreach ($dataDaftarPoliRJ['anamnesa']['hubunganDgnKeluarga']['hubunganDgnKeluargaOption'] as $hubunganDgnKeluargaOption)
                        <x-radio-button :label="__($hubunganDgnKeluargaOption['hubunganDgnKeluarga'])"
                            value="{{ $hubunganDgnKeluargaOption['hubunganDgnKeluarga'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.hubunganDgnKeluarga.hubunganDgnKeluarga" />
                    @endforeach

                </div>

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="dataDaftarPoliRJ.anamnesa.tempatTinggal.tempatTinggal" :value="__('Tempat Tinggal')"
                        :required="__(false)" class="mr-2" />

                    @foreach ($dataDaftarPoliRJ['anamnesa']['tempatTinggal']['tempatTinggalOption'] as $tempatTinggalOption)
                        <x-radio-button :label="__($tempatTinggalOption['tempatTinggal'])" value="{{ $tempatTinggalOption['tempatTinggal'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.tempatTinggal.tempatTinggal" />
                    @endforeach

                </div>
                <x-text-input id="dataDaftarPoliRJ.anamnesa.tempatTinggal.tempatTinggal"
                    placeholder="Keterangan Tempat Tinggal" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.tempatTinggal.tempatTinggal'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.tempatTinggal.keteranganTempatTinggal" />


                <x-text-input id="dataDaftarPoliRJ.anamnesa.spiritual.spiritual" placeholder="Spiritual" class="mt-1 ml-2"
                    :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.spiritual.spiritual'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.spiritual.spiritual" />

                <div class="flex items-center mt-2 ml-2">

                    <x-input-label for="dataDaftarPoliRJ.anamnesa.spiritual.spiritual" :value="__('Kebiasaan Ibadah Teratur')"
                        :required="__(false)" class="mr-2" />


                    @foreach ($dataDaftarPoliRJ['anamnesa']['spiritual']['ibadahTeraturOptions'] as $ibadahTeraturOption)
                        <x-radio-button :label="__($ibadahTeraturOption['ibadahTeratur'])" value="{{ $ibadahTeraturOption['ibadahTeratur'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.ibadahTeratur.ibadahTeratur" />
                    @endforeach

                </div>

                <div class="flex items-center mt-2 ml-2">

                    <x-input-label for="dataDaftarPoliRJ.anamnesa.spiritual.nilaiKepercayaan" :value="__('Nilai Kepercayaan')"
                        :required="__(false)" class="mr-2" />


                    @foreach ($dataDaftarPoliRJ['anamnesa']['spiritual']['nilaiKepercayaanOptions'] as $nilaiKepercayaanOption)
                        <x-radio-button :label="__($nilaiKepercayaanOption['nilaiKepercayaan'])" value="{{ $nilaiKepercayaanOption['nilaiKepercayaan'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.nilaiKepercayaan.nilaiKepercayaan" />
                    @endforeach

                </div>

                <x-text-input id="dataDaftarPoliRJ.anamnesa.nilaiKepercayaan.nilaiKepercayaan"
                    placeholder="Sebutkan Nilai Kepercayaan" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.nilaiKepercayaan.nilaiKepercayaan'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.spiritual.keteranganSpiritual" />



                <x-input-label for="dataDaftarPoliRJ.anamnesa.ekonomi.pengambilKeputusan" :value="__('Pengambil Keputusan')"
                    :required="__(false)" class="mr-2" />

                <x-text-input id="dataDaftarPoliRJ.anamnesa.ekonomi.pengambilKeputusan" placeholder="Pengambil Keputusan"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.ekonomi.pengambilKeputusan'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.ekonomi.pengambilKeputusan" />

                <x-text-input id="dataDaftarPoliRJ.anamnesa.ekonomi.pekerjaan" placeholder="Pekerjaan" class="mt-1 ml-2"
                    :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.ekonomi.pekerjaan'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.ekonomi.pekerjaan" />

                <div class="flex items-center mt-2 ml-2">

                    @foreach ($dataDaftarPoliRJ['anamnesa']['ekonomi']['penghasilanBlnOptions'] as $penghasilanBlnOptions)
                        <x-radio-button :label="__($penghasilanBlnOptions['penghasilanBln'])" value="{{ $penghasilanBlnOptions['penghasilanBln'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.ekonomi.penghasilanBln" />
                    @endforeach

                </div>

                <x-text-input id="dataDaftarPoliRJ.anamnesa.ekonomi.keteranganEkonomi" placeholder="Keterangan Ekonomi"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.ekonomi.keteranganEkonomi'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.ekonomi.keteranganEkonomi" />

            </div>

        </div> --}}





    </div>
</div>
