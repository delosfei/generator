import router from '@/router'
import store from '@/store'
import { ElMessageBox } from 'element-plus'
import { useRoute } from 'vue-router'

export default {
  router(route) {
    router.push(route)
  },
  route() {
    return useRoute()
  },
  store() {
    return store
  },
  isLogin() {
    return store.state.user.token
  },
  user() {
    return store.state.user.info
  },
  logout() {
    store.state.user.token = null
    window.localStorage.removeItem('token')
    router.push('/')
  },
  //确认框
  confirm(title) {
    return ElMessageBox.confirm(title, '温馨提示', {
      confirmButtonText: '确定',
      cancelButtonText: '取消',
      type: 'warning'
    })
  },
  //权限校验
  access(name) {
    const user = store.state.user.info

    if (user.id) {
      return user.is_admin && user.permissions.includes(name)
    }

    return false
  },
  //日期格式化
  dateFormat(value, format = 'YYYY/MM/DD') {
    return dayjs(value).format(format)
  },
  //几天前
  dateNow(value) {
    return dayjs(value).locale('zh-cn').fromNow()
  }
}
