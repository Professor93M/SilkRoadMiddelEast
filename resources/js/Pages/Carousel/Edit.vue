<template>
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0">
            <div class="grid lg:grid-cols-12 w-full bg-gray-700">
                <pageTitle :title="'Edit ' + carousel.title" />
                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 text-center mt-4">
                    <Title text="Edit" />

                    <form class="mt-5 space-y-3 w-75 mx-auto" @submit.prevent="editCar">

                        <Switch name="state" text="Show" @change="changeState" :checked="carousel.state" />

                        <label for="title" class="block text-right text-white mr-2 mb-2">Title</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="title" type="text" v-model="carousel.title" :class="{ 'is-invalid': errors.title }" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3" v-if="errors.title">{{ errors.title }}</small>

                        <label for="description" class="block text-right text-white mr-2 mb-2">Description</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <textarea type="text" rows="5" v-model="carousel.description" :class="{ 'is-invalid': errors.description }" class="max-height px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                        <small class="text-red-300 mr-auto mb-3" v-if="errors.description">{{ errors.description }}</small>

                        <label for="url" class="block text-right text-white mr-2 mb-2">URL</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="url" type="text" v-model="carousel.url" :class="{ 'is-invalid': errors.url }" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3" v-if="errors.url">{{ errors.url }}</small>

                        <label for="img" class="block text-right text-white mr-2 mb-2">Image</label>
                        <div class="bg-gray-400 py-3 rounded-1 cursor-pointer border-dashed border-2">
                            <div @click="selectImage">
                                <fa icon="images" class="text-4xl" />
                            </div>
                            <input name="img_url" ref="fileInput" type="file" hidden="true" accept="image/*" @change="inputImage">
                            <div v-show="carousel.img_url || img_preview" class="inline-flex">
                                <span @click="removeImgPreview()" class="relative X rounded-pill px-2 mt-1 mb-auto opacity-80 text-white bg-red-700 h-full"><fa icon="times" /></span>
                                <img loading="lazy" @click="showImage(this.img_preview ? this.img_preview : 'images/' + carousel.img_url)" :src="this.img_preview ? this.img_preview : 'images/' + carousel.img_url" width="100" height ="100" class="img-thumbnail cursor-zoom-in">
                            </div>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.img_url }}</small>

                        <label class="block text-right text-white mr-2 mb-2">Created at</label>
                        <div class="mt-1 relative rounded-md shadow-sm mb-3">
                            <label class="text-white">{{ moment(carousels.data.created_at).locale("ar").fromNow() }}</label>
                        </div>

                        <div v-if="carousels.data.created_at !== carousels.data.updated_at">
                            <label class="block text-right text-white mr-2 mb-2">Last Update</label>
                            <div class="mt-1 relative rounded-md shadow-sm mb-3">
                                <label class="text-white">{{ moment(carousels.data.updated_at).locale("ar").fromNow() }}</label>
                            </div>
                        </div>

                        <div class="flex justify-around my-4">
                            <button type="submit" class="btn btn-outline-primary px-5 text-white">Update</button>
                            <button @click.prevent="deleteCar" class="btn btn-outline-danger px-5 text-white">Delete</button>
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
            carousels: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
        },
        data(){
            return{
                carousel:{
                    id: this.carousels.data.id,
                    title: this.carousels.data.title,
                    description: this.carousels.data.description,
                    url: this.carousels.data.url,
                    state: this.carousels.data.state,
                    img_url: this.carousels.data.image.img_url,
                },
                state: false,
                moment: moment,
                imgExt: ['png', 'jpg', 'bmp', 'jpeg', 'gif', 'tiff', 'jfif'],
                img_preview: null,
            }
        },
        methods:{
            editCar(){
                Inertia.post(`/carousel/${this.carousels.data.id}`, {
                    _method: 'put',
                    'title': this.carousel.title,
                    'description': this.carousel.description,
                    'url': this.carousel.url,
                    'state': this.carousel.state,
                    'img_url' : this.carousel.img_url,
                })
            },
            deleteCar(){
                this.$swal({
                    icon: 'error',
                    title: 'Do you want to delete '+ this.carousel.title +' ?',
                    showDenyButton: true,
                    confirmButtonText: `Yes`,
                    denyButtonText: `No`,
                    reverseButtons: true,
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Inertia.delete(`/carousel/${this.carousels.data.id}`)
                    }
                })
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
                    this.carousel.img_url = e.target.files[0]
                    this.img_preview = URL.createObjectURL(e.target.files[0])
                }
            },
            removeImgPreview(){
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
            },
        }
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
