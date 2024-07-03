<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const page = usePage();
const flash = computed(() => page.props.value.flash);
</script>

<template>
  <div>
    <div v-if="flash.success" class="p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
      <i class="fas fa-check"></i> {{ flash.success }}
    </div>

    <div v-if="flash.error" class="p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
      <i class="fas fa-times"></i> {{ flash.error }}
    </div>
  </div>
</template>
