import { createRouter, createWebHistory } from "vue-router";

import HomeView from "./pages/Home.vue";
import ResultView from "./pages/Result.vue";
import LoginView from "./pages/Login.vue";
import RegisterView from "./pages/Register.vue";

const routes = [
    {
        path: "/",
        name: "home",
        component: HomeView,
    },
    {
        path: "/result",
        name: "result",
        component: ResultView,
    },
    {
        path: "/login",
        name: "login",
        component: LoginView,
    },
    {
        path: "/register",
        name: "register",
        component: RegisterView,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const userAuthPages = ["/", "/result"];
    let user = JSON.parse(localStorage.getItem("email"));

    const authRequired = userAuthPages.includes(to.path);

    let userLogedIn = false;

    if (user) {
        userLogedIn = true;
    }

    if (authRequired) {
        if (userLogedIn) {
            next();
        } else {
            next("/login");
        }
    } else {
        next();
    }
});

export default router;
