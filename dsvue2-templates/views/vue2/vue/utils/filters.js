import Vue from "vue";
import dayjs from "dayjs";

//得到几小时之前的时间表示
Vue.filter("fromNow", function(value) {
    return dayjs(value).fromNow();
});
