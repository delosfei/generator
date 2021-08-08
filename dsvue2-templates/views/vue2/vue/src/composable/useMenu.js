import menus from '@/data/menus'
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import helper from 'utils/helper'

export default () => {
  const route = useRoute()

  //过滤掉无权限的菜单
  menus.forEach(group => {
    group.menus.forEach(menus => {
      menus.children = menus.children.filter(menu => {
        return menu.permission ? helper.access(menu.permission) : true
      })
    })
  })

  menus.forEach(group => {
    group.menus = group.menus.filter(menus => {
      return menus.children.length
    })
  })

  //当前访问的菜单组
  const menuGroup = computed(() => {
    const data = menus.find(group => group.name === route.path.split('/')[1])

    return data
  })

  return { menus, menuGroup }
}
