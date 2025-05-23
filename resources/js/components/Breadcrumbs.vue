<script setup>
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator
} from '@/components/ui/breadcrumb';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    breadcrumbs: {
        type: Array,
        required: true,
        validator: (items) => {
            return items.every(item =>
                typeof item === 'object' &&
                item !== null &&
                'title' in item &&
                typeof item.title === 'string' &&
                (!('href' in item) || typeof item.href === 'string')
            );
        }
    }
});

const isLastItem = (index) => index === props.breadcrumbs.length - 1;
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template v-for="(item, index) in breadcrumbs" :key="index">
                <BreadcrumbItem>
                    <template v-if="index === breadcrumbs.length - 1">
                        <BreadcrumbPage>{{ item.title }}</BreadcrumbPage>
                    </template>
                    <template v-else>
                        <BreadcrumbLink as-child>
                            <Link :href="item.href ?? '#'">{{ item.title }}</Link>
                        </BreadcrumbLink>
                    </template>
                </BreadcrumbItem>
                <BreadcrumbSeparator v-if="index !== breadcrumbs.length - 1" />
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>
