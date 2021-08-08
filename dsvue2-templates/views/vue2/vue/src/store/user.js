import axios from 'plugins/axios'

export default {
  namespaced: true,
  state() {
    return {
      token: window.localStorage.getItem('token'),
      info: {}
    }
  },
  getters: {
    //登录检测
    isLogin(state) {
      return Boolean(state.token)
    }
  },
  mutations: {
    setToken(state, token) {
      state.token = token
      window.localStorage.setItem('token', token)
    },
    setUser(state, user) {
      state.info = user
    },
    //退出登录
    logout(state) {
      state.token = null
      window.localStorage.removeItem('token')
    }
  },
  actions: {
    //获取当前用户资料
    async getCurrentUser({ commit }) {
      const data = await axios.get(`user/info`)
      commit('setUser', data)
    }
    //用户登录
  }
}
