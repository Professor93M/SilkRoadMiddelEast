<template>
<inertia-head title="Your page title" />
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0">
            <div class="grid lg:grid-cols-12 w-full bg-gray-700">
                <pageTitle :title="'Edit ' + admin.name" />
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 text-center mt-4">
                    <Title text="Edit" />

                    <form class="mt-5 space-y-3 w-75 mx-auto" @submit.prevent="editAdmin">

                        <div :class="admins.id == 1 ? 'justify-end':'justify-between'" class="flex ">
                            <Switch v-if="admins.id !== 1" name="state" text="Rule" @change="changeState" :checked="admins.isAdmin" />
                        </div>

                        <label for="name" class="block text-left text-white mr-2 mb-2">Name</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="name" type="text" v-model="admin.name" :class="{ 'is-invalid': errors.name }" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3" v-if="errors.name">{{ errors.name }}</small>

                        <label for="password" class="block text-left text-white mr-2 mb-2">Password</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="password" type="password" v-model="admin.password" placeholder="Leave the field if there is no update" :class="{ 'is-invalid': errors.password }" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md placeholder-yellow-500 placeholder-opacity-70" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3" v-if="errors.password">{{ errors.password }}</small>

                        <label for="password_confirmation" class="block text-left text-white mr-2 mb-2">Confirm Password</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="password_confirmation" type="password" v-model="admin.password_confirmation" placeholder="Leave the field if there is no update" :class="{ 'is-invalid': errors.password_confirmation }" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md placeholder-yellow-500 placeholder-opacity-70" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3" v-if="errors.password_confirmation">{{ errors.password_confirmation }}</small>

                        <label for="email" class="block text-left text-white mr-2 mb-2">Email</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="email" type="email" v-model="admin.email" :class="{ 'is-invalid': errors.email }" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3" v-if="errors.email">{{ errors.email }}</small>

                        <label class="block text-left text-white mr-2 mb-2">Created at</label>
                        <div class="mt-1 relative rounded-md shadow-sm mb-3">
                            <label class="text-white">{{ moment(admins.created_at).fromNow() }}</label>
                        </div>

                        <div v-if="admins.created_at !== admins.updated_at">
                            <label class="block text-left text-white mr-2 mb-2">Last Update</label>
                            <div class="mt-1 relative rounded-md shadow-sm mb-3">
                                <label class="text-white">{{ moment(admins.updated_at).fromNow() }}</label>
                            </div>
                        </div>

                        <div class="flex justify-around my-4">
                            <button type="submit" class="btn btn-outline-primary px-5 text-white">Update</button>
                            <button v-if="!admin.isAdmin" @click.prevent="deleteAdmin" class="btn btn-outline-danger px-5 text-white">Delete</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Auth/Authenticated'
    import sideBar from "../../Layouts/Template/navbar";
    import {Inertia} from "@inertiajs/inertia";
    import moment from 'moment'
    import Switch from '../../Layouts/Template/switch'
    import Title from "../../Layouts/Template/titles";
    import pageTitle from "../../Layouts/Template/pageTitle";

    export default {
        components: {
            BreezeAuthenticatedLayout,
            sideBar,
            Switch,
            Title,
            pageTitle,
        },
        props: {
            auth: Object,
            errors: Object,
            admins: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
        },
        data(){
            return{
                admin:{
                    name: this.admins.name,
                    email: this.admins.email,
                    password: '',
                    password_confirmation: '',
                    isAdmin: this.admins.isAdmin,
                },
                moment: moment,
            }
        },
        methods:{
            editAdmin(){
                Inertia.post(`/admins/${this.admins.id}`, {
                    _method: 'put',
                    'name': this.admin.name,
                    'email': this.admin.email,
                    'password': this.admin.password,
                    'password_confirmation': this.admin.password_confirmation,
                    'isAdmin': this.admin.isAdmin,
                })
            },
            deleteAdmin(){
                this.$swal({
                    icon: 'error',
                    title: 'Do you want to delete '+ this.admin.name +' ?',
                    showDenyButton: true,
                    confirmButtonText: `Yes`,
                    denyButtonText: `No`,
                    reverseButtons: true,
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Inertia.delete(`/admins/${this.admins.id}`)
                    }
                })
            },
            changeState(){
                this.admin.isAdmin = !this.admin.isAdmin
            },
        },
    }
</script>
<style >
    .X{
        left:-50%
    }
    .swal2-popup{
        display: block !important;
    }
    .is-invalid{
        border-color: red
    }
    .cursor-zoom-in {
        cursor: -webkit-zoom-in;
        cursor: zoom-in;
    }
    input:checked ~ .dot {
        transform: translateX(100%);
        background-color: #F59E0B !important;
    }
</style>
