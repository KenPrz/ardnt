<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdateSocialsForm from './Partials/UpdateSocialsForm.vue';
import { Head } from '@inertiajs/vue3';
defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});
</script>

<template>
  <Head title="Edit Profile" />
  <div class="py-10">
    <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
      <h1 class="text-xl font-semibold">Edit Profile</h1>
      <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
        <UpdateProfileInformationForm
          :must-verify-email="mustVerifyEmail"
          :status="status"
          class="max-w-xl"
        />
      </div>
      <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
        <UpdateSocialsForm
          :must-verify-email="mustVerifyEmail"
          :status="status"
          class="max-w-xl"
        />
      </div>
      <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
        <UpdatePasswordForm class="max-w-xl" />
      </div>
      <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
        <DeleteUserForm class="max-w-xl" />
      </div>
    </div>
  </div>
</template>
