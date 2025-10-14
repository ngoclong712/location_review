<template>
    <div>
        <h1 class="text-xl font-semibold mb-4">Xử lí báo cáo</h1>
        <div class="bg-white border rounded">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 py-2">ID</th>
                    <th class="text-left px-4 py-2">Loại</th>
                    <th class="text-left px-4 py-2">Trạng thái</th>
                    <th class="text-left px-4 py-2">Hành động</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="rep in reports" :key="rep.id" class="border-t">
                    <td class="px-4 py-2">{{ rep.id }}</td>
                    <td class="px-4 py-2">{{ rep.type }}</td>
                    <td class="px-4 py-2">{{ rep.status }}</td>
                    <td class="px-4 py-2">
                        <button class="px-3 py-1 text-xs rounded bg-indigo-600 text-white">Xem</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const reports = ref([
    { id: 101, type: 'Báo cáo review', status: 'Mới' },
    { id: 102, type: 'Báo cáo người dùng', status: 'Đang xử lí' },
])
</script>


