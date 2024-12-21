<script setup>

import {Inertia} from "@inertiajs/inertia";
import NavLink from '@/Components/NavLink.vue';
import Pagination from "@/Components/Pagination.vue";
import { defineProps,reactive, ref, watch } from "vue";
import { Head, usePage, Link } from '@inertiajs/inertia-vue3';
import SearchFilter from "@/Components/SearchFilter.vue";
import FlashMessage from '@/Components/FlashMessage.vue';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import InventorySubNav from '@/Pages/Inventory/InventorySubNav.vue';
import CreateButtonLink from "@/Components/Buttons/CreateButtonLink.vue";
import ViewButtonLink from "@/Components/Buttons/ViewButtonLink.vue";
import PageHeader from "@/Components/PageHeader.vue";

const props = defineProps({
  assetTransfers: Object,
  filters: Object,
});


 const form = reactive({
  search: '',
});


const reset = () => {
  form.search = '';
};



let search = ref(props.filters.search);

watch(search, value =>{
    Inertia.get('/inventory/asset-transfer/history',{ search: value },
    {preserveState: true}
    )
});

const page = usePage();

const authority = page.props.value.autorization;


</script>

<template>
    <Head title="Asset Transfer" />

    <AuthenticatedLayout>
      

              
      <template #header>
            <PageHeader label="Inventory ( Asset Transfer - History )" />
        </template>


        <InventorySubNav />

        <div class="pb-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">


             <div class="flex items-center justify-between mb-6">

                       <Link :href="route('Inventory.AssetTransfer.index')" class="py-2.5 px-5 me-2 mb-2
                        text-sm font-medium text-gray-900 focus:outline-none
                        bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                        hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                        dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                        dark:border-gray-600 dark:hover:text-white
                        dark:hover:bg-gray-700">

                          <i class="fa-solid fa-arrow-left"></i> <span> Go Back</span>

                        </Link>

                          <input
                        v-model="search"
                        type="text"
                        placeholder="Search...."
                        class="mr-4 w-full max-w-md relative px-6 py-3 rounded focus:shadow-outline"
                      />

             </div>

            <div class="relative overflow-x-auto">

              <FlashMessage />

              <table
                class="text-center w-full text-sm rtl:text-right text-gray-500 dark:text-gray-400"
              >
                <thead
                  class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                  <tr>
                    <th scope="col" class="px-6 py-3">View</th>
                    <th scope="col" class="px-6 py-3">Asset Transfer No.</th>
                    <th scope="col" class="px-6 py-3">Transaction Date</th>
                    <th scope="col" class="px-6 py-3">Transfered Location</th>
                    <th scope="col" class="px-6 py-3">Date Received</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                  </tr>
                </thead>
                <tbody>
                    <!-- Check if products.data array is empty -->
        <template v-if="assetTransfers.data && assetTransfers.data.length > 0">
          <!-- Loop through assetTransfers.data array -->
          <tr v-for="assetTransfer in assetTransfers.data" :key="assetTransfer.INDEX_ID" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <!-- Table data -->
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                 <ViewButtonLink :href="route('Inventory.AssetTransfer.show',{ assetTransNo: assetTransfer.ASSET_TRANSFER_NO })">
                            <i class="fas fa-eye"></i>
                </ViewButtonLink>

            </th>
            <td class="px-6 py-4">{{ assetTransfer.ASSET_TRANSFER_NO }}</td>
            <td class="px-6 py-4">{{ assetTransfer.TRANSACTION_DATE }}</td>
            <td class="px-6 py-4">{{ assetTransfer.TRANSFERED_LOCATION_ID }}</td>
            <td class="px-6 py-4">{{ assetTransfer.DATE_RECEIVED ?? 'NOT AVAILABLE' }}</td>
            <td class="px-6 py-4">{{ assetTransfer.TRANSFER_STATUS }}</td>

          </tr>
        </template>
        <template v-else>
          <!-- Display a message when assetTransfers.data is empty -->
          <tr>
            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
              No data available
            </td>
          </tr>
        </template>
                </tbody>
              </table>
            </div>
             <pagination class="mt-6" :links="assetTransfers.links" />
          </div>
        </div>
      </div>
    </div>
    </AuthenticatedLayout>
</template>
