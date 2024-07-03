<script setup>
defineProps(['value','important']);
</script>

<template>
    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        <span v-if="value">{{ value }} <b class="text-red-800" v-if="important"> *</b></span>
        <span v-else><slot /></span>
    </label>
</template>
