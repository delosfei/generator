<template>
    <div class="mt-4 flex flex-col justify-between">
        <div class="flex justify-between">
            <el-input v-model="value" @change="change" placeholder="请输入图形验证码" clearable></el-input>
            <img :src="captcha.img" class="cursor-pointer ml-1 border rounded-t-md" @click="loadCaptcha()" />
        </div>
        <hd-error name="captcha" />
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmit } from 'vue'
import { captcha, loadCaptcha } from 'composable/useCaptcha'

const props = defineProps(['modelValue', 'key'])

const emit = defineEmit(['update:modelValue', 'update:key'])
const value = ref(props.modelValue)

const change = () => {
    emit('update:modelValue', value)
    emit('update:key', captcha.key)
}
</script>

<style>
</style>
