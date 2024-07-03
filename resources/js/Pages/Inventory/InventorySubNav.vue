<script setup>
import BreezeNavLink from "@/Components/NavLink.vue";
</script>

<template>
  <div class="pt-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="py-6">
        <div class="flex">
          <!-- Navigation Links -->
          <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <BreezeNavLink
              :href="route('Inventory.InventoryList.index')"
              :active="route().current('Inventory.InventoryList.*')"
            >
              Inventory List
            </BreezeNavLink>

            <BreezeNavLink
              :href="route('Inventory.Receive.index')"
              :active="route().current('Inventory.Receive.*')"
            >
              Receive
            </BreezeNavLink>

            <BreezeNavLink
              :href="route('Inventory.AssetTransfer.index')"
              :active="route().current('Inventory.AssetTransfer.*')"
            >
              Asset Transfer
            </BreezeNavLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
