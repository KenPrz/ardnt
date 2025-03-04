<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const toast = useToast();
defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const user = usePage().props.auth.user;

const form = useForm({
  first_name: user.first_name,
  last_name: user.last_name,
  email: user.email,
  handle: user.handle,
  website: user.website,
  twitter: user.twitter,
  instagram: user.instagram,
  facebook: user.facebook,
  linkedin: user.linkedin,
  medium: user.medium,
});
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>
      <p class="mt-1 text-sm text-gray-600">
        Update your account's profile information and email address.
      </p>
    </header>

    <form
      @submit.prevent="
        form.patch(route('profile.update'), {
          preserveScroll: true,
          onSuccess: () => {
            toast.success('Profile updated successfully.');
          },
        })
      "
      class="mt-6 space-y-6"
    >
      <div class="flex w-full space-x-2">
        <div class="w-1/2">
          <InputLabel for="first_name" value="First Name" />
          <TextInput
            id="first_name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.first_name"
            required
            autofocus
            autocomplete="given-name"
          />
          <InputError class="mt-2" :message="form.errors.first_name" />
        </div>
        <div class="w-1/2">
          <InputLabel for="last_name" value="Last Name" />
          <TextInput
            id="last_name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.last_name"
            required
            autocomplete="family-name"
          />
          <InputError class="mt-2" :message="form.errors.last_name" />
        </div>
      </div>

      <div>
        <InputLabel for="email" value="Email" />
        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autocomplete="username"
        />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div>
        <InputLabel for="handle" value="Username" />
        <TextInput
          id="handle"
          type="text"
          class="mt-1 block w-full"
          v-model="form.handle"
        />
        <InputError class="mt-2" :message="form.errors.handle" />
      </div>

      <div v-if="mustVerifyEmail && user.email_verified_at === null">
        <p class="mt-2 text-sm text-gray-800">
          Your email address is unverified.
          <Link
            :href="route('verification.send')"
            method="post"
            as="button"
            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          >
            Click here to re-send the verification email.
          </Link>
        </p>

        <div
          v-show="status === 'verification-link-sent'"
          class="mt-2 text-sm font-medium text-green-600"
        >
          A new verification link has been sent to your email address.
        </div>
      </div>

      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
            Saved.
          </p>
        </Transition>
      </div>
    </form>
  </section>
</template>
