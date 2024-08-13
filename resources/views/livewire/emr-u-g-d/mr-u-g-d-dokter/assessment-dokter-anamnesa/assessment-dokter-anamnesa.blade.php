<div>
    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp
    {{-- jika anamnesa kosong ngak usah di render --}}
    @if (isset($dataDaftarUgd['anamnesa']))
        <div class="w-full mb-1">

            <div id="TransaksiRawatJalan" class="p-2">
                <div id="TransaksiRawatJalan">

                    <div class="p-2 rounded-lg bg-gray-50">
                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.pengkajianPerawatanTab') --}}
                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.keluhanUtamaTab') --}}

                        <div>

                            <x-input-label :value="__('Keluhan Utama')" :required="__(true)" class="pt-2 sm:text-xl" />

                            <p class="w-full ml-2 text-sm">
                                {!! nl2br(
                                    e(
                                        isset($dataDaftarUgd['anamnesa']['keluhanUtama']['keluhanUtama'])
                                            ? ($dataDaftarUgd['anamnesa']['keluhanUtama']['keluhanUtama']
                                                ? $dataDaftarUgd['anamnesa']['keluhanUtama']['keluhanUtama']
                                                : '-')
                                            : '-',
                                    ),
                                ) !!}
                            </p>

                            <br>

                            <div class="grid grid-cols-2 gap-1 ">
                                <div>
                                    <x-input-label :value="__('Waktu Datang')" :required="__(false)" class="" />

                                    <p class="w-full ml-2 text-sm">
                                        {!! nl2br(
                                            e(
                                                isset($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang'])
                                                    ? ($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang']
                                                        ? $dataDaftarUgd['anamnesa']['pengkajianPerawatan']['jamDatang']
                                                        : '-')
                                                    : '-',
                                            ),
                                        ) !!}
                                    </p>
                                </div>

                                <div>
                                    <x-input-label :value="__('Cara Masuk IGD')" :required="__(false)" class="" />

                                    <p class="w-full ml-2 text-sm">
                                        {!! nl2br(
                                            e(
                                                isset($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['caraMasukIgd'])
                                                    ? ($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['caraMasukIgd']
                                                        ? $dataDaftarUgd['anamnesa']['pengkajianPerawatan']['caraMasukIgd']
                                                        : '-')
                                                    : '-',
                                            ),
                                        ) !!}
                                    </p>
                                </div>

                                <div>
                                    <x-input-label :value="__('Status Psikologis')" :required="__(false)" class="" />

                                    <div class="flex">
                                        <p class="w-full ml-2 text-sm">
                                            {!! nl2br(
                                                e(
                                                    isset($dataDaftarUgd['anamnesa']['statusPsikologis']['tidakAdaKelainan'])
                                                        ? ($dataDaftarUgd['anamnesa']['statusPsikologis']['tidakAdaKelainan']
                                                            ? 'Tidak Ada Kelainan'
                                                            : '-')
                                                        : '-',
                                                ),
                                            ) !!}
                                        </p>

                                        <p class="w-full ml-2 text-sm">
                                            {!! nl2br(
                                                e(
                                                    isset($dataDaftarUgd['anamnesa']['statusPsikologis']['marah'])
                                                        ? ($dataDaftarUgd['anamnesa']['statusPsikologis']['marah']
                                                            ? 'Marah'
                                                            : '-')
                                                        : '-',
                                                ),
                                            ) !!}
                                        </p>

                                        <p class="w-full ml-2 text-sm">
                                            {!! nl2br(
                                                e(
                                                    isset($dataDaftarUgd['anamnesa']['statusPsikologis']['ccemas'])
                                                        ? ($dataDaftarUgd['anamnesa']['statusPsikologis']['ccemas']
                                                            ? 'Cemas'
                                                            : '-')
                                                        : '-',
                                                ),
                                            ) !!}
                                        </p>

                                        <p class="w-full ml-2 text-sm">
                                            {!! nl2br(
                                                e(
                                                    isset($dataDaftarUgd['anamnesa']['statusPsikologis']['takut'])
                                                        ? ($dataDaftarUgd['anamnesa']['statusPsikologis']['takut']
                                                            ? 'Takut'
                                                            : '-')
                                                        : '-',
                                                ),
                                            ) !!}
                                        </p>

                                        <p class="w-full ml-2 text-sm">
                                            {!! nl2br(
                                                e(
                                                    isset($dataDaftarUgd['anamnesa']['statusPsikologis']['sedih'])
                                                        ? ($dataDaftarUgd['anamnesa']['statusPsikologis']['sedih']
                                                            ? 'Sedih'
                                                            : '-')
                                                        : '-',
                                                ),
                                            ) !!}
                                        </p>

                                        <p class="w-full ml-2 text-sm">
                                            {!! nl2br(
                                                e(
                                                    isset($dataDaftarUgd['anamnesa']['statusPsikologis']['cenderungBunuhDiri'])
                                                        ? ($dataDaftarUgd['anamnesa']['statusPsikologis']['cenderungBunuhDiri']
                                                            ? 'Cenderung Bunuh Diri'
                                                            : '-')
                                                        : '-',
                                                ),
                                            ) !!}
                                        </p>

                                        <p class="w-full ml-2 text-sm">
                                            {!! nl2br(
                                                e(
                                                    isset($dataDaftarUgd['anamnesa']['statusPsikologis']['sebutstatusPsikologis'])
                                                        ? ($dataDaftarUgd['anamnesa']['statusPsikologis']['sebutstatusPsikologis']
                                                            ? $dataDaftarUgd['anamnesa']['statusPsikologis']['sebutstatusPsikologis']
                                                            : '-')
                                                        : '-',
                                                ),
                                            ) !!}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <x-input-label :value="__('Status Mental')" :required="__(false)" class="" />

                                    <p class="w-full ml-2 text-sm">
                                        {!! nl2br(
                                            e(
                                                isset($dataDaftarUgd['anamnesa']['statusMental']['statusMental'])
                                                    ? ($dataDaftarUgd['anamnesa']['statusMental']['statusMental']
                                                        ? $dataDaftarUgd['anamnesa']['statusMental']['statusMental']
                                                        : '-')
                                                    : '-',
                                            ),
                                        ) !!}
                                    </p>
                                </div>

                                <div>
                                    <x-input-label :value="__('Tingkat Kegawatan')" :required="__(false)" class="" />

                                    <p class="w-full ml-2 text-sm">
                                        {!! nl2br(
                                            e(
                                                isset($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['tingkatKegawatan'])
                                                    ? ($dataDaftarUgd['anamnesa']['pengkajianPerawatan']['tingkatKegawatan']
                                                        ? $dataDaftarUgd['anamnesa']['pengkajianPerawatan']['tingkatKegawatan']
                                                        : '-')
                                                    : '-',
                                            ),
                                        ) !!}
                                    </p>
                                </div>

                            </div>






                        </div>
                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.anamnesaDiperolehTab') --}}
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.riwayatPenyakitSekarangUmumTab')
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.riwayatPenyakitDahuluTab')
                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.penyakitKeluargaTab') --}}
                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.statusFungsionalTab') --}}
                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.statusPsikologisTab') --}}
                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.edukasiTab')
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.screeningGiziTab') --}}
                        {{-- @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.batukTab') --}}
                    </div>



                </div>
            </div>



            {{-- <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6">

                <div class="">
                </div>
                <div>
                    <div wire:loading wire:target="store">
                        <x-loading />
                    </div>

                    <x-green-button :disabled=false wire:click.prevent="store()" type="button" wire:loading.remove>
                        Simpan Subjective
                    </x-green-button>
                </div>
            </div> --}}


        </div>
    @endif

</div>
