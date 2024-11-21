@if (!$collectingMyPasien)
    <div>
        <x-input-label for="dataPasienLovSearch" :value="__('Cari Data Pasien dgn [ Nama / Reg No / NIK / Noka BPJS] ')" :required="__(true)" />

        {{-- Lov dataPasienLov --}}
        <div x-data="{ selecteddataPasienLovIndex: @entangle('selecteddataPasienLovIndex') }" @click.outside="$wire.dataPasienLovSearch = ''">
            <x-text-input id="dataPasienLovSearch" placeholder="Cari Pasien" class="mt-1 ml-2" :errorshas="__($errors->has('dataPasienLovSearch'))"
                :disabled=$disabledProperty wire:model.debounce.1000ms="dataPasienLovSearch"
                x-on:click.outside="$wire.resetdataPasienLov()" x-on:keyup.escape="$wire.resetdataPasienLov()"
                x-on:keyup.down="$wire.selectNextdataPasienLov()" x-on:keyup.up="$wire.selectPreviousdataPasienLov()"
                x-on:keyup.enter="$wire.enterMydataPasienLov(selecteddataPasienLovIndex)"
                x-ref="dataPasienLovSearchfocus" x-init="$watch('selecteddataPasienLovIndex', (value, oldValue) => $refs.dataPasienLovSearch.children[selecteddataPasienLovIndex + 1].scrollIntoView({
                    block: 'nearest'
                }))" />

            {{-- Lov --}}
            <div class="py-2 mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-64"
                x-show="$wire.dataPasienLovSearch.length>1 && $wire.dataPasienLov.length>0" x-transition
                x-ref="dataPasienLovSearch">


                {{-- livewire --}}
                @foreach ($dataPasienLov as $key => $lov)
                    <li wire:key='dataPasienLov{{ $lov['reg_no'] }}'>
                        <x-dropdown-link wire:click="setMydataPasienLov('{{ $key }}')"
                            class="text-base font-normal {{ $key === $selecteddataPasienLovIndex ? 'bg-gray-100 outline-none' : '' }}">
                            <div>
                                {{ $lov['reg_no'] . '/ ' . $lov['reg_name'] }}
                            </div>
                            <div>
                                {{ $lov['sex'] . '/ ' . $lov['address'] }}
                            </div>
                            <div>
                                {{ 'Noka ' . $lov['nokartu_bpjs'] . '/ Nik ' . $lov['nik_bpjs'] }}
                            </div>
                        </x-dropdown-link>
                    </li>
                @endforeach

            </div>


            {{-- Start Lov exceptions --}}

            @if (strlen($dataPasienLovSearch) > 0 && strlen($dataPasienLovSearch) < 1 && count($dataPasienLov) == 0)
                <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    {{ 'Masukkan minimal lebih dari 1  karakter' }}
                </div>
            @elseif(strlen($dataPasienLovSearch) >= 1 && count($dataPasienLov) == 0)
                <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    {{ 'Data Tidak ditemukan' }}
                </div>
            @endif
            {{-- End Lov exceptions --}}

            @error('dataPasienLovSearch')
                <x-input-error :messages=$message />
            @enderror
        </div>
        {{-- Lov dataPasienLov --}}
    </div>
@endif
