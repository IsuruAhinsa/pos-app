<script setup lang="ts">
import type { Table } from '@tanstack/vue-table'
import { computed } from 'vue'
import { Settings2 } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import {
    DropdownMenu,
    DropdownMenuCheckboxItem,
    DropdownMenuContent,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

interface DataTableViewOptionsProps {
    table: Table<any>
}

const props = defineProps<DataTableViewOptionsProps>()

const columns = computed(() => props.table.getAllColumns()
    .filter(
        column =>
            typeof column.accessorFn !== 'undefined' && column.getCanHide(),
    ))

const getHeaderTitle = (column: any) => {
    // If header is a function that returns a DataTableColumnHeader component
    if (typeof column.columnDef.header === 'function') {
        try {
            const headerResult = column.columnDef.header({ column })
            return headerResult.props?.title || column.id
        } catch {
            return column.id
        }
    }
    // If the header is directly a component with the title prop
    if (column.columnDef.header?.props?.title) {
        return column.columnDef.header.props.title
    }
    // Fallback to formatted column ID
    return column.id
        .replace(/([A-Z])/g, ' $1')
        .replace(/^./, str => str.toUpperCase())
        .trim()
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button
                variant="outline"
                size="sm"
                class="ml-auto hidden h-8 lg:flex"
            >
                <Settings2 class="mr-2 h-4 w-4" />
                View
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end" class="w-[150px]">
            <DropdownMenuLabel>Toggle columns</DropdownMenuLabel>
            <DropdownMenuSeparator />

            <DropdownMenuCheckboxItem
                v-for="column in columns"
                :key="column.id"
                class="capitalize"
                :model-value="column.getIsVisible()"
                @update:model-value="(value) => column.toggleVisibility(!!value)"
            >
                {{ getHeaderTitle(column) }}
            </DropdownMenuCheckboxItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
