<script setup>
</script>

<template>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-teal-100"
    >
        <div class="w-3/4 h-auto container mx-auto flex flex-row gap-4 bg-white rounded shadow-xl">
         

            <div class="w-1/2 p-24 flex flex-col justify-center items-center bg-teal-300">
               <slot />
            </div>

            <div class="w-1/2 p-4 flex justify-center items-center">
                 <img src="images/StockTrackLogo.png" class="w-full h-full" />
            </div>
        </div>
    </div>
</template>
