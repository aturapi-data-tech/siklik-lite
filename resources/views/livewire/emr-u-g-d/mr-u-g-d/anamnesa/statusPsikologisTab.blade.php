<div>
    <div class="w-full mb-1">



        <div class="pt-2">
            <x-input-label for="dataDaftarUgd.anamnesa.statusPsikologis.statusPsikologis" :value="__('Status Psikologis')"
                :required="__(false)" class="pt-2 sm:text-xl" />

            <div class="grid grid-cols-4 gap-2 pt-2">
                <x-check-box value='1' :label="__('Tidak Ada Kelainan')"
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.statusPsikologis.tidakAdaKelainan" />

                <x-check-box value='1' :label="__('Marah')"
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.statusPsikologis.marah" />

                <x-check-box value='1' :label="__('Cemas')"
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.statusPsikologis.ccemas" />

                <x-check-box value='1' :label="__('Takut')"
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.statusPsikologis.takut" />

                <x-check-box value='1' :label="__('Sedih')"
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.statusPsikologis.sedih" />

                <x-check-box value='1' :label="__('Resiko Bunuh Diri')"
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.statusPsikologis.cenderungBunuhDiri" />
            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarUgd.anamnesa.statusPsikologis.statusPsikologis" placeholder="Lainnya"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.statusPsikologis.sebutstatusPsikologis'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.statusPsikologis.sebutstatusPsikologis" />

            </div>
        </div>

        <div class="pt-2">
            <x-input-label for="dataDaftarUgd.anamnesa.statusMental.statusMental" :value="__('Status Mental')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <div class="pt-2 ">

                <div class="flex mt-2 ml-2">
                    @foreach ($dataDaftarUgd['anamnesa']['statusMental']['statusMentalOption'] as $statusMentalOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($statusMentalOption['statusMental'])" value="{{ $statusMentalOption['statusMental'] }}"
                            wire:model="dataDaftarUgd.anamnesa.statusMental.statusMental" />
                    @endforeach

                </div>
            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarUgd.anamnesa.statusMental.statusMental" placeholder="Lainnya"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.statusMental.statusMental'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.statusMental.sebutstatusPsikologis" />

            </div>
        </div>

        {{-- <div class="pt-2">
            <x-input-label for="dataDaftarUgd.anamnesa.hubunganDgnKeluarga.hubunganDgnKeluarga" :value="__('Sosial')"
                :required="__(false)" />


            
            <div class="pt-2 ">

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="dataDaftarUgd.anamnesa.hubunganDgnKeluarga.hubunganDgnKeluarga"
                        :value="__('Hubungan Dgn Keluarga')" :required="__(false)" class="mr-2" />

                    @foreach ($dataDaftarUgd['anamnesa']['hubunganDgnKeluarga']['hubunganDgnKeluargaOption'] as $hubunganDgnKeluargaOption)
                        <x-radio-button :label="__($hubunganDgnKeluargaOption['hubunganDgnKeluarga'])"
                            value="{{ $hubunganDgnKeluargaOption['hubunganDgnKeluarga'] }}"
                            wire:model="dataDaftarUgd.anamnesa.hubunganDgnKeluarga.hubunganDgnKeluarga" />
                    @endforeach

                </div>

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="dataDaftarUgd.anamnesa.tempatTinggal.tempatTinggal" :value="__('Tempat Tinggal')"
                        :required="__(false)" class="mr-2" />

                    @foreach ($dataDaftarUgd['anamnesa']['tempatTinggal']['tempatTinggalOption'] as $tempatTinggalOption)
                        <x-radio-button :label="__($tempatTinggalOption['tempatTinggal'])" value="{{ $tempatTinggalOption['tempatTinggal'] }}"
                            wire:model="dataDaftarUgd.anamnesa.tempatTinggal.tempatTinggal" />
                    @endforeach

                </div>
                <x-text-input id="dataDaftarUgd.anamnesa.tempatTinggal.tempatTinggal"
                    placeholder="Keterangan Tempat Tinggal" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.tempatTinggal.tempatTinggal'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.tempatTinggal.keteranganTempatTinggal" />


                <x-text-input id="dataDaftarUgd.anamnesa.spiritual.spiritual" placeholder="Spiritual" class="mt-1 ml-2"
                    :errorshas="__($errors->has('dataDaftarUgd.anamnesa.spiritual.spiritual'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.spiritual.spiritual" />

                <div class="flex items-center mt-2 ml-2">

                    <x-input-label for="dataDaftarUgd.anamnesa.spiritual.spiritual" :value="__('Kebiasaan Ibadah Teratur')"
                        :required="__(false)" class="mr-2" />


                    @foreach ($dataDaftarUgd['anamnesa']['spiritual']['ibadahTeraturOptions'] as $ibadahTeraturOption)
                        <x-radio-button :label="__($ibadahTeraturOption['ibadahTeratur'])" value="{{ $ibadahTeraturOption['ibadahTeratur'] }}"
                            wire:model="dataDaftarUgd.anamnesa.ibadahTeratur.ibadahTeratur" />
                    @endforeach

                </div>

                <div class="flex items-center mt-2 ml-2">

                    <x-input-label for="dataDaftarUgd.anamnesa.spiritual.nilaiKepercayaan" :value="__('Nilai Kepercayaan')"
                        :required="__(false)" class="mr-2" />


                    @foreach ($dataDaftarUgd['anamnesa']['spiritual']['nilaiKepercayaanOptions'] as $nilaiKepercayaanOption)
                        <x-radio-button :label="__($nilaiKepercayaanOption['nilaiKepercayaan'])" value="{{ $nilaiKepercayaanOption['nilaiKepercayaan'] }}"
                            wire:model="dataDaftarUgd.anamnesa.nilaiKepercayaan.nilaiKepercayaan" />
                    @endforeach

                </div>

                <x-text-input id="dataDaftarUgd.anamnesa.nilaiKepercayaan.nilaiKepercayaan"
                    placeholder="Sebutkan Nilai Kepercayaan" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.nilaiKepercayaan.nilaiKepercayaan'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.spiritual.keteranganSpiritual" />



                <x-input-label for="dataDaftarUgd.anamnesa.ekonomi.pengambilKeputusan" :value="__('Pengambil Keputusan')"
                    :required="__(false)" class="mr-2" />

                <x-text-input id="dataDaftarUgd.anamnesa.ekonomi.pengambilKeputusan" placeholder="Pengambil Keputusan"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.ekonomi.pengambilKeputusan'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.ekonomi.pengambilKeputusan" />

                <x-text-input id="dataDaftarUgd.anamnesa.ekonomi.pekerjaan" placeholder="Pekerjaan" class="mt-1 ml-2"
                    :errorshas="__($errors->has('dataDaftarUgd.anamnesa.ekonomi.pekerjaan'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.ekonomi.pekerjaan" />

                <div class="flex items-center mt-2 ml-2">

                    @foreach ($dataDaftarUgd['anamnesa']['ekonomi']['penghasilanBlnOptions'] as $penghasilanBlnOptions)
                        <x-radio-button :label="__($penghasilanBlnOptions['penghasilanBln'])" value="{{ $penghasilanBlnOptions['penghasilanBln'] }}"
                            wire:model="dataDaftarUgd.anamnesa.ekonomi.penghasilanBln" />
                    @endforeach

                </div>

                <x-text-input id="dataDaftarUgd.anamnesa.ekonomi.keteranganEkonomi" placeholder="Keterangan Ekonomi"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.ekonomi.keteranganEkonomi'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarUgd.anamnesa.ekonomi.keteranganEkonomi" />

            </div>

        </div> --}}





    </div>
</div>
