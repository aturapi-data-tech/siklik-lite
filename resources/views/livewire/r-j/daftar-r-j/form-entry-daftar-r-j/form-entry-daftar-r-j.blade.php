@php
    $disabledProperty = $rjStatusRef;
@endphp

<div>


    {{-- FormEntry --}}
    <div class="grid grid-cols-2 gap-2 mx-2">
        <x-border-form :title="__('Data Pasien')" :align="__('start')" :bgcolor="__('bg-white')" class="mr-0">
            <div>{{ $FormEntry['noUrutBpjs'] ?? 'X' }}</div>
            {{-- Display Pasien Componen --}}
            <div class="grid grid-cols-1">
                <livewire:component.display-pasien.display-pasien :regNoRef="$FormEntry['regNo']" :checkStatusKlaimPasien="$checkStatusKlaimPasien"
                    :wire:key="$FormEntry['regNo'].'display-pasien'">

            </div>
        </x-border-form>

        <x-border-form :title="__('Pendaftaran Rawat Jalan')" :align="__('start')" :bgcolor="__('bg-white')" class="mr-0">
            <div id="FormEntry" class="px-4">
                <div class="flex justify-end">
                    <div class="w-1/2">
                        <x-input-label for="FormEntry.rjDate" :value="__('Tanggal Rawat Jalan')" :required="__(true)" />
                        <div class="flex items-center mb-2">
                            <x-text-input id="FormEntry.rjDate" placeholder="Tanggal Rawat Jalan" class="mt-1 ml-2"
                                :errorshas="__($errors->has('FormEntry.rjDate'))" :disabled=$disabledProperty wire:model="FormEntry.rjDate" />
                        </div>
                        @error('FormEntry.rjDate')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>
                </div>


                <div class="flex justify-end ">
                    <x-check-box :label="__('Pasien Baru')" wire:model="FormEntry.passStatus" :value="__($FormEntry['passStatus'])" />
                </div>

                {{-- LOV Pasien --}}
                <div class="mb-2">
                    <div class="mb-2">
                        @include('livewire.component.l-o-v.list-of-value-caridataPasien.list-of-value-caridataPasien')
                    </div>
                </div>

                @if ($pasien)
                    @if (!$disabledProperty)
                        <div>
                            <x-input-label :value="__('Pasien')" :required="__(true)"
                                wire:click="$set('collectingMyPasien',[])" />
                            <div class="flex items-center mb-2">
                                <x-text-input placeholder="Pasien" class="mt-1 ml-2" :disabled=true
                                    value="{{ isset($pasien['regNo']) ? $pasien['regNo'] . ' / ' . $pasien['regName'] : '-' }}" />
                            </div>
                        </div>
                    @else
                        <div>
                            <x-input-label :value="__('Pasien')" :required="__(true)" />
                            <div class="flex items-center mb-2">
                                <x-text-input placeholder="Pasien" class="mt-1 ml-2" :disabled=true
                                    value="{{ isset($pasien['regNo']) ? $pasien['regNo'] . ' / ' . $pasien['regName'] : '-' }}" />
                            </div>
                        </div>
                    @endif
                    @error('FormEntry.regNo')
                        <x-input-error :messages=$message />
                    @enderror
                    @error('FormEntry.noKartu')
                        <x-input-error :messages=$message />
                    @enderror
                @endif

                <div>
                    <x-input-label for="jenisKlaim" :value="__('Jenis Klaim')" :required="__(true)" />
                    <div class="grid grid-cols-3 gap-2 ">

                        @foreach ($jenisKlaim['JenisKlaimOptions'] as $sRj)
                            {{-- @dd($sRj) --}}
                            <x-radio-button :label="__($sRj['JenisKlaimDesc'])" value="{{ $sRj['JenisKlaimId'] }}"
                                wire:model="jenisKlaim.JenisKlaimId" />
                        @endforeach

                    </div>
                    @error('jenisKlaim.JenisKlaimId')
                        <x-input-error :messages=$message />
                    @enderror
                </div>

                <div>
                    <x-input-label for="refTkp" :value="__('Tkp')" :required="__(true)" />
                    <div class="grid grid-cols-3 gap-2 ">

                        @foreach ($refTkp['refTkpOptions'] as $sRj)
                            {{-- @dd($sRj) --}}
                            <x-radio-button :label="__($sRj['refTkpDesc'])" value="{{ $sRj['refTkpId'] }}"
                                wire:model="refTkp.refTkpId" />
                        @endforeach

                    </div>
                    @error('refTkp.refTkpId')
                        <x-input-error :messages=$message />
                    @enderror
                </div>

                <div>
                    <x-input-label for="kunjSakit" :value="__('Kunjungan Sakit')" :required="__(true)" />
                    <div class="grid grid-cols-3 gap-2 ">

                        @foreach ($kunjSakit['kunjSakitOptions'] as $sRj)
                            {{-- @dd($sRj) --}}
                            <x-radio-button :label="__($sRj['kunjSakitDesc'])" value="{{ $sRj['kunjSakitId'] }}"
                                wire:model="kunjSakit.kunjSakitId" />
                        @endforeach

                        <div
                            class="text-gray-700 font-sm {{ $kunjSakit['kunjSakitId'] ? 'text-red-500' : 'text-green-500' }}">
                            {{ $kunjSakit['kunjSakitId'] ? '(Kunjungan Sakit)' : '(Kunjungan Sehat)' }}</div>

                    </div>
                    @error('kunjSakit.kunjSakitId')
                        <x-input-error :messages=$message />
                    @enderror
                </div>

                {{-- LOV Dokter --}}

                <div class="mb-2">
                    <div class="mb-2">
                        @include('livewire.component.l-o-v.list-of-value-caridataDokter.list-of-value-caridataDokter')
                    </div>

                    <div class="mb-2">
                        @error('FormEntry.drId')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>
                </div>



                @if ($dokter)
                    @if (!$disabledProperty)
                        <div>
                            <x-input-label :value="__('Dokter')" :required="__(true)"
                                wire:click="$set('collectingMyDokter',[])" />
                            <div class="flex items-center mb-2">
                                <x-text-input placeholder="Dokter" class="mt-1 ml-2" :disabled=true
                                    value="{{ isset($dokter['DokterId']) ? $dokter['DokterId'] . ' / ' . $dokter['DokterDesc'] : '-' }}" />
                            </div>
                        </div>

                        <div>
                            <x-input-label :value="__('Poli')" :required="__(true)" />
                            <div class="flex items-center mb-2">
                                <x-text-input placeholder="Poli" class="mt-1 ml-2" :disabled=true
                                    value="{{ isset($dokter['DokterId']) ? $dokter['PoliId'] . ' / ' . $dokter['PoliDesc'] : '-' }}" />
                            </div>
                        </div>
                    @else
                        <div>
                            <x-input-label :value="__('Dokter')" :required="__(true)" />
                            <div class="flex items-center mb-2">
                                <x-text-input placeholder="Dokter" class="mt-1 ml-2" :disabled=true
                                    value="{{ isset($dokter['DokterId']) ? $dokter['DokterId'] . ' / ' . $dokter['DokterDesc'] : '-' }}" />
                            </div>
                        </div>

                        <div>
                            <x-input-label :value="__('Poli')" :required="__(true)" />
                            <div class="flex items-center mb-2">
                                <x-text-input placeholder="Poli" class="mt-1 ml-2" :disabled=true
                                    value="{{ isset($dokter['DokterId']) ? $dokter['PoliId'] . ' / ' . $dokter['PoliDesc'] : '-' }}" />
                            </div>
                        </div>
                    @endif
                    @error('FormEntry.kdpolibpjs')
                        <x-input-error :messages=$message />
                    @enderror
                @endif


            </div>

        </x-border-form>

    </div>
    {{-- down bar --}}

    <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 ">
        <div class="">
            <div wire:loading wire:key="loadingcloseModal" wire:target="closeModal">
                <x-loading />
            </div>
            <x-light-button wire:click="closeModal()" type="button" wire:loading.remove>Keluar</x-light-button>
        </div>

        @if ($jenisKlaim['JenisKlaimId'] === 'JM')
            <div class="">
                <div wire:loading wire:key="loadingdeletePendaftaranPasienBPJS"
                    wire:target="deletePendaftaranPasienBPJS">
                    <x-loading />
                </div>
                <x-red-button wire:click="deletePendaftaranPasienBPJS('{{ $jenisKlaim['JenisKlaimId'] }}')"
                    type="button" wire:loading.remove>
                    Hapus Pasien BPJS Pcare
                </x-red-button>
            </div>


            <div class="">
                <div wire:loading wire:key="loadingcheckPendaftaranPasienBPJSbyNomorUrut"
                    wire:target="checkPendaftaranPasienBPJSbyNomorUrut">
                    <x-loading />
                </div>
                <x-primary-button
                    wire:click="checkPendaftaranPasienBPJSbyNomorUrut('{{ $FormEntry['noUrutBpjs'] ?? '' }}', '{{ $FormEntry['rjDate'] ?? '' }}')"
                    wire:loading.attr="disabled" wire:key="btnCekPendaftaran" wire:loading.remove>
                    Cek Pendaftaran BPJS PCare
                </x-primary-button>
            </div>


            <div class="">
                <div wire:loading wire:key="loadingcekStatusPasienBPJS" wire:target="cekStatusPasienBPJS">
                    <x-loading />
                </div>
                <x-yellow-button wire:click="cekStatusPasienBPJS()" type="button" wire:loading.remove>
                    Cek Status Pasien BPJS
                </x-yellow-button>
            </div>
        @endif

        <div class="">
            <div wire:loading wire:key="loadingstore" wire:target="store">
                <x-loading />
            </div>
            <x-green-button :disabled=$disabledProperty wire:click="store()" type="button" wire:loading.remove>
                Simpan
            </x-green-button>
        </div>
    </div>


</div>
