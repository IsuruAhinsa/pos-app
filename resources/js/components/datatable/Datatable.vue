<script setup>
import {
    FlexRender,
    getCoreRowModel,
    getFacetedRowModel,
    getFacetedUniqueValues,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    useVueTable,
} from '@tanstack/vue-table'
import { ref, watch } from 'vue'
import { valueUpdater } from '@/components/datatable/utils/datatable'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import DataTablePagination from './DataTablePagination.vue'
import DataTableToolbar from './DataTableToolbar.vue'

const props = defineProps({
    columns: {
        type: Array,
        required: true
    },
    data: {
        type: Array,
        required: true
    },
    pageSize: {
        type: Number,
        default: 10
    },
    pageSizes: {
        type: Array,
        default: () => [10, 20, 30, 40, 50]
    },
    showToolbar: {
        type: Boolean,
        default: true
    },
    showPagination: {
        type: Boolean,
        default: true
    },
    showRowSelection: {
        type: Boolean,
        default: true
    },
    searchColumn: {
        type: String,
        default: undefined
    },
    facetColumns: {
        type: Array,
        default: () => []
    }
})

const emit = defineEmits([
    'update:sorting',
    'update:columnFilters',
    'update:columnVisibility',
    'update:rowSelection'
])

const sorting = ref([])
const columnFilters = ref([])
const columnVisibility = ref({})
const rowSelection = ref({})
const globalFilter = ref('')

const table = useVueTable({
    data: props.data,
    columns: props.columns,
    state: {
        get sorting() { return sorting.value },
        get columnFilters() { return columnFilters.value },
        get columnVisibility() { return columnVisibility.value },
        get rowSelection() { return rowSelection.value },
        get globalFilter() { return globalFilter.value },
        get pagination() {
            return {
                pageIndex: 0,
                pageSize: props.pageSize
            }
        },
    },
    enableRowSelection: props.showRowSelection,
    onSortingChange: updater => valueUpdater(updater, sorting),
    onColumnFiltersChange: updater => valueUpdater(updater, columnFilters),
    onColumnVisibilityChange: updater => valueUpdater(updater, columnVisibility),
    onRowSelectionChange: updater => valueUpdater(updater, rowSelection),
    onGlobalFilterChange: updater => valueUpdater(updater, globalFilter),
    getCoreRowModel: getCoreRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFacetedRowModel: getFacetedRowModel(),
    getFacetedUniqueValues: getFacetedUniqueValues(),
    globalFilterFn: 'includesString',
})

// Emit state changes
watch(sorting, (value) => emit('update:sorting', value))
watch(columnFilters, (value) => emit('update:columnFilters', value))
watch(columnVisibility, (value) => emit('update:columnVisibility', value))
watch(rowSelection, (value) => emit('update:rowSelection', value))
watch(globalFilter, (value) => emit('update:globalFilter', value))

defineExpose({
    table,
})
</script>

<template>
    <div class="space-y-4">
        <DataTableToolbar
            v-if="showToolbar"
            :table="table"
            :search-column="searchColumn"
            :facet-columns="facetColumns"
        />

        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead v-for="header in headerGroup.headers" :key="header.id">
                            <FlexRender
                                v-if="!header.isPlaceholder"
                                :render="header.column.columnDef.header"
                                :props="header.getContext()"
                            />
                        </TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <TableRow
                            v-for="row in table.getRowModel().rows"
                            :key="row.id"
                            :data-state="row.getIsSelected() && 'selected'"
                        >
                            <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                <FlexRender
                                    :render="cell.column.columnDef.cell"
                                    :props="cell.getContext()"
                                />
                            </TableCell>
                        </TableRow>
                    </template>

                    <TableRow v-else>
                        <TableCell
                            :colspan="columns.length"
                            class="h-24 text-center"
                        >
                            No results.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <DataTablePagination
            v-if="showPagination"
            :table="table"
            :page-sizes="pageSizes"
        />
    </div>
</template>
