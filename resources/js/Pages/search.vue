<template>
  <div class="container-fluid px-0 bg-gray-700">

    <pageTitle :title="'بحث عن:' + $store.state.search" />
    <nav-bar :logged="auth.user" />
    <p v-if="success" class="text-xl text-gray-400 bg-gray-800 rounded-lg text-center p-3 w-8/12 mx-auto my-3">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 animate-bounce inline md:float-right text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      {{success}}
    </p>
    <div v-if="searched.total > 0">
      <div class="w-40">
        <p class="text-lg text-gray-400 mr-5 my-7 bg-gray-800 p-2 rounded-lg">عدد السلع: &nbsp;<span class="text-yellow-400">{{ searched.total }}</span></p>
    </div>
    <div class="grid lg:grid-cols-6 md:grid-cols-4 grid-cols-2 m-3">
      <div dir="ltr" v-for="(prod, index) in searched.data" :key="index" class="hvr-bob card bg-gray-700 border-2 border-gray-400 rounded-lg mx-2 mb-3">
        <card :state='prod.pd_state' :image='prod.images[0].img_url' :pd_price='prod.pd_price' :products_id='prod.id' :pd_name="prod.pd_name" :pd_stack="prod.pd_stack" />
      </div>
    </div>
    <!--  Pagination  -->
    <div v-if="searched" class="flex justify-center my-3">
        <inertia-link v-if="searched.current_page > 2"
            :href="searched.first_page_url">
            <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                <fa icon="angle-double-right" />
            </span>
        </inertia-link>
        <pagination :links="searched.links" />
        <inertia-link v-if="searched.current_page < searched.last_page - 2"
            :href="searched.last_page_url">
            <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                <fa icon="angle-double-left" />
            </span>
        </inertia-link>
    </div>
    </div>
    <whatsapp />
    <Footer />
  </div>
</template>

<script>
    import card from '@/Layouts/Template/Card'
    import navBar from '@/Layouts/Template/nav'
    import pagination from '../Layouts/pagination'
    import Footer from '@/Layouts/Template/footer'
    import whatsapp from '@/Layouts/Template/whatsapp'
    import pageTitle from "../Layouts/Template/pageTitle";

export default {
    components:{
        card,
        navBar,
        pagination,
        Footer,
        whatsapp,
        pageTitle,
    },
    props: {
        searched: Object,
        success: null,
        auth: Object,
    },
}
</script>

<style scoped>
  .headers::before,.headers::after{
    content: "";
    flex: 1 1;
    border-bottom: 2px solid #a7a7a7;
    margin: 20px;
    opacity: .3;
  }
</style>
