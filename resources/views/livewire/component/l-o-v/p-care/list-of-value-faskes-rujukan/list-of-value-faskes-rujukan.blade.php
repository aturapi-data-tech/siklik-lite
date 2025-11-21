<div x-data @click.outside="$wire.faskesRujukanLovStatus = false" class="absolute">

    @if ($faskesRujukanLovStatus ?? false)
        <!-- Dropdown list Title -->



        <!-- Dropdown menu -->
        <div class="z-10 w-full bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Dropdown list -->
            <ul class="h-auto px-3 pt-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200 ">
                @foreach ($faskesRujukanLov as $lov)
                    <li wire:key='faskesRujukanLov{{ $lov['kdppk'] }}'
                        class="{{ $lov['kdppk'] === '0184R006' ? 'bg-primary bg-opacity-25' : '' }}">
                        <x-dropdown-link wire:click="setMyfaskesRujukanLov('{{ json_encode($lov, true) }}')">
                            {{ $lov['kdppk'] . ' / ' . $lov['nmppk'] }}
                            <div>
                                {{ $lov['kelas'] . ' / ' . $lov['nmkc'] }}
                            </div>
                            <div>
                                {{ $lov['alamatPpk'] . ' / ' . $lov['telpPpk'] }}
                            </div>
                            <div>
                                {{ $lov['jadwal'] }}
                            </div>
                            <div>
                                {{ $lov['jadwal'] }}
                                {{ $lov['jmlRujuk'] }}
                                {{ $lov['kapasitas'] }}
                                {{ $lov['persentase'] }}
                            </div>
                        </x-dropdown-link>
                    </li>
                @endforeach
                @if (strlen($faskesRujukanLovSearch) < 3 && count($faskesRujukanLov) == 0)
                    <li>
                        <div class="w-full p-4 text-sm text-center text-gray-500 dark:text-gray-400">
                            {{ 'Masukkan minimal 3 karakter' }}
                        </div>
                    </li>
                @elseif(strlen($faskesRujukanLovSearch) >= 3 && count($faskesRujukanLov) == 0)
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
