<template>
    <div class="min-h-screen grid grid-rows-[auto,1fr]">
        <header class="border-b bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <RouterLink to="/" class="font-bold text-lg">Review Địa Điểm</RouterLink>
                <RouterLink to="/" class="text-sm text-gray-600 hover:text-gray-900">Trang chủ</RouterLink>
            </div>
        </header>
        <main class="flex items-center justify-center py-10">
            <RouterView></RouterView>
        </main>
    </div>
</template>

<script setup lang="ts">
import {RouterView} from "vue-router";
</script>
