import base from './base'
import axios from 'plugins/axios'

export default {
  //发送验证码
  async send(account) {
    return await axios.post(`code/send`, { account })
  }
}
