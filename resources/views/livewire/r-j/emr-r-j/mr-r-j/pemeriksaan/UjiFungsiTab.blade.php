<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <x-input-label for="dataDaftarPoliRJ.pemeriksaan.FisikujiFungsi.FisikujiFungsi" :value="__('Pemeriksaan Fisik dan Uji Fungsi')"
                :required="__(false)" class="pt-2 sm:text-xl" />


            <div class="mb-2">
                {{-- <x-input-label for="dataDaftarPoliRJ.pemeriksaan.FisikujiFungsi.FisikujiFungsi" :value="__('Pemeriksaan Fisik dan Uji Fungsi')"
                :required="__(false)" /> --}}

                <x-text-input-area id="dataDaftarPoliRJ.pemeriksaan.FisikujiFungsi.FisikujiFungsi"
                    placeholder="Pemeriksaan Fisik dan Uji Fungsi" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.FisikujiFungsi.FisikujiFungsi'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.FisikujiFungsi.FisikujiFungsi"
                    :rows="__('3')" />
            </div>



        </div>




    </div>


</div>
