<template>
    <el-dialog title="选择课程" v-model="dialogVisible" width="80%" top="1rem">
        <hd-table-list name="lesson-select" :api="lessonApi.get.bind(lessonApi)" @select="$emit('select', $event)" />
    </el-dialog>

    <el-button class="mt-3" type="success" @click="dialogVisible = true" size="small">选择课程</el-button>
</template>

<script setup>
import { ref, defineEmit } from 'vue'
import lessonApi from 'api/lessonApi'
const dialogVisible = ref(false)

defineEmit(['select'])
</script>


<style>
</style>
