<template>
    <div
        class="text-xs text-red-600 mt-2 font-bold"
        v-show="$store.getters.errors(name)"
    >
        <i class="fas fa-info-circle"></i>
        {{ $store.getters.errors(name) }}
    </div>
</template>

<script>
export default {
    props: ["name"]
};
</script>

<style></style>
