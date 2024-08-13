<div x-data @click.outside="$wire.dataPasienLovStatus = false" class="absolute">
    @if ($dataPasienLovStatus)
        <!-- Dropdown list Title -->
        <div
            class="flex items-center p-3 text-sm text-gray-700 bg-gray-100 border-t border-gray-200 rounded-t-lg dark:border-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-500 hover:underline">
            <svg class="w-5 h-5 mr-1" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"
                    stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>

            <span>{{ count($dataPasienLov) }}</span>

        </div>


        <!-- Dropdown menu -->
        <div class="z-10 w-full overflow-auto bg-white rounded-lg shadow max-h-80 dark:bg-gray-700">
            <!-- Dropdown list -->
            <ul class="h-auto px-3 pt-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200">

                @foreach ($dataPasienLov as $key => $lov)
                    @php
                        $bgGanjilGenap = $key % 2 == 0 ? 'bg-gray-50' : 'bg-white';
                    @endphp
                    <li wire:key='dataPasienLov{{ $lov['reg_no'] }}' class="{{ $bgGanjilGenap }} ">
                        <x-dropdown-link wire:click="setMydataPasienLov('{{ $lov['reg_no'] }}')">

                            <div class="pl-0">
                                <div class="font-semibold text-gray-700 ">
                                    {{ $lov['reg_no'] . ' | NIK :' . $lov['nik_bpjs'] }}</div>
                                <div class="font-normal text-gray-700 ">
                                    {{ 'BPJS : ' . $lov['nokartu_bpjs'] }}</div>
                                <div class="font-semibold text-primary">
                                    {{ $lov['reg_name'] . ' / (' . $lov['sex'] . ')' . ' / ' . $lov['thn'] }}
                                </div>
                                <div class="font-normal text-gray-700">
                                    {{ $lov['address'] }}
                                </div>
                            </div>

                        </x-dropdown-link>
                    </li>
                @endforeach

                @if (strlen($dataPasienLovSearch) < 3 && count($dataPasienLov) == 0)
                    <li>
                        <div class="w-full p-4 text-sm text-center text-gray-500 dark:text-gray-400">
                            {{ 'Masukkan minimal 3 karakter' }}
                        </div>
                    </li>
                @elseif(strlen($dataPasienLovSearch) >= 3 && count($dataPasienLov) == 0)
                    <li>
                        <div class="w-full p-4 text-sm text-center text-gray-500 dark:text-gray-400">
                            {{ 'Data Tidak ditemukan' }}
                        </div>
                    </li>
                @endif
            </ul>
        </div>

        <!-- Dropdown Action menu Flowbite-->

        <!-- End Dropdown Action Open menu -->
    @endif

</div>
