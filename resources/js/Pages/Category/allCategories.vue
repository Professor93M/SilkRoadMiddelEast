<template>
  <pageTitle title="All Categories" />
  <div class="container-fluid px-0 bg-gray-700">
    <nav-bar :logged="auth.user" />
    <h1 class="headers md:mx-24 flex justify-center text-2xl font-extrabold text-yellow-500 hover:text-gray-300 select-none transition duration-500 font-weight-bolder my-5">
        All Categories
    </h1>
    <div v-if="allCategories.data.length > 0">
      <div class="grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 m-4">
        <div dir="ltr" v-for="(cat, index) in allCategories.data" :key="index" class="bg-gray-700 mx-auto px-3 mb-3 shadow-lg pt-3 rounded-lg">
          <categories url='category' :cat_id="cat.id" :cat_name="cat.cat_name" :img="cat.image.img_url"  />
        </div>
      </div>
    </div>
    <div v-else class="flex justify-center">
        <h1 class="text-white text-center text-2xl bg-gray-800 w-90 p-4 rounded-lg">
            No Categories
        </h1>
    </div>
    <!--  Pagination  -->
    <div v-if="products" class="flex justify-center my-3">
        <inertia-link v-if="products.current_page > 2"
            :href="products.first_page_url">
            <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                <fa icon="angle-double-right" />
            </span>
        </inertia-link>
        <pagination :links="products.links" />
        <inertia-link v-if="products.current_page < products.last_page - 2"
            :href="products.last_page_url">
            <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                <fa icon="angle-double-left" />
            </span>
        </inertia-link>
    </div>
    <Footer />
  </div>
</template>

<script>
    import categories from '@/Layouts/Template/categories'
    import navBar from '@/Layouts/Template/nav'
    import pagination from '../../Layouts/pagination'
    import Footer from '@/Layouts/Template/footer'
    import pageTitle from "../../Layouts/Template/pageTitle";

export default {
    components:{
        categories,
        navBar,
        pagination,
        Footer,
        pageTitle,
    },
    props: {
        allCategories: Object,
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
