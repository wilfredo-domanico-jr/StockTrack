<script setup>

import { Head, Link } from '@inertiajs/inertia-vue3';
import { defineProps } from "vue";
import SearchFilter from "@/Components/SearchFilter.vue";
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import InventorySubNav from '@/Pages/Inventory/InventorySubNav.vue';
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import { Inertia } from '@inertiajs/inertia';
import FlashMessage from '@/Components/FlashMessage.vue';
import PageHeader from "@/Components/PageHeader.vue";

defineProps({
  assetTransfer: Object
});

const accept = (assetTransNo) => {
  Inertia.post(route('Inventory.Receive.accept',{ assetTransNo: assetTransNo }));
};

const reject = (assetTransNo) => {
  Inertia.post(route('Inventory.Receive.reject',{ assetTransNo: assetTransNo }));
};


</script>

<template>
    <Head title="Receive" />

    <AuthenticatedLayout>
        

        <template #header>
            <PageHeader label="Inventory ( Receive - History - Show )" />
        </template>
        <InventorySubNav />

        <div class="pb-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">


                <form class="max-w-full mx-auto">

                        <FlashMessage />

                        <div class="grid grid-cols-4 gap-4 w-full">


                         <div class="mb-5">
                          <Label value="Asset Transfer No." />
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

                         <div class="flex mb-4">

                            <Link
                              :href="route('Inventory.Receive.history')"
                              class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                            >
                          <i class="fa-solid fa-arrow-left"></i> Go Back</Link>

                      </div>
                </form>

          </div>
        </div>
      </div>
    </div>
    </AuthenticatedLayout>
</template>
