<template>
    <pageTitle :title="'Edit ' + category.cat_name" />
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0">
            <div class="grid lg:grid-cols-12 w-full bg-gray-700">

                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 text-center mt-4">
                    <Title text="Edit" />

                    <div class="text-right ml-4">
                        <inertia-link :href="`/subcat/${category.id}`" type="submit" class="btn btn-outline-danger text-white px-3 text-xs " title="عرض جميع السلع التابعة لهذا القسم">
                            Products
                            <div class="float-right pl-2">
                                <fa class="text-lg" icon="tags" />
                            </div>
                        </inertia-link>
                    </div>

                    <form class="mt-5 space-y-3 w-75 mx-auto" @submit.prevent="editCat">

                        <label for="cat_name" class="block text-left text-white mr-2 mb-2">Name</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="cat_name" type="text" v-model="category.cat_name" :class="{ 'is-invalid': errors.cat_name }" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3" v-if="errors.cat_name">{{ errors.cat_name }}</small>

                        <div class="form-group">
                            <label for="categories" class="block text-left text-white mr-2 mb-2">Category</label>
                            <select class="form-select bg-gray-600 text-gray-300" name="categories" id="categories" @change="onChange($event)">
                                <option disabled value="">Select Category</option>
                                <option v-for="c_name in cat_name" :key="c_name.id" :selected="category.categories_id == c_name.id" :value="c_name.id">{{c_name.cat_name}}</option>
                            </select>
                        </div>

                        <label for="img" class="block text-left text-white mr-2 mb-2">SubCategory Image</label>
                        <div class="bg-gray-400 py-3 rounded-1 cursor-pointer border-dashed border-2">
                            <div @click="selectImage">
                                <fa icon="images" class="text-4xl" />
                            </div>
                            <input name="img_url" ref="fileInput" type="file" hidden="true" accept="image/*" @change="inputImage">
                            <div v-show="category.img_url || img_preview" class="inline-flex">
                                <span @click="removeImgPreview()" class="relative X rounded-pill px-2 mt-1 mb-auto opacity-80 text-white bg-red-700 h-full"><fa icon="times" /></span>
                                <img loading="lazy" @click="showImage(this.img_preview ? this.img_preview : 'images/' + category.img_url)" :src="this.img_preview ? this.img_preview : 'images/' + category.img_url" width="100" height ="100" class="img-thumbnail cursor-zoom-in">
                            </div>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.img_url }}</small>

                        <label class="block text-left text-white mr-2 mb-2">Created at</label>
                        <div class="mt-1 relative rounded-md shadow-sm mb-3">
                            <label class="text-white">{{ moment(categories.created_at).fromNow() }}</label>
                        </div>

                        <div v-if="categories.created_at !== categories.updated_at">
                            <label class="block text-left text-white mr-2 mb-2">Last Update</label>
                            <div class="mt-1 relative rounded-md shadow-sm mb-3">
                                <label class="text-white">{{ moment(categories.updated_at).fromNow() }}</label>
                            </div>
                        </div>

                        <div class="flex justify-around my-4">
                            <button type="submit" class="btn btn-outline-primary px-5 text-white">Update</button>
                            <button @click.prevent="deleteCat" class="btn btn-outline-danger px-5 text-white">Delete</button>
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
    import Title from "../../Layouts/Template/titles";
    import pageTitle from "../../Layouts/Template/pageTitle";

    export default {
        components: {
            BreezeAuthenticatedLayout,
            sideBar,
            Title,
            pageTitle,
        },
        props: {
            auth: Object,
            errors: Object,
            categories: Object,
            cat_name: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
        },
        data(){
            return{
                category:{
                    id: this.categories.id,
                    cat_name: this.categories.cat_name,
                    categories_id: this.categories.categories_id,
                    img_url: this.categories.image.img_url,
                },
                moment: moment,
                imgExt: ['png', 'jpg', 'bmp', 'jpeg', 'gif', 'tiff', 'jfif'],
                img_preview: null,
            }
        },
        methods:{
            editCat(){
                if(this.category.img_url){
                    Inertia.post(`/subcat/${this.categories.id}`, {
                        _method: 'put',
                        'cat_name': this.category.cat_name,
                        'categories_id' : this.category.categories_id,
                        'img_url' : this.category.img_url,
                    })
                }else{
                    alert('Select image')
                }
            },
            deleteCat(){
                this.$swal({
                    icon: 'error',
                    title: 'Do you want to delete '+ this.category.cat_name +' ?',
                    showDenyButton: true,
                    confirmButtonText: `Yes`,
                    denyButtonText: `No`,
                    reverseButtons: true,
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Inertia.delete(`/subcat/${this.categories.id}`)
                    }
                })
            },
            onChange(e){
                this.category.categories_id = e.target.options[e.target.options.selectedIndex].value
            },
            selectImage () {
                this.$refs.fileInput.click()
            },
            inputImage(e){
                var flag = 0
                if (this.imgExt.includes(e.target.files[0].name.split('.').pop())){
                    flag +=1
                }else{
                    alert('Please select Image format')
                }
                if ( (e.target.files[0].size) <= 2097152){
                    flag +=1
                }else{
                    alert('Image selected more than 2MB')
                }
                if(flag >=2){
                    this.category.img_url = e.target.files[0]
                    this.img_preview = URL.createObjectURL(e.target.files[0])
                }
            },
            removeImgPreview(){
                this.category.img_url = null
                this.img_preview = null
            },
            showImage(img){
                if(img){
                    this.$swal({
                        imageUrl: img,
                        showConfirmButton: false,
                        padding: '0 1em',
                    })
                }
            },
        }
    }
</script>
<style >
    .X{
        left:50%
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
</style>
