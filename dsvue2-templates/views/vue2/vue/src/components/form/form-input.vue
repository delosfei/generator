<template>
    <el-form-item :label="label">
        <el-input
            v-model="value"
            :type="type"
            @keyup="$emit('update:modelValue', value)"
        ></el-input>
        <hd-error :name="name" />
    </el-form-item>
</template>

<script>
export default {
    props: ["label", "modelValue", "type", "name"],
    data() {
        return { value: this.modelValue };
    },
};
</script>

<style>
</style>
