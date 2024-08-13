<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div id="DataPasien" class="sticky top-0 px-4 py-2 bg-white ">

        <div class="px-4 bg-grey-100 snap-mandatory snap-y">

            @php
                $pasieenTitle =
                    'Pasien RegNo : ' .
                    $dataPasien['pasien']['regNo'] .
                    ' Nomer Pelayanan :' .
                    $dataDaftarPoliRJ['noAntrian'];
            @endphp

            <div class="flex justify-between bg-white">

                <div>
                    <div class="text-base font-semibold text-gray-700">
                        {{ $dataPasien['pasien']['regNo'] }}
                    </div>

                    <div class="text-2xl font-semibold text-primary">
                        {{ strtoupper($dataPasien['pasien']['regName']) . ' / (' . $dataPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] . ')' . ' / ' . $dataPasien['pasien']['thn'] }}
                    </div>

                    <div class="font-normal text-gray-700">
                        {{ $dataPasien['pasien']['identitas']['alamat'] }}
                    </div>

                    <div>
                        <x-badge :badgecolor="__('default')">
                            Berat Badan :
                            {{ isset($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['bb'])
                                ? ($dataDaftarPoliRJ['pemeriksaan']['nutrisi']['bb']
                                    ? $dataDaftarPoliRJ['pemeriksaan']['nutrisi']['bb']
                                    : '-')
                                : '--' }}
                            Kg
                        </x-badge>

                        @isset($dataDaftarPoliRJ['anamnesa']['alergi']['alergi'])
                            @if ($dataDaftarPoliRJ['anamnesa']['alergi']['alergi'])
                                <x-badge :badgecolor="__('red')">
                                    Alergi :
                                    {{ isset($dataDaftarPoliRJ['anamnesa']['alergi']['alergi'])
                                        ? ($dataDaftarPoliRJ['anamnesa']['alergi']['alergi']
                                            ? $dataDaftarPoliRJ['anamnesa']['alergi']['alergi']
                                            : '-')
                                        : '--' }}
                                </x-badge>
                            @endif
                        @endisset

                    </div>

                </div>

                {{--  --}}
                <div class="grid">

                    <div class="px-2 text-base font-semibold text-gray-700 justify-self-end">
                        {{ $dataDaftarPoliRJ['poliDesc'] }}
                    </div>

                    <div class="px-2 text-base font-semibold text-primary justify-self-end">
                        {{ $dataDaftarPoliRJ['drDesc'] . ' / ' }}
                        {{ $dataDaftarPoliRJ['klaimId'] == 'UM'
                            ? 'UMUM'
                            : ($dataDaftarPoliRJ['klaimId'] == 'JM'
                                ? 'BPJS'
                                : ($dataDaftarPoliRJ['klaimId'] == 'KR'
                                    ? 'Kronis'
                                    : 'Asuransi Lain')) }}
                    </div>

                    <div class="px-2 font-normal text-gray-700 justify-self-end">
                        {{ isset($dataDaftarPoliRJ['sep']['noSep']) ? ($dataDaftarPoliRJ['sep']['noSep'] ? $dataDaftarPoliRJ['sep']['noSep'] : '-') : '--' }}
                    </div>

                    <div class="px-2 font-normal text-gray-700 justify-self-end">
                        {{ 'Tgl :' . $dataDaftarPoliRJ['rjDate'] }}
                    </div>


                </div>

            </div>




        </div>



    </div>


</div>
