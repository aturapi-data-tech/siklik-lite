<div>


    <div class="px-1 pt-7">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <!-- Card header -->
            <div class="w-full mb-1">

                <div id="TopBarMenuMaster" class="">

                    {{-- text Title --}}
                    <div class="mb-2">
                        <h3 class="text-2xl font-bold text-midnight dark:text-white">{{ $myTitle }}</h3>
                        <span class="text-base font-normal text-gray-500 dark:text-gray-400">{{ $mySnipt }}</span>
                    </div>
                    {{-- end text Title --}}


                    {{-- Tools --}}
                    <div class="md:flex md:justify-between">

                        {{-- search --}}
                        <div class="md:w-1/2">
                            <label for="mobile-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <x-text-input type="text" class="pl-10 p-2.5" placeholder="Cari Data"
                                    wire:model.lazy="search" autofocus />
                            </div>

                        </div>
                        {{-- end search --}}

                        {{-- two button --}}
                        <div class="flex justify-between mt-2 md:mt-0">
                            <x-primary-button wire:click="create()" class="flex justify-center flex-auto">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Tambah Data {{ $myProgram }}
                            </x-primary-button>



                            <x-dropdown align="right" width="48">
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
                    {{-- End Tools --}}
                    @error('dataPasien.pasien.regNo')
                        <x-input-error :messages=$message />
                    @enderror

                    @if ($isOpen)
                        @include('livewire.master-pasien.create')
                    @endif



                </div>



                <!-- Table -->
                <div class="flex flex-col mt-6">
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
                                                    No Identitas
                                                </x-sort-link>

                                            </th>

                                            <th scope="col" class="px-4 py-3 ">
                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Pasien
                                                </x-sort-link>
                                            </th>

                                            <th scope="col" class="px-4 py-3">

                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Status
                                                </x-sort-link>
                                            </th>

                                            <th scope="col" class="px-4 py-3">

                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    No Hp
                                                </x-sort-link>
                                            </th>

                                            <th scope="col" class="px-4 py-3">

                                                <x-sort-link :active=false wire:click.prevent="" role="button"
                                                    href="#">
                                                    Tgl Daftar
                                                </x-sort-link>
                                            </th>




                                            <th scope="col" class="w-8 px-4 py-3 text-center">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">


                                        @foreach ($pasiens as $p)
                                            <tr class="border-b group dark:border-gray-700">
                                                <td
                                                    class="px-4 py-3 font-normal group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    <div class="pl-0">
                                                        <div class="text-gray-700 ">
                                                            {{ 'BPJS: ' . $p->nokartu_bpjs }}
                                                        </div>
                                                        <div class=" text-primary">
                                                            {{ 'NIK: ' . $p->nik_bpjs }}
                                                        </div>
                                                    </div>
                                                </td>

                                                <td
                                                    class="px-4 py-3 font-medium group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{-- <img class="w-10 h-10 rounded-full " src="profile-picture-1.jpg"
                                                        alt="Jese image"> --}}
                                                    <div class="pl-0">
                                                        <div class="font-semibold text-gray-700 ">
                                                            {{ $p->reg_no }}</div>
                                                        <div class="font-semibold text-primary">
                                                            {{ $p->reg_name . ' / (' . $p->sex . ')' . ' / ' . $p->thn }}
                                                        </div>
                                                        <div class="font-normal text-gray-700">
                                                            {{ $p->address }}
                                                        </div>
                                                    </div>
                                                </td>

                                                <td
                                                    class="px-4 py-3 font-normal group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    <div class="pl-0">
                                                        <div class="text-gray-700 ">
                                                            {{ 'Gol. Darah: ' . $p->blood }}
                                                        </div>
                                                        <div class="text-gray-700 ">
                                                            {{ 'Status Menikah: ' . $p->marital_status }}
                                                        </div>
                                                        <div class=" text-primary">
                                                            {{ 'Hidup / Aktif' }}
                                                        </div>
                                                    </div>
                                                </td>

                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $p->phone }}
                                                </td>

                                                <td
                                                    class="px-4 py-3 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap dark:text-white">
                                                    {{ $p->reg_date }}
                                                </td>


                                                <td
                                                    class="flex items-center justify-center px-4 py-3 group-hover:bg-gray-50 group-hover:text-blue-700">



                                                    <!-- Dropdown Action menu Flowbite-->
                                                    <div>
                                                        <x-light-button id="dropdownButton{{ $p->reg_no }}"
                                                            class="inline-flex"
                                                            wire:click="$emit('pressDropdownButton','{{ $p->reg_no }}')">
                                                            <svg class="w-5 h-5" aria-hidden="true"
                                                                fill="currentColor" viewbox="0 0 20 20"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg>
                                                        </x-light-button>

                                                        <!-- Dropdown Action Open menu -->
                                                        <div id="dropdownMenu{{ $p->reg_no }}"
                                                            class="z-10 hidden w-auto bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700">
                                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                                aria-labelledby="dropdownButton{{ $p->reg_no }}">
                                                                <li>
                                                                    <x-dropdown-link
                                                                        wire:click="tampil('{{ $p->reg_no }}')">
                                                                        {{ __('Tampil | ' . $p->reg_name) }}
                                                                    </x-dropdown-link>
                                                                </li>
                                                                <li>
                                                                    <x-dropdown-link
                                                                        wire:click="edit('{{ $p->reg_no }}')">
                                                                        {{ __('Ubah') }}
                                                                    </x-dropdown-link>
                                                                </li>
                                                                <li>
                                                                    <x-dropdown-link
                                                                        wire:click="$emit('confirm_remove_record', '{{ $p->reg_no }}', '{{ $p->reg_name }}')">
                                                                        {{ __('Hapus') }}
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
                                @if ($pasiens->count() == 0)
                                    <div class="w-full p-4 text-sm text-center text-gray-500 dark:text-gray-400">
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
                    {{-- {{ $pasienss->links() }} --}}
                    {{ $pasiens->links('vendor.livewire.tailwind') }}
                </div>
                <!-- Pagination end -->



            </div>
        </div>
    </div>


</div>

























{{-- push start ///////////////////////////////// --}}
@push('scripts')
    {{-- script start --}}
    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/plugins/toastr/toastr.min.js') }}"></script>
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
                window.livewire.emit('confirm_remove_record_pasiens', key, name);
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

        });
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
