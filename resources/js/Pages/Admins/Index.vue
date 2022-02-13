<template>
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">
                <pageTitle title="المشرفين" />
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 table-responsive">
                    <Title text="المشرفين" />

                    <div class="float-right mx-3 my-3">
                        <inertia-link href="/register" type="submit" class="btn btn-outline-primary text-white float-left px-3 flex">
                            <fa icon="user-plus" class="text-xl" />
                            <span class="mx-2">اضافة مشرف</span>
                        </inertia-link>
                    </div>
                    <div class="float-left mx-3 my-3">
                        <inertia-link href="/logs" type="submit" class="btn btn-outline-success text-white float-left px-3 flex">
                            <fa icon="clipboard-list" class="text-xl" />
                            <span class="mx-2">سجل الشرفين</span>
                        </inertia-link>
                    </div>

                    <div v-if="admins.data.length > 0">

                        <div class="">
                            <table class="table table-dark table-hover table-striped text-center text-white table-fixed align-middle">
                                <thead>
                                    <tr class="text-muted">
                                        <th>
                                            <p class="flex justify-center">
                                                الاسم
                                            </p>
                                        </th>
                                        <th>
                                            <p class="flex justify-center">
                                                البريد الالكتروني
                                            </p>
                                        </th>
                                        <th>
                                            <p class="flex justify-center">
                                                تاريخ الاضافة
                                            </p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="admin in admins.data" :key="admin.id" @click="selectAdmin(admin.id)" class="cursor-pointer">
                                        <th class="truncate font-light text-sm">{{ admin.name }}</th>
                                        <th class="truncate font-light text-sm">{{ admin.email }}</th>
                                        <th class="truncate tracking-widest font-light text-sm">{{ moment(admin.created_at).format('YYYY/MM/DD') }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--  Pagination  -->
                        <div v-if="admins" class="flex justify-center my-3">
                            <inertia-link v-if="admins.current_page > 2"
                                :href="admins.first_page_url">
                                <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                                    <fa icon="angle-double-right" />
                                </span>
                            </inertia-link>
                            <pagination :links="admins.links" />
                            <inertia-link v-if="admins.current_page < admins.last_page - 2"
                                :href="admins.last_page_url">
                                <span class="rounded-2 px-2 py-1 text-white ml-1 hover:bg-red-900 bg-red-600">
                                    <fa icon="angle-double-left" />
                                </span>
                            </inertia-link>
                        </div>
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
            admins: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
        },
        methods:{
            selectAdmin(e){
                Inertia.visit(`/admins/${e}/edit`)
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
