<div>

    <div class="px-1 pt-7">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <!-- Card header -->



            <div class="w-full mb-1">
                <div class="">


                    {{-- text --}}
                    {{-- <div class="mb-5">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $myTitle }}</h3>
                        <span class="text-base font-normal text-gray-900 dark:text-gray-400">{{ $mySnipt }}</span>
                    </div> --}}
                    {{-- end text --}}



                    <div class="md:flex md:justify-between">

                        {{-- search --}}
                        <div class="relative pointer-events-auto md:w-1/2">
                            <div class="absolute inset-y-0 left-0 flex items-center p-5 pl-3 pointer-events-none">
                                <svg width="24" height="24" fill="none" aria-hidden="true"
                                    class="flex-none mr-3">
                                    <path d="m19 19-3.5-3.5" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                </svg>
                            </div>
                            <x-text-input id="simpleSearch" name="namesimpleSearch" type="text" class="p-2 pl-10"
                                autofocus autocomplete="simpleSearch" placeholder="Cari Data"
                                wire:model.lazy="search" />
                        </div>
                        {{-- end search --}}



                        {{-- two button --}}
                        <div class="flex justify-between mt-2 md:mt-0">

                            <x-dropdown align="right" :width="__('20')">
                                <x-slot name="trigger">
                                    {{-- Button myLimitPerPage --}}
                                    <x-alternative-button class="inline-flex">
                                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                        Tampil ({{ $limitPerPage }})
                                    </x-alternative-button>
                                </x-slot>
                                {{-- Open myLimitPerPagecontent --}}
                                <x-slot name="content">

                                    @foreach ($myLimitPerPages as $myLimitPerPage)
                                        <x-dropdown-link wire:click="setLimitPerPage({{ $myLimitPerPage }})">
                                            {{ __($myLimitPerPage) }}
                                        </x-dropdown-link>
                                    @endforeach
                                </x-slot>
                            </x-dropdown>
                        </div>
                        {{-- end two button --}}

                    </div>


                    <div class="flex rounded-lg bg-gray-50">

                        {{-- Dokter --}}
                        <div class="mt-2 ml-2">
                            <x-dropdown align="right" :width="__('80')" :contentclasses="__('overflow-auto max-h-[150px] py-1 bg-white dark:bg-gray-700')">
                                <x-slot name="trigger">
                                    {{-- Button Dokter --}}
                                    <x-alternative-button class="inline-flex w-80">
                                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                        <span>{{ 'Dokter ( ' . $drRjRef['drName'] . ' )' }}</span>
                                    </x-alternative-button>
                                </x-slot>
                                {{-- Open shiftcontent --}}
                                <x-slot name="content">

                                    @foreach ($drRjRef['drOptions'] as $dr)
                                        <x-dropdown-link
                                            wire:click="setdrRjRef('{{ $dr['drId'] }}','{{ $dr['drName'] }}')">
                                            {{ __($dr['drName']) }}
                                        </x-dropdown-link>
                                    @endforeach
                                </x-slot>
                            </x-dropdown>
                        </div>

                    </div>

                    @if ($isOpen)
                        @include('livewire.r-iskdp.create')
                    @endif



                </div>



                <!-- Table -->
                <div class="flex flex-col mt-2">
                    <div class="overflow-x-auto rounded-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-900 table-auto dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="w-1/3 px-4 py-3 ">
                                                <x-sort-link :active=false wire:click.prevent="sortBy('RJp_id')"
                                                    role="button" href="#">
                                                    Pasien
                                                </x-sort-link>
                                            </th>

                                            <th scope="col" class="w-1/3 px-4 py-3">
                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    SEP
                                                </x-sort-link>
                                            </th>
                                            <th scope="col" class="w-1/3 px-4 py-3">
                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Poli
                                                </x-sort-link>
                                            </th>
                                            <th scope="col" class="w-1/3 px-4 py-3 ">
                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Kontrol
                                                </x-sort-link>
                                            </th>




                                            <th scope="col" class="w-8 px-4 py-3 text-center">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">


                                        @foreach ($RJpasiens as $RJp)
                                            <tr class="border-b group dark:border-gray-700">

                                                <td
                                                    class="flex px-4 py-3 font-medium group-hover:bg-gray-100 group-hover:text-primary whitespace-nowrap dark:text-white">
                                                    <img class="w-10 h-10 rounded-full" src="profile-picture-1.jpg"
                                                        alt="Jese image">
                                                    <div class="pl-3">
                                                        <div class="text-base font-semibold text-gray-700">
                                                            {{ $RJp->reg_no }}</div>
                                                        <div class="font-semibold text-primary">
                                                            {{ $RJp->reg_name . ' / (' . $RJp->sex . ')' . ' / ' . $RJp->thn }}
                                                        </div>
                                                        <div class="font-normal text-gray-900">
                                                            {{ $RJp->address }}
                                                        </div>
                                                    </div>
                                                </td>


                                                <td
                                                    class="px-4 py-3 group-hover:bg-gray-100 group-hover:text-primary whitespace-nowrap dark:text-white">
                                                    {{ $RJp->vno_sep }}
                                                </td>


                                                <td
                                                    class="px-4 py-3 group-hover:bg-gray-100 whitespace-nowrap dark:text-white">
                                                    <div class="">
                                                        <div class="font-semibold text-primary">{{ $RJp->poli_desc }}
                                                        </div>
                                                        <div class="font-semibold text-gray-900">
                                                            {{ $RJp->dr_name . ' / ' }}
                                                            {{ $RJp->klaim_id == 'UM'
                                                                ? 'UMUM'
                                                                : ($RJp->klaim_id == 'JM'
                                                                    ? 'BPJS'
                                                                    : ($RJp->klaim_id == 'KR'
                                                                        ? 'Kronis'
                                                                        : 'Asuransi Lain')) }}
                                                        </div>
                                                        <div class="font-normal text-gray-900">
                                                            {{ 'Tanggal : ' . $RJp->rj_date }}
                                                        </div>
                                                    </div>
                                                </td>

                                                <td
                                                    class="px-4 py-3 group-hover:bg-gray-100 whitespace-nowrap dark:text-white">
                                                    <div class="overflow-auto w-52">
                                                        <div class="italic font-normal text-gray-900">
                                                            {{ 'Kontrol RS : ' .
                                                                (isset(json_decode($RJp->datadaftarri_json)->kontrol->noKontrolRS)
                                                                    ? (json_decode($RJp->datadaftarri_json)->kontrol->noKontrolRS
                                                                        ? json_decode($RJp->datadaftarri_json)->kontrol->noKontrolRS
                                                                        : '')
                                                                    : '') }}
                                                        </div>
                                                        <div class="italic font-normal text-gray-900">
                                                            {{ 'SKDP BPJS : ' .
                                                                (isset(json_decode($RJp->datadaftarri_json)->kontrol->noSKDPBPJS)
                                                                    ? (json_decode($RJp->datadaftarri_json)->kontrol->noSKDPBPJS
                                                                        ? json_decode($RJp->datadaftarri_json)->kontrol->noSKDPBPJS
                                                                        : '')
                                                                    : '') }}
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-4 py-3 group-hover:bg-gray-100 group-hover:text-primary">



                                                    <!-- Dropdown Action menu Flowbite-->
                                                    <div>
                                                        <x-light-button id="dropdownButton{{ $RJp->rihdr_no }}"
                                                            class="inline-flex"
                                                            wire:click="$emit('pressDropdownButton','{{ $RJp->rihdr_no }}')">
                                                            <svg class="w-5 h-5" aria-hidden="true"
                                                                fill="currentColor" viewbox="0 0 20 20"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg>
                                                        </x-light-button>

                                                        <!-- Dropdown Action Open menu -->
                                                        <div id="dropdownMenu{{ $RJp->rihdr_no }}"
                                                            class="z-10 hidden w-auto bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700">
                                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                                aria-labelledby="dropdownButton{{ $RJp->rihdr_no }}">

                                                                <li>
                                                                    <x-dropdown-link
                                                                        wire:click="edit('{{ $RJp->rihdr_no }}')">
                                                                        {{ __('Buat SKDP') }}
                                                                    </x-dropdown-link>
                                                                </li>


                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- End Dropdown Action Open menu -->


                                                </td>
                                            </tr>
                                        @endforeach



                                    </tbody>
                                </table>



                                {{-- no data found start --}}
                                @if ($RJpasiens->count() == 0)
                                    <div class="w-full p-4 text-sm text-center text-gray-900 dark:text-gray-400">
                                        {{ 'Data ' . $myProgram . ' Tidak ditemukan' }}
                                    </div>
                                @endif
                                {{-- no data found end --}}



                            </div>
                        </div>
                    </div>
                </div>



                <!-- Pagination start -->
                <div class="flex items-center justify-end pt-3 sm:pt-6">
                    {{-- {{ $RJpasiens->links() }} --}}
                    {{ $RJpasiens->links('vendor.livewire.tailwind') }}
                </div>
                <!-- Pagination end -->



            </div>
        </div>
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
