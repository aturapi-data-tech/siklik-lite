@php
    $disabledProperty = false;
    $disabledPropertyId = $isOpenMode == 'insert' ? false : true;
@endphp

<div>


    {{-- FormMasterPoli --}}
    <div id="FormMasterPoli" class="grid grid-cols-6 gap-4 px-4 py-8">


        <div class="">
            <div wire:loading wire:target="updateDataKesadaran">
                <x-loading />
            </div>

            <x-green-button :disabled=$disabledProperty wire:click.prevent="updateDataKesadaran()" type="button"
                wire:loading.remove>
                Update Data Kesadaran
            </x-green-button>
        </div>

        <div class="">
            <div wire:loading wire:target="updateDataDokter">
                <x-loading />
            </div>

            <x-green-button :disabled=$disabledProperty wire:click.prevent="updateDataDokter()" type="button"
                wire:loading.remove>
                Update Data Dokter
            </x-green-button>
        </div>

        <div class="">
            <div wire:loading wire:target="updateDataSpesialis">
                <x-loading />
            </div>

            <x-green-button :disabled=$disabledProperty wire:click.prevent="updateDataSpesialis()" type="button"
                wire:loading.remove>
                Update Data Spesialis
            </x-green-button>
        </div>

        <div class="">
            <div wire:loading wire:target="updateDataAlergi">
                <x-loading />
            </div>

            <x-green-button :disabled=$disabledProperty wire:click.prevent="updateDataAlergi()" type="button"
                wire:loading.remove>
                Update Data Alergi
            </x-green-button>
        </div>

        <div class="">
            <div wire:loading wire:target="updateDataPrognosa">
                <x-loading />
            </div>

            <x-green-button :disabled=$disabledProperty wire:click.prevent="updateDataPrognosa()" type="button"
                wire:loading.remove>
                Update Data Prognosa
            </x-green-button>
        </div>


        <div class="">
            <div wire:loading wire:target="updateDataPoliFktp">
                <x-loading />
            </div>

            <x-green-button :disabled=$disabledProperty wire:click.prevent="updateDataPoliFktp()" type="button"
                wire:loading.remove>
                Update Data PoliFktp
            </x-green-button>
        </div>

        <div class="">
            <div wire:loading wire:target="updateDataStatusPulang">
                <x-loading />
            </div>

            <x-green-button :disabled=$disabledProperty wire:click.prevent="updateDataStatusPulang()" type="button"
                wire:loading.remove>
                Update Data StatusPulang
            </x-green-button>
        </div>


        <div class="">
            <div wire:loading wire:target="updateDataProvider">
                <x-loading />
            </div>

            <x-green-button :disabled=$disabledProperty wire:click.prevent="updateDataProvider()" type="button"
                wire:loading.remove>
                Update Data Provider
            </x-green-button>
        </div>

        <div class="">
            <div wire:loading wire:target="updateDataSarana">
                <x-loading />
            </div>

            <x-green-button :disabled=$disabledProperty wire:click.prevent="updateDataSarana()" type="button"
                wire:loading.remove>
                Update Data Sarana
            </x-green-button>
        </div>






    </div>

    {{-- down bar --}}
    <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6">
        <div class="">

            <x-light-button wire:click="closeModal()" type="button">Keluar</x-light-button>



        </div>


    </div>


</div>
