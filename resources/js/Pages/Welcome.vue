<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 text-black dark:bg-black dark:text-white">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px] opacity-50"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <h1 class="text-4xl font-bold mb-6">My own gemini</h1>
        <div v-if="canLogin" class="z-10 flex flex-col items-center">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Dashboard
            </Link>
            <template v-else>
                <Link
                    :href="route('login')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Log in
                </Link>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="hover:pointer rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Register
                </Link>
            </template>
        </div>
    </div>
</template>
