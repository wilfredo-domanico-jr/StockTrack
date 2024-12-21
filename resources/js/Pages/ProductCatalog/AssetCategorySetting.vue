<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import ProductCatalogSubNav from "@/Pages/ProductCatalog/ProductCatalogSubNav.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import { defineProps, reactive, ref, watch } from "vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchFilter from "@/Components/SearchFilter.vue";
import { Inertia } from "@inertiajs/inertia";
import CreateButtonLink from "@/Components/Buttons/CreateButtonLink.vue";
import EditButtonLink from "@/Components/Buttons/EditButtonLink.vue";
import DeleteButtonLink from "@/Components/Buttons/DeleteButtonLink.vue";
import FlashMessage from '@/Components/FlashMessage.vue';
import PageHeader from "@/Components/PageHeader.vue";

const props = defineProps({
  categories: Object,
  filters: Object,
  addCategoryLink: String,
});

const form = reactive({
  search: "",
});

const reset = () => {
  form.search = "";
};

let search = ref(props.filters.search);

watch(search, (value) => {
  Inertia.get(
    "/productCatalog/assetCategorySetting",
    { search: value },
    { preserveState: true }
  );
});


const page = usePage();

const authority = page.props.value.autorization;


</script>

<template>
  <Head title="Product Catalog" />

  <BreezeAuthenticatedLayout>

    <template #header>
      <PageHeader label=" Product Catalog ( Asset Category Setting )" />
    </template>

    <ProductCatalogSubNav />

    <div class="pb-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div :class="{
                  'flex items-center justify-between mb-6': authority.ADD_ASSET_CATEGORY,
                  'flex items-end justify-end mb-6': !authority.ADD_ASSET_CATEGORY
                }">
              <CreateButtonLink v-show="authority.ADD_ASSET_CATEGORY" :href="route('ProductCatalog.createAssetCategory')">
                <div class="flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i>
                        <span> Add Category</span>
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
                class="w-full text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400"
              >
                <thead
                  class="text-xs text-gray-700 uppercase bg-teal-300 dark:bg-gray-700 dark:text-gray-400"
                >
                  <tr>
                    <th scope="col" class="px-6 py-3">Category id</th>
                    <th scope="col" class="px-6 py-3">Category Name</th>
                    <th scope="col" v-show="authority.EDIT_ASSET_CATEGORY" class="px-6 py-3">Edit</th>
                    <th scope="col" v-show="authority.DELETE_ASSET_CATEGORY" class="px-6 py-3">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="categories.data && categories.data.length > 0">
                    <tr
                      v-for="category in categories.data"
                      :key="category.id"
                      class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    >
                      <th
                        scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                      >
                        {{ category.id }}
                      </th>
                      <td class="px-6 py-4">
                        {{ category.CATEGORY_NAME }}
                      </td>

                      <td class="px-6 py-4" v-show="authority.EDIT_ASSET_CATEGORY">

                       <EditButtonLink :href="route('ProductCatalog.editAssetCategory',{ categoryId: category.id })">
                            <i class="fas fa-edit"></i>
                        </EditButtonLink>

                      </td>

                      <td class="px-6 py-4" v-show="authority.DELETE_ASSET_CATEGORY">


                        <DeleteButtonLink :href="route('ProductCatalog.deleteAssetCategory',{ categoryId: category.id })">
                             <i class="fas fa-trash-alt"></i>
                        </DeleteButtonLink>


                      </td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr
                      class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    >
                      <td colspan="4" class="px-6 py-4">No Data Found</td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
            <pagination class="mt-6" :links="categories.links" />
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
