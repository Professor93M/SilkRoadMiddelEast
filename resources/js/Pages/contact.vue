<template>
    <pageTitle title="اتصل بنا" />
    <div class="bg-gray-700">
        <navBar :logged="auth.user" />
            <h1 class="headers md:mx-24 flex justify-center text-2xl font-extrabold text-yellow-500 hover:text-gray-300 select-none transition duration-500 font-weight-bolder my-5">
                اتصل بنا
            </h1>

            <div class="mx-4">
                <!-- الفرع الاول -->
                <div class="grid lg:grid-cols-2 grid-cols-1 text-lg justify-items-center my-16 pt-4">
                    <div class="m-auto text-center font-bold text-gray-400 space-y-6 pb-3">
                        <p class="text-2xl text-yellow-500 bg-gray-900 py-2 px-5 rounded-lg">مايكـــرو للتقســيط</p>
                        <!-- <p class="text-yellow-500 font-bold">مايكرو للتقسيط</p> -->
                        <p dir="ltr">
                            شط العرب - باب الهوى
                            <fa icon="map-marker-alt" class="text-xl text-blue-400 mx-2 animate-bounce" />
                        </p>
                        <div dir="ltr" class="space-x-3 hvr-buzz-out">
                            <a href="tel:+9647701234567" class="tracking-widest text-xl">+964 770 123 4567</a>
                            <fa icon="phone" class="text-xl text-green-400" />
                        </div>
                        <div dir="ltr" class="space-x-3 flex items-center justify-center">
                            <a href="#" class="tracking-widest text-xl hover:text-gray-300">مايكرو للتقسيط</a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#0092ff" class="bi bi-facebook inline" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                            </svg>
                        </div>
                    </div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d693.4015679790471!2d47.79566424730726!3d30.59190670504644!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fc49fc5babf9bab%3A0xda68a9d5c43b9cf7!2z2YXYp9mK2YPYsdmIINmE2YTYqtmC2LPZiti3INmI2KfZhNin2YTZg9iq2LHZiNmG2YrYp9iq!5e0!3m2!1sar!2siq!4v1630680820214!5m2!1sar!2siq" width="400" height="300" style="border:0;" allowfullscreen="" class="mb-3 rounded-lg" loading="lazy"></iframe>
                </div>

                <!-- الفرع الثاني -->
                <div class="grid lg:grid-cols-2 grid-cols-1 text-lg justify-items-center my-16">
                    <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m24!1m12!1m3!1d859.4882012426712!2d47.81853482064169!3d30.494086083227337!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m9!3e6!4m3!3m2!1d30.497177599999997!2d47.8019584!4m3!3m2!1d30.494239999999998!2d47.81869!5e0!3m2!1sen!2siq!4v1628354845058!5m2!1sen!2siq" width="400" height="300" style="border:0;" allowfullscreen="" class="mb-3 rounded-lg" loading="lazy"></iframe> -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3436.2309069164785!2d47.803447485135116!3d30.542779581703662!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fc499909da12e39%3A0xf7a64ac6605e92bb!2z2LTYsdmD2Kkg2YXYp9mK2YPYsdmIINmE2YTYqtmC2LPZiti3!5e0!3m2!1sar!2siq!4v1630680687867!5m2!1sar!2siq" width="400" height="300" style="border:0;" allowfullscreen="" class="mb-3 rounded-lg" loading="lazy"></iframe>
                        <div class="m-auto text-center font-bold text-gray-400 space-y-6 pb-3 order1">
                        <p class="text-2xl text-yellow-500 bg-gray-900 py-2 px-5 rounded-lg">مايكـــرو للتقســيط</p>
                        <!-- <p class="text-yellow-500 font-bold">مايكرو للتقسيط</p> -->
                        <p dir="ltr">
                            الجبيلة - شارع المصلحة
                            <fa icon="map-marker-alt" class="text-xl text-blue-400 mx-2 animate-bounce" />
                        </p>
                        <div dir="ltr" class="space-x-3 hvr-buzz-out">
                            <a href="tel:+9647701234567" class="tracking-widest text-xl">+964 770 123 4567</a>
                            <fa icon="phone" class="text-xl text-green-400" />
                        </div>
                        <div dir="ltr" class="space-x-3 flex items-center justify-center">
                            <a href="#" class="tracking-widest text-xl hover:text-gray-300">OutWorld</a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#0092ff" class="bi bi-facebook inline" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- الفرع الثالث -->
                <div class="grid lg:grid-cols-2 grid-cols-1 text-lg justify-items-center my-16">
                    <div class="m-auto text-center font-bold text-gray-400 space-y-6 pb-3">
                        <p class="text-2xl text-yellow-500 bg-gray-900 py-2 px-5 rounded-lg">مايكـــرو للتقســيط</p>
                        <!-- <p class="text-yellow-500 font-bold">مايكرو للتقسيط</p> -->
                        <p dir="ltr">
                            شط العرب - التنومة - مقابل شارع 24
                            <fa icon="map-marker-alt" class="text-xl text-blue-400 mx-2 animate-bounce" />
                        </p>
                        <div dir="ltr" class="space-x-3 hvr-buzz-out">
                            <a href="tel:+9647701234567" class="tracking-widest text-xl">+964 770 123 4567</a>
                            <fa icon="phone" class="text-xl text-green-400" />
                        </div>
                        <div dir="ltr" class="space-x-3 flex items-center justify-center">
                            <a href="#" class="tracking-widest text-xl hover:text-gray-300">رايزن</a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#0092ff" class="bi bi-facebook inline" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                            </svg>
                        </div>
                    </div>
                    <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m24!1m12!1m3!1d859.4882012426712!2d47.81853482064169!3d30.494086083227337!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m9!3e6!4m3!3m2!1d30.497177599999997!2d47.8019584!4m3!3m2!1d30.494239999999998!2d47.81869!5e0!3m2!1sen!2siq!4v1628354845058!5m2!1sen!2siq" width="400" height="300" style="border:0;" allowfullscreen="" class="mb-3 rounded-lg" loading="lazy"></iframe> -->
                    <img loading="lazy" class="mb-3 rounded-lg opacity-50 hover:opacity-100 transition duration-500" src="../../../public/images/r.jpg" alt="">
                </div>
            </div>


        <whatsapp />
        <Footer />
    </div>
</template>

<script>
    import navBar from '@/Layouts/Template/nav'
    import whatsapp from '@/Layouts/Template/whatsapp'
    import Footer from '@/Layouts/Template/footer'
    import pageTitle from "../Layouts/Template/pageTitle";

export default {
    components:{
        navBar,
        Footer,
        whatsapp,
        pageTitle,
    },
    props: {
        auth: Object,
    }
}
</script>

<style scoped>
  .headers::before, .headers::after{
    content: "";
    flex: 1 1;
    border-bottom: 2px solid #a7a7a7;
    margin: 20px;
    opacity: .3;
  }

  @media screen and (max-width: 1024px) {
        .order1{
            order: -1
        }
    }

</style>
