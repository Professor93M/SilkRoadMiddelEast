<template>
    <span @click="right" class="carousel-control-next-icon flex opacity-50 hover:opacity-100 cursor-pointer"></span>
    <!-- <span @click="left" class="carousel-control-prev-icon flex opacity-50 hover:opacity-100 cursor-pointer"></span> -->
</template>

<script>
export default {
    props: {
        id: String,
    },
    methods:{
        right(){
        let s = document.getElementById('id')
        s.scrollLeft -= 100
        },
        left(){
        let s = document.getElementById('id')
        s.scrollLeft += 100
        },
    }
}
</script>