<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp

    <div class="w-full mb-1">


        {{-- <form class="scroll-smooth hover:scroll-auto"> --}}
        <div class="grid grid-cols-1">

            <div id="TransaksiRawatJalan" class="px-2">
                <div id="TransaksiRawatJalan" x-data="{ activeTab: 'Umum' }">

                    <div class="px-2 border-b border-gray-200 dark:border-gray-700">
                        <ul
                            class="flex flex-wrap -mb-px text-xs font-medium text-center text-gray-500 dark:text-gray-400">
                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['pemeriksaan']['umumTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['pemeriksaan']['umumTab'] }}'">{{ $dataDaftarPoliRJ['pemeriksaan']['umumTab'] }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ 'Fisik' }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ 'Fisik' }}'">{{ 'Fisik' }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ 'Anatomi' }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ 'Anatomi' }}'">{{ 'Anatomi' }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ 'Penunjang' }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ 'Penunjang' }}'">{{ 'Penunjang' }}</label>
                            </li>





                        </ul>
                    </div>

                    <div class="p-2 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['pemeriksaan']['umumTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['pemeriksaan']['umumTab'] }}'">
                        @include('livewire.mr-r-j.pemeriksaan.umumTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab === '{{ 'Fisik' }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ 'Fisik' }}'">
                        @include('livewire.mr-r-j.pemeriksaan.fisikTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab === '{{ 'Anatomi' }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ 'Anatomi' }}'">
                        @include('livewire.mr-r-j.pemeriksaan.anatomiTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab === '{{ 'Penunjang' }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ 'Penunjang' }}'">
                        @include('livewire.mr-r-j.pemeriksaan.penunjangTab')

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

</div>
