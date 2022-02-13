<template>
    <pageTitle title="اضافة سلعة جديدة" />
    <breeze-authenticated-layout :isAdmin="isAdmin" :orderCount="orderCount" :doneOrder="doneOrder">
        <div class="container-fluid px-0 bg-gray-700">
            <div class="grid lg:grid-cols-12 w-full">

                <div class="lg:col-start-4 lg:col-end-13 lg:mx-2 text-center mt-4">
                    <Title text="اضافة سلعة جديدة" />

                    <form  @submit.prevent="createProd" class="mt-5 space-y-3 w-75 mx-auto">

                        <Switch name="pd_state" text="مميز" @change="products.pd_state = !products.pd_state" :checked="products.pd_state" />

                        <label for="pd_name" class="block text-right text-white mr-2 mb-2">اسم السلعة</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" v-model="products.pd_name" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.pd_name }}</small>

                        <div class="form-group">
                            <label for="categories_id" class="block text-right text-white mr-2 mb-2">القسم الرئيسي</label>
                            <select class="form-select bg-gray-600 text-gray-300" name="categories_id" id="categories_id" @change="onChange($event)">
                                <option disabled selected value="">رجاء اختر القسم الرئيسي</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{category.cat_name}}</option>
                            </select>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.categories_id }}</small>

                        <div v-if="sub" class="form-group">
                            <label for="sub_cats_id" class="block text-right text-white mr-2 mb-2">القسم الفرعي</label>
                            <select class="form-select bg-gray-600 text-gray-300" name="sub_cats_id" id="sub_cats_id" @change="onChangeSub($event)">
                                <option disabled selected value="">رجاء اختر القسم الفرعي</option>
                                <option v-for="category in sub" :key="category.id" :value="category.id">{{category.cat_name}}</option>
                            </select>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.sub_cats_id }}</small>

                        <label for="img" class="block text-right text-white mr-2 mb-2">صورة الغلاف</label>
                        <div class="bg-gray-400 py-3 rounded-1 cursor-pointer border-dashed border-2">
                            <div @click="selectCover">
                                <fa icon="images" class="text-4xl" />
                            </div>
                            <input name="cover" ref="coverInput" type="file" hidden="true" accept="image/*" @change="inputCover">
                            <div v-show="cover_preview" class="inline-flex">
                                <span @click="removeCoverPreview(cover_preview)" class="relative X rounded-pill px-2 mt-1 mb-auto opacity-80 text-white bg-red-700 h-full"><fa icon="times" /></span>
                                <img loading="lazy" @click="showImage(cover_preview)" :src="cover_preview" width="100" height ="100" class="img-thumbnail cursor-zoom-in">
                            </div>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.cover }}</small>

                        <label for="img" class="block text-right text-white mr-2 mb-2">صور السلعة</label>
                        <div class="bg-gray-400 py-3 rounded-1 cursor-pointer border-dashed border-2">
                            <div @click="selectImage">
                                <fa icon="images" class="text-4xl" />
                            </div>
                            <input ref="fileInput" type="file" hidden="true" accept="image/*" multiple @change="InputImages">
                            <div v-for="(img, i) in img_preview" :key="i" class="inline-flex">
                                <span @click="removeImgPreview(img_preview[i])" class="relative X rounded-pill px-2 mt-1 mb-auto opacity-80 text-white bg-red-700"><fa icon="times" /></span>
                                <img loading="lazy" id="img" @click="showImage(img_preview[i])" :src="img_preview[i]" width="100" height ="100" class="img-thumbnail cursor-zoom-in">
                            </div>
                        </div>
                        <small v-show="imgEmpty" class="text-red-300 mr-auto mb-3">يجب ادخال صورة</small>

                        <label for="price" class="block text-right text-white mr-2 mb-2">السعر</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" @keypress='onlyNumbers' v-model.number="products.pd_price" min="0" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                            <p class='text-center text-white lead pt-1'>{{Number(products.pd_price).toLocaleString('en')}} $</p>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.pd_price }}</small>

                        <label for="stack" class="block text-right text-white mr-2 mb-2">المخزون</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" v-model="products.pd_stack" min="0" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.pd_stack }}</small>

                        <label for="description" class="block text-right text-white mr-2 mb-2">الوصف</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <textarea type="text" rows="5" v-model="products.pd_description" class="max-height px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.pd_description }}</small>

                        <label for="phone" class="block text-right text-white mr-2 mb-2">رقم الهاتف</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" v-model="products.phone" placeholder="07X0 000 0000" class="placeholder-gray-400 placeholder-opacity-70 px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.phone }}</small>

                        <label for="message" class="block text-right text-white mr-2 mb-2">رسالة بدء المحادثة</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <textarea type="text" rows="2" v-model="products.message" class="max-height px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.message }}</small>

                        <label for="review" class="block text-right text-white mr-2 mb-2">رابط المراجعة</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="url" v-model="products.review" class="px-3 bg-gray-600 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" />
                        </div>
                        <small class="text-red-300 mr-auto mb-3">{{ errors.review }}</small>

                        <div class="flex justify-around my-4">
                            <button type="submit" class="btn btn-outline-primary px-5 text-white" :disabled="products.processing || !products.pd_name || !products.img_url || !products.pd_price || !products.pd_stack || !products.pd_description || !products.phone || !products.categories_id || !products.sub_cats_id || !products.message">اضافة</button>
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
    import { Inertia } from '@inertiajs/inertia'
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
            categories: Object,
            subcat: Object,
            isAdmin: null,
            orderCount: null,
            doneOrder: null,
        },
        data(){
            return{
                products:{
                    pd_name: '',
                    categories_id: '',
                    sub_cats_id: '',
                    img_url: [],
                    pd_price: '',
                    pd_stack: '',
                    pd_state: false,
                    pd_description: '',
                    phone: '07733111109',
                    message: 'اريد الاستفسار عن هذه السلعة',
                    review: '',
                    cover: '',
                },
                img_preview: [],
                cover_preview: null,
                imgExt: ['png', 'jpg', 'bmp', 'jpeg', 'gif', 'tiff', 'jfif'],
                imgEmpty: false,
                sub: []
            }
        },
        methods:{
            createProd(){
                if(!this.img_preview){
                    return this.imgEmpty = true
                }else{
                    this.imgEmpty = false
                    Inertia.post('/products', this.products)
                }
            },
            onChange(e){
                this.products.categories_id = e.target.options[e.target.options.selectedIndex].value
                let index = 0
                for(let i=0;i < this.subcat.length;i++){
                    if(this.subcat[i].categories_id == this.products.categories_id){
                        this.sub[index] = this.subcat[i]
                        index++
                    }
                }
            },
            onChangeSub(e){
                this.products.sub_cats_id = e.target.options[e.target.options.selectedIndex].value
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
            InputImages(e){
                for (let i = 0;i< e.target.files.length;i++){
                    var flag = 0
                    if (this.imgExt.includes(e.target.files[i].name.split('.').pop())){
                        flag +=1
                    }else{
                        alert('رجاء قم بأختيار صورة مناسبة')
                    }
                    if ( (e.target.files[i].size) <= 2097152){
                        flag +=1
                    }else{
                        alert('يجب ان لا يتجاوز حجم الصورة 2MB')
                    }
                    if(flag >=2){
                        this.img_changed = true
                        this.products.img_url.push(e.target.files[i])
                        this.img_preview.push(URL.createObjectURL(e.target.files[i]))
                    }
                }
            },
            inputCover(e){
                console.log(e)
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
                    this.products.cover = e.target.files[0]
                    this.cover_preview = URL.createObjectURL(e.target.files[0])
                }
            },
            removeImgPreview(e){
                this.products.img_url.splice(this.products.img_url.indexOf(e), 1);
                this.img_preview.splice(this.img_preview.indexOf(e), 1);
            },
            removeCoverPreview(e){
                this.products.cover = null
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
