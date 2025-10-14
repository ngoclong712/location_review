<template>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Banner List</h1>

            <!-- Nút mở modal -->
            <button
                @click="showModal = true"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow"
            >
                + Add Banner
            </button>
        </div>

        <!-- Grid hiển thị banner -->
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
        >
            <div
                v-for="banner in banners"
                :key="banner.id"
                class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 flex flex-col relative"
            >
                <!-- Trạng thái Public -->
                <span
                    class="absolute top-2 right-2 px-2 py-1 text-xs font-semibold rounded-full"
                    :class="banner.is_public ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600'"
                >
          {{ banner.is_public ? 'Public' : 'Private' }}
        </span>

                <!-- Ảnh -->
                <img
                    :src="banner.value"
                    alt="Banner"
                    class="w-full h-40 object-cover"
                />

                <!-- Actions -->
                <div class="p-4 flex justify-between items-center">
                    <button
                        @click="togglePublic(banner)"
                        class="px-3 py-1 rounded-lg text-sm font-medium transition"
                        :class="banner.is_public
              ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200'
              : 'bg-green-100 text-green-700 hover:bg-green-200'"
                    >
                        {{ banner.is_public ? 'Make Private' : 'Make Public' }}
                    </button>

                    <button
                        @click="deleteBanner(banner.id)"
                        class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded-lg text-sm font-medium transition"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Upload Banner -->
        <div
            v-if="showModal"
            class="fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center z-50"
        >
            <div class="bg-white p-6 rounded-xl shadow-lg w-96 relative">
                <h2 class="text-xl font-bold mb-4">Upload New Banner</h2>

                <!-- Chọn file -->
                <div class="flex flex-col items-center">
                    <input
                        type="file"
                        accept="image/*"
                        ref="fileInput"
                        @change="handleFileChange"
                        class="hidden"
                    />

                    <button
                        @click="fileInput?.click()"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg border border-gray-300"
                    >
                        Choose Image
                    </button>

                    <!-- Preview -->
                    <div v-if="previewUrl" class="mt-4">
                        <img
                            :src="previewUrl"
                            alt="Preview"
                            class="w-full h-40 object-cover rounded-lg border"
                        />
                    </div>

                    <p v-else class="text-gray-500 text-sm mt-4">Choose file to preview</p>
                </div>

                <!-- Actions -->
                <div class="mt-6 flex justify-end gap-3">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100"
                    >
                        Cancel
                    </button>
                    <button
                        @click="uploadBanner"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow"
                        :disabled="!selectedFile"
                    >
                        Add
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import api from "@/services/api";
import { useToast } from "vue-toastification";

const toast = useToast();

type Banner = {
    id: number;
    key: string;
    value: string;
    is_public: boolean;
};

const banners = ref<Banner[]>([]);
const showModal = ref(false);
const selectedFile = ref<File | null>(null);
const previewUrl = ref<string | null>(null);
const fileInput = ref<HTMLInputElement | null>(null);

const handleFileChange = (e: Event) => {
    const input = e.target as HTMLInputElement;
    if (input.files && input.files[0]) {
        selectedFile.value = input.files[0];
        previewUrl.value = URL.createObjectURL(input.files[0]);
    }
};

const uploadBanner = async () => {
    if (!selectedFile.value) {
        toast.warning("Please select an image file first!");
        return;
    }

    try {
        const formData = new FormData();
        formData.append("banner", selectedFile.value);

        const res = await api.post("/banner", formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        banners.value.push(res.data.data);
        toast.success("Banner uploaded successfully!");

        closeModal();
    } catch (error) {
        console.error(error);
        toast.error("Failed to upload banner!");
    }
};

const closeModal = () => {
    showModal.value = false;
    selectedFile.value = null;
    previewUrl.value = null;
};

const fetchBanners = async () => {
    try {
        const res = await api.get("/banner");
        banners.value = res.data.data;
    } catch (error) {
        console.error(error);
        toast.error("Failed to fetch banners!");
    }
};

const togglePublic = async (banner: Banner) => {
    try {
        const res = await api.put(`/banner/${banner.id}`, {
            is_public: !banner.is_public,
        });
        banner.is_public = res.data.data.is_public;
        toast.success("Updated banner visibility!");
    } catch (error) {
        console.error(error);
        toast.error("Failed to update banner!");
    }
};

const deleteBanner = async (id: number) => {
    try {
        await api.delete(`/banner/${id}`);
        banners.value = banners.value.filter((b) => b.id !== id);
        toast.success("Banner deleted!");
    } catch (error) {
        console.error(error);
        toast.error("Failed to delete banner!");
    }
};

onMounted(() => {
    fetchBanners();
});
</script>
