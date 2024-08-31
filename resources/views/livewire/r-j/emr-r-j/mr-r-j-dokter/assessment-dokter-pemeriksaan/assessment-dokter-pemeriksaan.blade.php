<div>
    @php
        $disabledProperty = true;

        $disabledPropertyRjStatus = false;

    @endphp

    @if (isset($dataDaftarPoliRJ['pemeriksaan']))
        <div class="w-full mb-1">



            {{-- <form class="scroll-smooth hover:scroll-auto"> --}}
            <div class="grid grid-cols-1">

                <div id="TransaksiRawatJalan" class="p-2">

                    <div class="p-2 rounded-lg bg-gray-50">
                        {{-- @include('livewire.emr-r-j.mr-r-j.anamnesa.pengkajianPerawatanTab') --}}
                        {{-- @include('livewire.emr-r-j.mr-r-j.anamnesa.keluhanUtamaTab') --}}

                        <div>

                            <table class="w-full text-sm table-auto">
                                <tbody>
                                    <tr>
                                        <td class="w-1/2 font-semibold uppercase align-text-top">
                                            {{-- Perawat / Terapis --}}
                                            Perawat / Terapis :
                                        </td>
                                        <td class="w-1/2">
                                            {{ isset($dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['perawatPenerima'])
                                                ? ($dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['perawatPenerima']
                                                    ? strtoupper($dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['perawatPenerima'])
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
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['sistolik'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['sistolik']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['tandaVital']['sistolik']
                                                    : '-')
                                                : '-' }}
                                            /
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['distolik'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['distolik']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['tandaVital']['distolik']
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
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['frekuensiNadi'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['frekuensiNadi']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['tandaVital']['frekuensiNadi']
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
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['suhu'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['suhu']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['tandaVital']['suhu']
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
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['frekuensiNafas'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['frekuensiNafas']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['tandaVital']['frekuensiNafas']
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
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['saturasiO2'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['saturasiO2']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['tandaVital']['saturasiO2']
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
                                        {{ isset($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['bb'])
                                            ? ($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['bb']
                                                ? $dataDaftarPoliRJ['pemeriksaan']['nutrisi']['bb']
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
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['spo2'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['spo2']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['tandaVital']['spo2']
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
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['gda'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['tandaVital']['gda']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['tandaVital']['gda']
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
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['bb'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['bb']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['nutrisi']['bb']
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
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['tb'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['tb']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['nutrisi']['tb']
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
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['imt'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['imt']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['nutrisi']['imt']
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
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['lk'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['lk']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['nutrisi']['lk']
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
                                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['lila'])
                                                ? ($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['lila']
                                                    ? $dataDaftarPoliRJ['pemeriksaan']['nutrisi']['lila']
                                                    : '-')
                                                : '-' }}
                                            cm
                                        </td>
                                    </tr>




                                </tbody>
                            </table>

                        </div>



                        {{-- @include('livewire.emr-r-j.mr-r-j.pemeriksaan.umumTab') --}}
                        @include('livewire.emr-r-j.mr-r-j.pemeriksaan.fisikTab')

                        {{-- suspekAkibatKerja --}}
                        <div class="mb-2 ">
                            <x-input-label
                                for="dataDaftarPoliRJ.pemeriksaan.suspekAkibatKerja.KeteranganSuspekAkibatKerja"
                                :value="__('Suspek Penyakit Akibat Kecelakaan Kerja')" :required="__(false)" />

                            <div class="grid grid-cols-3 gap-2 mb-2">
                                @isset($dataDaftarPoliRJ['pemeriksaan']['suspekAkibatKerja']['suspekAkibatKerjaOptions'])
                                    @foreach ($dataDaftarPoliRJ['pemeriksaan']['suspekAkibatKerja']['suspekAkibatKerjaOptions'] as $suspekAkibatKerjaOptions)
                                        {{-- @dd($sRj) --}}
                                        <x-radio-button :label="__($suspekAkibatKerjaOptions['suspekAkibatKerja'])"
                                            value="{{ $suspekAkibatKerjaOptions['suspekAkibatKerja'] }}"
                                            wire:model="dataDaftarPoliRJ.pemeriksaan.suspekAkibatKerja.suspekAkibatKerja" />
                                    @endforeach
                                @endisset

                                <x-text-input
                                    id="dataDaftarPoliRJ.pemeriksaan.suspekAkibatKerja.keteranganSuspekAkibatKerja"
                                    placeholder="Keterangan" class="mt-1 ml-2" :errorshas="__(
                                        $errors->has(
                                            'dataDaftarPoliRJ.pemeriksaan.suspekAkibatKerja.keteranganSuspekAkibatKerja',
                                        ),
                                    )"
                                    :disabled=$disabledPropertyRjStatus
                                    wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.suspekAkibatKerja.keteranganSuspekAkibatKerja" />
                            </div>

                        </div>
                        {{-- Ujifungsi --}}
                        @include('livewire.emr-r-j.mr-r-j.pemeriksaan.UjiFungsiTab')

                        {{-- @include('livewire.emr-r-j.mr-r-j.pemeriksaan.anatomiTab') --}}
                        @include('livewire.emr-r-j.mr-r-j.pemeriksaan.penunjangTab')

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
