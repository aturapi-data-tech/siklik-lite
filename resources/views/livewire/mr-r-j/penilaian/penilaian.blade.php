<div>

    <div class="w-full mb-1">



        @php
            $disabledProperty = true;

            $disabledPropertyRjStatus = false;

        @endphp


        {{-- <form class="scroll-smooth hover:scroll-auto"> --}}
        <div class="grid grid-cols-1">

            <div id="TransaksiRawatJalan" class="px-2">
                <div id="TransaksiRawatJalan" x-data="{ activeTab: 'Fisik' }">

                    <div class="px-2 mb-2 border-b border-gray-200 dark:border-gray-700">
                        <ul
                            class="flex flex-wrap -mb-px text-xs font-medium text-center text-gray-500 dark:text-gray-400">
                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['penilaian']['fisikTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['penilaian']['fisikTab'] }}'">{{ $dataDaftarPoliRJ['penilaian']['fisikTab'] }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['penilaian']['nyeriTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['penilaian']['nyeriTab'] }}'">{{ $dataDaftarPoliRJ['penilaian']['nyeriTab'] }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['penilaian']['statusPediatrikTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['penilaian']['statusPediatrikTab'] }}'">{{ $dataDaftarPoliRJ['penilaian']['statusPediatrikTab'] }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['penilaian']['diagnosisTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['penilaian']['diagnosisTab'] }}'">{{ $dataDaftarPoliRJ['penilaian']['diagnosisTab'] }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab ===
                                        '{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseTab'] }}'
                                        ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseTab'] }}'">{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . ' / ' . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseTab'] }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab ===
                                        '{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyTab'] }}'
                                        ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyTab'] }}'">{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . ' / ' . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyTab'] }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab ===
                                        '{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['edmonsonTab'] }}'
                                        ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['edmonsonTab'] }}'">{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . ' / ' . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['edmonsonTab'] }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab ===
                                        '{{ $dataDaftarPoliRJ['penilaian']['dekubitus']['dekubitusTab'] }}'
                                        ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['penilaian']['dekubitus']['dekubitusTab'] }}'">{{ $dataDaftarPoliRJ['penilaian']['dekubitus']['dekubitusTab'] }}</label>
                            </li>




                        </ul>
                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['penilaian']['fisikTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['penilaian']['fisikTab'] }}'">
                        @include('livewire.mr-r-j.penilaian.fisikTab')

                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['penilaian']['nyeriTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['penilaian']['nyeriTab'] }}'">
                        @include('livewire.mr-r-j.penilaian.nyeriTab')

                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['penilaian']['statusPediatrikTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['penilaian']['statusPediatrikTab'] }}'">
                        @include('livewire.mr-r-j.penilaian.statusPediatrikTab')

                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['penilaian']['diagnosisTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['penilaian']['diagnosisTab'] }}'">
                        @include('livewire.mr-r-j.penilaian.diagnosisTab')

                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab ===
                                '{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaMorse']['skalaMorseTab'] }}'">
                        @include('livewire.mr-r-j.penilaian.skalaMorseTab')

                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab ===
                                '{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['skalaHumptyDumpty']['skalaHumptyDumptyTab'] }}'">
                        @include('livewire.mr-r-j.penilaian.skalaHumptyDumptyTab')

                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab ===
                                '{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['edmonsonTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['penilaian']['resikoJatuhTab'] . $dataDaftarPoliRJ['penilaian']['resikoJatuh']['edmonson']['edmonsonTab'] }}'">
                        @include('livewire.mr-r-j.penilaian.edmonsonTab')

                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab ===
                                '{{ $dataDaftarPoliRJ['penilaian']['dekubitus']['dekubitusTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['penilaian']['dekubitus']['dekubitusTab'] }}'">
                        @include('livewire.mr-r-j.penilaian.dekubitusTab')

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


            {{-- </form> --}}







        </div>
























        {{-- push start ///////////////////////////////// --}}
        @push('scripts')
            {{-- script start --}}
            <script src="{{ url('assets/js/jquery.min.js') }}"></script>
            <script src="{{ url('assets/plugins/toastr/toastr.min.js') }}"></script>
            <script src="{{ url('assets/flowbite/dist/datepicker.js') }}"></script>

            {{-- script end --}}





            {{-- Disabling enter key for form --}}
            {{-- <script type="text/javascript">
                $(document).on("keydown", "form", function(event) {
                    return event.key != "Enter";
                });
            </script> --}}





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
