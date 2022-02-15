<template>
  <div class="container-fluid px-0 bg-gray-700">
    <pageTitle title="Favorite" />
    <nav-bar :logged="auth.user" />
    <h1 class="headers md:mx-24 flex justify-center text-2xl font-extrabold text-yellow-500 hover:text-gray-300 select-none transition duration-500 font-weight-bolder my-5">
        Favorite
    </h1>
    <div v-if="$store.state.like.length >= 1">
      <div class="grid lg:grid-cols-6 md:grid-cols-4 grid-cols-2 m-3">
        <div v-show="$store.state.like.find(e=>e==prod.id)" dir="ltr" v-for="(prod, index) in favorite" :key="index" class="hvr-bob card bg-gray-700 border-2 border-gray-400 rounded-lg mx-2 mb-3">
          <card :state='prod.pd_state' :image='prod.images[0].img_url' :pd_price='prod.pd_price' :products_id='prod.id' :pd_name="prod.pd_name" :pd_stack="prod.pd_stack" />
        </div>
      </div>
    </div>
    <div v-else class="flex justify-center">
        <h1 class="text-white text-center text-2xl bg-gray-800 w-90 p-4 rounded-lg">
            No Products
        </h1>
    </div>
    <Footer />
  </div>
</template>

<script>
    import card from '@/Layouts/Template/Card'
    import navBar from '@/Layouts/Template/nav'
    import Footer from '@/Layouts/Template/footer'
    import pageTitle from "../Layouts/Template/pageTitle";

export default {
    components:{
        card,
        navBar,
        Footer,
        pageTitle,
    },
    props: {
        favorite: Object,
        auth: Object,
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
  .headers::before, .headers::after{
    content: "";
    flex: 1 1;
    border-bottom: 2px solid #a7a7a7;
    margin: 20px;
    opacity: .3;
  }
</style>
