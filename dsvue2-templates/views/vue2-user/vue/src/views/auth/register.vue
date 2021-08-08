<template>
    <div class="bg-blue-400 h-screen w-screen flex items-center justify-center">
        <div class="flex w-full bg-white rounded-lg shadow-lg overflow-hidden mx-auto max-w-sm lg:max-w-4xl">
            <div class="hidden lg:block lg:w-1/2 bg-cover" style="background-image: url('/images/register.jpeg')"></div>
            <div class="w-full p-8 lg:w-1/2">
                <h2 class="text-2xl font-semibold text-gray-700 text-center">注册</h2>
                <!-- <p class="text-xl text-gray-600 text-center">Welcome back!</p> -->

                <div class="mt-4 flex items-center justify-between">
                    <span class="border-b w-1/5 lg:w-1/4"></span>
                    <a href="#" class="text-xs text-center text-gray-500 uppercase">社区欢迎你的加入</a>
                    <span class="border-b w-1/5 lg:w-1/4"></span>
                </div>
                <div class="mt-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">帐号</label>
                    <hd-code v-model="form.account" v-model:code="form.code" />
                </div>
                <div class="mt-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">昵称</label>
                    <el-input v-model="form.name" placeholder="起个有个性的昵称吧" />
                    <hd-error name="name" />
                </div>
                <div class="mt-4">
                    <div class="flex justify-between">
                        <label class="block text-gray-700 text-sm font-bold mb-2">密码</label>
                        <router-link to="forget-password" class="text-xs text-gray-500">忘记密码?</router-link>
                    </div>
                    <el-input v-model="form.password" type="password" />
                    <hd-error name="password" />
                </div>
                <div class="mt-4">
                    <div class="flex justify-between">
                        <label class="block text-gray-700 text-sm font-bold mb-2">确认密码</label>
                    </div>
                    <el-input type="password" v-model="form.password_confirmation" />
                </div>
                <div class="mt-8">
                    <button @click="register" class="bg-blue-500 text-white font-bold py-3 px-4 w-full rounded hover:bg-blue-600">注册</button>
                </div>
                <div class="mt-4 flex items-center justify-center">
                    <router-link to="login" class="no-underline hover:underline text-blue-dark text-xs"> 会员登录 </router-link>
                    <span class="px-1"> · </span>
                    <router-link class="no-underline hover:underline text-blue-dark text-xs" to="/"> 网站首页 </router-link>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { reactive } from 'vue'
import helper from 'utils/helper'
import userApi from 'api/userApi'

const form = reactive({
    account: '',
    name: '',
    password: '',
    password_confirmation: '',
    //短信或邮件验证码
    code: ''
})

const register = async () => {
    try {
        await userApi.register(form)
        helper.router('/')
    } finally {
    }
}
</script>

<script>
export default {
    route: { path: '/register' }
}
</script>
