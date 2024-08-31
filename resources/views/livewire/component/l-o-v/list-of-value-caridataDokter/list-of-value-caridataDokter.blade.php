@if (!$collectingMyDokter)
    <div>
        <x-input-label for="dataDokterLovSearch" :value="__('Cari Dokter')" :required="__(true)" />

        {{-- Lov dataDokterLov --}}
        <div x-data="{ selecteddataDokterLovIndex: @entangle('selecteddataDokterLovIndex') }" @click.outside="$wire.dataDokterLovSearch = ''">
            <x-text-input id="dataDokterLovSearch" placeholder="Cari Dokter" class="mt-1 ml-2" :errorshas="__($errors->has('dataDokterLovSearch'))"
                :disabled=$disabledProperty wire:model.debounce.1000ms="dataDokterLovSearch"
                x-on:click.outside="$wire.resetdataDokterLov()" x-on:keyup.escape="$wire.resetdataDokterLov()"
                x-on:keyup.down="$wire.selectNextdataDokterLov()" x-on:keyup.up="$wire.selectPreviousdataDokterLov()"
                x-on:keyup.enter="$wire.enterMydataDokterLov(selecteddataDokterLovIndex)"
                x-ref="dataDokterLovSearchfocus" x-init="$watch('selecteddataDokterLovIndex', (value, oldValue) => $refs.dataDokterLovSearch.children[selecteddataDokterLovIndex + 1].scrollIntoView({
                    block: 'nearest'
                }))" />

            {{-- Lov --}}
            <div class="py-2 mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-64"
                x-show="$wire.dataDokterLovSearch.length>1 && $wire.dataDokterLov.length>0" x-transition
                x-ref="dataDokterLovSearch">


                {{-- livewire --}}
                @foreach ($dataDokterLov as $key => $lov)
                    <li wire:key='dataDokterLov{{ $lov['dr_id'] }}'>
                        <x-dropdown-link wire:click="setMydataDokterLov('{{ $key }}')"
                            class="text-base font-normal {{ $key === $selecteddataDokterLovIndex ? 'bg-gray-100 outline-none' : '' }}">
                            <div>
                                {{ $lov['dr_id'] . '/ ' . $lov['dr_name'] }}
                            </div>
                            <div>
                                {{ $lov['poli_id'] . '/ ' . $lov['poli_desc'] }}
                            </div>
                        </x-dropdown-link>
                    </li>
                @endforeach

            </div>


            {{-- Start Lov exceptions --}}

            @if (strlen($dataDokterLovSearch) > 0 && strlen($dataDokterLovSearch) < 1 && count($dataDokterLov) == 0)
                <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    {{ 'Masukkan minimal lebih dari 1  karakter' }}
                </div>
            @elseif(strlen($dataDokterLovSearch) >= 1 && count($dataDokterLov) == 0)
                <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    {{ 'Data Tidak ditemukan' }}
                </div>
            @endif
            {{-- End Lov exceptions --}}

            @error('dataDokterLovSearch')
                <x-input-error :messages=$message />
            @enderror
        </div>
        {{-- Lov dataDokterLov --}}
    </div>
@endif
