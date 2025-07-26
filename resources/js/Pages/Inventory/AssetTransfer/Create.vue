<script setup>
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { Head, useForm, Link, usePage } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import InventorySubNav from "@/Pages/Inventory/InventorySubNav.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import SelectInput from "@/Components/Select.vue";
import PageHeader from "@/Components/PageHeader.vue";

const token =
    "w4SK5hO3uZvA6Fi3Bj4nfI36-7JRyf6FGqYFVtZcK03rrU5pRt-DuullFo5l2nlo6ZlvTb_a07wOAvpeWaoHzi";

const page = usePage();

const userLocation = page.props.value.auth.user.LOCATION_ID;

const isDuplicateSerial = (serialNo, index) => {
    return form.serialNo.some(
        (item, i) => item.number === serialNo && i !== index
    );
};

const getInventory = (serialNo, index) => {
    // Check first if the serial number is already selected
    if (isDuplicateSerial(serialNo, index)) {
        Swal.fire({
            title: "Error!",
            text: "This serial number is already entered. Please enter a unique serial number.",
            icon: "error",
            confirmButtonText: "Okay",
        });

        form.serialNo[index].number = "";
        form.serialNo[index].assetName = "";
        form.serialNo[index].assetSubtype = "";
        form.serialNo[index].assetTag = "";
        form.serialNo[index].assetCondition = "";
        return;
    }

    axios
        .post(route("Axios.getInventoryItem", { serialNo, userLocation }))
        .then((response) => {
            // Assuming response.data contains the asset details.
            const asset = response.data;
            form.serialNo[index].number = asset.SERIAL_NO;
            form.serialNo[index].assetName = asset.product.ASSET_NAME;
            form.serialNo[index].assetSubtype = asset.product.ASSET_SUB_TYPE;
            form.serialNo[index].assetTag = asset.ASSET_TAG;
            form.serialNo[index].assetCondition = asset.STATUS;
        })
        .catch((error) => {
            if (error.response && error.response.status === 404) {
                console.log(error.response.data.message);
                Swal.fire({
                    title: "Error!",
                    text: error.response.data.message,
                    icon: "error",
                    confirmButtonText: "Okay",
                });

                form.serialNo[index].number = "";
                form.serialNo[index].assetName = "";
                form.serialNo[index].assetSubtype = "";
                form.serialNo[index].assetTag = "";
                form.serialNo[index].assetCondition = "";
            } else {
                console.error(error);
            }
        });
};

defineProps({
    locations: Object,
});

const form = useForm({
    transferTo: "",
    serialNo: [
        {
            number: "",
            assetName: "",
            assetSubtype: "",
            assetTag: "",
            assetCondition: "",
        },
    ],
});

const submit = () => {
    form.post(route("Inventory.AssetTransfer.store"), {
        onSuccess: () => {
            form.reset();
        },
    });
};

const totalRows = ref(1);

const updateTotalRow = (event) => {
    const value = event.target.valueAsNumber || 1; // Default to 0 if not a number
    totalRows.value = value < 1 ? 1 : value; // Ensure the value is at least 1
    // Adjust the form data structure accordingly
    if (form.serialNo.length < value) {
        while (form.serialNo.length < value) {
            form.serialNo.push({
                number: "",
                assetName: "",
                assetSubtype: "",
                assetTag: "",
                assetCondition: "",
            });
        }
    } else if (form.serialNo.length > value) {
        form.serialNo.length = value;
    }
};
</script>

<template>
    <Head title="Asset Transfer" />

    <AuthenticatedLayout>
        <template #header>
            <PageHeader label="Inventory ( Asset Transfer - Create )" />
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

                            <div class="grid grid-cols-2 gap-4 w-1/2">
                                <div class="mb-5">
                                    <Label
                                        value="Transfer Location"
                                        important="true"
                                    />
                                    <SelectInput
                                        v-model="form.transferTo"
                                        required
                                        class="w-1/2 text-center"
                                    >
                                        <option value="" selected disabled>
                                            Select Location
                                        </option>
                                        <option
                                            v-for="location in locations"
                                            :key="location.LOCATION_ID"
                                            :value="location.LOCATION_ID"
                                        >
                                            {{ location.LOCATION }}
                                        </option>
                                    </SelectInput>
                                </div>

                                <div class="mb-5">
                                    <Label value="Quantity" important="true" />
                                    <Input
                                        v-model="totalRows"
                                        @input="updateTotalRow"
                                        type="number"
                                        min="1"
                                        placeholder="Enter Quantity"
                                        class="mt-1 block w-1/2 text-center"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="relative overflow-x-auto mb-4">
                                <FlashMessage />

                                <table
                                    class="text-center w-full text-sm rtl:text-right text-gray-500 mb-4"
                                >
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50"
                                    >
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Serial No.
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Asset Name
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Asset Subtype
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Asset Tag No.
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Asset Condition
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        v-for="(row, index) in totalRows"
                                        :key="index"
                                    >
                                        <tr class="bg-white">
                                            <!-- Table data -->
                                            <th class="px-2" scope="row">
                                                <Input
                                                    type="text"
                                                    class="mt-1 block w-full text-center"
                                                    v-model="
                                                        form.serialNo[index]
                                                            .number
                                                    "
                                                    @change="
                                                        getInventory(
                                                            form.serialNo[index]
                                                                .number,
                                                            index
                                                        )
                                                    "
                                                    required
                                                    autofocus
                                                />
                                            </th>

                                            <td class="px-2">
                                                <Input
                                                    type="text"
                                                    class="mt-1 block w-full text-center"
                                                    v-model="
                                                        form.serialNo[index]
                                                            .assetName
                                                    "
                                                    disabled
                                                />
                                            </td>
                                            <td class="px-2">
                                                <Input
                                                    type="text"
                                                    class="mt-1 block w-full text-center"
                                                    v-model="
                                                        form.serialNo[index]
                                                            .assetSubtype
                                                    "
                                                    disabled
                                                />
                                            </td>
                                            <td class="px-2">
                                                <Input
                                                    type="text"
                                                    class="mt-1 block w-full text-center"
                                                    v-model="
                                                        form.serialNo[index]
                                                            .assetTag
                                                    "
                                                    disabled
                                                />
                                            </td>
                                            <td class="px-2">
                                                <Input
                                                    type="text"
                                                    class="mt-1 block w-full text-center"
                                                    v-model="
                                                        form.serialNo[index]
                                                            .assetCondition
                                                    "
                                                    disabled
                                                />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex gap-4">
                                <SubmitButton>
                                    <i
                                        class="fa-solid fa-arrow-up-from-bracket"
                                    ></i>
                                    Submit
                                </SubmitButton>

                                <Link
                                    :href="
                                        route('Inventory.AssetTransfer.index')
                                    "
                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                >
                                    <i class="fa-solid fa-ban"></i>Cancel
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
