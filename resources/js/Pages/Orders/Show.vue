<template>
    <pageTitle :title="'حساب ' + cart.first_name + ' ' + cart.last_name" />
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 table-responsive">
                    <h3 class="my-3 text-white text-2xl pb-3 pr-3 text-center border-b-2 border-gray-500">حساب <span class="text-yellow-500">{{ cart.first_name }} {{ cart.last_name }}</span></h3>

                    <div class="flex justify-around my-4">
                        <Switch name="state" v-if="orders[0].state <= 1" :text="orders[0].state === 0 ? 'تجهيز الطلب' : 'خزن الطلب'" @change="state = !state" :checked="cart.state" />

                        <div>
                            <input v-if="orders[0].state === 0" @click.prevent="submitState" :disabled="!state" class="btn btn-outline-secondary mx-2 border-yellow-500 border-2 border-opacity-60 text-gray-100" type="button" value="تجهيز">
                            <input v-if="orders[0].state === 1" @click.prevent="backState" class="btn btn-outline-secondary mx-2 border-yellow-500 border-2 border-opacity-60 text-gray-100" type="button" value="لم يجهز بعد">
                            <input v-if="orders[0].state === 1" @click.prevent="submitSave" :disabled="!state" class="btn btn-outline-secondary mx-2 border-yellow-500 border-2 border-opacity-60 text-gray-100" type="button" value="انهاء وحفظ">
                            <!-- <input v-if="orders[0].state === 2" @click.prevent="backSave" class="btn btn-outline-secondary mx-2 border-yellow-500 border-2 border-opacity-60 text-gray-100" type="button" value="تراجع عن الحفظ"> -->
                            <input @click.prevent="Delete" class="btn btn-danger mx-2 border-yellow-500 border-2 border-opacity-60 text-gray-100" type="button" value="ازالة من السجل">
                        </div>
                    </div>
                    <div class="w-10/12 mx-auto">
                        <div class="bg-gray-400 text-lg text-gray-900 py-2 px-3 rounded-t-lg border">معلومات الشراء</div>
                        <div class="bg-gray-800 rounded-b-lg py-1 px-3 mb-4 border">
                            <div class="mr-3 my-3">
                                <p class="text-gray-400 text-lg">رقم الطلبية: <span class="text-white">{{ cart.id }}</span></p>
                            </div>
                            <div class="mr-3 my-3">
                                <p class="text-gray-400 text-lg">تاريخ الطلب: <span class="text-white">{{ moment(cart.created_at).format('YYYY/MM/DD') }}</span></p>
                            </div>
                            <div class="mr-3 my-3">
                                <p class="text-gray-400 text-lg">الاسم: <span class="text-white">{{ cart.first_name }} {{ cart.last_name }}</span></p>
                            </div>
                            <div class="mr-3 my-3 md:flex">
                                <p class="text-gray-400 text-lg">المحافظة: <span class="text-white">{{ cart.governorate }}</span></p>
                                <p class="text-gray-400 text-lg md:mr-20">العنوان: <span class="text-white">{{ cart.address }}</span></p>
                                <p class="text-gray-400 text-lg md:mr-20"><span class="text-white">{{ cart.location }}</span></p>
                            </div>
                            <div class="mr-3 my-3 md:flex md:justify-between">
                                <p class="text-gray-400 text-lg">رقم الهاتف: <span class="text-white tracking-widest">0{{ cart.mobile }}</span></p>
                                <p v-if="cart.mobile2" class="text-gray-400 text-lg ml-20">رقم الهاتف (احتياط): <span class="text-white tracking-widest">0{{ cart.mobile2 }}</span></p>
                            </div>
                            <div class="mr-3 my-3 md:flex md:justify-between">
                                <p v-if="cart.email" class="text-gray-400 text-lg">البريد الالكتروني: <span class="text-white">{{ cart.email }}</span></p>
                            </div>
                            <div class="mr-3 my-3">
                                <p v-if="cart.comment" class="text-gray-400 text-lg">الملاحظات: <span class="text-white">{{ cart.comment }}</span></p>
                            </div>
                        </div>
                    </div>

                    <h3 class="my-3 text-gray-400 text-3xl pr-3 text-center border-gray-500">وصل الشراء</h3>

                    <table class="table w-10/12 mx-auto table-responsive text-lg bg-gray-800 text-gray-400 text-center">
                        <thead>
                            <tr class="bg-gray-400 text-gray-800 font-extrabold">
                                <th scope="col">#</th>
                                <th scope="col">السلعة</th>
                                <th scope="col">العدد</th>
                                <th scope="col">سعر المفرد</th>
                                <th scope="col">سعر الكل</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order, index) in orders" :key="index">
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ order.or_name }}</td>
                                <td>{{ order.count }} ×</td>
                                <td>${{ Number(order.or_price).toLocaleString('en-US') }}</td>
                                <td :id='index'>${{ Number(order.or_price * order.count).toLocaleString('en-US') }}</td>
                            </tr>
                            <tr class="text-center bg-gray-900 text-gray-400 font-extrabold">
                                <td colspan="3">المبلغ الكلي</td>
                                <td colspan="2" class="text-yellow-500 tracking-widest">${{ Number(allPrice).toLocaleString('en-US') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Auth/Authenticated'
    import sideBar from "../../Layouts/Template/navbar"
    import {Inertia} from "@inertiajs/inertia"
    import moment from 'moment'
    import Switch from '../../Layouts/Template/switch'
    import Title from "../../Layouts/Template/titles";
    import pageTitle from "../../Layouts/Template/pageTitle";

export default {
    components:{
        BreezeAuthenticatedLayout,
        moment,
        sideBar,
        Switch,
        Title,
        pageTitle,
    },
    data() {
        return {
            allPrice: 0,
            moment,
            state: 0,
        }
    },
    props:{
        orders: Object,
        cart: Object,
        success: null,
        isAdmin: null,
        orderCount: null,
        doneOrder: null,
    },
    methods:{
        submitState(){
            if(this.state){
                this.cart.state = 1
                Inertia.post('/orders', this.cart)
            }
        },
        submitSave(){
            if(this.state){
                this.cart.state = 2
                Inertia.post('/orders', this.cart)
            }
        },
        backState(){
            this.cart.state = 3
            Inertia.post('/orders', this.cart)
        },
        // backSave(){
        //     this.cart.state = 4
        //     Inertia.post('/orders', this.cart)
        // },
        Delete(){
            this.$swal({
                icon: 'error',
                title: "حذف الطلب فعلاً",
                showDenyButton: true,
                confirmButtonText: `نعم`,
                denyButtonText: `كلا`,
                reverseButtons: true,
                }).then((result) => {
                if (result.isConfirmed) {
                    Inertia.delete(`/orders/${this.cart.id}`)
                }
            })
        },
    },
    mounted(){
        for(let i=0 ; i < this.orders.length;i++){
            this.allPrice += this.orders[i].count * this.orders[i].or_price
        }
    }
}
</script>

<style >
    .swal2-popup{
        display: block !important;
    }
</style>
