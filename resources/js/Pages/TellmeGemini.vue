<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    geminiResponse: {
        type: String,
        required: false
    },
    total_token_count: Number
});
// Initialize the form
const form = useForm({
  question: '',
})

let responsesArray = ref([])

onMounted(() => {
    if(props.geminiResponse) {
        responsesArray.value.push(props.geminiResponse);
    }
});

// Function to submit the form
const submitForm = () => {
    console.log(form.question);
    form.question = form.question.trim();
    if(form.question.length === 0){
        form.errors.question = "Invalid submission";
        return
    }
    form.post(route('tell.get-from-gemini'), {
        preserveState: true,
        onSuccess: () => {
            responsesArray.value = [...responsesArray.value, props.geminiResponse];
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

                                <button class="btn btn-primary mt-2" type="submit" :disabled="form.processing || (form.question.trim()).length === 0">
                                    Send
                                </button>
                            </form>

                        </div>

                        <p v-show="total_token_count">{{ 'Total tokens: ' + total_token_count }}</p>
                        <ul>
                            <li v-for="response, index in responsesArray" :key="index">
                                {{ index }} - {{response}}
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
