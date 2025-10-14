<template>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Banner Config</h1>

            <!-- Add new banner -->
            <div class="flex items-center gap-3">
                <input
                    type="file"
                    accept="image/*"
                    @change="handleFileChange"
                    class="border border-gray-300 p-2 rounded"
                />
                <button
                    @click="addBanner"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow"
                >
                    + Add Banner
                </button>
            </div>
        </div>

        <!-- Banner Grid -->
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
        >
            <div
                v-for="banner in banners"
                :key="banner.id"
                class="relative bg-white rounded-xl shadow-md overflow-hidden border border-gray-200"
            >
                <!-- Status label -->
                <span
                    class="absolute top-3 right-3 z-10 px-2 py-1 text-xs font-semibold rounded-full"
                    :class="
            banner.is_public
              ? 'bg-green-100 text-green-700'
              : 'bg-gray-200 text-gray-700'
          "
                >
          {{ banner.is_public ? 'Public' : 'Private' }}
        </span>

                <!-- Image -->
                <img
                    :src="banner.value"
                    alt="Banner"
                    class="w-full h-48 object-cover rounded-t-xl"
                />

                <!-- Actions -->
                <div class="p-4 flex justify-between items-center">
                    <button
                        @click="togglePublic(banner)"
                        class="px-3 py-1 rounded-lg text-sm font-medium transition"
                        :class="
              banner.is_public
                ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200'
                : 'bg-green-100 text-green-700 hover:bg-green-200'
            "
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
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import api from "@/services/api";

type Banner = {
    id: number;
    key: string;
    value: string;
    is_public: boolean;
};

const banners = ref<Banner[]>([]);
const selectedFile = ref<File | null>(null);

const handleFileChange = (e: Event) => {
    const input = e.target as HTMLInputElement;
    if (input.files && input.files[0]) {
        selectedFile.value = input.files[0];
    }
};

const addBanner = () => {
    if (!selectedFile.value) {
        alert("Please select an image file first!");
        return;
    }

    const newBanner: Banner = {
        id: Date.now(),
        key: "banner_" + Date.now(),
        value: URL.createObjectURL(selectedFile.value),
        is_public: false,
    };

    banners.value.push(newBanner);
    selectedFile.value = null;
};

const togglePublic = (banner: Banner) => {
    banner.is_public = !banner.is_public;
};

const deleteBanner = (id: number) => {
    banners.value = banners.value.filter((b) => b.id !== id);
};

const fetchBanners = async () => {
    try {
        const res = await api.get("/banner");
        banners.value = res.data.data;
    } catch (error) {
        console.error(error);
    }
};

onMounted(() => {
    fetchBanners();
});
</script>
