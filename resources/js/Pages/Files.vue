<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    files: Array
});
// Initialize the form
const form = useForm({
  file: '',
})

// Function to submit the form
const submitForm = () => {
    console.log(form.file);
    form.post(route('files.store'), {
        onSuccess: () => {
            console.log('Form submitted successfully')
        },
        onError: (errors) => {
            console.log(errors)
        },
    })
}

</script>

<template>
    <Head title="Gemini" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl flex justify-between items-center font-semibold leading-tight text-gray-800"
            >
                Files
                <Link :href="route('files.see-all-files')" class="btn btn-primary mt-2" >
                    See all bucket files
                </Link>
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        Upload a file
                        <div class="mt-4">
                            <form @submit.prevent="submitForm">
                                <div>
                                    <label for="file">File</label>
                                    <input
                                        @change="form.file = $event.target.files[0]"
                                    class="block mb-4 w-full max-w-2xl"
                                    type="file"
                                    id="file"
                                    :class="{ 'is-invalid': form.errors.file }"
                                    />
                                    <span v-if="form.errors.file" class="text-red-500">{{ form.errors.file }}</span>
                                </div>

                                <button class="btn btn-primary mt-2" type="submit" :disabled="form.processing">
                                    Store file
                                </button>
                            </form>

                        </div>
                        <div class="mt-4 border-2 border-neutral-900 rounded-t-lg overflow-x-auto">
                            <p class="text-sm py-3 font-semibold pl-4 pr-3 sm:pl-6 text-left">File list ({{files.length}})</p>
                            <ul>
                                <li v-for="note in files" :key="note.id" class=" py-2  pl-4 pr-3 sm:pl-6 text-left">
                                    <span class="font-semibold">{{note.name}}</span>
                                    <p class="text-sm">{{ note.summary }}</p>
                                    <p class="text-sm">{{ note.url }}</p>
                                    <p class="text-xs italic">{{ note.created_at }}</p>
                                    <a :href="note.download_url" class="text-xs italic">Download</a>
                                    <Link :href="route('files.destroy', { file: note.id })" method="delete" class="text-xs italic">Destroy</Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
