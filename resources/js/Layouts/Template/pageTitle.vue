<template>
    <Head>
        <title>{{ title }}</title>
        <meta head-key="description" name="description" :content="description ? description : 'Here all what you want'">
     </Head>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Head,
    },
    props: ['title', 'description']
}
</script>
