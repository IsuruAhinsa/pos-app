<script setup>
import {shallowRef} from 'vue';
import AppLayout from "@/layouts/AppLayout.vue";
import {Head} from "@inertiajs/vue3";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import Datatable from "@/components/datatable/Datatable.vue";
import {columns, facetColumns} from './CategoryColumns.js'
import AddCategoryDialog from "@/Pages/categories/AddCategoryDialog.vue";

const breadcrumbs = [
    {
        title: 'Products',
        href: '/settings/profile',
    },
    {
        title: 'Categories',
        href: '/settings/profile',
    },
];

const categories = shallowRef([
    {
        "id": 1,
        "parentCategory": "Electronic",
        "name": "TV",
        "products_count": 2,
        "status": "active",
    },
    {
        "id": 2,
        "parentCategory": "Electronic",
        "name": "Smartphones",
        "products_count": 5,
        "status": "active",
    },
    {
        "id": 3,
        "parentCategory": "Clothing",
        "name": "Men's Wear",
        "products_count": 8,
        "status": "active",
    },
    {
        "id": 4,
        "parentCategory": "Clothing",
        "name": "Women's Wear",
        "products_count": 12,
        "status": "active",
    },
    {
        "id": 5,
        "parentCategory": "Books",
        "name": "Fiction",
        "products_count": 15,
        "status": "active",
    },
    {
        "id": 6,
        "parentCategory": "Books",
        "name": "Non-Fiction",
        "products_count": 10,
        "status": "active",
    },
    {
        "id": 7,
        "parentCategory": "Food",
        "name": "Snacks",
        "products_count": 6,
        "status": "active",
    },
    {
        "id": 8,
        "parentCategory": "Food",
        "name": "Beverages",
        "products_count": 4,
        "status": "active",
    },
    {
        "id": 9,
        "parentCategory": "Sports",
        "name": "Equipment",
        "products_count": 9,
        "status": "inactive",
    },
    {
        "id": 10,
        "parentCategory": "Sports",
        "name": "Apparel",
        "products_count": 7,
        "status": "active",
    },
    {
        "id": 11,
        "parentCategory": "Electronic",
        "name": "Laptops",
        "products_count": 3,
        "status": "active",
    },
])

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Categories"/>

        <div class="px-4 py-6">
            <Card class="shadow-none">
                <CardHeader>
                    <CardTitle>
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-bold tracking-tight">
                                Categories
                            </h2>
                            <AddCategoryDialog />
                        </div>
                    </CardTitle>
                    <CardDescription>
                        <p class="text-muted-foreground font-medium">
                            Manage your product categories for your point of sale system.
                        </p>
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Datatable :columns="columns" :data="categories" :facet-columns="facetColumns" />
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
