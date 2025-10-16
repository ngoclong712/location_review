<template>
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow">
        <h2 class="text-2xl font-bold mb-6">Chỉnh sửa hồ sơ</h2>

        <form @submit.prevent="updateProfile" class="space-y-6">
            <!-- Avatar -->
            <div class="flex items-center gap-6">
                <img
                    :src="avatarPreview"
                    alt="Avatar"
                    class="w-24 h-24 rounded-full object-cover border"
                />
                <div>
                    <label
                        for="avatar"
                        class="cursor-pointer px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        Chọn ảnh
                    </label>
                    <input
                        type="file"
                        id="avatar"
                        class="hidden"
                        accept="image/*"
                        @change="handleFileChange"
                    />
                    <p class="text-gray-500 text-sm mt-2">Chỉ hỗ trợ JPG, PNG ≤ 2MB</p>
                </div>
            </div>

            <!-- Name -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Tên hiển thị</label>
                <input
                    v-model="form.name"
                    type="text"
                    class="w-full border rounded-lg p-2"
                    required
                />
            </div>

            <!-- Bio -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Giới thiệu</label>
                <textarea
                    v-model="form.bio"
                    rows="4"
                    class="w-full border rounded-lg p-2 resize-none"
                    placeholder="Viết vài dòng giới thiệu bản thân..."
                ></textarea>
            </div>

            <!-- Submit -->
            <div class="text-right">
                <button
                    type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                    :disabled="loading"
                >
                    <span v-if="!loading">💾 Lưu thay đổi</span>
                    <span v-else>Đang lưu...</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import web from "@/services/web.js";
import { useAuthStore } from "@/stores/auth";
import { useToast } from "vue-toastification";

const auth = useAuthStore();
const toast = useToast();

const user = auth.user;
const form = ref({
    name: user?.name || "",
    bio: user?.bio || "",
});

const avatarFile = ref(null);
const avatarPreview = ref(user?.avatar_path || "/images/defaults/no-avatar.jpg");
const loading = ref(false);

function handleFileChange(e) {
    const file = e.target.files[0];
    if (file) {
        if (!['image/jpeg','image/png','image/webp'].includes(file.type)) {
            toast.error('Chỉ hỗ trợ JPG, PNG, WEBP');
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            toast.error('Dung lượng tối đa 2MB');
            return;
        }
        avatarFile.value = file;
        avatarPreview.value = URL.createObjectURL(file);
    }
}

async function updateProfile() {
    try {
        loading.value = true;

        const formData = new FormData();
        formData.append("name", form.value.name);
        formData.append("bio", form.value.bio);
        if (avatarFile.value) {
            formData.append("avatar", avatarFile.value);
        }

        const res = await web.post("/profile/update", formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        auth.setUser(res.data.data);
        toast.success("Cập nhật hồ sơ thành công!");
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
    } finally {
        loading.value = false;
    }
}
</script>

<style scoped>
textarea::-webkit-scrollbar {
    width: 6px;
}
textarea::-webkit-scrollbar-thumb {
    background-color: #cbd5e1;
    border-radius: 10px;
}
</style>
