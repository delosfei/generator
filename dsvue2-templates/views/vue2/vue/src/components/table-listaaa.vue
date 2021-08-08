<template>
    <el-table :data="data" border stripe>
        <el-table-column
            v-for="col in columns"
            :prop="col.id"
            :key="col.id"
            :label="col.label"
            :width="col.width"
            :align="col.align"
            #default="{ row }"
        >
            <slot name="default" :row="row" :col="col">
                <template v-if="col.id == 'created_at'">{{ dateNow(row['created_at']) }}</template>

                <template v-else>{{ row[col.id] }}</template>
            </slot>
        </el-table-column>
        <el-table-column width="100" align="center" #default="{ row }">
            <slot name="manage" :row="row" />
        </el-table-column>
    </el-table>
</template>

<script setup>
import { defineProps } from 'vue'
import useDate from 'composable/useDate'
const { dateNow, dateFormat } = useDate()
const props = defineProps(['data', 'columns'])
</script>

<style></style>
