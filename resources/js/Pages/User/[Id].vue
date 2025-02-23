<template>
    <UserLayout>
        <div
            class="bg-opacity-60 bg-white backdrop-blur-lg z-10 sticky top-0 overflow-hidden"
        >
            <div class="border-gray-800 border-b w-full">
                <div class="w-full text-black text--xl font-extrabold p-4" />

                <div
                    class="flex items-center justify-center w-full h-32 text-gray-500 text-lg font-extrabold p-4 hover:bg-black/10 cursor-pointer transition duration-200 ease-in-out"
                >
                    <div
                        class="text-xl cursor-pointer flex items-center justify-center"
                    >
                        <img
                            class="rounded-full w-1/2 max-w-80 aspect-square object-cover mr-4 shadow-sm"
                            :src="
                                user.avatar ??
                                `https://avatar.iran.liara.run/username?username=[${user.name}]`
                            "
                            alt="avatar"
                        />
                        <div class="w-fit">
                            <p class="text-black font-semibold text-2xl">
                                {{ user.name }}
                            </p>
                            <p class="text-gray-800 text-lg">
                                {{ user.email }}
                            </p>
                            <hr class="my-1" />
                            <div
                                class="flex items-center justify-between gap-4 text-base [&_p]:text-sm text-center leading-none"
                            >
                                <div>
                                    {{ userTweets.length }}
                                    <p>Bài viết</p>
                                </div>
                                <div>
                                    {{ userTweets.length }}
                                    <p>Đang Follows</p>
                                </div>
                                <div>
                                    {{ userTweets.length }}
                                    <p>Follows</p>
                                </div>
                                <div>
                                    {{ userTweets.length }}
                                    <p>Thích</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="userTweets">
            <Tweet v-for="tweet in userTweets" :key="tweet.id" :tweet="tweet" />
        </div>
        <div
            v-else
            class="flex flex-col items-center justify-center text-xl text-red-500 [&>p:last-child]:text-lg"
        >
            <p>Opps, there are no tweets!</p>
            <p>Please create a tweet first</p>
        </div>
    </UserLayout>
</template>

<script setup>
import Tweet from "@/Components/Tweet.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import { usePage } from "@inertiajs/vue3";

defineProps({
    user: {
        type: Object,
    },
    userTweets: {
        type: Array,
    },
});

const url = usePage().url;
</script>

<style></style>
