<template>
    <div>
        <h1 class="text-xl font-semibold mb-4">Xử lí báo cáo (Manager)</h1>
        <div class="bg-white border rounded">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 py-2">ID</th>
                    <th class="text-left px-4 py-2">Loại</th>
                    <th class="text-left px-4 py-2">Trạng thái</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="rep in reports" :key="rep.id" class="border-t">
                    <td class="px-4 py-2">{{ rep.id }}</td>
                    <td class="px-4 py-2">{{ rep.type }}</td>
                    <td class="px-4 py-2">{{ rep.status }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const reports = ref([
    { id: 41, type: 'Báo cáo bài viết', status: 'Mới' },
    { id: 42, type: 'Báo cáo bình luận', status: 'Đang xử lí' },
])
</script>


