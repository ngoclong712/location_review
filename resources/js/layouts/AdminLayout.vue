<template>
    <div>
        <Header></Header>
        <div class="min-h-screen grid grid-cols-[16rem_1fr]">
            <Sidebar :items="sidebarItems" />
            <main class="p-6 bg-gray-50">
                <RouterView></RouterView>
            </main>
        </div>
        <Footer></Footer>
    </div>

</template>

<script setup lang="ts">
import { RouterView } from "vue-router";
import Header from "../components/common/Header.vue";
import Footer from "../components/common/Footer.vue";
import Sidebar from "../components/common/Sidebar.vue";

import { ref,onMounted } from 'vue';
import { useAuthStore } from "@/stores/auth";

const sidebarItems = [
    { to: "/admin/banners", label: "Banner management" },
    { to: "/admin/badges",  label: "Badges management" },
    { to: "/admin/managers", label: "Manager management" },
    { to: "/admin/users", label: "User management" },
    { to: "/admin/reviews", label: "Approve review" },
    { to: "/admin/reports", label: "Reports" },
]

const auth = useAuthStore()

const userName = ref('')

onMounted(() => {
    auth.loadUserFromStorage();

    if(auth.user) {
        userName.value = auth.user.name;
    }
})
</script>
