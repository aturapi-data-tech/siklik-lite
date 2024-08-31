<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp

    <div class="w-full mb-1 ">

        <div class="grid grid-cols-1">

            <div id="TransaksiRawatJalan" class="px-4">
                <x-input-label for="" :value="__('Rekam Medis Pasien')" :required="__(false)" class="pt-2 sm:text-xl" />



                <!-- Table -->
                <div class="flex flex-col my-2">
                    <div class="overflow-x-auto rounded-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-2 py-2 ">


                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Layanan
                                                </x-sort-link>

                                            </th>


                                            <th scope="col" class="px-2 py-2 ">

                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Terapi
                                                </x-sort-link>
                                            </th>

                                            <th scope="col" class="px-2 py-2 ">

                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Diagnosis
                                                </x-sort-link>
                                            </th>

                                            <th scope="col" class="px-2 py-2 ">

                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    TTV
                                                </x-sort-link>
                                            </th>

                                            <th scope="col" class="w-8 px-2 py-2 text-center">
                                                RekamMedis
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">

                                        @foreach ($myQueryData as $myQData)
                                            <tr class="border-b group dark:border-gray-700">


                                                <td class="w-1/5 px-2 py-2 group-hover:bg-gray-100">
                                                    <div class="overflow-auto w-52 ">
                                                        <div class="font-semibold text-primary">
                                                            {{ $myQData->layanan_status === 'RI'
                                                                ? 'Rawat Inap'
                                                                : ($myQData->layanan_status === 'UGD'
                                                                    ? 'UGD'
                                                                    : ($myQData->layanan_status === 'RJ'
                                                                        ? 'Rawat Jalan'
                                                                        : '-')) }}
                                                        </div>
                                                        <div class="font-semibold text-gray-900">
                                                            {{ $myQData->txn_date . ' / (' . $myQData->reg_no . ')' }}
                                                        </div>
                                                        <div class="font-normal text-gray-900">
                                                            {{ $myQData->poli }}
                                                        </div>
                                                    </div>
                                                </td>

                                                @php
                                                    $datadaftar_json = json_decode($myQData->datadaftar_json, true);
                                                @endphp

                                                <td class="w-1/5 px-2 py-2 text-gray-900 group-hover:bg-gray-100">
                                                    <div class="w-full overflow-auto whitespace-nowrap">

                                                        {!! nl2br(
                                                            e(
                                                                isset($datadaftar_json['perencanaan']['terapi']['terapi'])
                                                                    ? $datadaftar_json['perencanaan']['terapi']['terapi']
                                                                    : '',
                                                            ),
                                                        ) !!}
                                                    </div>
                                                </td>

                                                <td class="w-1/5 px-2 py-2 text-gray-900 group-hover:bg-gray-100">
                                                    <div class="overflow-auto w-52 whitespace-nowrap">
                                                        @isset($datadaftar_json['diagnosis'])
                                                            @foreach ($datadaftar_json['diagnosis'] as $diagnosis)
                                                                {!! nl2br(e($diagnosis['diagId'] . ' - ' . $diagnosis['diagDesc'])) . '</br>' !!}
                                                            @endforeach
                                                        @endisset

                                                        <br>
                                                        Tindak Lanjut :
                                                        {{ isset($datadaftar_json['perencanaan']['tindakLanjut']['tindakLanjut'])
                                                            ? ($datadaftar_json['perencanaan']['tindakLanjut']['tindakLanjut']
                                                                ? $datadaftar_json['perencanaan']['tindakLanjut']['tindakLanjut']
                                                                : '-')
                                                            : '-' }}
                                                        /
                                                        {{ isset($datadaftar_json['perencanaan']['tindakLanjut']['keteranganTindakLanjut'])
                                                            ? ($datadaftar_json['perencanaan']['tindakLanjut']['keteranganTindakLanjut']
                                                                ? $datadaftar_json['perencanaan']['tindakLanjut']['keteranganTindakLanjut']
                                                                : '-')
                                                            : '-' }}
                                                    </div>
                                                </td>

                                                <td class="w-1/5 px-2 py-2 text-gray-900 group-hover:bg-gray-100">
                                                    <div class="w-full overflow-auto whitespace-nowrap">
                                                        TD :
                                                        {{ isset($datadaftar_json['pemeriksaan']['tandaVital']['sistolik'])
                                                            ? $datadaftar_json['pemeriksaan']['tandaVital']['sistolik']
                                                            : '' }}
                                                        /
                                                        {{ isset($datadaftar_json['pemeriksaan']['tandaVital']['distolik'])
                                                            ? $datadaftar_json['pemeriksaan']['tandaVital']['distolik']
                                                            : '' }}
                                                        (mmHg)
                                                        <br>
                                                        SPO2 :
                                                        {{ isset($datadaftar_json['pemeriksaan']['tandaVital']['spo2'])
                                                            ? $datadaftar_json['pemeriksaan']['tandaVital']['spo2']
                                                            : '' }}
                                                        (%)
                                                        <br>
                                                        GDA :
                                                        {{ isset($datadaftar_json['pemeriksaan']['tandaVital']['gda'])
                                                            ? $datadaftar_json['pemeriksaan']['tandaVital']['gda']
                                                            : '' }}
                                                        (mg/dL)
                                                    </div>
                                                </td>

                                                <td class="w-1/5 px-2 py-2 text-gray-900 group-hover:bg-gray-100">
                                                    <div>
                                                        <x-yellow-button
                                                            wire:click.prevent="openModalLayanan('{{ $myQData->txn_no }}',
                                                        '{{ $myQData->layanan_status }}',
                                                        {{ $myQData->datadaftar_json }}
                                                        )"
                                                            type="button" wire:loading.remove>
                                                            Resume Medis
                                                        </x-yellow-button>
                                                        <div wire:loading wire:target="openModalLayanan">
                                                            <x-loading />
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <x-green-button
                                                            wire:click.prevent="cetakRekamMedisRJGrid('{{ $myQData->txn_no }}',
                                                        '{{ $myQData->layanan_status }}',
                                                        {{ $myQData->datadaftar_json }}
                                                        )"
                                                            type="button" wire:loading.remove>
                                                            Cetak Resume Medis
                                                        </x-green-button>
                                                        <div wire:loading wire:target="cetakRekamMedisRJGrid">
                                                            <x-loading />
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <x-green-button
                                                            wire:click.prevent="cetakRekamMedisRJSuketIstirahatGrid('{{ $myQData->txn_no }}',
                                                        '{{ $myQData->layanan_status }}',
                                                        {{ $myQData->datadaftar_json }}
                                                        )"
                                                            type="button" wire:loading.remove>
                                                            Cetak Surat Keterangan Istirahat
                                                        </x-green-button>
                                                        <div wire:loading
                                                            wire:target="cetakRekamMedisRJSuketIstirahatGrid">
                                                            <x-loading />
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <x-green-button
                                                            wire:click.prevent="cetakRekamMedisRJSuketSehatGrid('{{ $myQData->txn_no }}',
                                                        '{{ $myQData->layanan_status }}',
                                                        {{ $myQData->datadaftar_json }}
                                                        )"
                                                            type="button" wire:loading.remove>
                                                            Cetak Surat Keterangan Sehat
                                                        </x-green-button>
                                                        <div wire:loading wire:target="cetakRekamMedisRJSuketSehatGrid">
                                                            <x-loading />
                                                        </div>
                                                    </div>

                                                </td>




                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                                {{-- no data found start --}}
                                @if ($myQueryData->count() == 0)
                                    <div class="w-full p-4 text-sm text-center text-gray-900 dark:text-gray-400">
                                        {{ 'Data Layanan Tidak ditemukan' }}
                                    </div>
                                @endif
                                {{-- no data found end --}}

                            </div>

                            {{ $myQueryData->links() }}

                        </div>
                    </div>
                    @if ($isOpenRekamMedisUGD)
                        @include('livewire.emr.rekam-medis.create-rekam-medis-u-g-d')
                    @endif
                    @if ($isOpenRekamMedisRJ)
                        @include('livewire.emr.rekam-medis.create-rekam-medis-r-j')
                    @endif
                </div>
            </div>



        </div>
    </div>
</div>
