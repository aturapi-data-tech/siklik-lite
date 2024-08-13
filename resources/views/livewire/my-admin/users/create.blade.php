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
                    class="sticky top-0 flex items-center justify-between p-4 bg-gray-700 bg-opacity-75 border-b rounded-t-lg">

                    <!-- myTitle-->
                    <h3 class="w-full text-2xl font-semibold text-white ">
                        {{ $myTitle }}
                    </h3>

                    {{-- rjDate & Shift Input Rj --}}
                    <div id="shiftTanggal" class="flex justify-end w-full mr-4">


                        {{-- Close Modal --}}
                        <button wire:click="closeModal()"
                            class="text-gray-400 bg-gray-50 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>







                </div>

                {{-- Content --}}
                <div class="mx-10">
                    <form wire:submit.prevent='store'>
                        {{-- @csrf --}}

                        <!-- Name -->
                        {{ $myData['name'] }}
                        <div>
                            <x-input-label for="myData.name" :value="__('Name')" />
                            <x-text-input id="myData.name" class="block w-full mt-1" type="text" name="myData.name"
                                :value="old('name')" required autofocus autocomplete="myData.name"
                                wire:model="myData.name" />
                            <x-input-error :messages="$errors->get('myData.name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="myData.email" :value="__('Email')" />
                            @if ($isOpenMode == 'insert')
                                <x-text-input id="myData.email" class="block w-full mt-1 " type="email"
                                    name="myData.email" :value="old('email')" required autocomplete="username"
                                    wire:model="myData.email" />
                            @else
                                <x-text-input id="myData.email" class="block w-full mt-1 " type="email"
                                    name="myData.email" :value="old('email')" required autocomplete="username"
                                    wire:model="myData.email" disabled />
                            @endif
                            <x-input-error :messages="$errors->get('myData.email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        @if ($isOpenMode == 'insert')
                            <div class="mt-4">
                                <x-input-label for="myData.password" :value="__('Password')" />

                                <x-text-input id="myData.password" class="block w-full mt-1" type="password"
                                    name="myData.password" required autocomplete="new-password"
                                    wire:model="myData.password" />
                                <x-input-error :messages="$errors->get('myData.password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-input-label for="myData.password_confirmation" :value="__('Confirm Password')" />

                                <x-text-input id="myData.password_confirmation" class="block w-full mt-1"
                                    type="password" name="myData.password_confirmation" required
                                    autocomplete="new-password" wire:model="myData.password_confirmation" />

                                <x-input-error :messages="$errors->get('myData.password_confirmation')" class="mt-2" />
                            </div>
                        @endif

                        <div>
                            <div class="mt-4">
                                <x-input-label for="myUserCode" :value="__('myUsreCode')" />
                                <x-text-input id="myUserCode" class="block w-full mt-1"
                                    wire:model="myData.myUserCode" />
                                <x-input-error :messages="$errors->get('myData.myUserCode')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="myUserName" :value="__('myUsreName')" />
                                <x-text-input id="myUserName" class="block w-full mt-1"
                                    wire:model="myData.myUserName" />
                                <x-input-error :messages="$errors->get('myData.myUserName')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="myUserSIP" :value="__('myUsreSIP')" />
                                <x-text-input id="myUserSIP" class="block w-full mt-1" wire:model="myData.myUserSIP" />
                                <x-input-error :messages="$errors->get('myData.myUserSIP')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="myUserTtdImage" :value="__('myUserTtdImage')" />
                                <x-text-input id="myUserTtdImage" class="block w-full mt-1"
                                    wire:model="myData.myUserTtdImage" type="file" />
                                {{-- photo Old --}}
                                <x-text-input id="myUserTtdImageOld" class="hidden w-full mt-1 "
                                    wire:model="myData.myUserTtdImage" />

                                <x-input-error :messages="$errors->get('myData.myUserTtdImage')" class="mt-2" />

                            </div>

                            <div class="my-4">
                                <img class="h-auto max-w-full rounded-lg"
                                    src="{{ asset('storage/' . $myData['myUserTtdImage']) }}" alt="">
                            </div>

                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>
                            @if ($isOpenMode == 'insert')
                                <x-primary-button class="ml-4">
                                    {{ __('Register') }}
                                </x-primary-button>
                            @else
                                <x-primary-button class="ml-4">
                                    {{ __('Update User') }}
                                </x-primary-button>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Content --}}

            </div>

        </div>

    </div>

</div>
