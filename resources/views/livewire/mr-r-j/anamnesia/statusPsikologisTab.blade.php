<div>
    <div class="w-full mb-1">



        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesia.statusPsikologis.statusPsikologis" :value="__('Status Psikologis')"
                :required="__(false)" />

            <div class="grid grid-cols-4 gap-2 pt-2">
                <x-check-box value='1' :label="__('Tidak Ada Kelainan')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusPsikologis.tidakAdaKelainan" />

                <x-check-box value='1' :label="__('Marah')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusPsikologis.marah" />

                <x-check-box value='1' :label="__('Cemas')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusPsikologis.ccemas" />

                <x-check-box value='1' :label="__('Takut')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusPsikologis.takut" />

                <x-check-box value='1' :label="__('Sedih')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusPsikologis.sedih" />

                <x-check-box value='1' :label="__('Cenderung Bunuh Diri')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusPsikologis.cenderungBunuhDiri" />

                <x-check-box value='1' :label="__('Cenderung Bunuh Diri')"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusPsikologis.cenderungBunuhDiri" />
            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesia.statusPsikologis.statusPsikologis" placeholder="Lainnya"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.statusPsikologis.sebutstatusPsikologis'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusPsikologis.sebutstatusPsikologis" />

            </div>
        </div>

        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesia.statusMental.statusMental" :value="__('Status Psikologis')"
                :required="__(false)" />

            <div class="pt-2 ">

                <div class="flex mt-2 ml-2">
                    @foreach ($dataDaftarPoliRJ['anamnesia']['statusMental']['statusMentalOption'] as $statusMentalOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($statusMentalOption['statusMental'])" value="{{ $statusMentalOption['statusMental'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesia.statusMental.statusMental" />
                    @endforeach

                </div>
            </div>
            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.anamnesia.statusMental.statusMental" placeholder="Lainnya"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.statusMental.statusMental'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.statusMental.sebutstatusPsikologis" />

            </div>
        </div>

        <div class="pt-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesia.hubunganDgnKeluarga.hubunganDgnKeluarga" :value="__('Sosial')"
                :required="__(false)" />



            <div class="pt-2 ">

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="dataDaftarPoliRJ.anamnesia.hubunganDgnKeluarga.hubunganDgnKeluarga"
                        :value="__('Hubungan Dgn Keluarga')" :required="__(false)" class="mr-2" />

                    @foreach ($dataDaftarPoliRJ['anamnesia']['hubunganDgnKeluarga']['hubunganDgnKeluargaOption'] as $hubunganDgnKeluargaOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($hubunganDgnKeluargaOption['hubunganDgnKeluarga'])"
                            value="{{ $hubunganDgnKeluargaOption['hubunganDgnKeluarga'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesia.hubunganDgnKeluarga.hubunganDgnKeluarga" />
                    @endforeach

                </div>

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="dataDaftarPoliRJ.anamnesia.tempatTinggal.tempatTinggal" :value="__('Tempat Tinggal')"
                        :required="__(false)" class="mr-2" />

                    @foreach ($dataDaftarPoliRJ['anamnesia']['tempatTinggal']['tempatTinggalOption'] as $tempatTinggalOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($tempatTinggalOption['tempatTinggal'])" value="{{ $tempatTinggalOption['tempatTinggal'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesia.tempatTinggal.tempatTinggal" />
                    @endforeach

                </div>
                <x-text-input id="dataDaftarPoliRJ.anamnesia.tempatTinggal.tempatTinggal"
                    placeholder="Keterangan Tempat Tinggal" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.tempatTinggal.tempatTinggal'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.tempatTinggal.keteranganTempatTinggal" />


                <x-text-input id="dataDaftarPoliRJ.anamnesia.spiritual.spiritual" placeholder="Spiritual"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.spiritual.spiritual'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.spiritual.spiritual" />

                <div class="flex items-center mt-2 ml-2">

                    <x-input-label for="dataDaftarPoliRJ.anamnesia.spiritual.spiritual" :value="__('Kebiasaan Ibadah Teratur')"
                        :required="__(false)" class="mr-2" />


                    @foreach ($dataDaftarPoliRJ['anamnesia']['spiritual']['ibadahTeraturOptions'] as $ibadahTeraturOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($ibadahTeraturOption['ibadahTeratur'])" value="{{ $ibadahTeraturOption['ibadahTeratur'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesia.ibadahTeratur.ibadahTeratur" />
                    @endforeach

                </div>

                <div class="flex items-center mt-2 ml-2">

                    <x-input-label for="dataDaftarPoliRJ.anamnesia.spiritual.nilaiKepercayaan" :value="__('Nilai Kepercayaan')"
                        :required="__(false)" class="mr-2" />


                    @foreach ($dataDaftarPoliRJ['anamnesia']['spiritual']['nilaiKepercayaanOptions'] as $nilaiKepercayaanOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($nilaiKepercayaanOption['nilaiKepercayaan'])" value="{{ $nilaiKepercayaanOption['nilaiKepercayaan'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesia.nilaiKepercayaan.nilaiKepercayaan" />
                    @endforeach

                </div>

                <x-text-input id="dataDaftarPoliRJ.anamnesia.nilaiKepercayaan.nilaiKepercayaan"
                    placeholder="Sebutkan Nilai Kepercayaan" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.nilaiKepercayaan.nilaiKepercayaan'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.spiritual.keteranganSpiritual" />



                <x-input-label for="dataDaftarPoliRJ.anamnesia.ekonomi.pengambilKeputusan" :value="__('Pengambil Keputusan')"
                    :required="__(false)" class="mr-2" />

                <x-text-input id="dataDaftarPoliRJ.anamnesia.ekonomi.pengambilKeputusan"
                    placeholder="Pengambil Keputusan" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.ekonomi.pengambilKeputusan'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.ekonomi.pengambilKeputusan" />

                <x-text-input id="dataDaftarPoliRJ.anamnesia.ekonomi.pekerjaan" placeholder="Pekerjaan"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.ekonomi.pekerjaan'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.ekonomi.pekerjaan" />

                <div class="flex items-center mt-2 ml-2">

                    @foreach ($dataDaftarPoliRJ['anamnesia']['ekonomi']['penghasilanBlnOptions'] as $penghasilanBlnOptions)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($penghasilanBlnOptions['penghasilanBln'])" value="{{ $penghasilanBlnOptions['penghasilanBln'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesia.ekonomi.penghasilanBln" />
                    @endforeach

                </div>

                <x-text-input id="dataDaftarPoliRJ.anamnesia.ekonomi.keteranganEkonomi" placeholder="Keterangan Ekonomi"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesia.ekonomi.keteranganEkonomi'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesia.ekonomi.keteranganEkonomi" />

            </div>

        </div>





    </div>
</div>
