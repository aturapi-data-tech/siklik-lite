@if (!$collectingMyGetPoliFKTP)
    <div>
        <x-input-label for="dataGetPoliFKTPLovSearch" :value="__('Cari Data GetPoliFKTP dgn [ Nama Poli / Id BPJS] ')" :required="__(true)" />

        {{-- Lov dataGetPoliFKTPLov --}}
        <div x-data="{ selecteddataGetPoliFKTPLovIndex: @entangle('selecteddataGetPoliFKTPLovIndex') }" @click.outside="$wire.dataGetPoliFKTPLovSearch = ''">
            <x-text-input id="dataGetPoliFKTPLovSearch" placeholder="Cari GetPoliFKTP" class="mt-1 ml-2" :errorshas="__($errors->has('dataGetPoliFKTPLovSearch'))"
                :disabled=$disabledProperty wire:model.debounce.1000ms="dataGetPoliFKTPLovSearch"
                x-on:click.outside="$wire.resetdataGetPoliFKTPLov()" x-on:keyup.escape="$wire.resetdataGetPoliFKTPLov()"
                x-on:keyup.down="$wire.selectNextdataGetPoliFKTPLov()"
                x-on:keyup.up="$wire.selectPreviousdataGetPoliFKTPLov()"
                x-on:keyup.enter="$wire.enterMydataGetPoliFKTPLov(selecteddataGetPoliFKTPLovIndex)"
                x-ref="dataGetPoliFKTPLovSearchfocus" x-init="$watch('selecteddataGetPoliFKTPLovIndex', (value, oldValue) => $refs.dataGetPoliFKTPLovSearch.children[selecteddataGetPoliFKTPLovIndex + 1].scrollIntoView({
                    block: 'nearest'
                }))" />

            {{-- Lov --}}

            <div class="py-2 mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-64"
                x-show="$wire.dataGetPoliFKTPLovSearch.length>1 && $wire.dataGetPoliFKTPLov" x-transition
                x-ref="dataGetPoliFKTPLovSearch">


                {{-- livewire --}}
                @foreach ($dataGetPoliFKTPLov as $key => $lov)
                    <li wire:key='dataGetPoliFKTPLov{{ $lov['kdPoli'] }}'>
                        <x-dropdown-link wire:click="setMydataGetPoliFKTPLov('{{ $key }}')"
                            class="text-base font-normal {{ $key === $selecteddataGetPoliFKTPLovIndex ? 'bg-gray-100 outline-none' : '' }}">
                            <div>
                                {{ $lov['kdPoli'] . '/ ' . $lov['nmPoli'] }}
                            </div>
                            <div>
                                {{ 'Poli Sakit  ' }}{{ $lov['poliSakit'] ? 'Ya' : 'Tidak' }}
                            </div>
                        </x-dropdown-link>
                    </li>
                @endforeach

            </div>


            {{-- Start Lov exceptions --}}

            @if (strlen($dataGetPoliFKTPLovSearch) > 0 && strlen($dataGetPoliFKTPLovSearch) < 1 && count($dataGetPoliFKTPLov) == 0)
                <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    {{ 'Masukkan minimal lebih dari 1  karakter' }}
                </div>
            @elseif(strlen($dataGetPoliFKTPLovSearch) >= 1 && count($dataGetPoliFKTPLov) == 0)
                <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    {{ 'Data Tidak ditemukan' }}
                </div>
            @endif
            {{-- End Lov exceptions --}}

            @error('dataGetPoliFKTPLovSearch')
                <x-input-error :messages=$message />
            @enderror
        </div>
        {{-- Lov dataGetPoliFKTPLov --}}
    </div>
@endif
