import axios from 'plugins/axios'

export default {
  async code(mobile) {
    return axios.post('sms/code', { mobile })
  }
}
