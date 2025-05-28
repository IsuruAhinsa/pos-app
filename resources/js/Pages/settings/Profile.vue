<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { cn } from '@/lib/utils'
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxItemIndicator, ComboboxList, ComboboxTrigger } from '@/components/ui/combobox'
import { Check, ChevronsUpDown, Search } from 'lucide-vue-next'
import {computed, ref, watch} from 'vue'
import {ScrollArea} from "@/components/ui/scroll-area";
import { parsePhoneNumberFromString, isValidPhoneNumber } from 'libphonenumber-js';

defineProps({
    mustVerifyEmail: {
        type: Boolean
    },
    status: {
        type: String
    },
    countryCodes: {
        type: Array,
        default: () => [],
    },
})

const breadcrumbs = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

const page = usePage();
const user = page.props.auth.user;
const countryCode = ref('+94');
const contactNumber = ref("");

if (user.phone?.startsWith('+')) {
    const parsed = parsePhoneNumberFromString(user.phone);
    if (parsed) {
        countryCode.value = `+${parsed.countryCallingCode}`;
        contactNumber.value = parsed.nationalNumber;
    }
}

const form = useForm({
    first_name: user.first_name,
    last_name: user.last_name,
    email: user.email,
    phone: user.phone,
});

watch([countryCode, contactNumber], ([code, number]) => {
    const fullNumber = `${code}${number}`;
    form.phone = fullNumber;
});

const phoneError = computed(() => {
    const fullNumber = `${countryCode.value}${contactNumber.value}`;
    try {
        const phone = parsePhoneNumberFromString(fullNumber);
        if (!phone || !phone.isValid()) {
            return 'Invalid phone number.';
        }
    } catch {
        return 'Invalid phone number.';
    }
    return null;
});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Profile information" description="Update your name and email address" />

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="first-name">First Name</Label>
                        <Input id="first-name" class="mt-1 block w-full" v-model="form.first_name" required autocomplete="first_name" placeholder="First name" />
                        <InputError class="mt-2" :message="form.errors.first_name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="last-name">Last Name</Label>
                        <Input id="last-name" class="mt-1 block w-full" v-model="form.last_name" autocomplete="last_name" placeholder="Last name" />
                        <InputError class="mt-2" :message="form.errors.last_name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">Email address</Label>
                        <Input
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            placeholder="Email address"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="phone">Phone</Label>
                        <div class="flex items-center">
                            <Combobox v-model="countryCode" by="label">
                                <ComboboxAnchor as-child class="w-24">
                                    <ComboboxTrigger as-child>
                                        <Button variant="outline" class="justify-between rounded-r-none border-r-0">
                                            {{ countryCode }}

                                            <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                        </Button>
                                    </ComboboxTrigger>
                                </ComboboxAnchor>

                                <ComboboxList>
                                    <div class="relative w-full max-w-sm items-center">
                                        <ComboboxInput class="focus-visible:ring-0 border-0 rounded-none h-10" placeholder="Select Country Code" />
                                        <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
          <Search class="size-4 text-muted-foreground" />
        </span>
                                    </div>

                                    <ComboboxEmpty>
                                        No country code found.
                                    </ComboboxEmpty>

                                    <ComboboxGroup>
                                        <ScrollArea class="h-72">
                                            <ComboboxItem
                                                v-for="(code, index) in countryCodes"
                                                :key="index"
                                                :value="code"
                                            >
                                                {{ code }}

                                                <ComboboxItemIndicator>
                                                    <Check :class="cn('ml-auto h-4 w-4')" />
                                                </ComboboxItemIndicator>
                                            </ComboboxItem>
                                        </ScrollArea>
                                    </ComboboxGroup>
                                </ComboboxList>
                            </Combobox>
                            <Input id="phone" class="mt-0 block w-full rounded-l-none" v-model="contactNumber" required autocomplete="phone" placeholder="Enter Phone Number" />
                        </div>
                        <InputError :message="form.errors.phone || phoneError" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="-mt-4 text-sm text-muted-foreground">
                            Your email address is unverified.
                            <Link
                                :href="route('verification.send')"
                                method="post"
                                as="button"
                                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                            >
                                Click here to resend the verification email.
                            </Link>
                        </p>

                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                            A new verification link has been sent to your email address.
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Save</Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                        </Transition>
                    </div>
                </form>
            </div>

            <DeleteUser />
        </SettingsLayout>
    </AppLayout>
</template>
