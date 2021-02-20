import Auth from "../utils/Auth";
import router from "../router";
export default {
    computed: {
        user() {
            return window.user;
        },
        Auth() {
            return Auth;
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
