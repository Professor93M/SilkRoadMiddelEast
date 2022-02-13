<template>
    <breeze-validation-errors class="mb-4" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <form @submit.prevent="submit">
        <p class="text-center text-bold text-2xl text-gray-400 mb-3">Login</p>
        <div>
            <breeze-label for="email" value="Email" />
            <breeze-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
        </div>

        <div class="mt-4">
            <breeze-label for="password" value="Password" />
            <breeze-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
        </div>

        <div class="block mt-4">
            <label class="flex items-center">
                <breeze-checkbox name="remember" v-model:checked="form.remember" />
                <span class="mr-2 text-sm text-gray-400">Remember Me</span>
            </label>
        </div>

        <div class="mt-4 text-center">
            <breeze-button class="py-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Login
            </breeze-button>
        </div>
    </form>
</template>

<script>
    import BreezeButton from '@/Components/Auth/Button'
    import BreezeGuestLayout from "@/Layouts/Auth/Guest"
    import BreezeInput from '@/Components/Auth/Input'
    import BreezeCheckbox from '@/Components/Auth/Checkbox'
    import BreezeLabel from '@/Components/Auth/Label'
    import BreezeValidationErrors from '@/Components/Auth/ValidationErrors'

    export default {
        layout: BreezeGuestLayout,

        components: {
            BreezeButton,
            BreezeInput,
            BreezeCheckbox,
            BreezeLabel,
            BreezeValidationErrors
        },

        props: {
            auth: Object,
            canResetPassword: Boolean,
            errors: Object,
            status: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('login'), {
                    onFinish: () => this.form.reset('password'),
                })
            }
        }
    }
</script>
