<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import ProductCatalogSubNav from "@/Pages/ProductCatalog/ProductCatalogSubNav.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import { Head, useForm, usePage, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import FlashMessage from "@/Components/FlashMessage.vue";
import PageHeader from "@/Components/PageHeader.vue";

const form = useForm({
    category: "",
});

const submit = () => {
    form.post(route("ProductCatalog.storeAssetCategory"), {
        onFinish: () => (form.category = ""),
    });
};
</script>

<template>
    <Head title="Product Catalog" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <PageHeader
                label=" Product Catalog ( Asset Category Setting - Create )"
            />
        </template>

        <ProductCatalogSubNav />

        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <FlashMessage />
                        <form @submit.prevent="submit" class="max-w-sm mx-auto">
                            <div class="mb-5">
                                <BreezeLabel
                                    for="category"
                                    value="Asset Category"
                                />
                                <BreezeInput
                                    id="category"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.category"
                                    required
                                    autofocus
                                    autocomplete="category"
                                />
                            </div>

                            <div class="flex gap-4">
                                <SubmitButton>
                                    <i class="fa-solid fa-plus"></i> Create
                                </SubmitButton>

                                <Link
                                    href="/productCatalog/assetCategorySetting"
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
