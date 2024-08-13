    @if (!$collectingMyDiagnosaICD10)
        <div>
            <x-input-label for="dataDiagnosaICD10LovSearch" :value="__('Kode ICD10')" :required="__(true)" />

            {{-- Lov dataDiagnosaICD10Lov --}}
            <div x-data="{ selecteddataDiagnosaICD10LovIndex: @entangle('selecteddataDiagnosaICD10LovIndex') }" @click.outside="$wire.dataDiagnosaICD10LovSearch = ''">
                <x-text-input id="dataDiagnosaICD10LovSearch" placeholder="Kode ICD10" class="mt-1 ml-2" :errorshas="__($errors->has('dataDiagnosaICD10LovSearch'))"
                    :disabled=$disabledPropertyRjStatus wire:model.debounce.1000ms="dataDiagnosaICD10LovSearch"
                    x-on:click.outside="$wire.resetdataDiagnosaICD10Lov()"
                    x-on:keyup.escape="$wire.resetdataDiagnosaICD10Lov()"
                    x-on:keyup.down="$wire.selectNextdataDiagnosaICD10Lov()"
                    x-on:keyup.up="$wire.selectPreviousdataDiagnosaICD10Lov()"
                    x-on:keyup.enter="$wire.enterMydataDiagnosaICD10Lov(selecteddataDiagnosaICD10LovIndex)"
                    x-ref="dataDiagnosaICD10LovSearchfocus" x-init="$watch('selecteddataDiagnosaICD10LovIndex', (value, oldValue) => $refs.dataDiagnosaICD10LovSearch.children[selecteddataDiagnosaICD10LovIndex + 1].scrollIntoView({
                        block: 'nearest'
                    }))" />

                {{-- Lov --}}
                <div class="py-2 mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-64"
                    x-show="$wire.dataDiagnosaICD10LovSearch.length>1 && $wire.dataDiagnosaICD10Lov.length>0"
                    x-transition x-ref="dataDiagnosaICD10LovSearch">
                    {{-- alphine --}}
                    {{-- <template x-for="(dataDiagnosaICD10Lovx, index) in $wire.dataDiagnosaICD10Lov">
            <button x-text="dataDiagnosaICD10Lovx.acte_desc"
                class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                :class="{
                    'bg-gray-100 outline-none': index === $wire
                        .selecteddataDiagnosaICD10LovIndex
                }"
                x-on:click.prevent="$wire.setMydataDiagnosaICD10Lov(index)"></button>
        </template> --}}

                    {{-- livewire --}}
                    @foreach ($dataDiagnosaICD10Lov as $key => $lov)
                        <li wire:key='dataDiagnosaICD10Lov{{ $lov['icdx'] }}'>
                            <x-dropdown-link wire:click="setMydataDiagnosaICD10Lov('{{ $key }}')"
                                class="text-base font-normal {{ $key === $selecteddataDiagnosaICD10LovIndex ? 'bg-gray-100 outline-none' : '' }}">
                                <div>
                                    {{ $lov['icdx'] . '/ ' . $lov['diag_desc'] }}
                                </div>
                            </x-dropdown-link>
                        </li>
                    @endforeach

                </div>


                {{-- Start Lov exceptions --}}

                @if (strlen($dataDiagnosaICD10LovSearch) > 0 &&
                        strlen($dataDiagnosaICD10LovSearch) < 1 &&
                        count($dataDiagnosaICD10Lov) == 0)
                    <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                        {{ 'Masukkan minimal lebih dari 1  karakter' }}
                    </div>
                @elseif(strlen($dataDiagnosaICD10LovSearch) >= 1 && count($dataDiagnosaICD10Lov) == 0)
                    <div class="w-full p-2 text-sm text-center text-gray-500 dark:text-gray-400">
                        {{ 'Data Tidak ditemukan' }}
                    </div>
                @endif
                {{-- End Lov exceptions --}}

                @error('dataDiagnosaICD10LovSearch')
                    <x-input-error :messages=$message />
                @enderror
            </div>
            {{-- Lov dataDiagnosaICD10Lov --}}
        </div>
    @endif
