<div x-data @click.outside="$wire.saranaLovStatus = false" class="absolute">

    @if ($saranaLovStatus)
        <!-- Dropdown list Title -->



        <!-- Dropdown menu -->
        <div class="z-10 w-full bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Dropdown list -->
            <ul class="h-auto px-3 pt-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200 ">
                @foreach ($saranaLov as $lov)
                    <li wire:key='saranaLov{{ $lov['saranaId'] }}'
                        class="{{ $lov['saranaId'] === '0184R006' ? 'bg-primary bg-opacity-25' : '' }}">
                        <x-dropdown-link
                            wire:click="setMysaranaLov('{{ $lov['saranaId'] }}','{{ $lov['saranaDesc'] }}')">
                            {{ $lov['saranaId'] . ' / ' . $lov['saranaDesc'] }}
                        </x-dropdown-link>
                    </li>
                @endforeach
                @if (strlen($saranaLovSearch) < 3 && count($saranaLov) == 0)
                    <li>
                        <div class="w-full p-4 text-sm text-center text-gray-500 dark:text-gray-400">
                            {{ 'Masukkan minimal 3 karakter' }}
                        </div>
                    </li>
                @elseif(strlen($saranaLovSearch) >= 3 && count($saranaLov) == 0)
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
