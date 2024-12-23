<script setup>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import ProductCatalogSubNav from "@/Pages/ProductCatalog/ProductCatalogSubNav.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import SelectInput from "@/Components/Select.vue";
import { Head, useForm, usePage, Link } from "@inertiajs/inertia-vue3";
import FlashMessage from '@/Components/FlashMessage.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import PageHeader from "@/Components/PageHeader.vue";


defineProps({
  categories: Array,
  suppliers: Array,
});

const subtypes = [
  { id: 1, SUBTYPE_NAME: "Computer Desktop PC" },
  { id: 2, SUBTYPE_NAME: "Laptop" },
  { id: 3, SUBTYPE_NAME: "POS Terminal" },
  { id: 4, SUBTYPE_NAME: "Server" },
  { id: 5, SUBTYPE_NAME: "Handy Terminal" },
  { id: 6, SUBTYPE_NAME: "Equipment Parts" },
  ];


const statusList = [
  { id: 1, STATUS: "In-Stock" },
  { id: 2, STATUS: "Out of Stock" },
  { id: 3, STATUS: "Allocated" },
  { id: 4, STATUS: "In-Use" },
  { id: 5, STATUS: "Disposed" },
  { id: 6, STATUS: "Obsolete" },
  ];

const productCategories = [
  { id: 1, PRODUCT_CATEGORY: "Hardware" },
  { id: 2, PRODUCT_CATEGORY: "Software" },
  { id: 3, PRODUCT_CATEGORY: "Consumables" },
  { id: 4, PRODUCT_CATEGORY: "Bundle" },
  ];


const form = useForm({
  assetName: "",
  assetSubType: "",
  productCategory: "",
  assetCategory: "",
  equipmentModel: "",
  manufacturer: "",
  color: "",
  weight: "",
  dimension: "",
  cost: "",
  warrantyTerms: "",
  usefulLife: "",
  assetCondition: "",
  status: "",
  vendor: "",
  description: "",
  image: "",
});


const submit = () => {
  form.post(route("ProductCatalog.storeProduct"), {
   onSuccess: () => {
    form.reset();
   } ,

  });
};
</script>

<template>
  <Head title="Product Catalog" />

  <AuthenticatedLayout>


    <template #header>
      <PageHeader label="Product Catalog ( Product List - Create )" />
    </template>


    <ProductCatalogSubNav />

    <div class="pb-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <BreezeValidationErrors class="mb-4" />



            <form @submit.prevent="submit" class="max-w-full mx-auto">

              <FlashMessage />

              <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                  <span class="font-medium">

                    Fields with asterisk (<b class="text-red-800"> * </b>) are required!

                  </span>
                </div>
              </div>
              <div class="grid grid-cols-3 gap-4">
                <div>
                  <div class="mb-5">
                    <Label value="Asset Name" important="true" />
                    <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.assetName"
                      required
                      autofocus
                    />
                  </div>

                  <div class="mb-5">
                    <Label value="Asset Category" important="true" />

                    <SelectInput v-model="form.assetCategory" required>
                      <option value="" selected disabled>Select Category</option>
                      <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.CATEGORY_NAME }}
                      </option>
                    </SelectInput>
                  </div>

                  <div class="mb-5">
                    <Label value="Color" />
                    <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.color"
                    />
                  </div>

                  <div class="mb-5">
                    <Label value="Cost" />
                    <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.cost"
                    />
                  </div>

                  <div class="mb-5">
                    <Label value="Asset Condition" important="true"  />
                    <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.assetCondition"
                      required
                    />
                  </div>
                </div>
                <div>
                  <div class="mb-5">
                    <Label value="Asset Subtype" important="true" />
                     <SelectInput v-model="form.assetSubType" required>
                      <option value="" selected disabled>Select Subtype</option>
                      <option v-for="subtype in subtypes" :key="subtype.id" :value="subtype.SUBTYPE_NAME">
                        {{ subtype.SUBTYPE_NAME }}
                      </option>
                    </SelectInput>
                  </div>

                  <div class="mb-5">
                    <Label value="Equipment Model" important="true" />
                    <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.equipmentModel"
                      required
                    />
                  </div>

                  <div class="mb-5">
                    <Label value="Weight" />
                    <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.weight"
                    />
                  </div>

                  <div class="mb-5">
                    <Label value="Warranty Terms" important="true" />
                    <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.warrantyTerms"
                      required
                    />
                  </div>
                  <div class="mb-5">
                    <Label for="category" value="Status" important="true" />
                    <SelectInput v-model="form.status" required>
                      <option value="" selected disabled>Select Status</option>
                      <option v-for="status in statusList" :key="status.id" :value="status.STATUS">
                        {{ status.STATUS }}
                      </option>
                    </SelectInput>
                  </div>
                </div>

                <div>
                  <div class="mb-5">
                    <Label for="category" value="Product Category" important="true" />
                    <SelectInput v-model="form.productCategory" required>
                      <option value="" selected disabled>Select Product Category</option>
                      <option v-for="productCategory in productCategories" :key="productCategory.id" :value="productCategory.PRODUCT_CATEGORY">
                        {{ productCategory.PRODUCT_CATEGORY }}
                      </option>
                    </SelectInput>
                  </div>

                  <div class="mb-5">
                    <Label value="Manufacturer" important="true" />
                    <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.manufacturer"
                      required
                    />
                  </div>

                  <div class="mb-5">
                    <Label value="Dimension('L''W'H) IN CBM" />
                    <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.dimension"
                    />
                  </div>

                  <div class="mb-5">
                    <Label value="Useful Life (Mos)" important="true" />
                    <Input
                      type="number"
                      min=0
                      class="mt-1 block w-full"
                      v-model="form.usefulLife"
                      required
                    />
                  </div>

                  <div class="mb-5">
                    <Label value="Vendor / Supplier" important="true" />
                    <SelectInput v-model="form.vendor" required>
                      <option value="" selected disabled>Select Supplier</option>
                      <option v-for="supplier in suppliers" :key="supplier.SUPPLIER_ID" :value="supplier.SUPPLIER_ID">
                        {{ supplier.SUPP_NAME }}
                      </option>
                    </SelectInput>
                  </div>
                </div>
              </div>

              <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2">
                  <div class="mb-5">
                    <Label value="Asset Description" />

                    <textarea v-model="form.description"
                    id="message" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50
                    rounded-lg border border-gray-300 focus:ring-blue-500
                    focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                    dark:focus:border-blue-500" placeholder="Enter Description...">
                    </textarea>
                  </div>
                </div>

                <div class="col-span-1">
                  <div class="mb-5">
                    <Label value="Upload Image" />

                       <input
                      class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                      aria-describedby="file_input_help"
                      id="file_input"
                      type="file"
    
                       @input="form.image = $event.target.files[0]"
                    />
                    <p
                      class="mt-1 text-sm text-gray-500 dark:text-gray-300"
                      id="file_input_help"
                    >
                      PNG, JPEG or JPG only (Must be below 5MB).
                    </p>
                  </div>
                </div>
              </div>

              <div class="flex gap-4">
                <SubmitButton> <i class="fa-solid fa-plus"></i> Create </SubmitButton>

                <Link
                  :href="route('ProductCatalog.index')"
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
  </AuthenticatedLayout>
</template>
