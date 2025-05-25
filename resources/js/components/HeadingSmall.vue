<script setup>
const props = defineProps({
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: false,
        default: undefined
    }
});
</script>

<template>
    <header>
        <h3 class="mb-0.5 text-base font-medium">{{ title }}</h3>
        <p v-if="description" class="text-sm text-muted-foreground">
            {{ description }}
        </p>
    </header>
</template>
