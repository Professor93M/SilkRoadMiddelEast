<template>
    <pageTitle title="الطلبات الجاهزة" />
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 table-responsive">
                    <Title text="الطلبات الجاهزة" />

                    <div v-if="orders" class="border border-white">
                        <table class="table table-dark table-hover table-striped text-center text-white table-fixed align-middle">
                            <thead>
                                <tr class="text-muted">
                                    <th>
                                        <td class="flex justify-center">رمز الطلب</td>
                                    </th>
                                    <th>
                                        <td class="flex justify-center">الاسم</td>
                                    </th>
                                    <th>
                                        <td class="flex justify-center">رقم الهاتف</td>
                                    </th>
                                    <th>
                                        <td class="flex justify-center">المحافظة</td>
                                    </th>
                                    <th>
                                        <td class="flex justify-center">تاريخ الطلب</td>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="order in orders" :key="order.order_id" @click="selectOrder(order.id)" class="cursor-pointer">
                                    <th class="truncate">{{ order.id }}</th>
                                    <th class="truncate text-wrap">{{ order.first_name }} {{ order.last_name }}</th>
                                    <th class="truncate text-wrap">0{{ order.mobile ? order.mobile : order.mobile2 }}</th>
                                    <th class="truncate text-wrap">{{ order.governorate }}</th>
                                    <th class="truncate text-wrap">{{ moment(order.created_at).format('YYYY-MM-DD') }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="flex justify-center mt-4">
                        <h1 class="text-white text-center text-2xl bg-gray-800 w-90 p-3 rounded-lg">
                            لاتوجد طلبات جاهزة
                        </h1>
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
            orders: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
        },
        methods:{
            selectOrder(e){
                Inertia.visit(`/orders/${e}/show`)
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
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
