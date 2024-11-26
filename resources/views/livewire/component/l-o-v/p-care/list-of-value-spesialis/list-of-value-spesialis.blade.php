<div x-data @click.outside="$wire.spesialisLovStatus = false" class="absolute">

    @if ($spesialisLovStatus)
        <!-- Dropdown list Title -->



        <!-- Dropdown menu -->
        <div class="z-10 w-full bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Dropdown list -->
            <ul class="h-auto px-3 pt-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200 ">
                @foreach ($spesialisLov as $lov)
                    <li wire:key='spesialisLov{{ $lov['spesialisId'] }}'
                        class="{{ $lov['spesialisId'] === '0184R006' ? 'bg-primary bg-opacity-25' : '' }}">
                        <x-dropdown-link
                            wire:click="setMyspesialisLov('{{ $lov['spesialisId'] }}','{{ $lov['spesialisDesc'] }}')">
                            {{ $lov['spesialisId'] . ' / ' . $lov['spesialisDesc'] }}
                        </x-dropdown-link>
                    </li>
                @endforeach
                @if (strlen($spesialisLovSearch) < 3 && count($spesialisLov) == 0)
                    <li>
                        <div class="w-full p-4 text-sm text-center text-gray-500 dark:text-gray-400">
                            {{ 'Masukkan minimal 3 karakter' }}
                        </div>
                    </li>
                @elseif(strlen($spesialisLovSearch) >= 3 && count($spesialisLov) == 0)
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
