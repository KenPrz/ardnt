<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

const sections = ref([]);

onMounted(() => {
    sections.value = document.querySelectorAll('section');
    window.addEventListener('scroll', handleScroll);
});

const handleScroll = () => {
    const scrollPosition = window.scrollY;

    sections.value.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;

        if (scrollPosition >= sectionTop - window.innerHeight / 2 &&
            scrollPosition < sectionTop + sectionHeight - window.innerHeight / 2) {
            section.classList.add('active');
        } else {
            section.classList.remove('active');
        }
    });
};
</script>

<template>

    <Head title="Welcome to ardnt" />
    <div class="bg-gray-100 min-h-screen">
        <header class="fixed top-0 left-0 right-0 bg-white shadow-md z-50">
            <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
                <ApplicationLogo class="h-10 w-auto" />
                <div v-if="canLogin" class="space-x-4">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                        class="font-semibold text-maroon-700 hover:text-maroon-900 focus:outline-none focus:underline">
                    Dashboard
                    </Link>
                    <template v-else>
                        <Link :href="route('login')"
                            class="font-semibold text-maroon-700 hover:text-maroon-900 focus:outline-none focus:underline">
                        Log in
                        </Link>
                        <Link v-if="canRegister" :href="route('register')"
                            class="ml-4 font-semibold text-white bg-maroon-700 hover:bg-maroon-800 px-4 py-2 rounded-full transition duration-300">
                        Register
                        </Link>
                    </template>
                </div>
            </nav>
        </header>

        <main>
            <section
                class="h-screen flex flex-col justify-center items-center bg-gradient-to-br from-maroon-500 to-pink-500 text-white">
                <h1 class="text-6xl font-bold mb-4">Welcome to <span class="font-customSerif">Ardnt.</span><span
                        id="cursor" class="font-thin">|</span></h1>
                <p class="text-xl mb-8">Your personal microblogging platform</p>
                <a href="#about"
                    class="bg-white text-maroon-700 px-6 py-3 rounded-full font-semibold hover:bg-maroon-100 transition duration-300">
                    Learn More
                </a>
            </section>

            <section id="about" class="min-h-screen flex flex-col justify-center items-center bg-gray-50 py-20 px-32">
                <div class="container mx-auto px-10">
                    <h2 class="text-4xl font-bold mb-8 text-center">About <span
                            class="text-maroon-500 font-customSerif">Ardnt.</span></h2>
                    <div class="grid md:grid-cols-2 gap-12 items-center">
                        <div>
                            <p class="text-lg mb-4">
                                <span class="text-maroon-500">Ardnt.</span> is a powerful microblogging platform
                                designed for
                                individuals who want to share their thoughts, ideas, and experiences with the world.
                            </p>
                            <p class="text-lg">
                                With its intuitive interface and robust features, ardnt makes it easy to create and
                                manage your
                                personal blog, connect with like-minded individuals, and build your online presence.
                            </p>
                        </div>
                        <div class="bg-gray-200 h-64 rounded-lg shadow-lg">
                            
                        </div>
                    </div>
                </div>
            </section>

            <section
                class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-maroon-500 to-pink-500 py-20">
                <div class="container mx-auto px-6">
                    <h2 class="text-4xl font-bold mb-12 text-center text-white">Key Features</h2>
                    <div class="grid md:grid-cols-2 gap-8 mx-32">
                        <div
                            class="bg-white p-8 rounded-lg shadow-lg border-t-4 border-maroon-500 transform hover:scale-105 transition-transform duration-300">
                            <div class="flex items-center justify-center w-16 h-16 bg-maroon-100 rounded-full mb-6">
                                <svg class="w-8 h-8 text-maroon-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-4 text-maroon-800">Easy Posting</h3>
                            <p class="text-gray-600 mb-4">Create and publish posts with our intuitive, distraction-free rich text
                                editor.
                            </p>
                            <div class="border-t border-gray-200 pt-4">
                                <p class="text-sm text-gray-500 italic">"Writing is the painting of the voice." -
                                    Voltaire</p>
                            </div>
                        </div>

                        <div
                            class="bg-white p-8 rounded-lg shadow-lg border-t-4 border-maroon-500 transform hover:scale-105 transition-transform duration-300">
                            <div class="flex items-center justify-center w-16 h-16 bg-maroon-100 rounded-full mb-6">
                                <svg class="w-8 h-8 text-maroon-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-4 text-maroon-800">Social Integration</h3>
                            <p class="text-gray-600 mb-4">Connect with fellow writers and share your content across
                                various
                                platforms.</p>
                            <div class="border-t border-gray-200 pt-4">
                                <p class="text-sm text-gray-500 italic">"The pen is mightier than the sword if the sword
                                    is very
                                    short, and the pen is very sharp." - Terry Pratchett</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="min-h-screen flex flex-col justify-center items-center bg-maroon-700 text-white py-20">
                <div class="container mx-auto px-6 text-center">
                    <h2 class="text-4xl font-bold mb-8">Join <span class="font-customSerif">Ardnt.</span> Today</h2>
                    <p class="text-xl mb-12">Start your microblogging journey and share your voice with the world.</p>
                    <Link v-if="canRegister" :href="route('register')"
                        class="bg-white text-maroon-700 px-8 py-4 rounded-full font-semibold text-lg hover:bg-maroon-100 transition duration-300">
                    Get Started
                    </Link>
                </div>
            </section>
        </main>

        <footer class="bg-gray-800 text-white py-8">
            <div class="container mx-auto px-6 text-center">
                <p>&copy; {{ new Date().getFullYear() }} ardnt. All rights reserved.</p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
section {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s ease, transform 0.5s ease;
}

section.active {
    opacity: 1;
    transform: translateY(0);
}

section:first-child {
    opacity: 1;
    transform: translateY(0);
}

@keyframes blink {

    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: 0;
    }
}

#cursor {
    animation: blink 1s infinite;
}
</style>