import base from './base'
import axios from 'plugins/axios'

export default {
  ...base,
  url: 'system',
  //设置系统课程的课程
  async syncLesson(systemId, lessons) {
    return await axios.post(`system/${systemId}/lesson`, { lessons })
  }
}
