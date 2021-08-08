import { createRouter, createWebHistory } from 'vue-router'
import store from '@/store'
import routes from './routes.js'
import helper from 'utils/helper'
import { ElMessage } from 'element-plus'

const router = createRouter({
  history: createWebHistory(),
  routes: [{ path: '/admin', redirect: '/system' }, ...routes]
})

router.beforeEach(async (to, from, next) => {
  const isLogin = store.getters['user/isLogin']

  //清除表单验证消息
  helper.store().state.error.errors = {}
  // 如果登录就获取用户资料
  if (isLogin) {
    await store.dispatch('user/getCurrentUser')
  }

  // 对登录的处理
  if (!isLogin && to.matched.some(route => route.meta.auth === true)) {
    //已经登录就要获取用户资料
    return next('/login')
  }

  if (isLogin && to.matched.some(route => route.meta.guest === true)) {
    // 对游客的处理
    return next('/')
  }

  //权限检验
  if (to.meta.permission) {
    if (!helper.access(to.meta.permission)) {
      ElMessage.error({
        message: '你没有访问访问'
      })
      return next('/admin')
    }
  }

  return next()
})

export default router
