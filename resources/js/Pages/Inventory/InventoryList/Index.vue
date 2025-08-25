<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { defineProps, reactive, ref, watch } from "vue";
import InventorySubNav from "@/Pages/Inventory/InventorySubNav.vue";
import Pagination from "@/Components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import ViewButtonLink from "@/Components/Buttons/ViewButtonLink.vue";
import CreateButtonLink from "@/Components/Buttons/CreateButtonLink.vue";
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
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-between mb-6">
                            <CreateButtonLink
                                :href="route('Inventory.InventoryList.create')"
                            >
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-plus"></i>
                                    <span> Add Inventory Item</span>
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
                            <table
                                class="w-full text-center text-sm rtl:text-right text-gray-500"
                            >
                                <thead class="text-xs text-gray-700 uppercase">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Product Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Product Category
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Serial No.
                                        </th>

                                        <th scope="col" class="px-6 py-3">
                                            Purchase Date
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
                                            class="bg-white border-b"
                                        >
                                            <th
                                                scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                            >
                                                {{ inventory.PRODUCT_NAME }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ inventory.CATEGORY_NAME }}
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ inventory.SERIAL_NO }}
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ inventory.PURCHASE_DATE }}
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
