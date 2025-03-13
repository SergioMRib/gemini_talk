<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    'logs': Array,
    'notes': Array
})

// Initialize the form
const form = useForm({
  question: '',
})

// Function to submit the form
const submitForm = () => {
    console.log(form.question);

    form.question = form.question.trim();
    if(form.question.length === 0){
        form.errors.question = "Invalid submission";
        return
    }

    form.post(route('gemini.store'), {
        onSuccess: () => {
            console.log('Form submitted successfully')
            form.question = ""
        },
        onError: (errors) => {
            console.log(errors)
        },
    })
}
</script>

<template>
    <Head title="Ask Gemini" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
            Ask Gemini
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        Ask gemini what you want
                        <div class="mt-4">

                            <form @submit.prevent="submitForm">
                                <div>
                                    <textarea
                                    v-model="form.question"
                                    rows="5"
                                    class="input bg-white border-primary block mt-2 w-full max-w-2xl"
                                    type="text"
                                    id="question"
                                    :class="{ 'is-invalid': form.errors.name }"
                                    />
                                    <span v-if="form.errors.question" class="text-red-500">{{ form.errors.question }}</span>
                                </div>

                                <button class="btn btn-primary mt-2  " type="submit" :disabled="form.processing || (form.question.trim()).length === 0">
                                    Send
                                </button>
                            </form>

                        </div>
                        <div class="mt-4 border-2 border-neutral-900 rounded-t-lg overflow-x-auto">
                            <!--------   -->
                            <p class="text-sm py-3 font-semibold pl-4 pr-3 sm:pl-6 text-left">My notes</p>
                            <ul class="">
                                <li v-for="note in notes" :key="note.id" class=" py-2 font-semibold pl-4 pr-3 sm:pl-6 text-left">
                                    {{ note.title }} <br>
                                    <p class="font-light text-sm">{{ note.description }}</p>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-4 border-2 border-neutral-900 rounded-t-lg overflow-x-auto">
                            <p class="text-sm py-3 font-semibold pl-4 pr-3 sm:pl-6 text-left">Interaction logs</p>
                            <ul>
                                <li v-for="note in logs" :key="note.id" class=" py-2  pl-4 pr-3 sm:pl-6 text-left">
                                    <span class="text-sm">{{ note.from_human ? 'Human' : 'Gemini' }}</span>
                                    <p class="font-semibold">{{ note.log_entry }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
