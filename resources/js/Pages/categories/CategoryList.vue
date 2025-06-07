<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle
} from '@/components/ui/card';
import Datatable from '@/components/datatable/Datatable.vue';
import { columns, facetColumns } from './CategoryColumns.js';
import AddCategoryDialog from '@/Pages/categories/AddCategoryDialog.vue';

const breadcrumbs = [
  {
    title: 'Products',
    href: '/settings/profile'
  },
  {
    title: 'Categories',
    href: '/categories'
  }
];

const props = defineProps({
  categories: {
    type: Object,
    default: () => ({})
  }
});
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Categories" />

    <div class="px-4 py-6">
      <Card class="shadow-none">
        <CardHeader>
          <CardTitle>
            <div class="flex items-center justify-between">
              <h2 class="text-2xl font-bold tracking-tight">Categories</h2>
              <AddCategoryDialog :categories="categories" />
            </div>
          </CardTitle>
          <CardDescription>
            <p class="text-muted-foreground font-medium">
              Manage your product categories for your point of sale system.
            </p>
          </CardDescription>
        </CardHeader>
        <CardContent>
          <Datatable
            :columns="columns"
            :data="categories"
            :facet-columns="facetColumns"
            :search-column="name"
          />
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
