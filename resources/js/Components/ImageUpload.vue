<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue']);

defineEmits(['update:modelValue']);

const input = ref(null);

</script>

<template>
    <input
                      class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                      aria-describedby="file_input_help"
                      id="file_input"
                      type="file"

                       @input="form.avatar = $event.target.files[0]"
                    />
                    <p
                      class="mt-1 text-sm text-gray-500"
                      id="file_input_help"
                    >
                      PNG, JPEG or JPG only (Must be below 5MB).
                    </p>
</template>
