<template>
    <div class="p-4 w-full hover:bg-black/5 border-b border-b-black/40 mb-3">
        <div
            class="font-extrabold flex items-center justify-between mt-0.5 mb-1.5"
        >
            <div class="flex items-center">
                <div class="min-w-[60px]">
                    <img
                        :src="
                            tweet.user.avatar ??
                            `https://avatar.iran.liara.run/username?username=[${tweet.user.name}]`
                        "
                        class="rounded-full mt-3 size-[50px] object-cover"
                        alt=""
                    />
                </div>
                <div>
                    <p>{{ tweet.user?.name ?? "User" }}</p>
                    <p class="font-light text-sm text-black">
                        {{ takeHandle(tweet.user?.name ?? "User") }}
                    </p>
                </div>
            </div>
            <div class="hover:bg-black/10 rounded-full cursor-pointer relative">
                <button v-if="auth.user?.id === tweet.user_id">
                    <DotsHorizontal
                        fillColor="#000"
                        @click="openOptions = !openOptions"
                    />
                </button>
                <div
                    v-if="openOptions"
                    class="absolute mt-1 right-0 w-[300px] bg-white border border-black rounded-lg shadow-lg"
                >
                    <Link
                        as="button"
                        method="delete"
                        :href="`/tweets/${tweet.id}`"
                        class="flex items-center cursor-pointer size-full p-2 px-3 hover:bg-red-200 hover:border-red-200"
                    >
                        <TrashCanOutline fillColor="#dc2626" :size="18" />
                        <p class="ml-2 text-red-600 font-extrabold">
                            Delete Tweet
                        </p>
                    </Link>
                </div>
            </div>
        </div>

        <div class="py-4 pl-5 text-black">{{ tweet?.tweet }}</div>

        <div v-if="tweet?.file">
            <div v-if="!tweet.isVideo" class="rounded-xl">
                <img
                    :src="formatLink(tweet.file)"
                    class="mt-2 object-fill rounded-xl w-full h-full"
                    alt=""
                />
            </div>
            <div v-else>
                <video
                    :src="formatLink(tweet.file)"
                    class="mt-2 object-fill rounded-xl w-full"
                    controls
                ></video>
            </div>
        </div>

        <div
            class="flex items-center justify-between mt-4 w-4/5 mx-auto [&>div]:cursor-pointer"
        >
            <div class="flex items-center">
                <MessageOutline fillColor="#000" :size="18" />
                <span class="text-xs font-extrabold text-[#000] ml-3">{{
                    tweet?.comments
                }}</span>
            </div>
            <div class="flex items-center">
                <Sync fillColor="#000" :size="18" />
                <span class="text-xs font-extrabold text-[#000] ml-3">{{
                    tweet?.retweets
                }}</span>
            </div>
            <div class="flex items-center">
                <HeartOutline fillColor="#000" :size="18" />
                <span class="text-xs font-extrabold text-[#000] ml-3">{{
                    tweet?.likes
                }}</span>
            </div>
            <div class="flex items-center">
                <ChartBar fillColor="#000" :size="18" />
                <span class="text-xs font-extrabold text-[#000] ml-3">{{
                    tweet?.analytics
                }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import HeartOutline from "vue-material-design-icons/HeartOutline.vue";
import ChartBar from "vue-material-design-icons/ChartBar.vue";
import MessageOutline from "vue-material-design-icons/MessageOutline.vue";
import Sync from "vue-material-design-icons/Sync.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import TrashCanOutline from "vue-material-design-icons/TrashCanOutline.vue";

defineProps({
    tweet: Object,
});

const auth = usePage().props.auth;

const openOptions = ref(false);

function takeHandle(name) {
    // Xóa dấu tiếng Việt
    const removeDiacritics = (str) => {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    };

    // Xử lý chuỗi: loại bỏ dấu, chuyển về chữ thường, xóa khoảng trắng
    const cleanName = removeDiacritics(name.trim().toLowerCase());
    const handle = "@" + cleanName.replace(/\s+/g, "");

    return handle;
}

function formatLink(string) {
    const pre = "https://kikitak-production.up.railway.app";
    return pre + string;
}
</script>
