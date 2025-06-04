<script setup>
import { computed } from 'vue'
import { X } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import DataTableFacetedFilter from './DataTableFacetedFilter.vue'
import DataTableViewOptions from './DataTableViewOptions.vue'

const props = defineProps({
    table: {
        type: Object,
        required: true
    },
    searchColumn: {
        type: String,
        default: 'title'
    },
    facetColumns: {
        type: Array,
        default: () => []
    }
})

const isFiltered = computed(() => props.table.getState().columnFilters.length > 0)
</script>

<template>
    <div class="flex items-center justify-between">
        <div class="flex flex-1 items-center space-x-2">
            <Input
                v-if="searchColumn"
                :placeholder="`Filter ${searchColumn}...`"
                :model-value="(table.getColumn(searchColumn)?.getFilterValue() || '')"
                class="h-8 w-[150px] lg:w-[250px]"
                @input="table.getColumn(searchColumn)?.setFilterValue($event.target.value)"
            />

            <template v-for="facet in facetColumns" :key="facet.column">
                <DataTableFacetedFilter
                    v-if="table.getColumn(facet.column)"
                    :column="table.getColumn(facet.column)"
                    :title="facet.title"
                    :options="facet.options"
                />
            </template>

            <Button
                v-if="isFiltered"
                variant="ghost"
                class="h-8 px-2 lg:px-3"
                @click="table.resetColumnFilters()"
            >
                Reset
                <X class="ml-2 h-4 w-4" />
            </Button>
        </div>
        <DataTableViewOptions :table="table" />
    </div>
</template>
