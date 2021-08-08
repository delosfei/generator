<template>
    <el-dialog title="选择用户" v-model="showDialog" width="80%" top="10px">
        <hd-table-list name="user" @select="select" />
    </el-dialog>

    <el-button type="primary" size="mini" @click="showDialog = true" v-bind="$attrs">
        <slot>选择用户</slot>
    </el-button>
</template>

<script setup>
import { ref, defineProps, defineEmit } from 'vue'

const showDialog = ref(false)
const emit = defineEmit(['select'])

const select = ({ row }) => {
    emit('select', row);
    showDialog.value = false
}
</script>

<style></style>
