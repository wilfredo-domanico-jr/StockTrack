<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";

const windowWidth = ref(window.innerWidth);
const loading = ref(true); // Track loading state

const imagesToPreload = [
    "/images/StockTrackLogo.png",
    "/images/StockTrackLoginBG2.png",
];

// Preload function
const preloadImages = (urls) => {
    return Promise.all(
        urls.map(
            (url) =>
                new Promise((resolve) => {
                    const img = new Image();
                    img.src = url;
                    img.onload = resolve;
                    img.onerror = resolve; // Continue even if one fails
                })
        )
    );
};

const updateWidth = () => {
    windowWidth.value = window.innerWidth;
};

onMounted(async () => {
    // Preload images first
    await preloadImages(imagesToPreload);
    loading.value = false; // All images loaded
    window.addEventListener("resize", updateWidth);
});

onUnmounted(() => {
    window.removeEventListener("resize", updateWidth);
});

const bgImage = computed(() => {
    return windowWidth.value >= 768
        ? "url('/images/StockTrackLoginBG2.png')"
        : "none";
});
</script>

<template>
    <div v-if="loading" class="flex items-center justify-center min-h-screen">
        <p class="text-gray-600">Loading...</p>
        <!-- You can add a spinner here -->
    </div>

    <div
        v-else
        class="min-h-screen flex flex-col justify-center"
        :style="{
            backgroundImage: bgImage,
            backgroundSize: 'cover',
            backgroundPosition: 'center',
        }"
    >
        <!-- LOGO FOR SMALL SCREEN -->
        <div class="flex justify-center md:hidden">
            <img
                src="/images/StockTrackLogo.png"
                alt="StockTrack Logo - For Small Screen"
                class="w-[250px] h-[150px]"
            />
        </div>

        <!-- MAIN CONTENT -->
        <div
            class="flex justify-center items-center mx-auto mt-[-30px] mb-12 md:justify-start md:ml-16 md:h-screen md:items-center md:mx-0 md:mt-0"
        >
            <div
                class="bg-white rounded-xl border border-gray-200 flex flex-col justify-center items-center shadow-2xl py-12 px-8 md:w-1/4"
            >
                <slot />
            </div>
        </div>

        <!-- Footer -->`
        <footer
            class="fixed bottom-0 left-0 w-full text-center text-white p-2 text-sm bg-blue-800 md:hidden"
        >
            © 2025 StockTrack. All rights reserved.
        </footer>
    </div>
</template>
