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
                        <button wire:click="closeModalAdministrasi()"
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

                    <livewire:emr-r-j.display-pasien.display-pasien :wire:key="$regNoRef.'display-pasien'"
                        :rjNoRef="$rjNoRef">

                        {{-- <livewire:emr-r-j.form-entry-r-j.form-entry-r-j :rjNo="$regNo"
                            :wire:key="$regNo.'form-entry-r-j'"> --}}
                </div>


                {{-- Transasi EMR --}}
                <div class="flex justify-between m-4 m-x-auto">

                    <div class="grid grid-cols-5 gap-2 mx-2">

                        <div class="relative">
                            <input type="text" id="RsAdmin" disabled
                                class=" block rounded-t-lg px-2.5 pb-1 pt-5 w-full text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{ number_format($sumRsAdmin) }}" />
                            <label for="RsAdmin"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                RS Admin
                            </label>
                        </div>

                        <div class="relative">
                            <input type="text" id="RjAdmin" disabled
                                class=" block rounded-t-lg px-2.5 pb-1 pt-5 w-full text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{ number_format($sumRjAdmin) }}" />
                            <label for="RjAdmin"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                Admin OB
                            </label>
                        </div>

                        <div class="relative">
                            <input type="text" id="PoliPrice" disabled
                                class=" block rounded-t-lg px-2.5 pb-1 pt-5 w-full text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{ number_format($sumPoliPrice) }}" />
                            <label for="PoliPrice"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                Uang Periksa
                            </label>
                        </div>

                        <div class="relative">
                            <input type="text" id="JasaKaryawan" disabled
                                class=" block rounded-t-lg px-2.5 pb-1 pt-5 w-full text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{ number_format($sumJasaKaryawan) }}" />
                            <label for="JasaKaryawan"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                Jasa Karyawan
                            </label>
                        </div>

                        <div class="relative">
                            <input type="text" id="sumJasaDokter" disabled
                                class=" block rounded-t-lg px-2.5 pb-1 pt-5 w-full text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{ number_format($sumJasaDokter) }}" />
                            <label for="sumJasaDokter"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                Jasa Dokter
                            </label>
                        </div>

                        <div class="relative">
                            <input type="text" id="sumJasaMedis" disabled
                                class=" block rounded-t-lg px-2.5 pb-1 pt-5 w-full text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{ number_format($sumJasaMedis) }}" />
                            <label for="sumJasaMedis"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                Jasa Medis
                            </label>
                        </div>

                        <div class="relative">
                            <input type="text" id="sumObat" disabled
                                class=" block rounded-t-lg px-2.5 pb-1 pt-5 w-full text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{ number_format($sumObat) }}" />
                            <label for="sumObat"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                Obat
                            </label>
                        </div>

                        <div class="relative">
                            <input type="text" id="sumLaboratorium" disabled
                                class=" block rounded-t-lg px-2.5 pb-1 pt-5 w-full text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{ number_format($sumLaboratorium) }}" />
                            <label for="sumLaboratorium"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                Laboratorium
                            </label>
                        </div>

                        <div class="relative">
                            <input type="text" id="sumRadiologi" disabled
                                class=" block rounded-t-lg px-2.5 pb-1 pt-5 w-full text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{ number_format($sumRadiologi) }}" />
                            <label for="sumRadiologi"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                Radiologi
                            </label>
                        </div>

                        <div class="relative">
                            <input type="text" id="sumLainLain" disabled
                                class=" block rounded-t-lg px-2.5 pb-1 pt-5 w-full text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{ number_format($sumLainLain) }}" />
                            <label for="sumLainLain"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                Lain-Lain
                            </label>
                        </div>


                    </div>

                    <div>
                        <div class="relative">
                            <input type="text" id="sumTotalRJ" disabled
                                class=" block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-3xl font-semibold text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{ number_format($sumTotalRJ) }}" />
                            <label for="sumTotalRJ"
                                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                TOTAL
                            </label>
                        </div>
                    </div>
                </div>

                <div>

                    {{-- jika anamnesa kosong ngak usah di render --}}
                    <div class="w-full mb-1">

                        <div id="TransaksiRawatJalan" class="px-2">
                            <div id="TransaksiRawatJalan" x-data="{ activeTabAdministrasi: @entangle('activeTabAdministrasi') }">

                                <div class="px-2 mb-2 border-b border-gray-200 dark:border-gray-700">
                                    <ul
                                        class="flex flex-wrap -mb-px text-xs font-medium text-center text-gray-500 dark:text-gray-400">

                                        @foreach ($EmrMenuAdministrasi as $EmrMenu)
                                            <li class="mr-2">
                                                <label
                                                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                                    x-bind:class="activeTabAdministrasi === '{{ $EmrMenu['ermMenuId'] }}'
                                                        ?
                                                        'text-primary border-primary bg-gray-100' : ''"
                                                    x-on:click="activeTabAdministrasi ='{{ $EmrMenu['ermMenuId'] }}'">{{ $EmrMenu['ermMenuName'] }}</label>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>

                                <div class="p-2 rounded-lg bg-gray-50"
                                    :class="{
                                        'active': activeTabAdministrasi === 'JasaKaryawan'
                                    }"
                                    x-show.transition.in.opacity.duration.600="activeTabAdministrasi === 'JasaKaryawan'">
                                    <livewire:emr-r-j.administrasi-r-j.jasa-karyawan-r-j
                                        :wire:key="'content-jasa-karyawan-r-j'" :rjNoRef="$rjNoRef">

                                </div>

                                <div class="p-2 rounded-lg bg-gray-50"
                                    :class="{
                                        'active': activeTabAdministrasi === 'JasaDokter'
                                    }"
                                    x-show.transition.in.opacity.duration.600="activeTabAdministrasi === 'JasaDokter'">
                                    <livewire:emr-r-j.administrasi-r-j.jasa-dokter-r-j
                                        :wire:key="'content-jasa-dokter-r-j2'" :rjNoRef="$rjNoRef">

                                </div>

                                <div class="p-2 rounded-lg bg-gray-50"
                                    :class="{
                                        'active': activeTabAdministrasi === 'JasaMedis'
                                    }"
                                    x-show.transition.in.opacity.duration.600="activeTabAdministrasi === 'JasaMedis'">
                                    <livewire:emr-r-j.administrasi-r-j.jasa-medis-r-j
                                        :wire:key="'content-jasa-medis-r-j'" :rjNoRef="$rjNoRef">

                                </div>

                                <div class="p-2 rounded-lg bg-gray-50"
                                    :class="{
                                        'active': activeTabAdministrasi === 'Obat'
                                    }"
                                    x-show.transition.in.opacity.duration.600="activeTabAdministrasi === 'Obat'">
                                    <livewire:emr-r-j.administrasi-r-j.obat-r-j :wire:key="'content-obat-r-j'"
                                        :rjNoRef="$rjNoRef">

                                </div>

                                <div class="p-2 rounded-lg bg-gray-50"
                                    :class="{
                                        'active': activeTabAdministrasi === 'Laboratorium'
                                    }"
                                    x-show.transition.in.opacity.duration.600="activeTabAdministrasi === 'Laboratorium'">
                                    <livewire:emr-r-j.administrasi-r-j.laboratorium-r-j
                                        :wire:key="'content-laboratorium-r-j'" :rjNoRef="$rjNoRef">

                                </div>

                                <div class="p-2 rounded-lg bg-gray-50"
                                    :class="{
                                        'active': activeTabAdministrasi === 'Radiologi'
                                    }"
                                    x-show.transition.in.opacity.duration.600="activeTabAdministrasi === 'Radiologi'">
                                    <livewire:emr-r-j.administrasi-r-j.radiologi-r-j :wire:key="'content-radiologi-r-j'"
                                        :rjNoRef="$rjNoRef">

                                </div>

                                <div class="p-2 rounded-lg bg-gray-50"
                                    :class="{
                                        'active': activeTabAdministrasi === 'LainLain'
                                    }"
                                    x-show.transition.in.opacity.duration.600="activeTabAdministrasi === 'LainLain'">
                                    <livewire:emr-r-j.administrasi-r-j.lain-lain-r-j
                                        :wire:key="'content-lain-lain-r-j2'" :rjNoRef="$rjNoRef">

                                </div>


                            </div>
                        </div>









                    </div>

                </div>


            </div>



        </div>




    </div>

</div>
