<div>
    <div class="w-full mb-1">

        <div>
            <x-input-label for="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.jamDatang" :value="__('Waktu Datang')"
                :required="__(true)" />

            <div class="mb-2 ">
                <div class="flex items-center mb-2 ">
                    <x-text-input id="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.jamDatang"
                        placeholder="Waktu Datang [dd/mm/yyyy hh24:mi:ss]" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.jamDatang'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.jamDatang" />

                    @if (!$dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['jamDatang'])
                        <div class="w-1/2 ml-2">
                            <div wire:loading wire:target="setJamDatang">
                                <x-loading />
                            </div>

                            <x-green-button :disabled=false
                                wire:click.prevent="setJamDatang('{{ date('d/m/Y H:i:s') }}')" type="button"
                                wire:loading.remove>
                                <div wire:poll>

                                    Set Jam Datang: {{ date('d/m/Y H:i:s') }}

                                </div>
                            </x-green-button>
                        </div>
                    @endif
                </div>

            </div>
            @error('dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.jamDatang')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.perawatPenerima" :value="__('Perawat Penerima')"
                :required="__(true)" class="pt-2 sm:text-xl" />

            <div class="mb-2 ">
                <div class="grid gap-2 mb-2">
                    <x-text-input id="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.perawatPenerima"
                        name="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.perawatPenerima"
                        placeholder="Perawat Penerima" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.perawatPenerima'))" :disabled=true
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.perawatPenerima"
                        autocomplete="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.perawatPenerima" />

                    <x-yellow-button :disabled=false wire:click.prevent="setPerawatPenerima()" type="button"
                        wire:loading.remove>
                        ttd Perawat
                    </x-yellow-button>
                </div>

            </div>
            @error('dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.perawatPenerima')
                <x-input-error :messages=$message />
            @enderror
        </div>



        {{-- <div class="mb-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.caraMasukRj" :value="__('Cara Masuk RJ')"
                :required="__(true)" class="pt-2 sm:text-xl" />

            <div class="mb-2 ">

                <div class="grid grid-cols-4 gap-2 mt-2 ml-2">
                    @foreach ($dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['caraMasukRjOption'] as $caraMasukRjOption)
                        <x-radio-button :label="__($caraMasukRjOption['caraMasukRj'])" value="{{ $caraMasukRjOption['caraMasukRj'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.caraMasukRj" />
                    @endforeach


                    <x-text-input id="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.caraMasukRjDesc"
                        placeholder="Keterangan Cara Masuk Rj" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.caraMasukRjDesc'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.caraMasukRjDesc" />


                </div>
            </div>

        </div> --}}

        {{-- <div class="mb-2">
            <x-input-label for="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.tingkatKegawatan" :value="__('Tingkat Kegawatan')"
                :required="__(true)" class="pt-2 sm:text-xl" />

            <div class="mb-2 ">

                <div class="grid grid-cols-4 gap-2 mt-2 ml-2">
                    @foreach ($dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['tingkatKegawatanOption'] as $tingkatKegawatanOption)
                       
                        <x-radio-button :label="__($tingkatKegawatanOption['tingkatKegawatan'])" value="{{ $tingkatKegawatanOption['tingkatKegawatan'] }}"
                            wire:model="dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.tingkatKegawatan" />
                    @endforeach
                </div>
            </div>

        </div> --}}




    </div>
</div>
