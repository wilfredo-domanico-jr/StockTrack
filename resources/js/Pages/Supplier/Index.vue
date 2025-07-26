<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import { defineProps, reactive, ref, watch } from "vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchFilter from "@/Components/SearchFilter.vue";
import { Inertia } from "@inertiajs/inertia";
import CreateButtonLink from "@/Components/Buttons/CreateButtonLink.vue";
import EditButtonLink from "@/Components/Buttons/EditButtonLink.vue";
import DeleteButtonLink from "@/Components/Buttons/DeleteButtonLink.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import PageHeader from "@/Components/PageHeader.vue";

const props = defineProps({
    suppliers: Object,
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
    Inertia.get("/supplier", { search: value }, { preserveState: true });
});

const page = usePage();

const authority = page.props.value.autorization;
</script>

<template>
    <Head title="Supplier" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <PageHeader label="Supplier ( Supplier List )" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div
                            :class="{
                                'flex items-center justify-between mb-6':
                                    authority.ADD_SUPPLIER,
                                'flex items-end justify-end mb-6':
                                    !authority.ADD_SUPPLIER,
                            }"
                        >
                            <CreateButtonLink
                                v-show="authority.ADD_SUPPLIER"
                                :href="route('Supplier.create')"
                            >
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-plus"></i>
                                    <span> Add Supplier</span>
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
                                class="w-full text-sm text-center rtl:text-right text-gray-500"
                            >
                                <thead class="text-xs text-gray-700 uppercase">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Supplier id
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            supplier name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Supplier Type
                                        </th>
                                        <th
                                            scope="col"
                                            v-show="authority.EDIT_SUPPLIER"
                                            class="px-6 py-3"
                                        >
                                            Edit
                                        </th>
                                        <th
                                            scope="col"
                                            v-show="authority.DELETE_SUPPLIER"
                                            class="px-6 py-3"
                                        >
                                            Delete
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template
                                        v-if="
                                            suppliers.data &&
                                            suppliers.data.length > 0
                                        "
                                    >
                                        <!-- Loop through suppliers.data array -->
                                        <tr
                                            v-for="supplier in suppliers.data"
                                            :key="supplier.SUPPLIER_ID"
                                            class="bg-white border-b"
                                        >
                                            <th
                                                scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                            >
                                                {{ supplier.SUPPLIER_ID }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ supplier.SUPP_NAME }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ supplier.TYPE }}
                                            </td>

                                            <td
                                                class="px-6 py-4"
                                                v-show="authority.EDIT_SUPPLIER"
                                            >
                                                <EditButtonLink
                                                    :href="
                                                        route('Supplier.show', {
                                                            supplierID:
                                                                supplier.SUPPLIER_ID,
                                                        })
                                                    "
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </EditButtonLink>
                                            </td>
                                            <td
                                                class="px-6 py-4"
                                                v-show="
                                                    authority.DELETE_SUPPLIER
                                                "
                                            >
                                                <DeleteButtonLink
                                                    :href="
                                                        route(
                                                            'Supplier.destroy',
                                                            {
                                                                supplierID:
                                                                    supplier.SUPPLIER_ID,
                                                            }
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-trash-alt"
                                                    ></i>
                                                </DeleteButtonLink>
                                            </td>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <!-- Display a message when inventories.data is empty -->
                                        <tr>
                                            <td
                                                colspan="5"
                                                class="px-6 py-4 text-center text-gray-500 dark:text-gray-400"
                                            >
                                                No data available
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        <pagination class="mt-6" :links="suppliers.links" />
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
