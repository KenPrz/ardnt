<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome to ardnt" />
    <div class="min-h-screen flex flex-col justify-center items-center">
        <main class="max-w-6xl">
            <div class="flex flex-col items-center">
                <ApplicationLogo class="h-24 w-auto" />
                <div class="flex">
                    <nav class="mt-6 mr-6">
                        <div v-if="canLogin">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="font-semibold text-maroon-700 hover:text-maroon-900 focus:outline-none focus:underline"
                            >
                                Dashboard
                            </Link>
                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="font-semibold text-maroon-700 hover:text-maroon-900 focus:outline-none focus:underline"
                                >
                                    Log in
                                </Link>
                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="ml-4 font-semibold text-maroon-700 hover:text-maroon-900 focus:outline-none focus:underline"
                                >
                                    Register
                                </Link>
                            </template>
                        </div>
                    </nav>
                </div>
            </div>
        </main>
        <footer class="absolute bottom-0 w-full text-center p-4 text-maroon-700">
            <p>&copy; 2024 ardnt. All rights reserved.</p>
        </footer>
    </div>
</template>
