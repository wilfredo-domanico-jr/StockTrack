<script setup>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import AdminSubNav from "@/Pages/Admin/AdminSubNav.vue";
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import { Head, useForm, usePage, Link } from "@inertiajs/inertia-vue3";
import FlashMessage from '@/Components/FlashMessage.vue';

const form = useForm({
    roleName: '',
});

const submit = () => {
    form.post(route('Admin.RoleManagement.store'), {
         onSuccess: () => {
            form.reset();
        } ,
    });
};

</script>

<template>
  <Head title="Admin - Role Management" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Admin ( Role Management - Create )
      </h2>
    </template>

    <AdminSubNav />

    <div class="pb-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">


            <form @submit.prevent="submit" class="max-w-sm mx-auto">


             <div class="mb-5">
                <Label value="Role Name" important="true" />
                <Input type="text" class="mt-1 block w-full" v-model="form.roleName" required autofocus />
            </div>


              <div class="flex gap-4">

                <SubmitButton>
                  <i class="fa-solid fa-plus"></i> Create
                </SubmitButton>

                 <Link
                  :href="route('Admin.RoleManagement.index')"
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
