<template>
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">🎖️ Quản lý Huy hiệu</h1>
            <button
                @click="openAddModal"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
            >
                + Thêm huy hiệu
            </button>
        </div>

        <!-- Bảng danh sách -->
        <div class="overflow-x-auto bg-white shadow rounded-xl">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Tên huy hiệu</th>
                    <th class="px-4 py-3 text-left">Mô tả</th>
                    <th class="px-4 py-3 text-left">Biểu tượng</th>
                    <th class="px-4 py-3 text-center">Số người sở hữu</th>
                    <th class="px-4 py-3 text-center">Hành động</th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="(badge, index) in badges"
                    :key="badge.id"
                    class="border-b hover:bg-gray-50"
                >
                    <td class="px-4 py-3">{{ index + 1 }}</td>
                    <td class="px-4 py-3 font-medium">{{ badge.name }}</td>
                    <td class="px-4 py-3">{{ badge.description || '-' }}</td>
                    <td class="px-4 py-3">
                        <img
                            v-if="badge.icon_path"
                            :src="badge.icon_path"
                            class="w-10 h-10 object-cover rounded-full border"
                        />
                        <span v-else class="text-gray-400 italic">Chưa có</span>
                    </td>
                    <td class="px-4 py-3 text-center">{{ badge.user_count }}</td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <button
                            @click="openEditModal(badge)"
                            class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                        >
                            Sửa
                        </button>
                        <button
                            @click="deleteBadge(badge.id)"
                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                        >
                            Xóa
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal thêm/sửa -->
        <div
            v-if="isModalOpen"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40"
        >
            <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg">
                <h2 class="text-lg font-semibold mb-4">
                    {{ isEditing ? 'Sửa huy hiệu' : 'Thêm huy hiệu mới' }}
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Tên huy hiệu</label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full border rounded px-3 py-2"
                            placeholder="Nhập tên huy hiệu..."
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Mô tả</label>
                        <textarea
                            v-model="form.description"
                            class="w-full border rounded px-3 py-2"
                            placeholder="Nhập mô tả..."
                        ></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Biểu tượng (URL)</label>
                        <input
                            v-model="form.icon_path"
                            type="text"
                            class="w-full border rounded px-3 py-2"
                            placeholder="https://..."
                        />
                    </div>
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                    >
                        Hủy
                    </button>
                    <button
                        @click="saveBadge"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        Lưu
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const badges = ref([
    {
        id: 1,
        name: "Người đóng góp tích cực",
        description: "Đã viết hơn 10 bài đánh giá chất lượng",
        icon_path: "https://cdn-icons-png.flaticon.com/512/616/616489.png",
        user_count: 15,
    },
    {
        id: 2,
        name: "Thành viên mới",
        description: "Mới tham gia hệ thống",
        icon_path: "https://cdn-icons-png.flaticon.com/512/1828/1828884.png",
        user_count: 120,
    },
]);

const isModalOpen = ref(false);
const isEditing = ref(false);
const form = ref({ id: null, name: "", description: "", icon_path: "" });

function openAddModal() {
    isEditing.value = false;
    form.value = { id: null, name: "", description: "", icon_path: "" };
    isModalOpen.value = true;
}

function openEditModal(badge) {
    isEditing.value = true;
    form.value = { ...badge };
    isModalOpen.value = true;
}

function closeModal() {
    isModalOpen.value = false;
}

function saveBadge() {
    if (isEditing.value) {
        const index = badges.value.findIndex((b) => b.id === form.value.id);
        if (index !== -1) badges.value[index] = { ...form.value };
    } else {
        const newBadge = {
            ...form.value,
            id: Date.now(),
            user_count: 0,
        };
        badges.value.push(newBadge);
    }
    closeModal();
}

function deleteBadge(id) {
    badges.value = badges.value.filter((b) => b.id !== id);
}
</script>
