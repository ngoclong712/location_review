// src/stores/auth.js
import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: JSON.parse(localStorage.getItem("user") || "null")
    }),
    actions: {
        setUser(user) {
            this.user = user;
            localStorage.setItem("user", JSON.stringify(user));
        },
        loadUserFromStorage() {
            const u = JSON.parse(localStorage.getItem("user") || "null");
            if (u) this.user = u;
        },
        logout() {
            this.user = null;
            localStorage.removeItem("user");
        }
    }
});
