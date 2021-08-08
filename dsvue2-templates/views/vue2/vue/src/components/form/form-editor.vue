<template>
    <el-form-item :label="label">
        <!-- <el-input
            v-model="value"
            :type="type"
            @keyup="$emit('update:modelValue', value)"
        ></el-input> -->
        <hd-editor v-model="value" />
        <hd-error :name="name" />
    </el-form-item>
</template>

<script>
export default {
    props: ['label', 'modelValue', 'type', 'name'],
    data() {
        return { value: this.modelValue }
    },
    watch: {
        value(n) {
            this.$emit('update:modelValue', n)
        }
    }
}
</script>

<style>
</style>
