import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import vueJsx from '@vitejs/plugin-vue-jsx'

const BASE_PATH = process.env.NODE_ENV == 'production' ? '/dist/' : '/'

export default defineConfig({
    plugins: [vue(), vueJsx()],
    base: BASE_PATH,
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'src'),
            composable: path.resolve(__dirname, 'src/composable'),
            plugins: path.resolve(__dirname, 'src/plugins'),
            data: path.resolve(__dirname, 'src/data'),
            api: path.resolve(__dirname, 'src/api'),
            utils: path.resolve(__dirname, 'src/utils'),
        },
    },
    build: {
        outDir: '../public/dist',
        emptyOutDir: true,
    },
})
