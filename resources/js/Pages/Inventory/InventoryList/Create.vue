<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm, Link } from "@inertiajs/inertia-vue3";
import InventorySubNav from "@/Pages/Inventory/InventorySubNav.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import SelectInput from "@/Components/Select.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import PageHeader from "@/Components/PageHeader.vue";
defineProps({
    products: Array,
});

const form = useForm({
    productId: "",
    serialNo: "",
    purchaseDate: "",
});

const submit = () => {
    form.post(route("Inventory.InventoryList.store"), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Inventory List" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <PageHeader label="Inventory ( Inventory List - Create )" />
        </template>

        <InventorySubNav />

        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form
                            @submit.prevent="submit"
                            class="max-w-full mx-auto"
                        >
                            <FlashMessage />

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

                            <div class="grid grid-cols-3 gap-4">
                                <div class="mb-5">
                                    <Label
                                        value="Product Name"
                                        important="true"
                                    />
                                    <SelectInput
                                        class="mt-1 block w-full"
                                        v-model="form.productId"
                                        required
                                    >
                                        <option value="" selected disabled>
                                            Select Product
                                        </option>
                                        <option
                                            v-for="product in products"
                                            :key="product.PRODUCT_ID"
                                            :value="product.PRODUCT_ID"
                                        >
                                            {{ product.PRODUCT_NAME }}
                                        </option>
                                    </SelectInput>
                                </div>
                                <div class="mb-5">
                                    <Label
                                        value="Serial No."
                                        important="true"
                                    />
                                    <Input
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.serialNo"
                                        required
                                        autofocus
                                    />
                                </div>

                                <div class="mb-5">
                                    <Label
                                        value="Purchase Date"
                                        important="true"
                                    />
                                    <Input
                                        type="date"
                                        class="mt-1 block w-full"
                                        v-model="form.purchaseDate"
                                        required
                                        autofocus
                                    />
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <SubmitButton>
                                    <i class="fa-solid fa-plus"></i> Create
                                </SubmitButton>

                                <Link
                                    :href="
                                        route('Inventory.InventoryList.index')
                                    "
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
