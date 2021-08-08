import axios from 'axios'
import store from '@/store'
import router from '@/router'
import { ElMessage, ElLoading } from 'element-plus'
import helper from 'utils/helper'
// import useLogin from '../composable/useLogin'
// const { logout } = useLogin()

const instance = axios.create({
  headers: {
    'Content-Type': 'application/json'
  }
})

//加载动画
let loading = null

instance.interceptors.request.use(
  function (config) {
    const baseUrl = import.meta.env.MODE == 'development' ? 'http://ds.test/api' : '/'
    config.baseURL = baseUrl

    //携带令牌
    const token = window.localStorage.getItem('token')
    if (token) config.headers.Authorization = `Bearer ${token}`
    //加载动画
    loading = ElLoading.service({
      lock: true,
      text: '加载中...',
      spinner: 'el-icon-loading',
      background: 'rgba(255, 255, 255, 0.3)'
    })
    return config
  },
  function (error) {
    return Promise.reject(error)
  }
)

instance.interceptors.response.use(
  function (response) {
    loading.close()
    const { data } = response
    if (data.message) {
      ElMessage.success({
        message: data.message,
        type: 'success'
      })
    }

    return data
  },
  function (error) {
    loading.close()
    const { status, data } = error.response

    switch (status) {
      case 422:
        //表单验证失败
        store.commit('error/set', data.errors)
        break
      case 403:
        //表单验证失败
        ElMessage.error({
          message: '你没有访问访问'
        })
        break
      case 429:
        //表单验证失败
        ElMessage.error({
          message: data
        })
        break
      case 401:
        helper.logout()
        router.push('/login')
        break
    }

    return Promise.reject(error)
  }
)

export default instance
