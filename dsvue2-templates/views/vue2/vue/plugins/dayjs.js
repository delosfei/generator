import dayjs from "delosfei/dsvue2-templates/views/vue2/vue/plugins/dayjs";
var relativeTime = require("dayjs/plugin/relativeTime");
dayjs.extend(relativeTime);

require("dayjs/locale/zh-cn");
dayjs.locale("zh-cn");
