import {h} from "vue";
import {Checkbox} from "@/components/ui/checkbox";
import DataTableColumnHeader from "@/components/datatable/DataTableColumnHeader.vue";
import DataTableRowActions from "@/components/datatable/DataTableRowActions.vue";
import {Circle, CircleHelp} from "lucide-vue-next";

export const statuses = [
    {
        value: 'active',
        label: 'Active',
        icon: h(CircleHelp),
    },
    {
        value: 'inactive',
        label: 'InActive',
        icon: h(Circle),
    },
]

export const columns = [
    {
        id: 'select',
        header: ({ table }) => h(Checkbox, {
            'modelValue': table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
            'onUpdate:modelValue': value => table.toggleAllPageRowsSelected(!!value),
            'ariaLabel': 'Select all',
            'class': 'translate-y-0.5',
        }),
        cell: ({ row }) => h(Checkbox, { 'modelValue': row.getIsSelected(), 'onUpdate:modelValue': value => row.toggleSelected(!!value), 'ariaLabel': 'Select row', 'class': 'translate-y-0.5' }),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: 'parentCategory',
        header: ({ column }) => h(DataTableColumnHeader, { column, title: 'Parent Category' }),
        cell: ({ row }) => h('div', { class: 'max-w-[500px] truncate font-medium' }, row.getValue('parentCategory')),
    },
    {
        accessorKey: 'name',
        header: ({ column }) => h(DataTableColumnHeader, { column, title: 'Name' }),
        cell: ({ row }) => h('div', { class: 'max-w-[500px] truncate' }, row.getValue('name')),
        filterFn: (row, id, value) => {
            return value.includes(row.getValue(id))
        },
    },
    {
        accessorKey: 'products_count',
        header: ({ column }) => h(DataTableColumnHeader, { column, title: 'Products' }),
        cell: ({ row }) => h('div', { class: 'max-w-[500px] truncate' }, row.getValue('products_count')),
        filterFn: (row, id, value) => {
            return value.includes(row.getValue(id))
        },
    },
    {
        accessorKey: 'status',
        header: ({ column }) => h(DataTableColumnHeader, { column, title: 'Status' }),

        cell: ({ row }) => {
            const status = statuses.find(
                status => status.value === row.getValue('status'),
            )

            if (!status)
                return null

            return h('div', { class: 'flex w-[100px] items-center' }, [
                status.icon && h(status.icon, { class: 'mr-2 h-4 w-4 text-muted-foreground' }),
                h('span', status.label),
            ])
        },
        filterFn: (row, id, value) => {
            return value.includes(row.getValue(id))
        },
    },
    {
        id: 'actions',
        cell: ({ row }) => h(DataTableRowActions, { row }),
    },
]

export const facetColumns = [
    {
        column: 'status',
        title: 'Status',
        options: statuses,
    },
]
