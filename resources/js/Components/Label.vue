<script setup>
defineProps(["value", "important"]);
</script>

<template>
    <label class="block mb-2 text-sm font-bold text-gray-900">
        <span v-if="value"
            >{{ value }} <b class="text-red-800" v-if="important"> *</b></span
        >
        <span v-else><slot /></span>
    </label>
</template>
