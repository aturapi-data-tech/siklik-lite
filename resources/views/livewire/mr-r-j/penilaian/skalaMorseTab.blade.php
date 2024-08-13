<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Riwayat Jatuh (Baru Saja / 3 Bulan Terakhir)')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['riwayatJatuh3blnTerakhirOptions'] as $riwayatJatuh3blnTerakhirOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($riwayatJatuh3blnTerakhirOptions['riwayatJatuh3blnTerakhir'])"
                        value="{{ $riwayatJatuh3blnTerakhirOptions['riwayatJatuh3blnTerakhir'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.riwayatJatuh3blnTerakhir" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Diagnosa Lain / Diagnosa Sekunder')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['diagSekunderOptions'] as $diagSekunderOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($diagSekunderOptions['diagSekunder'])" value="{{ $diagSekunderOptions['diagSekunder'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.diagSekunder" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Alat Bantu')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['alatBantuOptions'] as $alatBantuOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($alatBantuOptions['alatBantu'])" value="{{ $alatBantuOptions['alatBantu'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.alatBantu" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Heparin')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['heparinOptions'] as $heparinOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($heparinOptions['heparin'])" value="{{ $heparinOptions['heparin'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.heparin" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Gaya Berjalan')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['gayaBerjalanOptions'] as $gayaBerjalanOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($gayaBerjalanOptions['gayaBerjalan'])" value="{{ $gayaBerjalanOptions['gayaBerjalan'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.gayaBerjalan" />
                @endforeach

            </div>

            <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Kesadaran')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['kesadaranOptions'] as $kesadaranOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($kesadaranOptions['kesadaran'])" value="{{ $kesadaranOptions['kesadaran'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.kesadaran" />
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
