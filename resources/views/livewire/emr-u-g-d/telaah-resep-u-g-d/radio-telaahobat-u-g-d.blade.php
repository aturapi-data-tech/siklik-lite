<div>

    <div class="flex justify-between">
        <x-input-label for="" :value="__('Telaah Obat')" :required="__(false)" class="pt-2 sm:text-xl" />

        @role(['Apoteker', 'Admin'])
            @if ($disabledPropertyRjStatusObat)
                <x-badge :badgecolor="__('green')">{{ $dataDaftarUgd['telaahObat']['penanggungJawab']['userLog'] }}</x-badge>
            @else
                <x-green-button :disabled=$disabledPropertyRjStatusObat
                    wire:click.prevent="setttdTelaahObat({{ $rjNoRef }})">
                    ttd Telaah Obat
                </x-green-button>
            @endif
        @endrole
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Obat dgn resep / pesanan')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahObat']['obatdgnResep']['obatdgnResepOptions'] as $obatdgnResepOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusObat :label="__($obatdgnResepOptions['obatdgnResep'])"
                    value="{{ $obatdgnResepOptions['obatdgnResep'] }}"
                    wire:model="dataDaftarUgd.telaahObat.obatdgnResep.obatdgnResep" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahObat.obatdgnResep.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.telaahObat.obatdgnResep.desc'))" :disabled=$disabledPropertyRjStatusObat
                wire:model.debounce.500ms="dataDaftarUgd.telaahObat.obatdgnResep.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Jml / Dosis dgn resep / pesanan')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahObat']['jmlDosisdgnResep']['jmlDosisdgnResepOptions'] as $jmlDosisdgnResepOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusObat :label="__($jmlDosisdgnResepOptions['jmlDosisdgnResep'])"
                    value="{{ $jmlDosisdgnResepOptions['jmlDosisdgnResep'] }}"
                    wire:model="dataDaftarUgd.telaahObat.jmlDosisdgnResep.jmlDosisdgnResep" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahObat.jmlDosisdgnResep.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.telaahObat.jmlDosisdgnResep.desc'))" :disabled=$disabledPropertyRjStatusObat
                wire:model.debounce.500ms="dataDaftarUgd.telaahObat.jmlDosisdgnResep.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Ruter dgn resep / pesanan')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahObat']['rutedgnResep']['rutedgnResepOptions'] as $rutedgnResepOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusObat :label="__($rutedgnResepOptions['rutedgnResep'])"
                    value="{{ $rutedgnResepOptions['rutedgnResep'] }}"
                    wire:model="dataDaftarUgd.telaahObat.rutedgnResep.rutedgnResep" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahObat.rutedgnResep.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.telaahObat.rutedgnResep.desc'))" :disabled=$disabledPropertyRjStatusObat
                wire:model.debounce.500ms="dataDaftarUgd.telaahObat.rutedgnResep.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Waktu dan Frekuensi pemberian dgn resep / pesanan')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahObat']['waktuFrekPemberiandgnResep']['waktuFrekPemberiandgnResepOptions'] as $waktuFrekPemberiandgnResepOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusObat :label="__($waktuFrekPemberiandgnResepOptions['waktuFrekPemberiandgnResep'])"
                    value="{{ $waktuFrekPemberiandgnResepOptions['waktuFrekPemberiandgnResep'] }}"
                    wire:model="dataDaftarUgd.telaahObat.waktuFrekPemberiandgnResep.waktuFrekPemberiandgnResep" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahObat.waktuFrekPemberiandgnResep.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.telaahObat.waktuFrekPemberiandgnResep.desc'))" :disabled=$disabledPropertyRjStatusObat
                wire:model.debounce.500ms="dataDaftarUgd.telaahObat.waktuFrekPemberiandgnResep.desc" />
        </div>
    </div>


</div>
