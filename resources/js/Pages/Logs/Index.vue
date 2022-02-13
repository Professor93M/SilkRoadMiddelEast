<template>
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">
                <pageTitle title="سجل جميع المشرفين" />
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 table-responsive">
                    <Title text="سجل جميع المشرفين" />

                    <div class="mb-3 mx-3" :class="!search ? 'flex justify-end' : ''">
                        <input v-if="search" dir="rtl" placeholder="ابحث بكلمة ..." v-model="params.search" type="search" name="search" class="w-1/2 rounded-lg sm:text-sm bg-gray-600 text-gray-400 border-2 border-gray-400">
                        <button v-if="logs.data.length > 2" @click.prevent="deleteAllLog()" class="btn btn-outline-danger text-white opacity-70 text-xs float-left mx-1">حذف الكل &nbsp;<fa icon="trash" /></button>
                        <inertia-link href="/admins" class="btn btn-outline-primary text-white opacity-70 text-xs float-left mx-1">المشرفين &nbsp;<fa icon="user-friends" /></inertia-link>
                    </div>

                    <div v-if="logs.data.length > 0">

                        <div class="border border-white">
                            <table class="table table-dark table-hover table-striped text-center text-white table-fixed align-middle">
                                <thead>
                                    <tr class="text-muted">
                                        <th class="select-none">الحدث</th>
                                        <th>
                                            <inertia-link v-if="search" class="flex justify-center" href="username" @click="sort('username')">اسم المشرف
                                                <svg v-if="params.field === 'username' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                </svg>

                                                <svg v-if="params.field === 'username' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                </svg>
                                            </inertia-link>
                                            <p v-else class="select-none">اسم المشرف</p>
                                        </th>
                                        <th>
                                            <inertia-link v-if="search" class="flex justify-center" href="#" @click="sort('created_at')">تاريخ الحدث
                                                <svg v-if="params.field === 'created_at' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                </svg>

                                                <svg v-if="params.field === 'created_at' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                </svg>
                                            </inertia-link>
                                            <p v-else class="select-none">تاريخ الحدث</p>
                                        </th>
                                        <th class="select-none">حذف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(log, index) in logs.data" :key="index">
                                        <th class="font-light text-yellow-300 text-sm text-right">{{ log.log }}</th>
                                        <th class="font-light text-sm">{{ log.username }}</th>
                                        <th class="font-light text-sm tracking-widest">{{ moment(log.created_at).locale('ar').format('dddd - A ') + moment(log.created_at).format(' hh:mm:ss - YYYY/MM/DD') }}</th>
                                        <th class="font-light text-sm"><button @click="deleteLog(log.id)" class="btn btn-sm btn-outline-danger text-white opacity-70"><fa icon="trash" /></button></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--  Pagination  -->
                        <div v-if="logs" class="flex justify-center my-3">
                            <inertia-link v-if="logs.current_page > 2"
                                :href="logs.first_page_url">
                                <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                                    <fa icon="angle-double-right" />
                                </span>
                            </inertia-link>
                            <pagination :links="logs.links" />
                            <inertia-link v-if="logs.current_page < logs.last_page - 2"
                                :href="logs.last_page_url">
                                <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                                    <fa icon="angle-double-left" />
                                </span>
                            </inertia-link>
                        </div>
                    </div>
                    <div v-else class="text-center mt-5">
                        <h1 class="text-white text-4xl my-4">السجل فارغ!</h1>
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
    import { pickBy, throttle } from 'lodash';
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
                params:{
                    search: this.filters.search,
                    field: this.filters.field,
                    direction: this.filters.direction
                },
                moment,
            }
        },
        props: {
            auth: Object,
            errors: Object,
            success: null,
            logs: Object,
            filters: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
            search: Boolean,
        },
        methods:{
            deleteLog(e){
                Inertia.delete(`/logs/${e}/destroy`)
            },
            deleteAllLog(){
                this.$swal({
                    icon: 'error',
                    text: 'هل تريد فعلاً حذف السجل بالكامل؟',
                    showDenyButton: true,
                    confirmButtonText: `نعم`,
                    denyButtonText: `كلا`,
                    reverseButtons: true,
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Inertia.delete('/logs/destroyall')
                    }
                })
            },
            sort(field){
                this.params.field = field
                this.params.direction = this.params.direction === 'asc' ? 'desc' : 'asc'
            }
        },watch:{
            params:{
                handler: throttle(function () {
                    let params = pickBy(this.params);
                    this.$inertia.get('/logs', params, {replaces: true, preserveState: true})
                },10),
                deep:true,
            }
        },
    }
</script>

<style>
    .swal2-popup{
        display: block !important;
    }
</style>
