@if (!$collectingMyProduct)
    <div>
        <x-input-label for="dataProductLovSearch" :value="__('Nama Obat')" :required="true" />

        <div class="relative" x-data="{
            selecteddataProductLovIndex: @entangle('selecteddataProductLovIndex'),
            get isOpen() { return ($wire.dataProductLovSearch?.length || 0) > 1 && ($wire.dataProductLov?.length || 0) > 0 }
        }" @click.outside="$wire.resetdataProductLov()">

            {{-- input search --}}
            <x-text-input id="dataProductLovSearch" placeholder="Nama Obat" class="mt-1 ml-2" :errorshas="$errors->has('dataProductLovSearch')"
                :disabled="false" wire:model="dataProductLovSearch" x-on:keyup.escape="$wire.resetdataProductLov()"
                x-on:keyup.down="$wire.selectNextdataProductLov()" x-on:keyup.up="$wire.selectPreviousdataProductLov()"
                x-on:keyup.enter="$wire.enterMydataProductLov(selecteddataProductLovIndex)" x-ref="lovSearchInput"
                x-init="$watch('selecteddataProductLovIndex', () => {
                    const list = $refs.lovDropdownList;
                    if (!list) return;
                    const items = list.children;
                    if (!items || items.length === 0) return;
                    const i = selecteddataProductLovIndex;
                    if (i >= 0 && i < items.length) { items[i]?.scrollIntoView({ block: 'nearest' }); }
                })" />

            {{-- dropdown --}}
            <div class="absolute z-50 w-full py-2 mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-64"
                x-show="isOpen" x-transition x-ref="lovDropdownListWrapper">
                <ul role="listbox" class="divide-y divide-gray-100" x-ref="lovDropdownList">
                    @foreach ($dataProductLov as $key => $lov)
                        <li wire:key="dataProductLov{{ $lov['product_id'] }}">
                            <x-dropdown-link role="option" :aria-selected="$key === $selecteddataProductLovIndex"
                                wire:click="setMydataProductLov('{{ $key }}')"
                                class="text-base font-normal {{ $key === $selecteddataProductLovIndex ? 'bg-gray-100 outline-none' : '' }}">
                                <div class="text-lg font-semibold">{{ $lov['product_name'] }}</div>
                                <div class="text-xs">{{ number_format($lov['sales_price']) }}</div>
                                <div class="text-xs italic">
                                    {{ '(' }}{{ $lov['product_content'] ?? '-' }}{{ ')' }}{{ $lov['product_id'] }}
                                </div>
                            </x-dropdown-link>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- exceptions --}}
            @if (strlen($dataProductLovSearch) > 0 && strlen($dataProductLovSearch) < 2 && count($dataProductLov) == 0)
                <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    {{ 'Masukkan minimal lebih dari 1 karakter' }}
                </div>
            @elseif (strlen($dataProductLovSearch) >= 2 && count($dataProductLov) == 0)
                <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    {{ 'Data tidak ditemukan' }}
                </div>
            @endif

            @error('dataProductLovSearch')
                <x-input-error :messages="$message" />
            @enderror
        </div>
    </div>
@endif
