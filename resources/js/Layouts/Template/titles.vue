<template>
    <h1 class="h1 headers md:mx-24 flex justify-center text-2xl font-extrabold text-gray-300 font-weight-bolder mt-5 mb-3 select-none hover:text-yellow-500 transition duration-500">
    {{text}}
    </h1>
</template>

<script>
export default {
    props:['text']
}
</script>

<style scoped>
  .headers::before,.headers::after{
    content: "";
    flex: 1 1;
    border-bottom: 2px solid;
    margin: 20px ;
    opacity: 0.3;

  }
</style>
