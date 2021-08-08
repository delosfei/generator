import base from './base'
import axios from 'plugins/axios'

export default {
    ...base,
    url: 'role',
    async permissions(roleId) {
        return await axios.get(`role/permissions/${roleId}`)
    },
    async syncPermissions(roleId, permissions) {
        return axios.post(`role/sync/permissions/${roleId}`, { permissions })
    },
}
