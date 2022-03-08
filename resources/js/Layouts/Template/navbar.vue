<template>
    <div id="scrollbar" class="lg:col-start-1 lg:col-end-4 bg-dark pb-5 h-96 overflow-auto top left-0 lg:fixed lg:w-3/12">
        <div class="text-center my-4">
            <inertia-link href="/dashboard" class="text-gray-400 text-4xl block hover:text-yellow-500 transition duration-500">
                <fa icon="tachometer-alt" />
            </inertia-link>
            <inertia-link href="/dashboard" class="text-2xl text-white hover:text-yellow-500 transition duration-500">Dashboard</inertia-link>
        </div>
        <!-- + + + + + Admins List + + + + + -->
        <div v-if="isAdmin == 1" class="bg-gray-600 mt-4">
            <button @click="Admin" class="text-white  border-t-2 border-b-2 border-gray-400 bg-gray-600 hvr-bounce-to-left p-3 w-100 hover:bg-gray-400 text-xl text-left">
                <div class="inline-block align-middle pl-2">
                    <fa v-if="!showAdmin" icon="user-cog" />
                    <fa v-else icon="users" />
                </div>
                Admins
                <span class="float-right">
                    <fa icon="chevron-down" :class="showAdmin ? 'opened':'closed'" />
                </span>
            </button>

            <transition name="navItems">
                <div v-if="showAdmin" class="bg-gray-600 text-white text-center py-2">
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/admins">Show Admins
                        <div class="float-left px-3">
                            <fa icon="user-friends" class="text-xl" />
                        </div>
                    </inertia-link>
                    <hr>
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/register">Add Admin
                        <div class="float-left px-3">
                            <fa icon="user-plus" class="text-xl" />
                        </div>
                    </inertia-link>
                </div>
            </transition>
        </div>

        <!-- + + + + + Products List + + + + + -->
        <div class="bg-gray-600 mt-4">
            <button @click="Prod" class="text-white  border-t-2 border-b-2 border-gray-400 bg-gray-600 hvr-bounce-to-left p-3 w-100 hover:bg-gray-400 text-xl text-left">
                <span class="float-right">
                    <fa icon="chevron-down" :class="showProd ? 'opened':'closed'" />
                </span>
                <div class="inline-block align-middle pl-2">
                    <svg v-if="!showProd" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                    </svg>
                    <fa v-else icon="box-open" />
                </div>
                Products
            </button>

            <transition name="navItems">
                <div v-if="showProd" class="bg-gray-600 text-white text-center py-2">
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/products">Show Products
                        <div class="float-left px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-bag-check-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zm-.646 5.354a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                            </svg>
                        </div>
                    </inertia-link>
                    <hr>
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/products/create">Add Product
                        <div class="float-left px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5V8z"/>
                            </svg>
                        </div>
                    </inertia-link>
                </div>
            </transition>
        </div>

        <!-- + + + + + Categories List + + + + + -->
        <div class="bg-gray-600 mt-4">
            <button @click="Cat" class="text-white border-t-2 border-b-2 border-gray-400 bg-gray-600 hvr-bounce-to-left p-3 w-100 hover:bg-gray-400 text-xl text-left">
                <div class="inline-block align-middle pl-2">
                    <svg v-if="!showCat" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-bookmark-star-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zM8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.178.178 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.178.178 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.178.178 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.178.178 0 0 1-.134-.098L8.16 4.1z"/>
                    </svg>
                    <fa v-else icon="tags" />
                </div>
                Categories
                <span class="float-right">
                    <fa icon="chevron-down" :class="showCat ? 'opened':'closed'" />
                </span>
            </button>

            <transition name="navItems">
                <div v-if="showCat" class="bg-gray-600 text-white text-center py-2">
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/categories">Show Categories
                        <div class="float-left px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-bookmark-check-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                            </svg>
                        </div>
                    </inertia-link>
                    <hr>
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/categories/create">Add Category
                        <div class="float-left px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5V4.5z"/>
                            </svg>
                        </div>
                    </inertia-link>
                </div>
            </transition>
        </div>

        <!-- + + + + + Categories List + + + + + -->
        <div class="bg-gray-600 mt-4">
            <button @click="SCat" class="text-white border-t-2 border-b-2 border-gray-400 bg-gray-600 hvr-bounce-to-left p-3 w-100 hover:bg-gray-400 text-xl text-left">
                <div class="inline-block align-middle pl-2">
                    <svg v-if="!showSCat" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-bookmarks-fill" viewBox="0 0 16 16">
                        <path d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5V4z"/>
                        <path d="M4.268 1A2 2 0 0 1 6 0h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L13 13.768V2a1 1 0 0 0-1-1H4.268z"/>
                    </svg>
                    <fa v-else icon="tags" />
                </div>
                SubCategories
                <span class="float-right">
                    <fa icon="chevron-down" :class="showSCat ? 'opened':'closed'" />
                </span>
            </button>

            <transition name="navItems">
                <div v-if="showSCat" class="bg-gray-600 text-white text-center py-2">
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/subcat">Show SubCategories
                        <div class="float-left px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-bookmark-check-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                            </svg>
                        </div>
                    </inertia-link>
                    <hr>
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/subcat/create">Add SubCategory
                        <div class="float-left px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5V4.5z"/>
                            </svg>
                        </div>
                    </inertia-link>
                </div>
            </transition>
        </div>

        <!-- + + + + + Carousel List + + + + + -->
        <div class="bg-gray-600 mt-4">
            <button @click="Car" class="text-white border-t-2 border-b-2 border-gray-400 bg-gray-600 hvr-bounce-to-left p-3 w-100 hover:bg-gray-400 text-xl text-left">
                <div class="inline-block align-middle pl-2">
                    <svg v-if="showCar" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-megaphone-fill" viewBox="0 0 16 16">
                        <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-11zm-1 .724c-2.067.95-4.539 1.481-7 1.656v6.237a25.222 25.222 0 0 1 1.088.085c2.053.204 4.038.668 5.912 1.56V3.224zm-8 7.841V4.934c-.68.027-1.399.043-2.008.053A2.02 2.02 0 0 0 0 7v2c0 1.106.896 1.996 1.994 2.009a68.14 68.14 0 0 1 .496.008 64 64 0 0 1 1.51.048zm1.39 1.081c.285.021.569.047.85.078l.253 1.69a1 1 0 0 1-.983 1.187h-.548a1 1 0 0 1-.916-.599l-1.314-2.48a65.81 65.81 0 0 1 1.692.064c.327.017.65.037.966.06z"/>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-rss-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm1.5 2.5c5.523 0 10 4.477 10 10a1 1 0 1 1-2 0 8 8 0 0 0-8-8 1 1 0 0 1 0-2zm0 4a6 6 0 0 1 6 6 1 1 0 1 1-2 0 4 4 0 0 0-4-4 1 1 0 0 1 0-2zm.5 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                    </svg>
                </div>
                Carousels
                <span class="float-right">
                    <fa icon="chevron-down" :class="showCar ? 'opened':'closed'" />
                </span>
            </button>

            <transition name="navItems">
                <div v-if="showCar" class="bg-gray-600 text-white text-center py-2">
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/carousel">Show Carousels
                        <div class="float-left px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-signpost-2-fill" viewBox="0 0 16 16">
                                <path d="M7.293.707A1 1 0 0 0 7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586A1 1 0 0 0 7.293.707z"/>
                            </svg>
                        </div>
                    </inertia-link>
                    <hr>
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/carousel/create">Add Carousel
                        <div class="float-left px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-patch-plus-fill" viewBox="0 0 16 16">
                                <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zM8.5 6v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 1 0z"/>
                            </svg>
                        </div>
                    </inertia-link>
                </div>
            </transition>
        </div>
        <!-- + + + + + Orders List + + + + + -->
        <div class="bg-gray-600 mt-4">
            <button :class="orderCount ? 'bg-red-600 animate-pulse' : ''" @click="Order" class="text-white border-t-2 border-b-2 border-gray-400 bg-gray-600 hvr-bounce-to-left p-3 w-100 hover:bg-gray-400 text-xl text-left">
                <div class="inline-block align-middle pl-2">
                    <fa v-if="showOrder" icon="dolly" />
                    <fa v-else icon="dolly-flatbed" />
                </div>
                Orders
                <span class="float-right">
                    <fa icon="chevron-down" :class="showOrder ? 'opened':'closed'" />
                </span>
                <span v-if="!showOrder && orderCount > 0" class="position-absolute animate-bounce right-10 translate-middle badge rounded-pill bg-yellow-500">
                    {{orderCount}}
                    <span class="visually-hidden">orderCount</span>
                </span>
            </button>

            <transition name="navItems">
                <div v-if="showOrder" class="bg-gray-600 text-white text-center py-2">
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/orders">New Orders
                        <div class="float-left px-3 text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                            </svg>
                        </div>
                        <span class="position-absolute left-10 translate-middle badge rounded-pill bg-danger">
                            {{ orderCount > 100 ? '+99' : orderCount }}
                            <span class="visually-hidden">orderCount</span>
                        </span>
                    </inertia-link>
                    <hr>
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/orders/checked">Prepared Orders
                        <div class="float-left px-3">
                            <fa icon="truck" />
                        </div>
                        <span class="position-absolute left-10 translate-middle badge rounded-pill bg-danger">
                            {{ doneOrder > 100 ? '+99' : doneOrder }}
                            <span class="visually-hidden">doneOrder</span>
                        </span>
                    </inertia-link>
                    <hr>
                    <inertia-link class="block py-3 text-decoration-none hover:bg-gray-200 hover:text-dark" href="/orders/history">Orders Logs
                        <div class="float-left px-3 text-xl">
                            <fa icon="clipboard-check" />
                        </div>
                    </inertia-link>
                </div>
            </transition>
        </div>

    </div>
</template>

<script>

export default {
    props: ['isAdmin', 'display', 'orderCount', 'doneOrder'],
    methods: {
        Admin(){
            this.$store.commit("Admin")
        },
        Prod(){
            this.$store.commit("Prod")
        },
        Cat(){
            this.$store.commit("Cat")
        },
        SCat(){
            this.$store.commit("SCat")
        },
        Car(){
            this.$store.commit("Car")
        },
        Order(){
            this.$store.commit("Order")
        },
    },
    computed: {
        showAdmin (){
            return this.$store.state.showAdmin;
        },
        showProd (){
            return this.$store.state.showProd;
        },
        showCat (){
            return this.$store.state.showCat;
        },
        showSCat (){
            return this.$store.state.showSCat;
        },
        showCar (){
            return this.$store.state.showCar;
        },
        showOrder (){
            return this.$store.state.showOrder;
        },
    }
}
</script>

<style>
    .navItems-enter-active{
        transition:  all ease-in-out 0.4s;
    }

    .navItems-enter-from,
    .navItems-leave-to{
        transform: translateX(50px);
        opacity: 0;
    }

    .closed{
        transition: all 0.1s;
    }

    .opened{
        transform: rotate(90deg);
        transition: all 0.1s;
    }
    #scrollbar::-webkit-scrollbar {
        width: 0;
    }
    .hvr-bounce-to-left:before{
        background-color: #F59E0B;
    }
    .top{
        top: 66px
    }
</style>
