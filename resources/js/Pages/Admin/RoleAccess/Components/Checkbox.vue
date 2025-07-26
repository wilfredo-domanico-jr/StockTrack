<script setup>
import { ref, watch } from "vue";

// Define props for v-model (modelValue) and emit for updating it
const props = defineProps(["modelValue", "label"]);
const emit = defineEmits(["update:modelValue"]);

// Create a ref for the checkbox input
const input = ref(null);

// Watch for changes in modelValue to update the checkbox state
watch(
    () => props.modelValue,
    (newValue) => {
        if (input.value) {
            input.value.checked = newValue;
        }
    }
);

// Emit the updated value when the checkbox is clicked
const updateValue = (event) => {
    emit("update:modelValue", event.target.checked);
};
</script>

<template>
    <li class="w-full rounded-t-lg">
        <div class="flex items-center ps-3">
            <input
                ref="input"
                type="checkbox"
                :checked="modelValue"
                @change="updateValue"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
            />
            <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900">{{
                props.label
            }}</label>
        </div>
    </li>
</template>
