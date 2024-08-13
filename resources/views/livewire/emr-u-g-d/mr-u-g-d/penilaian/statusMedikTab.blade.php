<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <x-input-label for="dataDaftarUgd.penilaian.fisik.fisik" :value="__('Status Medik')" :required="__(false)"
                class="pt-2 sm:text-xl" />


            <div class="grid grid-cols-4 gap-2 mt-2 ml-2">

                @foreach ($dataDaftarUgd['penilaian']['statusMedik']['statusMedikOptions'] as $statusMedikOptions)
                    {{-- @dd($sRj) --}}
                    <x-radio-button :label="__($statusMedikOptions['statusMedik'])" value="{{ $statusMedikOptions['statusMedik'] }}"
                        wire:model="dataDaftarUgd.penilaian.statusMedik.statusMedik" />
                @endforeach

            </div>







        </div>




    </div>


</div>
