<template>
    <div class="w-full max-w-md mx-auto border rounded-xl p-6 bg-white">
        <h1 class="text-2xl font-semibold text-center">Đăng ký</h1>
        <form class="mt-6 grid gap-4" @submit.prevent="handleRegister">
            <div class="grid gap-1">
                <label class="text-sm text-gray-700">Tên hiển thị</label>
                <input
                    v-model="form.name"
                    type="text"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring w-full"
                    placeholder="Nguyễn Văn A"
                />
            </div>

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
                <label class="text-sm text-gray-700">Mật khẩu</label>
                <input
                    v-model="form.password"
                    type="password"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring w-full"
                    placeholder="••••••••"
                />
            </div>

            <div class="grid gap-1">
                <label class="text-sm text-gray-700">Xác nhận mật khẩu</label>
                <input
                    v-model="form.password_confirmation"
                    type="password"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring w-full"
                    placeholder="••••••••"
                />
            </div>

            <button
                type="submit"
                class="mt-2 inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700 w-full"
                :disabled="loading"
            >
                <span v-if="!loading">Đăng ký</span>
                <span v-else>Đang xử lý...</span>
            </button>

            <p class="text-center text-sm text-gray-600">
                Đã có tài khoản?
                <RouterLink to="/auth/login" class="text-blue-600 hover:underline">
                    Đăng nhập
                </RouterLink>
            </p>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import api from "@/services/api";
import {useAuthStore} from "@/stores/auth.js";

const router = useRouter();
const toast = useToast();
const loading = ref(false);
const auth = useAuthStore();

const form = ref({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const handleRegister = async () => {
    if (!form.value.name || !form.value.email || !form.value.password) {
        toast.error("Vui lòng nhập đầy đủ thông tin!");
        return;
    }

    if (form.value.password !== form.value.password_confirmation) {
        toast.error("Mật khẩu xác nhận không khớp!");
        return;
    }

    loading.value = true;

    try {
        const response = await api.post("/auth/register", form.value);

        if (response.data.success) {
            const user = response.data.data;

            auth.setUser(user);
            toast.success("Đăng ký thành công!");

            // Reset form
            form.value = {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            };

            router.push("/");
        } else {
            toast.error(response.data.message || "Đăng ký thất bại!");
        }
    } catch (error) {
        if (error.response?.status === 422) {
            const errors = error.response.data.errors;
            if (errors) {
                Object.values(errors).forEach((msgs) =>
                    msgs.forEach((msg) => toast.error(msg))
                );
            }
        } else {
            toast.error(error.response?.data?.message || "Có lỗi xảy ra!");
        }
    } finally {
        loading.value = false;
    }
};
</script>
