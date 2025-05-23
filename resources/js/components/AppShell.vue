<script setup>
import { SidebarProvider } from '@/components/ui/sidebar';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'sidebar',
        validator: (value) => ['header', 'sidebar'].includes(value)
    }
});

const page = usePage();
const isOpen = computed(() => page.props.sidebarOpen ?? true);
</script>

<template>
    <div v-if="variant === 'header'" class="flex min-h-screen w-full flex-col">
        <slot />
    </div>
    <SidebarProvider v-else :default-open="isOpen">
        <slot />
    </SidebarProvider>
</template>
