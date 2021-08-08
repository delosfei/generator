<template>
    <el-form-item :label="label">
        <hd-upload-image v-model="value" />
        <hd-error :name="name" />
    </el-form-item>
</template>

<script>
export default {
    props: ["label", 'name', "modelValue"],
    data() {
        return { value: this.modelValue };
    },
    watch: {
        value(n) {
            this.$emit("update:modelValue", this.value);
        },
    },
};
</script>

<style>
</style>
