<template>
    <div>
        <div class="min-h-screen">
            <nav class="border-b bg-dark sticky-top">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <inertia-link :href="route('dashboard')">
                                    <breeze-application-logo class="block w-24 my-2" />
                                </inertia-link>
                                <div class="">
                                    <breeze-responsive-nav-link :href="route('dashboard')" :active="route().current('home')" class="text-gray-50 text-2xl">
                                        Micro Store
                                    </breeze-responsive-nav-link>
                                </div>
                            </div>

                            <!-- Navigation Links -->

                        </div>

                        <div class="hidden lg:flex lg:items-center lg:ml-6">
                            <navBar :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder"/>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative flex">
                                <breeze-button @click.prevent="goHome" class="py-2 mx-2 text-xs border-2 border-white">
                                    الصفحة الرئيسية
                                </breeze-button>
                                <breeze-dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border-2 border-white text-sm leading-4 font-medium rounded-md hover:text-gray-400 text-white focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <breeze-dropdown-link class="text-right" :href="route('logout')" method="post" as="button">
                                            تسجيل الخروج
                                        </breeze-dropdown-link>
                                    </template>
                                </breeze-dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="flex items-center bg-white my-3 rounded-2 lg:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="lg:hidden">


                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 d-block">
                        <div class="px-4 w-100 text-center">
                            <div class="font-medium text-white">مرحبا بك <span class="text-warning">{{ $page.props.auth.user.name }}</span></div>
                        </div>
                        <navBar :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder" />
                        <div class="mt-3 space-y-1 text-center bg-danger">
                            <breeze-responsive-nav-link :href="route('home')" as="button" class="text-white bg-green-500">
                                الصفحة الرئيسية
                            </breeze-responsive-nav-link>
                            <breeze-responsive-nav-link :href="route('logout')" method="post" as="button" class="text-white">
                                تسجيل الخروج
                            </breeze-responsive-nav-link>
                        </div>
                    </div>
                </div>
            </nav>
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<script>
    import BreezeApplicationLogo from '@/Components/Auth/ApplicationLogo'
    import BreezeDropdown from '@/Components/Auth/Dropdown'
    import BreezeDropdownLink from '@/Components/Auth/DropdownLink'
    import BreezeNavLink from '@/Components/Auth/NavLink'
    import BreezeResponsiveNavLink from '@/Components/Auth/ResponsiveNavLink'
    import navBar from '../Template/navbar'
    import BreezeButton from '@/Components/Auth/Button'
    import { Inertia } from '@inertiajs/inertia'

    export default {
        components: {
            BreezeApplicationLogo,
            BreezeDropdown,
            BreezeDropdownLink,
            BreezeNavLink,
            BreezeResponsiveNavLink,
            navBar,
            BreezeButton,
        },
        props:['isAdmin', 'orderCount', 'doneOrder'],
        data() {
            return {
                showingNavigationDropdown: false,
            }
        },
        methods:{
            goHome(){
                Inertia.visit('/')
            }
        }
    }
</script>
