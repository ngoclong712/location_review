<template>
    <div>
        <section class="bg-gradient-to-b from-blue-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight">
                            Khám phá địa điểm ăn uống, cà phê và du lịch gần bạn
                        </h1>
                        <p class="mt-4 text-gray-600">
                            Tìm và chia sẻ trải nghiệm tại những địa điểm thú vị. Đánh giá, đăng ảnh và gợi ý cho cộng đồng.
                        </p>
                        <div class="mt-6 flex gap-3">
                            <RouterLink to="/" class="inline-flex items-center rounded-md bg-blue-600 px-5 py-2.5 text-white hover:bg-blue-700">Khám phá ngay</RouterLink>
                            <a href="#featured" class="inline-flex items-center rounded-md bg-gray-100 px-5 py-2.5 text-gray-800 hover:bg-gray-200">Xem nổi bật</a>
                        </div>
                    </div>

                    <!--Banner-->
                    <div class="hidden md:block">
                        <div class="w-full h-64 bg-white border rounded-xl shadow-sm grid grid-cols-3 gap-3 p-3">
                            <div v-for="banner in banners" :key="banner.id" class="rounded-lg overflow-hidden">
                                <img
                                    :src="banner.value"
                                    alt="Banner" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import api from "@/services/api";
import {useToast} from "vue-toastification";

const toast = useToast();

const banners = ref([]);

const fetchBanners = async () => {
    try {
        const response = await api.get("/banner-homepage");
        banners.value = response.data.data;
    } catch (error) {
        toast.error("Tải banner không thành công:");
    }
};

onMounted(() => {
    fetchBanners();
});
</script>
