<template>
    <Head>
        <title>{{ title }} - مايكرو للتقسيط</title>
        <meta head-key="description" name="description" :content="description ? description : 'شركة مايكرو للتقسيط للبيع المباشر وبالتقسيط المريح حيث كل ماهو جديد ومميز'">
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
