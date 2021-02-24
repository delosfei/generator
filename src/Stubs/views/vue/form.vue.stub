<template>
    <el-form
        :model="form"
        ref="form"
        label-width="80px"
        :inline="false"
        size="normal"
        v-loading="loading"
    >
        <hd-tab :tabs="tabs" />
        <el-form-item label="XXXX名称1">
            <el-input v-model="form.title"></el-input>
            <hd-error name="title" />
        </el-form-item>
        <el-form-item label="XXXX名称2">
            <el-input v-model="form.domain"></el-input>
            <hd-error name="domain" />
        </el-form-item>
        <el-form-item>
            <el-button type="primary" @click="onSubmit">保存提交</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
const form = { title: "", domain: "" };
import tabs from "./tabs";
export default {
    route: false,
    props: ["id"],
    data() {
        return { tabs, form, loading: true };
    },
    async created() {
        if (this.id) this.form = await this.axios.get(`site/${this.id}`);
        this.loading = false;
    },
    methods: {
        async onSubmit() {
            const url = this.id ? `site/${this.id}` : `site`;
            await this.axios[this.id ? "put" : "post"](url, this.form);
            this.route("site.site.index");
        }
    }
};
</script>

<style></style>