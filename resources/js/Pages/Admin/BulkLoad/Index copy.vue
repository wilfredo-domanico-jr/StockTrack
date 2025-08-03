<script setup>
import { ref, defineProps } from "vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AdminSubNav from "@/Pages/Admin/AdminSubNav.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import PageHeader from "@/Components/PageHeader.vue";

// Tabs Data

const props = defineProps({
    role: String,
});

const tabs = [
    {
        title: "User Bulkload",
        id: "user-bulkload-tab",
        dataTarget: "#user-bulkload",
        areaControls: "user-bulkload",
        icon: "fa-solid fa-users",
        name: "user",
    },
    {
        title: "Location Bulkload",
        id: "location-bulkload-tab",
        dataTarget: "#location-bulkload",
        areaControls: "location-bulkload",
        icon: "fa-solid fa-location-dot",
        name: "location",
    },
    {
        title: "Product Bulkload",
        id: "product-bulkload-tab",
        dataTarget: "#product-bulkload",
        areaControls: "product-bulkload",
        icon: "fa-solid fa-boxes-stacked",
        name: "product",
    },
    {
        title: "Inventory Bulkload",
        id: "inventory-bulkload-tab",
        dataTarget: "#inventory-bulkload",
        areaControls: "inventory-bulkload",
        icon: "fa-solid fa-warehouse",
        name: "inventory",
    },
    {
        title: "Supplier Bulkload",
        id: "supplier-bulkload-tab",
        dataTarget: "#supplier-bulkload",
        areaControls: "supplier-bulkload",
        icon: "fa-solid fa-truck-field",
        name: "supplier",
    },
];

// Tab Content Data
const tabContents = [
    {
        id: "user-bulkload",
        areaLabeledBy: "user-bulkload-tab",
        name: "user",
        exportLink: route("Admin.BulkLoad.ExportTemplate.userTemplate"),
        title: "USER BULKLOAD",
        icon: "fa-solid fa-users",
        importLink: route("Admin.BulkLoad.ImportTemplate.importUser"),
    },
    {
        id: "location-bulkload",
        areaLabeledBy: "location-bulkload-tab",
        name: "location",
        exportLink: route("Admin.BulkLoad.ExportTemplate.locationTemplate"),
        title: "LOCATION BULKLOAD",
        icon: "fa-solid fa-location-dot",
        importLink: route("Admin.BulkLoad.ImportTemplate.importLocation"),
    },
    {
        id: "product-bulkload",
        areaLabeledBy: "product-bulkload-tab",
        name: "product",
        exportLink: route("Admin.BulkLoad.ExportTemplate.productTemplate"),
        title: "PRODUCT BULKLOAD",
        icon: "fa-solid fa-boxes-stacked",
        importLink: route("Admin.BulkLoad.ImportTemplate.importProduct"),
    },
    {
        id: "inventory-bulkload",
        areaLabeledBy: "inventory-bulkload-tab",
        name: "inventory",
        exportLink: route("Admin.BulkLoad.ExportTemplate.inventoryTemplate"),
        title: "INVENTORY BULKLOAD",
        icon: "fa-solid fa-warehouse",
        importLink: route("Admin.BulkLoad.ImportTemplate.importInventory"),
    },
    {
        id: "supplier-bulkload",
        areaLabeledBy: "supplier-bulkload-tab",
        name: "supplier",
        exportLink: route("Admin.BulkLoad.ExportTemplate.supplierTemplate"),
        title: "SUPPLIER BULKLOAD",
        icon: "fa-solid fa-truck-field",
        importLink: route("Admin.BulkLoad.ImportTemplate.importSupplier"),
    },
];




// Active Tab State
const activeTab = ref("user");

// Tab Selection Function
function selectTab(tab) {
    activeTab.value = tab;
}

const form = useForm({
    submittedFile: "",
});

function submit(route) {
    form.post(route, {
        onSuccess: () => {
            // form.submittedFile = "";
        },
    });
}
</script>

<template>
    <Head title="Admin" />

    <AuthenticatedLayout>
        <template #header>
            <PageHeader label="Admin ( Bulk Load )" />
        </template>
        <AdminSubNav />
        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Tabs Navigation -->
                        <div class="mb-4 border-b border-gray-200">
                            <ul
                                class="flex flex-wrap -mb-px text-sm font-medium text-center"
                                role="tablist"
                            >
                                <li
                                    v-for="(tab, index) in tabs"
                                    :key="index"
                                    class="me-2"
                                >
                                    <span>{{ tab.name }}</span>
                                    <button
                                        @click="selectTab(tab.name)"
                                        :class="{
                                            'inline-block p-4 border-b-2 rounded-t-lg': true,
                                            'border-blue-600 text-blue-600':
                                                activeTab === tab.name,
                                            'hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300':
                                                activeTab !== tab.name,
                                        }"
                                        :id="tab.id"
                                        :data-tabs-target="tab.dataTarget"
                                        type="button"
                                        role="tab"
                                        :aria-controls="tab.areaControls"
                                        :aria-selected="activeTab === tab.name"
                                    >
                                        <i
                                            :class="`w-4 h-4 me-2 text-blue-600 ${tab.icon}`"
                                        ></i>
                                        {{ tab.title }}
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <FlashMessage />

                        <!-- Tab Content -->
                        <div id="default-tab-content">
                            <div
                                v-for="(tabContent, index) in tabContents"
                                :key="index"
                                class="flex justify-center"
                            >
                                <div
                                    v-show="activeTab === tabContent.name"
                                    class="p-4 rounded-lg bg-gray-50 w-1/2"
                                    :id="tabContent.id"
                                    role="tabpanel"
                                    :aria-labelledby="tabContent.areaLabeledBy"
                                >
                                    <h1
                                        class="text-blue-600 text-center mb-4 text-xl"
                                    >
                                        <i :class="tabContent.icon"></i>
                                        {{ tabContent.title }}
                                    </h1>

                                    <div class="flex gap-4 items-center">
                                        <label
                                            class="block mb-2 font-medium text-gray-900"
                                            >Upload file:</label
                                        >
                                        <a
                                            :href="tabContent.exportLink"
                                            class="block mb-2 font-medium text-blue-600 hover:underline"
                                            >Download Template</a
                                        >
                                    </div>

                                    <form
                                        @submit.prevent="
                                            submit(tabContent.importLink)
                                        "
                                    >
                                        <input
                                            @input="
                                                form.submittedFile =
                                                    $event.target.files[0]
                                            "
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none"
                                            accept=".xls, .xlsx"
                                            type="file"
                                        />
                                        <p
                                            class="mt-1 text-sm text-gray-500 dark:text-gray-300"
                                        >
                                            .xls, .xlsx only
                                        </p>

                                        <div class="flex justify-center mt-4">
                                            <SubmitButton>
                                                <i
                                                    class="fa-solid fa-upload"
                                                ></i>
                                                Import
                                            </SubmitButton>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
