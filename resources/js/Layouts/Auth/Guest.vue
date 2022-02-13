<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-700">
        <div>
            <inertia-link href="/">
                <breeze-application-logo class="w-40 mt-5 h-20 fill-current text-gray-500" />
            </inertia-link>
        </div>

        <div class="lg:w-6/12 md:w-8/12 w-10/12 sm:max-w-md mt-6 px-6 py-4 bg-gray-900 rounded-lg shadow-lg overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>

<script>
    import BreezeApplicationLogo from '@/Components/Auth/ApplicationLogo'

    export default {
        components: {
            BreezeApplicationLogo,
        }
    }
</script>
