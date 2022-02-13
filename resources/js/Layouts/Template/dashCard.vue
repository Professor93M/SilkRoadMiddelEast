<template>
    <div class="m-3 rounded-lg hvr-grow shadow-lg opacity-80 transition duration-700">
        <inertia-link :href="link" :class="bgTitle" class="text-xl my-2 py-2 font-bold text-center filter drop-shadow-2xl text-white block">{{ title }}</inertia-link>
        <div class="flex justify-between items-center m-2 p-3 rounded-lg text-white">
            <div class="inline space-y-2">
                <inertia-link :href="link1" class="block">{{ text1 }} : &nbsp;              <span class="font-bold text-black">( {{ count1 }} )</span></inertia-link>
                <inertia-link :href="link2" v-if="text2" class="block">{{ text2 }} : &nbsp; <span class="font-bold text-black">( {{ count2 }} )</span></inertia-link>
                <inertia-link :href="link3" v-if="text3" class="block">{{ text3 }} : &nbsp; <span class="font-bold text-black">( {{ count3 }} )</span></inertia-link>
            </div>
            <fa :icon="icon" class="md:text-6xl sm:text-5xl text-3xl opacity-40 float-left inline" />
        </div>
    </div>
</template>

<script>

export default {
    props:['title', 'text1', 'text2', 'count1', 'count2', 'text3', 'count3', 'icon', 'link', 'link1', 'link2', 'link3', 'bgTitle']
}
</script>

