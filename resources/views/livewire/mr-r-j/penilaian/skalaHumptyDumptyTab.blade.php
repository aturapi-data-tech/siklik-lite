<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <div class="mb-2 ">
                <x-input-label for="" :value="__('Umur')" :required="__(false)" class="px-2" />
                <x-text-input id="" placeholder="" class="mt-1 ml-2" :errorshas="__($errors->has(''))" :disabled=true
                    wire:model.debounce.500ms="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaHumptyDumpty.skalaHumptyDumptyket" />
            </div>

            <div class="mb-2 ">
                <x-input-label for="" :value="__('Jenis Kelamin')" :required="__(false)" class="px-2" />
                <x-text-input id="" placeholder="" class="mt-1 ml-2" :errorshas="__($errors->has(''))" :disabled=true
                    wire:model.debounce.500ms="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaHumptyDumpty.skalaHumptyDumptysex" />
            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Diagnosa')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['diagnosaOptions'] as $diagnosaOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($diagnosaOptions['diagnosa'])" value="{{ $diagnosaOptions['diagnosa'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaHumptyDumpty.diagnosa" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Gangguan Kognitif')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['gangguanKognitifOptions'] as $gangguanKognitifOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($gangguanKognitifOptions['gangguanKognitif'])" value="{{ $gangguanKognitifOptions['gangguanKognitif'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaHumptyDumpty.gangguanKognitif" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Faktor Lingkungan')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['faktorLingkunganOptions'] as $faktorLingkunganOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($faktorLingkunganOptions['faktorLingkungan'])" value="{{ $faktorLingkunganOptions['faktorLingkungan'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaHumptyDumpty.faktorLingkungan" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Penggunaan Obat')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['penggunaanObatOptions'] as $penggunaanObatOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($penggunaanObatOptions['penggunaanObat'])" value="{{ $penggunaanObatOptions['penggunaanObat'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaHumptyDumpty.penggunaanObat" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2 ">
                <x-input-label for="" :value="__('Respon Terhadap Operasi / Obat Penenang/ Efek Anastesi')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['responTerhadapOperasiOptions'] as $responTerhadapOperasiOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($responTerhadapOperasiOptions['responTerhadapOperasi'])"
                        value="{{ $responTerhadapOperasiOptions['responTerhadapOperasi'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaHumptyDumpty.responTerhadapOperasi" />
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


            </div>





        </div>




    </div>


</div>
