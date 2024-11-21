@if (!$collectingMyGetKesadaran)
    <div>
        <x-input-label for="dataGetKesadaranLovSearch" :value="__('Tingkat Kesadaran ')" :required="__(true)" />

        {{-- Lov dataGetKesadaranLov --}}
        <div x-data="{ selecteddataGetKesadaranLovIndex: @entangle('selecteddataGetKesadaranLovIndex') }" @click.outside="$wire.dataGetKesadaranLovSearch = ''">
            <x-text-input id="dataGetKesadaranLovSearch" placeholder="Tingkat Kesadaran" class="mt-1 ml-2"
                :errorshas="__($errors->has('dataGetKesadaranLovSearch'))" :disabled=$disabledProperty wire:model.debounce.1000ms="dataGetKesadaranLovSearch"
                x-on:click.outside="$wire.resetdataGetKesadaranLov()" x-on:keyup.escape="$wire.resetdataGetKesadaranLov()"
                x-on:keyup.down="$wire.selectNextdataGetKesadaranLov()"
                x-on:keyup.up="$wire.selectPreviousdataGetKesadaranLov()"
                x-on:keyup.enter="$wire.enterMydataGetKesadaranLov(selecteddataGetKesadaranLovIndex)"
                x-ref="dataGetKesadaranLovSearchfocus" x-init="$watch('selecteddataGetKesadaranLovIndex', (value, oldValue) => $refs.dataGetKesadaranLovSearch.children[selecteddataGetKesadaranLovIndex + 1].scrollIntoView({
                    block: 'nearest'
                }))" />

            {{-- Lov --}}

            <div class="py-2 mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-64"
                x-show="$wire.dataGetKesadaranLovSearch.length>1 && $wire.dataGetKesadaranLov" x-transition
                x-ref="dataGetKesadaranLovSearch">


                {{-- livewire --}}
                @foreach ($dataGetKesadaranLov as $key => $lov)
                    <li wire:key='dataGetKesadaranLov{{ $lov['kdPoli'] }}'>
                        <x-dropdown-link wire:click="setMydataGetKesadaranLov('{{ $key }}')"
                            class="text-base font-normal {{ $key === $selecteddataGetKesadaranLovIndex ? 'bg-gray-100 outline-none' : '' }}">
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

            @if (strlen($dataGetKesadaranLovSearch) > 0 &&
                    strlen($dataGetKesadaranLovSearch) < 1 &&
                    count($dataGetKesadaranLov) == 0)
                <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    {{ 'Masukkan minimal lebih dari 1  karakter' }}
                </div>
            @elseif(strlen($dataGetKesadaranLovSearch) >= 1 && count($dataGetKesadaranLov) == 0)
                <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    {{ 'Data Tidak ditemukan' }}
                </div>
            @endif
            {{-- End Lov exceptions --}}

            @error('dataGetKesadaranLovSearch')
                <x-input-error :messages=$message />
            @enderror
        </div>
        {{-- Lov dataGetKesadaranLov --}}
    </div>
@endif
