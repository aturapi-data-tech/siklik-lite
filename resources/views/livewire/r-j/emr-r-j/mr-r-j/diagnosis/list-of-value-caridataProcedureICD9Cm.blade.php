@if (!$collectingMyProcedureICD9Cm)
    <div>
        <x-input-label for="dataProcedureICD9CmLovSearch" :value="__('Kode ICD9Cm')" :required="__(true)" />

        {{-- Lov dataProcedureICD9CmLov --}}
        <div x-data="{ selecteddataProcedureICD9CmLovIndex: @entangle('selecteddataProcedureICD9CmLovIndex') }" @click.outside="$wire.dataProcedureICD9CmLovSearch = ''">
            <x-text-input id="dataProcedureICD9CmLovSearch" placeholder="Kode ICD9Cm" class="mt-1 ml-2" :errorshas="__($errors->has('dataProcedureICD9CmLovSearch'))"
                :disabled=$disabledPropertyRjStatus wire:model.debounce.1000ms="dataProcedureICD9CmLovSearch"
                x-on:click.outside="$wire.resetdataProcedureICD9CmLov()"
                x-on:keyup.escape="$wire.resetdataProcedureICD9CmLov()"
                x-on:keyup.down="$wire.selectNextdataProcedureICD9CmLov()"
                x-on:keyup.up="$wire.selectPreviousdataProcedureICD9CmLov()"
                x-on:keyup.enter="$wire.enterMydataProcedureICD9CmLov(selecteddataProcedureICD9CmLovIndex)"
                x-ref="dataProcedureICD9CmLovSearchfocus" x-init="$watch('selecteddataProcedureICD9CmLovIndex', (value, oldValue) => $refs.dataProcedureICD9CmLovSearch.children[selecteddataProcedureICD9CmLovIndex + 1].scrollIntoView({
                    block: 'nearest'
                }))" />

            {{-- Lov --}}
            <div class="py-2 mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-64"
                x-show="$wire.dataProcedureICD9CmLovSearch.length>1 && $wire.dataProcedureICD9CmLov.length>0"
                x-transition x-ref="dataProcedureICD9CmLovSearch">
                {{-- alphine --}}
                {{-- <template x-for="(dataProcedureICD9CmLovx, index) in $wire.dataProcedureICD9CmLov">
    <button x-text="dataProcedureICD9CmLovx.acte_desc"
        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
        :class="{
            'bg-gray-100 outline-none': index === $wire
                .selecteddataProcedureICD9CmLovIndex
        }"
        x-on:click.prevent="$wire.setMydataProcedureICD9CmLov(index)"></button>
</template> --}}

                {{-- livewire --}}
                @foreach ($dataProcedureICD9CmLov as $key => $lov)
                    <li wire:key='dataProcedureICD9CmLov{{ $lov['proc_id'] }}'>
                        <x-dropdown-link wire:click="setMydataProcedureICD9CmLov('{{ $key }}')"
                            class="text-base font-normal {{ $key === $selecteddataProcedureICD9CmLovIndex ? 'bg-gray-100 outline-none' : '' }}">
                            <div>
                                {{ $lov['proc_id'] . '/ ' . $lov['proc_desc'] }}
                            </div>
                        </x-dropdown-link>
                    </li>
                @endforeach

            </div>


            {{-- Start Lov exceptions --}}

            @if (strlen($dataProcedureICD9CmLovSearch) > 0 &&
                    strlen($dataProcedureICD9CmLovSearch) < 1 &&
                    count($dataProcedureICD9CmLov) == 0)
                <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    {{ 'Masukkan minimal lebih dari 1  karakter' }}
                </div>
            @elseif(strlen($dataProcedureICD9CmLovSearch) >= 1 && count($dataProcedureICD9CmLov) == 0)
                <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    {{ 'Data Tidak ditemukan' }}
                </div>
            @endif
            {{-- End Lov exceptions --}}

            @error('dataProcedureICD9CmLovSearch')
                <x-input-error :messages=$message />
            @enderror
        </div>
        {{-- Lov dataProcedureICD9CmLov --}}
    </div>
@endif
