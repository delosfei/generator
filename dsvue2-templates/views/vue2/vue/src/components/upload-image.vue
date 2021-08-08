<template>
    <el-upload
        class="upload-image"
        :headers="headers"
        :action="action"
        :show-file-list="false"
        :on-success="handleAvatarSuccess"
        :before-upload="beforeAvatarUpload"
        :on-error="onError"
    >
        <div v-if="imageUrl" class="relative">
            <img :src="imageUrl" class="upload-avatar" />
            <i class="fas fa-times-circle del-icon absolute right-2 top-2 text-white text-lg" @click.stop="imageUrl = ''"></i>
        </div>

        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
    </el-upload>
</template>

<script setup>
import { ref, defineEmit, defineProps } from 'vue'
import { ElMessage, ElLoading } from 'element-plus'
const action = import.meta.env.MODE == 'development' ? 'http://edu.test/api/upload' : '/api/upload'

const emit = defineEmit(['update:modelValue'])

const props = defineProps(['modelValue'])
const headers = {
    Authorization: `Bearer ${window.localStorage.getItem('token')}`
}

//上传成功的图片
const imageUrl = ref(props.modelValue)

//上传成功后
const handleAvatarSuccess = (res, file) => {
    imageUrl.value = file.response.path
    emit('update:modelValue', imageUrl.value)
}

//上传失败
const onError = () => {
    ElMessage.warning({
        message: `上传失败，文件类型或大小错误`
    })
}

//上传前
const beforeAvatarUpload = file => {
    const isJPG = file.type === 'image/jpeg'
    const isLt2M = file.size / 1024 / 1024 < 2

    if (!isJPG) {
        this.$message.error('上传头像图片只能是 JPG 格式!')
    }
    if (!isLt2M) {
        this.$message.error('上传头像图片大小不能超过 2MB!')
    }
    return isJPG && isLt2M
}
</script>

<style lang="scss">
.upload-image {
    .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .el-upload:hover {
        border-color: #409eff;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .upload-avatar {
        //    max-width: 178px;
        max-height: 150px;
        display: block;
    }
    .del-icon {
    }
}
</style>
