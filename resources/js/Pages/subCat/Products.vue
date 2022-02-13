<template>
    <pageTitle v-if="!fromDash" :title="subcat" />
    <pageTitle v-else title="السلع المميزة" />
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 table-responsive">
                    <Title v-if="!fromDash" :text="subcat" />
                    <Title v-else text="السلع المميزة" />

                    <div class="mx-3">
                        <inertia-link href="/products/create" type="submit" class="btn btn-outline-primary text-white float-left px-3 my-2 flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5V8z"/>
                            </svg>
                            <span class="mx-2 text-xs">اضافة سلع</span>
                        </inertia-link>
                    </div>

                    <div v-if="products.data.length > 0" class="border border-white">
                        <table class="table table-hover table-striped text-center text-white table-fixed align-middle">
                            <thead>
                                <tr class="text-gray-200 bg-gray-500">
                                    <th class="select-none">اسم السلعة</th>
                                    <th class="select-none">القسم الرئيسي</th>
                                    <th class="select-none">القسم الفرعي</th>
                                    <th class="select-none">السعر</th>
                                    <th class="select-none">المخزون</th>
                                    <th class="select-none">مميز</th>
                                    <th class="select-none">تاريخ الاضافة</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in products.data" :key="product.id" @click="selectProduct(product.id)" class="cursor-pointer text-white"  :class="[product.pd_stack <= 0 ? 'bg-red-900 mix-blend-difference' : '', index % 2 === 0 ? 'bg-gray-600' : 'bg-gray-800']">
                                    <th class="text-yellow-300 font-light">{{ product.pd_name }}</th>
                                    <th class="font-light">{{ getCat(product.categories_id) }}</th>
                                    <th v-if="!fromDash" class="font-light">{{ subcat }}</th>
                                    <th v-else class="font-light">{{ subcat[index].cat_name }}</th>
                                    <th class="font-light">{{ Number(product.pd_price).toLocaleString('en') }} $</th>
                                    <th class="font-light">{{ product.pd_stack }}</th>
                                    <th class="text-green-400 font-light" v-if="product.pd_state === 1 ">مميز</th>
                                    <th class="text-red-400 font-light" v-else>غير مميز</th>
                                    <th class="font-light">{{ moment(product.created_at).format('YYYY-MM-DD') }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="text-center mt-5">
                        <h1 class="text-white text-4xl my-4">لاتوجد سلع تطابق المحدد</h1>
                        <!-- <inertia-link class="lead text-decoration-none text-blue-300 hover:text-yellow-400 transition duration-500" href="/products/create">اضغط هنا لاضافة سلع جديده</inertia-link> -->
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
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Auth/Authenticated'
    import sideBar from "../../Layouts/Template/navbar"
    import {Inertia} from "@inertiajs/inertia"
    import pagination from '../../Layouts/pagination'
    import moment from 'moment'
    import 'moment/min/locales'
    import Title from "../../Layouts/Template/titles";
    import pageTitle from "../../Layouts/Template/pageTitle";

    export default {
        components: {
            BreezeAuthenticatedLayout,
            sideBar,
            pagination,
            moment,
            Title,
            pageTitle,
        },
        data(){
            return{
                success: null,
                moment,
            }
        },
        methods:{
            selectProduct(e){
                Inertia.visit(`/products/${e}/edit`)
            },
            getCat(e){
                for (let i=0;i < this.categories.length;i++){
                    if(this.categories[i].id == e){
                        return this.categories[i].cat_name
                    }
                }
            },
        },
        props: {
            auth: Object,
            errors: Object,
            products: Object,
            categories: Object,
            subcat: Object,
            success: null,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
            fromDash: Boolean,
        },
        mounted(){
            if(this.success){
                this.$swal({
                    toast: true,
                    position: 'top-start',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: 'success',
                    text: this.success,
                })
            }
        }
    }
</script>

<style>
    .filter-enter-active{
        transition:  all ease-out 0.6s;
    }

    .filter-leave-active{
        transition:  all ease-in 0.6s;
    }

    .filter-enter-from,
    .filter-leave-to{
        transform: translateY(-50px);
        opacity: 0;
    }

</style>
