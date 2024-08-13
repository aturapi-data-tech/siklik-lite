<div>
    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp
    {{-- jika anamnesa kosong ngak usah di render --}}
    @if (isset($dataDaftarUgd['anamnesa']))
        <div class="w-full mb-1">

            <div id="TransaksiRawatJalan" class="px-2">
                <div id="TransaksiRawatJalan" x-data="{ activeTab: 'Pengkajian Perawatan' }">

                    <div class="px-2 mb-2 border-b border-gray-200 dark:border-gray-700">
                        <ul
                            class="flex flex-wrap -mb-px text-xs font-medium text-center text-gray-500 dark:text-gray-400">

                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarUgd['anamnesa']['pengkajianPerawatanTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarUgd['anamnesa']['pengkajianPerawatanTab'] }}'">{{ $dataDaftarUgd['anamnesa']['pengkajianPerawatanTab'] }}</label>
                            </li>


                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarUgd['anamnesa']['keluhanUtamaTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarUgd['anamnesa']['keluhanUtamaTab'] }}'">{{ $dataDaftarUgd['anamnesa']['keluhanUtamaTab'] }}</label>
                            </li>

                            {{-- <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarUgd['anamnesa']['anamnesaDiperolehTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarUgd['anamnesa']['anamnesaDiperolehTab'] }}'">{{ $dataDaftarUgd['anamnesa']['anamnesaDiperolehTab'] }}</label>
                            </li> --}}

                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab ===
                                        '{{ $dataDaftarUgd['anamnesa']['riwayatPenyakitSekarangUmumTab'] }}'
                                        ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarUgd['anamnesa']['riwayatPenyakitSekarangUmumTab'] }}'">{{ $dataDaftarUgd['anamnesa']['riwayatPenyakitSekarangUmumTab'] }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarUgd['anamnesa']['riwayatPenyakitDahuluTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarUgd['anamnesa']['riwayatPenyakitDahuluTab'] }}'">{{ $dataDaftarUgd['anamnesa']['riwayatPenyakitDahuluTab'] }}</label>
                            </li>

                            {{-- <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarUgd['anamnesa']['penyakitKeluargaTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarUgd['anamnesa']['penyakitKeluargaTab'] }}'">{{ $dataDaftarUgd['anamnesa']['penyakitKeluargaTab'] }}</label>
                            </li> --}}

                            {{-- <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarUgd['anamnesa']['statusFungsionalTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarUgd['anamnesa']['statusFungsionalTab'] }}'">{{ $dataDaftarUgd['anamnesa']['statusFungsionalTab'] }}</label>
                            </li> --}}

                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarUgd['anamnesa']['statusPsikologisTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarUgd['anamnesa']['statusPsikologisTab'] }}'">{{ $dataDaftarUgd['anamnesa']['statusPsikologisTab'] }}</label>
                            </li>


                            {{-- <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarUgd['anamnesa']['edukasiTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarUgd['anamnesa']['edukasiTab'] }}'">{{ $dataDaftarUgd['anamnesa']['edukasiTab'] }}</label>
                            </li> --}}

                            {{-- <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarUgd['anamnesa']['screeningGiziTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarUgd['anamnesa']['screeningGiziTab'] }}'">{{ $dataDaftarUgd['anamnesa']['screeningGiziTab'] }}</label>
                            </li> --}}

                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarUgd['anamnesa']['batukTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarUgd['anamnesa']['batukTab'] }}'">{{ $dataDaftarUgd['anamnesa']['batukTab'] }}</label>
                            </li>




                        </ul>
                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarUgd['anamnesa']['pengkajianPerawatanTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarUgd['anamnesa']['pengkajianPerawatanTab'] }}'">
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.pengkajianPerawatanTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarUgd['anamnesa']['keluhanUtamaTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarUgd['anamnesa']['keluhanUtamaTab'] }}'">
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.keluhanUtamaTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarUgd['anamnesa']['anamnesaDiperolehTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarUgd['anamnesa']['anamnesaDiperolehTab'] }}'">
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.anamnesaDiperolehTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab ===
                                '{{ $dataDaftarUgd['anamnesa']['riwayatPenyakitSekarangUmumTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarUgd['anamnesa']['riwayatPenyakitSekarangUmumTab'] }}'">
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.riwayatPenyakitSekarangUmumTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarUgd['anamnesa']['riwayatPenyakitDahuluTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarUgd['anamnesa']['riwayatPenyakitDahuluTab'] }}'">
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.riwayatPenyakitDahuluTab')

                    </div>


                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarUgd['anamnesa']['penyakitKeluargaTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarUgd['anamnesa']['penyakitKeluargaTab'] }}'">
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.penyakitKeluargaTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarUgd['anamnesa']['statusFungsionalTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarUgd['anamnesa']['statusFungsionalTab'] }}'">
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.statusFungsionalTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarUgd['anamnesa']['statusPsikologisTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarUgd['anamnesa']['statusPsikologisTab'] }}'">
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.statusPsikologisTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarUgd['anamnesa']['edukasiTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarUgd['anamnesa']['edukasiTab'] }}'">
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.edukasiTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarUgd['anamnesa']['screeningGiziTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarUgd['anamnesa']['screeningGiziTab'] }}'">
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.screeningGiziTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarUgd['anamnesa']['batukTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarUgd['anamnesa']['batukTab'] }}'">
                        @include('livewire.emr-u-g-d.mr-u-g-d.anamnesa.batukTab')

                    </div>


                </div>
            </div>



            <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6">

                <div class="">
                    {{-- null --}}
                </div>
                <div>
                    <div wire:loading wire:target="store">
                        <x-loading />
                    </div>

                    <x-green-button :disabled=false wire:click.prevent="store()" type="button" wire:loading.remove>
                        Simpan
                    </x-green-button>
                </div>
            </div>


        </div>
    @endif

</div>
