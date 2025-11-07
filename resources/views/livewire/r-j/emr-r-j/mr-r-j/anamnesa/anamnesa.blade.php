<div>
    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp
    {{-- jika anamnesa kosong ngak usah di render --}}
    @if (isset($dataDaftarPoliRJ['anamnesa']))
        <div class="w-full mb-1">

            <div id="TransaksiRawatJalan" class="px-2">
                <div id="TransaksiRawatJalan" x-data="{ activeTab: 'Pengkajian Perawatan' }">

                    <div class="px-2 mb-2 border-b border-gray-200 dark:border-gray-700">
                        <ul
                            class="flex flex-wrap -mb-px text-xs font-medium text-center text-gray-500 dark:text-gray-400">

                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['pengkajianPerawatanTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['anamnesa']['pengkajianPerawatanTab'] }}'">{{ $dataDaftarPoliRJ['anamnesa']['pengkajianPerawatanTab'] }}</label>
                            </li>


                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['keluhanUtamaTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['anamnesa']['keluhanUtamaTab'] }}'">{{ $dataDaftarPoliRJ['anamnesa']['keluhanUtamaTab'] }}</label>
                            </li>

                            {{-- <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['anamnesaDiperolehTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['anamnesa']['anamnesaDiperolehTab'] }}'">{{ $dataDaftarPoliRJ['anamnesa']['anamnesaDiperolehTab'] }}</label>
                            </li> --}}

                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab ===
                                        '{{ $dataDaftarPoliRJ['anamnesa']['riwayatPenyakitSekarangUmumTab'] }}'
                                        ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['anamnesa']['riwayatPenyakitSekarangUmumTab'] }}'">{{ $dataDaftarPoliRJ['anamnesa']['riwayatPenyakitSekarangUmumTab'] }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['riwayatPenyakitDahuluTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['anamnesa']['riwayatPenyakitDahuluTab'] }}'">{{ $dataDaftarPoliRJ['anamnesa']['riwayatPenyakitDahuluTab'] }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['penyakitKeluargaTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['anamnesa']['penyakitKeluargaTab'] }}'">{{ $dataDaftarPoliRJ['anamnesa']['penyakitKeluargaTab'] }}</label>
                            </li>

                            {{-- <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['statusFungsionalTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['anamnesa']['statusFungsionalTab'] }}'">{{ $dataDaftarPoliRJ['anamnesa']['statusFungsionalTab'] }}</label>
                            </li> --}}

                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['statusPsikologisTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['anamnesa']['statusPsikologisTab'] }}'">{{ $dataDaftarPoliRJ['anamnesa']['statusPsikologisTab'] }}</label>
                            </li>


                            {{-- <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['edukasiTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['anamnesa']['edukasiTab'] }}'">{{ $dataDaftarPoliRJ['anamnesa']['edukasiTab'] }}</label>
                            </li> --}}

                            {{-- <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['screeningGiziTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['anamnesa']['screeningGiziTab'] }}'">{{ $dataDaftarPoliRJ['anamnesa']['screeningGiziTab'] }}</label>
                            </li> --}}

                            <li class="mr-2">
                                <label
                                    class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['batukTab'] }}' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='{{ $dataDaftarPoliRJ['anamnesa']['batukTab'] }}'">{{ $dataDaftarPoliRJ['anamnesa']['batukTab'] }}</label>
                            </li>




                        </ul>
                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['pengkajianPerawatanTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['pengkajianPerawatanTab'] }}'">
                        @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.pengkajianPerawatanTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['keluhanUtamaTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['keluhanUtamaTab'] }}'">
                        @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.keluhanUtamaTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['anamnesaDiperolehTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['anamnesaDiperolehTab'] }}'">
                        @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.anamnesaDiperolehTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab ===
                                '{{ $dataDaftarPoliRJ['anamnesa']['riwayatPenyakitSekarangUmumTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['riwayatPenyakitSekarangUmumTab'] }}'">
                        @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.riwayatPenyakitSekarangUmumTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['riwayatPenyakitDahuluTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['riwayatPenyakitDahuluTab'] }}'">
                        @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.riwayatPenyakitDahuluTab')

                    </div>


                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['penyakitKeluargaTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['penyakitKeluargaTab'] }}'">
                        @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.penyakitKeluargaTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['statusFungsionalTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['statusFungsionalTab'] }}'">
                        @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.statusFungsionalTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['statusPsikologisTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['statusPsikologisTab'] }}'">
                        @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.statusPsikologisTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['edukasiTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['edukasiTab'] }}'">
                        @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.edukasiTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['screeningGiziTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['screeningGiziTab'] }}'">
                        @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.screeningGiziTab')

                    </div>

                    <div class="p-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['batukTab'] }}'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['anamnesa']['batukTab'] }}'">
                        @include('livewire.r-j.emr-r-j.mr-r-j.anamnesa.batukTab')

                    </div>


                </div>
            </div>






        </div>
    @endif

</div>
