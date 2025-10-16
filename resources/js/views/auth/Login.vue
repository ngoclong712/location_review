<template>
    <div class="w-full max-w-md mx-auto border rounded-xl p-6 bg-white">
        <h1 class="text-2xl font-semibold text-center">Login</h1>

        <form class="mt-6 grid gap-4" @submit.prevent="handleLogin">
            <div class="grid gap-1">
                <label class="text-sm text-gray-700">Email</label>
                <input
                    v-model="form.email"
                    type="email"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring w-full"
                    placeholder="you@example.com"
                />
            </div>

            <div class="grid gap-1">
                <label class="text-sm text-gray-700">Password</label>
                <input
                    v-model="form.password"
                    type="password"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring w-full"
                    placeholder="••••••••"
                />
            </div>

            <button
                type="submit"
                class="mt-2 inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 w-full"
            >
                Login
            </button>

            <p class="text-center text-sm text-gray-600">
                Don’t have an account?
                <RouterLink to="/auth/register" class="text-blue-600 hover:underline">
                    Register
                </RouterLink>
            </p>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import { useAuthStore } from "@/stores/auth";
import api from "@/services/api";

const router = useRouter();
const toast = useToast();
const auth = useAuthStore();

const form = ref({
    email: "",
    password: "",
});

const redirectByRole = () => {
    if (!auth.user) return;

    switch (auth.user.role) {
        case 1: // USER
            router.push("/"); // homepage
            break;
        case 2: // MANAGER
            router.push("/manager");
            break;
        case 3: // SUPER_ADMIN
            router.push("/admin");
            break;
        default:
            router.push("/"); // fallback
    }
};

const handleLogin = async () => {
    try {
        const res = await api.post("/auth/login", form.value);
        if (res.data.success) {
            toast.success("Login successful!");

            auth.setUser(res.data.data);
            redirectByRole();

        } else {
            toast.error(res.data.message || "Login failed!");
        }
    } catch (err) {
        console.error("Login error:", err);
        toast.error(err.response?.data?.message || "An error occurred, please try again!");
    }
};
</script>
