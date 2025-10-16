<template>
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manage Badges</h1>

            <!-- Center: Search + Sort -->
            <div class="flex items-center gap-3 flex-1 justify-center">
                <div class="relative w-1/3">
                    <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search badges..."
                        class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-400"
                    />
                </div>
                <select
                    v-model="sortOption"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400"
                >
                    <option value="latest">Latest</option>
                    <option value="oldest">Oldest</option>
                    <option value="name_asc">Name A–Z</option>
                    <option value="name_desc">Name Z–A</option>
                </select>
            </div>

            <!-- Right: Add button -->
            <button
                @click="openModal = true"
                class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
            >
                <Plus class="w-4 h-4" />
                <span>Add Badge</span>
            </button>
        </div>

        <!-- Modal -->
        <div
            v-if="openModal"
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
            <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 relative">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">Add New Badge</h2>
                    <button @click="closeModal">
                        <X class="w-5 h-5 hover:text-gray-500"></X>
                    </button>
                </div>

                <!-- Form -->
                <form @submit.prevent="handleAddBadge" class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400"
                            placeholder="Enter badge name"
                        />
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea
                            v-model="form.description"
                            rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400 resize-none"
                            placeholder="Enter description (optional)"
                        ></textarea>
                    </div>

                    <!-- Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Badge Image</label>
                        <input
                            type="file"
                            accept="image/png,image/jpeg,image/webp"
                            @change="onFileChange"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-600 file:text-white file:cursor-pointer"
                        />
                        <div v-if="preview" class="mt-3">
                            <img :src="preview" alt="Preview" class="w-24 h-24 rounded-lg border object-cover" />
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button
                            type="button"
                            @click="closeModal"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700"
                        >
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!--Edit Modal-->
        <!-- Edit Modal -->
        <div
            v-if="openEditModal"
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
            <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 relative">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">Edit Badge</h2>
                    <button @click="closeEditModal">
                        <X class="w-5 h-5 hover:text-gray-500"></X>
                    </button>
                </div>

                <form @submit.prevent="handleUpdateBadge" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input
                            v-model="selectedBadge.name"
                            type="text"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea
                            v-model="selectedBadge.description"
                            rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400 resize-none"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Badge Image (optional)</label>
                        <input
                            type="file"
                            accept="image/png,image/jpeg,image/webp"
                            @change="onFileChange"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-600 file:text-white file:cursor-pointer"
                        />
                        <div v-if="preview" class="mt-3">
                            <img :src="preview" alt="Preview" class="w-24 h-24 rounded-lg border object-cover" />
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button
                            type="button"
                            @click="closeEditModal"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700"
                        >
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Badge Table -->
        <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-700">ID</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-700">Name</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-700">Description</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-700">Icon</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-700">Updated At</th>
                    <th class="px-6 py-3 text-center font-semibold text-gray-700">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                <tr
                    v-for="badge in filteredBadge"
                    :key="badge.id"
                    class="hover:bg-gray-50 transition"
                >
                    <td class="px-6 py-3 text-gray-700">{{ badge.id }}</td>
                    <td class="px-6 py-3 font-medium text-gray-800">{{ badge.name }}</td>
                    <td class="px-6 py-3 text-gray-600">
                        <span v-if="badge.description">{{ badge.description }}</span>
                        <span v-else class="text-gray-400 italic">No description</span>
                    </td>
                    <td class="px-6 py-3">
                        <img
                            v-if="badge.icon_path"
                            :src="badge.icon_path"
                            alt="Badge Icon"
                            class="w-12 h-12 object-cover rounded-md border"
                        />
                        <span v-else class="text-gray-400 italic">No image</span>
                    </td>
                    <td class="px-6 py-3 text-gray-600">
                        {{ new Date(badge.updated_at).toLocaleString() }}
                    </td>
                    <td class="px-6 py-3 text-center align-middle">
                        <div class="inline-flex items-center justify-center gap-3">
                            <button
                                @click="editBadge(badge)"
                                class="text-blue-600 hover:text-blue-800 transition"
                            >
                                <Edit class="w-5 h-5" />
                            </button>
                            <button
                                @click="deleteBadge(badge.id)"
                                class="text-red-600 hover:text-red-800 transition"
                            >
                                <Trash2 class="w-5 h-5" />
                            </button>
                        </div>
                    </td>
                </tr>
                <tr v-if="badges.length === 0">
                    <td colspan="6" class="px-6 py-6 text-center text-gray-500 italic">
                        No badges found.
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref,onMounted,computed } from "vue";
import { Plus, Search, X, Edit, Trash2 } from "lucide-vue-next";
import api from "@/services/api.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const openModal = ref(false);
const openEditModal = ref(false);
const selectedBadge = ref<Badge | null>(null);
const searchQuery = ref("");
const sortOption = ref("latest");

const form = ref({
    name: "",
    description: "",
    badge: null,
});

type Badge = {
    id: number;
    name: string;
    description: string | null;
    icon_path: string | null;
    updated_at: string;
};

const badges = ref<Badge[]>([]);

const filteredBadge = computed(() => {
    let filtered = badges.value;

    if(searchQuery.value) {
        filtered = filtered.filter(badge =>
            badge.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    }

    if (sortOption.value === 'latest') {
        filtered.sort((a, b) => b.id - a.id);
    }
    else if (sortOption.value === 'oldest') {
        filtered.sort((a, b) => a.id - b.id);
    }
    else if (sortOption.value === 'name_asc') {
        filtered.sort((a, b) => a.name.localeCompare(b.name));
    }
    else if (sortOption.value === 'name_desc') {
        filtered.sort((a, b) => b.name.localeCompare(a.name));
    }

    return filtered;
})
const fetchBadges = async () => {
    try {
        const res = await api.get("/badge");
        badges.value = res.data.data;
    } catch (error) {
        toast.error("Failed to load badges!");
        console.error(error);
    }
};

const editBadge = (badge: Badge) => {
    selectedBadge.value = { ...badge };
    preview.value = badge.icon_path;
    openEditModal.value = true;
};

function closeEditModal() {
    openEditModal.value = false;
    selectedBadge.value = null;
    preview.value = null;
}

const deleteBadge = async (id: number) => {
    if (!confirm("Are you sure you want to delete this badge?")) return;
    try {
        await api.delete(`/badge/${id}`);
        badges.value = badges.value.filter((b) => b.id !== id);
        toast.success("Badge deleted successfully!");
    } catch (error) {
        toast.error("Failed to delete badge!");
    }
};

const preview = ref(null);

function onFileChange(e) {
    const file = e.target.files[0];
    if (file && file.type.startsWith("image/")) {
        form.value.badge = file;
        preview.value = URL.createObjectURL(file);
    } else {
        toast.error("Please select a valid image file (PNG, JPG, WEBP).");
    }
}

function closeModal() {
    openModal.value = false;
    preview.value = null;
    form.value = { name: "", description: "", badge: null };
}

async function handleAddBadge() {
    try {
        const formData = new FormData();
        formData.append("name", form.value.name);
        formData.append("description", form.value.description);
        formData.append("badge", form.value.badge);

        const res = await api.post("/badge", formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        toast.success("Badge added successfully!");
        closeModal();
        fetchBadges();
    } catch (error) {
        if (error.response?.status === 422) {
            const errors = error.response.data.errors;
            if (errors) {
                Object.values(errors).forEach((msgs) =>
                    msgs.forEach((msg) => toast.error(msg))
                );
            }
        } else {
            console.error(error);
            toast.error(error.response?.data?.message || "Error occurred!");
        }
    }
}

async function handleUpdateBadge() {
    if (!selectedBadge.value) return;

    try {
        const formData = new FormData();
        formData.append("name", selectedBadge.value.name);
        formData.append("description", selectedBadge.value.description || "");
        if (form.value.badge) formData.append("badge", form.value.badge);

        await api.post(`/badge/${selectedBadge.value.id}?_method=PUT`, formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        toast.success("Badge updated successfully!");
        closeEditModal();
        fetchBadges();
    } catch (error) {
        if (error.response?.status === 422) {
            const errors = error.response.data.errors;
            if (errors) {
                Object.values(errors).forEach((msgs) =>
                    msgs.forEach((msg) => toast.error(msg))
                );
            }
        } else {
            console.error(error);
            toast.error(error.response?.data?.message || "Error occurred!");
        }
    }
}

onMounted(() => {
    fetchBadges();
})
</script>

<style scoped>
.fixed {
    animation: fadeIn 0.25s ease-out;
}
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>
