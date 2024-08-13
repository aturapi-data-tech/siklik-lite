<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <div class="flex justify-between my-4">
                @php
                    $mySkalaMoresColor = $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseScore'] >= 0 && $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseScore'] <= 24 ? 'text-green-500' : ($this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseScore'] >= 25 && $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseScore'] <= 50 ? 'text-yellow-400' : 'text-red-500');
                @endphp
                <p class="text-2xl font-bold {{ $mySkalaMoresColor }}">
                    {{ 'Total Skor :  ' . $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseScore'] }}
                    /
                    {{ isset($this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseDesc']) ? $this->dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseDesc'] : '' }}
                </p>
                <br>
                <p class="text-xs">
                    Tidak Ada Risiko 0-24 Tidak ada
                    <br>
                    Risiko Rendah 25-50 Lakukan pencegahan jatuh standar
                    <br>
                    Risiko Tinggi ≥ 51 Lakukan intervensi pencegahan jatuh risiko-tinggi

                </p>
            </div>


            <div class="grid grid-cols-5 gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Riwayat Jatuh (Baru Saja / 3 Bulan Terakhir)')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['riwayatJatuh3blnTerakhirOptions'] as $riwayatJatuh3blnTerakhirOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($riwayatJatuh3blnTerakhirOptions['riwayatJatuh3blnTerakhir'])"
                        value="{{ $riwayatJatuh3blnTerakhirOptions['riwayatJatuh3blnTerakhir'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.riwayatJatuh3blnTerakhir"
                        wire:click="$set('dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.riwayatJatuh3blnTerakhirScore', {{ $riwayatJatuh3blnTerakhirOptions['score'] }})" />
                @endforeach

            </div>

            <div class="grid grid-cols-5 gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Diagnosa Lain / Diagnosa Sekunder')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['diagSekunderOptions'] as $diagSekunderOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($diagSekunderOptions['diagSekunder'])" value="{{ $diagSekunderOptions['diagSekunder'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.diagSekunder"
                        wire:click="$set('dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.diagSekunderScore', {{ $diagSekunderOptions['score'] }})" />
                @endforeach

            </div>

            <div class="grid grid-cols-5 gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Alat Bantu')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['alatBantuOptions'] as $alatBantuOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($alatBantuOptions['alatBantu'])" value="{{ $alatBantuOptions['alatBantu'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.alatBantu"
                        wire:click="$set('dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.alatBantuScore', {{ $alatBantuOptions['score'] }})" />
                @endforeach

            </div>

            <div class="grid grid-cols-5 gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Heparin')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['heparinOptions'] as $heparinOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($heparinOptions['heparin'])" value="{{ $heparinOptions['heparin'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.heparin"
                        wire:click="$set('dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.heparinScore', {{ $heparinOptions['score'] }})" />
                @endforeach

            </div>

            <div class="grid grid-cols-5 gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Gaya Berjalan')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['gayaBerjalanOptions'] as $gayaBerjalanOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($gayaBerjalanOptions['gayaBerjalan'])" value="{{ $gayaBerjalanOptions['gayaBerjalan'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.gayaBerjalan"
                        wire:click="$set('dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.gayaBerjalanScore', {{ $gayaBerjalanOptions['score'] }})" />
                @endforeach

            </div>

            <div class="grid grid-cols-5 gap-2 mt-2 ml-2">
                <x-input-label for="" :value="__('Kesadaran')" :required="__(false)" class="px-2" />

                @foreach ($dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['kesadaranOptions'] as $kesadaranOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($kesadaranOptions['kesadaran'])" value="{{ $kesadaranOptions['kesadaran'] }}"
                        wire:model="dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.kesadaran"
                        wire:click="$set('dataDaftarPoliRJ.penilaian.resikoJatuh.skalaMorse.kesadaranScore', {{ $kesadaranOptions['score'] }})" />
                @endforeach

            </div>






        </div>




    </div>


</div>
