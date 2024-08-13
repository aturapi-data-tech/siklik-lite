<div x-data @click.outside="$wire.dataDiagnosaICD10LovStatus = false" class="absolute top-0 right-0 z-20 ">
    @if ($dataDiagnosaICD10LovStatus)
        <!-- Dropdown list Title -->
        <div x-data x-init="$refs.dataDiagnosaICD10LovSearch.focus()"
            class="flex items-center p-3 text-sm text-gray-700 bg-gray-100 border-t border-gray-200 rounded-t-lg dark:border-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-500 hover:underline">
            <svg class="w-5 h-5 mr-1" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"
                    stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <x-text-input x-ref="dataDiagnosaICD10LovSearch" placeholder="Cari Data" class="mt-1 ml-2"
                wire:model="dataDiagnosaICD10LovSearch" />
        </div>


        <!-- Dropdown menu -->
        <div class="z-10 w-full bg-white rounded-lg shadow dark:bg-gray-700 max-h-[200px] overflow-auto">
            <!-- Dropdown list -->
            <ul class="h-auto px-3 pt-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200">
                @foreach ($dataDiagnosaICD10Lov as $lov)
                    <li wire:key='dataDiagnosaICD10Lov{{ $lov['diag_id'] }}'>
                        <x-dropdown-link
                            wire:click="setMydataDiagnosaICD10Lov('{{ $lov['diag_id'] }}','{{ $lov['diag_desc'] }}')">
                            <div class="text-base font-normal">{{ $lov['diag_id'] . '. ' . $lov['diag_desc'] }}</div>
                        </x-dropdown-link>
                    </li>
                @endforeach
                @if (strlen($dataDiagnosaICD10LovSearch) < 3 && count($dataDiagnosaICD10Lov) == 0)
                    <li>
                        <div class="w-full p-4 text-sm text-center text-gray-500 dark:text-gray-400">
                            {{ 'Masukkan minimal 3 karakter' }}
                        </div>
                    </li>
                @elseif(strlen($dataDiagnosaICD10LovSearch) >= 3 && count($dataDiagnosaICD10Lov) == 0)
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
