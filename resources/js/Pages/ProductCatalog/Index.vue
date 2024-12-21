<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import { defineProps, reactive, ref, watch } from "vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import PageHeader from "@/Components/PageHeader.vue";
import ProductCatalogSubNav from "@/Pages/ProductCatalog/ProductCatalogSubNav.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchFilter from "@/Components/SearchFilter.vue";
import {Inertia} from "@inertiajs/inertia";
import CreateButtonLink from "@/Components/Buttons/CreateButtonLink.vue";
import EditButtonLink from "@/Components/Buttons/EditButtonLink.vue";
import DeleteButtonLink from "@/Components/Buttons/DeleteButtonLink.vue";
import FlashMessage from '@/Components/FlashMessage.vue';


const props = defineProps({
  products: Object,
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
    Inertia.get('/productCatalog',{ search: value },
    {preserveState: true}
    )
});


const page = usePage();

const authority = page.props.value.autorization;



</script>

<template>
  <Head title="Product Catalog" />

  <BreezeAuthenticatedLayout>

    <template #header>
      <PageHeader label="Product Catalog ( Product List )" />
    </template>

    <ProductCatalogSubNav />

    <div class="pb-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">

                 <div :class="{
                  'flex items-center justify-between mb-6': authority.ADD_PRODUCT,
                  'flex items-end justify-end mb-6': !authority.ADD_PRODUCT
                }">


                      <CreateButtonLink v-show="authority.ADD_PRODUCT" :href="route('ProductCatalog.createProduct')">
                        <div class="flex items-center gap-2">
                          <i class="fa-solid fa-plus"></i> <span>Add Product</span>
                        </div>
                      </CreateButtonLink>

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
                    <th scope="col" class="px-6 py-3">Asset id</th>
                    <th scope="col" class="px-6 py-3">Asset Category</th>
                    <th scope="col" class="px-6 py-3">Asset Name</th>
                    <th scope="col" class="px-6 py-3">Asset Subtype</th>
                    <th scope="col" class="px-6 py-3">Product Category</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th v-show="authority.EDIT_PRODUCT" scope="col" class="px-6 py-3">Edit</th>
                    <th v-show="authority.DELETE_PRODUCT" scope="col" class="px-6 py-3">Delete</th>
                  </tr>
                </thead>
                <tbody>
                    <!-- Check if products.data array is empty -->
        <template v-if="products.data && products.data.length > 0">
          <!-- Loop through products.data array -->
          <tr v-for="product in products.data" :key="product.INDEX_ID" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <!-- Table data -->
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ product.ASSET_ID }}</th>
            <td class="px-6 py-4">{{ product.CATEGORY_NAME }}</td>
            <td class="px-6 py-4">{{ product.ASSET_NAME }}</td>
            <td class="px-6 py-4">{{ product.ASSET_SUB_TYPE }}</td>
            <td class="px-6 py-4">{{ product.PRODUCT_CATEGORY }}</td>
            <td class="px-6 py-4">{{ product.STATUS }}</td>
            <td class="px-6 py-4" v-show="authority.EDIT_PRODUCT" >
              <EditButtonLink :href="route('ProductCatalog.editProduct',{ assetId: product.ASSET_ID })">
                <i class="fas fa-edit"></i>
              </EditButtonLink>
            </td>
            <td class="px-6 py-4" v-show="authority.DELETE_PRODUCT">
              <DeleteButtonLink :href="route('ProductCatalog.deleteProduct',{ assetId: product.ASSET_ID })">
                <i class="fas fa-trash-alt"></i>
              </DeleteButtonLink>
            </td>
          </tr>
        </template>
        <template v-else>
          <!-- Display a message when products.data is empty -->
          <tr>
            <td colspan="10" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
              No data available
            </td>
          </tr>
        </template>
                </tbody>
              </table>
            </div>
             <pagination class="mt-6" :links="products.links" />
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
