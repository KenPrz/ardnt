<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    handle: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div class="flex flex-col md:flex-row w-full space-y-2 md:space-y-0 md:space-x-2">
                <div>
                    <InputLabel for="first_name" value="First Name" />

                    <TextInput
                        id="first_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.first_name"
                        required
                        autofocus
                        autocomplete="first_name"
                    />

                    <InputError class="mt-2" :message="form.errors.first_name" />
                </div>
                <div>
                    <InputLabel for="last_name" value="Last Name" />

                    <TextInput
                        id="last_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.last_name"
                        required
                        autofocus
                        autocomplete="last_name"
                    />

                    <InputError class="mt-2" :message="form.errors.last_name" />
                </div>
            </div>

            <div class="mt-4">
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
            <div class="mt-4">
                <InputLabel for="handle" value="Handle" />

                <TextInput
                    id="handle"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.handle"
                    required
                    autofocus
                    autocomplete="handle"
                />

                <InputError class="mt-2" :message="form.errors.handle" />
            </div>
            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
            <div class="flex justify-end py-2">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>
            </div>
            <div class="flex items-center justify-end">
                <button 
                    class="w-full text-center bg-maroon-500 hover:bg-maroon-600 transition-colors duration-200 text-white py-3 rounded-lg" 
                    :class="{ 'opacity-25 bg-maroon-400': form.processing }" 
                    :disabled="form.processing">
                    <i v-show="form.processing" class="animate-spin pi pi-spinner me-1" style="font-size: .9em;"></i>
                    <span v-if="form.processing">Processing</span>
                    <span v-else>Register</span>
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
