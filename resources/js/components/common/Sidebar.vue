<template>
    <aside class="w-64 border-r bg-white min-h-full">
        <nav class="p-4 space-y-1">
            <RouterLink
                v-for="item in items"
                :key="item.to"
                :to="item.to"
                class="block rounded px-3 py-2 text-sm"
                :class="isActive(item.to) ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
            >
                {{ item.label }}
            </RouterLink>
        </nav>
    </aside>
    
</template>

<script setup lang="ts">
import { RouterLink, useRoute } from 'vue-router'

interface SidebarItem {
    to: string
    label: string
}

defineProps<{ items: SidebarItem[] }>()

const route = useRoute()

function isActive(targetPath: string): boolean {
    // Mark active if current path starts with the target path
    return route.path.startsWith(targetPath)
}
</script>


