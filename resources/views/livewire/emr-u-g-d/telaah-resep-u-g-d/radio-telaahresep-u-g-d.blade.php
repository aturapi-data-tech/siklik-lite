<div>

    <div class="flex justify-between">
        <x-input-label for="" :value="__('Telaah Resep')" :required="__(false)" class="pt-2 sm:text-xl" />

        @role(['Apoteker', 'Admin'])
            @if ($disabledPropertyRjStatusResep)
                <x-badge :badgecolor="__('green')">{{ $dataDaftarUgd['telaahResep']['penanggungJawab']['userLog'] }}</x-badge>
            @else
                <x-green-button :disabled=$disabledPropertyRjStatusResep
                    wire:click.prevent="setttdTelaahResep({{ $rjNoRef }})">
                    ttd Telaah Resep
                </x-green-button>
            @endif
        @endrole
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Kejelasan Tulisan Resep')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahResep']['kejelasanTulisanResep']['kejelasanTulisanResepOptions'] as $kejelasanTulisanResepOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($kejelasanTulisanResepOptions['kejelasanTulisanResep'])"
                    value="{{ $kejelasanTulisanResepOptions['kejelasanTulisanResep'] }}"
                    wire:model="dataDaftarUgd.telaahResep.kejelasanTulisanResep.kejelasanTulisanResep" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahResep.kejelasanTulisanResep.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.telaahResep.kejelasanTulisanResep.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarUgd.telaahResep.kejelasanTulisanResep.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Tepat Obat')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahResep']['tepatObat']['tepatObatOptions'] as $tepatObatOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($tepatObatOptions['tepatObat'])"
                    value="{{ $tepatObatOptions['tepatObat'] }}"
                    wire:model="dataDaftarUgd.telaahResep.tepatObat.tepatObat" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahResep.tepatObat.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('dataDaftarUgd.telaahResep.tepatObat.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarUgd.telaahResep.tepatObat.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Tepat Dosis')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahResep']['tepatDosis']['tepatDosisOptions'] as $tepatDosisOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($tepatDosisOptions['tepatDosis'])"
                    value="{{ $tepatDosisOptions['tepatDosis'] }}"
                    wire:model="dataDaftarUgd.telaahResep.tepatDosis.tepatDosis" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahResep.tepatDosis.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.telaahResep.tepatDosis.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarUgd.telaahResep.tepatDosis.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Tepat Rute')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahResep']['tepatRute']['tepatRuteOptions'] as $tepatRuteOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($tepatRuteOptions['tepatRute'])"
                    value="{{ $tepatRuteOptions['tepatRute'] }}"
                    wire:model="dataDaftarUgd.telaahResep.tepatRute.tepatRute" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahResep.tepatRute.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('dataDaftarUgd.telaahResep.tepatRute.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarUgd.telaahResep.tepatRute.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Tepat Waktu')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahResep']['tepatWaktu']['tepatWaktuOptions'] as $tepatWaktuOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($tepatWaktuOptions['tepatWaktu'])"
                    value="{{ $tepatWaktuOptions['tepatWaktu'] }}"
                    wire:model="dataDaftarUgd.telaahResep.tepatWaktu.tepatWaktu" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahResep.tepatWaktu.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.telaahResep.tepatWaktu.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarUgd.telaahResep.tepatWaktu.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Duplikasi')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahResep']['duplikasi']['duplikasiOptions'] as $duplikasiOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($duplikasiOptions['duplikasi'])"
                    value="{{ $duplikasiOptions['duplikasi'] }}"
                    wire:model="dataDaftarUgd.telaahResep.duplikasi.duplikasi" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahResep.duplikasi.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('dataDaftarUgd.telaahResep.duplikasi.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarUgd.telaahResep.duplikasi.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Alergi')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahResep']['alergi']['alergiOptions'] as $alergiOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($alergiOptions['alergi'])"
                    value="{{ $alergiOptions['alergi'] }}" wire:model="dataDaftarUgd.telaahResep.alergi.alergi" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahResep.alergi.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('dataDaftarUgd.telaahResep.alergi.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarUgd.telaahResep.alergi.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Interaksi Obat')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahResep']['interaksiObat']['interaksiObatOptions'] as $interaksiObatOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($interaksiObatOptions['interaksiObat'])"
                    value="{{ $interaksiObatOptions['interaksiObat'] }}"
                    wire:model="dataDaftarUgd.telaahResep.interaksiObat.interaksiObat" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahResep.interaksiObat.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.telaahResep.interaksiObat.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarUgd.telaahResep.interaksiObat.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Berat Badan Pasien Anak')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahResep']['bbPasienAnak']['bbPasienAnakOptions'] as $bbPasienAnakOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($bbPasienAnakOptions['bbPasienAnak'])"
                    value="{{ $bbPasienAnakOptions['bbPasienAnak'] }}"
                    wire:model="dataDaftarUgd.telaahResep.bbPasienAnak.bbPasienAnak" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahResep.bbPasienAnak.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.telaahResep.bbPasienAnak.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarUgd.telaahResep.bbPasienAnak.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Kontra Indikasi Lain')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarUgd['telaahResep']['kontraIndikasiLain']['kontraIndikasiLainOptions'] as $kontraIndikasiLainOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($kontraIndikasiLainOptions['kontraIndikasiLain'])"
                    value="{{ $kontraIndikasiLainOptions['kontraIndikasiLain'] }}"
                    wire:model="dataDaftarUgd.telaahResep.kontraIndikasiLain.kontraIndikasiLain" />
            @endforeach

            <x-text-input id="dataDaftarUgd.telaahResep.kontraIndikasiLain.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.telaahResep.kontraIndikasiLain.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarUgd.telaahResep.kontraIndikasiLain.desc" />
        </div>
    </div>
</div>
