<template>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item" v-for="(tab, index) in tabs" :key="index">
            <router-link
                :to="{ name: tab.name }"
                class="nav-link"
                :class="{ active: $route.name == tab.name }"
                v-if="!tab.current || $route.name == tab.name"
            >
                {{ tab.title }}
            </router-link>
        </li>
    </ul>
</template>

<script>
export default {
    props: ["tabs"]
};
</script>

<style></style>
