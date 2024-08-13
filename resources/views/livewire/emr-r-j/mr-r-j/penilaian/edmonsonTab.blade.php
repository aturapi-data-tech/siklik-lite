<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <div class="mb-2 ">
                <x-input-label for="" :value="__('Usia')" :required="__(false)" class="px-2" />
                <x-text-input id="" placeholder="" class="mt-1 ml-2" :errorshas="__($errors->has(''))" :disabled=true
                    wire:model.debounce.500ms="dataDaftarPoliRJ.penilaian.resikoJatuh.edmonson.edmonsonUsia" />
            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Status Mental')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['statusMentalOptions'] as $statusMentalOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($statusMentalOptions['statusMental'])" value="{{ $statusMentalOptions['statusMental'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.edmonson.statusMental" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Eliminasi')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['eliminasiOptions'] as $eliminasiOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($eliminasiOptions['eliminasi'])" value="{{ $eliminasiOptions['eliminasi'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.edmonson.eliminasi" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Medikasi')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['medikasiOptions'] as $medikasiOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($medikasiOptions['medikasi'])" value="{{ $medikasiOptions['medikasi'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.edmonson.medikasi" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Diagnosis')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['diagnosisOptions'] as $diagnosisOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($diagnosisOptions['diagnosis'])" value="{{ $diagnosisOptions['diagnosis'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.edmonson.diagnosis" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Ambulasi / Keseimbangan')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['ambulasiOptions'] as $ambulasiOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($ambulasiOptions['ambulasi'])" value="{{ $ambulasiOptions['ambulasi'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.edmonson.ambulasi" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Nutrisi')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['nutrisiOptions'] as $nutrisiOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($nutrisiOptions['nutrisi'])" value="{{ $nutrisiOptions['nutrisi'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.edmonson.nutrisi" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Ganguan Tidur')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['ganguanTidurOptions'] as $ganguanTidurOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($ganguanTidurOptions['ganguanTidur'])" value="{{ $ganguanTidurOptions['ganguanTidur'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.edmonson.ganguanTidur" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Riwayat Jatuh')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['riwayatJatuhOptions'] as $riwayatJatuhOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($riwayatJatuhOptions['riwayatJatuh'])" value="{{ $riwayatJatuhOptions['riwayatJatuh'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.edmonson.riwayatJatuh" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Faktor Lingkungan')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['faktorLingkunganOptions'] as $faktorLingkunganOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($faktorLingkunganOptions['faktorLingkungan'])" value="{{ $faktorLingkunganOptions['faktorLingkungan'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.edmonson.faktorLingkungan" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Penggunaan Obat')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['penggunaanObatOptions'] as $penggunaanObatOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($penggunaanObatOptions['penggunaanObat'])" value="{{ $penggunaanObatOptions['penggunaanObat'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.edmonson.penggunaanObat" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Respon Terhadap Operasi')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['responTerhadapOperasiOptions'] as $responTerhadapOperasiOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($responTerhadapOperasiOptions['responTerhadapOperasi'])"
                        value="{{ $responTerhadapOperasiOptions['responTerhadapOperasi'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.edmonson.responTerhadapOperasi" />
                @endforeach

            </div>

            <div class="grid grid-cols-6 mt-2 ml-2">
                <x-input-label for="" :value="__('Petugas')" :required="__(false)" class="px-2" />

                <x-input-label for="" :value="__('Tanggl & Jam')" :required="__(false)" class="px-2" />

                <x-input-label for="" :value="__('Total Skor : 0')" :required="__(false)" class="px-2" />

                <x-input-label for="" :value="__('Resiko Rendah | Tidak ada tindakan')" :required="__(false)" class="px-2" />

                <div class="mb-2 ">

                    <x-text-input id="" placeholder="" class="mt-1 ml-2" :errorshas="__($errors->has(''))" :disabled=true
                        wire:model.debounce.500ms="" />
                </div>

                {{-- <div class="mb-2 ">
                    <x-text-input id="" placeholder="" class="mt-1 ml-2" :errorshas="__($errors->has(''))" :disabled=true
                        wire:model.debounce.500ms="" />
                </div> --}}

                {{-- <div class="mb-2 ">
                    <x-text-input id="" placeholder="" class="mt-1 ml-2" :errorshas="__($errors->has(''))" :disabled=true
                        wire:model.debounce.500ms="" />
                </div> --}}

                {{-- <div class="mb-2 ">
                    <x-text-input id="" placeholder="" class="mt-1 ml-2" :errorshas="__($errors->has(''))" :disabled=true
                        wire:model.debounce.500ms="" />
                </div>

                <div class="mb-2 ">
                    <x-text-input id="" placeholder="" class="mt-1 ml-2" :errorshas="__($errors->has(''))" :disabled=true
                        wire:model.debounce.500ms="" />
                </div> --}}
            </div>





        </div>




    </div>


</div>
