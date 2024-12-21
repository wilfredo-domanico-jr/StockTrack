<script setup>
import { defineProps, ref } from "vue";
import Label from "@/Components/Label.vue";
import { Head } from "@inertiajs/inertia-vue3";
import TextInput from "@/Components/Input.vue";
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import InventorySubNav from "@/Pages/Inventory/InventorySubNav.vue";
import PageHeader from "@/Components/PageHeader.vue";

const props = defineProps({
    inventoryData: Object,
});

const firstRow = ref([
    { label: "Inventory ID", content: props.inventoryData.INVENTORY_ID },
    { label: "Asset ID", content: props.inventoryData.ASSET_ID },
    { label: "Asset Name", content: props.inventoryData.product.ASSET_NAME },
    {
        label: "Asset Category",
        content: props.inventoryData.product.asset_category.CATEGORY_NAME,
    },
]);

const secondRow = ref([
    { label: "Location ID", content: props.inventoryData.LOCATION_ID },
    {
        label: "Purchase Order No.",
        content: props.inventoryData.PURCHASE_ORDER_NO,
    },
    { label: "Use Policy", content: props.inventoryData.USE_POLICY },
    { label: "Purchase Date", content: props.inventoryData.PURCHASE_DATE },
]);

const thirdRow = ref([
    { label: "Asset Tag", content: props.inventoryData.ASSET_TAG },
    { label: "Service Level", content: props.inventoryData.SERVICE_LEVEL },
    { label: "In Service Date", content: props.inventoryData.IN_SERVICE_DATE },
    { label: "STATUS", content: props.inventoryData.STATUS },
]);

const fourthRow = ref([
    { label: "Serial No.", content: props.inventoryData.SERIAL_NO },
    { label: "Barcode", content: props.inventoryData.BARCODE },
    {
        label: "Warranty Start Date",
        content: props.inventoryData.WARRANTY_START_DATE,
    },
    { label: "Warranty Expiry", content: props.inventoryData.WARRANTY_EXPIRY },
]);
</script>

<template>
    <Head title="Inventory List" />

    <AuthenticatedLayout>
        <template #header>
            <PageHeader label="Inventory ( Inventory List - View )" />
        </template>
        <InventorySubNav />

        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="max-w-full mx-auto">
                            <div class="grid grid-cols-4 gap-4 mb-4">
                                <div
                                    v-for="data1 in firstRow"
                                    :key="data1.index"
                                >
                                    <div class="mb-5">
                                        <Label :value="data1.label" />
                                        <TextInput
                                            type="text"
                                            class="mt-1 block w-full"
                                            :value="data1.content"
                                            disabled
                                        />
                                    </div>
                                </div>

                                <div
                                    v-for="data2 in secondRow"
                                    :key="data2.index"
                                >
                                    <div class="mb-5">
                                        <Label :value="data2.label" />
                                        <TextInput
                                            type="text"
                                            class="mt-1 block w-full"
                                            :value="data2.content"
                                            disabled
                                        />
                                    </div>
                                </div>

                                <div
                                    v-for="data3 in thirdRow"
                                    :key="data3.index"
                                >
                                    <div class="mb-5">
                                        <Label :value="data3.label" />
                                        <TextInput
                                            type="text"
                                            class="mt-1 block w-full"
                                            :value="data3.content"
                                            disabled
                                        />
                                    </div>
                                </div>

                                <div
                                    v-for="data4 in fourthRow"
                                    :key="data4.index"
                                >
                                    <div class="mb-5">
                                        <Label :value="data4.label" />
                                        <TextInput
                                            type="text"
                                            class="mt-1 block w-full"
                                            :value="data4.content"
                                            disabled
                                        />
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="text-center my-4">
                                <Label value="Product Image" />
                            </div>
                            <hr />

                            <div class="flex justify-center mt-4">
                                <template
                                    v-if="props.inventoryData.product.LOGO"
                                >
                                    <img
                                        class="rounded-md h-64 w-96"
                                        :src="`/images/productListPhotos/${props.inventoryData.product.LOGO}`"
                                        alt="Product Image"
                                    />
                                </template>
                                <template v-else>
                                    <p>No asset image available.</p>
                                </template>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
