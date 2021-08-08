//验证码
import { reactive } from 'vue'
import axios from 'plugins/axios'

//验证码数据
export const captcha = reactive({ key: '', img: '' })

//加载验证码
export const loadCaptcha = async () => {
  const data = await axios.get(`captcha`)

  Object.assign(captcha, data)
}

loadCaptcha()
