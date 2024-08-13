<div>
    <div class="w-full mb-1">
        <div class="pt-0">

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Kondisi Fisik Umum')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['dekubitus']['kodisiFisikOptions'] as $kodisiFisikOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($kodisiFisikOptions['kodisiFisik'])" value="{{ $kodisiFisikOptions['kodisiFisik'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.dekubitus.kodisiFisik" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Kesadaran')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['dekubitus']['kesadaranOptions'] as $kesadaranOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($kesadaranOptions['kesadaran'])" value="{{ $kesadaranOptions['kesadaran'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.dekubitus.kesadaran" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Aktifitas')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['dekubitus']['aktifitasOptions'] as $aktifitasOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($aktifitasOptions['aktifitas'])" value="{{ $aktifitasOptions['aktifitas'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.dekubitus.aktifitas" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Mobilitas')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['dekubitus']['mobilitasOptions'] as $mobilitasOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($mobilitasOptions['mobilitas'])" value="{{ $mobilitasOptions['mobilitas'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.dekubitus.mobilitas" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Inkontinensia')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['dekubitus']['inkontinensiaOptions'] as $inkontinensiaOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($inkontinensiaOptions['inkontinensia'])" value="{{ $inkontinensiaOptions['inkontinensia'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.dekubitus.inkontinensia" />
                @endforeach

            </div>



            <div class="grid grid-cols-6 mt-2 ml-2">
                <x-input-label for="" :value="__('Petugas')" :required="__(false)" class="px-2" />

                <x-input-label for="" :value="__('Tanggl & Jam')" :required="__(false)" class="px-2" />

                <x-input-label for="" :value="__('Total Skor : 0')" :required="__(false)" class="px-2" />

                <x-input-label for="" :value="__('Peningkatan risiko 50x lebih besar terjadinya ulkus decubitus')" :required="__(false)" class="px-2" />

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
