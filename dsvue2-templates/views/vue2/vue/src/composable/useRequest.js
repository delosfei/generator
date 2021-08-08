import { ref } from 'vue'

//通用请求
export default action => {
    //请求状态
    const loading = ref(false)

    //结果集
    const results = ref(null)

    const query = async (...args) => {
        loading.value = false
        results.value = await action(...args)
        loading.value = true
    }

    return { loading, results, query }
}
