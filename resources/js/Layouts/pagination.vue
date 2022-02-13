<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap -mb-1">
      <template v-for="(page, index) in links" :key="index">
        <Link v-if="links[index].url"
                    :href="links[index].url">
            <span class="rounded-2 px-2 py-1 text-white text-sm ml-1 hover:bg-red-900"
                :class="[ links[index].active ? 'bg-dark cursor-default disabled' : 'bg-red-600' ]"
                v-html='links[index].label'>
            </span>
        </Link>
      </template>
    </div>
  </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'

export default {
    components:{
        Link,
    },
    props: {
        links: Array,
    },
}
</script>
