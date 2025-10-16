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
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Plus, Search, X } from "lucide-vue-next";
import api from "@/services/api.js";
import { useToast } from "vue-toastification";

const toast = useToast();

const openModal = ref(false);
const searchQuery = ref("");
const sortOption = ref("latest");

const form = ref({
    name: "",
    description: "",
    badge: null,
});

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
        formData.append("badge", form.value.badge); // phải trùng tên 'badge' trong backend rule

        const res = await api.post("/badge", formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        toast.success("Badge added successfully!");
        closeModal();
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
