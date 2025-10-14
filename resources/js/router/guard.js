// src/router/guard.js
import { useAuthStore } from "@/stores/auth";
import router from "./index";

router.beforeEach((to, from, next) => {
    const auth = useAuthStore();
    auth.loadUserFromStorage(); // đảm bảo user load khi F5

    const user = auth.user;

    // Nếu route cần role
    if (to.meta.roles) {
        if (!user) return next("/auth/login"); // chưa login -> login page
        if (!to.meta.roles.includes(user.role)) return next("/"); // role không hợp lệ -> homepage
    }

    next();
});
