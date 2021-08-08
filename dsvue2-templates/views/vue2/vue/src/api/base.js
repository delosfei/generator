import axios from 'plugins/axios'

export default {
    //请求列表
    async get(params) {
        return await axios.get(this.url, { params })
    },
    //找单条
    async find(id) {
        return await axios.get(`${this.url}/${id}`)
    },
    //保存提交
    async store(data) {
        return await axios.post(`${this.url}`, data)
    },
    async update(params) {
        return await axios.put(`${this.url}/${params.id}`, params)
    },

    async destroy(id) {
        return await axios.delete(`${this.url}/${id}`)
    },
}
