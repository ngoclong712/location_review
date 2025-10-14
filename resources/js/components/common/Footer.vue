<template>
    <footer class="bg-gray-100 border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row justify-between gap-6">
                <!-- About -->
                <div class="flex-1">
                    <h3 class="font-bold text-lg mb-2">🌍 Review Địa Điểm</h3>
                    <p class="text-gray-600 text-sm">
                        Ứng dụng web giúp người dùng khám phá, đánh giá và chia sẻ trải nghiệm
                        về các địa điểm như quán ăn, cà phê, hoặc địa điểm checkin.
                    </p>
                </div>

                <!-- Features -->
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-700 mb-2">Các phần chính</h4>
                    <ul class="text-gray-600 text-sm space-y-1">
                        <li>Quản lý địa điểm (Places)</li>
                        <li>Đánh giá & Bình luận (Reviews)</li>
                        <li>Hồ sơ người dùng (User Profile)</li>
                        <li>Tìm kiếm & Lọc nâng cao</li>
                    </ul>
                </div>

                <!-- Contact / Links -->
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-700 mb-2">Công nghệ</h4>
                    <ul class="text-gray-600 text-sm space-y-1">
                        <li>Backend: Laravel 11 (REST API)</li>
                        <li>Frontend: Vue 3 + Vue Router</li>
                        <li>Database: MySQL</li>
                        <li>CSS: TailwindCSS</li>
                        <li>Bản đồ: LeafletJS / Google Maps API</li>
                    </ul>
                </div>
            </div>

            <div class="mt-6 border-t pt-4 text-center text-gray-500 text-sm">
                &copy; 2025 Review Địa Điểm. All rights reserved.
            </div>
        </div>
    </footer>
</template>

<style scoped>
footer ul li::before {
    content: "•";
    margin-right: 0.25rem;
    color: #4B5563; /* gray-600 */
}
</style>
