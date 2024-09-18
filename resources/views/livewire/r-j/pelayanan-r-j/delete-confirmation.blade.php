<div x-data="{ deleteConfirmation{{ addslashes($RJp->rj_no) }}: false }">

    <div x-show="deleteConfirmation{{ addslashes($RJp->rj_no) }}">
        <x-confirmation-modal>

            <x-slot name="closeButton">
                <button type="button"
                    class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    @click="deleteConfirmation{{ addslashes($RJp->rj_no) }} = false">

                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </x-slot>

            <x-slot name="descriptionText">
                <p class="mb-4 text-gray-500 dark:text-gray-300">
                    Apakah anda yakin akan menghapus data
                    {{ $RJp->reg_name }}?
                </p>
            </x-slot>

            <x-slot name="yesButton">
                <x-red-button @click="deleteConfirmation{{ addslashes($RJp->rj_no) }} = false"
                    wire:click="batalPoli('{{ addslashes($RJp->rj_no) }}','{{ addslashes($RJp->reg_name) }}')"
                    wire:loading.remove>
                    Ya, Saya Yakin!
                </x-red-button>

                <div wire:loading wire:target="batalPoli">
                    <x-loading />
                </div>
            </x-slot>

            <x-slot name="noButton">
                <x-light-button @click="deleteConfirmation{{ addslashes($RJp->rj_no) }} = false" type="button">
                    Tidak
                </x-light-button>
            </x-slot>

        </x-confirmation-modal>
    </div>

    <x-red-button @click="deleteConfirmation{{ addslashes($RJp->rj_no) }} = true" class="ml-12">
        Batal Poli
    </x-red-button>


</div>
