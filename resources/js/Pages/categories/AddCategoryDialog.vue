<script setup>
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Check, Plus, ChevronsUpDown, Image } from 'lucide-vue-next';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import {
  Combobox,
  ComboboxAnchor,
  ComboboxEmpty,
  ComboboxGroup,
  ComboboxInput,
  ComboboxItem,
  ComboboxItemIndicator,
  ComboboxList,
  ComboboxTrigger,
  ComboboxViewport
} from '@/components/ui/combobox';
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { FocusScope } from 'reka-ui';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { toast } from 'vue-sonner';
import InputError from '@/components/InputError.vue';

const props = defineProps({
  categories: {
    type: Object,
    default: () => ({})
  }
});

const isDialogOpen = ref(false);
const selectedCategory = ref();
const iconPreview = ref(null);
const iconInput = ref(null);

const selectNewIcon = () => {
  iconInput.value.click();
};

const updateIconPreview = () => {
  const icon = iconInput.value.files[0];

  if (!icon) return;

  const reader = new FileReader();

  reader.onload = (e) => {
    iconPreview.value = e.target.result;
  };

  reader.readAsDataURL(icon);
};

const clearIconFileInput = () => {
  if (iconInput.value?.value) {
    iconInput.value.value = null;
  }
  iconPreview.value = null;
};

const form = useForm({
  parent_id: null,
  name: '',
  description: '',
  icon: null,
  status: true
});

const handleSubmit = () => {
  if (selectedCategory.value) {
    form.parent_id = selectedCategory.value.id;
  }

  if (iconInput.value) {
    form.icon = iconInput.value.files[0];
  }

  form.post(route('categories.store'), {
    onSuccess: () => {
      form.reset();
      clearIconFileInput();
      isDialogOpen.value = false;
      toast.success('Category Saved!');
      router.visit(route('categories.index'));
    },
    preserveScroll: true,
    preserveState: true
  });
};
</script>

<template>
  <Dialog v-model:open="isDialogOpen">
    <DialogTrigger>
      <Button>
        <Plus class="h-4 w-4" />
        Create Category
      </Button>
    </DialogTrigger>
    <DialogContent>
      <form @submit.prevent="handleSubmit" class="space-y-6">
        <DialogHeader>
          <DialogTitle>Create Category</DialogTitle>
          <DialogDescription>
            Please fill in the category details below and click save to create a
            new category.
          </DialogDescription>
        </DialogHeader>

        <div class="grid gap-4">
          <!-- Parent Category -->
          <div class="grid gap-3">
            <Label for="name-1">Parent Category</Label>
            <Combobox v-model="selectedCategory" by="name">
              <ComboboxAnchor as-child>
                <ComboboxTrigger as-child>
                  <Button variant="outline" class="w-full justify-between">
                    {{ selectedCategory?.name ?? 'Select Parent category' }}

                    <ChevronsUpDown class="ml-2 size-4 shrink-0 opacity-50" />
                  </Button>
                </ComboboxTrigger>
              </ComboboxAnchor>

              <ComboboxList class="w-[463px]">
                <ComboboxInput placeholder="Select Parent Category..." />

                <FocusScope as-child trapped>
                  <ComboboxViewport class="max-h-[260px]">
                    <ComboboxEmpty> No category found. </ComboboxEmpty>

                    <ComboboxGroup>
                      <ComboboxItem
                        v-for="category in categories"
                        :key="category.id"
                        :value="category"
                      >
                        {{ category.name }}

                        <ComboboxItemIndicator>
                          <Check />
                        </ComboboxItemIndicator>
                      </ComboboxItem>
                    </ComboboxGroup>
                  </ComboboxViewport>
                </FocusScope>
              </ComboboxList>
            </Combobox>
            <InputError :message="form.errors.parent_id" />
          </div>

          <!-- Category Name -->
          <div class="grid gap-3">
            <Label for="name">Category Name</Label>
            <Input
              type="text"
              id="name"
              v-model="form.name"
              placeholder="Enter Category Name"
            />
            <InputError :message="form.errors.name" />
          </div>

          <!-- Category Description -->
          <div class="grid gap-3">
            <Label for="name">Category Description</Label>
            <Textarea
              placeholder="Tell us a little bit about category"
              class="resize-none"
              v-model="form.description"
            />
            <InputError :message="form.errors.description" />
          </div>

          <!-- Status -->
          <div class="mt-3 flex items-center space-x-2">
            <Switch id="status" v-model="form.status" class="cursor-pointer" />
            <Label for="status">Active</Label>
            <InputError :message="form.errors.status" />
          </div>

          <!-- Category Icon -->
          <div class="grid gap-3">
            <Label for="name">Category Icon</Label>
            <div class="flex gap-6">
              <Avatar class="h-12 w-12">
                <AvatarImage
                  v-show="iconPreview"
                  :src="iconPreview"
                  alt="@unovue"
                />
                <AvatarFallback v-show="!iconPreview">
                  <Image />
                </AvatarFallback>
              </Avatar>

              <div class="d-flex flex-column justify-center gap-4">
                <div class="d-flex flex-wrap gap-2">
                  <Button
                    @click.prevent="selectNewIcon"
                    variant="outline"
                    size="sm"
                    >Choose Icon</Button
                  >
                  <div class="mt-1 text-xs text-gray-400">
                    Allowed JPG or PNG, Icon resolution should be (110px X
                    110px)
                  </div>

                  <input
                    id="icon"
                    ref="iconInput"
                    type="file"
                    hidden
                    @change="updateIconPreview"
                  />
                </div>
              </div>
            </div>
            <InputError :message="form.errors.icon" />
          </div>
        </div>

        <DialogFooter class="gap-2">
          <Button type="submit"> Save </Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
