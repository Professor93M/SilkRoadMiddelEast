<template>
  <pageTitle :title="cat_name" />
  <div class="container-fluid px-0 bg-gray-700">
    <nav-bar :logged="auth.user" />
    <h1 class="headers md:mx-24 flex justify-center text-2xl font-extrabold text-yellow-500 hover:text-gray-300 select-none transition duration-500 font-weight-bolder mt-5">
        {{cat_name}}
    </h1>

    <bread title1='Home' url1="/" :title2="cat_name" active2="active" />

    <div v-if="subCats.data.length > 0" class="flex flex-wrap justify-center">
        <subCats :subCats="subCats" class="m-3" />
    </div>
    <div v-else class="flex justify-center">
        <h1 class="text-white text-center text-2xl bg-gray-800 w-90 p-4 rounded-lg">
            No SubCategories
        </h1>
    </div>
    <whatsapp />
    <Footer />
  </div>
</template>

<script>
    import categories from '@/Layouts/Template/categories'
    import navBar from '@/Layouts/Template/nav'
    import bread from '@/Layouts/Template/bread'
    import pagination from '../../Layouts/pagination'
    import subCats from '../../Layouts/Template/subCats'
    import Footer from '@/Layouts/Template/footer'
    import whatsapp from '@/Layouts/Template/whatsapp'
    import pageTitle from "../../Layouts/Template/pageTitle";

export default {
    components:{
        categories,
        navBar,
        pagination,
        subCats,
        Footer,
        whatsapp,
        pageTitle,
        bread,
    },
    props: {
        subCats: Object,
        cat_name: Object,
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
