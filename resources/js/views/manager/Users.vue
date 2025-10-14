<template>
    <div>
        <h1 class="text-xl font-semibold mb-4">Quản lý người dùng (Manager)</h1>
        <ul class="bg-white border rounded divide-y">
            <li v-for="user in users" :key="user.id" class="px-4 py-3 flex items-center justify-between">
                <div>
                    <div class="font-medium">{{ user.name }}</div>
                    <div class="text-sm text-gray-600">{{ user.email }}</div>
                </div>
                <button class="px-3 py-1 text-xs rounded bg-gray-600 text-white">Xem</button>
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const users = ref([
    { id: 21, name: 'Member 1', email: 'm1@example.com' },
    { id: 22, name: 'Member 2', email: 'm2@example.com' },
])
</script>


