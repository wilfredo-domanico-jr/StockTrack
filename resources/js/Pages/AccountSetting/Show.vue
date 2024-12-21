<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { defineProps } from "vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import FlashMessage from '@/Components/FlashMessage.vue';
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import { ref, reactive, getCurrentInstance } from 'vue';
import { Inertia } from "@inertiajs/inertia";
import PageHeader from "@/Components/PageHeader.vue";

defineProps({
  userData: Object,
});

const instance = getCurrentInstance();
const userData = instance.props.userData;

let form = reactive({
  firstName: userData.FIRST_NAME,
  lastName: userData.LAST_NAME,
  email: userData.email,
  profilePicture: userData.PROFILE_PICTURE,
  new_profilePicture: null,
  accountStatus: userData.ACC_STATUS,
  location: (userData.location && userData.location.LOCATION) || 'N/A'
});

// Example usage

const submit = () => {
  Inertia.post(route("AccountSetting.update"), form, {
    onSuccess: () => {

    },
    onError: (error) => {
      console.error('Error submitting form:', error);
      // Handle errors if needed
    }
  });
};


</script>

<template>
  <Head title="Account Setting" />

  <BreezeAuthenticatedLayout>

    <template #header>
            <PageHeader label="Account Setting" />
        </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">

              <form @submit.prevent="submit" class="max-w-full mx-auto">

                  <input type="hidden" v-model="currentDateTime">

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
        <Label value="Profile Picture" />

        <template v-if="form.profilePicture">
          <img class="rounded-md w-full h-32"
              :src="`/images/userPhotos/${form.profilePicture}`"
              alt="Profile Picture">
        </template>
        <template v-else>
          <p>No profile picture available.</p>
        </template>
      </div>


 <div class="mb-5">
                    <Label value="Update Profile" />

                       <input
                      class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                      aria-describedby="file_input_help"
                      id="file_input"
                      type="file"
                       @input="form.new_profilePicture = $event.target.files[0]"
                    />
                    <p
                      class="mt-1 text-sm text-gray-500 dark:text-gray-300"
                      id="file_input_help"
                    >
                      PNG, JPEG or JPG only (Must be below 5MB).
                    </p>
                  </div>

                </div>


                <div>
                  <div class="mb-5">
                    <Label value="First Name" important="true" />
                    <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.firstName"
                      required
                      autofocus
                    />
                  </div>

                  <div class="mb-5">
                    <Label value="Last Name" important="true" />

                     <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.lastName"
                      required
                    />
                  </div>

                </div>

                <div>


                   <div class="mb-5">
                    <Label value="Account Status" />
                   <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.accountStatus"
                      readonly
                    />
                  </div>

                   <div class="mb-5">
                    <Label value="Location" />
                     <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.location"
                      readonly
                    />
                  </div>
                </div>


              </div>


              <div class="flex gap-4">
                <SubmitButton> <i class="fa-solid fa-edit"></i> Update </SubmitButton>
                  <Link
                  :href="route('AccountSetting.index')"
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
