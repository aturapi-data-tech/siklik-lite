<div>

    @php
        $disabledProperty = true;
        $disabledPropertyRjStatus = false;
    @endphp
    {{-- jika anamnesa kosong ngak usah di render --}}
    @if (isset($dataDaftarUgd['perencanaan']))
        <div class="w-full mb-1">

            {{-- <form class="scroll-smooth hover:scroll-auto"> --}}
            <div class="grid grid-cols-1" x-data="{ activeTab: 'Petugas Medis' }">
                <div id="TransaksiRawatJalan" class="p-2">
                    <div id="TransaksiRawatJalan">

                        <div class="p-2 rounded-lg bg-gray-50">
                            @include('livewire.emr-u-g-d.mr-u-g-d.perencanaan.terapiTab')
                            @include('livewire.emr-u-g-d.mr-u-g-d.perencanaan.tindakLanjutTab')
                            @include('livewire.emr-u-g-d.mr-u-g-d.perencanaan.pengkajianMedisTab')
                        </div>
                    </div>
                </div>


                {{-- <div class="sticky bottom-0 flex justify-between px-4 py-3 bg-gray-50 sm:px-6">

                    <div class="">
                    </div>
                    <div>
                        <div wire:loading wire:target="store">
                            <x-loading />
                        </div>

                        <x-green-button :disabled=false wire:click.prevent="store()" type="button" wire:loading.remove>
                            Simpan Plan
                        </x-green-button>
                    </div>
                </div> --}}


            </div>

        </div>
    @endif

</div>
