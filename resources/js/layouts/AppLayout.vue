<script setup>
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'
import { Toaster } from '@/components/ui/sonner'
import 'vue-sonner/style.css'

defineProps({
  breadcrumbs: {
    type: Array,
    default: () => []
  }
})
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Toaster class="pointer-events-auto" position="top-center" />
    <slot />
  </AppLayout>
</template>
