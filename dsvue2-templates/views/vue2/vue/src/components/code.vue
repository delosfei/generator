<template>
    <div class="mt-4 flex flex-col justify-between">
        <el-input v-model="account" placeholder="请输入邮箱或手机号" @input="$emit('update:modelValue', $event)" class="mb-3" />
        <hd-error name="account" />
        <div class="flex justify-between">
            <el-input v-model="code" @input="$emit('update:code', $event)" placeholder="请输入收到的验证码" clearable></el-input>
            <el-button @click="sendCode" class="ml-1" type="danger">发送验证码</el-button>
        </div>
        <hd-error name="code" />
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmit } from 'vue'
import codeApi from 'api/codeApi'

const props = defineProps(['modelValue', 'code', 'type'])
const account = ref(props.modelValue)

const code = ref('')
const emit = defineEmit(['update:modelValue', 'update:code'])

const sendCode = async () => {
    codeApi.send(account.value)
}
</script>

<style>
</style>
