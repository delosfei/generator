//注册全局组件
export default app => {
    const components = import.meta.globEager('../components/**/*')

    Object.entries(components).forEach(([file, component]) => {
        const name = `hd-` + file.split('/').pop().slice(0, -4)

        app.component(name, component.default)
    })
}
