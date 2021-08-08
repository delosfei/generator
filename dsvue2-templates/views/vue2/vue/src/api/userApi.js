import base from './base'
import axios from 'plugins/axios'
import helper from 'utils/helper'

export default {
  ...base,
  url: 'user',
  //用户角色列表
  async roles(id) {
    return await axios.get(`user/roles/${id}`)
  },
  //同步用户角色
  async syncRoles(userId, roles) {
    return await axios.post(`user/roles/${userId}`, { roles })
  },
  //登录
  async login(form) {
    const { data } = await axios.post(`login`, form)

    helper.store().commit('user/setToken', data.token)
  },
  //注册
  async register(form) {
    const { data } = await axios.post(`register`, form)
    helper.store().commit('user/setToken', data.token)
  },
  //找回密码
  async forgetPassword(form) {
    await axios.post(`forget-password`, form)
  }
}
