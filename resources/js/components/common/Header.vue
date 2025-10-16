<template>
    <header class="border-b bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <span class="text-xl font-bold">Rate My Place</span>
                </div>

                <nav class="flex items-center gap-4">
                    <RouterLink to="/" class="text-gray-700 hover:text-black">Homepage</RouterLink>

                    <!-- Nếu chưa login -->
                    <RouterLink
                        v-if="!user"
                        to="/auth/login"
                        class="ml-6 inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                    >
                        Login
                    </RouterLink>

                    <!-- Nếu đã login -->
                    <div v-else class="relative">
                        <button @click="menuOpen = !menuOpen" class="flex items-center gap-2">
                            <img
                                :src="user.avatar_path || '/images/defaults/no-avatar.jpg'"
                                alt="Avatar"
                                class="w-8 h-8 rounded-full"
                            />
                            <span class="hidden md:inline">{{ user.name }}</span>
                        </button>

                        <div
                            v-if="menuOpen"
                            class="absolute right-0 mt-2 w-56 bg-white border rounded-lg shadow-lg z-50"
                        >
                            <!-- User menu -->
                            <RouterLink
                                to="/profile/edit"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 hover:rounded-lg"
                                @click="menuOpen = false"
                            >
                                Edit Profile
                            </RouterLink>

                            <button
                                @click="() => { handleLogout(); menuOpen = false }"
                                class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 hover:rounded-lg"
                            >
                                Logout
                            </button>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useToast } from "vue-toastification";

const toast = useToast();
const router = useRouter();
const auth = useAuthStore();

const menuOpen = ref(false);
const user = computed(() => auth.user);

const handleLogout = () => {
    auth.logout();
    toast.success('Đăng xuất thành công');
    router.push("/");
};
</script>
