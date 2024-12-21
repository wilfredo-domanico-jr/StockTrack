<script setup>
import { Link } from '@inertiajs/inertia-vue3';
const props = defineProps(['href']);
</script>

<template>
    <Link :href="href" class="text-white bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:ring-teal-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-teal-600 dark:hover:bg-teal-700 focus:outline-none dark:focus:ring-teal-800">
        <slot />
      </Link>
</template>