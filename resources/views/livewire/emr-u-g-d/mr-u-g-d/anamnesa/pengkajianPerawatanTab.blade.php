<div>
    <div class="w-full mb-1">


        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.keluhanUtamaTab')

        <div>
            <x-input-label for="dataDaftarUgd.anamnesa.pengkajianPerawatan.jamDatang" :value="__('Waktu Datang')"
                :required="__(true)" />

            <div class="mb-2 ">
                <div class="flex items-center mb-2 ">
                    <x-text-input id="dataDaftarUgd.anamnesa.pengkajianPerawatan.jamDatang"
                        placeholder="Waktu Datang [dd/mm/yyyy hh24:mi:ss]" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.pengkajianPerawatan.jamDatang'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.pengkajianPerawatan.jamDatang" />

                    @if (!$dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang'])
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
            @error('dataDaftarUgd.anamnesa.pengkajianPerawatan.jamDatang')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div class="mb-2">
            <x-input-label for="dataDaftarUgd.anamnesa.pengkajianPerawatan.caraMasukIgd" :value="__('Cara Masuk IGD')"
                :required="__(true)" class="pt-2 sm:text-xl" />

            <div class="mb-2 ">

                <div class="grid grid-cols-4 gap-2 mt-2 ml-2">
                    @foreach ($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['caraMasukIgdOption'] as $caraMasukIgdOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($caraMasukIgdOption['caraMasukIgd'])" value="{{ $caraMasukIgdOption['caraMasukIgd'] }}"
                            wire:model="dataDaftarUgd.anamnesa.pengkajianPerawatan.caraMasukIgd" />
                    @endforeach



                    <x-text-input id="dataDaftarUgd.anamnesa.pengkajianPerawatan.caraMasukIgdDesc"
                        placeholder="Keterangan Cara Masuk IGD" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.pengkajianPerawatan.caraMasukIgdDesc'))"
                        :disabled=$disabledPropertyRjStatus
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.pengkajianPerawatan.caraMasukIgdDesc" />


                </div>
                @error('dataDaftarUgd.anamnesa.pengkajianPerawatan.caraMasukIgd')
                    <x-input-error :messages=$message />
                @enderror
            </div>

        </div>

        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.statusPsikologisTab')

        <div class="mb-2">
            <x-input-label for="dataDaftarUgd.anamnesa.pengkajianPerawatan.tingkatKegawatan" :value="__('Tingkat Kegawatan')"
                :required="__(true)" class="pt-2 sm:text-xl" />

            <div class="mb-2 ">

                <div class="grid grid-cols-4 gap-2 mt-2 ml-2">
                    @foreach ($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['tingkatKegawatanOption'] as $tingkatKegawatanOption)
                        {{-- @dd($sRj) --}}
                        <x-radio-button :label="__($tingkatKegawatanOption['tingkatKegawatan'])" value="{{ $tingkatKegawatanOption['tingkatKegawatan'] }}"
                            wire:model="dataDaftarUgd.anamnesa.pengkajianPerawatan.tingkatKegawatan" />
                    @endforeach
                </div>
            </div>

            @error('dataDaftarUgd.anamnesa.pengkajianPerawatan.tingkatKegawatan')
                <x-input-error :messages=$message />
            @enderror

        </div>

        <div>
            <x-input-label for="dataDaftarUgd.anamnesa.pengkajianPerawatan.perawatPenerima" :value="__('Perawat Penerima')"
                :required="__(true)" class="pt-2 sm:text-xl" />

            <div class="mb-2 ">
                <div class="grid gap-2 mb-2">
                    <x-text-input id="dataDaftarUgd.anamnesa.pengkajianPerawatan.perawatPenerima"
                        name="dataDaftarUgd.anamnesa.pengkajianPerawatan.perawatPenerima" placeholder="Perawat Penerima"
                        class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.anamnesa.pengkajianPerawatan.perawatPenerima'))" :disabled=true
                        wire:model.debounce.500ms="dataDaftarUgd.anamnesa.pengkajianPerawatan.perawatPenerima"
                        autocomplete="dataDaftarUgd.anamnesa.pengkajianPerawatan.perawatPenerima" />

                    <x-yellow-button :disabled=false wire:click.prevent="setPerawatPenerima()" type="button"
                        wire:loading.remove>
                        ttd Perawat
                    </x-yellow-button>

                </div>

            </div>
            @error('dataDaftarUgd.anamnesa.pengkajianPerawatan.perawatPenerima')
                <x-input-error :messages=$message />
            @enderror
        </div>


    </div>
</div>
