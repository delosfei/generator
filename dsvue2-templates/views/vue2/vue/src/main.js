import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import '@/assets/tailwind.css'
import '@/assets/app.scss'

//element_ui
import ElementPlus from '@/plugins/elementUi'
import 'element-plus/lib/theme-chalk/index.css'
import 'dayjs/locale/zh-cn'
import locale from 'element-plus/lib/locale/lang/zh-cn'

//自动加载公共组件
import autoload from '@/utils/autoload'

//把components 目录的组件自动注册到全局
const app = createApp(App)
autoload(app)
app.use(router)
app.use(store)
app.use(ElementPlus, { locale })
app.mount('#app')
