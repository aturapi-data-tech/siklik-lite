<form wire:submit.prevent="uploadHasilPenunjang">
    <div class="my-2">

        @role(['Perawat', 'Admin'])
            <x-input-label for="uploadHasilPenunjang" :value="__('Upload Penunjang')" />

            <div class="grid grid-cols-3 gap-2">
                <x-text-input id="uploadHasilPenunjang" class="block w-full mt-1" :errorshas="__($errors->has('filePDF'))"
                    :disabled=$disabledPropertyRjStatus wire:model="filePDF" type="file" />

                <x-text-input id="descPDF" placeholder="keteranganHasilPenunjang" class="mt-1 ml-2" :errorshas="__($errors->has('descPDF'))"
                    :disabled=$disabledPropertyRjStatus wire:model.debounce.500ms="descPDF" />

                <div class="grid grid-cols-1 p-2 mt-1">
                    <div wire:loading wire:target="uploadHasilPenunjang">
                        <x-loading />
                    </div>

                    <x-primary-button :disabled=$disabledPropertyRjStatus type="submit" wire:loading.remove>
                        Upload Data Penunjang
                    </x-primary-button>
                </div>

                {{-- @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach --}}

            </div>
        @endrole

        <table class="w-full text-sm text-left text-gray-500 table-auto ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 ">
                <tr>

                    <th scope="col" class="px-4 py-3 ">
                        <x-sort-link :active=false wire:click.prevent="" role="button" href="#">
                            Tgl Upload
                        </x-sort-link>
                    </th>

                    <th scope="col" class="px-4 py-3">
                        <x-sort-link :active=false wire:click.prevent="" role="button" href="#">
                            Keterangan Penunjang
                        </x-sort-link>
                    </th>

                    <th scope="col" class="w-8 px-4 py-3 text-center">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white ">
                @isset($dataDaftarUgd['pemeriksaan']['uploadHasilPenunjang'])
                    @foreach ($dataDaftarUgd['pemeriksaan']['uploadHasilPenunjang'] as $key => $uploadHasilPenunjang)
                        <tr class="border-b group ">

                            <td class="w-1/3 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                {{ isset($uploadHasilPenunjang['tglUpload']) ? $uploadHasilPenunjang['tglUpload'] : '' }}
                            </td>

                            {{-- <td class="w-1/3 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                {{ isset($uploadHasilPenunjang['file']) ? $uploadHasilPenunjang['file'] : '' }}
                            </td> --}}

                            <td class="w-1/3 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                {{ isset($uploadHasilPenunjang['desc']) ? $uploadHasilPenunjang['desc'] : '' }}
                            </td>

                            {{-- <td class="w-1/3 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                {{ implode(',', isset($uploadHasilPenunjang['penanggungJawab']) ? $uploadHasilPenunjang['penanggungJawab'] : []) }}
                            </td> --}}

                            <td class="w-1/3 px-2 py-2 font-normal text-gray-700 group-hover:bg-gray-50 whitespace-nowrap">
                                <div class="flex justify-between">
                                    @role(['Perawat', 'Admin', 'Dokter'])
                                        <x-yellow-button class="inline-flex" :disabled=$disabledPropertyRjStatus
                                            wire:click.prevent="openModalHasilPenunjang('{{ isset($uploadHasilPenunjang['file']) ? $uploadHasilPenunjang['file'] : '' }}')">
                                            <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M5 6a1 1 0 0 1 1-1h12a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Zm0 12a1 1 0 0 1 1-1h12a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Zm1.65-9.76A1 1 0 0 0 5 9v6a1 1 0 0 0 1.65.76l3.5-3a1 1 0 0 0 0-1.52l-3.5-3ZM12 10a1 1 0 0 1 1-1h5a1 1 0 1 1 0 2h-5a1 1 0 0 1-1-1Zm0 4a1 1 0 0 1 1-1h5a1 1 0 1 1 0 2h-5a1 1 0 0 1-1-1Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </x-yellow-button>
                                    @endrole
                                    @role(['Perawat', 'Admin'])
                                        <x-alternative-button class="inline-flex" :disabled=$disabledPropertyRjStatus
                                            wire:click.prevent="deleteHasilPenunjang('{{ isset($uploadHasilPenunjang['file']) ? $uploadHasilPenunjang['file'] : '' }}')">
                                            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                                <path
                                                    d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                            </svg>
                                        </x-alternative-button>
                                    @endrole

                                </div>
                            </td>

                        </tr>
                    @endforeach
                @endisset


            </tbody>
        </table>

    </div>
</form>

@if ($isOpenRekamMedisuploadpenunjangHasil)
    @include('livewire.emr-u-g-d.mr-u-g-d.pemeriksaan.create-uploadpenunjangHasil')
@endif
