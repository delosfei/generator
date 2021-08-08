<template>
    <div class="bg-blue-400 h-screen w-screen">
        <div class="flex flex-col items-center flex-1 h-full justify-center px-4 sm:px-0">
            <div class="flex rounded-lg shadow-lg w-full sm:w-3/4 lg:w-1/2 bg-white sm:mx-0" style="height: 500px">
                <div class="flex flex-col w-full md:w-1/2 p-4">
                    <div class="flex flex-col flex-1 justify-center mb-8">
                        <h1 class="text-4xl text-center font-thin">欢迎登录</h1>
                        <div class="w-full mt-4">
                            <form class="form-horizontal w-3/4 mx-auto" method="POST" action="#">
                                <div class="flex flex-col mt-4">
                                    <el-input v-model="form.account" placeholder="请输入邮箱或手机号" clearable></el-input>
                                    <hd-error name="account" />
                                </div>
                                <div class="flex flex-col mt-4">
                                    <el-input v-model="form.password" type="password" placeholder="请输入登录密码" clearable></el-input>
                                    <hd-error name="password" />
                                </div>
                                <hd-captcha v-model="form.captcha" v-model:key="form.captcha_key" />
                                <div class="flex flex-col mt-8">
                                    <button @click.prevent="login" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-semibold py-3 px-4 rounded">
                                        登录
                                    </button>
                                </div>
                            </form>
                            <div class="text-center mt-4">
                                <router-link to="forget-password" class="no-underline hover:underline text-blue-dark text-xs"> 找回密码 </router-link>
                                <span class="px-1"> · </span>
                                <router-link to="register" class="no-underline hover:underline text-blue-dark text-xs"> 会员注册 </router-link>
                                <span class="px-1"> · </span>
                                <router-link class="no-underline hover:underline text-blue-dark text-xs" to="/"> 网站首页 </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="hidden md:block md:w-1/2 rounded-r-lg"
                    style="background: url('/images/login.jpeg'); background-size: cover; background-position: center center"
                ></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import helper from 'utils/helper'
import { loadCaptcha } from 'composable/useCaptcha'
import userApi from 'api/userApi'

const form = reactive({
    account: '15066223705',
    password: 'admin888',
    //验证码
    captcha: '',
    captcha_key: ''
})

const login = async () => {
    try {
        await userApi.login(form)
        helper.router('/')
    } finally {
        loadCaptcha()
    }
}
</script>

<script>
export default {
    route: { path: '/login' }
}
</script>

<style></style>
