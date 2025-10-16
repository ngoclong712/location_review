// src/router/guard.js
import { useAuthStore } from "@/stores/auth";
import router from "./index";

router.beforeEach((to, from, next) => {
    const auth = useAuthStore();

    // Luôn load user nếu F5 hoặc lần đầu vào app
    if (!auth.user) {
        auth.loadUserFromStorage();
    }

    const user = auth.user;

    // Nếu route yêu cầu đăng nhập
    if (to.meta.requiresAuth && !user) {
        return next({ path: "/auth/login", query: { redirect: to.fullPath } });
    }

    // Nếu route chỉ cho guest (login/register)
    if (to.meta.guest && user) {
        return next({ path: "/" });
    }

    // Nếu route yêu cầu quyền (roles)
    if (to.meta.roles) {
        // Nếu chưa login
        if (!user) {
            return next({ path: "/auth/login" });
        }

        // Nếu role user không nằm trong danh sách cho phép
        if (!to.meta.roles.includes(user.role)) {
            return next({ path: "/" });
        }
    }

    // Nếu không vi phạm gì thì cho qua
    next();
});
