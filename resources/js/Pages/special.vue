<template>
  <div class="container-fluid px-0 bg-gray-700">
    <pageTitle title="Special" />
    <nav-bar :logged="auth.user" />
    <h1 class="headers md:mx-24 flex justify-center text-2xl font-extrabold text-yellow-500 hover:text-gray-300 select-none transition duration-500 font-weight-bolder my-5">
        Special
    </h1>
    <div v-if="special.data.length > 0">
      <div class="grid lg:grid-cols-6 md:grid-cols-4 grid-cols-2 m-3">
        <div dir="ltr" v-for="(prod, index) in special.data" :key="index" class="hvr-bob card bg-gray-700 border-2 border-gray-400 rounded-lg mx-2 mb-3">
          <card :state='prod.pd_state' :image='prod.images[0].img_url' :pd_price='prod.pd_price' :products_id='prod.id' :pd_name="prod.pd_name" :pd_stack="prod.pd_stack" />
        </div>
      </div>
    </div>
    <div v-else class="flex justify-center">
        <h1 class="text-white text-center text-2xl bg-gray-800 w-90 p-4 rounded-lg">
            No Products
        </h1>
    </div>
      
    <!--  Pagination  -->
    <div v-if="special" class="flex justify-center my-3">
        <inertia-link v-if="special.current_page > 2"
            :href="special.first_page_url">
            <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                <fa icon="angle-double-right" />
            </span>
        </inertia-link>
        <pagination :links="special.links" />
        <inertia-link v-if="special.current_page < special.last_page - 2"
            :href="special.last_page_url">
            <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                <fa icon="angle-double-left" />
            </span>
        </inertia-link>
    </div>
    <Footer />
  </div>
</template>

<script>
    import card from '@/Layouts/Template/Card'
    import navBar from '@/Layouts/Template/nav'
    import pagination from '../Layouts/pagination'
    import Footer from '@/Layouts/Template/footer'
    import pageTitle from "../Layouts/Template/pageTitle";

export default {
    components:{
        card,
        navBar,
        pagination,
        Footer,
        pageTitle,
    },
    props: {
        special: Object,
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
