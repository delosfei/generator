import base from './base'
import axios from 'plugins/axios'

export default {
    ...base,
    url: 'video',
    async find(lessonId) {
        return await axios.get(`lesson/${lessonId}/video`)
    },
    async store(lessonId, videos) {
        return await axios.post(`lesson/${lessonId}/video`, { videos })
    },
}
