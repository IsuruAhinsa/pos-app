<script setup>
import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';

const props = defineProps({
    title: {
        type: String,
        default: ''
    },
    description: {
        type: String,
        default: ''
    }
});
</script>

<template>
    <AuthLayout :title="title" :description="description">
        <slot />
    </AuthLayout>
</template>
