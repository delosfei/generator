const mix = require("laravel-mix");

mix.js("vue/app.js", "public/js")
    .vue()
    .postCss("vue/css/app.css", "public/css", [require("tailwindcss")])
    .webpackConfig(require("./webpack.config"));

mix.browserSync({
    proxy: "e19.test",
    files: ["vue/**"]
});
