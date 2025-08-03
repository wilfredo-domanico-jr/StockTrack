<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm, Link } from "@inertiajs/inertia-vue3";
import AdminSubNav from "@/Pages/Admin/AdminSubNav.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import { getCurrentInstance } from "vue";
import PageHeader from "@/Components/PageHeader.vue";
defineProps({
    userData: Object,
});

const instance = getCurrentInstance();
const userData = instance.props.userData;
const form = useForm({
    firstName: userData.FIRST_NAME,
    lastName: userData.LAST_NAME,
    email: userData.email,
    profilePicture: userData.PROFILE_PICTURE,
    accountStatus: userData.ACC_STATUS,
    location: (userData.location && userData.location.LOCATION) || "N/A",
    role: (userData.role && userData.role.ROLE) || "N/A",
});
</script>

<template>
    <Head title="Admin - User Management" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <PageHeader label="Admin ( User Management - Edit User )" />
        </template>
        <AdminSubNav />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!--START -->

                        <div class="grid grid-cols-4 gap-4">
                            <div class="mb-5">
                                <Label value="First Name" />
                                <Input
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.firstName"
                                    readonly
                                />
                            </div>

                            <div class="mb-5">
                                <Label value="Last Name" />

                                <Input
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.lastName"
                                    readonly
                                />
                            </div>

                            <div class="mb-5">
                                <Label value="Email Address" />
                                <Input
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    readonly
                                />
                            </div>

                            <div class="mb-5">
                                <Label value="Account Status" />
                                <Input
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.accountStatus"
                                    readonly
                                />
                            </div>
                        </div>

                        <!---END -->

                        <div class="grid grid-cols-3 gap-4">
                            <div class="mb-5">
                                <Label value="Location" />
                                <Input
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.location"
                                    readonly
                                />
                            </div>

                            <div class="mb-5">
                                <Label value="Role" />
                                <Input
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.role"
                                    readonly
                                />
                            </div>

                            <div class="mb-5">
                                <Label value="Profile Picture" />
                                <div v-if="form.profilePicture">
                                    <img
                                        class="rounded-md w-full h-32"
                                        :src="`/images/userPhotos/${form.profilePicture}`"
                                        alt="Profile Picture"
                                    />
                                </div>

                                <div v-else>
                                    <p class="text-gray-500 italic">
                                        No profile picture available
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <Link
                                :href="route('Admin.UserManagement.index')"
                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                            >
                                <i class="fa-solid fa-arrow-left"></i>
                                Back</Link
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
