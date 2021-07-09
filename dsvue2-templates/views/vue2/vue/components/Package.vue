<template>
    <div>
        <el-table :data="packageData" border stripe>
            <el-table-column
                v-for="col in columns"
                :prop="col.id"
                :key="col.id"
                :label="col.label"
                :width="col.width"
            >
            </el-table-column>
            <el-table-column label="模块列表" #default="{row:p}">
                <el-tag
                    type="danger"
                    size="mini"
                    v-for="module in p.modules"
                    :key="module.id"
                >
                    {{ module.title }}
                </el-tag>
            </el-table-column>
            <el-table-column width="150" align="center" #default="{row:p}">
                <slot :package="p" />
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
const columns = [
    { id: "id", label: "编号", width: 100 },
    { id: "title", label: "套餐名称" }
];
export default {
    props: ["packages"],
    data() {
        return {
            columns,
            packageData: this.packages
        };
    },
    watch: {
        packages(n) {
            this.packageData = n;
        }
    }
};
</script>

<style></style>
