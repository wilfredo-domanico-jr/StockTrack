<script setup>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import AdminSubNav from "@/Pages/Admin/AdminSubNav.vue";
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import { Inertia } from "@inertiajs/inertia";
import { defineProps, reactive, ref, watch } from "vue";
import { getCurrentInstance } from 'vue';
import SelectInput from "@/Components/Select.vue";


const props = defineProps({
  roleDetail: Object,
  listOfRoles: Object,
  roleSelected: Object,
});

const instance = getCurrentInstance();
const roleData = instance.props.roleDetail;

const roleID = ref(instance.props.roleSelected || '');

watch(roleID, (newValue) => {
  if (newValue) {
    Inertia.get(`/admin/roleaccess/show/${newValue}`);
  }
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

                            <SelectInput v-model="roleID" required>
                            <option value="" selected disabled>Select Role</option>
                            <option v-for="role in listOfRoles" :key="role.id" :value="role.id">
                              {{ role.ROLE }}
                            </option>
                          </SelectInput>
            </div>



          <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Check Modules you want the selected role to access</h3>
          <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                  <div class="flex items-center ps-3">
                      <input id="vue-checkbox-list" type="checkbox" checked disabled class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                      <label for="vue-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Home (Default)</label>
                  </div>
              </li>
              <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                  <div class="flex items-center ps-3 bg-red-400">
                      <input id="react-checkbox-list" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                      <label for="react-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Product Catalog</label>
                  </div>
              </li>
              <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                  <div class="flex items-center ps-3">
                      <input id="angular-checkbox-list" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                      <label for="angular-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Inventory</label>
                  </div>
              </li>
              <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                  <div class="flex items-center ps-3">
                      <input id="laravel-checkbox-list" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                      <label for="laravel-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Supplier</label>
                  </div>
              </li>


               <li class="w-full dark:border-gray-600">
                  <div class="flex items-center ps-3">
                      <input id="laravel-checkbox-list" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                      <label for="laravel-checkbox-list" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Admin</label>
                  </div>
              </li>
          </ul>


          






              <!-- <div class="flex gap-4">

                <SubmitButton>
                  <i class="fa-solid fa-edit"></i> Update
                </SubmitButton>

                 <Link
                  :href="route('Admin.RoleAccess.index')"
                  class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                >
                  <i class="fa-solid fa-ban"></i> Cancel</Link
                >
              </div> -->
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
