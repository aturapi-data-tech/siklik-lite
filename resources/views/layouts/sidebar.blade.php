{{-- SideBar --}}
<aside id="sidebar"
    class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-20 font-normal duration-75 transition-width"
    aria-label="Sidebar">
    <div
        class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                <ul class="pb-2 space-y-2 ">


                    @php
                        $myRoles = json_decode(auth()->user()->roles, true);
                    @endphp

                    @isset($myRoles)
                        @foreach ($myRoles as $myRole)
                            <div class="text-sm italic text-gray-900">
                                {{ auth()->user()->myuser_name }}
                                {{ ' - (' . $myRole['name'] . ')' }}
                            </div>
                        @endforeach
                    @endisset

                    <x-theme-line :themeline="__('3')"></x-theme-line>

                    <li class="border border-gray-300 rounded-lg shadow-lg shadow-gray-500/5">



                        <button type="button"
                            class="flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg group hover:text-primary dark:text-gray-200 dark:hover:bg-gray-700"
                            aria-controls="dropdown-layoutsRJ" data-collapse-toggle="dropdown-layoutsRJ">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" version="1.1"
                                id="svg6" sodipodi:docname="home-svgrepo-com.svg"
                                inkscape:version="1.1.2 (0a00cf5339, 2022-02-04)"
                                xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                                xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                                xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                                <defs id="defs10" />
                                <sodipodi:namedview id="namedview8" pagecolor="#ffffff" bordercolor="#666666"
                                    borderopacity="1.0" inkscape:pageshadow="2" inkscape:pageopacity="0.0"
                                    inkscape:pagecheckerboard="0" showgrid="false" inkscape:zoom="0.67"
                                    inkscape:cx="399.25373" inkscape:cy="400" inkscape:window-width="1366"
                                    inkscape:window-height="700" inkscape:window-x="1920" inkscape:window-y="136"
                                    inkscape:window-maximized="1" inkscape:current-layer="svg6" />
                                <path
                                    d="M22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274"
                                    stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" id="path2"
                                    style="stroke:#157547;stroke-opacity:1" />
                                <path d="M15 18H9" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"
                                    id="path4" style="stroke:#a1cd3a;stroke-opacity:1" />
                            </svg>
                            <span class="flex-1 ml-3 text-base text-left whitespace-nowrap" sidebar-toggle-item="">
                                Rawat
                                Jalan</span>
                            <svg sidebar-toggle-item="" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>


                        <ul id="dropdown-layoutsRJ" class="hidden py-2 space-y-2">
                            <li>
                                @role(['Mr', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('MasterPoli')" :active="request()->routeIs('MasterPoli')">
                                        {{ __('Master Poli') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Mr', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('MasterDokter')" :active="request()->routeIs('MasterDokter')">
                                        {{ __('Master Dokter') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Mr', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('MasterPasien')" :active="request()->routeIs('MasterPasien')">
                                        {{ __('Pendaftaran Pasien Baru') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Mr', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('BookingRJ')" :active="request()->routeIs('BookingRJ')">
                                        {{ __('Booking Rawat Jalan') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Perawat', 'Mr', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('daftarRJ')" :active="request()->routeIs('daftarRJ')">
                                        {{ __('Pendaftaran Rawat Jalan') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Perawat', 'Mr', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('pelayananRJ')" :active="request()->routeIs('pelayananRJ')">
                                        {{ __('Pelayanan Rawat Jalan') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Dokter', 'Perawat', 'Mr', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('EmrRJ')" :active="request()->routeIs('EmrRJ')">
                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->


                                        {{ __('Rekam Medis Rawat Jalan') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Apoteker', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('TelaahResepRJ')" :active="request()->routeIs('TelaahResepRJ')">
                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->


                                        {{ __('Resep Rawat Jalan') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Apoteker', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('TelaahResepUGD')" :active="request()->routeIs('TelaahResepUGD')">
                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Transformed by: SVG Repo Mixer Tools -->


                                        {{ __('Resep UGD') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Mr', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('SetupHfisBpjs')" :active="request()->routeIs('SetupHfisBpjs')">
                                        {{ __('SetupHfisBpjs') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Perawat', 'Mr', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('displayPelayananRJ')" :active="request()->routeIs('displayPelayananRJ')">
                                        {{ __('Display Pelayanan RJ') }}
                                    </x-nav-link>
                                @endrole

                            </li>
                        </ul>


                    </li>

                    <li class="border border-gray-300 rounded-lg ">

                        <button type="button"
                            class="flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg group hover:text-primary dark:text-gray-200 dark:hover:bg-gray-700"
                            aria-controls="dropdown-layoutsUGD" data-collapse-toggle="dropdown-layoutsUGD">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" version="1.1"
                                id="svg6" sodipodi:docname="home-angle-2-svgrepo-com.svg"
                                inkscape:version="1.1.2 (0a00cf5339, 2022-02-04)"
                                xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                                xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                                xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                                <defs id="defs10" />
                                <sodipodi:namedview id="namedview8" pagecolor="#ffffff" bordercolor="#666666"
                                    borderopacity="1.0" inkscape:pageshadow="2" inkscape:pageopacity="0.0"
                                    inkscape:pagecheckerboard="0" showgrid="false" inkscape:zoom="0.1675"
                                    inkscape:cx="-414.92537" inkscape:cy="567.16418" inkscape:window-width="1366"
                                    inkscape:window-height="700" inkscape:window-x="1920" inkscape:window-y="136"
                                    inkscape:window-maximized="1" inkscape:current-layer="svg6" />
                                <path d="M12 15L12 18" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"
                                    id="path2" style="stroke:#ff0f3a;stroke-opacity:1;fill:#ff0000" />
                                <path
                                    d="M21.6359 12.9579L21.3572 14.8952C20.8697 18.2827 20.626 19.9764 19.451 20.9882C18.2759 22 16.5526 22 13.1061 22H10.8939C7.44737 22 5.72409 22 4.54903 20.9882C3.37396 19.9764 3.13025 18.2827 2.64284 14.8952L2.36407 12.9579C1.98463 10.3208 1.79491 9.00229 2.33537 7.87495C2.87583 6.7476 4.02619 6.06234 6.32691 4.69181L7.71175 3.86687C9.80104 2.62229 10.8457 2 12 2C13.1543 2 14.199 2.62229 16.2882 3.86687L17.6731 4.69181C19.9738 6.06234 21.1242 6.7476 21.6646 7.87495"
                                    stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" id="path4"
                                    style="stroke:#157547;stroke-opacity:1" />
                            </svg>
                            <span class="flex-1 ml-3 text-base text-left whitespace-nowrap" sidebar-toggle-item="">
                                IGD</span>
                            <svg sidebar-toggle-item="" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>



                        <ul id="dropdown-layoutsUGD" class="hidden py-2 space-y-2">
                            <li>
                                @role(['Mr', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('daftarUGD')" :active="request()->routeIs('daftarUGD')">
                                        {{ __('Pendaftaran UGD') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Dokter', 'Perawat', 'Mr', 'Admin'])
                                    <x-nav-link class="pl-4" :href="route('EmrUGD')" :active="request()->routeIs('EmrUGD')">
                                        {{ __('Rekam Medis UGD') }}
                                    </x-nav-link>
                                @endrole



                                @role(['Admin'])
                                    <x-nav-link class="pl-4" :href="route('MyUsers')" :active="request()->routeIs('MyUses')">
                                        {{ __('MyUsers') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Admin'])
                                    <x-nav-link class="pl-4" :href="route('MyRoles')" :active="request()->routeIs('MyRoles')">
                                        {{ __('MyRoles') }}
                                    </x-nav-link>
                                @endrole

                                @role(['Admin'])
                                    <x-nav-link class="pl-4" :href="route('MyPermissions')" :active="request()->routeIs('MyPermissions')">
                                        {{ __('MyPermissions') }}
                                    </x-nav-link>
                                @endrole

                            </li>
                        </ul>


                    </li>



                </ul>

                <div class="pt-2 space-y-2">

                </div>






            </div>
        </div>

    </div>
</aside>
{{-- SideBar Transparant --}}
<div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>
