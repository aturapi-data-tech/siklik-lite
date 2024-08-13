<div>

    {{-- Start Coding  --}}

    {{-- Canvas
    Main BgColor /
    Size H/W --}}
    <div class="w-full h-[calc(100vh-68px)] bg-white border border-gray-200 px-16 pt-2">

        {{-- Title  --}}
        <div class="mb-2">
            <h3 class="text-3xl font-bold text-gray-900 ">{{ $myTitle }}</h3>
            <span class="text-base font-normal text-gray-700">{{ $mySnipet }}</span>
        </div>
        {{-- Title --}}

        {{-- Top Bar --}}
        <div class="flex justify-between">

            <div class="flex justify-between w-full">
                {{-- Cari Data --}}
                <div class="relative w-1/3 mr-2 pointer-events-auto">
                    <div class="absolute inset-y-0 left-0 flex items-center p-5 pl-3 pointer-events-none ">
                        <svg width="24" height="24" fill="none" aria-hidden="true" class="flex-none mr-3 ">
                            <path d="m19 19-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></circle>
                        </svg>
                    </div>

                    <x-text-input type="text" class="w-full p-2 pl-10" placeholder="Cari Data" autofocus
                        wire:model="refSearch" />
                </div>

                <div>
                    <form wire:submit.prevent="createUser">
                        <x-primary-button type="submit">Create User</x-primary-button>
                    </form>
                </div>
                {{-- Cari Data --}}


                {{-- <x-primary-button class="ml-2" wire:click='scanLogProses()' wire:loading.remove>
                    {{ 'ScanLog' }}
                </x-primary-button>

                <div wire:loading wire:target="scanLogProses">
                    <x-loading />
                </div>

                <x-primary-button class="ml-2" wire:click='scanLogProses()' wire:loading.remove>
                    {{ 'ScanLog All' }}
                </x-primary-button> --}}

            </div>

            <div>
                {{-- <x-primary-button class="ml-2" wire:click='userProses()' wire:loading.remove>
                    {{ 'User' }}
                </x-primary-button>

                <div wire:loading wire:target="userProses">
                    <x-loading />
                </div> --}}

                {{-- <x-primary-button class="ml-2" wire:click='getDevInfoMachine()' wire:loading.remove>
                    {{ 'DevieInfo' }}
                </x-primary-button>

                <div wire:loading wire:target="getDevInfoMachine">
                    <x-loading />
                </div> --}}
            </div>

            @if ($isOpen)
                @include('livewire.my-admin.users.create')
            @endif

        </div>
        {{-- Top Bar --}}






        <div class="h-[calc(100vh-250px)] mt-2 overflow-auto">
            <!-- Table -->
            <table class="w-full text-sm text-left text-gray-700 table-auto ">
                <thead class="sticky top-0 text-xs text-gray-900 uppercase bg-gray-100">
                    <tr>
                        {{-- <th scope="col" class="w-1/5 px-4 py-3 ">
                            Id
                        </th> --}}
                        <th scope="col" class="w-1/5 px-4 py-3 ">
                            User
                        </th>
                        {{-- <th scope="col" class="w-1/5 px-4 py-3 ">
                            Update
                        </th> --}}
                        <th scope="col" class="w-1/5 px-4 py-3 ">
                            Lock / Unlock
                        </th>
                        <th scope="col" class="w-1/5 px-4 py-3 ">
                            Hapus
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white ">

                    @foreach ($myQueryData as $myQData)
                        <tr class="border-b ">
                            {{-- <td class="px-4 py-2">
                                {{ $myQData->id }}
                            </td> --}}
                            <td class="px-4 py-2">
                                Name : {{ $myQData->name . ' / ' . $myQData->myuser_code }}
                                <br>
                                SIP : {{ $myQData->myuser_sip }}
                                <br>
                                <span class="text-lg font-semibold text-primary"> User : {{ $myQData->email }}</span>
                                <br>
                                <span class="italic font-semibold"> Role : {{ $myQData->myrole }}</span>
                                <br>
                                Create : {{ $myQData->updated_at }}
                            </td>
                            <td class="px-4 py-2">
                                <div>
                                    <img class="h-24" src="{{ asset('storage/' . $myQData->myuser_ttd_image) }}"
                                        alt="">
                                </div>
                            </td>
                            {{-- <td class="px-4 py-2">
                                {{ $myQData->updated_at }}
                            </td> --}}
                            <td class="px-4 py-2">



                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <form wire:submit.prevent="assignRolePerawat({{ $myQData->id }})">
                                            <x-primary-button type="submit">RolePerawat</x-primary-button>
                                        </form>
                                    </div>
                                    <div>
                                        <form wire:submit.prevent="assignRoleDokter({{ $myQData->id }})">
                                            <x-primary-button type="submit">RoleDokter</x-primary-button>
                                        </form>
                                    </div>
                                    <div>
                                        <form wire:submit.prevent="assignRoleMr({{ $myQData->id }})">
                                            <x-primary-button type="submit">RoleMr</x-primary-button>
                                        </form>
                                    </div>
                                    <div>
                                        <form wire:submit.prevent="assignRoleApoteker({{ $myQData->id }})">
                                            <x-primary-button type="submit">RoleApoteker</x-primary-button>
                                        </form>
                                    </div>
                                    <div>
                                        <form wire:submit.prevent="assignRoleAdmin({{ $myQData->id }})">
                                            <x-primary-button type="submit">RoleAdmin</x-primary-button>
                                        </form>
                                    </div>





                                    <div>
                                        <form wire:submit.prevent="removeRolePerawat({{ $myQData->id }})">
                                            <x-light-button type="submit">HapusRolePerawat</x-light-button>
                                        </form>
                                    </div>
                                    <div>
                                        <form wire:submit.prevent="removeRoleDokter({{ $myQData->id }})">
                                            <x-light-button type="submit">HapusRoleDokter</x-light-button>
                                        </form>
                                    </div>
                                    <div>
                                        <form wire:submit.prevent="removeRoleMr({{ $myQData->id }})">
                                            <x-light-button type="submit">HapusRoleMr</x-light-button>
                                        </form>
                                    </div>
                                    <div>
                                        <form wire:submit.prevent="removeRoleApoteker({{ $myQData->id }})">
                                            <x-light-button type="submit">HapusRoleApoteker</x-light-button>
                                        </form>
                                    </div>
                                    <div>
                                        <form wire:submit.prevent="removeRoleAdmin({{ $myQData->id }})">
                                            <x-light-button type="submit">HapusRoleAdmin</x-light-button>
                                        </form>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2">


                                    <div class="my-2">
                                        <form wire:submit.prevent="editUser('{{ $myQData->email }}')">
                                            <x-yellow-button type="submit">Edit User</x-yellow-button>
                                        </form>
                                    </div>

                                    <div class="my-2">
                                        <form wire:submit.prevent="deleteUser('{{ $myQData->email }}')">
                                            <x-danger-button type="submit">Hapus User</x-danger-button>
                                        </form>
                                    </div>
                                </div>


                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{ $myQueryData->links() }}


        <div class="grid grid-cols-4 gap-2">
            @can('Read Only')
                <div>
                    Read Only
                </div>
            @endcan

            @can('Read / Write')
                <div>
                    Read / Write
                </div>
            @endcan


            @role('Dokter')
                <div> I am a Dokter!</div>
            @endrole
            @role('Perawat')
                <div> I am a Perawat!</div>
            @endrole
            @role('Admin')
                <div> I am a Admin!</div>
            @endrole
            @php
                $myRoles = json_decode(auth()->user()->roles, true);
            @endphp
            @isset($myRoles)
                @foreach ($myRoles as $myRole)
                    <div>
                        {{ 'My role is ' . $myRole['name'] }}
                        {{ auth()->user()->myuser_ttd_image }}
                    </div>
                @endforeach
            @endisset
        </div>
    </div>

    {{-- Canvas
    Main BgColor /
    Size H/W --}}

    {{-- End Coding --}}
</div>
