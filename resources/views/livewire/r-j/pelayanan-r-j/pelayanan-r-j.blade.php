<div>

    <div class="px-1 pt-7">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <!-- Card header -->



            <div class="w-full mb-1">
                <div class="">


                    {{-- text --}}
                    <div class="mb-5">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $myTitle }}</h3>
                        <span class="text-base font-normal text-gray-900 dark:text-gray-400">{{ $mySnipt }}</span>
                    </div>
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

                        {{-- date --}}
                        <div class="relative w-1/5 mt-2 ">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-900 dark:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
                                        <x-dropdown-link
                                            wire:click="setdrRjRef('{{ $dr['drId'] }}','{{ $dr['drName'] }}')">
                                            {{ __($dr['drName']) }}
                                        </x-dropdown-link>
                                    @endforeach
                                </x-slot>
                            </x-dropdown>
                        </div>

                    </div>





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
                                            <th scope="col" class="px-4 py-3 ">
                                                <x-sort-link :active=false wire:click.prevent="sortBy('RJp_id')"
                                                    role="button" href="#">
                                                    Pasien / Poli
                                                </x-sort-link>
                                            </th>

                                            <th scope="col" class="px-4 py-3 ">
                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    SEP
                                                </x-sort-link>
                                            </th>


                                            <th scope="col" class="px-4 py-3 ">
                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Status Layanan
                                                </x-sort-link>
                                            </th>




                                            <th scope="col" class="px-4 py-3 text-center ">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">


                                        @foreach ($RJpasiens as $RJp)
                                            @php
                                                $statusLayananBgcolor = $RJp->waktu_masuk_poli == null && $RJp->waktu_masuk_apt == null ? 'bg-yellow-100' : ($RJp->waktu_masuk_poli != null && $RJp->waktu_masuk_apt == null ? 'bg-red-100' : ($RJp->waktu_masuk_poli != null && $RJp->waktu_masuk_apt != null ? 'bg-green-100' : ''));
                                            @endphp
                                            <tr
                                                class="border-b group dark:border-gray-700 {{ $statusLayananBgcolor }}">

                                                <td
                                                    class="flex items-center px-4 py-3 group-hover:bg-gray-100 whitespace-nowrap dark:text-white">
                                                    <span
                                                        class="text-5xl font-semibold text-gray-700">{{ $RJp->no_antrian }}</span>
                                                    <div class="pl-3">
                                                        <div class="text-base font-semibold text-gray-700">
                                                            {{ $RJp->reg_no }}</div>
                                                        <div class="font-semibold text-primary">
                                                            {{ $RJp->reg_name . ' / (' . $RJp->sex . ')' . ' / ' . $RJp->thn }}
                                                        </div>
                                                        <div class="font-normal text-gray-900">
                                                            {{ $RJp->address }}
                                                        </div>

                                                        <div class="pt-2 font-semibold text-gray-700">
                                                            {{ $RJp->poli_desc }}
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
                                                    class="px-4 py-3 break-all group-hover:bg-gray-100 dark:text-white w-52">

                                                    <div class="mb-2 font-semibold text-primary">
                                                        {{ $RJp->vno_sep }}
                                                    </div>
                                                    <div>
                                                        {{ '' . $RJp->push_antrian_bpjs_status . $RJp->push_antrian_bpjs_json }}
                                                    </div>

                                                </td>

                                                <td
                                                    class="px-4 py-3 group-hover:bg-gray-100 whitespace-nowrap dark:text-white">
                                                    <div class="overflow-auto w-52">
                                                        <div class="font-semibold text-primary">
                                                            {{ $RJp->waktu_masuk_poli == null && $RJp->waktu_masuk_apt == null
                                                                ? 'Pendaftaran'
                                                                : ($RJp->waktu_masuk_poli != null && $RJp->waktu_masuk_apt == null
                                                                    ? 'Pelayanan ' . $RJp->poli_desc
                                                                    : ($RJp->waktu_masuk_poli != null && $RJp->waktu_masuk_apt != null
                                                                        ? 'Menunggu Resep'
                                                                        : '--')) }}
                                                        </div>

                                                        @if ($RJp->datadaftarpolirj_json)
                                                            <div class="font-normal text-gray-900">
                                                                {{ '' . $RJp->nobooking }}
                                                            </div>
                                                            <div class="italic font-normal text-gray-900">
                                                                {{ 'TaskId3 ' . json_decode($RJp->datadaftarpolirj_json)->taskIdPelayanan->taskId3 }}
                                                            </div>
                                                            <div class="italic font-normal text-gray-900">
                                                                {{ 'TaskId4 ' . json_decode($RJp->datadaftarpolirj_json)->taskIdPelayanan->taskId4 }}
                                                            </div>
                                                            <div class="italic font-normal text-gray-900">
                                                                {{ 'TaskId5 ' . json_decode($RJp->datadaftarpolirj_json)->taskIdPelayanan->taskId5 }}
                                                            </div>
                                                            <div class="italic font-normal text-gray-900">
                                                                {{ 'TaskId99 ' . json_decode($RJp->datadaftarpolirj_json)->taskIdPelayanan->taskId99 }}
                                                            </div>
                                                        @endif

                                                    </div>
                                                </td>

                                                <td class="px-4 py-3 group-hover:bg-gray-100 group-hover:text-primary">



                                                    <!-- Dropdown Action menu Flowbite-->
                                                    <div class="inline-flex">

                                                        <x-yellow-button
                                                            wire:click="masukPoli('{{ addslashes($RJp->rj_no) }}')"
                                                            wire:loading.remove>
                                                            Masuk Poli
                                                        </x-yellow-button>
                                                        <div wire:loading wire:target="masukPoli">
                                                            <x-loading />
                                                        </div>

                                                        <x-green-button
                                                            wire:click="keluarPoli('{{ addslashes($RJp->rj_no) }}')"
                                                            wire:loading.remove>
                                                            Keluar Poli
                                                        </x-green-button>
                                                        <div wire:loading wire:target="keluarPoli">
                                                            <x-loading />
                                                        </div>

                                                        <x-red-button
                                                            wire:click="$emit('confirm_batal_poli', '{{ addslashes($RJp->rj_no) }}', '{{ addslashes($RJp->reg_name) }}')"
                                                            wire:loading.remove class="ml-12">
                                                            Batal Poli
                                                        </x-red-button>
                                                        <div wire:loading wire:target="batalPoli">
                                                            <x-loading />
                                                        </div>

                                                    </div>
                                                    <div>
                                                        <x-primary-button
                                                            wire:click="getListTaskId('{{ addslashes($RJp->nobooking) }}')"
                                                            wire:loading.remove>
                                                            Get List Task Id BPJS
                                                        </x-primary-button>
                                                        <div wire:loading wire:target="getListTaskId">
                                                            <x-loading />
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
            window.livewire.on('confirm_batal_poli', (key, name) => {

                let cfn = confirm('Apakah anda ingin membatalkan data ini ' + name + '?');
                if (cfn) {
                    console.log(cfn)
                    window.livewire.emit('confirm_batal_poli_taskId', key, name);
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
