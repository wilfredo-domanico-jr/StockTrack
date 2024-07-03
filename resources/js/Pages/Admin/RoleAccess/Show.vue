<script setup>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import AdminSubNav from "@/Pages/Admin/AdminSubNav.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import Checkbox from "@/Pages/Admin/RoleAccess/Components/Checkbox.vue";
import ListContainer from "@/Pages/Admin/RoleAccess/Components/ListContainer.vue";
import { Inertia } from "@inertiajs/inertia";
import { defineProps, reactive, ref, watch } from "vue";
import { getCurrentInstance } from "vue";
import SelectInput from "@/Components/Select.vue";
import FlashMessage from '@/Components/FlashMessage.vue';
import { Head, useForm, usePage, Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
  roleDetail: Object,
  listOfRoles: Object,
  roleSelected: Object,
  roleAccess: Object,
});

const instance = getCurrentInstance();
const roleData = instance.props.roleDetail;
const roleAccess = instance.props.roleAccess;

const roleID = ref(instance.props.roleSelected || "");



const submit = () => {
  form.put(route("Admin.RoleAccess.update", { roleID: instance.props.roleSelected }));
};

watch(roleID, (newValue) => {
  if (newValue) {
    Inertia.get(`/admin/roleaccess/show/${newValue}`);
  }
});

const form = useForm({
  productCatalog: roleAccess.PRODUCT_CATALOG === 1,
  addProduct: roleAccess.ADD_PRODUCT === 1,
  editProduct: roleAccess.EDIT_PRODUCT === 1,
  deleteProduct: roleAccess.DELETE_PRODUCT === 1,
  addAssetCategory: roleAccess.ADD_ASSET_CATEGORY === 1,
  editAssetCategory: roleAccess.EDIT_ASSET_CATEGORY === 1,
  deleteAssetCategory: roleAccess.DELETE_ASSET_CATEGORY === 1,
  inventory: roleAccess.INVENTORY === 1,
  createAssetTransfer: roleAccess.CREATE_ASSET_TRANSFER === 1,
  receiveAssetTransfer: roleAccess.RECEIVE_ASSET_TRANSFER === 1,
  supplier: roleAccess.SUPPLIER === 1,
  addSupplier: roleAccess.ADD_SUPPLIER === 1,
  editSupplier: roleAccess.EDIT_SUPPLIER === 1,
  deleteSupplier: roleAccess.DELETE_SUPPLIER === 1,
  admin: roleAccess.ADMIN === 1,
  addUser: roleAccess.ADD_USER === 1,
  deleteUser: roleAccess.DELETE_USER === 1,
  addLocation: roleAccess.ADD_LOCATION === 1,
  editLocation: roleAccess.EDIT_LOCATION === 1,
  deleteLocation: roleAccess.DELETE_LOCATION === 1,
  addRole: roleAccess.ADD_ROLE === 1,
  editRole: roleAccess.EDIT_ROLE === 1,
  deleteRole: roleAccess.DELETE_ROLE === 1,
  bulkloadUser: roleAccess.BULKLOAD_USER === 1,
  bulkloadInventory: roleAccess.BULKLOAD_INVENTORY === 1,
  bulkloadProduct: roleAccess.BULKLOAD_PRODUCT === 1,
  bulkloadSupplier: roleAccess.BULKLOAD_SUPPLIER === 1,
  bulkloadLocation: roleAccess.BULKLOAD_LOCATION === 1,
  manageRoleAccess: roleAccess.MANAGE_ROLE_ACCESS === 1,
});

</script>

<template>
  <Head title="Admin - Role Access" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Admin ( Role Access )
      </h2>
    </template>

    <AdminSubNav />

    <div class="pb-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <form @submit.prevent="submit" class="mx-auto">

              <div class="mb-5 max-w-sm">


                <Label value="Role" important="true" />
                <div class="flex gap-4">
                  <div>
                    <SelectInput v-model="roleID" required>
                      <option value="" selected disabled>Select Role</option>
                      <option
                        v-for="role in listOfRoles"
                        :key="role.id"
                        :value="role.id"
                      >
                        {{ role.ROLE }}
                      </option>
                    </SelectInput>
                  </div>

                  <div>
                    <SubmitButton>
                      <i class="fa-solid fa-edit"></i> Update
                    </SubmitButton>
                  </div>
                </div>
              </div>

              <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">
                Check Modules you want the selected role to access
              </h3>

              <div class="grid grid-cols-5 gap-4">
                <ul
                  class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
                  <li
                    class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600"
                  >
                    <div class="flex items-center ps-3">
                      <input
                        id="vue-checkbox"
                        type="checkbox"
                        checked
                        disabled
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                      />
                      <label
                        for="vue-checkbox"
                        class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >Home (Default)</label
                      >
                    </div>
                  </li>
                </ul>

                <ListContainer>
                  <Checkbox
                    v-model="form.productCatalog"
                    label="Product Catalog"
                  />
                  <Checkbox v-model="form.addProduct" label="Add Product" />
                  <Checkbox v-model="form.editProduct" label="Edit Product" />
                  <Checkbox
                    v-model="form.deleteProduct"
                    label="Delete Product"
                  />
                  <Checkbox
                    v-model="form.addAssetCategory"
                    label="Add Asset Category"
                  />
                  <Checkbox
                    v-model="form.editAssetCategory"
                    label="Edit Asset Category"
                  />
                  <Checkbox
                    v-model="form.deleteAssetCategory"
                    label="Delete Asset Category"
                  />
                </ListContainer>

                <ListContainer>
                  <Checkbox v-model="form.inventory" label="Inventory" />
                  <Checkbox
                    v-model="form.createAssetTransfer"
                    label="Create Asset Transfer"
                  />
                  <Checkbox
                    v-model="form.receiveAssetTransfer"
                    label="Receive Asset Transfer"
                  />
                </ListContainer>

                <ListContainer>
                  <Checkbox v-model="form.supplier" label="Supplier" />
                  <Checkbox v-model="form.addSupplier" label="Add Supplier" />
                  <Checkbox v-model="form.editSupplier" label="Edit Supplier" />
                  <Checkbox
                    v-model="form.deleteSupplier"
                    label="Delete Supplier"
                  />
                </ListContainer>

                <ListContainer>
                  <Checkbox v-model="form.admin" label="Admin" />
                  <Checkbox v-model="form.addUser" label="Add User" />
                  <Checkbox v-model="form.deleteUser" label="Delete User" />
                  <Checkbox v-model="form.addLocation" label="Add Location" />
                  <Checkbox v-model="form.editLocation" label="Edit Location" />
                  <Checkbox
                    v-model="form.deleteLocation"
                    label="Delete Location"
                  />
                  <Checkbox v-model="form.addRole" label="Add Role" />
                  <Checkbox v-model="form.editRole" label="Edit Role" />
                  <Checkbox v-model="form.deleteRole" label="Delete Role" />
                  <Checkbox v-model="form.bulkloadUser" label="Bulkload User" />
                  <Checkbox
                    v-model="form.bulkloadInventory"
                    label="Bulkload Inventory"
                  />
                  <Checkbox
                    v-model="form.bulkloadProduct"
                    label="Bulkload Product"
                  />
                  <Checkbox
                    v-model="form.bulkloadSupplier"
                    label="Bulkload Supplier"
                  />
                  <Checkbox
                    v-model="form.bulkloadLocation"
                    label="Bulkload Location"
                  />
                  <Checkbox
                    v-model="form.manageRoleAccess"
                    label="Manage Role Access"
                  />
                </ListContainer>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
