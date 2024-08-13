<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <x-input-label for="dataDaftarPoliRJ.penilaian.nyeri.nyeri" :value="__('Nyeri')" :required="__(false)"
                class="pt-2 sm:text-xl" />


            <div class="pt-2 ">

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="" :value="__('Nyeri')" :required="__(false)" class="px-2" />

                    @foreach ($dataDaftarPoliRJ['penilaian']['nyeri']['nyeriOptions'] as $nyeriOptions)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($nyeriOptions['nyeri'])" value="{{ $nyeriOptions['nyeri'] }}"
                            wire:model="dataDaftarPoliRJ.penilaian.nyeri.nyeri" />
                    @endforeach

                    @foreach ($dataDaftarPoliRJ['penilaian']['nyeri']['nyeriKetOptions'] as $nyeriKetOptions)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($nyeriKetOptions['nyeriKet'])" value="{{ $nyeriKetOptions['nyeriKet'] }}"
                            wire:model="dataDaftarPoliRJ.penilaian.nyeriKet.nyeriKet" />
                    @endforeach

                </div>



            </div>

            <div class="pt-2 ">

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="" :value="__('Metode')" :required="__(false)" class="px-2" />

                    @foreach ($dataDaftarPoliRJ['penilaian']['nyeri']['nyeriMetodeOptions'] as $edukasiOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($edukasiOption['nyeriMetode'])" value="{{ $edukasiOption['nyeriMetode'] }}"
                            wire:model="dataDaftarPoliRJ.penilaian.nyeri.nyeriMetode" />
                    @endforeach
                </div>

            </div>

            <div class="pt-2 ">

                <div class="mt-2 ml-2">
                    <x-input-label for="dataDaftarPoliRJ.penilaian.nyeri.skalaNyeri" :value="__('Skala Nyeri')"
                        :required="__(false)" class="px-2" />

                    <x-text-input id="dataDaftarPoliRJ.penilaian.nyeri.skalaNyeri" placeholder="Skala Nyeri"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.penilaian.nyeri.skalaNyeri'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.penilaian.nyeri.skalaNyeri" />
                </div>

            </div>

            <div class="pt-2 ">

                <div class="mt-2 ml-2 ">
                    <x-input-label for="dataDaftarPoliRJ.penilaian.nyeri.pencetus" :value="__('Pencetus')" :required="__(false)"
                        class="px-2" />

                    <x-text-input id="dataDaftarPoliRJ.penilaian.nyeri.pencetus" placeholder="Pencetus"
                        class="mt-1 ml-2 " :errorshas="__($errors->has('dataDaftarPoliRJ.penilaian.nyeri.pencetus'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.penilaian.nyeri.pencetus" />
                </div>

                <div class="mt-2 ml-2 ">
                    <x-input-label for="dataDaftarPoliRJ.penilaian.nyeri.gambar" :value="__('Gambar')" :required="__(false)"
                        class="px-2" />

                    <x-text-input id="dataDaftarPoliRJ.penilaian.nyeri.gambar" placeholder="Gambar" class="mt-1 ml-2 "
                        :errorshas="__($errors->has('dataDaftarPoliRJ.penilaian.nyeri.gambar'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.penilaian.nyeri.gambar" />
                </div>

                <div class="mt-2 ml-2 ">
                    <x-input-label for="dataDaftarPoliRJ.penilaian.nyeri.durasi" :value="__('Durasi')" :required="__(false)"
                        class="px-2" />

                    <x-text-input id="dataDaftarPoliRJ.penilaian.nyeri.durasi" placeholder="Durasi" class="mt-1 ml-2 "
                        :errorshas="__($errors->has('dataDaftarPoliRJ.penilaian.nyeri.durasi'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.penilaian.nyeri.durasi" />
                </div>

                <div class="mt-2 ml-2 ">
                    <x-input-label for="dataDaftarPoliRJ.penilaian.nyeri.lokasi" :value="__('Lokasi')" :required="__(false)"
                        class="px-2" />

                    <x-text-input id="dataDaftarPoliRJ.penilaian.nyeri.lokasi" placeholder="Lokasi" class="mt-1 ml-2 "
                        :errorshas="__($errors->has('dataDaftarPoliRJ.penilaian.nyeri.lokasi'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.penilaian.nyeri.lokasi" />
                </div>

            </div>

            <div class="grid grid-cols-6">
                <div class="mt-2 ">
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
