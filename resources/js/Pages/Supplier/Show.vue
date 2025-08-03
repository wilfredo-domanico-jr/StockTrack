<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import SelectInput from "@/Components/Select.vue";
import { Head, useForm, usePage, Link } from "@inertiajs/inertia-vue3";
import { getCurrentInstance } from "vue";
import PageHeader from "@/Components/PageHeader.vue";

defineProps({
    supplierData: Object,
});

const suppliertTypes = [
    { id: 1, TYPE: "INTERNAL" },
    { id: 2, TYPE: "VENDOR" },
    { id: 3, TYPE: "PROVIDER-MAINTENANCE" },
    { id: 4, TYPE: "SERVICE PROVIDER-THIRD PARTY LOGISTICS" },
    { id: 5, TYPE: "SERVICE PROVIDER-WAREHOUSE" },
];

const instance = getCurrentInstance();
const supplierData = instance.props.supplierData;
const form = useForm({
    supplierName: supplierData.SUPP_NAME,
    supplierType: supplierData.TYPE,
    contactName: supplierData.CONTACT_NAME,
    email: supplierData.EMAIL,
    contactNumber: supplierData.CONTACT_NO,
    address: supplierData.ADDRESS,
});

const submit = () => {
    form.put(
        route("Supplier.update", { supplierID: supplierData.SUPPLIER_ID }),
        {
            onSuccess: () => {
                // form.reset();
            },
        }
    );
};
</script>

<template>
    <Head title="Supplier" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <PageHeader label="Supplier ( Supplier List - Show )" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <BreezeValidationErrors class="mb-4" />

                        <form
                            @submit.prevent="submit"
                            class="max-w-full mx-auto"
                        >
                            <div
                                class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50"
                                role="alert"
                            >
                                <svg
                                    class="flex-shrink-0 inline w-4 h-4 me-3"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
                                    />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium">
                                        Fields with asterisk (<b
                                            class="text-red-800"
                                        >
                                            * </b
                                        >) are required!
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="mb-5">
                                        <BreezeLabel
                                            value="Supplier Name"
                                            important="true"
                                        />
                                        <BreezeInput
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.supplierName"
                                            required
                                            autofocus
                                        />
                                    </div>

                                    <div class="mb-5">
                                        <BreezeLabel
                                            value="Contact Name"
                                            important="true"
                                        />
                                        <BreezeInput
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.contactName"
                                            required
                                        />
                                    </div>

                                    <div class="mb-5">
                                        <BreezeLabel
                                            value="Contact Number"
                                            important="true"
                                        />
                                        <BreezeInput
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.contactNumber"
                                            required
                                        />
                                    </div>
                                </div>

                                <div>
                                    <div class="mb-5">
                                        <BreezeLabel
                                            value="Supplier Type"
                                            important="true"
                                        />

                                        <SelectInput
                                            v-model="form.supplierType"
                                            required
                                        >
                                            <option value="" selected disabled>
                                                Select Supplier Type
                                            </option>
                                            <option
                                                v-for="suppliertType in suppliertTypes"
                                                :key="suppliertType.id"
                                                :value="suppliertType.TYPE"
                                            >
                                                {{ suppliertType.TYPE }}
                                            </option>
                                        </SelectInput>
                                    </div>

                                    <div class="mb-5">
                                        <BreezeLabel
                                            value="Email Adress"
                                            important="true"
                                        />

                                        <BreezeInput
                                            type="email"
                                            class="mt-1 block w-full"
                                            v-model="form.email"
                                            required
                                        />
                                    </div>

                                    <div class="mb-5">
                                        <BreezeLabel
                                            value="Address"
                                            important="true"
                                        />
                                        <BreezeInput
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.address"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <SubmitButton>
                                    <i class="fa-solid fa-edit"></i> Update
                                </SubmitButton>

                                <Link
                                    :href="route('Supplier.index')"
                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                >
                                    <i class="fa-solid fa-ban"></i> Cancel</Link
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
