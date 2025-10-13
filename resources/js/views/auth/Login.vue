<template>
    <div class="w-full max-w-md mx-auto border rounded-xl p-6 bg-white">
        <h1 class="text-2xl font-semibold text-center">Đăng nhập</h1>
        <form class="mt-6 grid gap-4">
            <div class="grid gap-1">
                <label class="text-sm text-gray-700">Email</label>
                <input type="email" class="border rounded-md px-3 py-2 focus:outline-none focus:ring w-full" placeholder="you@example.com" />
            </div>
            <div class="grid gap-1">
                <label class="text-sm text-gray-700">Mật khẩu</label>
                <input type="password" class="border rounded-md px-3 py-2 focus:outline-none focus:ring w-full" placeholder="••••••••" />
            </div>
            <button type="button" class="mt-2 inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 w-full">Đăng nhập</button>
            <p class="text-center text-sm text-gray-600">Chưa có tài khoản?
                <RouterLink to="/auth/register" class="text-blue-600 hover:underline">Đăng ký</RouterLink>
            </p>
        </form>
    </div>
</template>
