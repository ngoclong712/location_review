<template>
    <header class="border-b bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <span class="text-xl font-bold">Review Địa Điểm</span>
                </div>
                <nav class="flex items-center gap-4">
                    <RouterLink to="/" class="text-gray-700 hover:text-black">Trang chủ</RouterLink>
                    <RouterLink
                        to="/auth/login"
                        class="ml-6 inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                    >
                        Đăng nhập
                    </RouterLink>
                </nav>
            </div>
        </div>
    </header>
</template>
