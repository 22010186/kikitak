<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import Upload from "vue-material-design-icons/Upload.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

let file = ref(null);
let fileDisplay = ref("");
let errorType = ref(null);
let fileData = ref(null);

const onchange = () => {
    fileDisplay.value = URL.createObjectURL(file.value.files[0]);
    fileData.value = file.value.files[0];
};

const onDrop = (e) => {
    file.value = e.dataTransfer.files[0];
    fileDisplay.value = URL.createObjectURL(file.value);
    fileData.value = e.dataTransfer.files[0];
};

const discard = () => {
    file.value = null;
    fileDisplay.value = null;
    fileData.value = null;
};

const form = useForm({
    file: fileData.value,
});

const update = () => {
    form.file = fileData.value;
    form.post("/profile/avatar", {
        onSuccess: () => {
            router.visit("/");
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Thay avatar</h2>

            <p class="mt-1 text-sm text-gray-600">
                Bạn có thể chính sửa avatar của bạn trên trang cá nhân.
            </p>
        </header>

        <form @submit.prevent="update()" class="mt-6 space-y-6">
            <div>
                <label
                    v-if="!fileDisplay"
                    @drop.prevent="onDrop($event)"
                    @dragover.prevent=""
                    for="fileInput"
                    class="md:mx-0 mx-auto mt-4 mb-6 flex flex-col items-center w-full max-w-[260px] h-40 text-center p-3 border-2 border-dashed border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer"
                >
                    <Upload fill-color="#b3b3b1" class="size-10" />
                    <div class="text-[17px]">Chọn một hình ảnh</div>
                    <p class="text-[13px] text-gray-50">Hoặc</p>
                    <div class="mt-1.50">Kéo ảnh vào trong ô</div>

                    <input
                        ref="file"
                        @input="onchange()"
                        type="file"
                        id="fileInput"
                        hidden
                        accept="image/*"
                    />
                </label>

                <img
                    v-if="fileDisplay"
                    class="md:mx-0 max-w-60 mx-auto rounded-full object-cover aspect-square"
                    :src="fileDisplay"
                />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="!fileDisplay || form.processing"
                    >Lưu</PrimaryButton
                >
                <DangerButton type="button" @click="discard()"
                    >Hủy</DangerButton
                >

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
