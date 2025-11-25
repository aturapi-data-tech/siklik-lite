<div>

    <div class="w-full mb-1 ">

        <div class="w-full p-4 text-sm ">
            <h2 class="text-2xl font-bold text-center">FORMULIR PERSETUJUAN UMUM RAWAT JALAN (RJ)</h2>
            </br>

            <div class="w-full p-2 m-2 mx-auto bg-white rounded-lg shadow-md">
                <h2 class="mt-6 text-lg font-semibold">Pernyataan Persetujuan</h2>

                <p class="mb-4 text-sm text-gray-700 tracking-tracking-wide">
                    Dengan ini, saya memberikan persetujuan untuk menerima pelayanan kesehatan
                    di Pelayanan Rawat Jalan (RJ) sesuai dengan kondisi saya.
                    </br>
                    Saya telah menerima penjelasan yang jelas mengenai
                    <span class="font-semibold">hak dan kewajiban saya sebagai pasien</span>
                    sebagaimana diatur dalam peraturan perundang-undangan yang berlaku.
                </p>

                <p class="mb-2 text-xs text-gray-500">
                    Dasar hukum:
                    1) Undang-Undang Nomor 17 Tahun 2023 tentang Hak dan Kewajiban Pasien,
                    2) Permenkes Nomor 4 Tahun 2018 tentang Kewajiban Klinik dan Kewajiban Pasien.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-2">
                {{-- HAK PASIEN --}}
                <div class="w-full p-2 m-2 mx-auto bg-white rounded-lg shadow-md">
                    <h3 class="mt-4 text-lg font-semibold">HAK SEBAGAI PASIEN</h3>

                    <ol class="mb-4 text-gray-700 list-decimal list-inside">

                        <li class="mb-2 text-sm tracking-tracking-wide">
                            Mendapatkan informasi mengenai kesehatan dirinya.
                        </li>

                        <li class="mb-2 text-sm tracking-tracking-wide">
                            Mendapatkan kejelasan yang memadai mengenai pelayanan kesehatan yang diterimanya.
                        </li>

                        <li class="mb-2 text-sm tracking-tracking-wide">
                            Mendapatkan pelayanan kesehatan sesuai dengan kebutuhan medis,
                            standar profesi, dan pelayanan yang bermutu.
                        </li>

                        <li class="mb-2 text-sm tracking-tracking-wide">
                            Menolak atau menyetujui tindakan medis, kecuali untuk tindakan medis
                            yang diperlukan dalam rangka pencegahan penyakit menular dan
                            penanggulangan KLB atau wabah.
                        </li>

                        <li class="mb-2 text-sm tracking-tracking-wide">
                            Mendapatkan akses terhadap informasi yang terdapat dalam rekam medis.
                        </li>

                        <li class="mb-2 text-sm tracking-tracking-wide">
                            Menerima pendapat tenaga medis atau tenaga kesehatan lainnya (second opinion).
                        </li>

                        <li class="mb-2 text-sm tracking-tracking-wide">
                            Mendapatkan hak-hak lain sesuai dengan ketentuan peraturan perundang-undangan.
                        </li>

                    </ol>
                </div>

                {{-- KEWAJIBAN PASIEN --}}
                <div class="w-full p-2 m-2 mx-auto bg-white rounded-lg shadow-md">
                    <h3 class="mt-4 text-lg font-semibold">KEWAJIBAN SEBAGAI PASIEN</h3>

                    <ol class="mb-4 text-gray-700 list-decimal list-inside">

                        <li class="mb-2 text-sm tracking-tracking-wide">
                            Memberikan informasi yang lengkap dan jujur tentang masalah kesehatannya.
                        </li>

                        <li class="mb-2 text-sm tracking-tracking-wide">
                            Mematuhi nasihat dan petunjuk tenaga medis dan tenaga kesehatan.
                        </li>

                        <li class="mb-2 text-sm tracking-tracking-wide">
                            Mematuhi ketentuan dan tata tertib yang berlaku pada fasilitas pelayanan kesehatan.
                        </li>

                        <li class="mb-2 text-sm tracking-tracking-wide">
                            Memberikan imbalan jasa atas pelayanan yang diterima sesuai dengan ketentuan yang berlaku.
                        </li>

                    </ol>
                </div>

            </div>
            <x-theme-line></x-theme-line>

            <div class="w-full p-2 m-2 mx-auto bg-white rounded-lg shadow-md">

                <h3 class="mt-4 text-lg font-semibold">PEMAHAMAN</h3>

                <p class="mb-4 text-gray-700">Saya telah menerima penjelasan singkat mengenai hak dan kewajiban saya
                    sebagai pasien RJ, serta risiko tindakan medis yang mungkin diperlukan.
                </p>


                <h3 class="mt-4 text-lg font-semibold">PERSETUJUAN</h3>

                <p class="mb-4 text-gray-700">Saya menyetujui pemeriksaan, pengobatan, atau tindakan medis yang dianggap
                    perlu oleh tim medis RJ dalam situasi darurat atau untuk menyelamatkan nyawa saya.
                </p>


                <h3 class="mt-4 text-lg font-semibold">PELEPASAN INFORMASI</h3>

                <p class="mb-4 text-gray-700">Saya memberikan izin kepada rumah sakit untuk berbagi informasi medis saya
                    kepada pihak-pihak terkait, seperti keluarga, dokter rujukan, atau penyedia asuransi, untuk
                    kepentingan penanganan medis.</p>


                <h3 class="mt-4 text-lg font-semibold">BARANG BENDA</h3>

                <p class="mb-4 text-gray-700">Saya memahami bahwa rumah sakit tidak bertanggung jawab atas kehilangan
                    atau kerusakan barang berharga yang saya bawa ke RJ.</p>


                <h3 class="mt-4 text-lg font-semibold">BIAYA</h3>

                <p class="mb-4 text-gray-700">Saya memahami bahwa saya bertanggung jawab atas biaya yang timbul selama
                    perawatan di RJ, sesuai dengan ketentuan yang berlaku.</p>

            </div>

        </div>

        <div class="grid content-center grid-cols-2 gap-2 p-2 m-2">
            @if (
                !$this->dataDaftarRJ['generalConsentPasienRJ']['signature'] ||
                    !$this->dataDaftarRJ['generalConsentPasienRJ']['wali']
            )
                <div class="flex items-end justify-center w-full p-2 m-2 mx-auto bg-white rounded-lg shadow-md">
                    <div>
                        <div class="flex ml-2">
                            @foreach ($agreementOptions as $agreement)
                                <x-radio-button :label="__($agreement['agreementDesc'])" value="{{ $agreement['agreementId'] }}"
                                    wire:model="dataDaftarRJ.generalConsentPasienRJ.agreement" />
                            @endforeach
                        </div>

                        <div class="relative flex flex-col gap-4 p-6 bg-white rounded-lg shadow-xl">
                            <x-signature-pad wire:model.defer="signature">

                            </x-signature-pad>
                            @error('dataDaftarRJ.generalConsentPasienRJ.signature')
                                <x-input-error :messages=$message />
                            @enderror

                            <div>
                                <x-text-input id="dataDaftarRJ.generalConsentPasienRJ.wali" placeholder="Nama Wali"
                                    class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarRJ.generalConsentPasienRJ.wali'))"
                                    wire:model.lazy="dataDaftarRJ.generalConsentPasienRJ.wali" />
                            </div>

                            <x-primary-button wire:click="submit" class="text-white">
                                Submit
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex items-end justify-center w-full p-2 m-2 mx-auto bg-white rounded-lg shadow-md ">

                    <div class="w-56 h-auto">
                        <div class="text-sm text-right ">
                            {{ env('SATUSEHAT_ORGANIZATION_NAMEX', 'RUMAH SAKIT ISLAM MADINAH') }}
                        </div>
                        <div class="text-sm text-right ">
                            {{ ' Ngunut , ' . $this->dataDaftarRJ['generalConsentPasienRJ']['signatureDate'] }}
                        </div>
                        <div class="flex items-center justify-center">
                            <object type="image/svg+xml"
                                data="data:image/svg+xml;utf8,{{ $this->dataDaftarRJ['generalConsentPasienRJ']['signature'] ?? $signature }}">
                                <img src="fallback.png" alt="Fallback image for browsers that don't support SVG">
                            </object>
                        </div>

                        <div class="mb-4 text-sm text-center">
                            {{ $this->dataDaftarRJ['generalConsentPasienRJ']['wali'] }}

                        </div>
                    </div>
                </div>
            @endisset


            @if (
                !$dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksa'] ||
                    !$dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksaCode']
            )
                <div class="flex items-end justify-center w-full p-2 m-2 mx-auto bg-white rounded-lg shadow-md">
                    <div class="w-full mb-5">
                        <x-input-label for="dataDaftarRJ.generalConsentPasienRJ.petugasPemeriksa" :value="__('Petugas Pemeriksa')"
                            :required="__(true)" />
                        <div class="grid grid-cols-1 gap-2 ">
                            <x-text-input id="dataDaftarRJ.generalConsentPasienRJ.petugasPemeriksa"
                                placeholder="Petugas Pemeriksa" class="mt-1 mb-2" :errorshas="__($errors->has('dataDaftarRJ.generalConsentPasienRJ.petugasPemeriksa'))" :disabled=true
                                wire:model.debounce.500ms="dataDaftarRJ.generalConsentPasienRJ.petugasPemeriksa" />

                            <x-yellow-button :disabled=false wire:click.prevent="setPetugasPemeriksa()"
                                type="button" wire:loading.remove>
                                ttd Petugas Pemeriksa
                            </x-yellow-button>

                        </div>
                    </div>
                </div>
            @else
                <div class="flex items-end justify-center w-full p-2 m-2 mx-auto bg-white rounded-lg shadow-md">

                    <div class="w-56 h-auto">
                        <div class="text-sm text-center">
                            Petugas
                        </div>
                        @isset($dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksa'])
                            @if ($dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksa'])
                                @isset($dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksaCode'])
                                    @if ($dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksaCode'])
                                        @isset(App\Models\User::where('myuser_code', $dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksaCode'])->first()->myuser_ttd_image)
                                            <div class="flex items-center justify-center">
                                                <img class="h-24"
                                                    src="{{ asset('storage/' . App\Models\User::where('myuser_code', $dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksaCode'])->first()->myuser_ttd_image) }}"
                                                    alt="">
                                            </div>
                                        @endisset
                                    @endif
                                @endisset
                            @endif
                        @endisset

                        <div class="mb-4 text-sm text-center">
                            {{ $this->dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksa'] }}
                            </br>
                            {{ $this->dataDaftarRJ['generalConsentPasienRJ']['petugasPemeriksaDate'] }}

                        </div>
                    </div>
                </div>
            @endif

    </div>


    <div class="grid w-full grid-cols-1 px-4 pb-4">
        <x-primary-button wire:click="cetakGeneralConsentPasienRJ()" wire:loading.attr="disabled"
            class="relative flex items-center justify-center gap-2 text-white">
            {{-- Saat loading tampil ikon spinner --}}
            <div wire:loading wire:target="cetakGeneralConsentPasienRJ">
                <x-loading />
            </div>

            {{-- Saat tidak loading tampil teks --}}
            <span wire:loading.remove wire:target="cetakGeneralConsentPasienRJ">
                Cetak Persetujuan Umum RJ
            </span>
        </x-primary-button>
    </div>


</div>
