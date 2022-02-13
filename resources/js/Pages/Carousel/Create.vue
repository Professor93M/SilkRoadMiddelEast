<template>
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">
                <pageTitle title="اضافة اعلان جديد" />
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 text-center mt-4">
                    <Title text="اضافة اعلان جديد" />

                    <form class="mt-5 space-y-3 w-75 mx-auto" @submit.prevent="createCar" enctype="multipart/form-data" method="POST">

                        <Switch name="state" text="عرض الاعلان" @change="changeState" :checked="carousel.state" />

                        <label for="title" class="block text-right text-white mr-2 mb-2">عنوان الاعلان:</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="title" type="text" v-model="carousel.title" :class="{ 'is-invalid': errors.title }" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.title }}</small>

                        <label for="description" class="block text-right text-white mr-2 mb-2">وصف الاعلان:</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <textarea type="text" rows="5" v-model="carousel.description" class="max-height px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.description }}</small>
                        <label for="url" class="block text-right text-white mr-2 mb-2">رابط الاعلان:</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="url" type="text" v-model="carousel.url" :class="{ 'is-invalid': errors.url }" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.url }}</small>

                        <label for="img" class="block text-right text-white mr-2 mb-2">صورة الاعلان</label>
                        <div class="bg-gray-400 py-3 rounded-1 cursor-pointer border-dashed border-2">
                            <div @click="selectImage">
                                <fa icon="images" class="text-4xl" />
                            </div>
                            <input name="img_url" ref="fileInput" type="file" hidden="true" accept="image/*" @change="inputImage">
                            <div v-show="img_preview" class="inline-flex">
                                <span @click="removeImgPreview(img_preview)" class="relative X rounded-pill px-2 mt-1 mb-auto opacity-80 text-white bg-red-700 h-full"><fa icon="times" /></span>
                                <img loading="lazy"  @click="showImage(img_preview)" :src="img_preview" width="100" height ="100" class="img-thumbnail cursor-zoom-in">
                            </div>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.img_url }}</small>

                        <div class="flex justify-around my-4">
                            <button :disabled="carousel.processing || !carousel.title || !carousel.img_url" type="submit" class="btn btn-outline-primary px-5 text-white">اضافة</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Auth/Authenticated'
    import sideBar from "../../Layouts/Template/navbar"
    import Switch from '../../Layouts/Template/switch'
    import { useForm } from '@inertiajs/inertia-vue3'
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
        data(){
            return{
                success: null,
                imgExt: ['png', 'jpg', 'bmp', 'jpeg', 'gif', 'tiff', 'jfif'],
                img_preview: null,
            }
        },
        setup () {
            const carousel = useForm({
                title: null,
                description: null,
                url: null,
                state: false,
                img_url: null,
            })

            function createCar() {
                carousel.post('/carousel')
            }

            return { carousel, createCar }
        },
        props: {
            auth: Object,
            errors: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
        },
        methods:{
            selectImage(){
                this.$refs.fileInput.click()
            },
            inputImage(e){
                var flag = 0
                if (this.imgExt.includes(e.target.files[0].name.split('.').pop())){
                    flag +=1
                }else{
                    alert('رجاء قم بأختيار صورة مناسبة')
                }
                if ( (e.target.files[0].size) <= 2097152){
                    flag +=1
                }else{
                    alert('يجب ان لا يتجاوز حجم الصورة 2MB')
                }
                if(flag >=2){
                    this.carousel.img_url = e.target.files[0]
                    this.img_preview = URL.createObjectURL(e.target.files[0])
                }
            },
            removeImgPreview(e){
                this.carousel.img_url = null
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
            changeState(){
                this.carousel.state = !this.carousel.state
            }
        },
    }
</script>

<style scoped>
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
</style>
