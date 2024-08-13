<div>
    @php
        $disabledProperty = true;

        $disabledPropertyRjStatus = false;

    @endphp

    @if (isset($dataDaftarUgd['pemeriksaan']))
        <div class="w-full mb-1">



            {{-- <form class="scroll-smooth hover:scroll-auto"> --}}
            <div class="grid grid-cols-1">

                <div id="TransaksiRawatJalan" class="p-2">

                    <div class="p-2 rounded-lg bg-gray-50">
                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.pengkajianPerawatanTab') --}}
                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.keluhanUtamaTab') --}}

                        <div>

                            <table class="w-full text-sm table-auto">
                                <tbody>
                                    <tr>
                                        <td class="w-1/2 font-semibold uppercase align-text-top">
                                            {{-- Perawat / Terapis --}}
                                            Perawat / Terapis :
                                        </td>
                                        <td class="w-1/2">
                                            {{ isset($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['perawatPenerima'])
                                                ? ($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['perawatPenerima']
                                                    ? strtoupper($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['perawatPenerima'])
                                                    : 'Perawat Penerima')
                                                : 'Perawat Penerima' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-1/2 font-semibold uppercase">
                                            {{-- Tanda Vital --}}
                                            Tanda Vital :
                                        </td>
                                        <td class="w-1/2">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-4 text-end">
                                            TD :
                                        </td>
                                        <td>
                                            {{ isset($dataDaftarUgd['pemeriksaan']['tandaVital']['sistolik'])
                                                ? ($dataDaftarUgd['pemeriksaan']['tandaVital']['sistolik']
                                                    ? $dataDaftarUgd['pemeriksaan']['tandaVital']['sistolik']
                                                    : '-')
                                                : '-' }}
                                            /
                                            {{ isset($dataDaftarUgd['pemeriksaan']['tandaVital']['distolik'])
                                                ? ($dataDaftarUgd['pemeriksaan']['tandaVital']['distolik']
                                                    ? $dataDaftarUgd['pemeriksaan']['tandaVital']['distolik']
                                                    : '-')
                                                : '-' }}
                                            mmhg
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-4 text-end">
                                            Nadi :
                                        </td>
                                        <td>
                                            {{ isset($dataDaftarUgd['pemeriksaan']['tandaVital']['frekuensiNadi'])
                                                ? ($dataDaftarUgd['pemeriksaan']['tandaVital']['frekuensiNadi']
                                                    ? $dataDaftarUgd['pemeriksaan']['tandaVital']['frekuensiNadi']
                                                    : '-')
                                                : '-' }}
                                            x/mnt
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-4 text-end">
                                            Suhu :
                                        </td>
                                        <td>
                                            {{ isset($dataDaftarUgd['pemeriksaan']['tandaVital']['suhu'])
                                                ? ($dataDaftarUgd['pemeriksaan']['tandaVital']['suhu']
                                                    ? $dataDaftarUgd['pemeriksaan']['tandaVital']['suhu']
                                                    : '-')
                                                : '-' }}
                                            °C
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-4 text-end">
                                            Pernafasan :
                                        </td>
                                        <td>
                                            {{ isset($dataDaftarUgd['pemeriksaan']['tandaVital']['frekuensiNafas'])
                                                ? ($dataDaftarUgd['pemeriksaan']['tandaVital']['frekuensiNafas']
                                                    ? $dataDaftarUgd['pemeriksaan']['tandaVital']['frekuensiNafas']
                                                    : '-')
                                                : '-' }}
                                            x/mnt
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="pr-4 text-end">
                                            Saturasi O2 :
                                        </td>
                                        <td>
                                            {{ isset($dataDaftarUgd['pemeriksaan']['tandaVital']['saturasiO2'])
                                                ? ($dataDaftarUgd['pemeriksaan']['tandaVital']['saturasiO2']
                                                    ? $dataDaftarUgd['pemeriksaan']['tandaVital']['saturasiO2']
                                                    : '-')
                                                : '-' }}
                                            Saturasi
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                    <td class="pr-4 text-end">
                                        Berat Badan :
                                    </td>
                                    <td>
                                        {{ isset($dataDaftarUgd['pemeriksaan']['nutrisi']['bb'])
                                            ? ($dataDaftarUgd['pemeriksaan']['nutrisi']['bb']
                                                ? $dataDaftarUgd['pemeriksaan']['nutrisi']['bb']
                                                : '-')
                                            : '-' }}
                                        kg
                                    </td>
                                </tr> --}}
                                    <tr>
                                        <td class="pr-4 text-end">
                                            SPO2 :
                                        </td>
                                        <td>
                                            {{ isset($dataDaftarUgd['pemeriksaan']['tandaVital']['spo2'])
                                                ? ($dataDaftarUgd['pemeriksaan']['tandaVital']['spo2']
                                                    ? $dataDaftarUgd['pemeriksaan']['tandaVital']['spo2']
                                                    : '-')
                                                : '-' }}
                                            %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-4 text-end">
                                            GDA :
                                        </td>
                                        <td>
                                            {{ isset($dataDaftarUgd['pemeriksaan']['tandaVital']['gda'])
                                                ? ($dataDaftarUgd['pemeriksaan']['tandaVital']['gda']
                                                    ? $dataDaftarUgd['pemeriksaan']['tandaVital']['gda']
                                                    : '-')
                                                : '-' }}
                                            mg/dL
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-1/2 font-semibold uppercase">
                                            {{-- Nutrisi --}}
                                            Nutrisi :
                                        </td>
                                        <td class="w-1/2">

                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="pr-4 text-end">
                                            Berat Badan :
                                        </td>
                                        <td>
                                            {{ isset($dataDaftarUgd['pemeriksaan']['nutrisi']['bb'])
                                                ? ($dataDaftarUgd['pemeriksaan']['nutrisi']['bb']
                                                    ? $dataDaftarUgd['pemeriksaan']['nutrisi']['bb']
                                                    : '-')
                                                : '-' }}
                                            Kg
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-4 text-end">
                                            Tinggi Badan :
                                        </td>
                                        <td>
                                            {{ isset($dataDaftarUgd['pemeriksaan']['nutrisi']['tb'])
                                                ? ($dataDaftarUgd['pemeriksaan']['nutrisi']['tb']
                                                    ? $dataDaftarUgd['pemeriksaan']['nutrisi']['tb']
                                                    : '-')
                                                : '-' }}
                                            cm
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-4 text-end">
                                            Index Masa Tubuh :
                                        </td>
                                        <td>
                                            {{ isset($dataDaftarUgd['pemeriksaan']['nutrisi']['imt'])
                                                ? ($dataDaftarUgd['pemeriksaan']['nutrisi']['imt']
                                                    ? $dataDaftarUgd['pemeriksaan']['nutrisi']['imt']
                                                    : '-')
                                                : '-' }}
                                            Kg/M2
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-4 text-end">
                                            Lingkar Kepala :
                                        </td>
                                        <td>
                                            {{ isset($dataDaftarUgd['pemeriksaan']['nutrisi']['lk'])
                                                ? ($dataDaftarUgd['pemeriksaan']['nutrisi']['lk']
                                                    ? $dataDaftarUgd['pemeriksaan']['nutrisi']['lk']
                                                    : '-')
                                                : '-' }}
                                            cm
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="pr-4 text-end">
                                            Lingkar Lengan Atas :
                                        </td>
                                        <td>
                                            {{ isset($dataDaftarUgd['pemeriksaan']['nutrisi']['lila'])
                                                ? ($dataDaftarUgd['pemeriksaan']['nutrisi']['lila']
                                                    ? $dataDaftarUgd['pemeriksaan']['nutrisi']['lila']
                                                    : '-')
                                                : '-' }}
                                            cm
                                        </td>
                                    </tr>






                                </tbody>
                            </table>

                        </div>

                        <div class="grid grid-cols-2 gap-2 p-2 text-sm bg-gray-200 rounded-lg">
                            {{-- abcd --}}
                            <div>
                                <span class="font-semibold">
                                    Jalan Nafas (A) :
                                </span>
                                <br>
                                {{ isset($dataDaftarTxn['pemeriksaan']['tandaVital']['jalanNafas']['jalanNafas'])
                                    ? ($dataDaftarTxn['pemeriksaan']['tandaVital']['jalanNafas']['jalanNafas']
                                        ? $dataDaftarTxn['pemeriksaan']['tandaVital']['jalanNafas']['jalanNafas']
                                        : '-')
                                    : '-' }}
                            </div>

                            <div>
                                <span class="font-semibold">
                                    Pernafasan (B) :
                                </span>
                                <br>
                                {{ isset($dataDaftarTxn['pemeriksaan']['tandaVital']['pernafasan']['pernafasan'])
                                    ? ($dataDaftarTxn['pemeriksaan']['tandaVital']['pernafasan']['pernafasan']
                                        ? $dataDaftarTxn['pemeriksaan']['tandaVital']['pernafasan']['pernafasan']
                                        : '-')
                                    : '-' }}
                                <span class="font-semibold">
                                    Gerak Dada :
                                </span>
                                <br>
                                {{ isset($dataDaftarTxn['pemeriksaan']['tandaVital']['gerakDada']['gerakDada'])
                                    ? ($dataDaftarTxn['pemeriksaan']['tandaVital']['gerakDada']['gerakDada']
                                        ? $dataDaftarTxn['pemeriksaan']['tandaVital']['gerakDada']['gerakDada']
                                        : '-')
                                    : '-' }}
                            </div>

                            <div>
                                <span class="font-semibold">
                                    Sirkulasi (C) :
                                </span>
                                <br>
                                {{ isset($dataDaftarTxn['pemeriksaan']['tandaVital']['sirkulasi']['sirkulasi'])
                                    ? ($dataDaftarTxn['pemeriksaan']['tandaVital']['sirkulasi']['sirkulasi']
                                        ? $dataDaftarTxn['pemeriksaan']['tandaVital']['sirkulasi']['sirkulasi']
                                        : '-')
                                    : '-' }}
                            </div>

                            <div>

                                <span class="font-semibold">
                                    Neurologi (D) :
                                </span>
                                <br>
                                Mata :
                                {{ isset($dataDaftarTxn['pemeriksaan']['tandaVital']['e'])
                                    ? ($dataDaftarTxn['pemeriksaan']['tandaVital']['e']
                                        ? $dataDaftarTxn['pemeriksaan']['tandaVital']['e']
                                        : '-')
                                    : '-' }}
                                -
                                Verbal:
                                {{ isset($dataDaftarTxn['pemeriksaan']['tandaVital']['v'])
                                    ? ($dataDaftarTxn['pemeriksaan']['tandaVital']['v']
                                        ? $dataDaftarTxn['pemeriksaan']['tandaVital']['v']
                                        : '-')
                                    : '-' }}
                                -
                                Motorik :
                                {{ isset($dataDaftarTxn['pemeriksaan']['tandaVital']['m'])
                                    ? ($dataDaftarTxn['pemeriksaan']['tandaVital']['m']
                                        ? $dataDaftarTxn['pemeriksaan']['tandaVital']['m']
                                        : '-')
                                    : '-' }}
                                -
                                GCS:
                                {{ isset($dataDaftarTxn['pemeriksaan']['tandaVital']['gcs'])
                                    ? ($dataDaftarTxn['pemeriksaan']['tandaVital']['gcs']
                                        ? $dataDaftarTxn['pemeriksaan']['tandaVital']['gcs']
                                        : '-')
                                    : '-' }}
                            </div>

                        </div>



                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.pemeriksaan.umumTab') --}}
                        @include('livewire.emr-u-g-d.mr-u-g-d.pemeriksaan.fisikTab')

                        {{-- suspekAkibatKerja --}}
                        <div class="mb-2 ">
                            <x-input-label for="dataDaftarUgd.pemeriksaan.suspekAkibatKerja.KeteranganSuspekAkibatKerja"
                                :value="__('Suspek Penyakit Akibat Kecelakaan Kerja')" :required="__(false)" />

                            <div class="grid grid-cols-3 gap-2 mb-2">
                                @isset($dataDaftarUgd['pemeriksaan']['suspekAkibatKerja']['suspekAkibatKerjaOptions'])
                                    @foreach ($dataDaftarUgd['pemeriksaan']['suspekAkibatKerja']['suspekAkibatKerjaOptions'] as $suspekAkibatKerjaOptions)
                                        {{-- @dd($sRj) --}}
                                        <x-radio-button :label="__($suspekAkibatKerjaOptions['suspekAkibatKerja'])"
                                            value="{{ $suspekAkibatKerjaOptions['suspekAkibatKerja'] }}"
                                            wire:model="dataDaftarUgd.pemeriksaan.suspekAkibatKerja.suspekAkibatKerja" />
                                    @endforeach
                                @endisset

                                <x-text-input
                                    id="dataDaftarUgd.pemeriksaan.suspekAkibatKerja.keteranganSuspekAkibatKerja"
                                    placeholder="Keterangan" class="mt-1 ml-2" :errorshas="__(
                                        $errors->has(
                                            'dataDaftarUgd.pemeriksaan.suspekAkibatKerja.keteranganSuspekAkibatKerja',
                                        ),
                                    )"
                                    :disabled=$disabledPropertyRjStatus
                                    wire:model.debounce.500ms="dataDaftarUgd.pemeriksaan.suspekAkibatKerja.keteranganSuspekAkibatKerja" />
                            </div>

                        </div>
                        {{-- Ujifungsi --}}
                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.pemeriksaan.UjiFungsiTab') --}}

                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.pemeriksaan.anatomiTab') --}}
                        @include('livewire.emr-u-g-d.mr-u-g-d.pemeriksaan.penunjangTab')

                    </div>

                </div>




                {{-- <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6">

                    <div class="">
                    </div>
                    <div>
                        <div wire:loading wire:target="store">
                            <x-loading />
                        </div>

                        <x-green-button :disabled=$disabledPropertyRjStatus wire:click.prevent="store()" type="button"
                            wire:loading.remove>
                            Simpan Objective
                        </x-green-button>
                    </div>
                </div> --}}




            </div>

        </div>
    @endif


</div>
