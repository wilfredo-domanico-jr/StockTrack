<script setup>
import { Link } from '@inertiajs/inertia-vue3';
const props = defineProps(['href']);
</script>

<template>
    <Link :href="href" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
        <slot />
      </Link>
</template>