<div class="fixed inset-0 z-40">
    @php
        $disabledPropertyRjStatus = false;
        $disabledPropertyRjStatusResep = isset($dataDaftarPoliRJ['telaahResep']['penanggungJawab']) ? true : false;
        $disabledPropertyRjStatusObat = isset($dataDaftarPoliRJ['telaahObat']['penanggungJawab']) ? true : false;

    @endphp
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
                        {{ 'Terapi' }}
                    </h3>

                    {{-- rjDate & Shift Input Rj --}}
                    <div id="shiftTanggal" class="flex justify-end w-full mr-4">


                        {{-- Close Modal --}}
                        <button wire:click="closeModalTelaahResep()"
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
                    {{-- :rjNo="" disi dari emit ListeneropenModalEditRj --}}

                    <livewire:emr-r-j.display-pasien.display-pasien :wire:key="$rjNoRef.'display-pasienEresep'"
                        :rjNoRef="$rjNoRef">

                        {{-- <livewire:emr-r-j.form-entry-r-j.form-entry-r-j :rjNo="$regNo"
                            :wire:key="$regNo.'form-entry-r-j'"> --}}
                </div>

                {{-- Grid Eresep --}}
                <div class="grid grid-cols-3 gap-4">

                    <div class="col-span-2">
                        {{-- Transasi EMR --}}
                        <div id="TransaksiEMR" x-data="{ activeTabRacikanNonRacikan: @entangle('activeTabRacikanNonRacikan') }" class="grid grid-cols-1">

                            <div class="px-2 mb-0 overflow-auto border-b border-gray-200">
                                <ul
                                    class="flex flex-row flex-wrap justify-center -mb-px text-sm font-medium text-gray-500 text-start ">
                                    @foreach ($EmrMenuRacikanNonRacikan as $EmrM)
                                        <li wire:key="tab-{{ $EmrM['ermMenuId'] }}" class="mx-1 mr-0 rounded-t-lg"
                                            :class="'{{ $activeTabRacikanNonRacikan }}'
                                            === '{{ $EmrM['ermMenuId'] }}' ?
                                                'text-primary border-primary bg-gray-100' :
                                                'border border-gray-200'">
                                            <label
                                                class="inline-block p-2 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                                x-on:click="activeTabRacikanNonRacikan ='{{ $EmrM['ermMenuId'] }}'"
                                                wire:click="$set('activeTabRacikanNonRacikan', '{{ $EmrM['ermMenuId'] }}')">{{ $EmrM['ermMenuName'] }}

                                                @if ($EmrM['ermMenuId'] === 'NonRacikan')
                                                    @if ($eresep)
                                                        <span
                                                            class="inline-flex items-center justify-center w-4 h-4 text-xs font-semibold text-red-800 bg-red-200 rounded-full ms-2">
                                                            {{ $eresep }}
                                                        </span>
                                                    @endif
                                                @else
                                                    @if ($eresepRacikan)
                                                        <span
                                                            class="inline-flex items-center justify-center w-4 h-4 text-xs font-semibold text-red-800 bg-red-200 rounded-full ms-2">
                                                            {{ $eresepRacikan }}
                                                        </span>
                                                    @endif
                                                @endif
                                            </label>
                                        </li>
                                    @endforeach


                                </ul>
                            </div>



                            <div class="w-full mx-2 mr-2 rounded-lg bg-gray-50"
                                :class="{
                                    'active': activeTabRacikanNonRacikan === 'NonRacikan'
                                }"
                                x-show.transition.in.opacity.duration.600="activeTabRacikanNonRacikan === 'NonRacikan'">
                                <livewire:emr-r-j.eresep-r-j.eresep-r-j :wire:key="'eresep-r-j'" :rjNoRef="$rjNoRef">

                            </div>

                            <div class="w-full mx-2 mr-2 rounded-lg bg-gray-50"
                                :class="{
                                    'active': activeTabRacikanNonRacikan === 'Racikan'
                                }"
                                x-show.transition.in.opacity.duration.600="activeTabRacikanNonRacikan === 'Racikan'">
                                <livewire:emr-r-j.eresep-r-j.eresep-r-j-racikan :wire:key="'eresep-r-j-racikan'"
                                    :rjNoRef="$rjNoRef">

                            </div>


                        </div>

                        {{-- Telaah Resep / Telaah Obat --}}
                        @role(['Apoteker', 'Admin'])
                            <div class="grid w-full grid-cols-2 gap-8 px-8 mx-2 my-2 mr-2 rounded-lg bg-gray-50">
                                @include('livewire.emr-r-j.telaah-resep-r-j.radio-telaahresep-rj')
                                @include('livewire.emr-r-j.telaah-resep-r-j.radio-telaahobat-rj')
                            </div>
                        @endrole

                    </div>

                    {{-- Resume --}}
                    <div class="col-span-1">
                        <livewire:emr.rekam-medis.rekam-medis-display :wire:key="'content-rekamMedisDisplay'"
                            :rjNoRefCopyTo="$rjNoRef" :regNoRef="$regNoRef">
                    </div>

                </div>







            </div>
        </div>
    </div>

</div>
