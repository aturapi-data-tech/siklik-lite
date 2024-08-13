<x-border-form :title="__('Kesimpulan')" :align="__('center')">
    <div id="divKesimpulan" class="">
        <div>
            <div class="flex items-center my-2">

                @isset($dataDaftarPoliRJ['screeningKesimpulan']['sck_option'])
                    @foreach ($dataDaftarPoliRJ['screeningKesimpulan']['sck_option'] as $key => $scK)
                        @php
                            $radioPropertyColor = $scK['option_value'] == 1 ? 'bg-green-100' : ($scK['option_value'] == 2 ? 'bg-yellow-100' : ($scK['option_value'] == 3 ? 'bg-red-100' : 'bg-grey-100'));
                        @endphp
                        <div
                            class="flex items-center pl-4 mr-4 {{ $radioPropertyColor }} border border-gray-200 rounded basis-full dark:border-gray-700 hover:bg-gray-100">
                            <input id="kesimpulan{{ $key }}" type="radio" value="{{ $scK['option_value'] }}"
                                wire:click="prosesDataKesimpulan(
                            {{ $scK['option_value'] }},
                            '{{ $scK['option_label'] }}')"
                                wire:model="dataDaftarPoliRJ.screeningKesimpulan.sck_value"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="kesimpulan{{ $key }}"
                                class="w-full py-3 pr-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                {{ $scK['option_label'] }}
                            </label>
                        </div>
                    @endforeach
                @endisset

            </div>

        </div>
    </div>
</x-border-form>
