@php
    $classStepActiveSatu = $steperStatus == 1 ? '' : 'hidden';
    $classStepActiveDua = $steperStatus == 2 ? '' : 'hidden';
    $classStepActiveTiga = $steperStatus == 3 ? '' : 'hidden';
    
    $classpendaftaranStepSatu = $steperStatus >= 1 ? "flex md:w-full items-center text-blue-600 dark:text-blue-500  sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700" : "flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700";
    
    $classpendaftaranStepDua = $steperStatus >= 2 ? "flex md:w-full items-center text-blue-600 dark:text-blue-500  sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700" : "flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700";
    
    $classpendaftaranStepTiga = $steperStatus >= 3 ? "flex md:w-full items-center text-blue-600 dark:text-blue-500  sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700" : "flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700";
    
@endphp


<div>

    <div class="px-4 pt-6">
        <div
            class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <!-- Card header -->


            <div class="w-full mb-1">
                <div class="">


                    {{-- text --}}
                    <div class="mb-5">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $myTitle }}</h3>
                        <span class="text-base font-normal text-gray-500 dark:text-gray-400">{{ $mySnipt }}</span>
                    </div>
                    {{-- end text --}}



                    {{-- steper start --}}
                    <div class="flex items-center justify-center mb-4">


                        <ol
                            class="flex items-center w-full text-sm font-medium text-center text-gray-500 dark:text-gray-400 sm:text-base">
                            <li class="{{ $classpendaftaranStepSatu }}">
                                <span
                                    class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">

                                    @if ($steperStatus >= 1)
                                        <svg aria-hidden="true" class="w-4 h-4 mr-2 sm:w-5 sm:h-5" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    @endif

                                    <span class="">1</span>
                                    <span class="hidden sm:inline-flex sm:ml-2">Registrasi</span>
                                </span>
                            </li>
                            <li class="{{ $classpendaftaranStepDua }}">
                                <span
                                    class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">

                                    @if ($steperStatus >= 2)
                                        <svg aria-hidden="true" class="w-4 h-4 mr-2 sm:w-5 sm:h-5" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    @endif

                                    <span class="mr-2">2</span>
                                    Pilih <span class="hidden sm:inline-flex sm:ml-2">Poli</span>
                                </span>
                            </li>
                            <li class="{{ $classpendaftaranStepTiga }}">
                                <span
                                    class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                    @if ($steperStatus >= 3)
                                        <svg aria-hidden="true" class="w-4 h-4 mr-2 sm:w-5 sm:h-5" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    @endif

                                    <span class="mr-2">3</span>
                                    Konfirmasi
                            </li>
                        </ol>

                    </div>
                    {{-- steper end --}}



                    <div>






                        <div id="pendaftaranStepSatu" name="pendaftaranStepSatu" class="{{ $classStepActiveSatu }}">

                            {{-- search by noReg --}}
                            <div class="ml-2 md:w-full">
                                <x-input-label for="regNo" :value="__('No_Registrasi')" class="mb-2" />
                                <x-text-input id="regNo" name="regNo" type="text" class="p-2 " autofocus
                                    autocomplete="regNo" placeholder="No Registrasi" wire:model.lazy="regNo" />

                            </div>
                            {{-- search by noReg --}}

                            <div class="inline-flex">
                                <div class="w-1/2 p-2">
                                    <div class="inline-flex items-center justify-between m-2 md:w-full">
                                        <x-input-label :value="__('No_Registrasi')" class="w-1/4 mb-2 mr-2" />
                                        <x-text-input :disabled=true type="text" class="p-2 "
                                            wire:model="dataPasien.regNo" />

                                    </div>
                                    <div class="inline-flex justify-between m-2 md:w-full">
                                        <x-input-label :value="__('Pasien')" class="w-1/4 mb-2 mr-2" />
                                        <x-text-input :disabled=true type="text" class="p-2 "
                                            wire:model="dataPasien.regName" />

                                    </div>
                                    <div class="inline-flex justify-between m-2 md:w-full">
                                        <x-input-label :value="__('L/P')" class="w-1/4 mb-2 mr-2" />
                                        <x-text-input :disabled=true type="text" class="p-2 "
                                            wire:model="dataPasien.sex" />

                                    </div>
                                    <div class="inline-flex justify-between m-2 md:w-full">
                                        <x-input-label :value="__('Tgl_Lahir')" class="w-1/4 mb-2 mr-2" />
                                        <x-text-input :disabled=true type="text" class="p-2 "
                                            wire:model="dataPasien.birthDate" />

                                    </div>
                                    <div class="inline-flex justify-between m-2 md:w-full">
                                        <x-input-label :value="__('Usia')" class="w-1/4 mb-2 mr-2" />
                                        <x-text-input :disabled=true type="text" class="p-2 "
                                            wire:model="dataPasien.thn" />

                                    </div>
                                </div>




                                <div class="w-1/2 p-2">
                                    <div class="inline-flex justify-between m-2 md:w-full">
                                        <x-input-label :value="__('Tempat_lahir')" class="w-1/4 mb-2 mr-2" />
                                        <x-text-input :disabled=true type="text" class="p-2 "
                                            wire:model="dataPasien.birthPlace" />

                                    </div>
                                    <div class="inline-flex justify-between m-2 md:w-full">
                                        <x-input-label :value="__('Status')" class="w-1/4 mb-2 mr-2" />
                                        <x-text-input :disabled=true type="text" class="p-2 "
                                            wire:model="dataPasien.maritalStatus" />

                                    </div>
                                    <div class="inline-flex justify-between m-2 md:w-full">
                                        <x-input-label :value="__('Alamat')" class="w-1/4 mb-2 mr-2" />
                                        <textarea
                                            class="shadow-sm bg-gray-100 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            required rows="7" disabled wire:model="dataPasien.address"></textarea>

                                    </div>

                                </div>
                            </div>


                            <div class="flex justify-end">
                                <x-primary-button wire:click="counterSteper">Proses</x-primary-button>
                            </div>
                        </div>



                        <div id="pendaftaranStepDua" name="pendaftaranStepDua" class="{{ $classStepActiveDua }}">

                            <div
                                class="flex items-center justify-start mb-2 border border-gray-200 rounded dark:border-gray-700">

                                <h5
                                    class="m-2 text-2xl font-bold tracking-tight text-center text-gray-800 dark:text-white dark:bg-gray-700">
                                    {{ $dataPasien['regNo'] . ' / ' . $dataPasien['regName'] . ' / ' . $dataPasien['address'] }}
                                </h5>
                            </div>


                            <div class="flex items-center justify-center">




                                <div
                                    class="flex items-center w-1/3 pl-4 mr-4 border border-gray-200 rounded dark:border-gray-700 hover:bg-gray-100">
                                    <input id="klaimTypeUM" type="radio" value="UM" wire:model="klaimType"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="klaimTypeUM"
                                        class="w-full py-4 pr-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">UMUM</label>
                                </div>
                                <div
                                    class="flex items-center w-1/3 pl-4 border border-gray-200 rounded dark:border-gray-700 hover:bg-gray-100">
                                    <input id="klaimTypeJM" type="radio" value="JM" wire:model="klaimType"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="klaimTypeJM"
                                        class="w-full py-4 pr-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">BPJS</label>
                                </div>

                            </div>



                            <div class="flex flex-wrap ">


                                @foreach ($dataJadwalPoli as $j)
                                    <div class="w-full pt-2 pr-2 md:basis-1/3 ">
                                        <a wire:click.prefent="setDataPoli('{{ $j->poli_id }}','{{ $j->poli_desc }}','{{ $j->dr_id }}','{{ $j->dr_name }}','{{ $klaimType }}')"
                                            class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-blue-100 dark:bg-gray-700 dark:border-gray-700 dark:hover:bg-gray-700 ">
                                            <h5
                                                class="mb-2 text-2xl font-bold tracking-tight text-gray-800 dark:text-white">
                                                {{ $j->poli_desc }}
                                            </h5>
                                            <p class="font-bold text-blue-700 dark:text-gray-400">
                                                {{ $j->dr_name }}
                                            </p>
                                            <p class="font-normal text-gray-700 dark:text-gray-400">
                                                {{ $j->sc_poli_ket }}
                                            </p>
                                            <p class="font-semibold text-red-500 dark:text-gray-400">
                                                @if ($klaimType == 'UM')
                                                    Klaim UMUM
                                                @else
                                                    Klaim BPJS
                                                @endif
                                            </p>
                                        </a>


                                    </div>
                                @endforeach




                            </div>



                        </div>



                        <div id="pendaftaranStepTiga" name="pendaftaranStepTiga" class="{{ $classStepActiveTiga }}">


                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <div
                                                class="px-6 py-3 text-2xl font-bold text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                Data Pasien</div>
                                            <th scope="col" class="w-[100px] px-0 py-0 text-2xl">
                                            </th>
                                            <th scope="col" class="w-1/2 px-0 py-0">

                                            </th>
                                            <th scope="col" class="w-[100px] px-0 py-0">

                                            </th>
                                            <th scope="col" class="w-1/2 px-0 py-0">

                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                No Reg
                                            </th>
                                            <td class="px-6 py-4 ">
                                                {{ $dataDaftarPasienPoli['regNo'] }}
                                            </td>
                                            <td
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Dokter
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $dataDaftarPasienPoli['drName'] }}
                                            </td>

                                        </tr>
                                        <tr class="border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Pasien
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $dataDaftarPasienPoli['regName'] }}
                                            </td>
                                            <td
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Poli
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $dataDaftarPasienPoli['poliDesc'] }}
                                            </td>

                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                L/P
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $dataDaftarPasienPoli['sex'] }}
                                            </td>
                                            <td
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Klaim
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $dataDaftarPasienPoli['klaimId'] }}
                                            </td>

                                        </tr>
                                        <tr class="border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Tgl Lahir
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $dataDaftarPasienPoli['birthDate'] }}
                                            </td>
                                            <td class="px-6 py-4">

                                            </td>
                                            <td class="px-6 py-4">

                                            </td>

                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Usia
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $dataDaftarPasienPoli['thn'] }}
                                            </td>
                                            <td class="px-6 py-4">

                                            </td>
                                            <td class="px-6 py-4">

                                            </td>

                                        </tr>
                                        <tr class="border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Tempat Lahir
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $dataDaftarPasienPoli['birthPlace'] }}
                                            </td>
                                            <td class="px-6 py-4">

                                            </td>
                                            <td class="px-6 py-4">

                                            </td>

                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Status
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $dataDaftarPasienPoli['maritalStatus'] }}
                                            </td>
                                            <td class="px-6 py-4">

                                            </td>
                                            <td class="px-6 py-4">

                                            </td>

                                        </tr>
                                        <tr class="border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Alamat
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $dataDaftarPasienPoli['address'] }}
                                            </td>
                                            <td class="px-6 py-4">

                                            </td>
                                            <td class="px-6 py-4">

                                            </td>

                                        </tr>


                                    </tbody>
                                </table>
                            </div>



                            <div class="flex justify-end pt-4">
                                <x-primary-button wire:click="rjNoMax">Proses</x-primary-button>
                            </div>
                        </div>

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
                        window.livewire.emit('confirm_remove_record_regency', key, name);
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
