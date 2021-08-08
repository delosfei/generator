//处理表单验证错误
export default {
    namespaced: true,
    state() {
        return {
            errors: {},
        }
    },
    getters: {
        //获取表单错误消息
        get(state) {
            return name => (state.errors[name] ? state.errors[name][0] : null)
        },
    },
    mutations: {
        set(state, errors) {
            state.errors = errors
        },
    },
}
