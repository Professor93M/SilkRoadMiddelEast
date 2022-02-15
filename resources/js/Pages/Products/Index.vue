<template>
    <pageTitle title="All Products" />
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 table-responsive">
                    <Title text="All Products" />

                    <div class="mb-3 mx-3">
                        <input dir="rtl" placeholder="Search ..." v-model="params.search" type="search" name="search" class="w-1/2 placeholder-opacity-50 rounded-lg sm:text-sm bg-gray-600 text-gray-400 border-2 border-gray-400">
                        <inertia-link href="/products/create" type="submit" class="btn btn-outline-primary text-white float-right px-3 flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5V8z"/>
                            </svg>
                            <span class="mx-2 text-xs">Create</span>
                        </inertia-link>
                    </div>

                    <!-- +++++++++ Filter +++++++++ -->

                    <form class="bg-gray-900 rounded my-2">
                        <legend @click="showFilter=!showFilter" title="Filter" class="text-yellow-400 p-1 text-center select-none cursor-pointer bg-gray-800">Filter</legend>
                        <transition name="filter">
                            <fieldset v-if="showFilter" class="flex flex-wrap justify-center">
                                <div class="form-group m-2">
                                    <label for="categories_id" class="block text-left text-white mr-2 mb-2">Category</label>
                                    <select class="form-select bg-gray-600 text-gray-300" name="categories_id" id="categories_id" v-model="filter.category" @change="onChange($event)">
                                        <option disabled selected value="">Select Category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{category.cat_name}}</option>
                                    </select>
                                </div>

                                <div v-if="categorySelected" class="form-group m-2">
                                    <label for="categories" class="block text-left text-white mr-2 mb-2">SubCategory</label>
                                    <select v-if="sub.length > 0 || emptySub" class="form-select bg-gray-600 text-gray-300" v-model="filter.subcat" name="categories" id="Scategories" @change="onChangeSub($event)">
                                        <option disabled value="">Select SubCategory</option>
                                        <option id='selectCat' v-for="cat in sub" :key="cat.id" :selected="cat.id == products.sub_cats_id" :value="cat.id">{{cat.cat_name}}</option>
                                    </select>
                                    <select v-else class="form-select bg-gray-600 text-gray-300" v-model="filter.subcat" name="categories" id="categories" @change="onChangeSub($event)">
                                        <option disabled value="">Select SubCategory</option>
                                        <option v-for="cat in subcat" :key="cat.id" :selected="cat.id == products.sub_cats_id" :value="cat.id">{{cat.cat_name}}</option>
                                    </select>
                                </div>
                                <div v-if="categorySelected" class="m-auto ">
                                    <inertia-link class="bg-red-500 btn w-20 mb-1 text-white" href="/products">الغاء</inertia-link>
                                </div>
                            </fieldset>

                        </transition>
                    </form>

                    <!-- +++++++++ End Filter +++++++++ -->

                    <div v-if="products.data.length > 0" class="border border-white">
                        <table class="table table-hover table-striped text-center text-white table-fixed align-middle">
                            <thead>
                                <tr class="text-gray-300 bg-gray-500">
                                    <th>
                                        <inertia-link class="flex justify-center hover:text-yellow-500" href="#" @click="sort('pd_name')">Name
                                            <svg v-if="params.field === 'pd_name' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                            </svg>

                                            <svg v-if="params.field === 'pd_name' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                            </svg>
                                        </inertia-link>
                                    </th>
                                    <th>
                                        <inertia-link class="flex justify-center hover:text-yellow-500" href="#" @click="sort('categories_id')">Category
                                            <svg v-if="params.field === 'categories_id' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                            </svg>

                                            <svg v-if="params.field === 'categories_id' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                            </svg>
                                        </inertia-link>
                                    </th>
                                    <th>
                                        <inertia-link class="flex justify-center hover:text-yellow-500" href="#" @click="sort('sub_cats_id')">SubCategory
                                            <svg v-if="params.field === 'sub_cats_id' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                            </svg>

                                            <svg v-if="params.field === 'sub_cats_id' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                            </svg>
                                        </inertia-link>
                                    </th>
                                    <th>
                                        <inertia-link class="flex justify-center hover:text-yellow-500" href="#" @click="sort('company')">company
                                            <svg v-if="params.field === 'company' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                            </svg>

                                            <svg v-if="params.field === 'company' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                            </svg>
                                        </inertia-link>
                                    </th>
                                    <th class="select-none">Price</th>
                                    <th>
                                        <inertia-link class="flex justify-center hover:text-yellow-500" href="#" @click="sort('pd_stack')">Qty
                                            <svg v-if="params.field === 'pd_stack' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                            </svg>

                                            <svg v-if="params.field === 'pd_stack' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                            </svg>
                                        </inertia-link>
                                    </th>
                                    <th>
                                        <inertia-link class="flex justify-center hover:text-yellow-500" href="#" @click="sort('pd_state')">Special
                                            <svg v-if="params.field === 'pd_state' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                            </svg>

                                            <svg v-if="params.field === 'pd_state' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                            </svg>
                                        </inertia-link>
                                    </th>
                                    <th>
                                        <inertia-link class="flex justify-center hover:text-yellow-500" href="#" @click="sort('created_at')">Created at
                                            <svg v-if="params.field === 'created_at' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                            </svg>

                                            <svg v-if="params.field === 'created_at' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                            </svg>
                                        </inertia-link>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in products.data" :key="product.id" @click="selectProduct(product.id)" class="cursor-pointer text-white" :class="[product.pd_stack <= 0 ? 'bg-red-900 mix-blend-difference' : '', index % 2 === 0 ? 'bg-gray-600' : 'bg-gray-800']">
                                    <th class="text-yellow-300 font-light">{{ product.pd_name }}</th>
                                    <th class="font-light">{{ getCat(product.categories_id) }}</th>
                                    <th class="font-light">{{ getSCat(product.sub_cats_id) }}</th>
                                    <th class="font-light">{{ product.company }}</th>
                                    <th class="font-light">{{ Number(product.pd_price).toLocaleString('en') }} $</th>
                                    <th class="font-light">{{ product.pd_stack }}</th>
                                    <th class="text-green-400 font-light" v-if="product.pd_state === 1 ">Special</th>
                                    <th class="text-red-400 font-light" v-else>Not Special</th>
                                    <th class="font-light">{{ moment(product.created_at).format('YYYY-MM-DD') }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="text-center mt-5">
                        <h1 class="text-white text-4xl my-4">No Products</h1>
                    </div>
                    <!--  Pagination  -->
                    <div v-if="products" class="flex justify-center my-3">
                        <inertia-link v-if="products.current_page > 2"
                            :href="products.first_page_url">
                            <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                                <fa icon="angle-double-left" />
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
    import { pickBy, throttle } from 'lodash'
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
                params:{
                    search: this.filters.search,
                    field: this.filters.field,
                    direction: this.filters.direction
                },
                filter:{
                    category: this.filters.category,
                    subcat: this.filters.subcat,
                },
                moment,
                sub: '',
                categorySelected: false,
                showFilter: false
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
            getSCat(e){
                for (let i=0;i < this.subcat.length;i++){
                    if(this.subcat[i].id == e){
                        return this.subcat[i].cat_name
                    }
                }
            },
            sort(field){
                this.params.field = field
                this.params.direction = this.params.direction === 'asc' ? 'desc' : 'asc'
            },
            onChange(e){
                this.categorySelected = true
                this.sub = []
                this.products.categories_id = e.target.options[e.target.options.selectedIndex].value
                let index = 0
                for(let i=0;i < this.subcat.length;i++){
                    if(this.subcat[i].categories_id == this.products.categories_id){
                        this.sub[index] = this.subcat[i]
                        index++
                    }
                }
                if(this.sub.length > 0){
                    this.products.sub_cats_id = this.sub[0].id
                }else{
                    this.products.sub_cats_id = null
                    this.emptySub = true
                }
            },
            onChangeSub(e){
                this.products.sub_cats_id = e.target.options[e.target.options.selectedIndex].value
            },
        },watch:{
            params:{
                handler: throttle(function () {
                    let params = pickBy(this.params);
                    this.$inertia.get('/products', params, {replaces: true, preserveState: true})
                },10),
                deep:true,
            },
            filter:{
                handler: throttle(function () {
                    let filter = pickBy(this.filter);
                    this.$inertia.get('/products', filter, {replaces: true, preserveState: true})
                },10),
                deep:true,
            }
        },
        props: {
            auth: Object,
            errors: Object,
            products: Object,
            categories: Object,
            subcat: Object,
            filters: Object,
            filt: Object,
            success: null,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
        },
        mounted(){
            if(this.success){
                this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: 'success',
                    text: this.success,
                })
            }
        },
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
