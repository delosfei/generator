import { createStore } from 'vuex'
import error from './error'
import user from './user'
// 创建一个新的 store 实例
const store = createStore({
    modules: {
        error,
        user,
    },
})

export default store
