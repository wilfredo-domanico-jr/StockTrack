<script setup>
defineProps({
    label: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <h2 class="font-semibold text-xl text-teal-800 leading-tight">{{label}}</h2>
</template>
