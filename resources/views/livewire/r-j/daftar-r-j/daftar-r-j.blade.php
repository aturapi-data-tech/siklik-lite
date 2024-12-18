<div>

    {{-- Start Coding  --}}

    {{-- Canvas
    Main BgColor /
    Size H/W --}}
    <div class="w-full h-[calc(100vh-68px)] bg-white border border-gray-200 px-4 pt-6">

        {{-- Title  --}}
        <div class="mb-2">
            <h3 class="text-3xl font-bold text-gray-900 ">{{ $myTitle }}</h3>
            <span class="text-base font-normal text-gray-700">{{ $mySnipt }}</span>
        </div>
        {{-- Title --}}

        {{-- Top Bar --}}
        <div class="flex justify-between">

            <div class="flex w-full">

                {{-- Cari Data --}}
                <div class="relative w-2/3 mr-2 pointer-events-auto">
                    <div class="absolute inset-y-0 left-0 flex items-center p-5 pl-3 pointer-events-none ">
                        <svg width="24" height="24" fill="none" aria-hidden="true" class="flex-none mr-3 ">
                            <path d="m19 19-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></circle>
                        </svg>
                    </div>

                    <x-text-input type="text" class="w-full p-2 pl-10" placeholder="Cari Data" autofocus
                        wire:model="refFilter" />
                </div>
                {{-- Cari Data --}}

            </div>

            <div class="flex justify-end w-1/2">
                <x-primary-button wire:click="create()" class="flex justify-center ">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Daftar {{ $myProgram }}
                </x-primary-button>



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
                            <x-dropdown-link wire:click="$set('limitPerPage', '{{ $myLimitPerPage }}')">
                                {{ __($myLimitPerPage) }}
                            </x-dropdown-link>
                        @endforeach
                    </x-slot>
                </x-dropdown>
            </div>

        </div>

        <div class="flex rounded-lg bg-gray-50">

            {{-- date --}}
            <div class="relative w-1/5 mt-2 ">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-900 dark:text-gray-400" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>


                <x-text-input id="dateRjRef" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy"
                    type="text" class="p-2 pl-10 " placeholder="dd/mm/yyyy" wire:model="dateRjRef" />
            </div>

            {{-- radio --}}
            <div class="flex mt-2 ml-2">
                @foreach ($statusRjRef['statusOptions'] as $sRj)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($sRj['statusDesc'])" value="{{ $sRj['statusId'] }}"
                        wire:model="statusRjRef.statusId" />
                @endforeach
            </div>

            {{-- shift --}}
            {{-- <div class="mt-2 ml-0">
                <x-dropdown align="right" :width="__('20')" class="">
                    <x-slot name="trigger">
                        <x-alternative-button class="inline-flex">
                            <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                            <span>{{ 'Shift' . $shiftRjRef['shiftDesc'] }}</span>
                        </x-alternative-button>
                    </x-slot>
                    <x-slot name="content">

                        @foreach ($shiftRjRef['shiftOptions'] as $shift)
                            <x-dropdown-link wire:click="setShift({{ $shift['shiftId'] }},{{ $shift['shiftDesc'] }})">
                                {{ __($shift['shiftDesc']) }}
                            </x-dropdown-link>
                        @endforeach
                    </x-slot>
                </x-dropdown>
            </div> --}}

            {{-- Dokter --}}
            <div class="mt-2 ml-0">
                <x-dropdown align="right" :width="__('80')" :contentclasses="__('overflow-auto max-h-[150px] py-1 bg-white dark:bg-gray-700')">
                    <x-slot name="trigger">
                        {{-- Button Dokter --}}
                        <x-alternative-button class="inline-flex">
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
                            <x-dropdown-link wire:click="setdrRjRef('{{ $dr['drId'] }}','{{ $dr['drName'] }}')">
                                {{ __($dr['drName']) }}
                            </x-dropdown-link>
                        @endforeach
                    </x-slot>
                </x-dropdown>
            </div>

            @if ($isOpen)
                @include('livewire.r-j.daftar-r-j.create')
            @endif


        </div>
        {{-- Top Bar --}}

        {{-- Table Grid --}}
        <div class="h-[calc(100vh-250px)] mt-2 overflow-auto">
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
                                                Poli
                                            </x-sort-link>
                                        </th>
                                        <th scope="col" class="w-1/3 px-4 py-3 ">
                                            <x-sort-link :active=false wire:click.prevent="" role="button"
                                                href="#">
                                                Status Layanan
                                            </x-sort-link>
                                        </th>




                                        <th scope="col" class="w-1/3 px-4 py-3 text-center">Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">


                                    @foreach ($myQueryData as $RJp)
                                        <tr class="border-b group dark:border-gray-700">


                                            <td
                                                class="px-4 py-3 group-hover:bg-gray-100 whitespace-nowrap dark:text-white">
                                                <div class="">
                                                    <div class="font-semibold text-primary">
                                                        {{ $RJp->reg_no }}
                                                    </div>
                                                    <div class="font-semibold text-gray-900">
                                                        {{ $RJp->reg_name . ' / (' . $RJp->sex . ')' . ' / ' . $RJp->thn }}
                                                    </div>
                                                    <div class="font-normal text-gray-900">
                                                        {{ $RJp->address }}
                                                    </div>
                                                </div>
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
                                                        {{ 'Nomer Pelayanan ' . $RJp->no_antrian }}
                                                    </div>
                                                </div>
                                            </td>

                                            <td
                                                class="px-4 py-3 group-hover:bg-gray-100 whitespace-nowrap dark:text-white">
                                                <div class="overflow-auto w-52">
                                                    <div class="font-semibold text-primary">{{ $RJp->rj_status }}
                                                    </div>
                                                    <div class="font-semibold text-gray-900">
                                                        {{ '' . $RJp->nobooking }}
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-4 py-3 group-hover:bg-gray-100 group-hover:text-primary">


                                                <div class="inline-flex">

                                                    {{-- <livewire:cetak.cetak-etiket :regNo="$RJp->reg_no"
                                                        :wire:key="$RJp->rj_no"> --}}

                                                    <!-- Dropdown Action menu Flowbite-->
                                                    <div>
                                                        <x-light-button id="dropdownButton{{ $RJp->rj_no }}"
                                                            class="inline-flex"
                                                            wire:click="$emit('pressDropdownButton','{{ $RJp->rj_no }}')">
                                                            <svg class="w-5 h-5" aria-hidden="true"
                                                                fill="currentColor" viewbox="0 0 20 20"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg>
                                                        </x-light-button>

                                                        <!-- Dropdown Action Open menu -->
                                                        <div id="dropdownMenu{{ $RJp->rj_no }}"
                                                            class="z-10 hidden w-auto bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700">
                                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                                aria-labelledby="dropdownButton{{ $RJp->rj_no }}">
                                                                <li>
                                                                    <x-dropdown-link
                                                                        wire:click="tampil('{{ $RJp->rj_no }}')">
                                                                        {{ __('Tampil | ' . $RJp->reg_name) }}
                                                                    </x-dropdown-link>
                                                                </li>
                                                                <li>
                                                                    <x-dropdown-link
                                                                        wire:click="edit('{{ $RJp->rj_no }}')">
                                                                        {{ __('Ubah') }}
                                                                    </x-dropdown-link>
                                                                </li>
                                                                <li>
                                                                    <x-dropdown-link
                                                                        wire:click="$emit('confirm_remove_record', '{{ $RJp->rj_no }}', '{{ $RJp->reg_name }}')">
                                                                        {{ __('Hapus') }}
                                                                    </x-dropdown-link>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- End Dropdown Action Open menu -->
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>



                            {{-- no data found start --}}
                            @if ($myQueryData->count() == 0)
                                <div class="w-full p-4 text-sm text-center text-gray-900 dark:text-gray-400">
                                    {{ 'Data ' . $myProgram . ' Tidak ditemukan' }}
                                </div>
                            @endif
                            {{-- no data found end --}}



                        </div>
                    </div>
                </div>
            </div>



        </div>
        {{-- Table Grid --}}

        {{-- pagination --}}
        {{ $myQueryData->links() }}
        {{-- pagination --}}


    </div>



    {{-- Canvas
    Main BgColor /
    Size H/W --}}

    {{-- End Coding --}}




















    {{-- push start ///////////////////////////////// --}}
    @push('scripts')
        {{-- script start --}}
        <script src="{{ url('assets/js/jquery.min.js') }}"></script>
        <script src="{{ url('assets/plugins/toastr/toastr.min.js') }}"></script>
        <script src="{{ url('assets/flowbite/dist/datepicker.js') }}"></script>

        {{-- script end --}}


        {{-- Global Livewire JavaScript Object start --}}
        <script type="text/javascript">
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-left",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            window.livewire.on('toastr-success', message => toastr.success(message));
            window.Livewire.on('toastr-info', (message) => {
                toastr.info(message)
            });
            window.livewire.on('toastr-error', message => toastr.error(message));





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

        {{-- Global Livewire JavaScript Object end --}}
    @endpush













    @push('styles')
        {{-- stylesheet start --}}
        <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toastr.min.css') }}">

        {{-- stylesheet end --}}
    @endpush
    {{-- push end --}}

</div>
