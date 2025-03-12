<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Initialize the form
const form = useForm({
  question: '',
})

// Function to submit the form
const submitForm = () => {
    console.log(form.question);
    form.post(route('tell.get-from-gemini'), {
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
                Tell me Gemini
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

                                <button class="btn btn-primary mt-2" type="submit" :disabled="form.processing">
                                    Send
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
