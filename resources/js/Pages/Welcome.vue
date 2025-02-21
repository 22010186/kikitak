<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import Tweet from "@/Components/Tweet.vue";

defineProps({
    tweets: {
        type: Array,
    },
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <MainLayout>
        <div v-if="tweets">
            <Tweet v-for="tweet in tweets" :key="tweet.id" :tweet="tweet" />
        </div>
        <div
            v-else
            class="flex flex-col items-center justify-center text-xl text-red-500 [&>p:last-child]:text-lg"
        >
            <p>Opps, there are no tweets!</p>
            <p>Please create a tweet first</p>
        </div>
    </MainLayout>
</template>
