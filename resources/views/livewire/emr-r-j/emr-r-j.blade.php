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
                <div class="relative w-1/3 mr-2 pointer-events-auto">
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

                {{-- Tanggal --}}
                <div class="relative w-[150px] mr-2">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-900 dark:text-gray-400" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>

                    <x-text-input type="text" class="p-2 pl-10 " placeholder="[dd/mm/yyyy]"
                        wire:model="myTopBar.refDate" />
                </div>
                {{-- Tanggal --}}

                {{-- Shift --}}
                {{-- <div class="relative w-[75px]">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-800 " aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M1 5h1.424a3.228 3.228 0 0 0 6.152 0H19a1 1 0 1 0 0-2H8.576a3.228 3.228 0 0 0-6.152 0H1a1 1 0 1 0 0 2Zm18 4h-1.424a3.228 3.228 0 0 0-6.152 0H1a1 1 0 1 0 0 2h10.424a3.228 3.228 0 0 0 6.152 0H19a1 1 0 0 0 0-2Zm0 6H8.576a3.228 3.228 0 0 0-6.152 0H1a1 1 0 0 0 0 2h1.424a3.228 3.228 0 0 0 6.152 0H19a1 1 0 0 0 0-2Z" />
                        </svg>
                    </div>

                    <x-text-input type="text" class="w-full p-2 pl-10 " placeholder="[Shift 1/2/3]"
                        wire:model="myTopBar.refShiftId" />
                </div> --}}
                {{-- Shift --}}

                {{-- Status Transaksi --}}
                <div class="flex ml-2">
                    @foreach ($myTopBar['refStatusOptions'] as $refStatus)
                        {{-- @dd($refStatus) --}}
                        <x-radio-button :label="__($refStatus['refStatusDesc'])" value="{{ $refStatus['refStatusId'] }}"
                            wire:model="myTopBar.refStatusId" />
                    @endforeach
                </div>
                {{-- Status Transaksi --}}

                {{-- Dokter --}}
                <div>
                    <x-dropdown align="right" :width="__('80')" :contentclasses="__('overflow-auto max-h-[150px] py-1 bg-white dark:bg-gray-700')">
                        <x-slot name="trigger">
                            {{-- Button Dokter --}}
                            <x-alternative-button class="inline-flex whitespace-nowrap">
                                <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                                <span>{{ $myTopBar['drName'] }}</span>
                            </x-alternative-button>
                        </x-slot>
                        {{-- Open shiftcontent --}}
                        <x-slot name="content">

                            @foreach ($myTopBar['drOptions'] as $dr)
                                <x-dropdown-link
                                    wire:click="settermyTopBardrOptions('{{ $dr['drId'] }}','{{ addslashes($dr['drName']) }}')">
                                    {{ __($dr['drName']) }}
                                </x-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-dropdown>
                </div>



            </div>



            <div class="flex justify-end w-1/2">
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


            @if ($isOpen)
                @include('livewire.emr-r-j.create-emr-r-j')
            @endif

            @if ($isOpenDokter)
                @include('livewire.emr-r-j.create-emr-r-j-dokter')
            @endif

            @if ($isOpenScreening)
                @include('livewire.emr-r-j.create-screening-r-j')
            @endif

        </div>
        {{-- Top Bar --}}






        <div class="h-[calc(100vh-250px)] mt-2 overflow-auto">
            <!-- Table -->
            <table class="w-full text-sm text-left text-gray-700 table-auto ">
                <thead class="sticky top-0 text-xs text-gray-900 uppercase bg-gray-100 ">
                    <tr>
                        <th scope="col" class="w-1/4 px-4 py-3 ">
                            Pasien
                        </th>
                        <th scope="col" class="w-1/4 px-4 py-3 ">
                            Poli
                        </th>
                        <th scope="col" class="w-1/4 px-4 py-3 ">
                            Status Layanan
                        </th>
                        <th scope="col" class="w-1/4 px-4 py-3 ">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white ">

                    @foreach ($myQueryData as $myQData)
                        @php
                            $datadaftar_json = json_decode($myQData->datadaftarpolirj_json, true);
                            $anamnesa = isset($datadaftar_json['anamnesa']) ? 1 : 0;
                            $pemeriksaan = isset($datadaftar_json['pemeriksaan']) ? 1 : 0;
                            $penilaian = isset($datadaftar_json['penilaian']) ? 1 : 0;
                            $procedure = isset($datadaftar_json['procedure']) ? 1 : 0;
                            $diagnosis = isset($datadaftar_json['diagnosis']) ? 1 : 0;
                            $perencanaan = isset($datadaftar_json['perencanaan']) ? 1 : 0;
                            $prosentaseEMR =
                                (($anamnesa + $pemeriksaan + $penilaian + $procedure + $diagnosis + $perencanaan) / 6) *
                                100;

                            $bgSelesaiPemeriksaan = isset(
                                $datadaftar_json['perencanaan']['pengkajianMedis']['drPemeriksa'],
                            )
                                ? ($datadaftar_json['perencanaan']['pengkajianMedis']['drPemeriksa']
                                    ? 'bg-green-100'
                                    : '')
                                : '';

                            $badgecolorEmr = $prosentaseEMR >= 80 ? 'green' : 'red';

                            $badgecolorStatus = isset($myQData->rj_status)
                                ? ($myQData->rj_status === 'A'
                                    ? 'red'
                                    : ($myQData->rj_status === 'L'
                                        ? 'green'
                                        : ($myQData->rj_status === 'I'
                                            ? 'green'
                                            : ($myQData->rj_status === 'F'
                                                ? 'yellow'
                                                : 'default'))))
                                : '';

                            $badgecolorKlaim =
                                $myQData->klaim_id == 'UM'
                                    ? 'green'
                                    : ($myQData->klaim_id == 'JM'
                                        ? 'default'
                                        : ($myQData->klaim_id == 'KR'
                                            ? 'yellow'
                                            : 'red'));

                            $badgecolorAdministrasiRj = isset($datadaftar_json['AdministrasiRj']) ? 'green' : 'red';
                        @endphp


                        <tr class="border-b group {{ $bgSelesaiPemeriksaan }}">


                            <td class="px-4 py-3 group-hover:bg-gray-100 whitespace-nowrap ">
                                <div class="">
                                    <div class="font-semibold text-primary">
                                        {{ $myQData->reg_no }}
                                    </div>
                                    <div class="font-semibold text-gray-900">
                                        {{ $myQData->reg_name . ' / (' . $myQData->sex . ')' . ' / ' . $myQData->thn }}
                                    </div>
                                    <div class="font-normal text-gray-900">
                                        {{ $myQData->address }}
                                    </div>
                                </div>
                            </td>


                            <td class="px-4 py-3 group-hover:bg-gray-100 whitespace-nowrap ">
                                <div class="">
                                    <div class="font-semibold text-primary">{{ $myQData->poli_desc }}
                                    </div>
                                    <div class="font-semibold text-gray-900">
                                        {{ $myQData->dr_name . ' / ' }}
                                        <x-badge :badgecolor="__($badgecolorKlaim)">
                                            {{ $myQData->klaim_id == 'UM'
                                                ? 'UMUM'
                                                : ($myQData->klaim_id == 'JM'
                                                    ? 'BPJS'
                                                    : ($myQData->klaim_id == 'KR'
                                                        ? 'Kronis'
                                                        : 'Asuransi Lain')) }}
                                        </x-badge>

                                    </div>
                                    <div class="font-normal text-gray-900">
                                        {{ 'Nomer Pelayanan ' . $myQData->no_antrian }}
                                    </div>
                                    <div class="font-normal">
                                        {{ $myQData->vno_sep }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 group-hover:bg-gray-100 whitespace-nowrap ">
                                <div class="">
                                    <div class="font-semibold text-primary">
                                        {{ $myQData->rj_date }}
                                    </div>
                                    <div class="flex italic font-semibold text-gray-900">
                                        <x-badge :badgecolor="__($badgecolorStatus)">
                                            {{ isset($myQData->rj_status)
                                                ? ($myQData->rj_status === 'A'
                                                    ? 'Pelayanan'
                                                    : ($myQData->rj_status === 'L'
                                                        ? 'Selesai Pelayanan'
                                                        : ($myQData->rj_status === 'I'
                                                            ? 'Transfer Inap'
                                                            : ($myQData->rj_status === 'F'
                                                                ? 'Batal Transaksi'
                                                                : ''))))
                                                : '' }}
                                        </x-badge>
                                        <x-badge :badgecolor="__($badgecolorEmr)">
                                            Emr: {{ $prosentaseEMR . '%' }}
                                        </x-badge>
                                    </div>
                                    <div class="font-normal text-gray-900">
                                        {{ '' . $myQData->nobooking }}
                                    </div>
                                    {{-- <div class="font-normal text-gray-900 ">
                                        {{ '' . $myQData->push_antrian_bpjs_status . $myQData->push_antrian_bpjs_json }}
                                    </div> --}}
                                    <div class="font-normal text-gray-700">
                                        <x-badge :badgecolor="__($badgecolorAdministrasiRj)">
                                            Administrasi :
                                            @isset($datadaftar_json['AdministrasiRj'])
                                                {{ $datadaftar_json['AdministrasiRj']['userLog'] }}
                                            @else
                                                {{ '---' }}
                                            @endisset
                                        </x-badge>
                                    </div>

                                </div>
                            </td>

                            <td class="px-4 py-3 group-hover:bg-gray-100 group-hover:text-primary">


                                <div class="inline-flex">

                                    <livewire:cetak.cetak-etiket :regNo="$myQData->reg_no"
                                        :wire:key="'cetak-etiket-'.$myQData->rj_no">

                                        <!-- Dropdown Action menu Flowbite-->
                                        <div>
                                            <x-light-button id="dropdownButton{{ $myQData->rj_no }}"
                                                class="inline-flex"
                                                wire:click="$emit('pressDropdownButton','{{ $myQData->rj_no }}')">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </x-light-button>

                                            <!-- Dropdown Action Open menu -->
                                            <div id="dropdownMenu{{ $myQData->rj_no }}"
                                                class="z-10 hidden w-auto bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700">
                                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                    aria-labelledby="dropdownButton{{ $myQData->rj_no }}">
                                                    {{-- <li>
                                                        <x-dropdown-link wire:click="tampil('{{ $myQData->rj_no }}')">
                                                            {{ __('Tampil | ' . $myQData->reg_name) }}
                                                        </x-dropdown-link>
                                                    </li> --}}


                                                    @role('Admin')
                                                        <li>
                                                            <x-dropdown-link
                                                                wire:click="editScreening('{{ $myQData->rj_no }}','{{ $myQData->reg_no }}')">
                                                                {{ __('Screening') }}
                                                            </x-dropdown-link>
                                                        </li>

                                                        <li>
                                                            <x-dropdown-link
                                                                wire:click="editDokter('{{ $myQData->rj_no }}','{{ $myQData->reg_no }}')">
                                                                {{ __('Assessment Dokter') }}
                                                            </x-dropdown-link>
                                                        </li>

                                                        <li>
                                                            <x-dropdown-link
                                                                wire:click="edit('{{ $myQData->rj_no }}','{{ $myQData->reg_no }}')">
                                                                {{ __('Assessment Perawat') }}
                                                            </x-dropdown-link>
                                                        </li>
                                                    @endrole
                                                    @role('Mr')
                                                        <li>
                                                            <x-dropdown-link
                                                                wire:click="editScreening('{{ $myQData->rj_no }}','{{ $myQData->reg_no }}')">
                                                                {{ __('Screening') }}
                                                            </x-dropdown-link>
                                                        </li>

                                                        <li>
                                                            <x-dropdown-link
                                                                wire:click="editDokter('{{ $myQData->rj_no }}','{{ $myQData->reg_no }}')">
                                                                {{ __('Assessment Dokter') }}
                                                            </x-dropdown-link>
                                                        </li>

                                                        <li>
                                                            <x-dropdown-link
                                                                wire:click="edit('{{ $myQData->rj_no }}','{{ $myQData->reg_no }}')">
                                                                {{ __('Assessment Perawat') }}
                                                            </x-dropdown-link>
                                                        </li>
                                                    @endrole
                                                    @role('Perawat')
                                                        <li>
                                                            <x-dropdown-link
                                                                wire:click="editScreening('{{ $myQData->rj_no }}','{{ $myQData->reg_no }}')">
                                                                {{ __('Screening') }}
                                                            </x-dropdown-link>
                                                        </li>
                                                        <li>
                                                            <x-dropdown-link
                                                                wire:click="edit('{{ $myQData->rj_no }}','{{ $myQData->reg_no }}')">
                                                                {{ __('Assessment Perawat') }}
                                                            </x-dropdown-link>
                                                        </li>
                                                    @endrole
                                                    @role('Dokter')
                                                        <li>
                                                            <x-dropdown-link
                                                                wire:click="editDokter('{{ $myQData->rj_no }}','{{ $myQData->reg_no }}')">
                                                                {{ __('Assessment Dokter') }}
                                                            </x-dropdown-link>
                                                        </li>
                                                        <li>
                                                            <x-dropdown-link
                                                                wire:click="edit('{{ $myQData->rj_no }}','{{ $myQData->reg_no }}')">
                                                                {{ __('Assessment') }}
                                                            </x-dropdown-link>
                                                        </li>
                                                    @endrole

                                                    {{-- <li>
                                                        <x-dropdown-link
                                                            wire:click="$emit('confirm_remove_record', '{{ $myQData->rj_no }}', '{{ $myQData->reg_name }}')">
                                                            {{ __('Hapus') }}
                                                        </x-dropdown-link>
                                                    </li> --}}

                                                </ul>
                                            </div>
                                        </div>
                                        <!-- End Dropdown Action Open menu -->
                                        @role(['Admin', 'Mr', 'Perawat'])
                                            <livewire:emr-r-j.post-encounter-r-j.post-encounter-r-j :rjNoRef="$myQData->rj_no"
                                                :wire:key="'post-encounter-r-j-'.$myQData->rj_no">
                                            @endrole

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

        {{ $myQueryData->links() }}








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





        {{-- Disabling enter key for form --}}
        <script type="text/javascript">
            $(document).on("keydown", "form", function(event) {
                return event.key != "Enter";
            });
        </script>





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













            // confirmation message remove record
            window.livewire.on('confirm_remove_record', (key, name) => {

                let cfn = confirm('Apakah anda ingin menghapus data ini ' + name + '?');

                if (cfn) {
                    window.livewire.emit('confirm_remove_record_RJp', key, name);
                }
            });


            // confirmation message doble record
            window.livewire.on('confirm_doble_record', (key, name) => {

                let cfn = confirm('Pasien Sudah terdaftar, Apakah anda ingin tetap menyimpan data ini ' + name + '?');

                if (cfn) {
                    window.livewire.emit('confirm_doble_record_RJp', key, name);
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

        {{-- Global Livewire JavaScript Object start --}}
        <script type="text/javascript">
            // confirmation message doble record
            window.livewire.on('confirm_doble_recordUGD', (key, name) => {
                console.log('x')
                let cfn = confirm('Pasien Sudah terdaftar, Apakah anda ingin tetap menyimpan data ini ' + name + '?');

                if (cfn) {
                    window.livewire.emit('confirm_doble_record_UGDp', key, name);
                }
            });
        </script>
    @endpush













    @push('styles')
        {{-- stylesheet start --}}
        <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toastr.min.css') }}">

        {{-- stylesheet end --}}
    @endpush
    {{-- push end --}}

</div>
