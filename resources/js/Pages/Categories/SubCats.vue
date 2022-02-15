<template>
    <pageTitle title="SubCategories" />
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 table-responsive">
                    <Title text="SubCategories" />

                    <div class="mx-3">
                        <inertia-link href="/subcat/create" type="submit" class="btn btn-outline-primary text-white float-left px-3 my-2 flex">
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
                                    <th class="select-none">SubCategories</th>
                                    <th class="select-none">Categories</th>
                                    <th class="select-none">Image</th>
                                    <th class="select-none">Created at</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cat in categories.data" :key="cat.cat_id" @click="selectCat(cat.id)" class="cursor-pointer">
                                    <th>{{ cat.cat_name }}</th>
                                    <th>{{ cat_name }}</th>
                                    <th v-if="cat.image"><img loading="lazy" :src="'images/' + cat.image.img_url" alt="Image" class="mx-auto" width="60" height="60"></th>
                                    <th>{{ moment(cat.created_at).format('YYYY-MM-DD') }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="text-center mt-5">
                        <h1 class="text-white text-4xl my-4">No SubCategories added</h1>
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
                moment
            }
        },
        props: {
            auth: Object,
            errors: Object,
            success: null,
            categories: Object,
            cat_name: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
        },
        methods:{
            selectCat(e){
                Inertia.visit(`/subcat/${e}/edit`)
            },
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
