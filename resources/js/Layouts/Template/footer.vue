<template>
    <footer class="footer bg-gradient-to-t from-black via-gray-900 to-gray-700 shadow-lg relative pt-1 mt-5">
        <div class="container mx-auto px-6">

            <div class="sm:flex sm:mt-8">
                <div class="mt-8 sm:mt-0 sm:w-full sm:px-8 flex flex-col md:flex-row justify-around">
                    <div class="flex flex-col text-center order-2">
                        <inertia-link href="/" class="font-extrabold text-gray-400 text-2xl font-mono uppercase filter drop-shadow-lg hover:text-gray-100 transition duration-500">Silk Road MiddleEast</inertia-link>
                        <span class="my-2 text-gray-400 font-light">All what you need is only here</span>
                    </div>
                    <div class="flex flex-col">
                        <span id="divide" class="font-extrabold text-gray-400 uppercase mt-4 md:mt-0 mb-2 select-none">Links</span>
                        <span class="my-1"><inertia-link href="/" class="text-gray-500 text-md hover:text-yellow-500 transition duration-500">Home</inertia-link></span>
                        <span class="my-1"><inertia-link href="/category" class="text-gray-500 text-md hover:text-yellow-500 transition duration-500">Categories</inertia-link></span>
                        <span class="my-1"><inertia-link href="/product" class="text-gray-500 text-md hover:text-yellow-500 transition duration-500">Products</inertia-link></span>
                        <span class="my-1"><inertia-link href="/cart" class="text-gray-500  text-md hover:text-yellow-500 transition duration-500">Cart</inertia-link></span>
                        <span class="my-1"><inertia-link href="/state" class="text-gray-500 text-md hover:text-yellow-500 transition duration-500">Check your Order</inertia-link></span>
                        <span class="my-1"><inertia-link href="likes" class="text-gray-500 text-md hover:text-yellow-500 transition duration-500">Favorite</inertia-link></span>
                        <span class="my-1"><inertia-link href="special" class="text-gray-500 text-md hover:text-yellow-500 transition duration-500">Special Products</inertia-link></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mx-auto px-6">
            <div class="mt-4 border-t-2 border-gray-500 border-opacity-40 flex flex-col items-center">
                <div class="sm:w-2/3 text-center py-3">
                    <p class="text-sm text-gray-400 font-bold mb-1">
                        {{ moment().format('YYYY') }} - All Right Received for Silk Road MiddleEast
                    </p>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
    import moment from 'moment'

export default {
    data() {
        return {
            moment: moment,
        }
    },
}
</script>

<style scoped>
    #divide::after{
        content: '';
        display: block;
        width: 40px;
        border-top: 2px solid #F59E0B;
        margin: 0.8rem 0 0 0;
        opacity: .4;
    }
</style>
