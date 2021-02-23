<template>
    <div>
        <!-- component -->
        <div class="bg-blue-400 h-screen w-screen">
            <div
                class="flex flex-col items-center flex-1 h-full justify-center px-4 sm:px-0"
            >
                <div
                    class="flex rounded-lg shadow-lg w-full sm:w-3/4 lg:w-1/2 bg-white sm:mx-0"
                    style="height: 500px"
                >
                    <div class="flex flex-col w-full md:w-1/2 p-4">
                        <div class="flex flex-col flex-1 justify-center mb-8">
                            <h1 class="text-4xl text-center font-thin">登录</h1>
                            <div class="w-full mt-4">
                                <form
                                    class="form-horizontal w-3/4 mx-auto"
                                    method="POST"
                                    action="#"
                                >
                                    <div class="flex flex-col mt-4">
                                        <el-input
                                            v-model="form.mobile"
                                            placeholder="请输入手机号"
                                            size="normal"
                                            clearable
                                        ></el-input>
                                        <hd-error name="mobile" />
                                    </div>
                                    <div class="flex flex-col mt-4">
                                        <el-input
                                            v-model="form.password"
                                            placeholder="请输入登录密码"
                                            size="normal"
                                            clearable
                                            show-password
                                        ></el-input>
                                        <hd-error name="password" />
                                    </div>

                                    <div class="flex flex-col mt-4">
                                        <hd-captcha
                                            v-model="form.captcha"
                                            ref="captcha"
                                        />
                                    </div>
                                    <div class="flex items-center mt-4">
                                        <input
                                            type="checkbox"
                                            name="remember"
                                            v-model="form.remember"
                                            id="remember"
                                            class="mr-2"
                                        />
                                        <label
                                            for="remember"
                                            class="text-sm text-grey-dark"
                                        >记住我
                                        </label>
                                    </div>
                                    <div class="flex flex-col mt-8">
                                        <button
                                            type="button"
                                            class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded"
                                            @click="onSubmit"
                                        >
                                            登录
                                        </button>
                                    </div>
                                </form>
                                <hd-footer />
                            </div>
                        </div>
                    </div>

                    <div
                        class="hidden md:block md:w-1/2 rounded-r-lg"
                        style="
                            background: url('/images/login.jpeg');
                            background-size: cover;
                            background-position: center center;
                        "
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HdFooter from "./Footer";
export default {
    route: {path: "/login",meta: { guest: true } },
    components: { HdFooter },
    data() {
        return {
            form: {
                mobile: "15066223705",
                password: "admin888",
                captcha: {},
                remember: false,
            },
        };
    },
    methods: {
        onSubmit() {
            this.axios
                .post(`login`, this.form)
                .then(({ token }) => {
                    //本地缓存的TOKEN
                     localStorage.setItem("token", token);
                     location.href = "/admin";
                })
                .finally((_) => this.$refs.captcha.get());
        },
    },
};
</script>

<style></style>
