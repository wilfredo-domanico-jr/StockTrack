<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head,Link } from "@inertiajs/inertia-vue3";
import { defineProps } from "vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import SubmitButton from "@/Components/Buttons/SubmitButton.vue";
import { ref, reactive, getCurrentInstance } from "vue";
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
  accountStatus: userData.ACC_STATUS,
  location: (userData.location && userData.location.LOCATION) || "N/A",
});

</script>

<template>
  <Head title="Account Setting" />

  <BreezeAuthenticatedLayout>


    <template #header>
            <PageHeader label="Account Setting" />
        </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">

              <div class="px-2 py-4 flex justify-end">

                       <Link :href="route('AccountSetting.show')" class="py-2.5 px-5 me-2 mb-2
                        text-sm font-medium text-gray-900 focus:outline-none
                        bg-white rounded-lg border border-gray-200 hover:bg-gray-100
                        hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
                        dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                        dark:border-gray-600 dark:hover:text-white
                        dark:hover:bg-gray-700">

                          Edit Profile
                        <i class="fa-solid fa-pencil"></i>
                        </Link>



              </div>

          <div class="p-6 bg-white border-b border-gray-200">


                  <FlashMessage />

              <div class="grid grid-cols-3 gap-4">
                <div>
                  <div class="mb-5">
                    <Label value="Profile Picture" />

                    <template v-if="form.profilePicture">
                      <img
                        class="rounded-md w-full h-32"
                        :src="`/images/userPhotos/${form.profilePicture}`"
                        alt="Profile Picture"
                      />
                    </template>
                    <template v-else>
                      <p>No profile picture available.</p>
                    </template>
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
                      readonly
                    />
                  </div>

                  <div class="mb-5">
                    <Label value="Last Name" important="true" />

                    <Input
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.lastName"
                      required
                       readonly
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

          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
