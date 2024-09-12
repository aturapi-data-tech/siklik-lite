<!-- Main modal -->
<div
    class="fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full overflow-y-auto bg-gray-900 bg-opacity-50 md:inset-0 h-modal md:h-full">

    <div class="relative w-full h-full max-w-md p-4 md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">

            {{ isset($closeButton) ? $closeButton : '' }}

            <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                    clip-rule="evenodd"></path>
            </svg>

            {{ isset($descriptionText) ? $descriptionText : 'Keterangan' }}

            <div class="flex items-center justify-center space-x-4">

                {{ isset($yesButton) ? $yesButton : '' }}

                {{ isset($noButton) ? $noButton : '' }}


            </div>
        </div>
    </div>

</div>
