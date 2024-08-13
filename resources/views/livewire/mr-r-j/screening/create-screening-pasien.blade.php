<x-border-form :title="__('Pertanyaan?')" :align="__('start')">
    <div id="divScreeningPasien" class="flex flex-col w-full my-2">
        @isset($dataDaftarPoliRJ['screening'])
            @foreach ($dataDaftarPoliRJ['screening'] as $key => $sQ)
                <div>
                    @if (isset($sQ['sc_image']))
                        <div class="flex justify-center">
                            <img src="/pain_scale_level.jpg" class="object-fill h-auto w-1/2 ...">
                        </div>
                    @endif
                    <div class="flex items-center mt-2">
                        {{-- image pain scale level --}}

                        <x-input-label class="basis-1/3" :value="$sQ['sc_desc']" />


                        @isset($sQ['sc_option'])
                            @foreach ($sQ['sc_option'] as $sCO)
                                @php
                                    $radioPropertyColor = $sCO['option_value'] == 1 ? 'bg-green-100' : ($sCO['option_value'] == 2 ? 'bg-yellow-100' : ($sCO['option_value'] == 3 ? 'bg-red-100' : 'bg-grey-100'));
                                @endphp

                                <div
                                    class="flex items-center pl-4 mr-4 {{ $radioPropertyColor }} border border-gray-200 rounded  dark:border-gray-700 hover:bg-gray-100">

                                    <input id="{{ $sCO['option_label'] }}" type="radio" value="{{ $sCO['option_value'] }}"
                                        wire:click="prosesDataScreening(
                                '{{ $sQ['sc_desc'] }}',
                                '{{ $sCO['option_value'] }}',
                                '{{ $sCO['option_score'] }}',
                                '{{ $sCO['option_label'] }}',
                                '{{ $key }}',
                                )"
                                        wire:model="dataDaftarPoliRJ.screening.{{ $key }}.sc_value"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">

                                    <label for="{{ $sCO['option_label'] }}"
                                        class="w-full py-3 pr-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        {{ $sCO['option_label'] }}
                                    </label>
                                </div>
                            @endforeach
                        @endisset

                    </div>

                </div>
            @endforeach
        @endisset


    </div>
</x-border-form>
