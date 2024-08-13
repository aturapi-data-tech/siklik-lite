<div>

    <div class="w-full mb-1 ">



        @php
            $disabledProperty = true;

            $disabledPropertyRjStatus = false;

        @endphp








        <form class="scroll-smooth hover:scroll-auto">
            <div class="grid grid-cols-1">

                <div id="TransaksiRawatJalan" class="px-4">

                    {{-- ICD10 --}}
                    <div>
                        <div class="flex">
                            <div class="flex items-center justify-end w-full mr-5">
                                <x-text-input placeholder="Isi dgn data yang sesuai"
                                    class="mt-1 ml-2 sm:rounded-none sm:rounded-l-lg" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.diagAwal'))"
                                    :disabled=$disabledProperty value="{{ 'Masukkan Diagnosa ICD 10' }}" />

                                <x-green-button :disabled=false
                                    class="mt-1 sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                    wire:click.prevent="clickdataDiagnosaICD10lov()">
                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </x-green-button>
                                @error('SEPJsonReq.request.t_sep.diagAwal')
                                    <x-input-error :messages=$message />
                                @enderror
                            </div>
                        </div>
                        {{-- LOV Diagnosa --}}
                        <div class="relative mt-0 bg-red-300">
                            @include('livewire.mr-r-j.diagnosis.list-of-value-caridataDiagnosaICD10')
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="flex flex-col my-2">
                        <div class="overflow-x-auto rounded-lg">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden shadow sm:rounded-lg">
                                    <table class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-4 py-3">


                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Kode (ICD 10)
                                                    </x-sort-link>

                                                </th>

                                                <th scope="col" class="px-4 py-3 ">
                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Diagnosa
                                                    </x-sort-link>
                                                </th>

                                                <th scope="col" class="px-4 py-3">

                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Keterangan Diagnosa
                                                    </x-sort-link>
                                                </th>

                                                <th scope="col" class="px-4 py-3">

                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Kategori
                                                    </x-sort-link>
                                                </th>

                                                <th scope="col" class="w-8 px-4 py-3 text-center">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800">


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

                                                    <td
                                                        class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                        {{ $diag['ketdiagnosa'] }}
                                                    </td>

                                                    <td
                                                        class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                        {{ $diag['kategoriDiagnosa'] }}
                                                    </td>

                                                    <td
                                                        class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">

                                                        <x-alternative-button class="inline-flex"
                                                            wire:click.prevent="removeDiagICD10('{{ $diag['diagId'] }}')">
                                                            <svg class="w-5 h-5 text-gray-800 dark:text-white"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 18 20">
                                                                <path
                                                                    d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                                            </svg>
                                                            {{ 'Hapus ' . $diag['icdX'] }}
                                                        </x-alternative-button>

                                                    </td>




                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>







                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ICD 9 CM --}}
                    <div>
                        <div class="flex">
                            <div class="flex items-center justify-end w-full mr-5">
                                <x-text-input placeholder="Isi dgn data yang sesuai"
                                    class="mt-1 ml-2 sm:rounded-none sm:rounded-l-lg" :errorshas="__($errors->has('SEPJsonReq.request.t_sep.diagAwal'))"
                                    :disabled=$disabledProperty value="{{ 'Masukkan Diagnosa ICD 9 CM' }}" />

                                <x-green-button :disabled=false
                                    class="mt-1 sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                    wire:click.prevent="clickdataProcedureICD9Cmlov()">
                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </x-green-button>
                                @error('SEPJsonReq.request.t_sep.diagAwal')
                                    <x-input-error :messages=$message />
                                @enderror
                            </div>
                        </div>
                        {{-- LOV Diagnosa --}}
                        <div class="relative mt-0 bg-red-300">
                            @include('livewire.mr-r-j.diagnosis.list-of-value-caridataProcedureICD9Cm')
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="flex flex-col my-2">
                        <div class="overflow-x-auto rounded-lg">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden shadow sm:rounded-lg">
                                    <table class="w-full text-sm text-left text-gray-500 table-auto dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-4 py-3">


                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Kode (ICD 9 CM)
                                                    </x-sort-link>

                                                </th>

                                                <th scope="col" class="px-4 py-3 ">
                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
                                                        Prosedur
                                                    </x-sort-link>
                                                </th>

                                                <th scope="col" class="px-4 py-3">

                                                    <x-sort-link :active=false wire:click.prevent="" role="button"
                                                        href="#">
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
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 18 20">
                                                                <path
                                                                    d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                                            </svg>
                                                            {{ 'Hapus ' . $procedure['procedureId'] }}
                                                        </x-alternative-button>

                                                    </td>




                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>







                                </div>
                            </div>
                        </div>
                    </div>

                </div>






            </div>

            <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6">

                <div class="">
                    {{-- null --}}
                </div>
                <div>
                    <div wire:loading wire:target="store">
                        <x-loading />
                    </div>

                    <x-green-button :disabled=$disabledPropertyRjStatus wire:click.prevent="store()" type="button"
                        wire:loading.remove>
                        Simpan
                    </x-green-button>
                </div>
            </div>


        </form>







    </div>
























    {{-- push start ///////////////////////////////// --}}
    @push('scripts')
        {{-- script start --}}
        <script src="{{ url('assets/js/jquery.min.js') }}"></script>
        <script src="{{ url('assets/plugins/toastr/toastr.min.js') }}"></script>
        <script src="{{ url('assets/flowbite/dist/datepicker.js') }}"></script>

        {{-- script end --}}





        {{-- Disabling enter key for form --}}
        <script type="text/javascript">
            $(document).on("keydown", "form", function(event) {
                return event.key != "Enter";
            });
        </script>





        {{-- Global Livewire JavaScript Object start --}}
        <script type="text/javascript">
            window.livewire.on('toastr-success', message => toastr.success(message));
            window.Livewire.on('toastr-info', (message) => {
                toastr.info(message)
            });
            window.livewire.on('toastr-error', message => toastr.error(message));













            // confirmation message remove record
            window.livewire.on('confirm_remove_record', (key, name) => {

                let cfn = confirm('Apakah anda ingin menghapus data ini ' + name + '?');

                if (cfn) {
                    window.livewire.emit('confirm_remove_record_RJp', key, name);
                }
            });












            // confirmation cari_Data_Pasien_Tidak_Ditemukan_Confirmation
            window.livewire.on('cari_Data_Pasien_Tidak_Ditemukan_Confirmation', (msg) => {
                let cfn = confirm('Data ' + msg +
                    ' tidak ditemuka, apakah anda ingin menambahkan menjadi pasien baru ?');

                if (cfn) {
                    @this.set('callMasterPasien', true);
                }
            });




            // confirmation rePush_Data_Antrian_Confirmation
            window.livewire.on('rePush_Data_Antrian_Confirmation', () => {
                let cfn = confirm('Apakah anda ingin mengulaingi Proses Kirim data Antrian ?');

                if (cfn) {
                    // emit ke controller
                    window.livewire.emit('rePush_Data_Antrian');
                }
            });













            // press_dropdownButton flowbite
            window.Livewire.on('pressDropdownButton', (key) => {
                    // set the dropdown menu element
                    const $targetEl = document.getElementById('dropdownMenu' + key);

                    // set the element that trigger the dropdown menu on click
                    const $triggerEl = document.getElementById('dropdownButton' + key);

                    // options with default values
                    const options = {
                        placement: 'left',
                        triggerType: 'click',
                        offsetSkidding: 0,
                        offsetDistance: 10,
                        delay: 300,
                        onHide: () => {
                            console.log('dropdown has been hidden');

                        },
                        onShow: () => {
                            console.log('dropdown has been shown');
                        },
                        onToggle: () => {
                            console.log('dropdown has been toggled');
                        }
                    };

                    /*
                     * $targetEl: required
                     * $triggerEl: required
                     * options: optional
                     */
                    const dropdown = new Dropdown($targetEl, $triggerEl, options);

                    dropdown.show();

                }

            );
        </script>
        <script>
            // $("#dateRjRef").change(function() {
            //     const datepickerEl = document.getElementById('dateRjRef');
            //     console.log(datepickerEl);
            // });
        </script>
        {{-- Global Livewire JavaScript Object end --}}
    @endpush













    @push('styles')
        {{-- stylesheet start --}}
        <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toastr.min.css') }}">

        {{-- stylesheet end --}}
    @endpush
    {{-- push end --}}
</div>
