<script setup>
import { Inertia } from "@inertiajs/inertia";
import Pagination from "@/Components/Pagination.vue";
import { defineProps, reactive, ref, watch } from "vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import FlashMessage from "@/Components/FlashMessage.vue";
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import InventorySubNav from "@/Pages/Inventory/InventorySubNav.vue";
import CreateButtonLink from "@/Components/Buttons/CreateButtonLink.vue";
import ViewButtonLink from "@/Components/Buttons/ViewButtonLink.vue";
import PageHeader from "@/Components/PageHeader.vue";

const props = defineProps({
    inventoryTransfers: Object,
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
    Inertia.get(
        "/inventory/asset-transfer",
        { search: value },
        { preserveState: true }
    );
});

const page = usePage();

const authority = page.props.value.autorization;
</script>

<template>
    <Head title="Inventory Transfer" />

    <AuthenticatedLayout>
        <template #header>
            <PageHeader label="Inventory ( Inventory Transfer )" />
        </template>

        <InventorySubNav />

        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div
                            :class="{
                                'flex items-center justify-between mb-6':
                                    authority.CREATE_INVENTORY_TRANSFER,
                                'flex items-end justify-end mb-6':
                                    !authority.CREATE_INVENTORY_TRANSFER,
                            }"
                        >
                            <div class="flex gap-4">
                                <CreateButtonLink
                                    v-show="authority.CREATE_INVENTORY_TRANSFER"
                                    :href="
                                        route(
                                            'Inventory.InventoryTransfer.create'
                                        )
                                    "
                                >
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>Create Inventory Transfer</span>
                                    </div>
                                </CreateButtonLink>

                                <CreateButtonLink
                                    v-show="authority.CREATE_INVENTORY_TRANSFER"
                                    :href="
                                        route(
                                            'Inventory.InventoryTransfer.history'
                                        )
                                    "
                                >
                                    <div class="flex items-center gap-2">
                                        <i
                                            class="fa-solid fa-clock-rotate-left"
                                        ></i>
                                        <span>View Transfer History</span>
                                    </div>
                                </CreateButtonLink>
                            </div>

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
                                class="text-center w-full text-sm rtl:text-right text-gray-500"
                            >
                                <thead class="text-xs text-gray-700 uppercase">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            View
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Inventory Transfer No.
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Transaction Date
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Transfered Location
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date Received
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Check if products.data array is empty -->
                                    <template
                                        v-if="
                                            inventoryTransfers.data &&
                                            inventoryTransfers.data.length > 0
                                        "
                                    >
                                        <!-- Loop through inventoryTransfers.data array -->
                                        <tr
                                            v-for="inventoryTransfer in inventoryTransfers.data"
                                            :key="inventoryTransfer.INDEX_ID"
                                            class="bg-white border-b"
                                        >
                                            <!-- Table data -->
                                            <th
                                                scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                            >
                                                <ViewButtonLink
                                                    :href="
                                                        route(
                                                            'Inventory.InventoryTransfer.show',
                                                            {
                                                                inventoryTransNo:
                                                                    inventoryTransfer.INVENTORY_TRANSFER_NO,
                                                            }
                                                        )
                                                    "
                                                >
                                                    <i class="fas fa-eye"></i>
                                                </ViewButtonLink>
                                            </th>
                                            <td class="px-6 py-4">
                                                {{
                                                    inventoryTransfer.INVENTORY_TRANSFER_NO
                                                }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{
                                                    inventoryTransfer.TRANSACTION_DATE
                                                }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{
                                                    inventoryTransfer.TRANSFERED_LOCATION_ID
                                                }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{
                                                    inventoryTransfer.DATE_RECEIVED ??
                                                    "NOT AVAILABLE"
                                                }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{
                                                    inventoryTransfer.TRANSFER_STATUS
                                                }}
                                            </td>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <!-- Display a message when inventoryTransfers.data is empty -->
                                        <tr>
                                            <td
                                                colspan="6"
                                                class="px-6 py-4 text-center text-gray-500"
                                            >
                                                No data available
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        <pagination
                            class="mt-6"
                            :links="inventoryTransfers.links"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
