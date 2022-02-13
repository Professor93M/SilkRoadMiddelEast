<template>
    <div class="container-fluid px-0 bg-gray-700">
        <pageTitle title="تحقق من طلبك" />

        <nav-bar :logged="auth.user" />
        <h1 class="headers md:mx-24 flex justify-center text-2xl font-extrabold text-yellow-500 hover:text-gray-300 select-none transition duration-500 font-weight-bolder mt-5 mb-20">
            تحقق من طلبك
        </h1>
        <div class="text-center">
            <div class="mx-auto lg:w-3/12 md:w-5/12 w-8/12 ">
                <label for="mobile" class="block text-right text-gray-300 mr-2 mb-2">رقم الهاتف</label>
                <div class="mt-1 relative rounded-md">
                    <input type="tel" v-model="state.m" placeholder="07X0 000 0000" class="text-center bg-gray-700 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md w-full" />
                </div>
                <small class="text-red-300 mr-auto mb-3">{{ errors.m }}</small>
                <small v-if="errorMobile" class="text-red-300 mr-auto mb-3">{{ errorMobile }}</small>
            </div>
            <button @click.prevent="checkState" @keypress.enter="checkState" class="btn btn-outline-secondary text-yellow-500 text-xl mb-5 mt-3 px-4">تحقق</button>
            <div class="mx-auto lg:w-5/12 md:w-8/12 w-11/12 text-center text-lg font-medium text-gray-400 bg-gray-800 p-3 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 animate-bounce inline md:float-right text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="relative inline-flex rounded-md shadow-sm">ادخل رقم هاتفك الذي قمت بأضافته ليتم التحقق من طلبك</p>
            </div>
        </div>
        <whatsapp />
        <Footer />
  </div>
</template>

<script>
    import card from '@/Layouts/Template/Card'
    import navBar from '@/Layouts/Template/nav'
    import {Inertia} from "@inertiajs/inertia";
    import Footer from '@/Layouts/Template/footer'
    import whatsapp from '@/Layouts/Template/whatsapp'
    import pageTitle from "../Layouts/Template/pageTitle";

    export default {
        components:{
            card,
            navBar,
            Footer,
            whatsapp,
            pageTitle,
        },
        data() {
            return {
                state:{
                    m: null,
                },
                errorMobile: null,
            }
        },
        props:{
            errors: Object,
            success: null,
            auth: Object,
        },
        methods:{
            checkState(){
                if(this.state.m){
                    if(/(07)[0-9]{9}$/.test(this.state.m)){
                        Inertia.get('/stateCheck', this.state)
                    }else{
                        this.errorMobile = 'الرقم المدخل غير صحيح'
                    }
                }else{
                    this.errorMobile = 'ادخل رقم الهاتف'
                }
            },
        },
        mounted(){
            if(this.success){
                this.$swal({
                    icon: 'error',
                    confirmButtonText: 'حسناً',
                    text: this.success,
                })
            }
        }
    }
</script>

<style>
    .headers::before, .headers::after{
        content: "";
        flex: 1 1;
        border-bottom: 2px solid #a7a7a7;
        margin: 20px;
        opacity: .3;
    }
    .swal2-container.swal2-center>.swal2-popup{
        display:block !important;
        /* flex-direction: column !important; */
    }
</style>
