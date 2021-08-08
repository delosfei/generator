<template>
    <el-card class="box-card mt-3" v-for="(group, index) in permissionConfig" :key="index">
        <template #header>{{ group.title }}</template>
        <div class>
            <template v-if="showCheckbox">
                <el-checkbox-group
                    v-model="permissions"
                    @change="$emit('update:permissions', permissions)"
                >
                    <el-checkbox :label="item.permission" v-for="(item, i) in group.items" :key="i">
                        {{ item.title }}
                        <span class>{{ item.permission }}</span>
                    </el-checkbox>
                </el-checkbox-group>
            </template>
            <template v-else>
                <div class="grid grid-cols-6 grid-span-6">
                    <div v-for="(item, i) in group.items" :key="i">
                        {{ item.title }}
                        <span class>{{ item.permission }}</span>
                    </div>
                </div>
            </template>
        </div>
    </el-card>
</template>

<script setup>
import permissionApi from 'api/permissionApi'
// import usePermission from 'composable/usePermission'
import { ref, defineProps } from 'vue'

const props = defineProps({
    permissions: { type: Array, default: () => [] },
    //为 true　时显示复选框
    showCheckbox: { type: Boolean, default: false },
})
// const { permissionConfig, load, sync } = usePermission()
// load()

const permissionConfig = await permissionApi.get();
</script>

<style></style>
