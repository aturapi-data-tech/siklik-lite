<div>

    <div class="flex justify-between">
        <x-input-label for="" :value="__('Telaah Resep')" :required="__(false)" class="pt-2 sm:text-xl" />

        @role(['Apoteker', 'Admin'])
            @if ($disabledPropertyRjStatusResep)
                <x-badge :badgecolor="__('green')">{{ $dataDaftarPoliRJ['telaahResep']['penanggungJawab']['userLog'] }}</x-badge>
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
            @foreach ($telaahResep['kejelasanTulisanResep']['kejelasanTulisanResepOptions'] as $kejelasanTulisanResepOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($kejelasanTulisanResepOptions['kejelasanTulisanResep'])"
                    value="{{ $kejelasanTulisanResepOptions['kejelasanTulisanResep'] }}"
                    wire:model="telaahResep.kejelasanTulisanResep.kejelasanTulisanResep" />
            @endforeach

            <x-text-input id="telaahResep.kejelasanTulisanResep.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('telaahResep.kejelasanTulisanResep.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="telaahResep.kejelasanTulisanResep.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Tepat Obat')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($telaahResep['tepatObat']['tepatObatOptions'] as $tepatObatOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($tepatObatOptions['tepatObat'])"
                    value="{{ $tepatObatOptions['tepatObat'] }}" wire:model="telaahResep.tepatObat.tepatObat" />
            @endforeach

            <x-text-input id="telaahResep.tepatObat.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('telaahResep.tepatObat.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="telaahResep.tepatObat.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Tepat Dosis')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($telaahResep['tepatDosis']['tepatDosisOptions'] as $tepatDosisOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($tepatDosisOptions['tepatDosis'])"
                    value="{{ $tepatDosisOptions['tepatDosis'] }}" wire:model="telaahResep.tepatDosis.tepatDosis" />
            @endforeach

            <x-text-input id="telaahResep.tepatDosis.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('telaahResep.tepatDosis.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="telaahResep.tepatDosis.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Tepat Rute')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($telaahResep['tepatRute']['tepatRuteOptions'] as $tepatRuteOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($tepatRuteOptions['tepatRute'])"
                    value="{{ $tepatRuteOptions['tepatRute'] }}" wire:model="telaahResep.tepatRute.tepatRute" />
            @endforeach

            <x-text-input id="telaahResep.tepatRute.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('telaahResep.tepatRute.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="telaahResep.tepatRute.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Tepat Waktu')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($telaahResep['tepatWaktu']['tepatWaktuOptions'] as $tepatWaktuOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($tepatWaktuOptions['tepatWaktu'])"
                    value="{{ $tepatWaktuOptions['tepatWaktu'] }}" wire:model="telaahResep.tepatWaktu.tepatWaktu" />
            @endforeach

            <x-text-input id="telaahResep.tepatWaktu.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('telaahResep.tepatWaktu.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="telaahResep.tepatWaktu.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Duplikasi')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($telaahResep['duplikasi']['duplikasiOptions'] as $duplikasiOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($duplikasiOptions['duplikasi'])"
                    value="{{ $duplikasiOptions['duplikasi'] }}" wire:model="telaahResep.duplikasi.duplikasi" />
            @endforeach

            <x-text-input id="telaahResep.duplikasi.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('telaahResep.duplikasi.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="telaahResep.duplikasi.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Alergi')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($telaahResep['alergi']['alergiOptions'] as $alergiOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($alergiOptions['alergi'])"
                    value="{{ $alergiOptions['alergi'] }}" wire:model="telaahResep.alergi.alergi" />
            @endforeach

            <x-text-input id="telaahResep.alergi.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('telaahResep.alergi.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="telaahResep.alergi.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Interaksi Obat')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($telaahResep['interaksiObat']['interaksiObatOptions'] as $interaksiObatOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($interaksiObatOptions['interaksiObat'])"
                    value="{{ $interaksiObatOptions['interaksiObat'] }}"
                    wire:model="telaahResep.interaksiObat.interaksiObat" />
            @endforeach

            <x-text-input id="telaahResep.interaksiObat.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('telaahResep.interaksiObat.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="telaahResep.interaksiObat.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Berat Badan Pasien Anak')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($telaahResep['bbPasienAnak']['bbPasienAnakOptions'] as $bbPasienAnakOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($bbPasienAnakOptions['bbPasienAnak'])"
                    value="{{ $bbPasienAnakOptions['bbPasienAnak'] }}"
                    wire:model="telaahResep.bbPasienAnak.bbPasienAnak" />
            @endforeach

            <x-text-input id="telaahResep.bbPasienAnak.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('telaahResep.bbPasienAnak.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="telaahResep.bbPasienAnak.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Kontra Indikasi Lain')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($telaahResep['kontraIndikasiLain']['kontraIndikasiLainOptions'] as $kontraIndikasiLainOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($kontraIndikasiLainOptions['kontraIndikasiLain'])"
                    value="{{ $kontraIndikasiLainOptions['kontraIndikasiLain'] }}"
                    wire:model="telaahResep.kontraIndikasiLain.kontraIndikasiLain" />
            @endforeach

            <x-text-input id="telaahResep.kontraIndikasiLain.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('telaahResep.kontraIndikasiLain.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="telaahResep.kontraIndikasiLain.desc" />
        </div>
    </div>
</div>
