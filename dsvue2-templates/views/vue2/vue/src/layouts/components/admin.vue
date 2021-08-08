<template>
    <div class="antialiased">
        <div class="wrapper">
            <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark md:w-48">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <h1 class="navbar-brand navbar-brand-autodark justify-start mt-3">
                        <a href="." class="flex text-gray-200">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-3d-cube-sphere mr-3"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M6 17.6l-2 -1.1v-2.5" />
                                <path d="M4 10v-2.5l2 -1.1" />
                                <path d="M10 4.1l2 -1.1l2 1.1" />
                                <path d="M18 6.4l2 1.1v2.5" />
                                <path d="M20 14v2.5l-2 1.12" />
                                <path d="M14 19.9l-2 1.1l-2 -1.1" />
                                <line x1="12" y1="12" x2="14" y2="10.9" />
                                <line x1="18" y1="8.6" x2="20" y2="7.5" />
                                <line x1="12" y1="12" x2="12" y2="14.5" />
                                <line x1="12" y1="18.5" x2="12" y2="21" />
                                <path d="M12 12l-2 -1.12" />
                                <line x1="6" y1="8.6" x2="4" y2="7.5" />
                            </svg>
                            在线教育
                        </a>
                    </h1>
                    <div class="navbar-nav flex-row d-lg-none">
                        <div class="nav-item d-none d-md-flex me-3">
                            <div class="btn-list">
                                <a href="https://github.com/tabler/tabler" class="btn btn-outline-white" target="_blank" rel="noreferrer">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon text-github"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5"
                                        />
                                    </svg>
                                    Source code
                                </a>
                                <a href="https://github.com/sponsors/codecalm" class="btn btn-outline-white" target="_blank" rel="noreferrer">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon text-pink"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                                    </svg>
                                    Sponsor
                                </a>
                            </div>
                        </div>
                        <div class="nav-item dropdown d-none d-md-flex me-3">
                            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                                <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                </svg>
                                <span class="badge bg-red"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                                <div class="card">
                                    <div class="card-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur exercitationem fugiat in ipsa
                                        ipsum, natus odio quidem quod repudiandae sapiente. Amet debitis et magni maxime necessitatibus ullam.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                                <span
                                    class="avatar avatar-sm"
                                    style="background-image: url(https://houdunren-image.oss-cn-qingdao.aliyuncs.com/11552521685.png)"
                                ></span>
                                <div class="d-none d-xl-block ps-2">
                                    <div>Paweł Kuna</div>
                                    <div class="mt-1 small text-muted">UI Designer</div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="#" class="dropdown-item">Set status</a>
                                <a href="#" class="dropdown-item">Profile &amp; account</a>
                                <a href="#" class="dropdown-item">Feedback</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">Settings</a>
                                <a href="#" class="dropdown-item">Logout</a>
                            </div>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <ul class="navbar-nav pt-lg-3">
                            <li class="nav-item dropdown font-bold pb-3 mb-3 border-b border-gray-600" v-for="(menu, index) in menuGroup.menus" :key="index">
                                <a class="nav-link" href="#navbar-base">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i :class="menu.icon"></i>
                                    </span>
                                    <span class="nav-link-title">{{ menu.title }}</span>
                                </a>
                                <div class="dropdown-menu show">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a
                                                href="#"
                                                class="dropdown-item font-bold child-menu"
                                                :class="{ active: currentRouteName == childMenu.route.name }"
                                                v-for="(childMenu, key) in menu.children"
                                                :key="key"
                                                @click.prevent="redirect(childMenu.route)"
                                                >{{ childMenu.title }}</a
                                            >
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>
            <div class="page-wrapper md:ml-48">
                <div class="bg-white border-b border-gray-100 p-3 px-5">
                    <div class="page-header d-print-none mt-0 flex flex-row justify-between">
                        <ul class="navbar-nav flex flex-row text-gray-600 font-bold">
                            <li class="nav-item mr-5" v-for="(menu, index) in menus" :key="index">
                                <div v-if="menu.menus.length">
                                    <router-link :to="menu.menus[0].children[0].route" class="nav-link">
                                        <i :class="menu.icon" class="mr-1"></i>
                                        <span class="nav-link-title">{{ menu.title }}</span>
                                    </router-link>
                                </div>
                            </li>
                            <li class="nav-item mr-5">
                                <a href="/" target="_blank" class="nav-link">
                                    <span class="nav-link-title">
                                        <i class="fas fa-home"></i>
                                        网站首页
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item mr-5">
                                <a href="/member" target="_blank" class="nav-link">
                                    <i class="fas fa-user-circle mr-1"></i>
                                    <span class="nav-link-title">会员中心</span>
                                </a>
                            </li>
                            <li class="nav-item mr-5">
                                <a href="https://www.houdunren.com" target="_blank" class="nav-link">
                                    <i class="fas fa-hands-helping mr-1"></i>
                                    <span class="nav-link-title">帮助文档</span>
                                </a>
                            </li>
                        </ul>

                        <div class="navbar-nav flex-row order-md-last">
                            <div class="nav-item dropdown d-none d-md-flex me-3">
                                <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                    </svg>
                                    <span class="badge bg-red"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                                    <div class="card">
                                        <div class="card-body">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur exercitationem fugiat in
                                            ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet debitis et magni maxime necessitatibus ullam.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                                    <span class="avatar avatar-sm" :style="`background-image: url(${user.icon})`"></span>
                                    <div class="d-none d-xl-block ps-2">
                                        <div>{{ user.name }}</div>
                                        <div class="mt-1 small text-muted">注册于{{ useDate.dateNow(user.created_at) }}</div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <a href="#" class="dropdown-item">网站首页</a>
                                    <a href="#" class="dropdown-item">后盾人官网</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item">会员中心</a>
                                    <a href="#" @click.prevent="helper.logout" class="dropdown-item">退出登录</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body bg-white min-h-screen m-5 p-5">
                    <router-view />
                </div>
                <footer class="footer footer-transparent d-print-none">
                    <div class="container">
                        <div class="row text-center align-items-center flex-row-reverse">
                            <div class="col-lg-auto ms-lg-auto">
                                <ul class="list-inline list-inline-dots mb-0">
                                    <li class="list-inline-item">
                                        <a href="./docs/index.html" class="link-secondary">Documentation</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="./license.html" class="link-secondary">License</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://github.com/tabler/tabler" target="_blank" class="link-secondary" rel="noopener">Source code</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                                <ul class="list-inline list-inline-dots mb-0">
                                    <li class="list-inline-item">
                                        Copyright © 2021
                                        <a href="https://www.houdunren.com" class="link-secondary">houdunren.com</a>. All rights reserved.
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="./changelog.html" class="link-secondary" rel="noopener">v1.0.0</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="example-text-input" placeholder="Your report name" />
                        </div>
                        <label class="form-label">Report type</label>
                        <div class="form-selectgroup-boxes row mb-3">
                            <div class="col-lg-6">
                                <label class="form-selectgroup-item">
                                    <input type="radio" name="report-type" value="1" class="form-selectgroup-input" checked />
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                        <span class="me-3">
                                            <span class="form-selectgroup-check"></span>
                                        </span>
                                        <span class="form-selectgroup-label-content">
                                            <span class="form-selectgroup-title strong mb-1">Simple</span>
                                            <span class="d-block text-muted">Provide only basic data needed for the report</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-selectgroup-item">
                                    <input type="radio" name="report-type" value="1" class="form-selectgroup-input" />
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                        <span class="me-3">
                                            <span class="form-selectgroup-check"></span>
                                        </span>
                                        <span class="form-selectgroup-label-content">
                                            <span class="form-selectgroup-title strong mb-1">Advanced</span>
                                            <span class="d-block text-muted">Insert charts and additional advanced analyses to be inserted in the report</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Report url</label>
                                    <div class="input-group input-group-flat">
                                        <span class="input-group-text">https://tabler.io/reports/</span>
                                        <input type="text" class="form-control ps-0" value="report-01" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Visibility</label>
                                    <select class="form-select">
                                        <option value="1" selected>Private</option>
                                        <option value="2">Public</option>
                                        <option value="3">Hidden</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Client name</label>
                                    <input type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Reporting period</label>
                                    <input type="date" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label class="form-label">Additional information</label>
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
                        <a href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Create new report
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <svg
            id="SvgjsSvg1001"
            width="2"
            height="0"
            xmlns="http://www.w3.org/2000/svg"
            version="1.1"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            xmlns:svgjs="http://svgjs.com/svgjs"
            style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0"
        >
            <defs id="SvgjsDefs1002" />
            <polyline id="SvgjsPolyline1003" points="0,0" />
            <path id="SvgjsPath1004" d="M0 0 " />
        </svg>
    </div>
</template>

<script setup>
import useMenu from 'composable/useMenu'
import useDate from 'composable/useDate'
import { useRouter } from 'vue-router'
import { ref } from 'vue'
import { useStore } from 'vuex'
import helper from 'utils/helper'

const router = useRouter()
const { menus, menuGroup } = useMenu()

const store = useStore()
const user = store.state.user.info

//菜单点击
const currentRouteName = ref('')
const redirect = route => {
    currentRouteName.value = route.name
    router.push(route)
}
</script>

<script>
export default {
    route: { meta: { auth: true } }
}
</script>

<style lang="scss" scoped>
.child-menu {
    &.active,
    &:hover {
        @apply bg-green-600 text-white duration-300;
    }
}
</style>
