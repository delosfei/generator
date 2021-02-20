import Vue from "vue";
import dayjs from "dayjs";

Vue.filter("fromNow", function(value) {
    return dayjs(value).fromNow();
});
