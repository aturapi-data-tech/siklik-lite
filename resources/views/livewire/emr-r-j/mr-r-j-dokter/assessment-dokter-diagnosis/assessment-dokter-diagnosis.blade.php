<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp
    {{-- jika anamnesa kosong ngak usah di render --}}
    {{-- @if (isset($dataDaftarPoliRJ['diagnosis'])) --}}
    <div class="w-full mb-1 ">

        <div id="TransaksiRawatJalan" class="p-2">
            <div id="TransaksiRawatJalan">

                <div class="p-2 rounded-lg bg-gray-50">
                    <div class="grid grid-cols-1">

                        <div id="TransaksiRawatJalan" class="px-4">
                            <x-input-label for="" :value="__('Diagnosis ICD')" :required="__(false)" class="pt-2 sm:text-xl" />

                            {{-- ICD10 --}}
                            <div>
                                {{-- LOV Diagnosa --}}
                                @include('livewire.emr-r-j.mr-r-j.diagnosis.list-of-value-caridataDiagnosaICD10')
                            </div>

                            <!-- Table -->
                            <div class="flex flex-col my-2">
                                <div class="overflow-x-auto rounded-lg">
                                    <div class="inline-block min-w-full align-middle">
                                        <div class="overflow-hidden shadow sm:rounded-lg">
                                            <table
                                                class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
                                                <thead
                                                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                                    <tr>
                                                        <th scope="col" class="px-4 py-3">


                                                            <x-sort-link :active=false wire:click.prevent=""
                                                                role="button" href="#">
                                                                Kode (ICD 10)
                                                            </x-sort-link>

                                                        </th>

                                                        <th scope="col" class="px-4 py-3 ">
                                                            <x-sort-link :active=false wire:click.prevent=""
                                                                role="button" href="#">
                                                                Diagnosa
                                                            </x-sort-link>
                                                        </th>

                                                        {{-- <th scope="col" class="px-4 py-3">

                                                            <x-sort-link :active=false wire:click.prevent=""
                                                                role="button" href="#">
                                                                Keterangan Diagnosa
                                                            </x-sort-link>
                                                        </th> --}}

                                                        <th scope="col" class="px-4 py-3">

                                                            <x-sort-link :active=false wire:click.prevent=""
                                                                role="button" href="#">
                                                                Kategori
                                                            </x-sort-link>
                                                        </th>

                                                        <th scope="col" class="w-8 px-4 py-3 text-center">
                                                            Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white dark:bg-gray-800">

                                                    @isset($dataDaftarPoliRJ['diagnosis'])
                                                        @foreach ($dataDaftarPoliRJ['diagnosis'] as $key => $diag)
                                                            <tr class="border-b group dark:border-gray-700">

                                                                <td
                                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                    {{ $diag['icdX'] }}
                                                                </td>

                                                                <td
                                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                    {{ $diag['diagDesc'] }}
                                                                </td>

                                                                {{-- <td
                                                                class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                {{ $diag['ketdiagnosa'] }}
                                                            </td> --}}

                                                                <td
                                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                    {{ $diag['kategoriDiagnosa'] }}
                                                                </td>

                                                                <td
                                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">

                                                                    <x-alternative-button class="inline-flex"
                                                                        wire:click.prevent="removeDiagnosaICD10('{{ isset($diag['rjDtlDtl']) ? $diag['rjDtlDtl'] : 0 }}')">
                                                                        <svg class="w-5 h-5 text-gray-800 dark:text-white"
                                                                            aria-hidden="true"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            fill="currentColor" viewBox="0 0 18 20">
                                                                            <path
                                                                                d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                                                        </svg>
                                                                        {{ 'Hapus ' . $diag['icdX'] }}
                                                                    </x-alternative-button>

                                                                </td>




                                                            </tr>
                                                        @endforeach
                                                    @endisset



                                                </tbody>
                                            </table>







                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ICD 9 CM --}}
                            <div>
                                {{-- LOV Diagnosa --}}
                                @include('livewire.emr-r-j.mr-r-j.diagnosis.list-of-value-caridataProcedureICD9Cm')
                            </div>

                            <!-- Table -->
                            <div class="flex flex-col my-2">
                                <div class="overflow-x-auto rounded-lg">
                                    <div class="inline-block min-w-full align-middle">
                                        <div class="overflow-hidden shadow sm:rounded-lg">
                                            <table
                                                class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
                                                <thead
                                                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                                    <tr>
                                                        <th scope="col" class="px-4 py-3">


                                                            <x-sort-link :active=false wire:click.prevent=""
                                                                role="button" href="#">
                                                                Kode (ICD 9 CM)
                                                            </x-sort-link>

                                                        </th>

                                                        <th scope="col" class="px-4 py-3 ">
                                                            <x-sort-link :active=false wire:click.prevent=""
                                                                role="button" href="#">
                                                                Prosedur
                                                            </x-sort-link>
                                                        </th>

                                                        <th scope="col" class="px-4 py-3">

                                                            <x-sort-link :active=false wire:click.prevent=""
                                                                role="button" href="#">
                                                                Keterangan Prosedur
                                                            </x-sort-link>
                                                        </th>

                                                        {{-- <th scope="col" class="px-4 py-3">

                                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                                    href="#">
                                                                    Kategori
                                                                </x-sort-link>
                                                            </th> --}}

                                                        <th scope="col" class="w-8 px-4 py-3 text-center">
                                                            Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white dark:bg-gray-800">

                                                    @isset($dataDaftarPoliRJ['procedure'])
                                                        @foreach ($dataDaftarPoliRJ['procedure'] as $key => $procedure)
                                                            <tr class="border-b group dark:border-gray-700">

                                                                <td
                                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                    {{ $procedure['procedureId'] }}
                                                                </td>

                                                                <td
                                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                    {{ $procedure['procedureDesc'] }}
                                                                </td>

                                                                <td
                                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                    {{ $procedure['ketProcedure'] }}
                                                                </td>

                                                                {{-- <td
                                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                                    {{ $procedure['kategoriprocedurenosa'] }}
                                                                </td> --}}

                                                                <td
                                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">

                                                                    <x-alternative-button class="inline-flex"
                                                                        wire:click.prevent="removeProcedureICD9Cm('{{ $procedure['procedureId'] }}')">
                                                                        <svg class="w-5 h-5 text-gray-800 dark:text-white"
                                                                            aria-hidden="true"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            fill="currentColor" viewBox="0 0 18 20">
                                                                            <path
                                                                                d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                                                        </svg>
                                                                        {{ 'Hapus ' . $procedure['procedureId'] }}
                                                                    </x-alternative-button>

                                                                </td>




                                                            </tr>
                                                        @endforeach
                                                    @endisset


                                                </tbody>
                                            </table>







                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>






                    </div>

                </div>
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
                    Simpan Assesment
                </x-green-button>
            </div>
        </div> --}}

    </div>
    {{-- @endif --}}

</div>
