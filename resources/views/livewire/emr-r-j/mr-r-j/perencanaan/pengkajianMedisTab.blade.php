<div>
    <div class="w-full mb-1">

        {{-- <div class="mb-2 ">
            <p class="text-sm font-medium text-gray-900">
                Waktu Datang
                :{{ isset($dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['jamDatang'])
                    ? ($dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['jamDatang']
                        ? $dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['jamDatang']
                        : '-')
                    : '-' }}

            </p>
        </div> --}}

        {{-- <div class="mb-2 ">
            <x-input-label for="dataDaftarPoliRJ.perencanaan.pengkajianMedis.waktuPemeriksaan" :value="__('Waktu Pemeriksaan')"
                :required="__(true)" />

            <div class="flex items-center mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.perencanaan.pengkajianMedis.waktuPemeriksaan"
                    placeholder="Waktu Pemeriksaan [dd/mm/yyyy hh24:mi:ss]" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.perencanaan.pengkajianMedis.waktuPemeriksaan'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.perencanaan.pengkajianMedis.waktuPemeriksaan" />
                @isset($dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['waktuPemeriksaan'])
                    @if (!$dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['waktuPemeriksaan'])
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
            @error('dataDaftarPoliRJ.perencanaan.pengkajianMedis.waktuPemeriksaan')
                <x-input-error :messages=$message />
            @enderror

        </div> --}}

        {{-- <div class="mb-2 ">
            <x-input-label for="dataDaftarPoliRJ.perencanaan.pengkajianMedis.selesaiPemeriksaan" :value="__('Selesai Pemeriksaan')"
                :required="__(true)" />

            <div class="flex items-center mb-2 ">
                <x-text-input id="dataDaftarPoliRJ.perencanaan.pengkajianMedis.selesaiPemeriksaan"
                    placeholder="Selesai Pemeriksaan [dd/mm/yyyy hh24:mi:ss]" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.perencanaan.pengkajianMedis.selesaiPemeriksaan'))"
                    :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarPoliRJ.perencanaan.pengkajianMedis.selesaiPemeriksaan" />
                @isset($dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['selesaiPemeriksaan'])
                    @if (!$dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['selesaiPemeriksaan'])
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
            @error('dataDaftarPoliRJ.perencanaan.pengkajianMedis.selesaiPemeriksaan')
                <x-input-error :messages=$message />
            @enderror

        </div> --}}

        <div class="mb-2 ">
            <x-input-label for="dataDaftarPoliRJ.perencanaan.pengkajianMedis.drPemeriksa" :value="__('Dokter Pemeriksa')"
                :required="__(true)" />
            <div class="grid grid-cols-1 gap-2 ">
                <x-text-input id="dataDaftarPoliRJ.perencanaan.pengkajianMedis.drPemeriksa" placeholder="Dokter Pemeriksa"
                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.perencanaan.pengkajianMedis.drPemeriksa'))" :disabled=true
                    wire:model.debounce.500ms="dataDaftarPoliRJ.perencanaan.pengkajianMedis.drPemeriksa" />

                <x-yellow-button :disabled=false wire:click.prevent="setDrPemeriksa()" type="button" wire:loading.remove>
                    ttd Dokter
                </x-yellow-button>

                <livewire:cetak.cetak-eresep-r-j :rjNoRef="$rjNoRef"
                    wire:key="cetak.cetak-eresep-r-j-{{ $rjNoRef }}">

            </div>
            @error('dataDaftarPoliRJ.perencanaan.pengkajianMedis.drPemeriksa')
                <x-input-error :messages=$message />
            @enderror

        </div>
        {{-- @isset($dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['waktuPemeriksaan'])
            @isset($dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['jamDatang'])
                @if ($dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['waktuPemeriksaan'] && $dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['jamDatang'])
                    <div class="mb-2">
                        @error('dataDaftarPoliRJ.anamnesa.pengkajianPerawatan.jamDatang')
                            <p class="text-sm font-medium text-gray-900">
                                Waktu Response untu pasien {{ $dataDaftarPoliRJ['regNo'] }} adalah
                                {{ '-' }}
                            </p>
                        @else
                            @error('dataDaftarPoliRJ.perencanaan.pengkajianMedis.waktuPemeriksaan')
                                <p class="text-sm font-medium text-gray-900">
                                    Waktu Response untu pasien {{ $dataDaftarPoliRJ['regNo'] }} adalah
                                    {{ '-' }}
                                </p>
                            @else
                                @inject('carbon', 'Carbon\Carbon')
                                <p class="text-sm font-medium text-gray-900">
                                    Waktu Response untu pasien {{ $dataDaftarPoliRJ['regNo'] }} adalah
                                    {{ $carbon
                                        ::createFromFormat('d/m/Y H:i:s', $dataDaftarPoliRJ['perencanaan']['pengkajianMedis']['waktuPemeriksaan'])->diff($carbon::createFromFormat('d/m/Y H:i:s', $dataDaftarPoliRJ['anamnesa']['pengkajianPerawatan']['jamDatang']))->format('%H:%I:%S') }}
                                </p>
                            @enderror
                        @enderror
                    </div>
                @endif
            @endisset
        @endisset --}}


    </div>
</div>
