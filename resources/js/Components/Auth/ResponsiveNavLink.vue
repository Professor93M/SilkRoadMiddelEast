<template>
    <inertia-link :class="classes">
        <slot />
    </inertia-link>
</template>

<script>
    export default {
        props: ['active'],

        computed: {
            classes() {
                return this.active
                    ? 'block pl-3 pr-4 py-2 font-medium text-gray-100 hover:text-gray-400 font-extrabold font-mono transition duration-150 ease-in-out w-100'
                    : 'block pl-3 pr-4 py-2 font-medium text-gray-100 hover:text-gray-400 font-extrabold font-mono transition duration-150 ease-in-out w-100'
            }
        }
    }
</script>
