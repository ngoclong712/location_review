<template>
<div>
    <Header></Header>
    <main class="min-h-screen">
        <RouterView></RouterView>
    </main>
    <Footer></Footer>
</div>
</template>

<script setup lang="ts">
import {RouterView} from "vue-router";
import Header from "../components/common/Header.vue";
import Footer from "../components/common/Footer.vue";
import { ref,onMounted } from 'vue'
import { useAuthStore } from "@/stores/auth"

const auth = useAuthStore()

const userName = ref('')

onMounted(() => {
    auth.loadUserFromStorage();

    if(auth.user) {
        userName.value = auth.user.name;
    }
})
</script>
