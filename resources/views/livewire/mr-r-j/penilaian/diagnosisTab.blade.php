<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <x-input-label for="dataDaftarPoliRJ.penilaian.dignosis.dignosis" :value="__('dignosis')" :required="__(false)"
                class="pt-2 sm:text-xl" />


            <div class="mb-2">
                <x-input-label for="dataDaftarPoliRJ.penilaian.dignosis.dignosis" :value="__('Diagnosis')" :required="__(false)" />

                <x-text-input-area id="dataDaftarPoliRJ.penilaian.dignosis.dignosis" placeholder="Diagnosis"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.penilaian.dignosis.dignosis'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.penilaian.dignosis.dignosis" :rows="__('10')" />
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
