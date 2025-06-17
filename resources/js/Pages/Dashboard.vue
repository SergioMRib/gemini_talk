<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <Link :href="route('tell.index')" class="block btn btn-info m-5 flex">Ask about your stuff</Link>
                    <Link :href="route('gemini.create')" class="block btn btn-warning m-5 flex">Note down on gemini</Link>
                    <Link :href="route('files.create')" class="block btn btn-warning m-5 flex">Save a file</Link>
                    <Link :href="route('gemini.index')" class="block btn btn-error m-5 flex">Ask any question</Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
