<script setup>
import { SidebarInset } from '@/components/ui/sidebar';
import {computed} from "vue";

const props = defineProps({
    variant: {
        type: String,
        default: 'sidebar',
        validator: (value) => ['header', 'sidebar'].includes(value)
    },
    class: {
        type: [String, Object, Array],
        default: ''
    }
})

const classes = computed(() => {
    const baseClasses = {
        header: 'bg-background border-b',
        sidebar: 'bg-muted/40 border-r'
    };

    return [
        baseClasses[props.variant],
        props.class
    ];
});
</script>

<template>
    <SidebarInset v-if="props.variant === 'sidebar'" :class="classes">
        <slot />
    </SidebarInset>
    <main v-else class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl" :class="classes">
        <slot />
    </main>
</template>
