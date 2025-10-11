<template>
    <div class="p-6 text-center">
        <h1 class="text-3xl font-bold text-blue-600">🏠 Home Page</h1>
        <RouterLink
            to="/about"
            class="text-blue-500 hover:underline"
        >
            Đi đến About
        </RouterLink>
    </div>
</template>

<script setup lang="ts">
import { RouterLink } from "vue-router";
</script>
