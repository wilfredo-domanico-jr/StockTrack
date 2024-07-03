<script setup>

// import { defineProps,reactive, ref, watch } from "vue";
import { Head, Link } from '@inertiajs/inertia-vue3';
import { defineProps } from "vue";
import SearchFilter from "@/Components/SearchFilter.vue";
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import InventorySubNav from '@/Pages/Inventory/InventorySubNav.vue';
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";

defineProps({
  assetTransfer: Object
});


</script>

<template>
    <Head title="Asset Transfer" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inventory ( Asset Transfer )
            </h2>
        </template>

        <InventorySubNav />

        <div class="pb-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">


                <form @submit.prevent="submit" class="max-w-full mx-auto">

                        <FlashMessage />

                        <div class="grid grid-cols-4 gap-4 w-full">


                         <div class="mb-5">
                          <Label value="Asset Tranfer No." />
                            <Input
                                type="text"
                                class="mt-1 block w-full text-center"
                                v-model="assetTransfer.ASSET_TRANSFER_NO"
                                disabled
                              />
                        </div>

                         <div class="mb-5">
                          <Label value="Transfer Location" />
                            <Input
                                type="text"
                                class="mt-1 block w-full text-center"
                                v-model="assetTransfer.location.LOCATION"
                                disabled
                              />
                        </div>

                        <div class="mb-5">
                          <Label value="Quantity" />
                            <Input
                                type="text"
                                class="mt-1 block w-full text-center"
                                v-model="assetTransfer.asset_transfer_asset_details.length"
                                disabled
                              />
                        </div>


                        <div class="mb-5">
                          <Label value="Transfer Status" />
                            <Input
                                type="text"
                                class="mt-1 block w-full text-center"
                                v-model="assetTransfer.TRANSFER_STATUS"
                                disabled
                              />
                        </div>

                        </div>



                           <div class="relative overflow-x-auto mb-4">

                        <FlashMessage />

                        <table
                          class="text-center w-full text-sm rtl:text-right text-gray-500 mb-4"
                        >
                          <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 "
                          >
                            <tr>
                              <th scope="col" class="px-6 py-3">Serial No.</th>
                              <th scope="col" class="px-6 py-3">Asset Name</th>
                              <th scope="col" class="px-6 py-3">Asset Subtype</th>
                              <th scope="col" class="px-6 py-3">Asset Tag No.</th>
                              <th scope="col" class="px-6 py-3">Asset Condition</th>
                            </tr>
                          </thead>

                          <tbody v-for="item in assetTransfer.asset_transfer_asset_details" :key="item.index">

                            <tr class="bg-white">
                              <!-- Table data -->
                                <th  class="px-2" scope="row">

                                   <Input
                                  type="text"
                                  class="mt-1 block w-full text-center"
                                  v-model="item.SERIAL_NO"
                                  disabled
                                />


                                </th>

                              <td class="px-2">
                                  <Input
                                type="text"
                                class="mt-1 block w-full text-center"
                                v-model="item.inventory.product.ASSET_NAME"
                                disabled
                              />
                              </td>
                              <td class="px-2">
                                   <Input
                                type="text"
                                class="mt-1 block w-full text-center"
                                v-model="item.inventory.product.ASSET_SUB_TYPE"
                                disabled
                              />
                              </td>
                              <td class="px-2">
                                   <Input
                                type="text"
                                class="mt-1 block w-full text-center"
                                v-model="item.inventory.ASSET_TAG"
                                disabled
                              />
                              </td>
                              <td class="px-2">
                                  <Input
                                type="text"
                                class="mt-1 block w-full text-center"
                                v-model="item.inventory.STATUS"
                                disabled
                              />
                              </td>

                            </tr>
                          </tbody>
                        </table>
                      </div>

                        <div class="flex gap-4">
                          <Link
                            :href="route('Inventory.AssetTransfer.index')"
                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                          >
                            <i class="fa-solid fa-arrow-left"></i> Go Back</Link
                          >
                        </div>
            </form>

          </div>
        </div>
      </div>
    </div>
    </AuthenticatedLayout>
</template>
