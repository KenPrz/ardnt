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
    website: user.website || '',
    twitter: user.twitter || '',
    instagram: user.instagram || '',
    facebook: user.facebook || '',
    linkedin: user.linkedin || '',
    medium: user.medium || '',
});

const updateSocials = () => {
    form.patch(route('profile.update.socials'), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Socials updated successfully.');
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Socials</h2>
            <p class="mt-1 text-sm text-gray-600">
                Update your social media handles.
            </p>
        </header>

        <form @submit.prevent="updateSocials" class="mt-6 space-y-6">
            <div>
                <InputLabel for="website" value="Website" />
                <TextInput
                    id="website"
                    type="url"
                    class="mt-1 block w-full"
                    v-model="form.website"
                />
                <InputError class="mt-2" :message="form.errors.website" />
            </div>

            <div>
                <InputLabel for="twitter" value="Twitter" />
                <TextInput
                    id="twitter"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.twitter"
                />
                <InputError class="mt-2" :message="form.errors.twitter" />
            </div>

            <div>
                <InputLabel for="instagram" value="Instagram" />
                <TextInput
                    id="instagram"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.instagram"
                />
                <InputError class="mt-2" :message="form.errors.instagram" />
            </div>

            <div>
                <InputLabel for="facebook" value="Facebook" />
                <TextInput
                    id="facebook"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.facebook"
                />
                <InputError class="mt-2" :message="form.errors.facebook" />
            </div>

            <div>
                <InputLabel for="linkedin" value="LinkedIn" />
                <TextInput
                    id="linkedin"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.linkedin"
                />
                <InputError class="mt-2" :message="form.errors.linkedin" />
            </div>

            <div>
                <InputLabel for="medium" value="Medium" />
                <TextInput
                    id="medium"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.medium"
                />
                <InputError class="mt-2" :message="form.errors.medium" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton 
                    @click="updateSocials"
                    :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>