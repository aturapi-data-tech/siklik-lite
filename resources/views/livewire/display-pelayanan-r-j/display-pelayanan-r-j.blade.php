<div>

    <div wire:poll.keep-alive class="px-1 pt-7">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <!-- Card header -->

            <div class="mb-4 text-sm text-center text-white rounded-lg bg-primary">

                Jam: {{ now() }}

            </div>

            <div class="grid grid-cols-4 gap-2">

                @isset($drRjRef['drOptions'])
                    @foreach ($drRjRef['drOptions'] as $RJp)
                        <section class="w-full mb-1 ">
                            <div class="p-2 bg-gray-200 border border-gray-200 rounded-lg shadow ">
                                <div class="flex justify-center">
                                    <h5 class="text-xl font-semibold tracking-tight text-primary">
                                        {{ $RJp['poliDesc'] }}
                                    </h5>
                                </div>

                                <div class="">

                                    <div class="flex items-center px-4 py-3 group-hover:bg-gray-100 ">
                                        <span class="text-5xl font-semibold text-gray-700">
                                            {{ $RJp['noAntrian'] }}
                                        </span>
                                        <div class="pl-3">

                                            <div class="font-semibold text-gray-700">
                                                {{ $RJp['regName'] }}
                                            </div>

                                            <div class="font-semibold text-gray-500">
                                                {{ $RJp['drName'] }}
                                            </div>

                                        </div>
                                    </div>


                                </div>

                            </div>

                            <div class="flex flex-col mt-2 overflow-auto max-h-52">
                                <div class="overflow-x-auto rounded-lg">
                                    <div class="inline-block min-w-full align-middle">
                                        <div class="overflow-hidden shadow sm:rounded-lg">
                                            <table
                                                class="w-full text-sm text-left text-gray-900 table-auto dark:text-gray-400">
                                                <thead
                                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                    <tr>
                                                        <th scope="col" class="px-4 py-3 ">
                                                            <x-sort-link :active=false wire:click.prevent="sortBy('RJp_id')"
                                                                role="button" href="#">
                                                                Pasien / Poli
                                                            </x-sort-link>
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white dark:bg-gray-800">
                                                    @isset($RJp['pasien'])
                                                        @foreach ($RJp['pasien'] as $p)
                                                            @php
                                                                $statusLayananBgcolor = $p['waktu_masuk_poli'] == null && $p['waktu_masuk_apt'] == null ? '' : ($p['waktu_masuk_poli'] != null && $p['waktu_masuk_apt'] == null ? 'bg-gray-100' : ($p['waktu_masuk_poli'] != null && $p['waktu_masuk_apt'] != null ? '' : ''));
                                                            @endphp

                                                            <tr
                                                                class=" border-b group dark:border-gray-700 {{ $statusLayananBgcolor }}">
                                                                <td
                                                                    class="flex items-center px-4 py-3 group-hover:bg-gray-100 whitespace-nowrap dark:text-white">
                                                                    <span class="text-gray-700 ">{{ $p['noAntrian'] }}</span>
                                                                    <div class="pl-3">

                                                                        <div class="text-gray-700 ">
                                                                            {{ $p['regName'] . ' / (' . $p['sex'] . ')' . ' / ' . $p['thn'] }}
                                                                        </div>
                                                                        <div>
                                                                            {{ $p['waktu_masuk_poli'] == null && $p['waktu_masuk_apt'] == null
                                                                                ? 'Pendaftaran'
                                                                                : ($p['waktu_masuk_poli'] != null && $p['waktu_masuk_apt'] == null
                                                                                    ? 'Pelayanan Poli'
                                                                                    : ($p['waktu_masuk_poli'] != null && $p['waktu_masuk_apt'] != null
                                                                                        ? 'Menunggu Resep'
                                                                                        : '--')) }}
                                                                        </div>
                                                                    </div>
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

                        </section>
                    @endforeach
                @endisset

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
