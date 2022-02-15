<template>
    <div class="container-fluid px-0 bg-gray-700">
        <pageTitle :title="product.pd_name" />

        <navBar :logged="auth.user" />
        <div class="bg-gray-700 grid md:grid-cols-2 grid-cols-1 font-extrabold">
            <div class="mx-4 mt-5">
                <div id="divide" class="text-right mr-3 pr-3">
                    <h1 class="text-2xl text-gray-400 font-black mb-3">{{ product.pd_name }}</h1>
                    <div class="flex items-center">
                        <inertia-link :href="`/category/${product.categories_id}`" class="bg-yellow-400 text-xs rounded-md px-3 py-1 text-gray-800 hover:text-gray-100 hover:bg-gray-800 transition ease-in-out duration-300">{{ cat_name.cat_name }}</inertia-link>
                        <span class="text-2xl font-medium text-gray-300 mx-2">/</span>
                        <inertia-link :href="`/subcats/${product.sub_cats_id}`" class="bg-blue-400 text-xs rounded-md px-3 py-1 text-gray-800 hover:text-gray-100 hover:bg-gray-800 transition ease-in-out duration-300">{{ subcat_name.cat_name }}</inertia-link>
                    </div>
                </div>

                <!-- Copy URl -->
                <span @click="copyURL" title="Copy Product URL" class="bg-gray-800 rounded-lg text-gray-400 p-2 mr-3 select-none cursor-pointer hover:text-yellow-500 transition duration-700">
                    <fa icon="link" class="text-xs ml-2" />
                    <span id="copied" class="text-xs">Copy Product URL</span>
                </span>

                <!-- Review -->
                <a v-if="product.review" :href="product.review" target="_blank" class="mr-3 inline-block mt-3 text-gray-400 bg-gray-800 rounded-lg p-2 hover:text-yellow-500 transition duration-700 select-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-youtube text-red-600 inline" viewBox="0 0 16 16">
                        <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
                    </svg>
                    <p class="mr-2 inline text-xs">Review</p>
                </a>

                <!-- Description -->

                <div class="relative pt-3">
                    <span class="absolute bg-gray-700 px-3 text-gray-500 pos">Description</span>
                    <div class="shadow-lg p-3 m-3 border-2 border-gray-400 border-opacity-20 text-gray-400 font-normal rounded-lg leading-loose whitespace-pre-wrap">
                        {{ product.pd_description }}
                    </div>
                </div>

                <!-- Price -->

                <div class="text-gray-400 text-center my-5 flex justify-center text-xl font-light antialiased">
                    <p class="text-3xl tracking-widest text-yellow-500 px-2 font-extrabold">{{Number(product.pd_price).toLocaleString('en-US')}}<span class="text-base text-gray-400 px-2">USD</span></p>  $
                </div>

                <!-- Tags -->

                <div class="my-3 mr-3 opacity-90 select-none">
                    <span v-if="product.pd_stack > 0" class="bg-green-500 text-gray-900 font-light rounded-lg ml-2 px-2 py-1">Available</span>
                    <span v-else class="bg-red-500 text-white font-light rounded-lg ml-2 px-2 py-1">Unavailable</span>
                    <span v-if="product.pd_state === 1" class="bg-yellow-500 text-gray-800 font-light rounded-lg ml-3 px-2 py-1">Special</span>
                </div>
            </div>

            <div class="grid my-4 mx-5 justify-center max-h-screen">
                <img loading="lazy" @click="showImage" id="imgP" :src="'images/' + product.cover" class="max-h-80 img-thumbnail mx-auto cursor-pointer" />
                <div id="scrollbar" class="flex items-center overflow-y-hidden border-2 border-gray-400 border-opacity-20 max-h-40 h-32 mt-3">
                    <img loading="lazy" @click="imgPreview(img)" v-for="(img, index) in product.images" :key="index" :src="'images/' + img.img_url" class="mx-2 max-h-24 transition duration-300 ease-in-out transform hover:scale-110 motion-reduce:transform-none cursor-pointer" >
                </div>

                <div class="flex justify-center items-center pt-2">
                    <div v-if="$store.state.like.find(e=>e==product.id)" @click='likes(product.id)' class="btn btn-sm btn-outline-secondary border mx-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mx-1 text-red-500 transtion duration-500 cursor-pointer" fill='#EF4444' viewBox="0 0 24 24" stroke='currentColor'>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <div v-else @click='likes(product.id)' class="btn btn-sm btn-outline-secondary border flex items-center mx-1">
                        <span class="text-gray-400">Add to Favorite</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mx-1 text-red-500 cursor-pointer transtion duration-500" fill='none' viewBox="0 0 24 24" stroke='currentColor'>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>

                    <div v-if="product.pd_stack">
                        <div v-if="$store.state.cart.find(e=>e==product.id)" @click="cart(product.id)" class="btn btn-sm btn-outline-secondary border mx-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mx-1 text-yellow-200 hover:text-gray-300 cursor-pointer transtion duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div v-else @click="cart(product.id)" class="btn btn-sm btn-outline-secondary border flex items-center mx-1">
                            <span class="text-gray-400">Add to Cart</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mx-1 text-gray-400 hover:text-gray-100 cursor-pointer transtion duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <p v-else class="text-yellow-500 border py-1 px-2 rounded-md mx-2 cursor-default select-none">Empty</p>
                </div>

            </div>
        </div>

        <Title text="Related" />
        <div class="flex justify-center items-center">
            <span @click="newRight" class="carousel-control-next-icon flex opacity-50 hover:opacity-100 cursor-pointer"></span>
            <div id="newSlider" class="flex flex-nowrap w-4/5 scroll overflow-auto mx-0 my-3 rounded-lg p-3 shadow-2xl bg-gray-800">
                <div dir="ltr" v-for="(prod, index) in others" :key="index" class="hvr-bob card bg-gray-700 border-2 border-gray-400 rounded-lg mx-2 lg:min-w-20 md:min-w-30 min-w-50 md:max-w-18">
                <Card :state='prod.pd_state' :image='prod.cover' :pd_price='prod.pd_price' :products_id='prod.id' :pd_name="prod.pd_name" :pd_stack="prod.pd_stack" />
                </div>
            </div>
            <span @click="newLeft" class="carousel-control-prev-icon flex opacity-50 hover:opacity-100 cursor-pointer"></span>
        </div>

        <Title text="Others" />
        <div class="flex justify-center items-center">
            <span @click="othRight" class="carousel-control-next-icon flex opacity-50 hover:opacity-100 cursor-pointer"></span>
            <div id="othSlider" class="flex flex-nowrap w-4/5 scroll overflow-auto mx-0 my-3 rounded-lg p-3 shadow-2xl bg-gray-800">
                <div dir="ltr" v-for="(prod, index) in products" :key="index" class="hvr-bob card bg-gray-700 border-2 border-gray-400 rounded-lg mx-2 lg:min-w-20 md:min-w-30 min-w-50 md:max-w-18">
                <Card :state='prod.pd_state' :image='prod.cover' :pd_price='prod.pd_price' :products_id='prod.id' :pd_name="prod.pd_name" :pd_stack="prod.pd_stack" />
                </div>
            </div>
            <span @click="othLeft" class="carousel-control-prev-icon flex opacity-50 hover:opacity-100 cursor-pointer"></span>
        </div>

        <Footer />
    </div>
</template>

<script>
    import navBar from '@/Layouts/Template/nav'
    import Footer from '@/Layouts/Template/footer'
    import Card from '@/Layouts/Template/Card'
    import pageTitle from "../Layouts/Template/pageTitle";
    import Title from "../Layouts/Template/titles";

export default {
    components:{
        navBar,
        Footer,
        Card,
        pageTitle,
        Title,
    },
    props:{
        cat_name: String,
        subcat_name: String,
        product: Object,
        others: Object,
        products: Object,
        auth: Object,
    },
    methods:{
        imgPreview(img){
            document.getElementById('imgP').setAttribute('src', 'images/' + img.img_url)
        },
        likes(id){
            if(!this.$store.state.like.includes(id.toString()) && !this.$store.state.like.includes(id)){
                this.$store.state.like.push(id.toString())
                localStorage['likes' + id] = id.toString()
            }else{
                localStorage.removeItem('likes' + id)
                this.$store.state.like.splice(this.$store.state.like.indexOf(id.toString()), 1)
            }
        },
        cart(id){
            if(!this.$store.state.cart.includes(id.toString()) && !this.$store.state.cart.includes(id)){
                this.$store.state.cart.push(id.toString())
                localStorage['carts' + id] = id.toString()
            }else{
                localStorage.removeItem('carts' + id)
                this.$store.state.cart.splice(this.$store.state.cart.indexOf(id.toString()), 1)
            }
        },
        showImage(){
            if(document.getElementById('imgP').src){
                this.$swal({
                    imageUrl: document.getElementById('imgP').src,
                    showConfirmButton: false,
                    padding: '0 1em',
                })
            }
        },
        copyURL(){
            const URL = window.location.href
            navigator.clipboard.writeText(URL)
            let old = document.getElementById('copied').innerHTML
            document.getElementById('copied').innerHTML = "Copied &#10004;&#65039;"
            setTimeout(() => {
                document.getElementById('copied').innerHTML = old
            }, 5000)
        },
        newRight(){
            document.getElementById('newSlider').scrollLeft += 500
        },
        newLeft(){
            document.getElementById('newSlider').scrollLeft -= 500
        },
        othRight(){
            document.getElementById('othSlider').scrollLeft += 500
        },
        othLeft(){
            document.getElementById('othSlider').scrollLeft -= 500
        },
    },
    mounted() {
        let keys = Object.keys(localStorage);
        if(this.$store.state.like.length === 0 ){
            for(let key of keys) {
                if(key.substring(0,5) === 'likes'){
                    this.$store.state.like.push(localStorage.getItem(key));
                }
            }
        }
        if(this.$store.state.cart.length === 0 ){
            for(let key of keys) {
                if(key.substring(0,5) === 'carts'){
                    this.$store.state.cart.push(localStorage.getItem(key));
                }
            }
        }
    },
    metaInfo: {
    title: 'Posts',
    meta: [
      {
        key: 'og:title',
        name: 'og:title',
        content: 'timdeschryver.dev - posts',
      },
      {
        key: 'twitter:title',
        name: 'twitter:title',
        content: 'timdeschryver.dev - posts',
      },
    ]
    }
}
</script>

<style>
    #divide::after{
        content: '';
        display: block;
        width: 80px;
        border-top: 2px solid #e7e7e7;
        margin: 1rem 0 1.25rem;
        opacity: .4;
    }
    .scroll{
        -ms-overflow-style: none;
        scrollbar-width: none;
        scroll-behavior: smooth;
        -ms-overflow-style: none;
    }

    .scroll::-webkit-scrollbar {
        display: none;
    }
    #scrollbar::-webkit-scrollbar {
        height: 0.5em;
    }

    #scrollbar::-webkit-scrollbar-track {
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    #scrollbar::-webkit-scrollbar-thumb {
        background-color: darkgrey;
        outline: 1px solid rgb(218, 220, 221);
    }
    .swal2-popup{
        display: block !important;
    }
    .swal2-container.swal2-center>.swal2-popup{
        justify-content: center !important;
    }
    .pos{
        top: 20px;
        right: 25px;
    }
</style>
