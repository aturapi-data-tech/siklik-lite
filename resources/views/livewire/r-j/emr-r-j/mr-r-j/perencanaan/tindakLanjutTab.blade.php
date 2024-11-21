<div>
    <div class="w-full mb-1">

        <div class="pt-0">

            <x-input-label for="dataDaftarPoliRJ.perencanaan.tindakLanjut.tindakLanjut" :value="__('Tindak Lanjut')"
                :required="__(false)" class="pt-2 sm:text-xl" />


            <div class="pt-2 ">

                <div class="grid grid-cols-3 gap-2 mt-2 mb-2 ml-2">
                    @foreach ($dataDaftarPoliRJ['perencanaan']['tindakLanjut']['tindakLanjutOptions'] ?? [] as $tindakLanjutOptions)
                        <x-radio-button :label="__($tindakLanjutOptions['tindakLanjut'])" value="{{ $tindakLanjutOptions['tindakLanjut'] }}"
                            wire:model="dataDaftarPoliRJ.perencanaan.tindakLanjut.tindakLanjut" />
                    @endforeach


                </div>

                <div>
                    <x-text-input id="" placeholder="Keterangan Tindak Lanjut" class="mt-1 ml-2"
                        :errorshas="__($errors->has(''))" :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.perencanaan.tindakLanjut.keteranganTindakLanjut" />
                </div>
            </div>


        </div>



    </div>
</div>
