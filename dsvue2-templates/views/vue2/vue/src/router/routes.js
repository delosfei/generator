const routes = []
//所有布局组件
const layouts = import.meta.globEager('../layouts/*.vue')
//所有页面组件
const views = import.meta.globEager('../views/**/*.vue')

//处理布局组件
Object.entries(layouts).forEach(([file, component]) => {
    component = component.default
    //布局路由路径
    const path = file.split('/').pop().slice(0, -4)
    const route = {
        path: `/${path}`,
        component,
        children: [],
        ...component.route,
    }
    routes.push(route)
})

//页面路由
Object.entries(views).map(([file, component]) => {
    component = component.default
    //组件不需要注册路由
    if (component.route && component.route.path === false) return

    const route = viewRoute(file, component)

    const layout = viewLayout(file, component)
    layout ? layout.children.push(route) : routes.push(route)
})

//视图路由
function viewRoute(file, component) {
    const route = { path: '', component, name: file.slice(9).replace(/\//g, '.').slice(0, -4), ...component.route }
    const layout = viewLayout(file)
    if (component.route && component.route.path) {
        route.path = component.route.path
    } else if (layout) {
        route.path = file.split('/').splice(3).join('/').slice(0, -4)
    } else {
        route.path = '/' + file.split('/').splice(2).join('/').slice(0, -4)
    }
    return route
}

//取页面在哪个布局组件组
function viewLayout(file) {
    return routes.find(route => route.children && file.includes(`/views${route.path}`))
}

export default routes
