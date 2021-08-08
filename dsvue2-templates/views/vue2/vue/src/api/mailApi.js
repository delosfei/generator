import axios from 'plugins/axios'

export default {
  async code(email) {
    return axios.post('mail/code', { email })
  }
}
