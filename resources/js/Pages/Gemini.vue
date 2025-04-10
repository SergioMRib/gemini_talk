<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import MarkdownIt from 'markdown-it';

const props = defineProps({
    response: {
        type: String,
        default: null, // Set a default value if the prop is not passed
    },
    conversation: Array,
});

const md = MarkdownIt();

let parsedConversation = ref([]);

parsedConversation = props.conversation.map(item => ({
    ...item,
    parsedContent: md.render(item.message)
}));


// Initialize the form
const form = useForm({
  question: '',
})

// Function to submit the form
const submitForm = () => {
    console.log(form.question);
    form.post(route('gemini.send'), {
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
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Gemini
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        Let's ask gemini lots of questions
                        <div class="mt-4">

                            <form @submit.prevent="submitForm">
                                <div>
                                    <label for="question">Question</label>
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
                                    Send message
                                </button>
                            </form>

                        </div>
                        <div class="mt-4">
                            <p v-if="response">{{response}}</p>
                        </div>

                        <div>
                            <div  v-for="message in parsedConversation">{{ message.parsedContent }}</div>
                        </div>
                        <div>
                            <ul>
                                <li v-for="message in conversation"
                                    :key="message.id"
                                    class="text-sm my-1 p-1 flex "
                                    :class="{'bg-blue-500 justify-end text-white': message.is_ai }">
                                    <span class="w-4/5">
                                        {{message.id}} {{message.message}} - at: {{message.created_at}}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
