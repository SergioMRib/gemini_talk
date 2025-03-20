<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex flex-col items-center justify-center min-h-screen bg-gray-50 text-black dark:bg-black dark:text-white"
    >

        <img
            id="background"
            class="absolute z-0 -left-20 top-0 max-w-[877px] opacity-50"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div
            class="mt-6 w-full z-10 overflow-hidden pssx-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
