<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp
    {{-- jika anamnesa kosong ngak usah di render --}}
    {{-- @if (isset($dataDaftarPoliRJ['diagnosis'])) --}}
    <div class="w-full mb-1 ">

        <div class="grid grid-cols-2">

            <div id="TransaksiRawatJalan" class="px-4">
                <x-input-label for="" :value="__('Subjective')" :required="__(false)" class="pt-2 sm:text-xl" />

                {{-- Subjective / Subjektif --}}
                <div class="w-full mx-2 mr-2 bg-green-100 rounded-lg ">
                    <livewire:emr-u-g-d.mr-u-g-d-dokter.assessment-dokter-anamnesa.assessment-dokter-anamnesa
                        :wire:key="'content-assessment-dokter-anamnesaUgd'" :rjNoRef="$rjNoRef">
                </div>

            </div>

            <div id="TransaksiRawatJalan" class="px-4">
                <x-input-label for="" :value="__('Objective')" :required="__(false)" class="pt-2 sm:text-xl" />

                {{-- Objective / Objektif  --}}
                <div class="w-full mx-2 mr-2 bg-green-200 rounded-lg ">

                    <livewire:emr-u-g-d.mr-u-g-d-dokter.assessment-dokter-pemeriksaan.assessment-dokter-pemeriksaan
                        :wire:key="'content-assessment-dokter-pemeriksaanUgd'" :rjNoRef="$rjNoRef">
                </div>

            </div>



        </div>

        <div class="grid grid-cols-3">

            <div id="TransaksiRawatJalan" class="px-4">
                <x-input-label for="" :value="__('Assesment')" :required="__(false)" class="pt-2 sm:text-xl" />

                {{-- Assesment / Penilaian / Diagnosis --}}
                <div class="w-full mx-2 mr-2 bg-green-300 rounded-lg ">

                    <livewire:emr-u-g-d.mr-u-g-d-dokter.assessment-dokter-diagnosis.assessment-dokter-diagnosis
                        :wire:key="'content-assessment-dokter-diagnosisUgd'" :rjNoRef="$rjNoRef">
                </div>

            </div>

            <div id="TransaksiRawatJalan" class="px-4">
                <x-input-label for="" :value="__('Plan')" :required="__(false)" class="pt-2 sm:text-xl" />

                {{-- Plan /Perencanaan --}}
                <div class="w-full mx-2 mr-2 bg-green-400 rounded-lg ">

                    <livewire:emr-u-g-d.mr-u-g-d-dokter.assessment-dokter-perencanaan.assessment-dokter-perencanaan
                        :wire:key="'content-assessment-dokter-perencanaanUgd'" :rjNoRef="$rjNoRef">
                </div>

            </div>

            <div id="TransaksiRawatJalan" class="px-4">
                <x-input-label for="" :value="__('Resume Medis')" :required="__(false)" class="pt-2 sm:text-xl" />

                {{-- Plan /Perencanaan --}}
                <div class="w-full mx-2 mr-2 bg-gray-400 rounded-lg ">

                    <livewire:emr.rekam-medis.rekam-medis-display :wire:key="'content-rekamMedisDisplay'"
                        :rjNoRefCopyTo="$rjNoRef" :regNoRef="$regNoRef">
                </div>

            </div>

        </div>


        <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-opacity-75 bg-gray-50 sm:px-6">

            <div class="">
            </div>
            <div>
                <div wire:loading wire:target="storeAssessmentDokterUGD">
                    <x-loading />
                </div>

                <x-green-button :disabled=false wire:click.prevent="storeAssessmentDokterUGD()" type="button"
                    wire:loading.remove>
                    Simpan
                </x-green-button>
            </div>
        </div>

    </div>
    {{-- @endif --}}



</div>
