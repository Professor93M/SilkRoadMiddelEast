<template>
    <div class="bg-gray-700">
        <navBar :logged="auth.user" />
        <div class="flex justify-center opacity-70">
            <input :disabled="!$store.state.cart.length >= 1" @click.prevent="x=1" type="button" :class="x==1 ? 'btn-danger z-10' : 'btn-secondary'" class="btn btn-secondary btn-lg  w-80 mr-9 rounded-tr-none rounded-tl-none rounded-bl-full rounded-br-full focus:ring-0 z-10" value="السلة">
            <input v-if="$store.state.cart.length >= 1" @click.prevent="submitCart" type="button" :class="x==2 ? 'btn-danger z-10' : 'btn-secondary'" class="btn btn-secondary btn-lg  w-80 -mr-9 rounded-tr-none rounded-tl-none rounded-bl-full rounded-br-full focus:ring-0" value="ادخال البيانات">
        </div>

        <!-- +++++++++ Start Cart Template +++++++++ -->
        <template v-if="$store.state.cart.length >= 1">
            <template v-if="x==1">
                <div>
                    <pageTitle title="السلة" />
                    <div v-for="(cart, index) in carts" :key="index" class="bg-gray-700 mx-5 mt-3">
                        <div v-if="$store.state.cart.includes(cart.id.toString())">
                            <div class="flex lg:flex-nowrap flex-wrap lg:justify-between justify-center rounded-lg my-4 shadow-lg align-items-center border-2 border-opacity-10 border-gray-400">
                                <div class="m-4 w-full md:max-w-70 max-w-80 relative">
                                    <inertia-link dir="rtl" :href="`/product/${cart.id}`" class="relative md:left-0 text-xl text-gray-200 hover:text-yellow-500 transition duration-500">{{ cart.pd_name }}</inertia-link>
                                    <button @click="removeProd(cart.id)" class="btn btn-outline-danger text-gray-400 md:hidden inline absolute posCart cursor-pointer rounded-lg text-lg opacity-70 transition duration-300"><fa icon="times" /></button>
                                    <span class="block border-b-2 border-gray-400 border-opacity-30 mt-1"></span>
                                    <textarea readonly dir="rtl" name="descriptionCart" id="textarea" rows="6" v-model="cart.pd_description" class="cursor-default mt-3 font-medium text-gray-400 bg-gray-700 border-2 border-gray-400 border-opacity-20 rounded-lg w-full foucs"></textarea>
                                    <div>
                                        <div class="text-gray-400 text-center mt-2 flex justify-center text-xl font-light antialiased">
                                            <p class="price text-3xl tracking-widest text-yellow-500 px-2 font-extrabold">{{Number(cart.pd_price).toLocaleString('en-US')}}<span class="text-base text-gray-400 px-2">USD</span></p>  $
                                        </div>
                                        <div class="flex md:justify-between justify-center items-center my-1">
                                            <div class="flex justify-center items-center">
                                                <button @click="removeProd(cart.id)" class="md:block hidden btn btn-outline-danger text-gray-400 transition py-2 px-3 duration-500">
                                                    <fa icon="times" />
                                                </button>
                                            </div>
                                            <div>
                                                <div class="flex justify-center items-center">
                                                    <p class="text-gray-400 text-xl font-extrabold mx-2">الكمية</p>
                                                    <inputNumber :max="cart.pd_stack > 10 ? 10 : cart.pd_stack" :min="count[index] ? count[index] : min" @inc="inc($event, index)" @dec="inc($event,index)" class="mx-2" />
                                                </div>
                                                <p v-if="cart.pd_stack <= 10" class="text-gray-400 text-center mt-3">يتوفر منه ( <span class="text-yellow-500">{{ cart.pd_stack }}</span> )</p>
                                                <p v-if="cart.pd_stack > 10" class="text-gray-400 text-center mt-3">يتوفر منه اكثر من ( <span class="text-yellow-500">10</span> )</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <inertia-link class="m-4 size2" :href="`/product/${cart.id}`">
                                    <img loading="lazy" :src="'images/'+cart.images[0].img_url" class="image mx-auto img-thumbnail my-2 shadow-lg">
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <input @click.prevent="submitCart" type="submit" class="btn btn-outline-secondary w-40 p-2 mb-5 mt-3 border-2 border-gray-400 text-yellow-500 font-extrabold text-lg" value="موافق">
                    </div>
                </div>
            </template>
        </template>
        <template v-else>
            <div class="text-center mt-5 w-7/12 mx-auto">
                <p class="text-3xl text-gray-400 bg-gray-800 text-center p-2 rounded-lg">السلة فارغة, قم بالشراء اولاً</p>
                <inertia-link class="lead text-decoration-none text-blue-300 btn btn-outline-secondary btn-lg mt-3 px-4 hover:text-yellow-400" href="/product">قائمة جميع السلع</inertia-link>
            </div>

        </template>
        <!-- +++++++++ End Cart Template +++++++++ -->

        <!-- +++++++++ Start Order Template +++++++++ -->

        <template v-if="x==2">
            <pageTitle title="ادخال البيانات" />
            <div class="grid lg:grid-cols-2 grid-cols-1 mx-5 items-baseline">
                <div class="flex justify-center">
                    <form class="mt-5 mb-3 space-y-7">

                        <div class="flex justify-start">
                            <div class=" ml-2">
                                <label for="first_name" class="block text-right text-gray-300 mr-2 mb-2">الاسم الاول <span class="text-red-400">*</span></label>
                                <div class="mt-1 relative rounded-md">
                                    <input name="first_name" type="text" v-model="order.first_name" placeholder="ادخل اسمك" class="bg-gray-700 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md w-full placeholder-opacity-50" />
                                </div>
                                <small class="text-red-300 mr-auto mb-3">{{ errors.first_name }}</small>
                            </div>
                            <div class="mr-2">
                                <label for="last_name" class="block text-right text-gray-300 mr-2 mb-2">اسم العائلة <span class="text-red-400">*</span></label>
                                <div class="mt-1 relative rounded-md">
                                    <input name="order['last_name']" type="text" v-model="order.last_name" placeholder="ادخل اسم العائلة (الاب)" class="bg-gray-700 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md w-full placeholder-opacity-50" />
                                </div>
                                <small class="text-red-300 mr-auto mb-3">{{ errors.last_name }}</small>
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-right text-gray-300 mx-2 mb-2">البريد الالكتروني</label>
                            <div class="mt-1 relative rounded-md">
                                <input type="email" v-model="order.email" placeholder="example@domain.com" class="bg-gray-700 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md w-full" />
                            </div>
                            <small class="text-red-300 mr-auto mb-3">{{ errors.email }}</small>
                        </div>

                        <div class="flex justify-start">
                            <div class=" ml-2">
                                <label for="mobile" class="block text-right text-gray-300 mr-2 mb-2">رقم الهاتف <span class="text-red-400">*</span></label>
                                <div class="mt-1 relative rounded-md">
                                    <input type="tel" title="يجب ادخال الارقام باللغة الانكليزية" v-model="order.mobile" placeholder="07X0 000 0000" class="bg-gray-700 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md w-full" />
                                </div>
                                <small class="text-red-300 mr-auto mb-3">{{ errors.mobile }}</small>
                            </div>
                            <div class="mr-2">
                                <label for="mobile2" class="block text-right text-gray-300 mr-2 mb-2">رقم الهاتف (احتياطي)</label>
                                <div class="mt-1 relative rounded-md">
                                    <input type="tel" v-model="order.mobile2" placeholder="07X0 000 0000" class="bg-gray-700 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md w-full" />
                                </div>
                                <small class="text-red-300 mr-auto mb-3">{{ errors.mobile2 }}</small>
                            </div>
                        </div>

                        <div>
                            <label for="governorate" class="block text-right text-gray-300 mx-2 mb-2">المحافظة <span class="text-red-400">*</span></label>
                            <div class="mt-1 relative rounded-md">
                                <select @change="onChange($event)" class="bg-gray-700 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md w-full leading-5">
                                    <option disabled selected value="">رجاء اختر محافظتك</option>
                                    <option class="leading-5" value="اربيل">اربيل</option>
                                    <option value="الانبار">الانبار</option>
                                    <option value="بابل">بابل</option>
                                    <option value="بغداد">بغداد</option>
                                    <option value="البصرة">البصرة</option>
                                    <option value="ديالى">ديالى</option>
                                    <option value="ذي قار">ذي قار</option>
                                    <option value="السليمانية">السليمانية</option>
                                    <option value="صلاح الدين">صلاح الدين</option>
                                    <option value="كركوك">كركوك</option>
                                    <option value="كربلاء">كربلاء</option>
                                    <option value="المثنى">المثنى</option>
                                    <option value="ميسان">ميسان</option>
                                    <option value="النجف">النجف</option>
                                    <option value="نينوى">نينوى</option>
                                    <option value="واسط">واسط</option>
                                </select>
                            </div>
                            <small class="text-red-300 mr-auto mb-3">{{ errors.governorate }}</small>
                        </div>

                        <div>
                            <label for="address" class="block text-right text-gray-300 mx-2 mb-2">عنوان السكن <span class="text-red-400">*</span></label>
                            <div class="mt-1 relative rounded-md">
                                <textarea type="text" v-model="order.address" placeholder="المنطقة واقرب نقطة دالة" class="max-height bg-gray-700 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md w-full"></textarea>
                            </div>
                            <small class="text-red-300 mr-auto mb-3">{{ errors.address }}</small>
                        </div>

                        <div class="flex justify-around">
                            <div class="flex">
                                <div class="mt-1 relative ">
                                    <input @focus="locationChange = false" type="radio" id="location1" value="0" checked name="location1" v-model="location1" class="bg-gray-700 " />
                                </div>
                                <label for="location1" class="text-right text-gray-300 mx-2">مركز المحافظة</label>
                            </div>

                            <div class="flex">
                                <div class="mt-1 relative rounded-md">
                                    <input @focus="locationChange = true" type="radio" id="location2" value="1" name="location1" v-model="location1" class="bg-gray-700 " />
                                </div>
                                <label for="location2" class="text-right text-gray-300 mx-2">اقضية ونواحي</label>
                            </div>
                        </div>

                        <div v-if="locationChange">
                            <label for="location" class="block text-right text-gray-300 mx-2 mb-2">اسم القظاء <span class="text-red-400">*</span></label>
                            <div class="mt-1 relative rounded-md">
                                <input name="location" type="text" v-model="order.location" class="bg-gray-700 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md w-full" />
                            </div>
                            <small class="text-red-300 mr-auto mb-3">{{ errors.location }}</small>
                        </div>

                        <div>
                            <label for="comment" class="block text-right text-gray-300 mx-2 mb-2">ملاحظات اخرى</label>
                            <div class="mt-1 relative rounded-md">
                                <textarea type="text" v-model="order.comment" placeholder="هل لديك ملاحظات اخرى" class="max-height bg-gray-700 text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md w-full"></textarea>
                            </div>
                        </div>

                        <div class="text-center">
                            <input @click.prevent="submitOrder" type="submit" class="btn btn-outline-secondary w-40 p-2 mb-5 mt-3 border-2 border-gray-400 text-yellow-500 font-extrabold text-lg" :disabled="order.processing || !order.first_name || !order.last_name || !order.mobile || !order.address" value="اطلب الان">
                        </div>
                    </form>
                </div>

                <div>
                    <h1 class="text-center text-2xl text-gray-400 font-extrabold mb-3">وصــل الشـــراء</h1>
                    <table class="table table-responsive text-lg bg-gray-800 text-gray-400 text-center">
                        <thead>
                            <tr class="bg-gray-400 text-gray-800 font-extrabold">
                                <th scope="col">#</th>
                                <th scope="col">السلعة</th>
                                <th scope="col">سعر المفرد</th>
                                <th scope="col">العدد</th>
                                <th scope="col">السعر</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="index in data.pd_name.length" :key="index">
                                <th scope="row">{{ index }}</th>
                                <td>{{ data.pd_name[index-1] }}</td>
                                <td>${{ Number(data.pd_price[index-1]).toLocaleString('en-US') }}</td>
                                <td>{{ data.count[index-1] }} ×</td>
                                <td>${{ Number(data.pd_price[index-1] * data.count[index-1]).toLocaleString('en-US') }}</td>
                            </tr>
                            <tr class="text-center bg-gray-900 text-gray-400 font-extrabold">
                                <td colspan="3">المبلغ الكلي</td>
                                <td colspan="2" class="text-yellow-500 tracking-widest">${{Number(this.allPrice).toLocaleString('en-US')}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <p class="text-center text-xl text-gray-400 bg-gray-800 rounded-lg p-3 my-3">
                            الدفع عند الاستلام<br>
                            سوف نقوم بجلب البضاعة اليك<br>
                            <br>
                            ان كنت ترغب بحجز البضاعة والقدوم لأستلامها في المحل هذا جائز ايضاً
                        </p>
                    </div>
                </div>
            </div>
        </template>

        <!-- +++++++++ End Order Template +++++++++ -->
        <whatsapp />
        <Footer />

    </div>
</template>

<script>
    import navBar from '@/Layouts/Template/nav'
    import inputNumber from '@/Layouts/Template/inputNumber'
    import {Inertia} from "@inertiajs/inertia";
    import Footer from '@/Layouts/Template/footer'
    import whatsapp from '@/Layouts/Template/whatsapp'
    import _ from 'lodash';
    import pageTitle from "../Layouts/Template/pageTitle";

export default {
    components:{
        navBar,
        inputNumber,
        Footer,
        whatsapp,
        pageTitle,
    },
    props:{
        carts: Object,
        cat_name: String,
        errors: Object,
        auth: Object,
    },
    methods:{
        submitCart(){
            let index = 0
            this.allPrice = 0
            for(let i=0;i<this.carts.length;i++){
                if(this.$store.state.cart.some(r=> this.carts[i].id == r)){
                    this.data.id[index] = this.carts[i].id
                    this.data.pd_name[index] = this.carts[i].pd_name
                    this.data.pd_price[index] = this.carts[i].pd_price
                    if(this.count[i]){
                        this.data.count[index] = this.count[i]
                    }else{
                        this.data.count[index] = this.min
                    }
                    this.allPrice += (this.data.count[index] * this.data.pd_price[index])
                    this.data.cart_id = this.carts[i].id
                    index++
                }
            }
            this.x = 2
        },
        submitOrder(){
            console.log(this.location1)
            if(this.location1 == 0){
                this.order.location = "مركز المحافظة"
            }else{
                this.order.location
            }
            this.$swal({
                text: 'هل انت متأكد من جميع المعلومات المدخلة',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم, اشتري',
                cancelButtonText: 'تراجع',
                }).then((result) => {
                if (result.isConfirmed) {
                    Inertia.post('/saveCarts',[this.order,this.data],{
                        onSuccess: () => {
                            let keys = Object.keys(localStorage);
                            for(let key of keys) {
                                if(key.substring(0,5) === 'carts'){
                                    this.$store.state.cart.pop()
                                    localStorage.removeItem(key)
                                }
                            }
                        }
                    })
                }
            })

        },
        onChange(e){
            this.order.governorate = e.target.options[e.target.options.selectedIndex].value
        },
        removeProd(id){
            let i = this.$store.state.cart.indexOf(id.toString())
            localStorage.removeItem('carts' + id)
            this.$store.state.cart.splice(this.$store.state.cart.indexOf(id.toString()), 1)
            this.data.pd_name.splice(i, 1)
            this.data.pd_price.splice(i, 1)
            this.data.id.splice(i, 1)
            this.data.count.splice(i, 1)
        },
        inc(v, e){
            this.count[e] = v
        },
        changeNumbers($e){
            if($e.key === "١"){
                $e.keyCode = 49
            }
            console.log($e)
        }
    },
    mounted() {
        let index = 0
        let keys = Object.keys(localStorage);
        if(this.$store.state.cart.length === 0 ){
            for(let [i,key] of keys.entries()) {
                if(key.substring(0,5) === 'carts'){
                    this.$store.state.cart.push(localStorage.getItem(key));
                    index++
                }
            }
        }
        document.onreadystatechange = () => {
            if (document.readyState == "complete") {
                let index = 0
                for(let i=0;i<this.carts.length;i++){
                    if(this.$store.state.cart.some(r=> this.carts[i].id == r)){
                        this.price[index] = this.carts[i].pd_price
                        index++
                    }
                }
            }
        }
    },
    data() {
        return {
            x:1,
            max: 10,
            min: 1,
            price: [],
            allPrice: 0,
            count: [],
            locationChange: false,
            location1: 0,
            data:{
                id: [],
                pd_name:[],
                pd_price: [],
                count: [],
                cart_id: null,
            },
            order:{
                first_name: '',
                last_name: '',
                email: '',
                mobile: '',
                mobile2: '',
                address: '',
                location: '',
                governorate: '',
                comment: '',
            }
        }
    },
}
</script>

<style scope>
    .max-height{
        max-height: 250px;
    }
    .swal2-popup{
        display: block !important;
    }
    .image{
        height: 250px;
        width: 100%;
    }
    .size{
        width: 50%;
    }
    @media screen and (min-width: 800px) {
        .size2{
            width: 40%;
        }
    }
    @media screen and (min-width: 1000px) {
        .size2{
            width: 20%;
        }
    }
    #textarea{
        resize:none;
    }
    #textarea::-webkit-scrollbar {
        display: none;
    }
    .posCart{
        top: -22px;
        left: -26px;
    }
    .foucs:focus {
        border-color: #4B5563 !important;
        box-shadow: none !important;
    }
</style>
