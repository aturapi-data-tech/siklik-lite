<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp

    <div class="w-full mb-1 ">

        <div class="grid grid-cols-1">

            <div id="TransaksiRawatJalan" class="px-4">
                <x-input-label for="" :value="__($myTitle)" :required="__(false)" class="pt-2 sm:text-xl" />
                <p class="text-sm text-gray-700">{{ $mySnipt }}</p>



                <!-- Table -->
                <div class="flex flex-col my-2">
                    <div class="overflow-x-auto rounded-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="w-1/3 px-4 py-3 overflow-auto">

                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Pemeriksaan
                                                </x-sort-link>
                                            </th>

                                            <th scope="col" class="w-8 px-4 py-3 text-center">
                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Hasil Radiologi
                                                </x-sort-link>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">

                                        @foreach ($myQueryData as $myQData)
                                            <tr class="border-b group dark:border-gray-700">
                                                <td
                                                    class="px-4 py-3 text-gray-900 group-hover:bg-gray-100 whitespace-nowrap">
                                                    <div class="italic">
                                                        {{ 'Radiologi ' }}{{ $myQData->rad_rjri === 'RI'
                                                            ? 'Rawat Inap'
                                                            : ($myQData->rad_rjri === 'UGD'
                                                                ? 'UGD'
                                                                : ($myQData->rad_rjri === 'RJ'
                                                                    ? 'Rawat Jalan'
                                                                    : '-')) }}
                                                    </div>
                                                    <div class="font-semibold text-primary">
                                                        {{ 'Tanggal rad :' }} {{ $myQData->rad_date }}
                                                    </div>

                                                    <div class="font-semibold text-gray-900">
                                                        {{ $myQData->rad_desc }}
                                                    </div>

                                                    <div class="font-semibold text-gray-900">
                                                        {{ $myQData->txn_no_dtl }}
                                                        {{ $myQData->rad_upload_pdf }}
                                                    </div>

                                                    <div class="text-gray-900 ">
                                                        {{ $myQData->rad_upload_pdf ? 'Selesai' : 'Proses' }}
                                                    </div>


                                                </td>

                                                <td
                                                    class="px-4 py-3 text-gray-900 group-hover:bg-gray-100 whitespace-nowrap">
                                                    <div class="grid justify-center">
                                                        <x-yellow-button
                                                            wire:click.prevent="openModalLayanan('{{ $myQData->rad_upload_pdf }}')"
                                                            type="button" wire:loading.remove>
                                                            Hasil Radiologi
                                                        </x-yellow-button>
                                                        <div wire:loading wire:target="openModalLayanan">
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
                    @if ($isOpenRekamMedisRadiologi)
                        @include('livewire.emr.radiologi.create-radiologi')
                    @endif

                </div>
            </div>



        </div>
    </div>
</div>
