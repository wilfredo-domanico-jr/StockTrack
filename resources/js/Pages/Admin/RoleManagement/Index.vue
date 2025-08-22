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
    roles: Object,
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
        "/admin/rolemanagement/index",
        { search: value },
        { preserveState: true }
    );
});

const page = usePage();

const authority = page.props.value.autorization;
</script>

<template>
    <Head title="Admin - Role Management" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <PageHeader label="Admin ( Role Management - Role List )" />
        </template>
        <AdminSubNav />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div
                            :class="{
                                'flex items-center justify-between mb-6':
                                    authority.ADD_ROLE,
                                'flex items-end justify-end mb-6':
                                    !authority.ADD_ROLE,
                            }"
                        >
                            <CreateButtonLink
                                v-show="authority.ADD_ROLE"
                                :href="route('Admin.RoleManagement.create')"
                            >
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-plus"></i>
                                    <span> Add Role</span>
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
                                <thead class="text-xs text-gray-700 uppercase">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Role
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Created By
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Updated by
                                        </th>
                                        <th
                                            v-show="
                                                authority.EDIT_ROLE ||
                                                authority.DELETE_ROLE
                                            "
                                            scope="col"
                                            colspan="2"
                                            class="px-6 py-3 whitespace-nowrap w-32"
                                        >
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template
                                        v-if="
                                            props.roles.data &&
                                            props.roles.data.length > 0
                                        "
                                    >
                                        <!-- Loop through users.data array -->
                                        <tr
                                            v-for="role in props.roles.data"
                                            :key="role.id"
                                            class="bg-white border-b"
                                        >
                                            <!-- Table data -->
                                            <th
                                                scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                            >
                                                {{ role.ROLE }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ role.CREATED_BY }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ role.UPDATED_BY }}
                                            </td>

                                            <td
                                                class="px-2 py-2 whitespace-nowrap w-16"
                                                v-show="authority.EDIT_ROLE"
                                            >
                                                <EditButtonLink
                                                    :href="
                                                        route(
                                                            'Admin.RoleManagement.show',
                                                            { roleID: role.id }
                                                        )
                                                    "
                                                    class="opacity-50 pointer-events-none"
                                                >
                                                    <i
                                                        class="fas fa-edit mr-2"
                                                    ></i>
                                                    <span>Edit</span>
                                                </EditButtonLink>
                                            </td>

                                            <td
                                                class="px-2 py-2 whitespace-nowrap w-16"
                                                v-show="authority.DELETE_ROLE"
                                            >
                                                <DeleteButtonLink
                                                    :href="
                                                        route(
                                                            'Admin.RoleManagement.destroy',
                                                            { roleID: role.id }
                                                        )
                                                    "
                                                    class="opacity-50 pointer-events-none"
                                                >
                                                    <i
                                                        class="fas fa-trash-alt mr-2"
                                                    ></i>
                                                    <span>Delete</span>
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
                        <pagination class="mt-6" :links="props.roles.links" />
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
