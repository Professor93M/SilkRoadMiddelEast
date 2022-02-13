<template>
    <inertia-link :href="`/${url}/${cat_id}`" class="rounded-lg">
        <div dir="ltr" class="size size2 mx-2 bg-gray-700 mt-2 border-2 rounded-full transform hover:scale-110 motion-reduce:transform-none transition duration-500">
            <img loading="lazy" :src="'images/' + img" class="image rounded-full" alt="...">
        </div>
        <div class="card-body text-center my-0">
            <h5 class="card-title font-extrabold text-gray-300 my-0">{{cat_name}}</h5>
        </div>
    </inertia-link>
</template>

<script>
export default {
    props: {
        img: String,
        cat_id: Number,
        cat_name: String,
        url: String,
    }
}
</script>

<style>
    .size{
        height: 180px;
        width: 200px;
    }
    .image{
        height: 100%;
        width: 100%;
    }

    @media screen and (max-width: 800px) {
        .size2{
            height: 130px;
            width: 150px;
        }
    }
</style>
