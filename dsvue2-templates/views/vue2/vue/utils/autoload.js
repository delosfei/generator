import Vue from "vue";
const components = require.context("@/components", true, /\.vue$/);

components.keys().forEach(path => {
    const name = path.slice(2, -4);
    Vue.component(`Hd${name}`, components(path).default);
});
