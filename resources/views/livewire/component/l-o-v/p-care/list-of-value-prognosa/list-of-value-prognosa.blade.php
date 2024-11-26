<div x-data @click.outside="$wire.prognosaLovStatus = false" class="absolute">

    @if ($prognosaLovStatus)
        <!-- Dropdown list Title -->



        <!-- Dropdown menu -->
        <div class="z-10 w-full bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Dropdown list -->
            <ul class="h-auto px-3 pt-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200">
                @foreach ($prognosaLov as $lov)
                    <li wire:key='prognosaLov{{ $lov['prognosaId'] }}'>
                        <x-dropdown-link
                            wire:click="setMyprognosaLov('{{ $lov['prognosaId'] }}','{{ $lov['prognosaDesc'] }}')">
                            {{ $lov['prognosaId'] . ' / ' . $lov['prognosaDesc'] }}
                        </x-dropdown-link>
                    </li>
                @endforeach
                @if (strlen($prognosaLovSearch) < 3 && count($prognosaLov) == 0)
                    <li>
                        <div class="w-full p-4 text-sm text-center text-gray-500 dark:text-gray-400">
                            {{ 'Masukkan minimal 3 karakter' }}
                        </div>
                    </li>
                @elseif(strlen($prognosaLovSearch) >= 3 && count($prognosaLov) == 0)
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
