<div>
    <div class="w-full mb-1">


        <div class="pt-0">

            <x-input-label for="dataDaftarUgd.pemeriksaan.penunjang" :value="__('Penunjang')" :required="__(false)"
                class="pt-2 sm:text-xl" />

            <div class="mb-2">
                <x-input-label for="dataDaftarUgd.pemeriksaan.penunjang" :value="__('Pemeriksaan Penunjang Lab / Foto / EKG / Lan-lain')" :required="__(false)" />

                <x-text-input-area id="dataDaftarUgd.pemeriksaan.penunjang" placeholder="Penunjang" class="mt-1 ml-2"
                    :errorshas="__($errors->has('dataDaftarUgd.pemeriksaan.penunjang'))" :disabled=$disabledPropertyRjStatus
                    wire:model.debounce.500ms="dataDaftarUgd.pemeriksaan.penunjang" :rows="__('3')" />
            </div>

            {{-- tab Penunjang --}}

            {{-- Lab --}}
            <div>
                <!-- Table -->
                <div class="grid grid-cols-1 ml-2">
                    <div wire:loading wire:target="pemeriksaanLaboratorium">
                        <x-loading />
                    </div>

                    <x-yellow-button :disabled=$disabledPropertyRjStatus wire:click.prevent="pemeriksaanLaboratorium()"
                        type="button" wire:loading.remove>
                        Pemeriksaan Laboratorium
                    </x-yellow-button>
                </div>

                @if ($isOpenLaboratorium)
                    @include('livewire.emr-u-g-d.mr-u-g-d.pemeriksaan.create-penunjang-laboratorium')
                @endif


                <table class="w-full text-sm text-left text-gray-500 table-auto ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 ">
                        <tr>
                            <th scope="col" class="px-4 py-3">


                                <x-sort-link :active=false wire:click.prevent="" role="button" href="#">
                                    No Lab
                                </x-sort-link>

                            </th>

                            <th scope="col" class="px-4 py-3 ">
                                <x-sort-link :active=false wire:click.prevent="" role="button" href="#">
                                    Tgl Lab
                                </x-sort-link>
                            </th>

                            <th scope="col" class="px-4 py-3">

                                <x-sort-link :active=false wire:click.prevent="" role="button" href="#">
                                    Pemeriksaan Lab
                                </x-sort-link>
                            </th>

                            <th scope="col" class="w-8 px-4 py-3 text-center">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white ">
                        @isset($dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['lab'])
                            @foreach ($dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['lab'] as $key => $pemeriksaanPenunjangLab)
                                <tr class="border-b group ">

                                    <td
                                        class="w-1/4 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                        {{ $pemeriksaanPenunjangLab['labHdr']['labHdrNo'] }}
                                    </td>

                                    <td
                                        class="w-1/4 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                        {{ $pemeriksaanPenunjangLab['labHdr']['labHdrDate'] }}
                                    </td>

                                    <td
                                        class="w-1/4 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                        {{ implode(',', array_column($pemeriksaanPenunjangLab['labHdr']['labDtl'], 'clabitem_desc')) }}
                                    </td>

                                    <td
                                        class="w-1/4 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                        -
                                    </td>




                                </tr>
                            @endforeach
                        @endisset


                    </tbody>
                </table>
            </div>

            {{-- Rad --}}
            <div>
                <!-- Table -->
                <div class="grid grid-cols-1 ml-2">
                    <div wire:loading wire:target="pemeriksaanRadiologi">
                        <x-loading />
                    </div>

                    <x-yellow-button :disabled=$disabledPropertyRjStatus wire:click.prevent="pemeriksaanRadiologi()"
                        type="button" wire:loading.remove>
                        Pemeriksaan Radiologi
                    </x-yellow-button>
                </div>

                @if ($isOpenRadiologi)
                    @include('livewire.emr-u-g-d.mr-u-g-d.pemeriksaan.create-penunjang-radiologi')
                @endif


                <table class="w-full text-sm text-left text-gray-500 table-auto ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 ">
                        <tr>
                            <th scope="col" class="px-4 py-3">


                                <x-sort-link :active=false wire:click.prevent="" role="button" href="#">
                                    No Rad
                                </x-sort-link>

                            </th>

                            <th scope="col" class="px-4 py-3 ">
                                <x-sort-link :active=false wire:click.prevent="" role="button" href="#">
                                    Tgl Rad
                                </x-sort-link>
                            </th>

                            <th scope="col" class="px-4 py-3">

                                <x-sort-link :active=false wire:click.prevent="" role="button" href="#">
                                    Pemeriksaan Rad
                                </x-sort-link>
                            </th>

                            <th scope="col" class="w-8 px-4 py-3 text-center">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white ">
                        @isset($dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['rad'])
                            @foreach ($dataDaftarUgd['pemeriksaan']['pemeriksaanPenunjang']['rad'] as $key => $pemeriksaanPenunjangRad)
                                <tr class="border-b group ">

                                    <td
                                        class="w-1/4 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                        {{ isset($pemeriksaanPenunjangRad['radHdr']['radHdrNo']) ? $pemeriksaanPenunjangRad['radHdr']['radHdrNo'] : '-' }}
                                    </td>

                                    <td
                                        class="w-1/4 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                        {{ isset($pemeriksaanPenunjangRad['radHdr']['radHdrDate']) ? $pemeriksaanPenunjangRad['radHdr']['radHdrDate'] : '-' }}
                                    </td>

                                    <td
                                        class="w-1/4 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                        {{ isset($pemeriksaanPenunjangRad['radHdr']['radDtl']) ? implode(',', array_column($pemeriksaanPenunjangRad['radHdr']['radDtl'], 'rad_desc')) : '-' }}
                                    </td>

                                    <td
                                        class="w-1/4 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                        -
                                    </td>




                                </tr>
                            @endforeach
                        @endisset


                    </tbody>
                </table>
            </div>

            {{-- Lain --}}
            @include('livewire.emr-u-g-d.mr-u-g-d.pemeriksaan.uploadpenunjangHasil')





































            {{-- <div id="TransaksiRawatJalan" x-data="{ activeTab: 'EEG' }" class="flex">
                <div class="w-[200px] h-80 overflow-auto">

                    <div class="flex px-2 mb-2 border-b border-gray-200 dark:border-gray-700 ">

                        <ul class="inline -mb-px text-xs font-medium text-center text-gray-500 ">
                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === 'EEG' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='EEG'">{{ 'EEG' }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === 'EMG' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='EMG'">{{ 'EMG' }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === 'ravenTest' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='ravenTest'">{{ 'Raven Test' }}</label>
                            </li>

                            <li class="mr-2">
                                <label
                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                    :class="activeTab === 'Ekg' ?
                                        'text-primary border-primary bg-gray-100' : ''"
                                    @click="activeTab ='Ekg'">{{ 'Ekg' }}</label>
                            </li>



                        </ul>

                    </div>

                </div>


                <div class="w-full">

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab === 'EEG'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === 'EEG'">

                        @include('livewire.mr-r-j.pemeriksaan.penunjang.eeg')


                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab === 'EMG'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === 'EMG'">

                        @include('livewire.mr-r-j.pemeriksaan.penunjang.emg')


                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                        :class="{
                            'active': activeTab === 'ravenTest'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === 'ravenTest'">

                        @include('livewire.mr-r-j.pemeriksaan.penunjang.ravenTest')


                    </div>



                </div>
            </div> --}}



        </div>




    </div>


</div>
