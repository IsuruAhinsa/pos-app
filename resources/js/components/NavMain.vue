<script setup>
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem
} from '@/components/ui/sidebar';
import {Link, usePage} from '@inertiajs/vue3';
import {ChevronRight} from 'lucide-vue-next';
import {SidebarMenuSub, SidebarMenuSubButton, SidebarMenuSubItem} from "@/components/ui/sidebar";
import {
    Collapsible,
    CollapsibleTrigger,
    CollapsibleContent,
} from '@/components/ui/collapsible';

const props = defineProps({
    items: {
        type: Array,
        required: true
    }
});

const page = usePage();

const isChildActive = (item) => {
    return item.href === page.url || item.children?.some(child => child.href === page.url);
};
</script>

<template>
    <SidebarGroup
        v-for="group in items"
        :key="group.label || 'group'"
        class="px-2 py-0"
    >
        <SidebarGroupLabel v-if="group.label">
            {{ group.label }}
        </SidebarGroupLabel>
        <SidebarMenu>
            <template v-for="item in group.items" :key="item.title">
                <Collapsible
                    v-if="item.children"
                    as-child
                    :default-open="isChildActive(item)"
                    class="group/collapsible"
                >
                    <SidebarMenuItem>
                        <CollapsibleTrigger as-child>
                            <SidebarMenuButton :tooltip="item.title">
                                <component :is="item.icon"/>
                                <span>{{ item.title }}</span>
                                <ChevronRight
                                    class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"/>
                            </SidebarMenuButton>
                        </CollapsibleTrigger>
                        <CollapsibleContent>
                            <SidebarMenuSub>
                                <SidebarMenuSubItem
                                    v-for="subItem in item.children"
                                    :key="subItem.title"
                                >
                                    <SidebarMenuSubButton as-child :is-active="subItem.href === page.url"
                                                          :class="{ '!bg-emerald-100': subItem.href === page.url }">
                                        <Link :href="subItem.href">
                                            <component v-if="subItem.icon" :is="subItem.icon"/>
                                            <span>{{ subItem.title }}</span>
                                        </Link>
                                    </SidebarMenuSubButton>
                                </SidebarMenuSubItem>
                            </SidebarMenuSub>
                        </CollapsibleContent>
                    </SidebarMenuItem>
                </Collapsible>

                <SidebarMenuItem v-else>
                    <SidebarMenuButton as-child :tooltip="item.title" :is-active="item.href === page.url"
                                       :class="{ '!bg-emerald-100': item.href === page.url }">
                        <Link :href="item.href">
                            <component :is="item.icon"/>
                            <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </template>
        </SidebarMenu>
    </SidebarGroup>
</template>
