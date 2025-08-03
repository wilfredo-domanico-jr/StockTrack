<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import { defineProps, reactive, ref, watch } from "vue";
import AdminSubNav from "@/Pages/Admin/AdminSubNav.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchFilter from "@/Components/SearchFilter.vue";
import { Inertia } from "@inertiajs/inertia";
import CreateButtonLink from "@/Components/Buttons/CreateButtonLink.vue";
import EditButtonLink from "@/Components/Buttons/EditButtonLink.vue";
import DeleteButtonLink from "@/Components/Buttons/DeleteButtonLink.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import PageHeader from "@/Components/PageHeader.vue";

const props = defineProps({
    locations: Object,
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
        "/admin/locationmanagement/index",
        { search: value },
        { preserveState: true }
    );
});

const page = usePage();

const authority = page.props.value.autorization;
</script>

<template>
    <Head title="Admin - Location Management" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <PageHeader label="Admin ( Location Management - Location List )" />
        </template>
        <AdminSubNav />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div
                            :class="{
                                'flex items-center justify-between mb-6':
                                    authority.ADD_LOCATION,
                                'flex items-end justify-end mb-6':
                                    !authority.ADD_LOCATION,
                            }"
                        >
                            <CreateButtonLink
                                v-show="authority.ADD_LOCATION"
                                :href="route('Admin.LocationManagement.create')"
                            >
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-plus"></i>
                                    <span> Add Location</span>
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
                                class="text-center w-full text-sm rtl:text-right text-gray-500"
                            >
                                <thead class="text-xs text-gray-700 uppercase">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Location id
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Location
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Updated by
                                        </th>
                                        <th
                                            v-show="authority.EDIT_LOCATION"
                                            scope="col"
                                            class="px-6 py-3"
                                        >
                                            Edit
                                        </th>
                                        <th
                                            v-show="authority.DELETE_LOCATION"
                                            scope="col"
                                            class="px-6 py-3"
                                        >
                                            Delete
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Check if users.data array is empty -->
                                    <template
                                        v-if="
                                            props.locations.data &&
                                            props.locations.data.length > 0
                                        "
                                    >
                                        <!-- Loop through users.data array -->
                                        <tr
                                            v-for="location in props.locations
                                                .data"
                                            :key="location.LOCATION_ID"
                                            class="bg-white border-b"
                                        >
                                            <!-- Table data -->
                                            <th
                                                scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                            >
                                                {{ location.LOCATION_ID }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ location.LOCATION }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ location.UPDATED_BY }}
                                            </td>

                                            <td
                                                class="px-6 py-4"
                                                v-show="authority.EDIT_LOCATION"
                                            >
                                                <EditButtonLink
                                                    :href="
                                                        route(
                                                            'Admin.LocationManagement.show',
                                                            {
                                                                locationID:
                                                                    location.LOCATION_ID,
                                                            }
                                                        )
                                                    "
                                                    :class="{
                                                        'opacity-50 pointer-events-none':
                                                            [
                                                                '000000',
                                                                '000001',
                                                                '000002',
                                                            ].includes(
                                                                location.LOCATION_ID
                                                            ),
                                                    }"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </EditButtonLink>
                                            </td>

                                            <td
                                                class="px-6 py-4"
                                                v-show="
                                                    authority.DELETE_LOCATION
                                                "
                                            >
                                                <DeleteButtonLink
                                                    :href="
                                                        route(
                                                            'Admin.LocationManagement.destroy',
                                                            {
                                                                locationID:
                                                                    location.LOCATION_ID,
                                                            }
                                                        )
                                                    "
                                                    :class="{
                                                        'opacity-50 pointer-events-none':
                                                            [
                                                                '000000',
                                                                '000001',
                                                                '000002',
                                                            ].includes(
                                                                location.LOCATION_ID
                                                            ),
                                                    }"
                                                >
                                                    <i
                                                        class="fas fa-trash-alt"
                                                    ></i>
                                                </DeleteButtonLink>
                                            </td>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <!-- Display a message when users.data is empty -->
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
                        <pagination
                            class="mt-6"
                            :links="props.locations.links"
                        />
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
