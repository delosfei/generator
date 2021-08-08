import dayjs from '@/plugins/dayjs'
//日期处理
export default {
    //日期格式化
    dateFormat(value, format = 'YYYY/MM/DD') {
        return dayjs(value).format(format)
    },
    //几天前
    dateNow(value) {
        return dayjs(value).locale('zh-cn').fromNow()
    },
}
