<template>
    <router-view />
</template>

<script>
export default {
    //要求游客操作
    route: { meta: { guest: true } }
}
</script>

