<template>
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <pageTitle title="Dashboard" />
            <div class="grid lg:grid-cols-12 w-full">
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 table-responsive">
                    <Title text="Dashboard" />

                    <div class="grid md:grid-cols-2 grid-cols-1 mx-2 my-5">
                        <!-- Products -->
                        <dashCard title="Products" text1="All Products" :count1="products" link1="/products" text2="Special Products" :count2="speical" link2="/dashboard/products?s=special" text3="Finished Products" :count3="stack" link3="/dashboard/products?s=empty" icon="box-open" link="/products" bgTitle="bg-red-900" class="bg-red-500 text-gray-900" />
                        <!-- Categories -->
                        <dashCard title="Categories" text1="Categories" :count1="categories" link1="/categories" text2="SubCategories" :count2="subCats" link2="/subcat" icon="tags" link="categories" bgTitle="bg-green-900" class="bg-green-500 text-gray-900" />
                        <!-- Carousels -->
                        <dashCard title="Carousel" text1="Shown" :count1="carOn" link1="dashboard/carousel?s=active" text2="Hidden" :count2="carOff" link2="dashboard/carousel?s=inactive" icon="rss" link="carousel" bgTitle="bg-yellow-900" class="bg-yellow-500 text-gray-900" />
                        <!-- Orders -->
                        <dashCard title="Orders" text1="New" :count1="newOrder" link1="/orders" text2="Ready" :count2="doneOrder" link2="orders/checked" text3="Log" :count3="saveOrder" link3="orders/history" icon="shopping-cart" link="orders" bgTitle="bg-blue-900" class="bg-blue-500 text-gray-900" />
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Auth/Authenticated'
    import sideBar from "../Layouts/Template/navbar";
    import Title from "../Layouts/Template/titles";
    import pageTitle from "../Layouts/Template/pageTitle";
    import dashCard from "../Layouts/Template/dashCard";

    export default {
        components: {
            BreezeAuthenticatedLayout,
            sideBar,
            Title,
            pageTitle,
            dashCard,
        },

        props: {
            auth: Object,
            errors: Object,
            isAdmin: null,
            products: Object,
            speical: Object,
            stack: Object,
            categories: Object,
            subCats: Object,
            carOff: Object,
            carOn: Object,
            newOrder: Object,
            doneOrder: Object,
            saveOrder: Object,
            orderCount: null,
            doneOrder: null,
            // bgTitle: null
        },
    }
</script>

