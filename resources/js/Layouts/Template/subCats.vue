<template>
    <div class="grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 justify-items-center">
      <div dir="ltr" v-for="(cat, index) in subCats.data" :key="index" class="bg-gray-700 p-3 m-4 shadow-lg rounded-lg">
        <categories :cat_id="cat.id" :cat_name="cat.cat_name" :img="cat.image.img_url" url="subcats" />
      </div>
    </div>
</template>

<script>
    // import Card from '@/Layouts/Template/Card'
    import categories from '@/Layouts/Template/categories'

export default {
    components:{
        categories,
    },
    props: ['subCats'],
    data() {
        return {

        }
    },
    methods: {

    },
}
</script>
