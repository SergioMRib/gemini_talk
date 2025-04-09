<script setup>
import { ref, watch } from 'vue'
import { usePage, Link } from '@inertiajs/vue3';

const show = ref(true)
const page = usePage()

watch(() => page.props.flash, () => {
  show.value = true
}, { deep: true })
</script>

<template>
    <div class="toast  z-50" @click="show = false">
        <div v-if="($page.props.flash.error || Object.keys($page.props.errors).length > 0) && show" class="alert rounded-none alert-error">
            <span>{{ $page.props.flash.error }}</span>
        </div>
        <div v-if="$page.props.flash.info && show" class="alert rounded-none alert-info">
            <span>{{ $page.props.flash.info }}</span>
        </div>
        <div v-if="$page.props.flash.warning && show" class="alert rounded-none alert-warning">
            <span>{{ $page.props.flash.warning }}</span>
        </div>
        <div v-if="$page.props.flash.success && show" class="alert rounded-none alert-success">
            <span>{{ $page.props.flash.success }}</span>
        </div>
    </div>
</template>
