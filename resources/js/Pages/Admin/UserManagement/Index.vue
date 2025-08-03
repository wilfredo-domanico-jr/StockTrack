<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import { defineProps, reactive, ref, watch } from "vue";
import AdminSubNav from "@/Pages/Admin/AdminSubNav.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchFilter from "@/Components/SearchFilter.vue";
import { Inertia } from "@inertiajs/inertia";
import CreateButtonLink from "@/Components/Buttons/CreateButtonLink.vue";
import ViewButtonLink from "@/Components/Buttons/ViewButtonLink.vue";
import DeleteButtonLink from "@/Components/Buttons/DeleteButtonLink.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import PageHeader from "@/Components/PageHeader.vue";

const props = defineProps({
    users: Object,
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
        "/admin/usermanagement/index",
        { search: value },
        { preserveState: true }
    );
});

const page = usePage();

const authority = page.props.value.autorization;
</script>

<template>
    <Head title="Admin - User Management" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <PageHeader label="Admin ( User Management - User List )" />
        </template>
        <AdminSubNav />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div
                            :class="{
                                'flex items-center justify-between mb-6':
                                    authority.ADD_USER,
                                'flex items-end justify-end mb-6':
                                    !authority.ADD_USER,
                            }"
                        >
                            <CreateButtonLink
                                v-show="authority.ADD_USER"
                                :href="route('Admin.UserManagement.create')"
                            >
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-plus"></i>
                                    <span> Add User</span>
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
                                <thead class="text-xs text-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            View
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            User id
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            First name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Last Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Status
                                        </th>
                                        <th
                                            scope="col"
                                            v-show="authority.DELETE_USER"
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
                                            props.users.data &&
                                            props.users.data.length > 0
                                        "
                                    >
                                        <!-- Loop through users.data array -->
                                        <tr
                                            v-for="user in props.users.data"
                                            :key="user.USER_ID"
                                            class="bg-white border-b"
                                        >
                                            <!-- Table data -->
                                            <td class="px-6 py-4">
                                                <ViewButtonLink
                                                    :href="
                                                        route(
                                                            'Admin.UserManagement.show',
                                                            {
                                                                userID: user.USER_ID,
                                                            }
                                                        )
                                                    "
                                                >
                                                    <i class="fas fa-eye"></i>
                                                </ViewButtonLink>
                                            </td>
                                            <th
                                                scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                            >
                                                {{ user.USER_ID }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ user.FIRST_NAME }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ user.LAST_NAME }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ user.email }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ user.ACC_STATUS }}
                                            </td>

                                            <td
                                                class="px-6 py-4"
                                                v-show="authority.DELETE_USER"
                                            >
                                                <DeleteButtonLink
                                                    :href="
                                                        route(
                                                            'Admin.UserManagement.destroy',
                                                            {
                                                                userID: user.USER_ID,
                                                            }
                                                        )
                                                    "
                                                    class="opacity-50 pointer-events-none"
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
                                                colspan="8"
                                                class="px-6 py-4 text-center text-gray-500 dark:text-gray-400"
                                            >
                                                No data available
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        <pagination class="mt-6" :links="props.users.links" />
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
