<script setup>
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import { Button } from '@/components/ui/button'
import {Check, ChevronsUpDown, Plus, Search} from 'lucide-vue-next'
import {Label} from "@/components/ui/label";
import {cn} from "@/lib/utils.js";
import {
    Combobox,
    ComboboxAnchor,
    ComboboxEmpty, ComboboxGroup, ComboboxInput,
    ComboboxItem, ComboboxItemIndicator,
    ComboboxList,
    ComboboxTrigger
} from "@/components/ui/combobox";
import {ScrollArea} from "@/components/ui/scroll-area";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    parentCategories: {
        type: Array,
        default: () => [],
    }
})

const form = useForm({
    parent: '',
    name: '',
    description: '',
    image: '',
    status: '',
})
</script>

<template>
    <Dialog>
        <DialogTrigger>
            <Button>
                <Plus class="w-4 h-4" />
                Create Category
            </Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Create Category</DialogTitle>
                <DialogDescription>
                    Please fill in the category details below and click save to create a new category.
                </DialogDescription>
            </DialogHeader>

            <Label for="parent">Parent Category</Label>
            <Combobox v-model="form.parent" by="label">
                <ComboboxAnchor as-child class="w-full">
                    <ComboboxTrigger as-child>
                        <Button variant="outline" class="justify-between">
                            {{ parentCategories ?? 'Select Parent Category' }}

                            <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                        </Button>
                    </ComboboxTrigger>
                </ComboboxAnchor>

                <ComboboxList class="w-full">
                    <div class="relative w-full max-w-sm items-center">
                        <ComboboxInput class="focus-visible:ring-0 border-0 rounded-none h-10" placeholder="Select Parent Category" />
                        <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
          <Search class="size-4 text-muted-foreground" />
        </span>
                    </div>

                    <ComboboxEmpty>
                        No parent categories found.
                    </ComboboxEmpty>

                    <ComboboxGroup>
                        <ScrollArea class="h-72">
                            <ComboboxItem
                                v-for="(category, index) in parentCategories"
                                :key="index"
                                :value="category"
                            >
                                {{ category }}

                                <ComboboxItemIndicator>
                                    <Check :class="cn('ml-auto h-4 w-4')" />
                                </ComboboxItemIndicator>
                            </ComboboxItem>
                        </ScrollArea>
                    </ComboboxGroup>
                </ComboboxList>
            </Combobox>
            <DialogFooter>
                <Button>
                    Save
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
