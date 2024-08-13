<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <x-input-label for="dataDaftarUgd.penilaian.nyeri.nyeri" :value="__('Nyeri')" :required="__(false)"
                class="pt-2 sm:text-xl" />



            <div class="flex justify-center">
                <img src="/pain_scale_level.jpg" class="object-fill w-1/2 h-auto">
            </div>
            {{-- vas --}}
            <div class="pt-2 ">

                <div class="grid grid-cols-11 gap-2 mt-2 ml-2">
                    @foreach ($dataDaftarUgd['penilaian']['nyeri']['vas']['vasOptions'] as $vasOptions)
                        @php
                            $vasColor = $vasOptions['vas'] >= 0 && $vasOptions['vas'] <= 3 ? 'bg-blue-300' : ($vasOptions['vas'] >= 4 && $vasOptions['vas'] <= 7 ? 'bg-yellow-300' : 'bg-red-300');
                        @endphp

                        <x-radio-button :label="__($vasOptions['vas'])" value="{{ $vasOptions['vas'] }}"
                            wire:model="dataDaftarUgd.penilaian.nyeri.vas.vas" class="{{ $vasColor }}" />
                    @endforeach

                </div>
            </div>

            {{-- <div class="pt-2 ">

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="" :value="__('Nyeri')" :required="__(false)" class="px-2" />

                    @foreach ($dataDaftarUgd['penilaian']['nyeri']['nyeriOptions'] as $nyeriOptions)
                        <x-radio-button :label="__($nyeriOptions['nyeri'])" value="{{ $nyeriOptions['nyeri'] }}"
                            wire:model="dataDaftarUgd.penilaian.nyeri.nyeri" />
                    @endforeach

                    @foreach ($dataDaftarUgd['penilaian']['nyeri']['nyeriKetOptions'] as $nyeriKetOptions)
                        <x-radio-button :label="__($nyeriKetOptions['nyeriKet'])" value="{{ $nyeriKetOptions['nyeriKet'] }}"
                            wire:model="dataDaftarUgd.penilaian.nyeriKet.nyeriKet" />
                    @endforeach

                </div>



            </div> --}}

            {{-- <div class="pt-2 ">

                <div class="flex items-center mt-2 ml-2">
                    <x-input-label for="" :value="__('Metode')" :required="__(false)" class="px-2" />

                    @foreach ($dataDaftarUgd['penilaian']['nyeri']['nyeriMetodeOptions'] as $edukasiOption)
                        <x-radio-button :label="__($edukasiOption['nyeriMetode'])" value="{{ $edukasiOption['nyeriMetode'] }}"
                            wire:model="dataDaftarUgd.penilaian.nyeri.nyeriMetode" />
                    @endforeach
                </div>

            </div> --}}

            {{-- <div class="pt-2 ">

                <div class="mt-2 ml-2">
                    <x-input-label for="dataDaftarUgd.penilaian.nyeri.skalaNyeri" :value="__('Skala Nyeri')" :required="__(false)"
                        class="px-2" />

                    <x-text-input id="dataDaftarUgd.penilaian.nyeri.skalaNyeri" placeholder="Skala Nyeri"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.penilaian.nyeri.skalaNyeri'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.penilaian.nyeri.skalaNyeri" />
                </div>

            </div> --}}

            <div class="pt-2 ">

                <div class="mt-2 ml-2 ">
                    <x-input-label for="dataDaftarUgd.penilaian.nyeri.pencetus" :value="__('Pencetus')" :required="__(false)"
                        class="px-2" />

                    <x-text-input id="dataDaftarUgd.penilaian.nyeri.pencetus" placeholder="Pencetus" class="mt-1 ml-2 "
                        :errorshas="__($errors->has('dataDaftarUgd.penilaian.nyeri.pencetus'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.penilaian.nyeri.pencetus" />
                </div>

                {{-- <div class="mt-2 ml-2 ">
                    <x-input-label for="dataDaftarUgd.penilaian.nyeri.gambar" :value="__('Gambar')" :required="__(false)"
                        class="px-2" />

                    <x-text-input id="dataDaftarUgd.penilaian.nyeri.gambar" placeholder="Gambar" class="mt-1 ml-2 "
                        :errorshas="__($errors->has('dataDaftarUgd.penilaian.nyeri.gambar'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.penilaian.nyeri.gambar" />
                </div> --}}

                <div class="mt-2 ml-2 ">
                    <x-input-label for="dataDaftarUgd.penilaian.nyeri.durasi" :value="__('Durasi')" :required="__(false)"
                        class="px-2" />

                    <x-text-input id="dataDaftarUgd.penilaian.nyeri.durasi" placeholder="Durasi" class="mt-1 ml-2 "
                        :errorshas="__($errors->has('dataDaftarUgd.penilaian.nyeri.durasi'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.penilaian.nyeri.durasi" />
                </div>

                <div class="mt-2 ml-2 ">
                    <x-input-label for="dataDaftarUgd.penilaian.nyeri.lokasi" :value="__('Lokasi')" :required="__(false)"
                        class="px-2" />

                    <x-text-input id="dataDaftarUgd.penilaian.nyeri.lokasi" placeholder="Lokasi" class="mt-1 ml-2 "
                        :errorshas="__($errors->has('dataDaftarUgd.penilaian.nyeri.lokasi'))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.penilaian.nyeri.lokasi" />
                </div>

            </div>







        </div>




    </div>


</div>
