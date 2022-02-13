<template>
    <pageTitle :title="'Edit ' + product.pd_name" />
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">

                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 text-center mt-4">
                    <Title text="Edit" />

                    <form class="mt-5 space-y-3 w-75 mx-auto" @submit.prevent="editProd">

                        <Switch name="pd_state" text="Special" @change="product.pd_state = !product.pd_state" :checked="product.pd_state" />

                        <label for="pd_name" class="block text-right text-white mr-2 mb-2">Name</label>
                        <div class="mt-1 relative rounded-md shadow-sm mb-3">
                            <input type="text" v-model="product.pd_name" class="px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md bg-gray-600 text-gray-300" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.pd_name }}</small>

                        <div class="form-group">
                            <label for="Mcategories" class="block text-right text-white mr-2 mb-2">Category</label>
                            <select class="form-select bg-gray-600 text-gray-300" name="Mcategories" id="Mcategories" @load.once="run" @change="onChange($event)">
                                <option disabled value="">Select Category</option>
                                <option v-for="category in categories" :key="category.id" :selected="category.id == product.categories_id" :value="category.id">{{category.cat_name}}</option>
                            </select>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.categories_id }}</small>

                        <div class="form-group">
                            <label for="categories" class="block text-right text-white mr-2 mb-2">SubCategory</label>
                            <select v-if="sub.length > 0 || emptySub" class="form-select bg-gray-600 text-gray-300" name="categories" id="Scategories" @change="onChangeSub($event)">
                                <option disabled value="">Select SubCategory</option>
                                <option id='selectCat' v-for="cat in sub" :key="cat.id" :selected="cat.id == product.sub_cats_id" :value="cat.id">{{cat.cat_name}}</option>
                            </select>
                            <select v-else class="form-select bg-gray-600 text-gray-300" name="categories" id="categories" @change="onChangeSub($event)">
                                <option disabled value="">Select SubCategory</option>
                                <option v-for="cat in subcat" :key="cat.id" :selected="cat.id == product.sub_cats_id" :value="cat.id">{{cat.cat_name}}</option>
                            </select>
                        </div>
                        <small v-show="!Equal" class="text-red-300 mr-auto mb-3">Select SubCategory</small>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.sub_cats_id }}</small>

                        <label for="img" class="block text-right text-white mr-2 mb-2">Cover Image</label>
                        <div class="bg-gray-400 py-3 rounded-1 cursor-pointer border-dashed border-2">
                            <div @click="selectCover">
                                <fa icon="images" class="text-4xl" />
                            </div>
                            <input name="cover" ref="coverInput" type="file" hidden="true" accept="image/*" @change="inputCover">
                            <div v-show="product.cover || cover_preview" class="inline-flex">
                                <span @click="removeCoverPreview()" class="relative X rounded-pill px-2 mt-1 mb-auto opacity-80 text-white bg-red-700 h-full"><fa icon="times" /></span>
                                <img @click="showImage(this.cover_preview ? this.cover_preview : 'images/' + product.cover)" :src="this.cover_preview ? this.cover_preview : 'images/' + product.cover" width="100" height ="100" class="img-thumbnail cursor-zoom-in">
                            </div>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.cover }}</small>

                        <label for="img" class="block text-right text-white mr-2 mb-2">Product Images</label>
                        <div class="bg-gray-400 py-3 rounded-1 cursor-pointer border-dashed border-2">
                            <div @click="selectImage">
                                <fa icon="images" class="text-4xl" />
                            </div>
                            <input ref="fileInput" type="file" hidden="true" accept="image/*" multiple @change="inputImages">
                            <div v-for="(img, i) in products.data.images" :key="i" class="inline-flex my-1">
                                <span @click="removeOldImg(i)" class="relative X rounded-pill px-2 mt-1 mb-auto opacity-80 text-white bg-red-700 h-full"><fa icon="times" /></span>
                                <img loading="lazy" id="img1" @click="showImage('images/' + img.img_url)" :src="'images/' + img.img_url" width="100" height ="100" class="img-thumbnail cursor-zoom-in">
                            </div>
                            <div v-for="(img, i) in img_preview" :key="i" class="inline-flex my-1">
                                <span @click="removeImgPreview(img)" class="relative X rounded-pill px-2 mt-1 my-auto opacity-80 text-white bg-red-700 h-full"><fa icon="times" /></span>
                                <img loading="lazy" id="img2" @click="showImage(img)" :src="img" width="100" height ="100" class="img-thumbnail cursor-zoom-in">
                            </div>
                        </div>
                        <small v-show="imgEmpty" class="text-red-300 mr-auto mb-3">Must select image</small>

                        <label for="pd_price" class="block text-right text-white mr-2 mb-2">Price</label>
                        <div class="mt-1 relative rounded-md shadow-sm mb-3">
                            <input type="number" v-model="product.pd_price" min="0" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                            <p class='text-center text-white lead pt-1'>{{Number(product.pd_price).toLocaleString('en')}} $</p>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.pd_price }}</small>

                        <label for="pd_stack" class="block text-right text-white mr-2 mb-2">Qty</label>
                        <div class="mt-1 relative rounded-md shadow-sm mb-3">
                            <input type="number" v-model="product.pd_stack" min="0" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.pd_stack }}</small>

                        <label for="pd_description" class="block text-right text-white mr-2 mb-2">Description</label>
                        <div class="mt-1 relative rounded-md shadow-sm mb-3">
                            <textarea type="text" rows="5" v-model="product.pd_description" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.pd_description }}</small>

                        <label for="company" class="block text-right text-white mr-2 mb-2">Company</label>
                        <div class="mt-1 relative rounded-md shadow-sm mb-3">
                            <input type="text" v-model="product.company" class="px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md bg-gray-600 text-gray-300" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.company }}</small>

                        <label for="review" class="block text-right text-white mr-2 mb-2">Review</label>
                        <div class="mt-1 relative rounded-md shadow-sm mb-3">
                            <input type="url" v-model="product.review" class="px-3 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md bg-gray-600 text-gray-300" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.review }}</small>

                        <label for="created_at" class="block text-right text-white mr-2 mb-2">Created at</label>
                        <div class="mt-1 relative rounded-md shadow-sm mb-3">
                            <label class="text-white">{{ moment(products.data.created_at).locale('ar').fromNow() }}</label>
                        </div>

                        <div v-if="products.data.created_at !== products.data.updated_at">
                            <label for="updated_at" class="block text-right text-white mr-2 mb-2">Last Update</label>
                            <div class="mt-1 relative rounded-md shadow-sm mb-3">
                                <label class="text-white">{{ moment(products.data.updated_at).locale('ar').fromNow() }}</label>
                            </div>
                        </div>
                        <div class="flex justify-around my-4">
                            <button type="submit" class="btn btn-outline-primary px-5 text-white" :disabled="product.processing || !product.pd_name || !product.img_url || !product.pd_price || !product.pd_description || !product.phone || !product.message">Update</button>
                            <button @click.prevent="deleteProd" class="btn btn-outline-danger px-5 text-white">حذف</button>
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

    import {ref} from 'vue'
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
            products: Object,
            categories: Object,
            subcat: Object,
            allSubCat: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
        },
        data(){
            return{
                product:{
                    cat_id: this.products.data.cat_id,
                    pd_name: this.products.data.pd_name,
                    pd_price: this.products.data.pd_price,
                    pd_stack: this.products.data.pd_stack,
                    pd_state: this.products.data.pd_state,
                    img_url: [],
                    pd_description: this.products.data.pd_description,
                    phone: '0' + this.products.data.phone,
                    message: this.products.data.message,
                    review: this.products.data.review,
                    cover: this.products.data.cover,
                    categories_id: this.products.data.categories_id,
                    sub_cats_id: this.products.data.sub_cats_id,
                },
                moment: moment,
                img_preview: [],
                cover_preview: null,
                imgExt: ['png', 'jpg', 'bmp', 'jpeg', 'gif', 'tiff', 'jfif'],
                imgEmpty: false,
                sub: this.products.data.sub_cats_id,
                Equal: true,
                emptySub: false
            }
        },
        methods:{
            editProd(){
                if((this.product.categories_id == this.products.data.categories_id) && (this.product.sub_cats_id == this.products.data.sub_cats_id)){
                    this.Equal = true
                }else if((this.product.categories_id != this.products.data.categories_id) && (this.product.sub_cats_id == this.products.data.sub_cats_id)){
                    this.Equal = false
                }else if((this.product.categories_id != this.products.data.categories_id) && (this.product.sub_cats_id != this.products.data.sub_cats_id)){
                    this.Equal = true
                }

                if(document.getElementById('img2') || document.getElementById('img1')){
                    this.imgEmpty = false

                    if(this.Equal){
                        this.Equal = false
                        Inertia.post(`/products/${this.products.data.id}`, {
                            _method: 'put',
                            'cat_id': this.product.cat_id,
                            'pd_name': this.product.pd_name,
                            'pd_price': this.product.pd_price,
                            'pd_stack': this.product.pd_stack,
                            'pd_state': this.product.pd_state,
                            'pd_description': this.product.pd_description,
                            'phone': this.product.phone,
                            'message': this.product.message,
                            'review': this.product.review,
                            'cover': this.product.cover,
                            'categories_id': this.product.categories_id,
                            'sub_cats_id': this.product.sub_cats_id,
                            'img_url': this.product.img_url,
                            'old_img': this.products.data.images
                        })
                    }
                }else{return this.imgEmpty = true}
            },
            deleteProd(){
                this.$swal({
                    icon: 'error',
                    title: "Do you want to delete "+ this.product.pd_name +" ?",
                    showDenyButton: true,
                    confirmButtonText: `Yes`,
                    denyButtonText: `No`,
                    reverseButtons: true,
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Inertia.delete(`/products/${this.products.data.id}`)
                    }
                })
            },
            onChange(e){
                this.sub = []
                this.product.categories_id = e.target.options[e.target.options.selectedIndex].value
                let index = 0
                for(let i=0;i < this.allSubCat.length;i++){
                    if(this.allSubCat[i].categories_id == this.product.categories_id){
                        this.sub[index] = this.allSubCat[i]
                        index++
                    }
                }
                if(this.sub.length > 0){
                    this.product.sub_cats_id = this.sub[0].id
                }else{
                    this.product.sub_cats_id = null
                    this.emptySub = true
                }
            },
            onChangeSub(e){
                this.product.sub_cats_id = e.target.options[e.target.options.selectedIndex].value
            },
            onlyNumbers($event){
                let keyCode = ($event.keyCode ? $event.keyCode : $event.watch);
                if((keyCode < 48 || keyCode > 57) && keyCode !==46) {
                    $event.preventDefault();
                }
            },
            selectImage () {
                this.$refs.fileInput.click()
            },
            selectCover () {
                this.$refs.coverInput.click()
            },
            inputImages(e){
                for (let i = 0;i< e.target.files.length;i++){
                    var flag = 0
                    if (this.imgExt.includes(e.target.files[i].name.split('.').pop())){
                        flag +=1
                    }else{
                        alert('Please select Image format')
                    }
                    if ( (e.target.files[i].size) <= 2097152){
                        flag +=1
                    }else{
                        alert('Image selected more than 2MB')
                    }
                    if(flag >=2){
                        this.img_changed = true
                        this.product.img_url.push(e.target.files[i])
                        this.img_preview.push(URL.createObjectURL(e.target.files[i]))
                    }
                }
            },
            removeImgPreview(e){
                this.product.img_url.splice(this.product.img_url.indexOf(e), 1);
                this.img_preview.splice(this.img_preview.indexOf(e), 1);
            },
            removeOldImg(e){
                this.products.data.images.splice(e, 1);
            },
            inputCover(e){
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
                    this.product.cover = e.target.files[0]
                    this.cover_preview = URL.createObjectURL(e.target.files[0])
                }
            },
            removeCoverPreview(){
                this.product.cover = null
                this.cover_preview = null
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
        },
    }
</script>
<style >
    .max-height{
        max-height: 250px;
    }
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
