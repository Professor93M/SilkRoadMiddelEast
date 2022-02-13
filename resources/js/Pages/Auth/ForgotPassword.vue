<template>
    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <breeze-validation-errors class="mb-4" />

    <form @submit.prevent="submit">
        <p class="text-center text-bold text-2xl text-gray-400 mb-3">اعادة كلمة المرور</p>
        <div>
            <breeze-label for="email" value="البريد الالكتروني" />
            <breeze-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
        </div>

        <div class="flex items-center justify-center mt-4">
            <breeze-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                ارسل رابط اعادة كلمة المرور
            </breeze-button>
        </div>
    </form>
    <div class="text-center text-sm font-medium text-gray-400 mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 animate-bounce mx-auto text-yellow-300 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
        نسيت كلمة المرور؟  لا عليك فقط قم بكتابة البريد الالكتروني الذي قمت بالتسجيل به ثم سنقوم بأرسال بريد لاعادة كلمة المرور.
    </div>
</template>

<script>
    import BreezeButton from '@/Components/Auth/Button'
    import BreezeGuestLayout from "@/Layouts/Auth/Guest"
    import BreezeInput from '@/Components/Auth/Input'
    import BreezeLabel from '@/Components/Auth/Label'
    import BreezeValidationErrors from '@/Components/Auth/ValidationErrors'

    export default {
        layout: BreezeGuestLayout,

        components: {
            BreezeButton,
            BreezeInput,
            BreezeLabel,
            BreezeValidationErrors,
        },

        props: {
            auth: Object,
            errors: Object,
            status: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.email'))
            }
        }
    }
</script>
