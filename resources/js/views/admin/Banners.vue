<template>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Banner List</h1>

            <select v-model="statusFilter" class="px-3 py-2 border border-gray-200 rounded-lg bg-white">
                <option value="">All Status</option>
                <option value="1">Public</option>
                <option value="0">Private</option>
            </select>
            <!-- Nút mở modal -->
            <button
                @click="showModal = true"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center"
            >
                <Plus class="w-5 h-5 mr-1"></Plus>
                 Add Banner
            </button>
        </div>

        <div
            v-if="isLimitReached"
            class="bg-red-100 text-red-700 border border-red-300 rounded-lg px-4 py-2 mb-3 flex items-center"
        >
            <TriangleAlert class="w-4 h-4 mr-1"></TriangleAlert>
            <span>
             You can only have up to {{ MAX_PUBLIC }} public banners ({{ publicCount }} currently).
            </span>
        </div>
        <!-- Grid hiển thị banner -->
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
        >
            <div
                v-for="banner in filteredBanner"
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
                    >
                        Add
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref,computed,onMounted } from "vue";
import api from "@/services/api";
import { useToast } from "vue-toastification";
import { TriangleAlert, Plus } from 'lucide-vue-next'

const toast = useToast();

const MAX_PUBLIC = 6;

const publicCount = computed(() =>
    banners.value.filter((b) => b.is_public == 1).length
);

const isLimitReached = computed(() => publicCount.value >= MAX_PUBLIC - 1);

const statusFilter = ref<number | ''>('');

type Banner = {
    id: number;
    key: string;
    value: string;
    is_public: number;
};

const banners = ref<Banner[]>([]);

const filteredBanner = computed(() => {
    if (statusFilter.value === '') return banners.value;
    const wanted = Number(statusFilter.value);
    return banners.value.filter(n => n.is_public === wanted);
});

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
    } catch (error: any) {
        if (error.response?.status === 422) {
            const errors = error.response.data.errors as Record<string, string[]>;
            if (errors) {
                Object.values(errors).forEach((msgs) => {
                    msgs.forEach((msg) => toast.error(msg));
                });
            }
        } else {
            toast.error(error.response?.data?.message || "Error occurred!");
        }
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
    if (!banner.is_public && publicCount.value >= MAX_PUBLIC) {
        toast.error(`You can only have up to ${MAX_PUBLIC} public banners.`);
        return;
    }
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
