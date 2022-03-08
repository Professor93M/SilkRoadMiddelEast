<template>
  <div class="container-fluid px-0 bg-gray-700">
    <pageTitle description="Silk Road MiddleEast" title="Home" />
    <nav-bar :logged="auth.user" />
    <vueper-slides v-if="carousel.length > 0" autoplay lazy lazy-load-on-drag :touchable="false" rtl :dragging-distance="50" arrows-outside progress fixed-height="600px" :bullets="false" class="mt-2 mx-5 px-2 border-2 border-gray-400 border-opacity-40 rounded-lg">
      <vueper-slide v-for="(car, i) in carousel" :key="i" :image="'images/' + car.image.img_url" :title="car.title" :link="car.url" :content="car.description">
        <template #loader>
            <i class="spinner-border text-warning"></i>
            <span class="text-gray-300 mt-3">Loading Image</span>
        </template>
      </vueper-slide>
    </vueper-slides>

    <!-- Categories       -->
    <inertia-link as="h1" href="/category" class="headers md:mx-24 flex justify-center text-2xl font-extrabold text-yellow-500 font-weight-bolder mt-12 mb-3 hover:text-gray-300 transition duration-500">
      Categories
    </inertia-link>
    <div v-if="Category.length > 0" class="flex justify-center items-center">
      <span @click="catRight" class="carousel-control-next-icon flex opacity-50 hover:opacity-100 cursor-pointer"></span>
      <div id="catSlider" class="flex flex-nowrap w-4/5 scroll overflow-auto mx-0 my-3 rounded-lg p-3 shadow-2xl bg-gray-800">
        <div v-for="(cat, index) in Category" :key="index">
          <subcat :cat_id="cat.id" :cat_name="cat.cat_name" :img="cat.image.img_url" url="category" />
        </div>
      </div>
      <span @click="catLeft" class="carousel-control-prev-icon flex opacity-50 hover:opacity-100 cursor-pointer"></span>
    </div>
    <h1 v-else class="text-yellow-400 font-bold text-2xl text-center bg-gray-900 rounded-lg p-2 mx-auto w-5/6">No Categories</h1>

     <!-- Newiest -->
    <inertia-link as="h1" href="/product" class="headers md:mx-24 flex justify-center text-2xl font-extrabold text-yellow-500 font-weight-bolder mt-16 mb-3 hover:text-gray-300 transition duration-500">
      Newiest
    </inertia-link>
    <div v-if="ProdLastest.length > 0" class="flex justify-center items-center">
      <span @click="newRight" class="carousel-control-next-icon flex opacity-50 hover:opacity-100 cursor-pointer"></span>
      <div id="newSlider" class="flex flex-nowrap w-4/5 scroll overflow-auto mx-0 my-3 rounded-lg p-3 shadow-2xl bg-gray-800">
        <div dir="ltr" v-for="(prod, index) in ProdLastest" :key="index" class="hvr-bob bg-gray-700 border-2 border-gray-400 rounded-lg mx-2 min-w-60 md:min-w-40 lg:min-w-20 max-w-30 md:max-w-20">
          <Card :state='prod.pd_state' :image='prod.cover' :pd_price='prod.pd_price' :products_id='prod.id' :pd_name="prod.pd_name" :pd_stack="prod.pd_stack" />
        </div>
      </div>
      <span @click="newLeft" class="carousel-control-prev-icon flex opacity-50 hover:opacity-100 cursor-pointer"></span>
    </div>
    <h1 v-else class="text-yellow-400 font-bold text-2xl text-center bg-gray-900 rounded-lg p-2 mx-auto w-5/6">No Products</h1>

    <!-- Special       -->
    <inertia-link as="h1" href="/special" class="headers md:mx-24 flex justify-center text-2xl font-extrabold text-yellow-500 font-weight-bolder mt-16 mb-3 hover:text-gray-300 transition duration-500">
      Special
    </inertia-link>
    <div v-if="Special.length > 0" class="flex justify-center items-center">
      <span @click="cardRight" class="carousel-control-next-icon flex opacity-50 hover:opacity-100 cursor-pointer"></span>
      <div id="cardSlider" class="flex flex-nowrap w-4/5 scroll overflow-auto mx-0 my-3 rounded-lg p-3 shadow-2xl bg-gray-800">
        <div dir="ltr" v-for="(prod, index) in Special" :key="index" class="hvr-bob bg-gray-700 border-2 border-gray-400 rounded-lg mx-2 min-w-60 md:min-w-40 lg:min-w-20 max-w-30 md:max-w-20">
          <Card :state='prod.pd_state' :image='prod.cover' :pd_price='prod.pd_price' :products_id='prod.id' :pd_name="prod.pd_name" :pd_stack="prod.pd_stack" />
        </div>
      </div>
      <span @click="cardLeft" class="carousel-control-prev-icon flex opacity-50 hover:opacity-100 cursor-pointer"></span>
    </div>
    <h1 v-else class="text-yellow-400 font-bold text-2xl text-center bg-gray-900 rounded-lg p-2 mx-auto w-5/6">No Products</h1>

    <Footer />
  </div>
</template>

<script>
    import navBar from '@/Layouts/Template/nav'
    import Footer from '@/Layouts/Template/footer'
    import Card from '@/Layouts/Template/Card'
    import subcat from '@/Layouts/Template/subcat'
    import { VueperSlides, VueperSlide } from 'vueperslides'
    import pageTitle from "../Layouts/Template/pageTitle";

export default {
  props:{
    Category: Object,
    ProdLastest: Object,
    Special: Object,
    carousel: Object,
    success: null,
    auth: Object,
  },
  components:{
    navBar,
    Footer,
    Card,
    subcat,
    VueperSlides,
    VueperSlide,
    pageTitle,
  },
  methods:{
    catRight(){
      document.getElementById('catSlider').scrollLeft += 500
    },
    catLeft(){
      document.getElementById('catSlider').scrollLeft -= 500
    },
    cardRight(){
      document.getElementById('cardSlider').scrollLeft += 500
    },
    cardLeft(){
      document.getElementById('cardSlider').scrollLeft -= 500
    },
    newRight(){
      document.getElementById('newSlider').scrollLeft += 500
    },
    newLeft(){
      document.getElementById('newSlider').scrollLeft -= 500
    },
  },
  mounted(){
    if(this.success){
        this.$swal({
            text: this.success,
            icon: 'currect',
            confirmButtonText: 'Submit',
        })
    }
  },
}
</script>

<style >
  .scroll{
    -ms-overflow-style: none;
    scrollbar-width: none;
    scroll-behavior: smooth;
    -ms-overflow-style: none;
  }

  .scroll::-webkit-scrollbar {
    display: none;
  }

  .headers::before,.headers::after{
    content: "";
    flex: 1 1;
    border-bottom: 2px solid #a7a7a7;
    margin: 20px;
    opacity: .3;
  }

  #swal2-content{
    line-height: 30px !important;
  }

  body > div.swal2-container.swal2-rtl.swal2-top-end.swal2-backdrop-show > div{
    display: block !important;
    font-size: 18px
  }

  body > div.swal2-container.swal2-rtl.swal2-top-end.swal2-backdrop-show > div > div.swal2-header{
    display: flex !important;
  }

  .vueperslides__bullet--active .default {color: #F59E0B !important;}
  .vueperslides__arrow {color: #a7a7a7}
  .vueperslide__title{
    font-size: 28px !important;
    color: #F59E0B !important;
    font-weight: bold;
  }

  .vueperslide__content-wrapper{
    justify-content: flex-end !important;
    padding: 20px 0
  }

  .vueperslide__title, .vueperslide__content{
    background-color: #1f2937ce !important;
    padding: 5px;
    color: #fff;
    width: 100%;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    font-size: 20px;
  }

  .vueperslide{
    background-repeat: no-repeat !important;
    background-size: contain !important;
  }

  .vueperslides__progress {
    background: rgba(0, 0, 0, 0.25);
    color: #F59E0B;
  }

  @media screen and (max-width: 800px) {
    .vueperslide__content-wrapper{
      display: none !important;
    }
    .default{
      display: none !important;
    }
    .vueperslides--fixed-height { height: 300px !important; }
  }
</style>
