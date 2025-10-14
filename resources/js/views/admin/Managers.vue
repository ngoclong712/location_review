<template>
    <div>
        <h1 class="text-xl font-semibold mb-4">Quản lý manager</h1>
        <div class="grid gap-3">
            <div v-for="m in managers" :key="m.id" class="bg-white border rounded p-4">
                <div class="font-medium">{{ m.name }}</div>
                <div class="text-sm text-gray-600">Email: {{ m.email }}</div>
                <div class="text-sm text-gray-600">Số địa điểm: {{ m.locations }}</div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const managers = ref([
    { id: 1, name: 'Nguyễn Văn A', email: 'a@example.com', locations: 5 },
    { id: 2, name: 'Trần Thị B', email: 'b@example.com', locations: 3 },
])
</script>


