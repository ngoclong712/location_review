<template>
    <div class="min-h-screen grid grid-rows-[auto,1fr]">
        <header class="border-b bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between py-4">
                <div class="flex items-center">
                    <RouterLink to="/" class="font-bold text-lg">Review Địa Điểm</RouterLink>
                </div>
                <div class="flex items-center">
                    <RouterLink to="/" class="text-sm text-gray-600 hover:text-gray-900">Trang chủ</RouterLink>
                </div>
            </div>
        </header>
        <main class="flex items-center justify-center py-10">
            <RouterView></RouterView>
        </main>
        <Footer></Footer>
    </div>
</template>

<script setup lang="ts">
import {RouterView} from "vue-router";
import Footer from "@/components/common/Footer.vue";
</script>
