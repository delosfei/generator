import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        //表单验证错误
        errors: {},
        //登录用户
        user: {},
        //系统配置
        system: {}
    },
    getters: {
        errors: state => name => state.errors[name] && state.errors[name][0],
        auth() {
            return Boolean(localStorage.getItem("token"));
        },
        token() {
            return window.localStorage.getItem("token");
        }
    },
    //修改数据时使用，这是一个同步方法，不能在这里执行异步动作
    mutations: {
        //设置验证错误
        setErrors(state, errors = {}) {
            state.errors = errors;
        },
        setUser(state, user) {
            state.user = user;
        },
        setSystemConfig(state, config) {
            state.system = config;
        }
    },
    //用来执行异步动作
    actions: {
        async getUserInfo({ commit }) {
            commit("setUser", await axios.get(`user/info`));
        },
        async getSystemConfig({ commit }) {
            commit("setSystemConfig", await axios.get(`system/config/1`));
        }
    }
});
