<template>
    <div class="size size2">
        <inertia-link :href="`/product/${products_id}`">
            <div v-if="state ? 'ribbon' : ''" class="ribbon"><span><fa icon="star" class="mx-1 text-xs" />مميز<fa icon="star" class="mx-1 text-xs" /></span></div>
            <span v-if="pd_stack < 1" class="empty bg-gradient-to-b from-gray-600 to-gray-700 rounded-lg text-yellow-500 opacity-80 text-2xl font-extrabold absolute h-44 w-full flex justify-center items-center z-10">نفذت الكمية</span>
            <img loading="lazy" :src="'images/' + image" class="imgEffect card-img-top rounded-lg h-screen max-h-44 image" alt="...">
        </inertia-link>
        <div class="text-center">
            <textarea dir="rtl" name="prodName" id="textarea" rows="3" v-model="pd_name" readonly class="font-medium text-white bg-gray-700 border-0 text-center w-full foucs"></textarea>
            <div class="divide-y-2 divide-opacity-30 divide-gray-400 space-y-1">
                <p dir="rtl" class="text-yellow-500 font-semibold tracking-widest truncate">{{Number(pd_price).toLocaleString('en-US')}} $</p>
                <div class="flex justify-center items-center space-x-5 pt-2">

                    <svg v-if="$store.state.like.find(e=>e==products_id)" @click='likes(products_id)' xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-500 hover:text-red-600 transtion duration-500 cursor-pointer hvr-pulse" fill='#EF4444' viewBox="0 0 24 24" stroke='currentColor'>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <svg v-else @click='likes(products_id)' xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-400 hover:text-red-500 cursor-pointer transtion duration-500 hvr-pulse" fill='none' viewBox="0 0 24 24" stroke='currentColor'>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>

                    <div v-if="pd_stack > 0">
                        <svg v-if="$store.state.cart.find(e=>e==products_id)" @click="cart(products_id)" xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-cart-check font-extrabold text-yellow-200 hover:text-gray-100 cursor-pointer transtion duration-500 hvr-rotate" viewBox="0 0 16 16">
                            <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                        <svg v-else @click="cart(products_id)" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-400 hover:text-gray-100 cursor-pointer transtion duration-500 hvr-rotate" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['state', 'image', 'pd_name', 'products_id', 'pd_price', 'pd_stack'],
    methods:{
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
}
</script>

<style scoped>
    .imgEffect{
        mask-image: linear-gradient(to top, rgba(70, 70, 70, 0) 0%,rgba(70, 70, 70.65) 10%);
        -webkit-mask-image: linear-gradient(to top, rgba(70, 70, 70,0) 0%,rgba(70, 70, 70.65) 10%);
    }
    .ribbon {
        position: absolute;
        left: -5px; top: -5px;
        z-index: 1;
        overflow: hidden;
        width: 75px; height: 75px;
        text-align: right;
        z-index: 20;
    }
    .ribbon span {
        font-size: 14px;
        font-weight: bold;
        color: #FFF;
        text-align: center;
        line-height: 20px;
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
        width: 100px;
        display: block;
        background: #79A70A;
        background: linear-gradient(#F79E05 0%, #8F5408 100%);
        box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
        position: absolute;
        top: 19px; left: -21px;
    }
    .ribbon span::before {
        content: "";
        position: absolute; left: 0px; top: 100%;
        z-index: -1;
        border-left: 3px solid #8F5408;
        border-right: 3px solid transparent;
        border-bottom: 3px solid transparent;
        border-top: 3px solid #8F5408;
    }
    .ribbon span::after {
        content: "";
        position: absolute; right: 0px; top: 100%;
        z-index: -1;
        border-left: 3px solid transparent;
        border-right: 3px solid #8F5408;
        border-bottom: 3px solid transparent;
        border-top: 3px solid #8F5408;
    }
    .image{
        height: 100%;
        width: 100%;
    }
    .size{
        height: 345px;
        width: 100%;
    }
    .empty{
        height: 51%;
    }
    @media screen and (max-width: 800px) {
        .size2{
            height: 345px;
            width: 100%;
        }
    }
    #textarea{
        resize:none;
    }
    #textarea::-webkit-scrollbar {
        display: none;
    }
    .foucs:focus {
        border-color: #4B5563 !important;
        box-shadow: none !important;
    }
</style>
