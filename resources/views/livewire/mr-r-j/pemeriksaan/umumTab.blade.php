<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.keadaanUmum" :value="__('Tanda Vital')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.keadaanUmum" :value="__('Keadaan Umum')"
                :required="__(false)" />

            <div class="mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.pemeriksaan.tandaVital.keadaanUmum" placeholder="Keadaan Umum"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.keadaanUmum'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.keadaanUmum" />

            </div>

            <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.tingkatKesadaran" :value="__('Tingkat Kesadaran')"
                :required="__(false)" />

            <div class="mt-1">
                <div class="flex ">
                    <x-text-input placeholder="Tingkat Kesadaran" class="sm:rounded-none sm:rounded-l-lg"
                        :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.tingkatKesadaran'))" :disabled=true
                        value="{{ $dataDaftarPoliRJ['pemeriksaan']['tandaVital']['tingkatKesadaran'] }}" />



                    <x-green-button :disabled=$disabledPropertyRjStatus
                        class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                        wire:click.prevent="clicktingkatKesadaranlov()">
                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </x-green-button>
                </div>
                {{-- LOV tingkatKesadaran --}}
                @include('livewire.mr-r-j.pemeriksaan.list-of-value-tingkatKesadaran')
            </div>

            <div class="grid grid-cols-4 gap-2 my-2">
                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.e" :value="__('E [Eye]')"
                        :required="__(false)" />
                    <x-text-input id="dataDaftarPoliRJ.pemeriksaan.tandaVital.e" placeholder="E [Eye]" class="mt-1 ml-2"
                        :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.e'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.e" />
                </div>

                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.m" :value="__('M [Motorik]')"
                        :required="__(false)" />
                    <x-text-input id="dataDaftarPoliRJ.pemeriksaan.tandaVital.m" placeholder="M [Motorik]"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.m'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.m" />
                </div>

                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.v" :value="__('V [Verbal]')"
                        :required="__(false)" />
                    <x-text-input id="dataDaftarPoliRJ.pemeriksaan.tandaVital.v" placeholder="V [Verbal]"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.v'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.v" />
                </div>

                <div class="mb-2 ">
                    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.gcs" :value="__('GCS')"
                        :required="__(false)" />
                    <x-text-input id="dataDaftarPoliRJ.pemeriksaan.tandaVital.gcs" placeholder="GCS" class="mt-1 ml-2"
                        :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.gcs'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.gcs" />
                </div>
            </div>

            <div class="mb-2 ">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik" :value="__('Tekanan Darah')"
                    :required="__(false)" />
                <div class="grid grid-cols-2 gap-2">
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik" placeholder="Sistolik"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik'))" :disabled=$disabledPropertyRjStatus :mou_label="__('mmHg')"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.sistolik" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik" placeholder="Distolik"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik'))" :disabled=$disabledPropertyRjStatus :mou_label="__('mmHg')"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.distolik" />
                </div>
            </div>

            <div class="mb-2 ">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas" :value="__('Frekuensi Nafas / Frekuensi Nadi')"
                    :required="__(false)" />
                <div class="grid grid-cols-2 gap-2">
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas"
                        placeholder="Frekuensi Nafas" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas'))"
                        :disabled=$disabledPropertyRjStatus :mou_label="__('X/Menit')"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNafas" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi"
                        placeholder="Frekuensi Nadi" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi'))"
                        :disabled=$disabledPropertyRjStatus :mou_label="__('X/Menit')"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.frekuensiNadi" />
                </div>
            </div>

            <div class="mb-2 ">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu" :value="__('Suhu / Saturasi O2')"
                    :required="__(false)" />
                <div class="grid grid-cols-2 gap-2">
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu" placeholder="Suhu"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu'))" :disabled=$disabledPropertyRjStatus :mou_label="__('0C')"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.suhu" />
                    <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.tandaVital.saturasiO2" placeholder="Saturasi O2"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.saturasiO2'))" :disabled=$disabledPropertyRjStatus :mou_label="__('Saturasi O2 ')"
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.saturasiO2" />
                </div>
            </div>

            <div class="mb-2 ">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.tandaVital.waktuPemeriksaan" :value="__('Waktu Pemeriksaan')"
                    :required="__(false)" />
                <div class="grid grid-cols-1 gap-0">
                    <x-text-input id="dataDaftarPoliRJ.pemeriksaan.tandaVital.waktuPemeriksaan"
                        placeholder="Waktu Pemeriksaan [dd/mm/yyyy hh24:mi:ss]" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.tandaVital.waktuPemeriksaan'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.tandaVital.waktuPemeriksaan" />
                </div>
            </div>



        </div>



        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.nutrisi.bb" :value="__('Nutrisi')" :required="__(false)"
            class="pt-2 sm:text-xl" />

        <div class="grid grid-cols-4 gap-2 pt-2">

            <div class="mb-2 ">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.nutrisi.bb" :value="__('Berat Badan')" :required="__(false)" />
                <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.nutrisi.bb" placeholder="Berat Badan"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.nutrisi.bb'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.nutrisi.bb" :mou_label="__('Kg')" />

            </div>

            <div class="mb-2 ">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.nutrisi.tb" :value="__('Tinggi Badan')" :required="__(false)" />
                <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.nutrisi.tb" placeholder="Tinggi Badan"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.nutrisi.tb'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.nutrisi.tb" :mou_label="__('Cm')" />

            </div>

            <div class="mb-2 ">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.nutrisi.imt" :value="__('Index Masa Tubuh')" :required="__(false)" />
                <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.nutrisi.imt" placeholder="Index Masa Tubuh"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.nutrisi.imt'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.nutrisi.imt" :mou_label="__('-')" />

            </div>

            <div class="mb-2 ">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.nutrisi.lk" :value="__('Lingkar Kepala')" :required="__(false)" />
                <x-text-input-mou id="dataDaftarPoliRJ.pemeriksaan.nutrisi.lk" placeholder="Lingkar Kepala"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.nutrisi.lk'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.nutrisi.lk" :mou_label="__('Cm')" />

            </div>

        </div>

        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.fungsional.bb" :value="__('Fungsional')" :required="__(false)"
            class="pt-2 sm:text-xl" />

        <div class="grid grid-cols-3 gap-2 pt-2">



            <div class="mb-2 ">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.fungsional.alatBantu" :value="__('Alat Bantu')"
                    :required="__(false)" />
                <x-text-input id="dataDaftarPoliRJ.pemeriksaan.fungsional.alatBantu" placeholder="Alat Bantu"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.fungsional.alatBantu'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.fungsional.alatBantu" />

            </div>

            <div class="mb-2 ">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.fungsional.prothesa" :value="__('Prothesa')"
                    :required="__(false)" />
                <x-text-input id="dataDaftarPoliRJ.pemeriksaan.fungsional.prothesa" placeholder="Prothesa"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.fungsional.prothesa'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.fungsional.prothesa" />

            </div>

            <div class="mb-2 ">
                <x-input-label for="dataDaftarPoliRJ.pemeriksaan.fungsional.cacatTubuh" :value="__('Cacat Tubuh')"
                    :required="__(false)" />
                <x-text-input id="dataDaftarPoliRJ.pemeriksaan.fungsional.cacatTubuh" placeholder="Cacat Tubuh"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.fungsional.cacatTubuh'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.fungsional.cacatTubuh" />

            </div>






        </div>



    </div>


</div>
