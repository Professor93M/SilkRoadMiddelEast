<template>
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">
                <pageTitle title="سجل المستخدمين" />
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 table-responsive">
                    <Title text="سجل المستخدمين" />

                    <div class="mb-3 mx-3 flex justify-end">
                        <!-- <input v-if="search" dir="rtl" placeholder="ابحث بكلمة ..." v-model="params.search" type="search" name="search" class="w-1/2 rounded-lg sm:text-sm bg-gray-600 text-gray-400 border-2 border-gray-400"> -->
                        <button v-if="logs.data.length > 2" @click.prevent="deleteAllUsersLogs()" class="btn btn-outline-danger text-white opacity-70 text-xs  mx-1">حذف الكل &nbsp;<fa icon="trash" /></button>
                        <!-- <inertia-link href="/admins" class="btn btn-outline-primary text-white opacity-70 text-xs float-left mx-1">المشرفين &nbsp;<fa icon="user-friends" /></inertia-link> -->
                    </div>

                    <div v-if="logs.data.length > 0">

                        <div class="border border-white">
                            <table class="table table-dark table-hover table-striped text-center text-white table-fixed align-middle">
                                <thead>
                                    <tr class="text-muted">
                                        <th class="select-none">الحدث</th>
                                        <th>
                                            <p class="select-none">رقم الهاتف</p>
                                        </th>
                                        <th>
                                            <p class="select-none">تاريخ الحدث</p>
                                        </th>
                                        <th class="select-none">حذف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(log, index) in logs.data" :key="index">
                                        <th class="truncate font-light text-yellow-300 text-sm text-right">{{ log.log }}</th>
                                        <th class="truncate font-light text-sm">{{ log.username }}</th>
                                        <th class="truncate font-light text-sm tracking-widest">{{ moment(log.created_at).locale('ar').format('dddd - A ') + moment(log.created_at).format(' hh:mm:ss - YYYY/MM/DD') }}</th>
                                        <th class="truncate font-light text-sm"><button @click="deleteUsersLogs(log.id)" class="btn btn-sm btn-outline-danger text-white opacity-70"><fa icon="trash" /></button></th>
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
                moment,
            }
        },
        props: {
            auth: Object,
            errors: Object,
            success: null,
            logs: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
        },
        methods:{
            deleteUsersLogs(e){
                Inertia.visit(`/orders/${e}/destroy`)
            },
            deleteAllUsersLogs(){
                this.$swal({
                    icon: 'error',
                    text: 'هل تريد فعلاً حذف السجل بالكامل؟',
                    showDenyButton: true,
                    confirmButtonText: `نعم`,
                    denyButtonText: `كلا`,
                    reverseButtons: true,
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Inertia.visit('/orders/destroyall')
                    }
                })
            },
        },
    }
</script>

<style>
    .swal2-popup{
        display: block !important;
    }
</style>
