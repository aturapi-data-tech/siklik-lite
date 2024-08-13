<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <x-input-label for="dataDaftarUgd.penilaian.dignosis.dignosis" :value="__('dignosis')" :required="__(false)"
                class="pt-2 sm:text-xl" />


            <div class="mb-2">
                <x-input-label for="dataDaftarUgd.penilaian.dignosis.dignosis" :value="__('Diagnosis')" :required="__(false)" />

                <x-text-input-area id="dataDaftarUgd.penilaian.dignosis.dignosis" placeholder="Diagnosis" class="mt-1 ml-2"
                    :errorshas="__($errors->has('dataDaftarUgd.penilaian.dignosis.dignosis'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarUgd.penilaian.dignosis.dignosis" :rows="__('10')" />
            </div>







        </div>




    </div>


</div>
