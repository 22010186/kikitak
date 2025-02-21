<template>
    <div class="md:max-w-2xl md:mx-auto md:mt-10 md:rounded-xl bg-white">
        <div
            class="flex items-center justify-between md:inline-block p-2 m-2 rounded-full cursor-pointer"
        >
            <div
                @click="closeMessageBox()"
                class="hover:bg-black/10 inline-block p-2 rounded-full cursor-pointer"
            >
                <Close fillColor="#000" :size="28" class="md:block hidden" />
                <ArrowLeft fillColor="#000" :size="28" class="md:hidden" />
            </div>

            <button
                @click="addTweet()"
                :disabled="!tweet"
                class="md:hidden font-extrabold text-base p-1.5 px-4 rounded-full cursor-pointer"
                :class="
                    tweet
                        ? 'bg-[#3b82fc] text-white'
                        : 'bg-[#124d77] text-gray-400'
                "
            >
                Tweet
            </button>
        </div>

        <div class="w-full flex">
            <div class="ml-3.5 mr-2">
                <img
                    class="rounded-full size-[55px] object-cover"
                    :src="
                        auth.user.avatar ??
                        `https://avatar.iran.liara.run/username?username=[${auth.user.name}]`
                    "
                    alt=""
                />
            </div>
            <div class="w-[calc(100%-100px)]">
                <div class="inline-block w-full">
                    <div
                        class="flex items-center border border-gray-700 rounded-full"
                    >
                        <span class="text-mainColor pl-3.5 font-extrabold">
                            Everyone
                        </span>
                        <ChevronDown
                            class="pr-2"
                            fillColor="#1c9cef"
                            :size="25"
                        />
                    </div>
                    <div>
                        <textarea
                            @input="textareaInput"
                            cols="30"
                            rows="4"
                            placeholder="What's happening?"
                            ref="textarea"
                            class="w-full mt-2 focus:ring-0 text-black rounded-xl font-extrabold min-h-[120px]"
                        ></textarea>
                    </div>
                    <div class="w-full">
                        <video
                            v-if="uploadType === 'mp4'"
                            :src="showUpload"
                            controls
                            class="rounded-xl overflow-auto w-fit max-h-80"
                        ></video>
                        <img
                            v-else
                            :src="showUpload"
                            class="rounded-xl w-fit max-h-80"
                            alt=""
                        />
                    </div>
                    <div
                        class="flex py-2 items-center text-mainColor font-extrabold"
                    >
                        <Earth fillColor="#1c9cef" :size="20" />
                        <span class="pl-2">Everyone can reply</span>
                    </div>
                    <div class="border-b border-gray-700" />
                    <div class="flex items-center justify-between py-2">
                        <div class="flex items-center">
                            <div
                                class="hover:bg-gray-800/10 inline-block p-2 rounded-full cursor-pointer"
                            >
                                <label for="fileUpload" class="cursor-pointer">
                                    <ImageOutline
                                        fillColor="#1c9cef"
                                        :size="25"
                                    />
                                </label>
                                <input
                                    type="file"
                                    id="fileUpload"
                                    hidden
                                    @change="getFile($event)"
                                    accept="image/*,video/*"
                                />
                            </div>
                            <div
                                class="hover:bg-gray-800/10 inline-block p-2 rounded-full cursor-pointer"
                            >
                                <FileGifBox fillColor="#1c9cef" :size="25" />
                            </div>
                            <div
                                class="hover:bg-gray-800/10 inline-block p-2 rounded-full cursor-pointer"
                            >
                                <Emoticon fillColor="#1c9cef" :size="25" />
                            </div>
                        </div>
                        <button
                            @click="addTweet()"
                            :disabled="!tweet || form.processing"
                            class="hidden md:block font-extrabold text-base p-1.5 px-4 rounded-full cursor-pointer"
                            :class="
                                tweet
                                    ? 'bg-[#3b82fc] text-white'
                                    : 'bg-[#124d77] text-gray-400'
                            "
                        >
                            Tweet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router, usePage, useForm } from "@inertiajs/vue3";
import Close from "vue-material-design-icons/Close.vue";
import ChevronDown from "vue-material-design-icons/ChevronDown.vue";
import Earth from "vue-material-design-icons/Earth.vue";
import ImageOutline from "vue-material-design-icons/ImageOutline.vue";
import FileGifBox from "vue-material-design-icons/FileGifBox.vue";
import Emoticon from "vue-material-design-icons/Emoticon.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";

const form = useForm({
    tweet: "",
    file: null,
});
const auth = usePage().props.auth;

const tweet = ref("");
const textarea = ref(null);
const showUpload = ref("");
const uploadType = ref("");

const emits = defineEmits(["close"]);

const textareaInput = (e) => {
    tweet.value = e.target.value;
    textarea.value.style.height = "auto";
    textarea.value.style.height = `${e.target.scrollHeight}px`;
};

const getFile = (e) => {
    form.file = e.target.files[0];
    uploadType.value = form.file.name.split(".").pop();
    showUpload.value = URL.createObjectURL(e.target.files[0]);
};

const closeMessageBox = () => {
    emits("close");
    showUpload.value = "";
    uploadType.value = "";
};

const addTweet = () => {
    form.tweet = tweet.value;
    form.post("/tweets", {
        onSuccess: () => {
            router.visit("/");
        },
        onFinish: () => {
            closeMessageBox();
        },
    });
};
</script>
