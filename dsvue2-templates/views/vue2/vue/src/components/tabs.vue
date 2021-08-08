<template>
    <div class="flex border-b border-gray-200 font-bold text-gray-600">
        <router-link
            :to="tab.route"
            class="px-5 pb-3 cursor-pointer"
            :class="{ active: isCurrentRoute(tab) }"
            v-for="(tab, index) in data"
            :key="index"
            v-show="!tab.current || isCurrentRoute(tab)"
        >{{ tab.title }}</router-link>
    </div>
</template>

<script setup>
import { ref, defineProps } from 'vue'
import { useRoute } from 'vue-router'
const route = useRoute();
// const props = defineProps(['data'])

// 获取配置文件
const configFile = `../views/` + route.path.split('/').slice(0, -1).join('/').substr(1) + '/tabs.js';
const data = await import(configFile).then(_ => _.default)







const activeName = ref('name-0')
const isCurrentRoute = (tab) => {
    return tab.route.name == route.name || tab.route.path == route.path
}
</script>

<style lang="scss" scoped>
.active {
    @apply border-b-2 border-blue-600;
}
</style>
