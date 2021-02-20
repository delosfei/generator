<template>
    <div>
        <div class="flex justify-between">
            <el-input
                v-model="content"
                placeholder="请输入验证码"
                size="normal"
                clearable
                class="mr-2"
            ></el-input>
            <img
                :src="captcha.img"
                class="rounded-sm border border-gray-200 cursor-pointer"
                @click="get"
            />
        </div>
        <hd-error name="captcha.content" />
    </div>
</template>

<script>
export default {
    data() {
        return {
            //后台接口返回的验证码数据
            captcha: {},
            //用户输入的验证码
            content: ""
        };
    },
    watch: {
        content(n) {
            this.$emit("input", {
                content: this.content,
                key: this.captcha.key
            });
        }
    },
    created() {
        this.get();
    },
    methods: {
        async get() {
            this.captcha = await this.axios.get(`captcha`);
        }
    }
};
</script>

<style></style>
