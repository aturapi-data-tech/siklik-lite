@php
    $disabledProperty = false;
    $disabledPropertyId = $isOpenMode == 'insert' ? false : true;
@endphp

<div>


    {{-- FormPcareKunjungan --}}
    <div id="FormPcareKunjungan" class="px-4">

        {{-- <div>
            <x-input-label for="FormEntry.addKunjungan.noKartu" :value="__('noKartu')" :required="__($errors->has('FormEntry.addKunjungan.noKartu'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntry.addKunjungan.noKartu" placeholder="noKartu" class="mt-1 ml-2"
                    :errorshas="__($errors->has('FormEntry.addKunjungan.noKartu'))" :disabled=$disabledPropertyId wire:model="FormEntry.addKunjungan.noKartu" />
            </div>
            @error('FormEntry.addKunjungan.noKartu')
                <x-input-error :messages=$message />
            @enderror
        </div> --}}

        <div class="grid grid-cols-4 gap-2 p-2 my-1 border border-gray-300 rounded-lg">
            <div class="col-span-3">
                <div class="text-base font-semibold text-gray-700">
                    {{ $displayPasien['pasien']['regNo'] ?? '-' }}
                </div>

                <div class="text-2xl font-semibold text-primary">
                    {{ $displayPasien['pasien']['regName'] ?? '-' }}
                    {{ ' / (' }}
                    {{ $displayPasien['pasien']['jenisKelamin']['jenisKelaminDesc'] ?? '-' }}
                    {{ ') /' }}
                    {{ $displayPasien['pasien']['thn'] ?? '-' }}
                </div>

                <div class="font-normal text-gray-700">
                    {{ $displayPasien['pasien']['identitas']['alamat'] ?? '-' }}
                </div>

                <div class="font-normal text-gray-700">
                    {{ $displayPasien['pasien']['identitas']['nik'] ?? '-' }}
                </div>

                <div class="font-normal text-gray-700">
                    {{ $displayPasien['pasien']['identitas']['idBpjs'] ?? '-' }}
                </div>

                <div class="font-normal text-gray-700">
                    {{ $displayPasien['pasien']['kontak']['nomerTelponSelulerPasien'] ?? '-' }}
                </div>

                <div class="font-normal text-gray-700">
                    {{ $displayPasien['pasien']['hubungan']['namaPenanggungJawab'] ?? '-' }}
                </div>
            </div>

            <div class="flex justify-end px-4">
                <div wire:loading wire:target="store">
                    <x-loading />
                </div>

                @if (empty($FormEntry['addKunjungan']['noKunjungan']))
                    <x-green-button wire:click="store()" type="button" wire:loading.remove>
                        Kirim Pcare
                    </x-green-button>
                @else
                    <x-light-button wire:click="store()" type="button" wire:loading.remove>
                        Update Pcare
                    </x-light-button>
                @endif
            </div>

        </div>

        <div class="flex justify-between">
            @if (!empty($FormEntry['addKunjungan']['noKunjungan']))
                <div class="flex justify-end px-4">
                    <div wire:loading wire:target="deleteKunjunganBpjs">
                        <x-loading />
                    </div>

                    <x-red-button wire:click="deleteKunjunganBpjs()" type="button" wire:loading.remove>
                        Delete Pcare
                    </x-red-button>

                    {{-- <x-red-button wire:click="getDiagnosaBpjs()" type="button" wire:loading.remove>
                GetDiagnosa
            </x-red-button> --}}
                </div>
            @endif

            @if (empty($FormEntry['addKunjungan']['noKunjungan']))
                <div class="flex justify-end px-4">
                    <div wire:loading wire:target="resetKunjunganBpjs">
                        <x-loading />
                    </div>

                    <x-yellow-button wire:click="resetKunjunganBpjs()" type="button" wire:loading.remove>
                        reset Pcare
                    </x-yellow-button>
                </div>
            @else
                <div class="flex justify-end px-4">
                    <div>
                        <livewire:component.cetak.cetak-surat-rujukan :rjNoRef="$rjNoRef"
                            :wire:key="$rjNoRef.'cetak-surat-rujukan'">
                    </div>

                    <div wire:loading wire:target="checkRiwayatKunjunganPasien,checkRujukanKunjungan">
                        <x-loading />
                    </div>

                    <x-yellow-button
                        wire:click="checkRiwayatKunjunganPasien('{{ addslashes($FormEntry['addKunjungan']['noKartu']) ?? '' }}')"
                        type="button" wire:key="btnCheckRiwayatKunjungan" wire:loading.remove>
                        Cek Riwayat Kunjungan
                    </x-yellow-button>

                    <x-yellow-button
                        wire:click="checkRujukanKunjungan('{{ addslashes($FormEntry['addKunjungan']['noKunjungan']) ?? '' }}')"
                        type="button" wire:key="btnCheckRiwayatKunjungan" wire:loading.remove>
                        {{ 'Kunjungan ' . addslashes($FormEntry['addKunjungan']['noKunjungan']) ?? '' }}
                    </x-yellow-button>
                </div>
            @endif


            @php
                $tindakLanjut = $FormEntry['perencanaan']['tindakLanjut']['tindakLanjut'] ?? '';

                switch ($tindakLanjut) {
                    case '1':
                        $tindakLanjutDesc = 'Meninggal';
                        break;
                    case '3':
                        $tindakLanjutDesc = 'Berobat Jalan';
                        break;
                    case ' 4':
                        $tindakLanjutDesc = 'Rujuk Vertikal';
                        break;
                    case '6':
                        $tindakLanjutDesc = 'Rujuk Horizontal';
                        break;
                    case 'A':
                        $tindakLanjutDesc = 'Rujuk Atas Permintaan Sendiri (APS)';
                        break;
                    default:
                        $tindakLanjutDesc = '-';
                }
            @endphp

            <div class="text-2xl font-semibold text-gray-700">
                {{ $tindakLanjutDesc ?? '' }}
            </div>
        </div>

        <x-border-form title="Kunjungan" align="start" bordercolor="border-gray-300" bgcolor="bg-white">
            <div class="grid grid-cols-4 gap-2 p-2 my-1 border border-gray-300 rounded-lg">
                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.noKunjungan" :value="__('No Kunjungan')" :required="__($errors->has('FormEntry.addKunjungan.noKunjungan'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['noKunjungan'] ?? '-' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.kdPoli" :value="__('Poli')" :required="__($errors->has('FormEntry.addKunjungan.kdPoli'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['kdPoli'] ?? '' }}{{ $this->FormEntry['poliDesc'] ?? '' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.kdDokter" :value="__('Dokter')" :required="__($errors->has('FormEntry.addKunjungan.kdDokter'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['kdDokter'] ?? '' }}/{{ $this->FormEntry['drDesc'] ?? '' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-1">
                    <x-input-label for="FormEntry.addKunjungan.tglDaftar" :value="__('Tanggal Daftar')" :required="__($errors->has('FormEntry.addKunjungan.tglDaftar'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['tglDaftar'] ?? '' }}
                    </p>

                    <x-input-label for="FormEntry.addKunjungan.tglPulang" :value="__('Tanggal Pulang')" :required="__($errors->has('FormEntry.addKunjungan.tglPulang'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['tglPulang'] ?? '' }}
                    </p>
                </div>
            </div>

            <div class="my-2 text-2xl font-bold text-gray-700">
                Pemeriksaan
            </div>

            <div class="grid grid-cols-4 gap-2 p-2 my-1 border border-gray-300 rounded-lg">

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.keluhan" :value="__('Keluhan')" :required="__($errors->has('FormEntry.addKunjungan.keluhan'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['keluhan'] ?? '' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.anamnesa" :value="__('Anamnesa')" :required="__($errors->has('FormEntry.addKunjungan.anamnesa'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['anamnesa'] ?? '' }}
                    </p>
                </div>
            </div>


            <div class="grid grid-cols-4 gap-2 p-2 my-1 border border-gray-300 rounded-lg">
                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.alergiMakanan" :value="__('Alergi Makanan')" :required="__($errors->has('FormEntry.addKunjungan.alergiMakanan'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['alergiMakanan'] ?? '' }}{{ $this->FormEntry['anamnesa']['alergi']['alergiMakananDesc'] ?? '' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.alergiUdara" :value="__('Alergi Udara')" :required="__($errors->has('FormEntry.addKunjungan.alergiUdara'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['alergiUdara'] ?? '' }}{{ $this->FormEntry['anamnesa']['alergi']['alergiUdaraDesc'] ?? '' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.alergiObat" :value="__('Alergi Obat')" :required="__($errors->has('FormEntry.addKunjungan.alergiObat'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['alergiObat'] ?? '' }}{{ $this->FormEntry['anamnesa']['alergi']['alergiObatDesc'] ?? '' }}
                    </p>
                </div>

            </div>
            <div class="grid grid-cols-2 gap-2 p-2 my-1 border border-gray-300 rounded-lg">
                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.kdPrognosa" :value="__('Prognosa')" :required="__($errors->has('FormEntry.addKunjungan.kdPrognosa'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['kdPrognosa'] ?? '' }}{{ $this->FormEntry['perencanaan']['prognosa']['prognosaDesc'] ?? '' }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-2 p-2 my-1 border border-gray-300 rounded-lg">
                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.terapiObat" :value="__('Terapi')" :required="__($errors->has('FormEntry.addKunjungan.terapiObat'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['terapiObat'] ?? '' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.terapiNonObat" :value="__('Terapi Non Obat')" :required="__($errors->has('FormEntry.addKunjungan.terapiNonObat'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['terapiNonObat'] ?? '' }}
                    </p>
                </div>
            </div>

            {{-- <div class="flex">
                <x-input-label for="FormEntry.addKunjungan.bmhp" :value="__('bmhp')" :required="__($errors->has('FormEntry.addKunjungan.bmhp'))" />
                <d class="ml-2"iv class="flex items-center mb-2">
                    <x-text-input id="FormEntry.addKunjungan.bmhp" placeholder="bmhp" class="mt-1 ml-2"
                        :errorshas="__($errors->has('FormEntry.addKunjungan.bmhp'))" :disabled=$disabledPropertyId wire:model="FormEntry.addKunjungan.bmhp" />
                </d>
                @error('FormEntry.addKunjungan.bmhp')
                    <x-input-error :messages=$message />
                @enderror
            </div> --}}

            <div class="grid grid-cols-2 gap-2 p-2 my-1 border border-gray-300 rounded-lg">
                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.kdDiag1" :value="__('Diag1')" :required="__($errors->has('FormEntry.addKunjungan.kdDiag1'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['kdDiag1'] ?? '' }}{{ $this->FormEntry['diagnosis'][0]['diagDesc'] ?? '' }}
                    </p>

                </div>
                <div>
                    <p>
                        {{ isset($this->FormEntry['addKunjungan']['nonSpesialis']) ? 'Non Spesialis' : 'Spesialis' }}
                    </p>
                </div>

                {{-- <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.kdDiag2" :value="__('Diag2')" :required="__($errors->has('FormEntry.addKunjungan.kdDiag2'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['kdDiag2'] ?? '' }}{{ $this->FormEntry['diagnosis'][1]['diagDesc'] ?? '' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.kdDiag3" :value="__('Diag3')" :required="__($errors->has('FormEntry.addKunjungan.kdDiag3'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['kdDiag3'] ?? '' }}{{ $this->FormEntry['diagnosis'][2]['diagDesc'] ?? '' }}
                    </p>
                </div> --}}
            </div>




            <div class="grid grid-cols-2 gap-2 p-2 my-1 border border-gray-300 rounded-lg">
                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.kdSadar" :value="__('Tingkat Kesadaran')" :required="__($errors->has('FormEntry.addKunjungan.kdSadar'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['kdSadar'] ?? '' }}{{ $this->FormEntry['pemeriksaan']['tandaVital']['tingkatKesadaranDesc'] ?? '' }}
                    </p>
                </div>
            </div>

            <div class="my-2 text-2xl font-bold text-gray-700">
                Tanda Vital
            </div>

            <div class="grid grid-cols-4 gap-2 p-2 my-1 border border-gray-300 rounded-lg">
                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.suhu" :value="__('Suhu')" :required="__($errors->has('FormEntry.addKunjungan.suhu'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['suhu'] ?? '' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.tinggiBadan" :value="__('Tinggi Badan')" :required="__($errors->has('FormEntry.addKunjungan.tinggiBadan'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['tinggiBadan'] ?? '' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.beratBadan" :value="__('Berat Badan')" :required="__($errors->has('FormEntry.addKunjungan.beratBadan'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['beratBadan'] ?? '' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.lingkarPerut" :value="__('Lingkar Perut')" :required="__($errors->has('FormEntry.addKunjungan.lingkarPerut'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['lingkarPerut'] ?? '' }}
                    </p>
                </div>
            </div>


            <div class="my-2 text-2xl font-bold text-gray-700">
                Tekanan Darah
            </div>

            <div class="grid grid-cols-4 gap-2 p-2 my-1 border border-gray-300 rounded-lg">
                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.sistole" :value="__('sistole')" :required="__($errors->has('FormEntry.addKunjungan.sistole'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['sistole'] ?? '' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.diastole" :value="__('diastole')" :required="__($errors->has('FormEntry.addKunjungan.diastole'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['diastole'] ?? '' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.respRate" :value="__('respRate')" :required="__($errors->has('FormEntry.addKunjungan.respRate'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['respRate'] ?? '' }}
                    </p>
                </div>

                <div class="flex">
                    <x-input-label for="FormEntry.addKunjungan.heartRate" :value="__('heartRate')" :required="__($errors->has('FormEntry.addKunjungan.heartRate'))" />
                    <p class="ml-2 font-normal text-primary">
                        {{ $FormEntry['addKunjungan']['heartRate'] ?? '' }}
                    </p>
                </div>
            </div>
        </x-border-form>


        {{-- inap jalan --}}
        @php
            $kdStatusPulang = $this->FormEntry['addKunjungan']['kdStatusPulang'] ?? '';
        @endphp
        @if ($kdStatusPulang === '4')
            <x-border-form title="Rujuk Lanjut" align="start" bordercolor="border-gray-300" bgcolor="bg-white">

                {{-- <div>
                <x-input-label for="FormEntry.addKunjungan.kdStatusPulang" :value="__('kdStatusPulang')"
                    :required="__($errors->has('FormEntry.addKunjungan.kdStatusPulang'))" />
                <div class="flex items-center mb-2">
                    <x-text-input id="FormEntry.addKunjungan.kdStatusPulang" placeholder="kdStatusPulang"
                        class="mt-1 ml-2" :errorshas="__($errors->has('FormEntry.addKunjungan.kdStatusPulang'))" :disabled=$disabledPropertyId
                        wire:model="FormEntry.addKunjungan.kdStatusPulang" />
                </div>
                @error('FormEntry.addKunjungan.kdStatusPulang')
                    <x-input-error :messages=$message />
                @enderror
            </div> --}}
                <div class="grid grid-cols-4 gap-2 p-2 my-1 border border-gray-300 rounded-lg">
                    {{-- <div>
                        <x-input-label for="FormEntry.addKunjungan.rujukLanjut.kdppk" :value="__('kdppk')"
                            :required="__($errors->has('FormEntry.addKunjungan.rujukLanjut.kdppk'))" />

                        <div class="flex ">
                            <x-text-input placeholder="Provider" class="sm:rounded-none sm:rounded-l-lg"
                                :errorshas="__($errors->has('FormEntry.addKunjungan.rujukLanjut.kdppk'))" :disabled=true
                                value="{{ $FormEntry['addKunjungan']['rujukLanjut']['kdppk'] ?? '' }}{{ ' / ' }}{{ $FormEntry['addKunjungan']['rujukLanjut']['kdppkDesc'] ?? '' }}" />

                            <x-green-button :disabled=$disabledProperty
                                class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                wire:click.prevent="clickproviderlov()">
                                <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </x-green-button>
                        </div> --}}
                    {{-- LOV provider --}}

                    {{-- @include('livewire.component.l-o-v.p-care.list-of-value-provider.list-of-value-provider')

                        @error('FormEntry.addKunjungan.rujukLanjut.kdppk')
                            <x-input-error :messages=$message />
                        @enderror

                    </div> --}}

                    <div>
                        <x-input-label for="FormEntry.addKunjungan.rujukLanjut.tglEstRujuk" :value="__('tglEstRujuk')"
                            :required="__($errors->has('FormEntry.addKunjungan.rujukLanjut.tglEstRujuk'))" />
                        <div class="flex ">
                            <x-text-input placeholder="[dd-mm-yyyy]" class="sm:rounded-none sm:rounded-l-lg"
                                :errorshas="__($errors->has('FormEntry.addKunjungan.rujukLanjut.tglEstRujuk'))" :disabled=$disabledProperty
                                wire:model="FormEntry.addKunjungan.rujukLanjut.tglEstRujuk" />

                            <x-green-button :disabled=$disabledProperty
                                class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                wire:click.prevent="clicktglEstRujuk()">
                                <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </x-green-button>
                            @error('FormEntry.addKunjungan.rujukLanjut.tglEstRujuk')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div>
                            <x-input-label for="FormEntry.addKunjungan.rujukLanjut.subSpesialis.kdSpesialis"
                                :value="__('kdSpesialis')" :required="__(
                                    $errors->has('FormEntry.addKunjungan.rujukLanjut.subSpesialis.kdSpesialis'),
                                )" />

                            <div class="flex ">
                                <x-text-input placeholder="Spesialis" class="sm:rounded-none sm:rounded-l-lg"
                                    :errorshas="__(
                                        $errors->has('FormEntry.addKunjungan.rujukLanjut.subSpesialis.kdSpesialis'),
                                    )" :disabled=true
                                    value="{{ $FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialis'] ?? '' }}{{ ' / ' }}{{ $FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSpesialisDesc'] ?? '' }}" />

                                <x-green-button :disabled=$disabledProperty
                                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                    wire:click.prevent="clickspesialislov()">
                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </x-green-button>
                            </div>
                            {{-- LOV spesialis --}}

                            @include('livewire.component.l-o-v.p-care.list-of-value-spesialis.list-of-value-spesialis')

                            @error('FormEntry.addKunjungan.rujukLanjut.subSpesialis.kdSpesialis')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="FormEntry.addKunjungan.rujukLanjut.subSpesialis.kdSubSpesialis1"
                                :value="__('kdSubSpesialis1')" :required="__(
                                    $errors->has('FormEntry.addKunjungan.rujukLanjut.subSpesialis.kdSubSpesialis1'),
                                )" />

                            <div class="flex ">
                                <x-text-input placeholder="Spesialis" class="sm:rounded-none sm:rounded-l-lg"
                                    :errorshas="__(
                                        $errors->has('FormEntry.addKunjungan.rujukLanjut.subSpesialis.kdSubSpesialis1'),
                                    )" :disabled=true
                                    value="{{ $FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1'] ?? '' }}{{ ' / ' }}{{ $FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSubSpesialis1Desc'] ?? '' }}" />

                                <x-green-button :disabled=$disabledProperty
                                    class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                    wire:click.prevent="clicksubSpesialislov()" wire:loading.remove>
                                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </x-green-button>

                                <div wire:loading wire:target="clicksubSpesialislov">
                                    <x-loading />
                                </div>
                            </div>
                            {{-- LOV spesialis --}}

                            @include('livewire.component.l-o-v.p-care.list-of-value-sub-spesialis.list-of-value-sub-spesialis')

                            @error('FormEntry.addKunjungan.rujukLanjut.subSpesialis.kdSubSpesialis1')
                                <x-input-error :messages=$message />
                            @enderror
                        </div>
                    </div>

                    <div>
                        <x-input-label for="FormEntry.addKunjungan.rujukLanjut.subSpesialis.kdSarana"
                            :value="__('kdSarana')" :required="__($errors->has('FormEntry.addKunjungan.rujukLanjut.subSpesialis.kdSarana'))" />

                        <div class="flex ">
                            <x-text-input placeholder="kdSarana" class="sm:rounded-none sm:rounded-l-lg"
                                :errorshas="__($errors->has('FormEntry.addKunjungan.rujukLanjut.subSpesialis.kdSarana'))" :disabled=true
                                value="{{ $FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSarana'] ?? '' }}{{ ' / ' }}{{ $FormEntry['addKunjungan']['rujukLanjut']['subSpesialis']['kdSaranaDesc'] ?? '' }}" />

                            <x-green-button :disabled=$disabledProperty
                                class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                wire:click.prevent="clicksaranalov()">
                                <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </x-green-button>
                        </div>
                        {{-- LOV sarana --}}

                        @include('livewire.component.l-o-v.p-care.list-of-value-sarana.list-of-value-sarana')

                        @error('FormEntry.addKunjungan.rujukLanjut.subSpesialis.kdSarana')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>



                    <div>
                        <x-input-label for="FormEntry.addKunjungan.rujukLanjut.kdppk" :value="__('kdppk')"
                            :required="__($errors->has('FormEntry.addKunjungan.rujukLanjut.kdppk'))" />

                        <div class="flex ">
                            <x-text-input placeholder="clickfaskesRujukanlov" class="sm:rounded-none sm:rounded-l-lg"
                                :errorshas="__($errors->has('FormEntry.addKunjungan.rujukLanjut.kdppk'))" :disabled=true
                                value="{{ $FormEntry['addKunjungan']['rujukLanjut']['kdppk'] ?? '' }}{{ ' / ' }}{{ $FormEntry['addKunjungan']['rujukLanjut']['nmppk'] ?? '' }}" />

                            <div wire:loading wire:target="clickfaskesRujukanlov">
                                <x-loading />
                            </div>

                            <x-green-button :disabled=$disabledProperty
                                class="sm:rounded-none sm:rounded-r-lg sm:mb-0 sm:mr-0 sm:px-2"
                                wire:click.prevent="clickfaskesRujukanlov()" wire:loading.remove>
                                <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </x-green-button>
                        </div>
                        {{-- LOV faskes-rujukan --}}

                        @include('livewire.component.l-o-v.p-care.list-of-value-faskes-rujukan.list-of-value-faskes-rujukan')

                        @error('FormEntry.addKunjungan.rujukLanjut.kdppk')
                            <x-input-error :messages=$message />
                        @enderror

                    </div>

                </div>

                {{-- tacc --}}
                @if ($this->FormEntry['addKunjungan']['nonSpesialis'] ?? false)
                    <div>
                        <x-input-label for="FormEntry.addKunjungan.kdTacc" :value="__('kdTacc')" :required="__($errors->has('FormEntry.addKunjungan.kdTacc'))" />
                        <div class="flex items-center mb-2">
                            <x-text-input id="FormEntry.addKunjungan.kdTacc" placeholder="kdTacc" class="mt-1 ml-2"
                                :errorshas="__($errors->has('FormEntry.addKunjungan.kdTacc'))" :disabled=$disabledPropertyId
                                wire:model="FormEntry.addKunjungan.kdTacc" />
                        </div>
                        @error('FormEntry.addKunjungan.kdTacc')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="FormEntry.addKunjungan.alasanTacc" :value="__('alasanTacc')" :required="__($errors->has('FormEntry.addKunjungan.alasanTacc'))" />
                        <div class="flex items-center mb-2">
                            <x-text-input id="FormEntry.addKunjungan.alasanTacc" placeholder="alasanTacc"
                                class="mt-1 ml-2" :errorshas="__($errors->has('FormEntry.addKunjungan.alasanTacc'))" :disabled=$disabledPropertyId
                                wire:model="FormEntry.addKunjungan.alasanTacc" />
                        </div>
                        @error('FormEntry.addKunjungan.alasanTacc')
                            <x-input-error :messages=$message />
                        @enderror
                    </div>

                    {{-- jika dia termasuk diagnosa NonSpesialistik atau false baru mucullkan --}}
                    <div class="grid grid-cols-1 gap-2 p-2 my-1 mt-2 ml-2 border border-gray-300 rounded-lg">
                        @foreach ($refTacc as $tacc)
                            <x-radio-button :label="__($tacc['nmTacc'] . ' / ' . $tacc['kdTacc'])" value="{{ $tacc['kdTacc'] }}"
                                wire:model="FormEntry.addKunjungan.kdTacc" />

                            <div class="grid grid-cols-4 gap-2 p-2 mx-4 my-1 border border-gray-300 rounded-lg ">
                                @php
                                    $kdTacc = $FormEntry['addKunjungan']['kdTacc'] ?? '';
                                @endphp
                                @if ($kdTacc === $tacc['kdTacc'])
                                    @foreach ($tacc['alasanTacc'] as $key => $alasanTacc)
                                        <x-radio-button :label="__($alasanTacc)" value="{{ $alasanTacc }}"
                                            wire:model="FormEntry.addKunjungan.alasanTacc" />
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

            </x-border-form>
        @endif










        {{-- inap --}}
        {{-- <div>
            <x-input-label for="FormEntry.addKunjungan.tglPulang" :value="__('tglPulang')" :required="__($errors->has('FormEntry.addKunjungan.tglPulang'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntry.addKunjungan.tglPulang" placeholder="tglPulang" class="mt-1 ml-2"
                    :errorshas="__($errors->has('FormEntry.addKunjungan.tglPulang'))" :disabled=$disabledPropertyId
                    wire:model="FormEntry.addKunjungan.tglPulang" />
            </div>
            @error('FormEntry.addKunjungan.tglPulang')
                <x-input-error :messages=$message />
            @enderror
        </div> --}}



        {{-- <div>
            <x-input-label for="FormEntry.addKunjungan.kdPoliRujukInternal" :value="__('kdPoliRujukInternal')"
                :required="__($errors->has('FormEntry.addKunjungan.kdPoliRujukInternal'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntry.addKunjungan.kdPoliRujukInternal" placeholder="kdPoliRujukInternal"
                    class="mt-1 ml-2" :errorshas="__($errors->has('FormEntry.addKunjungan.kdPoliRujukInternal'))" :disabled=$disabledPropertyId
                    wire:model="FormEntry.addKunjungan.kdPoliRujukInternal" />
            </div>
            @error('FormEntry.addKunjungan.kdPoliRujukInternal')
                <x-input-error :messages=$message />
            @enderror
        </div> --}}







        {{-- <div>
            <x-input-label for="FormEntry.addKunjungan.rujukLanjut.khusus.kdKhusus" :value="__('kdKhusus')"
                :required="__($errors->has('FormEntry.addKunjungan.rujukLanjut.khusus.kdKhusus'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntry.addKunjungan.rujukLanjut.khusus.kdKhusus" placeholder="kdKhusus"
                    class="mt-1 ml-2" :errorshas="__($errors->has('FormEntry.addKunjungan.rujukLanjut.khusus.kdKhusus'))" :disabled=$disabledPropertyId
                    wire:model="FormEntry.addKunjungan.rujukLanjut.khusus.kdKhusus" />
            </div>
            @error('FormEntry.addKunjungan.rujukLanjut.khusus.kdKhusus')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="FormEntry.addKunjungan.rujukLanjut.khusus.kdSubSpesialis1" :value="__('kdSubSpesialis1')"
                :required="__($errors->has('FormEntry.addKunjungan.rujukLanjut.khusus.kdSubSpesialis1'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntry.addKunjungan.rujukLanjut.khusus.kdSubSpesialis1"
                    placeholder="kdSubSpesialis1" class="mt-1 ml-2" :errorshas="__($errors->has('FormEntry.addKunjungan.rujukLanjut.khusus.kdSubSpesialis1'))" :disabled=$disabledPropertyId
                    wire:model="FormEntry.addKunjungan.rujukLanjut.khusus.kdSubSpesialis1" />
            </div>
            @error('FormEntry.addKunjungan.rujukLanjut.khusus.kdSubSpesialis1')
                <x-input-error :messages=$message />
            @enderror
        </div>

        <div>
            <x-input-label for="FormEntry.addKunjungan.rujukLanjut.khusus.catatan" :value="__('catatan')"
                :required="__($errors->has('FormEntry.addKunjungan.rujukLanjut.khusus.catatan'))" />
            <div class="flex items-center mb-2">
                <x-text-input id="FormEntry.addKunjungan.rujukLanjut.khusus.catatan" placeholder="catatan"
                    class="mt-1 ml-2" :errorshas="__($errors->has('FormEntry.addKunjungan.rujukLanjut.khusus.catatan'))" :disabled=$disabledPropertyId
                    wire:model="FormEntry.addKunjungan.rujukLanjut.khusus.catatan" />
            </div>
            @error('FormEntry.addKunjungan.rujukLanjut.khusus.catatan')
                <x-input-error :messages=$message />
            @enderror
        </div> --}}

    </div>





</div>
