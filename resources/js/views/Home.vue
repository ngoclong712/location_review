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
                    <div class="hidden md:block">
                        <div class="w-full h-64 bg-white border rounded-xl shadow-sm grid grid-cols-3 gap-3 p-3">
                            <div class="bg-gray-100 rounded-lg"></div>
                            <div class="bg-gray-100 rounded-lg"></div>
                            <div class="bg-gray-100 rounded-lg"></div>
                            <div class="bg-gray-100 rounded-lg"></div>
                            <div class="bg-gray-100 rounded-lg"></div>
                            <div class="bg-gray-100 rounded-lg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured section -->
        <section id="featured" class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-semibold mb-6">Địa điểm nổi bật</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="border rounded-xl p-4 hover:shadow transition">
                        <div class="h-40 bg-gray-100 rounded-lg"></div>
                        <h3 class="mt-3 font-semibold">Quán cà phê Chill</h3>
                        <p class="text-gray-600 text-sm">Không gian yên tĩnh, phù hợp làm việc.</p>
                    </div>
                    <div class="border rounded-xl p-4 hover:shadow transition">
                        <div class="h-40 bg-gray-100 rounded-lg"></div>
                        <h3 class="mt-3 font-semibold">Bún bò Huế Cô Ba</h3>
                        <p class="text-gray-600 text-sm">Đậm vị miền Trung, giá hợp lý.</p>
                    </div>
                    <div class="border rounded-xl p-4 hover:shadow transition">
                        <div class="h-40 bg-gray-100 rounded-lg"></div>
                        <h3 class="mt-3 font-semibold">Điểm check-in bờ sông</h3>
                        <p class="text-gray-600 text-sm">Gió mát, cảnh đẹp, nhiều góc chụp hình.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
