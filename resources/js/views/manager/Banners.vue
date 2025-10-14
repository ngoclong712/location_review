<template>
    <div>
        <h1 class="text-xl font-semibold mb-4">Quản lý banner (Manager)</h1>
        <div class="bg-white border rounded">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 py-2">ID</th>
                    <th class="text-left px-4 py-2">Tiêu đề</th>
                    <th class="text-left px-4 py-2">Trạng thái</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="banner in banners" :key="banner.id" class="border-t">
                    <td class="px-4 py-2">{{ banner.id }}</td>
                    <td class="px-4 py-2">{{ banner.title }}</td>
                    <td class="px-4 py-2">{{ banner.active ? 'Đang hiển thị' : 'Ẩn' }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const banners = ref([
    { id: 11, title: 'KM tuần này', active: true },
    { id: 12, title: 'Sự kiện tháng', active: false },
])
</script>


