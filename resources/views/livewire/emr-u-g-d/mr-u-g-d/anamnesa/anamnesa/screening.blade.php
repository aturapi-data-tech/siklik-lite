<div>
    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp
    {{-- jika anamnesa kosong ngak usah di render --}}
    @if (isset($dataDaftarUgd['screening']))
        <div class="m-4 mb-1 -300 ">

            <div class="px-4 overflow-auto bg-white snap-mandatory snap-y">
                <div>
                    <x-input-label for="dataDaftarUgd.screening.keluhanUtama" :value="__('Keluhan Utama')" :required="__(true)"
                        class="pt-2 sm:text-xl" />

                    <div class="mb-2 ">
                        <x-text-input-area id="dataDaftarUgd.screening.keluhanUtama" placeholder="Keluhan Utama"
                            class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.screening.keluhanUtama'))" :disabled=$disabledPropertyRjStatus :rows=7
                            wire:model.debounce.500ms="dataDaftarUgd.screening.keluhanUtama" />

                    </div>
                    @error('dataDaftarUgd.screening.keluhanUtama')
                        <x-input-error :messages=$message />
                    @enderror
                </div>



                <div>
                    <x-input-label for="dataDaftarUgd.screening.pernafasan" :value="__('Pernafasan')" :required="__(true)"
                        class="px-2 pt-2 sm:text-xl" />

                    <div class="grid grid-cols-2 gap-2 mt-2 ml-2">

                        @foreach ($dataDaftarUgd['screening']['pernafasanOptions'] as $pernafasanOption)
                            {{-- @dd($sRj) --}}
                            <x-radio-button :label="__($pernafasanOption['pernafasan'])" value="{{ $pernafasanOption['pernafasan'] }}"
                                wire:model="dataDaftarUgd.screening.pernafasan" />
                        @endforeach

                        @error('dataDaftarUgd.screening.pernafasan')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>
                </div>

                <div>
                    <x-input-label for="dataDaftarUgd.screening.kesadaran" :value="__('Kesadaran')" :required="__(true)"
                        class="px-2 pt-2 sm:text-xl" />

                    <div class="grid grid-cols-4 gap-2 mt-2 ml-2">

                        @foreach ($dataDaftarUgd['screening']['kesadaranOptions'] as $kesadaranOption)
                            {{-- @dd($sRj) --}}
                            <x-radio-button :label="__($kesadaranOption['kesadaran'])" value="{{ $kesadaranOption['kesadaran'] }}"
                                wire:model="dataDaftarUgd.screening.kesadaran" />
                        @endforeach

                        @error('dataDaftarUgd.screening.kesadaran')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>
                </div>

                <div>
                    <x-input-label for="dataDaftarUgd.screening.nyeriDada" :value="__('Nyeri Dada')" :required="__(true)"
                        class="px-2 pt-2 sm:text-xl" />

                    <div class="grid grid-cols-2 gap-2 mt-2 ml-2">

                        @foreach ($dataDaftarUgd['screening']['nyeriDadaOptions'] as $nyeriDadaOption)
                            {{-- @dd($sRj) --}}
                            <x-radio-button :label="__($nyeriDadaOption['nyeriDada'])" value="{{ $nyeriDadaOption['nyeriDada'] }}"
                                wire:model="dataDaftarUgd.screening.nyeriDada" />
                        @endforeach

                        @error('dataDaftarUgd.screening.nyeriDada')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>
                </div>

                @if ($dataDaftarUgd['screening']['nyeriDada'] === 'Ada')
                    <div>
                        <x-input-label for="dataDaftarUgd.screening.nyeriDadaTingkat" :value="__('Nyeri Dada (Tingkat Nyeri)')"
                            :required="__(true)" class="px-2 pt-2 sm:text-xl" />

                        <div class="grid grid-cols-3 gap-2 mt-2 ml-2">

                            @foreach ($dataDaftarUgd['screening']['nyeriDadaTingkatOptions'] as $nyeriDadaTingkatOption)
                                {{-- @dd($sRj) --}}
                                <x-radio-button :label="__($nyeriDadaTingkatOption['nyeriDadaTingkat'])"
                                    value="{{ $nyeriDadaTingkatOption['nyeriDadaTingkat'] }}"
                                    wire:model="dataDaftarUgd.screening.nyeriDadaTingkat" />
                            @endforeach

                            @error('dataDaftarUgd.screening.nyeriDadaTingkat')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>
                @endif

                <div>
                    <x-input-label for="dataDaftarUgd.screening.prioritasPelayanan" :value="__('Nyeri Dada (Tingkat Nyeri)')"
                        :required="__(true)" class="px-2 pt-2 sm:text-xl" />

                    <div class="grid grid-cols-4 gap-2 mt-2 ml-2">

                        @foreach ($dataDaftarUgd['screening']['prioritasPelayananOptions'] as $prioritasPelayananOption)
                            {{-- @dd($sRj) --}}
                            <x-radio-button :label="__($prioritasPelayananOption['prioritasPelayanan'])"
                                value="{{ $prioritasPelayananOption['prioritasPelayanan'] }}"
                                wire:model="dataDaftarUgd.screening.prioritasPelayanan" />
                        @endforeach

                        @error('dataDaftarUgd.screening.prioritasPelayanan')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>
                </div>


                <div class="mb-2 ">
                    <x-input-label for="dataDaftarUgd.screening.tanggalPelayanan" :value="__('Tanggal Pelayanan')"
                        :required="__(false)" />
                    <div class="grid grid-cols-1 gap-0">
                        <x-text-input id="dataDaftarUgd.screening.tanggalPelayanan"
                            placeholder="Tanggal Pelayanan [dd/mm/yyyy]" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.screening.tanggalPelayanan'))"
                            :disabled=$disabledPropertyRjStatus
                            wire:model.debounce.500ms="dataDaftarUgd.screening.tanggalPelayanan" />
                    </div>
                </div>

                <div class="mb-2 ">
                    <x-input-label for="dataDaftarUgd.screening.petugasPelayanan" :value="__('Petugas Pelayanan')"
                        :required="__(false)" />
                    <div class="grid grid-cols-1 gap-0">
                        <x-text-input id="dataDaftarUgd.screening.petugasPelayanan" placeholder="Petugas Pelayanan"
                            class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.screening.petugasPelayanan'))" :disabled=$disabledPropertyRjStatus
                            wire:model.debounce.500ms="dataDaftarUgd.screening.petugasPelayanan" />
                    </div>
                </div>


                <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6">

                    <div class=>
                        <div wire:loading wire:target="resetScreening">
                            <x-loading />
                        </div>

                        <x-light-button :disabled=false wire:click.prevent="resetScreening()" type="button"
                            wire:loading.remove>
                            Reset Screening
                        </x-light-button>
                    </div>

                    <div>
                        <div wire:loading wire:target="store">
                            <x-loading />
                        </div>

                        <x-green-button :disabled=false wire:click.prevent="store()" type="button" wire:loading.remove>
                            Simpan
                        </x-green-button>
                    </div>
                </div>

            </div>

        </div>
    @endif
</div>
