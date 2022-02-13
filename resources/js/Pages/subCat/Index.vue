<template>
    <pageTitle title="SubCategories" />
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 table-responsive">
                    <Title text="SubCategories" />

                    <div class="mb-3 mx-3">
                        <input dir="rtl" placeholder="Search ..." v-model="params.search" type="search" name="search" class="w-1/2 placeholder-opacity-50 rounded-lg sm:text-sm bg-gray-600 text-gray-400 border-2 border-gray-400">
                        <inertia-link href="/subcat/create" type="submit" class="btn btn-outline-primary text-white float-left px-3 flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5V4.5z"/>
                            </svg>
                            <span class="mx-2 text-xs">Create</span>
                        </inertia-link>
                    </div>
                    <div v-if="categories.data.length > 0" class="border border-white">
                        <table class="table table-dark table-hover table-striped text-center text-white table-fixed align-middle">
                            <thead>
                                <tr class="text-muted">
                                    <th>
                                        <inertia-link class="flex justify-center" href="#" @click="sort('cat_name')">SubCategories
                                            <svg v-if="params.field === 'cat_name' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                            </svg>

                                            <svg v-if="params.field === 'cat_name' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                            </svg>
                                        </inertia-link>
                                    </th>
                                    <th>
                                        <inertia-link class="flex justify-center" href="#" @click="sort('categories_id')">Categories
                                            <svg v-if="params.field === 'categories_id' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                            </svg>

                                            <svg v-if="params.field === 'categories_id' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                            </svg>
                                        </inertia-link>
                                    </th>
                                    <th>الصورة</th>
                                    <th>
                                        <inertia-link class="flex justify-center" href="#" @click="sort('created_at')">Created at
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
                                <tr v-for="(cat, index) in categories.data" :key="cat.cat_id" @click="selectCat(cat.id)" class="cursor-pointer">
                                    <th>{{ cat.cat_name }}</th>
                                    <th>{{ cat_name[index].cat_name }}</th>
                                    <th v-if="cat.image"><img loading="lazy" :src="'images/' + cat.image.img_url" alt="صورة" class="mx-auto" width="60" height="60"></th>
                                    <th>{{ moment(cat.created_at).format('YYYY-MM-DD') }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="text-center mt-5">
                        <h1 class="text-white text-4xl my-4">No SubCategories</h1>
                        <inertia-link class="lead text-decoration-none text-blue-300 hover:text-yellow-400 transition duration-500" href="/subcat/create">Create</inertia-link>
                    </div>
                    <!--  Pagination  -->
                    <div v-if="categories" class="flex justify-center my-3">
                        <inertia-link v-if="categories.current_page > 2"
                            :href="categories.first_page_url">
                            <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                                <fa icon="angle-double-right" />
                            </span>
                        </inertia-link>
                        <pagination :links="categories.links" />
                        <inertia-link v-if="categories.current_page < categories.last_page - 2"
                            :href="categories.last_page_url">
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
    import sideBar from "../../Layouts/Template/navbar";
    import {Inertia} from "@inertiajs/inertia";
    import pagination from '../../Layouts/pagination'
    import moment from 'moment'
    import { pickBy, throttle } from 'lodash';
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
        data() {
            return {
                params:{
                    search: this.filters.search,
                    field: this.filters.field,
                    direction: this.filters.direction
                },
                moment
            }
        },
        props: {
            auth: Object,
            errors: Object,
            success: null,
            categories: Object,
            cat_name: Object,
            filters: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
        },
        methods:{
            selectCat(e){
                Inertia.visit(`/subcat/${e}/edit`)
            },
            sort(field){
                this.params.field = field
                this.params.direction = this.params.direction === 'asc' ? 'desc' : 'asc'
            }
        },watch:{
            params:{
                handler: throttle(function () {
                    let params = pickBy(this.params);
                    this.$inertia.get('/subcat', params, {replaces: true, preserveState: true})
                },10),
                deep:true,
            }
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

<style >
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>
