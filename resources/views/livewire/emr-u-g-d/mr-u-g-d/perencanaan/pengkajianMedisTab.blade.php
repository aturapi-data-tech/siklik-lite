<div>
    <div class="w-full mb-1">

        <div class="mb-2 ">
            <p class="text-sm font-medium text-gray-900">
                Waktu Datang
                :{{ isset($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang'])
                    ? ($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang']
                        ? $dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang']
                        : '-')
                    : '-' }}

            </p>
        </div>

        <div class="mb-2 ">
            <x-input-label for="dataDaftarUgd.perencanaan.pengkajianMedis.waktuPemeriksaan" :value="__('Waktu Pemeriksaan')"
                :required="__(true)" />

            <div class="flex items-center mb-2 ">
                <x-text-input id="dataDaftarUgd.perencanaan.pengkajianMedis.waktuPemeriksaan"
                    placeholder="Waktu Pemeriksaan [dd/mm/yyyy hh24:mi:ss]" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.perencanaan.pengkajianMedis.waktuPemeriksaan'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarUgd.perencanaan.pengkajianMedis.waktuPemeriksaan" />
                @isset($dataDaftarUgd['perencanaan']['pengkajianMedis']['waktuPemeriksaan'])
                    @if (!$dataDaftarUgd['perencanaan']['pengkajianMedis']['waktuPemeriksaan'])
                        <div class="w-1/2 ml-2">
                            <div wire:loading wire:target="setWaktuPemeriksaan">
                                <x-loading />
                            </div>

                            <x-green-button :disabled=false
                                wire:click.prevent="setWaktuPemeriksaan('{{ date('d/m/Y H:i:s') }}')" type="button"
                                wire:loading.remove>
                                <div wire:poll>

                                    Waktu Pemeriksaan: {{ date('d/m/Y H:i:s') }}

                                </div>
                            </x-green-button>
                        </div>
                    @endif
                @endisset
            </div>
            @error('dataDaftarUgd.perencanaan.pengkajianMedis.waktuPemeriksaan')
                <x-input-error :messages=$message />
            @enderror

        </div>

        <div class="mb-2 ">
            <x-input-label for="dataDaftarUgd.perencanaan.pengkajianMedis.selesaiPemeriksaan" :value="__('Selesai Pemeriksaan')"
                :required="__(true)" />

            <div class="flex items-center mb-2 ">
                <x-text-input id="dataDaftarUgd.perencanaan.pengkajianMedis.selesaiPemeriksaan"
                    placeholder="Selesai Pemeriksaan [dd/mm/yyyy hh24:mi:ss]" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.perencanaan.pengkajianMedis.selesaiPemeriksaan'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarUgd.perencanaan.pengkajianMedis.selesaiPemeriksaan" />
                @isset($dataDaftarUgd['perencanaan']['pengkajianMedis']['selesaiPemeriksaan'])
                    @if (!$dataDaftarUgd['perencanaan']['pengkajianMedis']['selesaiPemeriksaan'])
                        <div class="w-1/2 ml-2">
                            <div wire:loading wire:target="setSelesaiPemeriksaan">
                                <x-loading />
                            </div>

                            <x-green-button :disabled=false
                                wire:click.prevent="setSelesaiPemeriksaan('{{ date('d/m/Y H:i:s') }}')" type="button"
                                wire:loading.remove>
                                <div wire:poll>

                                    Selesai Pemeriksaan: {{ date('d/m/Y H:i:s') }}

                                </div>
                            </x-green-button>
                        </div>
                    @endif
                @endisset
            </div>
            @error('dataDaftarUgd.perencanaan.pengkajianMedis.selesaiPemeriksaan')
                <x-input-error :messages=$message />
            @enderror

        </div>

        <div class="mb-2 ">
            <x-input-label for="dataDaftarUgd.perencanaan.pengkajianMedis.drPemeriksa" :value="__('Dokter Pemeriksa')"
                :required="__(true)" />
            <div class="grid grid-cols-1 gap-2 ">
                <x-text-input id="dataDaftarUgd.perencanaan.pengkajianMedis.drPemeriksa" placeholder="Dokter Pemeriksa"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarUgd.perencanaan.pengkajianMedis.drPemeriksa'))" :disabled=true
                    wire:model.debounce.500ms="dataDaftarUgd.perencanaan.pengkajianMedis.drPemeriksa" />

                <x-yellow-button :disabled=false wire:click.prevent="setDrPemeriksa()" type="button"
                    wire:loading.remove>
                    ttd Dokter
                </x-yellow-button>



                <livewire:cetak.cetak-eresep-u-g-d :rjNoRef="$rjNoRef"
                    wire:key="cetak.cetak-eresep-u-g-d-{{ $rjNoRef }}">

            </div>
            @error('dataDaftarUgd.perencanaan.pengkajianMedis.drPemeriksa')
                <x-input-error :messages=$message />
            @enderror

        </div>


        @isset($dataDaftarUgd['perencanaan']['pengkajianMedis']['waktuPemeriksaan'])
            @isset($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang'])
                @if (
                    $dataDaftarUgd['perencanaan']['pengkajianMedis']['waktuPemeriksaan'] &&
                        $dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang']
                )
                    <div class="mb-2">
                        @error('dataDaftarUgd.anamnesa.pengkajianPerawatan.jamDatang')
                            <p class="text-sm font-medium text-gray-900">
                                Waktu Response untu pasien {{ $dataDaftarUgd['regNo'] }} adalah
                                {{ '-' }}
                            </p>
                        @else
                            @error('dataDaftarUgd.perencanaan.pengkajianMedis.waktuPemeriksaan')
                                <p class="text-sm font-medium text-gray-900">
                                    Waktu Response untu pasien {{ $dataDaftarUgd['regNo'] }} adalah
                                    {{ '-' }}
                                </p>
                            @else
                                @inject('carbon', 'Carbon\Carbon')
                                <p class="text-sm font-medium text-gray-900">
                                    Waktu Response untu pasien {{ $dataDaftarUgd['regNo'] }} adalah
                                    {{ $carbon
                                        ::createFromFormat('d/m/Y H:i:s', $dataDaftarUgd['perencanaan']['pengkajianMedis']['waktuPemeriksaan'])->diff($carbon::createFromFormat('d/m/Y H:i:s', $dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang']))->format('%H:%I:%S') }}
                                </p>
                            @enderror
                        @enderror
                    </div>
                @endif
            @endisset
        @endisset


    </div>
</div>
