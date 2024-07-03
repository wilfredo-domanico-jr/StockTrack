<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import AdminSubNav from "@/Pages/Admin/AdminSubNav.vue";
</script>

<template>
    <Head title="Admin" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Admin ( Role Access )
            </h2>
        </template>
    <AdminSubNav />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                                    <li class="me-2" role="presentation">
                                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="product-catalog-tab" data-tabs-target="#product-catalog" type="button" role="tab" aria-controls="product-catalog" aria-selected="false">Product Catalog</button>
                                    </li>
                                    <li class="me-2" role="presentation">
                                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="inventory-tab" data-tabs-target="#inventory" type="button" role="tab" aria-controls="inventory" aria-selected="false">Inventory</button>
                                    </li>
                                    <li role="presentation">
                                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="supplier-tab" data-tabs-target="#supplier" type="button" role="tab" aria-controls="supplier" aria-selected="false">Supplier</button>
                                    </li>
                                    <li role="presentation">
                                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="reports-tab" data-tabs-target="#reports" type="button" role="tab" aria-controls="reports" aria-selected="false">Reports</button>
                                    </li>
                                    <li role="presentation">
                                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="admin-tab" data-tabs-target="#admin" type="button" role="tab" aria-controls="admin" aria-selected="false">Admin</button>
                                    </li>
                                </ul>
                            </div>
                            <div id="default-tab-content">
                                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="product-catalog" role="tabpanel" aria-labelledby="product-catalog-tab">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                                </div>
                                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="inventory" role="tabpanel" aria-labelledby="inventory-tab">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Settings tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                                </div>
                                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="supplier" role="tabpanel" aria-labelledby="supplier-tab">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                                </div>

                                 <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                                </div>

                                 <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="admin" role="tabpanel" aria-labelledby="admin-tab">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
