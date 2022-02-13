<template>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb flex justify-items-center items-center text-lg mr-5 mt-3">
            <li class="breadcrumb-item text-white mx-2"><inertia-link :href="url1" class="hover:text-yellow-500 transition duration-500">{{ title1 }}</inertia-link></li>
            <fa icon="angle-double-left" class="text-gray-400" />
            <li class="breadcrumb-item mx-2" :class="active2 ? 'active select-none' : 'text-white hover:text-yellow-500 transition duration-500'"><inertia-link :href="url2" class="hover:text-yellow-500 transition duration-500">{{ title2 }}</inertia-link></li>
            <fa v-if="title3" icon="angle-double-left" class="text-gray-400" />
            <li class="breadcrumb-item mx-2" v-if="title3" :class="active3 ? 'active select-none' : 'text-white hover:text-yellow-500 transition duration-500'" :href="url3">{{ title3 }}</li>
        </ol>
    </nav>
</template>

<script>
export default {
    props: ['title1', 'url1', 'title2', 'url2', 'active2', 'title3', 'url3', 'active3'],
}
</script>
