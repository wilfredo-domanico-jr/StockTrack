<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { defineProps, reactive, ref, watch } from "vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import InventorySubNav from "@/Pages/Inventory/InventorySubNav.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchFilter from "@/Components/SearchFilter.vue";
import { Inertia } from "@inertiajs/inertia";
import ViewButtonLink from "@/Components/Buttons/ViewButtonLink.vue";
import PageHeader from "@/Components/PageHeader.vue";

const props = defineProps({
    inventories: Object,
    filters: Object,
});

const form = reactive({
    search: "",
});

const reset = () => {
    form.search = "";
};

let search = ref(props.filters.search);

watch(search, (value) => {
    Inertia.get("/inventory", { search: value }, { preserveState: true });
});
</script>

<template>
    <Head title="Inventory List" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <PageHeader label="Inventory ( Inventory List )" />
        </template>

        <InventorySubNav />

        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-end mb-6">
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Search...."
                                class="mr-4 w-full max-w-md relative px-6 py-3 rounded focus:shadow-outline"
                            />
                        </div>

                        <div class="relative overflow-x-auto">
                            <table
                                class="w-full text-center text-sm rtl:text-right text-gray-500 dark:text-gray-400"
                            >
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-teal-300 dark:bg-gray-700 dark:text-gray-400"
                                >
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            View
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Asset id
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Asset Category
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Product Category
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Asset Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Asset Tag
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Location
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Serial No.
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date Created
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template
                                        v-if="
                                            inventories.data &&
                                            inventories.data.length > 0
                                        "
                                    >
                                        <!-- Loop through inventories.data array -->
                                        <tr
                                            v-for="inventory in inventories.data"
                                            :key="inventory.id"
                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                        >
                                            <td class="px-6 py-4">
                                                <ViewButtonLink
                                                    :href="
                                                        route(
                                                            'Inventory.InventoryList.show',
                                                            {
                                                                inventoryID:
                                                                    inventory.INVENTORY_ID,
                                                            }
                                                        )
                                                    "
                                                >
                                                    <i class="fas fa-eye"></i>
                                                </ViewButtonLink>
                                            </td>
                                            <th
                                                scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                {{ inventory.ASSET_ID }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ inventory.CATEGORY_NAME }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ inventory.PRODUCT_CATEGORY }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ inventory.ASSET_NAME }}
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ inventory.ASSET_TAG }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ inventory.LOCATION }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ inventory.SERIAL_NO }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ inventory.DATE_CREATED }}
                                            </td>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <!-- Display a message when inventories.data is empty -->
                                        <tr>
                                            <td
                                                colspan="9"
                                                class="px-6 py-4 text-center text-gray-500 dark:text-gray-400"
                                            >
                                                No data available
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        <template
                            v-if="
                                inventories.data && inventories.data.length > 0
                            "
                        >
                            <pagination
                                class="mt-6"
                                :links="inventories.links"
                            />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
