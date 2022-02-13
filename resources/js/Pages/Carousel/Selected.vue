<template>
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">
                <pageTitle :title="title ? title : 'Carousels'" />
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 table-responsive">
                    <Title :text="title ? title : 'Carousels'" />

                    <div class="mx-3">
                        <inertia-link href="/carousel/create" type="submit" class="btn btn-outline-primary text-white float-left px-3 my-2 flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-patch-plus-fill" viewBox="0 0 16 16">
                                <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zM8.5 6v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 1 0z"/>
                            </svg>
                            <span class="mx-2">Create</span>
                        </inertia-link>
                    </div>

                    <div v-if="carousel.data.length > 0">

                        <div class="border border-white">
                            <table class="table table-dark table-hover table-striped text-center text-white table-fixed align-middle">
                                <thead>
                                    <tr class="text-muted">
                                        <th class="select-none">Title</th>
                                        <th class="select-none">State</th>
                                        <th class="select-none">Image</th>
                                        <th class="select-none">Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="car in carousel.data" :key="car.id" @click="selectCar(car.id)" class="cursor-pointer">
                                        <th>{{ car.title }}</th>
                                        <th :class="car.state == true ? 'text-green-500' : 'text-red-500'">{{ car.state == true ? "Show" : "Hidden" }}</th>
                                        <th v-if="car.image"><img loading="lazy" :src="'images/' + car.image.img_url" alt="Image" class="mx-auto" width="60" height="60"></th>
                                        <th v-else><img loading="lazy" src="storage/carousel/time.png" alt="Image Unavailable" class="mx-auto" width="60" height="60"></th>
                                        <th>{{ moment(car.created_at).format('YYYY-MM-DD') }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--  Pagination  -->
                        <div v-if="carousel" class="flex justify-center my-3">
                            <inertia-link v-if="carousel.current_page > 2"
                                :href="carousel.first_page_url">
                                <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                                    <fa icon="angle-double-right" />
                                </span>
                            </inertia-link>
                            <pagination :links="carousel.links" />
                            <inertia-link v-if="carousel.current_page < carousel.last_page - 2"
                                :href="carousel.last_page_url">
                                <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                                    <fa icon="angle-double-left" />
                                </span>
                            </inertia-link>
                        </div>
                    </div>
                    <div v-else class="text-center mt-5">
                        <h1 class="text-white text-4xl my-4">No Carousel added</h1>
                        <inertia-link class="lead text-decoration-none text-blue-300 hover:text-yellow-400 transition duration-500" href="/carousel/create">Create</inertia-link>
                    </div>
                </div>
            </div>
        </div>

    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Auth/Authenticated'
    import {Inertia} from "@inertiajs/inertia";
    import pagination from '../../Layouts/pagination'
    import moment from 'moment'
    import Title from "../../Layouts/Template/titles";
    import pageTitle from "../../Layouts/Template/pageTitle";

    export default {
        components: {
            BreezeAuthenticatedLayout,
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
            carousel: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
            title: null,
        },
        methods:{
            selectCar(e){
                Inertia.visit(`/carousel/${e}/edit`)
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
