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
            @foreach ($dataDaftarPoliRJ['telaahResep']['kejelasanTulisanResep']['kejelasanTulisanResepOptions'] as $kejelasanTulisanResepOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($kejelasanTulisanResepOptions['kejelasanTulisanResep'])"
                    value="{{ $kejelasanTulisanResepOptions['kejelasanTulisanResep'] }}"
                    wire:model="dataDaftarPoliRJ.telaahResep.kejelasanTulisanResep.kejelasanTulisanResep" />
            @endforeach

            <x-text-input id="dataDaftarPoliRJ.telaahResep.kejelasanTulisanResep.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.telaahResep.kejelasanTulisanResep.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarPoliRJ.telaahResep.kejelasanTulisanResep.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Tepat Obat')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarPoliRJ['telaahResep']['tepatObat']['tepatObatOptions'] as $tepatObatOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($tepatObatOptions['tepatObat'])"
                    value="{{ $tepatObatOptions['tepatObat'] }}"
                    wire:model="dataDaftarPoliRJ.telaahResep.tepatObat.tepatObat" />
            @endforeach

            <x-text-input id="dataDaftarPoliRJ.telaahResep.tepatObat.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.telaahResep.tepatObat.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarPoliRJ.telaahResep.tepatObat.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Tepat Dosis')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarPoliRJ['telaahResep']['tepatDosis']['tepatDosisOptions'] as $tepatDosisOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($tepatDosisOptions['tepatDosis'])"
                    value="{{ $tepatDosisOptions['tepatDosis'] }}"
                    wire:model="dataDaftarPoliRJ.telaahResep.tepatDosis.tepatDosis" />
            @endforeach

            <x-text-input id="dataDaftarPoliRJ.telaahResep.tepatDosis.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.telaahResep.tepatDosis.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarPoliRJ.telaahResep.tepatDosis.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Tepat Rute')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarPoliRJ['telaahResep']['tepatRute']['tepatRuteOptions'] as $tepatRuteOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($tepatRuteOptions['tepatRute'])"
                    value="{{ $tepatRuteOptions['tepatRute'] }}"
                    wire:model="dataDaftarPoliRJ.telaahResep.tepatRute.tepatRute" />
            @endforeach

            <x-text-input id="dataDaftarPoliRJ.telaahResep.tepatRute.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.telaahResep.tepatRute.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarPoliRJ.telaahResep.tepatRute.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Tepat Waktu')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarPoliRJ['telaahResep']['tepatWaktu']['tepatWaktuOptions'] as $tepatWaktuOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($tepatWaktuOptions['tepatWaktu'])"
                    value="{{ $tepatWaktuOptions['tepatWaktu'] }}"
                    wire:model="dataDaftarPoliRJ.telaahResep.tepatWaktu.tepatWaktu" />
            @endforeach

            <x-text-input id="dataDaftarPoliRJ.telaahResep.tepatWaktu.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.telaahResep.tepatWaktu.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarPoliRJ.telaahResep.tepatWaktu.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Duplikasi')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarPoliRJ['telaahResep']['duplikasi']['duplikasiOptions'] as $duplikasiOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($duplikasiOptions['duplikasi'])"
                    value="{{ $duplikasiOptions['duplikasi'] }}"
                    wire:model="dataDaftarPoliRJ.telaahResep.duplikasi.duplikasi" />
            @endforeach

            <x-text-input id="dataDaftarPoliRJ.telaahResep.duplikasi.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.telaahResep.duplikasi.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarPoliRJ.telaahResep.duplikasi.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Alergi')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarPoliRJ['telaahResep']['alergi']['alergiOptions'] as $alergiOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($alergiOptions['alergi'])"
                    value="{{ $alergiOptions['alergi'] }}" wire:model="dataDaftarPoliRJ.telaahResep.alergi.alergi" />
            @endforeach

            <x-text-input id="dataDaftarPoliRJ.telaahResep.alergi.desc" placeholder="Keterangan" class="w-1/2 mt-1 ml-2"
                :errorshas="__($errors->has('dataDaftarPoliRJ.telaahResep.alergi.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarPoliRJ.telaahResep.alergi.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Interaksi Obat')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarPoliRJ['telaahResep']['interaksiObat']['interaksiObatOptions'] as $interaksiObatOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($interaksiObatOptions['interaksiObat'])"
                    value="{{ $interaksiObatOptions['interaksiObat'] }}"
                    wire:model="dataDaftarPoliRJ.telaahResep.interaksiObat.interaksiObat" />
            @endforeach

            <x-text-input id="dataDaftarPoliRJ.telaahResep.interaksiObat.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.telaahResep.interaksiObat.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarPoliRJ.telaahResep.interaksiObat.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Berat Badan Pasien Anak')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarPoliRJ['telaahResep']['bbPasienAnak']['bbPasienAnakOptions'] as $bbPasienAnakOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($bbPasienAnakOptions['bbPasienAnak'])"
                    value="{{ $bbPasienAnakOptions['bbPasienAnak'] }}"
                    wire:model="dataDaftarPoliRJ.telaahResep.bbPasienAnak.bbPasienAnak" />
            @endforeach

            <x-text-input id="dataDaftarPoliRJ.telaahResep.bbPasienAnak.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.telaahResep.bbPasienAnak.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarPoliRJ.telaahResep.bbPasienAnak.desc" />
        </div>
    </div>

    <div class="pt-2 ">
        <x-input-label for="" :value="__('Kontra Indikasi Lain')" :required="__(true)" />

        <div class="flex mt-2 ml-2">
            @foreach ($dataDaftarPoliRJ['telaahResep']['kontraIndikasiLain']['kontraIndikasiLainOptions'] as $kontraIndikasiLainOptions)
                <x-radio-button :disabled=$disabledPropertyRjStatusResep :label="__($kontraIndikasiLainOptions['kontraIndikasiLain'])"
                    value="{{ $kontraIndikasiLainOptions['kontraIndikasiLain'] }}"
                    wire:model="dataDaftarPoliRJ.telaahResep.kontraIndikasiLain.kontraIndikasiLain" />
            @endforeach

            <x-text-input id="dataDaftarPoliRJ.telaahResep.kontraIndikasiLain.desc" placeholder="Keterangan"
                class="w-1/2 mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.telaahResep.kontraIndikasiLain.desc'))" :disabled=$disabledPropertyRjStatusResep
                wire:model.debounce.500ms="dataDaftarPoliRJ.telaahResep.kontraIndikasiLain.desc" />
        </div>
    </div>
</div>
