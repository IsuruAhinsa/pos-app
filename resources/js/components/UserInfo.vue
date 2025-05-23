<script setup>
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import { computed } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
        validator: (user) => (
            typeof user === 'object' &&
            user !== null &&
            'name' in user &&
            typeof user.name === 'string' &&
            (!('avatar' in user) || typeof user.avatar === 'string') &&
            (!('email' in user) || typeof user.email === 'string')
        )
    },
    showEmail: {
        type: Boolean,
        default: false
    }
});

const { getInitials } = useInitials();

const showAvatar = computed(() => props.user?.avatar && props.user.avatar !== '');
</script>

<template>
    <Avatar class="h-8 w-8 overflow-hidden rounded-lg">
        <AvatarImage v-if="showAvatar" :src="user.avatar" :alt="user.name" />
        <AvatarFallback class="rounded-lg text-black dark:text-white">
            {{ getInitials(user.name) }}
        </AvatarFallback>
    </Avatar>

    <div class="grid flex-1 text-left text-sm leading-tight">
        <span class="truncate font-medium">{{ user.name }}</span>
        <span v-if="showEmail" class="truncate text-xs text-muted-foreground">{{ user.email }}</span>
    </div>
</template>
