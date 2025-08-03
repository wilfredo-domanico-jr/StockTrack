<script setup>
import BreezeNavLink from "@/Components/NavLink.vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";

const page = usePage();
</script>

<template>
    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex">
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <BreezeNavLink
                            :href="route('Admin.UserManagement.index')"
                            :active="route().current('Admin.UserManagement.*')"
                        >
                            User Management
                        </BreezeNavLink>

                        <BreezeNavLink
                            :href="route('Admin.BulkLoad.index')"
                            :active="route().current('Admin.BulkLoad.*')"
                        >
                            Bulk Load
                        </BreezeNavLink>

                        <BreezeNavLink
                            :href="route('Admin.LocationManagement.index')"
                            :active="
                                route().current('Admin.LocationManagement.*')
                            "
                        >
                            Location Management
                        </BreezeNavLink>

                        <BreezeNavLink
                            :href="route('Admin.RoleManagement.index')"
                            :active="route().current('Admin.RoleManagement.*')"
                        >
                            Role Management
                        </BreezeNavLink>

                        <BreezeNavLink
                            :href="route('Admin.RoleAccess.index')"
                            :active="route().current('Admin.RoleAccess.*')"
                        >
                            Role Access
                        </BreezeNavLink>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
