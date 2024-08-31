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
                        {{ 'Pemeriksaan Radiologi' }}
                    </h3>

                    {{-- rjDate & Shift Input Rj --}}
                    <div id="shiftTanggal" class="flex justify-end w-full mr-4">


                        {{-- Close Modal --}}
                        <button wire:click="closeModalRadiologi()"
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

                    <livewire:emr-r-j.display-pasien.display-pasien :wire:key="$rjNoRef.'display-pasien'"
                        :rjNoRef="$rjNoRef">

                        {{-- <livewire:emr-r-j.form-entry-r-j.form-entry-r-j :rjNo="$regNo"
                            :wire:key="$regNo.'form-entry-r-j'"> --}}
                </div>


                {{-- Transasi EMR --}}
                {{-- headier --}}
                <div class="grid w-full gap-1 mx-10 rounded-lg grid-cols-10 min-h-[75px]">
                    @foreach ($isPemeriksaanRadiologiSelected as $key => $isPemeriksaanRad)
                        <div
                            class="inline-flex items-center justify-between w-auto p-1 my-2 text-gray-900 bg-green-100 border-2 rounded-lg cursor-pointer border-grey-200 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 ">
                            <div class="block">
                                <div class="w-auto text-sm">
                                    {{ $isPemeriksaanRad['rad_desc'] }}</div>
                            </div>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-red-500 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center "
                                wire:click.prefent="RemovePemeriksaanRadiologiIsSelectedFor({{ $key }})">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Hapus</span>
                            </button>
                        </div>
                    @endforeach
                </div>
                {{-- content --}}
                <div class="flex flex-wrap mx-10">

                    @foreach ($isPemeriksaanRadiologi as $key => $isPemeriksaanRad)
                        @php
                            $bgCardPropertyColor = $isPemeriksaanRad['radStatus'] == 1 ? 'bg-green-100' : 'bg-white';
                        @endphp
                        <div class="w-full pt-2 pr-2 md:basis-1/5 ">
                            <a wire:click.prefent="PemeriksaanRadiologiIsSelectedFor({{ $key }})"
                                class="block p-6 {{ $bgCardPropertyColor }} border border-gray-200 rounded-lg shadow hover:bg-gray-50 ">

                                <div class="flex flex-col items-center pb-1">
                                    <p class="text-lg font-semibold text-gray-900 ">
                                        {{ $isPemeriksaanRad['rad_desc'] }}
                                    </p>
                                    <span class="text-sm text-gray-500 ">
                                        {{ number_format($isPemeriksaanRad['rad_price']) }}
                                    </span>
                                </div>

                            </a>

                            {{-- <a
                                wire:click.prefent="voteFor({{ $key }},
                            {{ 1 }},
                        '{{ 2 }}')">x{{ $key }}
                            </a> --}}

                        </div>
                    @endforeach
                </div>

                <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6">

                    <div class="">
                        {{-- null --}}
                    </div>
                    <div>
                        <div wire:loading wire:target="kirimRadiologi">
                            <x-loading />
                        </div>

                        <x-green-button :disabled=false wire:click.prevent="kirimRadiologi()" type="button"
                            wire:loading.remove>
                            Kirim Radiologi
                        </x-green-button>
                    </div>
                </div>


            </div>



        </div>




    </div>

</div>
