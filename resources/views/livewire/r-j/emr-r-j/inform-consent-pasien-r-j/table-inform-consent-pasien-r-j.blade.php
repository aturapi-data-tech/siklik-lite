<div class="h-[calc(100vh-250px)] mt-2 overflow-auto">
    <!-- Table -->
    <table class="w-full text-sm text-left text-gray-700 table-auto ">
        <thead class="text-xs text-gray-900 uppercase bg-gray-100 ">
            <tr>
                <th scope="col" class="px-4 py-3 ">
                    Tindakan Medis
                </th>

                <th scope="col" class="px-4 py-3 ">
                    Atas Persetujuan
                </th>

                <th scope="col" class="px-4 py-3 ">
                    Action
                </th>
            </tr>
        </thead>

        <tbody class="bg-white ">
            @isset($dataDaftarRJ['informConsentPasienRJ'])
                @foreach ($dataDaftarRJ['informConsentPasienRJ'] as $myQData)
                    <tr class="border-b group dark:border-gray-700">


                        <td class="px-4 py-3 group-hover:bg-gray-100 whitespace-nowrap dark:text-white">
                            <div class="text-sm text-primary">
                                Tindakan :{{ $myQData['tindakan'] }}
                                </br>
                                Tujuan :{{ $myQData['tujuan'] }}
                                </br>
                                Resiko :{{ $myQData['resiko'] }}
                                </br>
                                Alternatif: {{ $myQData['alternatif'] }}
                                </br>
                                Dokter :{{ $myQData['dokter'] }}
                                </br>
                            </div>

                        </td>

                        <td class="px-4 py-3 group-hover:bg-gray-100 group-hover:text-primary">
                            {{ $myQData['agreement'] ? 'Setuju' : 'Tidak Setuju' }}
                            </br>
                            Wali :{{ $myQData['wali'] }}
                            </br>
                            Saksi :{{ $myQData['saksi'] }}
                            </br>
                            Petugas : {{ $myQData['petugasPemeriksa'] }}
                            </br>
                            Tanggal : {{ $myQData['signatureSaksiDate'] }}
                            </br>
                        </td>




                        <td class="px-4 py-3 group-hover:bg-gray-100 group-hover:text-primary">
                            <div class="grid w-full grid-cols-1 px-4 pb-4">
                                <x-primary-button
                                    wire:click.stop="cetakInformConsentPasienRJ('{{ $myQData['signatureDate'] }}')"
                                    wire:loading.attr="disabled"
                                    class="relative flex items-center justify-center gap-2 text-white">
                                    <div wire:loading wire:target="cetakInformConsentPasienRJ">
                                        <x-loading />
                                    </div>
                                    <span wire:loading.remove wire:target="cetakInformConsentPasienRJ">
                                        Cetak Persetujuan Tindakan Medis
                                    </span>
                                </x-primary-button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endisset

        </tbody>
    </table>

</div>
