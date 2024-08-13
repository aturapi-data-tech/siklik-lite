<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <x-input-label for="dataDaftarPoliRJ.penilaian.statusPediatrik.statusPediatrik" :value="__('Status Pediatrik')"
                :required="__(false)" class="pt-2 sm:text-xl" />


            <div class="pt-2 ">

                <div class="grid grid-flow-row gap-2 mt-2 ml-2">
                    <x-input-label for="" :value="__('Status Pediatrik')" :required="__(false)" class="px-2" />

                    @foreach ($dataDaftarPoliRJ['penilaian']['statusPediatrik']['statusPediatrikOptions'] as $statusPediatrikOptions)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($statusPediatrikOptions['statusPediatrik'])" value="{{ $statusPediatrikOptions['statusPediatrik'] }}"
                            wire:model="dataDaftarPoliRJ.penilaian.statusPediatrik.statusPediatrik" />
                    @endforeach

                </div>

            </div>

            <div class="grid grid-cols-6">
                <div class="mb-2 ">
                    <x-text-input id="" placeholder="" class="mt-1 ml-2" :errorshas="__($errors->has(''))" :disabled=true
                        wire:model.debounce.500ms="" />
                </div>


            </div>

        </div>




    </div>


</div>
