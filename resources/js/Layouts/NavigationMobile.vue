<template>
    <transition enter-active-class="transition ease-in-out duration-150" enter-from-class="opacity-0"
        enter-to-class="opacity-100" leave-active-class="transition ease-in-out duration-150"
        leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-show="$page.props.showingMobileMenu"
            class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
    </transition>
    <transition enter-active-class="transition ease-in-out duration-150"
        enter-from-class="opacity-0 transform -translate-x-20" enter-to-class="opacity-100"
        leave-active-class="transition ease-in-out duration-150" leave-from-class="opacity-100"
        leave-to-class="opacity-0 transform -translate-x-20">
        <aside v-show="$page.props.showingMobileMenu"
            class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white md:hidden">
            <div class="py-4 ">
                <Link class="ml-6 text-lg font-bold text-gray-800" :href="route('dashboard')">
                Autos de la Huasteca
                </Link>
                <ul class="mt-6">
                    <li class="relative px-6 py-3">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            <template #icon>
                                <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" stroke="#001E50">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M21.4498 10.275L11.9998 3.1875L2.5498 10.275L2.9998 11.625H3.7498V20.25H20.2498V11.625H20.9998L21.4498 10.275ZM5.2498 18.75V10.125L11.9998 5.0625L18.7498 10.125V18.75H14.9999V14.3333L14.2499 13.5833H9.74988L8.99988 14.3333V18.75H5.2498ZM10.4999 18.75H13.4999V15.0833H10.4999V18.75Z"
                                        fill="#001E50"></path>
                                </g>
                            </svg>
                            </template>
                            Dashboard
                        </ResponsiveNavLink>
                    </li>

                    <li class="relative px-6 py-3">
                        <ResponsiveNavLink :href="route('reporte.index')" :active="route().current('reporte.index')">
                            <template #icon>
                                <!-- <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                     stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                  <path
                      d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                </svg> -->
                <svg fill="#001E50" width="30px" height="30px" viewBox="0 0 16 16" id="register-16px"
                                xmlns="http://www.w3.org/2000/svg" stroke="#001E50" stroke-width="0.00016">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path id="Path_184" data-name="Path 184"
                                        d="M57.5,41a.5.5,0,0,0-.5.5V43H47V31h2v.5a.5.5,0,0,0,.5.5h5a.5.5,0,0,0,.5-.5V31h2v.5a.5.5,0,0,0,1,0v-1a.5.5,0,0,0-.5-.5H55v-.5A1.5,1.5,0,0,0,53.5,28h-3A1.5,1.5,0,0,0,49,29.5V30H46.5a.5.5,0,0,0-.5.5v13a.5.5,0,0,0,.5.5h11a.5.5,0,0,0,.5-.5v-2A.5.5,0,0,0,57.5,41ZM50,29.5a.5.5,0,0,1,.5-.5h3a.5.5,0,0,1,.5.5V31H50Zm11.854,4.646-2-2a.5.5,0,0,0-.708,0l-6,6A.5.5,0,0,0,53,38.5v2a.5.5,0,0,0,.5.5h2a.5.5,0,0,0,.354-.146l6-6A.5.5,0,0,0,61.854,34.146ZM54,40V38.707l5.5-5.5L60.793,34.5l-5.5,5.5Zm-2,.5a.5.5,0,0,1-.5.5h-2a.5.5,0,0,1,0-1h2A.5.5,0,0,1,52,40.5Zm0-3a.5.5,0,0,1-.5.5h-2a.5.5,0,0,1,0-1h2A.5.5,0,0,1,52,37.5ZM54.5,35h-5a.5.5,0,0,1,0-1h5a.5.5,0,0,1,0,1Z"
                                        transform="translate(-46 -28)"></path>
                                </g>
                            </svg>
                            </template>
                            Registro de quejas
                        </ResponsiveNavLink>
                    </li>

                    <li class="relative px-6 py-3">
                        <ResponsiveNavLink :href="route('empleados.index')" :active="route().current('empleados.index')">
                            <template #icon>
                                <svg width="30px" height="30px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#001E50" stroke="#001E50"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools --> <title>ic_fluent_person_add_24_filled</title> <desc>Created with Sketch.</desc> <g id="🔍-System-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="ic_fluent_person_add_24_filled" fill="#001E50" fill-rule="nonzero"> <path d="M17.5,12 C20.5376,12 23,14.4624 23,17.5 C23,20.5376 20.5376,23 17.5,23 C14.4624,23 12,20.5376 12,17.5 C12,14.4624 14.4624,12 17.5,12 Z M12.0223,13.9993 C11.3752,15.0098 11,16.2111 11,17.5 C11,19.1303 11.6002,20.6205 12.5917,21.7615 C11.7962,21.9216 10.9313,22.0011 10,22.0011 C6.57903,22.0011 4.05607,20.9289 2.51391,18.7646 C2.223445,18.3569375 2.05054172,17.8789141 2.01185441,17.3825156 L2.00354,17.1688 L2.00354,16.2488 C2.00354,15.05855 2.92824302,14.0842165 4.09844811,14.0050884 L4.25242,13.9999 L12.0223,13.9993 Z M17.5,14 L17.4101,14.008 C17.2351571,14.0398 17.0919531,14.1625551 17.0313076,14.3255085 L17.0081,14.4101 L17,14.5 L16.999,17 L14.5039,17 L14.414,17.0081 C14.2390571,17.0398143 14.0958531,17.1625571 14.0352076,17.3255087 L14.012,17.4101 L14.0039,17.5 L14.012,17.5899 C14.0437143,17.7648429 14.1664571,17.9080469 14.3294087,17.9686924 L14.414,17.9919 L14.5039,18 L16.999,18 L17,20.5 L17.0081,20.5899 C17.0398143,20.7648429 17.1625571,20.9080469 17.3255087,20.9686924 L17.4101,20.9919 L17.5,21 L17.5899,20.9919 C17.7648429,20.9601857 17.9080469,20.8374429 17.9686924,20.6744913 L17.9919,20.5899 L18,20.5 L17.999,18 L20.5039,18 L20.5938,17.9919 C20.7687429,17.9601857 20.9119469,17.8374429 20.9726554,17.6744913 L20.9959,17.5899 L21.0039,17.5 L20.9959,17.4101 C20.9641,17.2351571 20.8413449,17.0919531 20.6783915,17.0313076 L20.5938,17.0081 L20.5039,17 L17.999,17 L18,14.5 L17.9919,14.4101 C17.9601857,14.2351571 17.8374429,14.0919531 17.6744913,14.0312446 L17.5899,14.008 L17.5,14 Z M10,2.00464 C12.7614,2.00464 15,4.24321 15,7.00464 C15,9.76606 12.7614,12.0046 10,12.0046 C7.23857,12.0046 5,9.76606 5,7.00464 C5,4.24321 7.23857,2.00464 10,2.00464 Z" id="🎨-Color"> </path> </g> </g> </g></svg>
                            </template>
                            Registro de personal
                        </ResponsiveNavLink>
                    </li>
                </ul>
            </div>
        </aside>
    </transition>
</template>

<script setup>
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

let showingTwoLevelMenu = ref(false);
</script>
