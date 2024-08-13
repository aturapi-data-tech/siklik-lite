<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <x-input-label for="dataDaftarUgd.pemeriksaan.anatomi" :value="__('Anatomi')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <div id="TransaksiRawatJalan" x-data="{ activeTab: 'kepala' }" class="flex">
                <div class="w-[200px] h-80 overflow-auto">
                    @foreach ($dataDaftarUgd['pemeriksaan']['anatomi'] as $key => $pAnatomi)
                        <div class="flex px-2 mb-2 border-b border-gray-200 dark:border-gray-700 ">
                            <ul class="inline -mb-px text-xs font-medium text-center text-gray-500 ">
                                <li class="mr-2">
                                    <label
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        :class="activeTab === '{{ $key }}' ?
                                            'text-primary border-primary bg-gray-100' : ''"
                                        @click="activeTab ='{{ $key }}'">{{ strtoupper($key) }}</label>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>


                <div class="w-full">
                    @foreach ($dataDaftarUgd['pemeriksaan']['anatomi'] as $key => $pAnatomi)
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                            :class="{
                                'active': activeTab === '{{ $key }}'
                            }"
                            x-show.transition.in.opacity.duration.600="activeTab === '{{ $key }}'">

                            <x-input-label for="dataDaftarUgd.pemeriksaan.anatomi.{{ $key }}.kelainan"
                                :value="__(strtoupper($key))" :required="__(false)" />

                            <div class="flex mt-2 ml-2">
                                @foreach ($pAnatomi['kelainanOptions'] as $kelainanOptions)
                                    {{-- @dd($sRj) --}}
                                    <x-radio-button :label="__($kelainanOptions['kelainan'])" value="{{ $kelainanOptions['kelainan'] }}"
                                        wire:model="dataDaftarUgd.pemeriksaan.anatomi.{{ $key }}.kelainan" />
                                @endforeach
                            </div>
                            <x-text-input-area id="dataDaftarUgd.pemeriksaan.anatomi.{{ $key }}.kelainan"
                                placeholder="{{ strtoupper($key) }}" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.pemeriksaan.anatomi'))"
                                :disabled=$disabledPropertyRjStatus
                                wire:model.debounce.500ms="dataDaftarUgd.pemeriksaan.anatomi.{{ $key }}.desc"
                                :rows="__('10')" />

                        </div>
                    @endforeach
                </div>
            </div>


        </div>




    </div>


</div>
