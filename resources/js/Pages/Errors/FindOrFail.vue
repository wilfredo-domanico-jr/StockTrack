<script setup>

import { Head } from "@inertiajs/inertia-vue3";
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { defineProps } from "vue";

defineProps({
  statusTitle: String,
  paragraph: String,
});

</script>

<template>
  <Head title="Could Not Be Found" />

    <section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="mx-auto max-w-screen-sm text-center">

            <div class="flex items-center  rounded-lg p-8 justify-center">
                      <ApplicationLogo class="block h-32 w-auto" />
            </div>

            <h1 class="mb-4 text-7xl tracking-tight font-extrabold lg:text-5xl text-blue-600 dark:text-blue-500">{{ statusTitle }}</h1>
            <p class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-2xl dark:text-white">{{ paragraph }}</p>
            <a :href="route('Home.index')" class="inline-flex text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-blue-900 my-4">Back to Homepage</a>


        </div>
    </div>
</section>

</template>
