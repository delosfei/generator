import Auth from "./Auth";
import router from "../router";
import store from "../store";
export default {
    computed: {
        user() {
            return store.state.user;
        },
        Auth() {
            return Auth;
        },
        isLogin() {
            return window.localStorage.getItem("token");
        }
    },
    methods: {
        route(name, params = {}) {
            router.push({ name, params });
        },
        logout() {
            window.localStorage.removeItem("token");
            location.href = "/";
        }
    }
};
