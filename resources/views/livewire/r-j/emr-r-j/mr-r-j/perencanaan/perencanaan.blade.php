<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp
    {{-- jika anamnesa kosong ngak usah di render --}}
    @if (isset($dataDaftarPoliRJ['perencanaan']))
        <div class="w-full mb-1">

            {{-- <form class="scroll-smooth hover:scroll-auto"> --}}
            <div class="grid grid-cols-1" x-data="{ activeTab: 'Petugas Medis' }">

                <div id="TransaksiRawatJalan" class="px-2">
                    <div id="TransaksiRawatJalan">

                        <div class="px-2 mb-2 border-b border-gray-200 dark:border-gray-700">
                            <ul
                                class="flex flex-wrap -mb-px text-xs font-medium text-center text-gray-500 dark:text-gray-400">

                                <li class="mr-2">
                                    <label
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        :class="activeTab === '{{ $dataDaftarPoliRJ['perencanaan']['pengkajianMedisTab'] }}' ?
                                            'text-primary border-primary bg-gray-100' : ''"
                                        @click="activeTab ='{{ $dataDaftarPoliRJ['perencanaan']['pengkajianMedisTab'] }}'">{{ $dataDaftarPoliRJ['perencanaan']['pengkajianMedisTab'] }}</label>
                                </li>

                                <li class="mr-2">
                                    <label
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        :class="activeTab === '{{ $dataDaftarPoliRJ['perencanaan']['tindakLanjutTab'] }}' ?
                                            'text-primary border-primary bg-gray-100' : ''"
                                        @click="activeTab ='{{ $dataDaftarPoliRJ['perencanaan']['tindakLanjutTab'] }}'">{{ $dataDaftarPoliRJ['perencanaan']['tindakLanjutTab'] }}</label>
                                </li>

                                <li class="mr-2">
                                    <label
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        :class="activeTab === '{{ $dataDaftarPoliRJ['perencanaan']['terapiTab'] }}' ?
                                            'text-primary border-primary bg-gray-100' : ''"
                                        @click="activeTab ='{{ $dataDaftarPoliRJ['perencanaan']['terapiTab'] }}'">{{ $dataDaftarPoliRJ['perencanaan']['terapiTab'] }}</label>
                                </li>

                                <li class="mr-2">
                                    <label
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        :class="activeTab === '{{ 'Kontrol' }}' ?
                                            'text-primary border-primary bg-gray-100' : ''"
                                        @click="activeTab ='{{ 'Kontrol' }}'">{{ 'Kontrol' }}</label>
                                </li>




                            </ul>
                        </div>

                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                            :class="{
                                'active': activeTab === '{{ $dataDaftarPoliRJ['perencanaan']['terapiTab'] }}'
                            }"
                            x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['perencanaan']['terapiTab'] }}'">
                            @include('livewire.emr-r-j.mr-r-j.perencanaan.terapiTab')

                        </div>

                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                            :class="{
                                'active': activeTab === '{{ $dataDaftarPoliRJ['perencanaan']['tindakLanjutTab'] }}'
                            }"
                            x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['perencanaan']['tindakLanjutTab'] }}'">
                            @include('livewire.emr-r-j.mr-r-j.perencanaan.tindakLanjutTab')

                        </div>

                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                            :class="{
                                'active': activeTab === '{{ $dataDaftarPoliRJ['perencanaan']['pengkajianMedisTab'] }}'
                            }"
                            x-show.transition.in.opacity.duration.600="activeTab === '{{ $dataDaftarPoliRJ['perencanaan']['pengkajianMedisTab'] }}'">
                            @include('livewire.emr-r-j.mr-r-j.perencanaan.pengkajianMedisTab')

                        </div>

                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                            :class="{
                                'active': activeTab === '{{ 'Kontrol' }}'
                            }"
                            x-show.transition.in.opacity.duration.600="activeTab === '{{ 'Kontrol' }}'">


                            <div id="TransaksiRawatJalanskdp" class="px-4">

                                <livewire:emr-r-j.mr-r-j.skdp-r-j.skdp-r-j :wire:key="'content-skdpRj'"
                                    :rjNoRef="$rjNoRef">

                            </div>


                        </div>





                    </div>
                </div>



                <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6"
                    x-show.transition.in.opacity.duration.600="activeTab !== '{{ 'Kontrol' }}'">

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

        </div>
    @endif

</div>
