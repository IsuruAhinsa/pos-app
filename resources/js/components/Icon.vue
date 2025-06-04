<script setup>
import {cn} from '@/lib/utils';
import * as icons from 'lucide-vue-next';
import {computed} from 'vue';

const props = defineProps({
    name: {
        type: String,
        required: true
    },
    class: {
        type: String,
        default: ''
    },
    size: {
        type: [Number, String],
        default: 16
    },
    color: {
        type: String
    },
    strokeWidth: {
        type: [Number, String],
        default: 2
    }
});

const className = computed(() => cn('h-4 w-4', props.class));

const icon = computed(() => {
    const iconName = props.name.charAt(0).toUpperCase() + props.name.slice(1);
    return icons[iconName];
});
</script>

<template>
    <component :is="icon" :class="className" :size="size" :stroke-width="strokeWidth" :color="color" />
</template>
