<template>
    <div class="fixed w-full mx-auto bg-white">
        <div class="max-w-[1400px] flex mx-auto">
            <!-- Left sidebar -->
            <div
                class="relative lg:w-3/12 w-[60px] h-screen max-w-[350px] lg:px-4 lg:mx-auto"
            >
                <div
                    class="p-2 px-3 mb-4 flex items-center justify-start border-b border-gray-800"
                >
                    <div class="w-40">
                        <ApplicationLogo />
                    </div>
                </div>

                <div>
                    <MenuItemComponent iconString="Home" :active="true" />
                    <MenuItemComponent iconString="Explore" />
                    <MenuItemComponent iconString="Notifications" />
                    <MenuItemComponent iconString="Messages" />
                    <Link href="/profile">
                        <MenuItemComponent iconString="Profile" />
                    </Link>

                    <button
                        @click="handleOpenCreateTweetOverlay()"
                        class="lg:w-full mt-8 ml-2 text-white font-extrabold text-xl bg-[#3b82fc] p-3 px-3 rounded-full cursor-pointer"
                    >
                        <span class="lg:block hidden">Tweet</span>
                        <span class="block lg:hidden">
                            <Feather fillColor="#fff" :size="20" />
                        </span>
                    </button>
                </div>

                <div v-if="auth.user" class="absolute bottom-0">
                    <div
                        class="lg:w-full mt-8 ml-2 text-xl p-3 px-0 lg:px-3 cursor-pointer flex items-center"
                    >
                        <img
                            class="rounded-full w-12 lg:w-16 aspect-square object-cover mr-4 shadow-sm"
                            :src="
                                auth.user.avatar ??
                                `https://avatar.iran.liara.run/username?username=[${auth.user.name}]`
                            "
                            alt="avatar"
                        />
                        <div class="w-full hidden lg:block">
                            <p class="text-black font-semibold">
                                {{ auth.user.name }}
                            </p>
                            <p class="text-gray-800 text-sm">
                                {{ auth.user.email }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main section -->
            <div class="lg:w-7/12 w-11/12 border-x border-gray-800 relative">
                <main
                    class="absolute top-0 z-0 h-full w-full overflow-auto scrollbar-hide"
                >
                    <div class="mt-44" />
                    <slot />
                    <div class="pb-4" />
                </main>
            </div>

            <!-- Right sidebar -->
            <div
                class="lg:block hidden lg:w-4/12 h-screen border-l border-gray-800 lg:px-4"
            >
                <div
                    class="relative w-full p-1 mt-2 px-4 lg:flex items-center rounded-full border border-black hidden"
                >
                    <Magnify fillColor="#5e5c5c" :size="25" />
                    <input
                        type="text"
                        v-model="search"
                        @input="debouncedSearch()"
                        class="appearance-none w-full border-none py-2 text-black placeholder-gray-500 leading-tight focus:ring-0"
                        placeholder="Tìm kiếm"
                    />

                    <div
                        v-if="search.trim().length"
                        class="scrollbar-hide hidden lg:block absolute w-full bg-white shadow-lg border rounded-xl h-40 top-12 left-0 overflow-y-scroll"
                    >
                        <div v-if="isLoading" class="p-4">
                            <p class="text-red-600 text-center">Searching...</p>
                        </div>
                        <div v-else-if="users.length">
                            <Link
                                v-for="user in users"
                                :href="`/user/${user.id}`"
                                :key="user.id"
                                class="mb-4 p-2 w-full cursor-pointer flex items-center border-b border-gray-800 hover:bg-black/10 transition duration-200 ease-in-out"
                            >
                                <img
                                    class="rounded-full w-12 lg:w-16 aspect-square object-cover mr-4 shadow-sm"
                                    :src="
                                        user.avatar ??
                                        `https://avatar.iran.liara.run/username?username=[${user.name}]`
                                    "
                                    alt="avatar"
                                />
                                <div class="w-full hidden lg:block">
                                    <p class="text-black font-semibold">
                                        {{ user.name }}
                                    </p>
                                    <p class="text-gray-800 text-sm">
                                        {{ user.email }}
                                    </p>
                                </div>
                            </Link>
                        </div>
                        <div v-else class="p-4">
                            <p class="text-red-600 text-center">
                                Không có tên người dùng trùng khớp!
                            </p>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-4 rounded-lg lg:block hidden">
                    <div
                        class="w-full p-4 text-black font-extrabold mb-6 text-xl border-b border-gray-800"
                    >
                        Điều gì đang diễn ra?
                    </div>
                    <div
                        class="h-[80px] hover:bg-black/10 rounded-xl cursor-pointer transition duration-200 ease-in-out"
                    >
                        <div class="flex p-3 justify-between h-[80px] px-3">
                            <div>
                                <div class="text-sm text-black">
                                    Tennis Tournament LIVE
                                </div>
                                <div
                                    class="w-full text-black font-extrabold mb-6 text-base"
                                >
                                    Lorem ipsum dolor sit amet consectetur.
                                </div>
                            </div>
                            <img
                                :src="randImg2"
                                class="rounded-full object-contain"
                                alt=""
                            />
                        </div>
                    </div>
                    <div
                        class="hover:bg-black/10 rounded-xl cursor-pointer transition duration-200 ease-in-out"
                    >
                        <div class="flex p-3 justify-between">
                            <div>
                                <div class="text-sm text-black">Trending</div>
                                <div
                                    class="w-full text-black font-extrabold mb-2 text-base"
                                >
                                    {{ quotes[0]?.quote }}
                                </div>
                                <div class="text-sm text-right text-black mb-6">
                                    -{{ quotes[0]?.author }}-
                                </div>
                                <div class="text-sm text-black">
                                    40,731 Views
                                </div>
                            </div>
                            <DotsHorizontal fillColor="#000" :size="20" />
                        </div>
                    </div>
                    <div
                        class="hover:bg-black/10 rounded-xl cursor-pointer transition duration-200 ease-in-out"
                    >
                        <div class="flex p-3 justify-between">
                            <div>
                                <div class="text-sm text-black">Trending</div>
                                <div
                                    class="w-full text-black font-extrabold mb-6 text-base"
                                >
                                    Lorem ipsum dolor sit amet consectetur.
                                </div>
                                <div class="text-sm text-black">
                                    40,731 Views
                                </div>
                            </div>
                            <DotsHorizontal fillColor="#000" :size="20" />
                        </div>
                    </div>
                    <div
                        class="hover:bg-black/10 rounded-xl cursor-pointer transition duration-200 ease-in-out"
                    >
                        <div class="flex p-3 justify-between">
                            <div>
                                <div class="text-sm text-black">Trending</div>
                                <div
                                    class="w-full text-black font-extrabold mb-6 text-base"
                                >
                                    Lorem ipsum dolor sit amet consectetur.
                                </div>
                                <div class="text-sm text-black">
                                    40,731 Views
                                </div>
                            </div>
                            <DotsHorizontal fillColor="#000" :size="20" />
                        </div>
                    </div>
                    <div
                        class="hover:bg-black/10 rounded-xl cursor-pointer transition duration-200 ease-in-out"
                    >
                        <div class="flex p-3 justify-between">
                            <div>
                                <div class="text-sm text-black">Trending</div>
                                <div
                                    class="w-full text-black font-extrabold mb-6 text-base"
                                >
                                    Lorem ipsum dolor sit amet consectetur.
                                </div>
                                <div class="text-sm text-black">
                                    40,731 Views
                                </div>
                            </div>
                            <DotsHorizontal fillColor="#000" :size="20" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        v-if="createTweet"
        id="OverLaySection"
        class="fixed top-0 left-0 w-full h-screen bg-black md:bg-black md:bg-opacity-30 md:p-3"
    >
        <CreateTweetOverlay @close="createTweet = false" />
    </div>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import { usePage, router, Link } from "@inertiajs/vue3";
import Magnify from "vue-material-design-icons/Magnify.vue";
import DotsHorizontal from "vue-material-design-icons/DotsHorizontal.vue";
import Feather from "vue-material-design-icons/Feather.vue";

import MenuItemComponent from "@/Components/MenuItemComponent.vue";
import CreateTweetOverlay from "@/Components/CreateTweetOverlay.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const createTweet = ref(false);
const auth = usePage().props.auth;
const quotes = ref([]);
const error = ref(null);
const search = ref("");
const users = ref([]);
const isLoading = ref(false);

const randImg2 = ref(
    `https://picsum.photos/id/${(Math.random() * 200).toFixed(0)}/100`
);

function handleOpenCreateTweetOverlay() {
    if (!auth.user) return router.visit("/login");
    createTweet.value = true;
}

function debounce(func, timeout = 1000) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(this, args);
        }, timeout);
    };
}

async function handleSearch() {
    if (!search.value.trim().length) return;
    isLoading.value = true;
    search.value = search.value.trim();
    await fetch(`/search?q=${search.value}`)
        .then((res) => res.json())
        .then((json) => (users.value = json))
        .catch((err) => (error.value = err));

    isLoading.value = false;
}

const debouncedSearch = debounce(() => handleSearch());

onBeforeMount(async () => {
    await fetch("https://api.api-ninjas.com/v1/quotes", {
        method: "GET",
        headers: {
            "X-Api-Key": "mOgglMUZV47bSciAKm9DEg==An8g107KkPPJRgze",
        },
    })
        .then((res) => res.json())
        .then((json) => (quotes.value = json))
        .catch((err) => (error.value = err));
});
</script>

<style>
body {
    background: black;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
</style>
