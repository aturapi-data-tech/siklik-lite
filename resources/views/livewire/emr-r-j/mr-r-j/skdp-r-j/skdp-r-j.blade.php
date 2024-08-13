<div>
    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp

    <div class="w-full mb-1">


        <form class="scroll-smooth hover:scroll-auto">
            <div class="grid grid-cols-1">


                <div id="TransaksiRawatJalan" class="grid grid-cols-2 gap-2">

                    <div>

                        <div>
                            <div class='grid items-center grid-cols-2 gap-4'>
                                <x-input-label for="dataDaftarPoliRJ.kontrol.noKontrolRS" :value="__('No Kontrol RS')"
                                    :required="__(true)" />

                                <x-input-label for="dataDaftarPoliRJ.kontrol.noSEP" :value="__('SEP')"
                                    :required="__(false)" />
                            </div>

                            <div class="grid items-center grid-cols-2 gap-2">
                                <x-text-input id="dataDaftarPoliRJ.kontrol.noKontrolRS" placeholder="No Kontrol RS"
                                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.kontrol.noKontrolRS'))" :disabled=true
                                    wire:model.debounce.500ms="dataDaftarPoliRJ.kontrol.noKontrolRS" />

                                <x-text-input id="dataDaftarPoliRJ.kontrol.noSEP" placeholder="SEP" class="mt-1 ml-2"
                                    :errorshas="__($errors->has('dataDaftarPoliRJ.kontrol.noSEP'))" :disabled=true
                                    wire:model.debounce.500ms="dataDaftarPoliRJ.kontrol.noSEP" />

                            </div>
                            @error('dataDaftarPoliRJ.kontrol.noKontrolRS')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="dataDaftarPoliRJ.kontrol.noSKDPBPJS" :value="__('No SKDP BPJS ')"
                                :required="__(false)" />

                            <div class="flex items-center">
                                <x-text-input id="dataDaftarPoliRJ.kontrol.noSKDPBPJS" placeholder="No SKDP BPJS "
                                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.kontrol.noSKDPBPJS'))" :disabled=true
                                    wire:model.debounce.500ms="dataDaftarPoliRJ.kontrol.noSKDPBPJS" />

                            </div>
                            @error('dataDaftarPoliRJ.kontrol.noSKDPBPJS')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="dataDaftarPoliRJ.kontrol.noAntrian" :value="__('No Antrian')"
                                :required="__(false)" />

                            <div class="flex items-center">
                                <x-text-input id="dataDaftarPoliRJ.kontrol.noAntrian" placeholder="No Antrian"
                                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.kontrol.noAntrian'))" :disabled=$disabledPropertyRjStatus
                                    wire:model.debounce.500ms="dataDaftarPoliRJ.kontrol.noAntrian" />

                            </div>
                            @error('dataDaftarPoliRJ.kontrol.noAntrian')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>
                    <div>


                        <div>
                            <x-input-label for="dataDaftarPoliRJ.kontrol.tglKontrol" :value="__('Tgl Kontrol')"
                                :required="__(true)" />

                            <div class="flex items-center">
                                <x-text-input id="dataDaftarPoliRJ.kontrol.tglKontrol"
                                    placeholder="Tgl Kontrol [dd/mm/yyyy]" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.kontrol.tglKontrol'))"
                                    :disabled=$disabledPropertyRjStatus
                                    wire:model.debounce.500ms="dataDaftarPoliRJ.kontrol.tglKontrol" />

                            </div>
                            @error('dataDaftarPoliRJ.kontrol.tglKontrol')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>

                        <div>
                            <x-input-label :value="__('Dokter')" :required="__(true)" />
                            <div class="mt-1 ml-2 ">
                                <div class="flex ">
                                    <x-text-input placeholder="Dokter" class="sm:rounded-none sm:rounded-l-lg"
                                        :errorshas="__($errors->has('dataDaftarPoliRJ.kontrol.drKontrol'))" :disabled=true
                                        value="{{ $dataDaftarPoliRJ['kontrol']['drKontrol'] . ' / ' . $dataDaftarPoliRJ['kontrol']['drKontrolBPJS'] . ' ' . $dataDaftarPoliRJ['kontrol']['drKontrolDesc'] }}" />
                                    <x-green-button :disabled=$disabledPropertyRjStatus
                                        class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                        wire:click.prevent="clickdataDokterlov()">
                                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path clip-rule="evenodd" fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </x-green-button>
                                </div>

                                {{-- <div wire:loading wire:target="dataDokterLovSearch">
                                        <x-loading />
                                    </div> --}}
                                {{-- LOV Dokter --}}
                                <div class="mt-2">
                                    @include('livewire.mr-r-j.skdp.list-of-value-caridatadokter')
                                </div>

                            </div>
                            @error('dataDaftarPoliRJ.kontrol.drKontrol')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>

                        <div>
                            <x-input-label :value="__('Poli')" :required="__(true)" />
                            <div class="flex items-center">
                                <x-text-input placeholder="Poli" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.kontrol.poliKontrol'))"
                                    :disabled=$disabledProperty
                                    value="{{ $dataDaftarPoliRJ['kontrol']['poliKontrol'] . ' / ' . $dataDaftarPoliRJ['kontrol']['poliKontrolBPJS'] . ' ' . $dataDaftarPoliRJ['kontrol']['poliKontrolDesc'] }}" />
                            </div>
                            @error('dataDaftarPoliRJ.kontrol.poliKontrol')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="dataDaftarPoliRJ.kontrol.catatan" :value="__('Keterangan')"
                                :required="__(false)" />

                            <div class="flex items-center">
                                <x-text-input id="dataDaftarPoliRJ.kontrol.catatan" placeholder="Keterangan"
                                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.kontrol.catatan'))" :disabled=$disabledPropertyRjStatus
                                    wire:model.debounce.500ms="dataDaftarPoliRJ.kontrol.catatan" />

                            </div>
                            @error('dataDaftarPoliRJ.kontrol.catatan')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                </div>



            </div>

            <div class="sticky bottom-0 flex justify-end px-4 py-3 bg-gray-50 sm:px-6">


                <div class="">
                    <div wire:loading wire:target="cetakSKDP">
                        <x-loading />
                    </div>

                    <x-yellow-button :disabled=$disabledPropertyRjStatus wire:click.prevent="cetakSKDP()" type="button"
                        wire:loading.remove>
                        Cetak SKDP
                    </x-yellow-button>
                </div>

                <div>
                    <div wire:loading wire:target="store">
                        <x-loading />
                    </div>

                    <x-green-button :disabled=$disabledPropertyRjStatus wire:click.prevent="store()" type="button"
                        wire:loading.remove>
                        Simpan SKDP
                    </x-green-button>
                </div>
            </div>


        </form>







    </div>

</div>
