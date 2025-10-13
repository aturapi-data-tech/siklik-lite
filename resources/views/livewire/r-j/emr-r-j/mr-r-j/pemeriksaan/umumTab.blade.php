<div>
    <div class="w-full mb-1">

        <div class="pt-0">

            <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.keadaanUmum" :value="__('Keadaan Umum')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.pemeriksaan.tandaVital.keadaanUmum" placeholder="Keadaan Umum"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.keadaanUmum'))" :disabled="$disabledPropertyRjStatus"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.keadaanUmum" />
                @error('dataDaftarPoliRJ.pemeriksaan.tandaVital.keadaanUmum')
                    <x-input-error :messages="$message" />
                @enderror
            </div>

            <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.tingkatKesadaran" :value="__('Tingkat Kesadaran')"
                :required="__(false)" />

            <div class="mt-1">
                <div class="flex ">
                    <x-text-input placeholder="Tingkat Kesadaran" class="sm:rounded-none sm:rounded-l-lg"
                        :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.tingkatKesadaran'))" :disabled="true"
                        value="{{ $dataDaftarPoliRJ['pemeriksaan']['tandaVital']['tingkatKesadaran'] ?? '' }}{{ ' / ' }}{{ $dataDaftarPoliRJ['pemeriksaan']['tandaVital']['tingkatKesadaranDesc'] ?? '' }}" />
                    @error('dataDaftarPoliRJ.pemeriksaan.tandaVital.tingkatKesadaran')
                        <x-input-error :messages="$message" />
                    @enderror

                    <x-green-button :disabled="$disabledPropertyRjStatus" class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                        wire:click.prevent="clicktingkatKesadaranlov()">
                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </x-green-button>
                </div>
                @include('livewire.r-j.emr-r-j.mr-r-j.pemeriksaan.list-of-value-tingkatKesadaran')
            </div>

            <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik" :value="__('Tanda Vital')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <div class="grid grid-cols-1 gap-2 pt-2">
                <!-- Kolom 1: Tekanan Darah (Sistolik & Distolik) -->
                <div class="mb-2">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik" :value="__('Tekanan Darah')"
                        :required="__(false)" />
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik"
                                placeholder="Sistolik" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik'))" :disabled="$disabledPropertyRjStatus"
                                wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik"
                                :mou_label="__('mmHg')" />
                            @error('dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik')
                                <x-input-error :messages="$message" />
                            @enderror
                        </div>
                        <div>
                            <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik"
                                placeholder="Distolik" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik'))" :disabled="$disabledPropertyRjStatus"
                                wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik"
                                :mou_label="__('mmHg')" />
                            @error('dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik')
                                <x-input-error :messages="$message" />
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 pt-2">
                <!-- Kolom 2: Frekuensi Nadi & Frekuensi Nafas -->
                <div class="mb-2">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi" :value="__('Frekuensi Nadi')"
                        :required="__(false)" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi"
                        placeholder="Frekuensi Nadi" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi"
                        :mou_label="__('X/Menit')" />
                    @error('dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>

                <div class="mb-2">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas" :value="__('Frekuensi Nafas')"
                        :required="__(false)" class="mt-2" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas"
                        placeholder="Frekuensi Nafas" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas"
                        :mou_label="__('X/Menit')" />
                    @error('dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>
            </div>

            <!-- Kolom 3: Suhu, SPO2 & GDA -->
            <div class="mb-2">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu" :value="__('Suhu')"
                    :required="__(false)" />
                <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu" placeholder="Suhu" class="mt-1 ml-2"
                    :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu'))" :disabled="$disabledPropertyRjStatus"
                    wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu" :mou_label="__('°C')" />
                @error('dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu')
                    <x-input-error :messages="$message" />
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-2 mt-2">
                <div>
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.spo2" :value="__('SPO2')"
                        :required="__(false)" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.spo2" placeholder="SPO2"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.spo2'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.spo2" :mou_label="__('%')" />
                    @error('dataDaftarPoliRJ.pemeriksaan.tandaVital.spo2')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>
                <div>
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.gda" :value="__('GDA')"
                        :required="__(false)" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.gda" placeholder="GDA"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.gda'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.gda" :mou_label="__('g/dl')" />
                    @error('dataDaftarPoliRJ.pemeriksaan.tandaVital.gda')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>
            </div>

            <x-input-label for="dataDaftarPoliRJ.pemeriksaan.nutrisi.bb" :value="__('Nutrisi')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <div class="grid grid-cols-3 gap-2 pt-2">

                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.nutrisi.bb" :value="__('Berat Badan')"
                        :required="__(false)" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.nutrisi.bb" placeholder="Berat Badan"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.nutrisi.bb'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.nutrisi.bb" :mou_label="__('Kg')" />
                    @error('dataDaftarPoliRJ.pemeriksaan.nutrisi.bb')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>

                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.nutrisi.tb" :value="__('Tinggi Badan')"
                        :required="__(false)" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.nutrisi.tb" placeholder="Tinggi Badan"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.nutrisi.tb'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.nutrisi.tb" :mou_label="__('Cm')" />
                    @error('dataDaftarPoliRJ.pemeriksaan.nutrisi.tb')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>

                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.nutrisi.imt" :value="__('Index Masa Tubuh')"
                        :required="__(false)" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.nutrisi.imt" placeholder="Index Masa Tubuh"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.nutrisi.imt'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.nutrisi.imt" :mou_label="__('Kg/M2')" />
                    @error('dataDaftarPoliRJ.pemeriksaan.nutrisi.imt')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>

            </div>

            <div class="grid grid-cols-3 gap-2 pt-2">
                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.nutrisi.lk" :value="__('Lingkar Kepala')"
                        :required="__(false)" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.nutrisi.lk" placeholder="Lingkar Kepala"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.nutrisi.lk'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.nutrisi.lk" :mou_label="__('Cm')" />
                    @error('dataDaftarPoliRJ.pemeriksaan.nutrisi.lk')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>

                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.nutrisi.lila" :value="__('Lingkar Lengan Atas')"
                        :required="__(false)" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.nutrisi.lila" placeholder="Lingkar Lengan Atas"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.nutrisi.lila'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.nutrisi.lila" :mou_label="__('Cm')" />
                    @error('dataDaftarPoliRJ.pemeriksaan.nutrisi.lila')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>

                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.nutrisi.liPerut" :value="__('Lingkar Perut')"
                        :required="__(false)" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.nutrisi.liPerut" placeholder="Lingkar Perut"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.nutrisi.liPerut'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.nutrisi.liPerut" :mou_label="__('Cm')" />
                    @error('dataDaftarPoliRJ.pemeriksaan.nutrisi.liPerut')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>
            </div>

            <x-input-label for="dataDaftarPoliRJ.pemeriksaan.fungsional.bb" :value="__('Fungsional')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <div class="grid grid-cols-3 gap-2 pt-2">

                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.fungsional.alatBantu" :value="__('Alat Bantu')"
                        :required="__(false)" />
                    <x-text-input id="dataDaftarPoliRJ.pemeriksaan.fungsional.alatBantu" placeholder="Alat Bantu"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.fungsional.alatBantu'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.fungsional.alatBantu" />
                    @error('dataDaftarPoliRJ.pemeriksaan.fungsional.alatBantu')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>

                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.fungsional.prothesa" :value="__('Prothesa')"
                        :required="__(false)" />
                    <x-text-input id="dataDaftarPoliRJ.pemeriksaan.fungsional.prothesa" placeholder="Prothesa"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.fungsional.prothesa'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.fungsional.prothesa" />
                    @error('dataDaftarPoliRJ.pemeriksaan.fungsional.prothesa')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>

                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.fungsional.cacatTubuh" :value="__('Cacat Tubuh')"
                        :required="__(false)" />
                    <x-text-input id="dataDaftarPoliRJ.pemeriksaan.fungsional.cacatTubuh" placeholder="Cacat Tubuh"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.fungsional.cacatTubuh'))" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.fungsional.cacatTubuh" />
                    @error('dataDaftarPoliRJ.pemeriksaan.fungsional.cacatTubuh')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>

            </div>

            <div class="mb-2 ">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.suspekAkibatKerja.KeteranganSuspekAkibatKerja"
                    :value="__('Suspek Penyakit Akibat Kecelakaan Kerja')" :required="__(false)" />

                <div class="grid grid-cols-3 gap-2 mb-2">
                    @isset($dataDaftarPoliRJ['pemeriksaan']['suspekAkibatKerja']['suspekAkibatKerjaOptions'])
                        @foreach ($dataDaftarPoliRJ['pemeriksaan']['suspekAkibatKerja']['suspekAkibatKerjaOptions'] as $suspekAkibatKerjaOptions)
                            <x-radio-button :label="__($suspekAkibatKerjaOptions['suspekAkibatKerja'])"
                                value="{{ $suspekAkibatKerjaOptions['suspekAkibatKerja'] }}"
                                wire:model="dataDaftarPoliRJ.pemeriksaan.suspekAkibatKerja.suspekAkibatKerja" />
                        @endforeach
                    @endisset

                    <x-text-input id="dataDaftarPoliRJ.pemeriksaan.suspekAkibatKerja.keteranganSuspekAkibatKerja"
                        placeholder="Keterangan" class="mt-1 ml-2" :errorshas="__(
                            $errors->has('dataDaftarPoliRJ.pemeriksaan.suspekAkibatKerja.keteranganSuspekAkibatKerja'),
                        )" :disabled="$disabledPropertyRjStatus"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.suspekAkibatKerja.keteranganSuspekAkibatKerja" />
                    @error('dataDaftarPoliRJ.pemeriksaan.suspekAkibatKerja.keteranganSuspekAkibatKerja')
                        <x-input-error :messages="$message" />
                    @enderror
                </div>

            </div>

        </div>

    </div>
</div>
