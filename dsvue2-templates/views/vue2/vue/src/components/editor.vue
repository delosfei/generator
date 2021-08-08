<template>
    <div>
        <div :id="id"></div>
    </div>
</template>

<script setup>
import { nextTick, defineProps, defineEmit } from 'vue'
import axios from 'plugins/axios'
//编辑器
import Editor from '@toast-ui/editor'
import '@toast-ui/editor/dist/toastui-editor.css'

//自定义全屏显示按钮
function fullscreenButton() {
    const button = document.createElement('button')
    button.className = 'toastui-editor-toolbar-icons last'
    button.style.backgroundImage = 'none'
    button.style.margin = '0'
    button.innerHTML = `<span>全屏</span>`

    button.addEventListener('click', () => {
        let ui = document.querySelector('.toastui-editor-defaultUI')
        ui.classList.toggle('fullScreen')
    })

    return button
}

//自定义工具条
const toolbarItems = [
    ['heading', 'bold', 'italic', 'strike'],
    ['hr', 'quote'],
    ['ul', 'ol', 'task', 'indent', 'outdent'],
    ['table', 'image', 'link'],
    ['code', 'codeblock'],
    [
        {
            el: fullscreenButton(),
            name: 'fullscreen',
            tooltip: 'fullscreen'
        }
    ]
]

const props = defineProps({
    modelValue: String,
    action: { type: String, default: `/upload` },
    id: { type: String, default: `editor` },
    type: { type: String, default: 'markdown' },
    height: { type: String, default: '300px' }
})

const emit = defineEmit(['update:modelValue'])

nextTick(() => {
    const editor = new Editor({
        el: document.querySelector(`#${props.id}`),
        height: props.height,
        initialEditType: props.type,
        previewStyle: 'vertical',
        initialValue: props.modelValue,
        placeholder: '请在底部切换为编辑模式，同时支持托放上传图片',
        toolbarItems
    })

    editor.on('change', type => {
        emit('update:modelValue', type == 'markdown' ? editor.getMarkdown() : editor.getHTML())
    })
    //图片处理
    editor.removeHook('addImageBlobHook')
    editor.addHook('addImageBlobHook', async (blob, callback) => {
        const formData = new FormData()
        //添加post数据
        formData.append('file', blob, blob.name)
        //上传图片
        const response = await axios.post(props.action, formData)
        //更改编辑器内容
        callback(response.path, blob.name)
        return false
    })
})
</script>

<style lang="scss">
// 事件按钮需要使用类所以不能加scoped
.fullScreen {
    position: fixed !important;
    z-index: 9999;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #fff;
}
</style>
