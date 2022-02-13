<template>
    <div class="vh-100 d-flex justify-center align-items-center">
        <template v-if="!$page.props.auth.user">
            <div class="text-center mb-4">
                <div class="text-bold mb-5 text-3xl text-white text-center">
                    مرحبا بك في Micro Store حيث كل ما هو جديد
                </div>
                <!-- <div class="mt-5">
                    <inertia-link :href="route('login')" class="text-dark mx-3 p-3 bg-light rounded-1">
                        تسجيل الدخول
                    </inertia-link>
                    <inertia-link v-if="canRegister" :href="route('register')" class="text-white mx-3 p-3 border-3 rounded-1">
                        مستخدم جديد
                    </inertia-link>
                </div> -->
            </div>
        </template>
        <template v-else>
            <div class="text-center text-white text-4xl">
                <div>
                    مرحبا بك يا <span class="text-warning">{{ $page.props.auth.user.name }}</span> في Micro Store
                </div>
                <div class="mt-3 underline">
                    <inertia-link v-if="$page.props.auth.user" href="/dashboard">
                        اضغط هنا للدخول الى لوحة التحكم
                    </inertia-link>
                </div>
            </div>
        </template>
    </div>

</template>

<script>
    export default {
        props: {
            auth: Object,
            canLogin: Boolean,
            canRegister: Boolean,
        }
    }
</script>
