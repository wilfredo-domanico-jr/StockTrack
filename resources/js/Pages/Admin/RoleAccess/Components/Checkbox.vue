<script setup>
import { ref, watch } from 'vue';

// Define props for v-model (modelValue) and emit for updating it
const props = defineProps(['modelValue' ,'label']);
const emit = defineEmits(['update:modelValue']);

// Create a ref for the checkbox input
const input = ref(null);

// Watch for changes in modelValue to update the checkbox state
watch(() => props.modelValue, (newValue) => {
  if (input.value) {
    input.value.checked = newValue;
  }
});

// Emit the updated value when the checkbox is clicked
const updateValue = (event) => {
  emit('update:modelValue', event.target.checked);
};

</script>


<template>
   <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
              <div class="flex items-center ps-3">
                  <input ref="input"
                    type="checkbox"
                    :checked="modelValue"
                    @change="updateValue"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                  <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ props.label }}</label>
              </div>
          </li>
</template>