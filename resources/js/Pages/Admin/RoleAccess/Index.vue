<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { defineProps, reactive, ref, watch } from "vue";
import AdminSubNav from "@/Pages/Admin/AdminSubNav.vue";
import SelectInput from "@/Components/Select.vue";
import { Inertia } from "@inertiajs/inertia";
import Label from '@/Components/Label.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import PageHeader from "@/Components/PageHeader.vue";


const props = defineProps({
  roles: Object,
  roleSelected: Object,
});


const form = reactive({
  roleID: '',
});

const roleID = ref(props.roleSelected.roleID);

watch(roleID, (newValue) => {
  if (newValue) {
    Inertia.get(`/admin/roleaccess/show/${newValue}`);
  }
});

</script>

<template>
    <Head title="Admin - Role Access" />

    <BreezeAuthenticatedLayout>
       

        <template #header>
            <PageHeader label="Admin ( Role Access )" />
        </template>
    <AdminSubNav />
        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                      <FlashMessage />

                             <div class="mb-5 max-w-sm">

                                <Label value="Role" important="true" />
                                <SelectInput v-model="roleID" required>
                                <option value="" selected disabled>Select Role</option>
                                <option v-for="role in roles" :key="role.id" :value="role.id">
                                    {{ role.ROLE }}
                                </option>
                                </SelectInput>

                             </div>




                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
