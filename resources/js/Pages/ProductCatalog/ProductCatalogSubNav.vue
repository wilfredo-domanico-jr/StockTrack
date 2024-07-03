<script setup>
import BreezeNavLink from "@/Components/NavLink.vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";

const page = usePage();

console.log("isPage:", page.props);

const isActive = computed(() => {
  return (
    route().current("ProductCatalog.createAssetCategory") ||
    route().current("ProductCatalog.assetCategorySetting")
  );
});

// Log the value of isActive to see if it's working correctly
// console.log('isActive:', isActive.value);
</script>

<template>
  <div class="pt-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="py-6">
        <div class="flex">
          <!-- Navigation Links -->
          <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <BreezeNavLink
              :href="route('ProductCatalog.index')"
              :active="route().current('ProductCatalog.index')"
            >
              Product List
            </BreezeNavLink>

            <BreezeNavLink
              :href="route('ProductCatalog.assetCategorySetting')"
              :active="isActive"
            >
              Asset Category Setting
            </BreezeNavLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
