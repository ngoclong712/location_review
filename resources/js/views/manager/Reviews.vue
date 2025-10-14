<template>
    <div>
        <h1 class="text-xl font-semibold mb-4">Duyệt bài review (Manager)</h1>
        <div class="space-y-3">
            <div v-for="r in reviews" :key="r.id" class="bg-white border rounded p-4">
                <div class="font-medium">{{ r.title }}</div>
                <div class="text-sm text-gray-600">Tác giả: {{ r.author }}</div>
                <div class="mt-2 flex gap-2">
                    <button class="px-3 py-1 text-xs rounded bg-green-600 text-white">Duyệt</button>
                    <button class="px-3 py-1 text-xs rounded bg-gray-600 text-white">Từ chối</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const reviews = ref([
    { id: 31, title: 'Điểm đến C thú vị', author: 'Member 1' },
    { id: 32, title: 'Quán ăn D ngon', author: 'Member 2' },
])
</script>


