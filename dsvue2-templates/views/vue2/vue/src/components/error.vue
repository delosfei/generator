<template>
    <div class="text-red-700 text-xs mt-1 mb-2" v-if="message">
        <i class="fas fa-info-circle mr-1"></i>
        {{ message }}
    </div>
</template>

<script setup>
import { defineProps, computed } from 'vue'
import { useStore } from 'vuex'
const props = defineProps({
    name: String
})
const store = useStore()

const message = computed(() => {
    return store.getters['error/get'](props.name)
})
</script>

<style></style>
