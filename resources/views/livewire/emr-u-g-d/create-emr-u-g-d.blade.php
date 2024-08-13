<div class="fixed inset-0 z-40">

    <div class="">

        <!-- This element is to trick the browser into transition-opacity. -->
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into transition-opacity. Body-->
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute overflow-auto bg-white rounded-t-lg inset-4">

                {{-- Topbar --}}
                <div
                    class="sticky top-0 flex items-center justify-between p-4 bg-opacity-75 border-b rounded-t-lg bg-primary">

                    <!-- myTitle-->
                    <h3 class="w-full text-2xl font-semibold text-white ">
                        {{ $myTitle }}
                    </h3>

                    {{-- rjDate & Shift Input Rj --}}
                    <div id="shiftTanggal" class="flex justify-end w-full mr-4">


                        {{-- Close Modal --}}
                        <button wire:click="closeModal()"
                            class="text-gray-400 bg-gray-50 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Pasien --}}





                </div>

                {{-- Display Pasien Componen --}}
                <div class="">
                    {{-- Display Pasien --}}
                    {{-- :rjNo="" disi dari emit ListeneropenModalEditUgd --}}

                    <livewire:emr-u-g-d.display-pasien.display-pasien :wire:key="$regNo.'display-pasien'"
                        :rjNoRef="$rjNoRef">

                        {{-- <livewire:emr-u-g-d.form-entry-u-g-d.form-entry-u-g-d :rjNo="$regNo"
                            :wire:key="$regNo.'form-entry-u-g-d'"> --}}
                </div>


                {{-- Transasi EMR --}}
                <div id="TransaksiEMR" x-data="{ activeTab: @entangle('activeTab') }" class="flex">

                    <div class="px-4 mb-0 border-b border-gray-200  w-[250px] overflow-auto ">
                        <ul class="flex flex-col flex-wrap -mb-px text-sm font-medium text-gray-500 text-start ">
                            @foreach ($EmrMenu as $EmrM)
                                <li wire:key="tab-{{ $EmrM['ermMenuId'] }}" class="mr-0 rounded-lg"
                                    :class="'{{ $activeTab }}'
                                    === '{{ $EmrM['ermMenuId'] }}' ?
                                        'text-primary border-primary bg-gray-100' :
                                        ''">
                                    <label
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        @click="activeTab ='{{ $EmrM['ermMenuId'] }}'"
                                        wire:click="$set('activeTab', '{{ $EmrM['ermMenuId'] }}')">{{ $EmrM['ermMenuName'] }}</label>
                                </li>
                            @endforeach


                        </ul>
                    </div>



                    <div class="w-full mx-2 mr-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === 'anamnesa'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === 'anamnesa'">

                        <livewire:emr-u-g-d.mr-u-g-d.anamnesa.anamnesa :wire:key="'content-anamnesaUgd'"
                            :rjNoRef="$rjNoRef">
                    </div>


                    <div class="w-full mx-2 mr-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === 'pemeriksaan'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === 'pemeriksaan'">


                        <livewire:emr-u-g-d.mr-u-g-d.pemeriksaan.pemeriksaan :wire:key="'content-pemeriksaanUgd'"
                            :rjNoRef="$rjNoRef">
                    </div>


                    <div class="w-full mx-2 mr-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === 'penilaian'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === 'penilaian'">

                        <livewire:emr-u-g-d.mr-u-g-d.penilaian.penilaian :wire:key="'content-penilaianUgd'"
                            :rjNoRef="$rjNoRef">
                    </div>

                    <div class="w-full mx-2 mr-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === 'diagnosis'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === 'diagnosis'">



                        <livewire:emr-u-g-d.mr-u-g-d.diagnosis.diagnosis :wire:key="'content-diagnosisUgd'"
                            :rjNoRef="$rjNoRef">
                    </div>


                    <div class="w-full mx-2 mr-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === 'perencanaan'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === 'perencanaan'">

                        <livewire:emr-u-g-d.mr-u-g-d.perencanaan.perencanaan :wire:key="'content-perencanaanUgd'"
                            :rjNoRef="$rjNoRef">
                    </div>

                    <div class="w-full mx-2 mr-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === 'rekamMedis'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === 'rekamMedis'">


                        <livewire:emr.rekam-medis.rekam-medis :wire:key="'content-layananUgd'" :regNoRef="$regNoRef">
                    </div>


                    <div class="w-full mx-2 mr-2 rounded-lg bg-gray-50"
                        :class="{
                            'active': activeTab === 'administrasi'
                        }"
                        x-show.transition.in.opacity.duration.600="activeTab === 'administrasi'">

                        <livewire:emr-r-j.administrasi-r-j.administrasi-r-j :wire:key="'content-administrasiUgd'"
                            :rjNoRef="$rjNoRef">

                    </div>


                </div>

            </div>



        </div>




    </div>

</div>
