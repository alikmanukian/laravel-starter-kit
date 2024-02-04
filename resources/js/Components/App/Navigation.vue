<script setup>
import { Link, router } from '@inertiajs/vue3'
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
} from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'
import Container from '@/Components/App/Container.vue'
</script>

<template>
    <Disclosure v-slot="{ open }" as="nav" class="border-b border-b-slate-200 mb-4">
        <Container>
            <div class="flex h-16 justify-between relative">
                <div class="flex grow">
                    <div class="flex items-center sm:mr-6">
                        <Link href="#" class="font-bold font-mono text-lg">
                            {{ $page.props.config['app.name'] }}
                        </Link>
                    </div>

                    <div class="flex justify-between w-full">
                        <div class="hidden sm:flex sm:ml-6 space-x-8">
                            <Link
                                :href="route('home')"
                                class="inline-flex items-center border-b-2 border-transparent hover:border-gray-200 text-sm font-medium text-gray-900"
                            >
                                Home
                            </Link>
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="inline-flex items-center border-b-2 border-transparent hover:border-gray-200 text-sm font-medium text-gray-900"
                            >
                                Dashboard
                            </Link>
                        </div>

                        <div
                            v-if="!$page.props.auth.user"
                            class="hidden sm:flex sm:ml-6 space-x-8"
                        >
                            <Link
                                v-if="$page.props.auth.features.registration"
                                :href="route('register')"
                                class="inline-flex items-center border-b-2 border-transparent text-sm font-medium text-gray-900"
                            >
                                Create an account
                            </Link>
                            <Link
                                :href="route('login')"
                                class="inline-flex items-center border-b-2 border-transparent text-sm font-medium text-gray-900"
                            >
                                Sign In
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="inset-y-0 right-0 flex items-center space-x-3 ml-4">
                    <Menu
                        v-if="$page.props.auth.user"
                        as="ul"
                        class="relative mr-1"
                    >
                        <MenuButton class="flex items-center text-sm space-x-3">
                            <span class="font-medium text-gray-900 text-right">
                                {{ $page.props.auth.user.name }}
                            </span>
                            <img
                                src="https://ui-avatars.com/api/?name=Alex"
                                alt="Avatar"
                                class="h-8 w-8 rounded-full"
                            />
                        </MenuButton>
                        <MenuItems
                            class="absolute right-0 z-10 mt-2 w-48 bg-white border border-b-slate-200"
                        >
                            <MenuItem v-slot="{ active, close }">
                                <Link
                                    href="#"
                                    class="block px-4 py-2 text-sm text-gray-900"
                                    :class="{ 'bg-gray-100': active }"
                                    :on-success="close"
                                >
                                    Account
                                </Link>
                            </MenuItem>

                            <MenuItem v-slot="{ active, close }">
                                <Link
                                    href="#"
                                    class="block px-4 py-2 text-sm text-gray-900"
                                    :class="{ 'bg-gray-100': active }"
                                    :on-success="close"
                                >
                                    Security
                                </Link>
                            </MenuItem>

                            <MenuItem v-slot="{ active }">
                                <button
                                    class="block px-4 py-2 text-sm text-gray-900 w-full text-left"
                                    :class="{ 'bg-gray-100': active }"
                                    @click.prevent="
                                        router.post(route('logout'))
                                    "
                                >
                                    Sign out
                                </button>
                            </MenuItem>
                        </MenuItems>
                    </Menu>

                    <DisclosureButton
                        class="sm:hidden relative p-2 text-gray-900 hover:bg-gray-100"
                    >
                        <Bars3Icon v-if="!open" class="block w-6 h-6" />
                        <XMarkIcon v-else class="block w-6 h-6" />
                    </DisclosureButton>
                </div>
            </div>
        </Container>
        <DisclosurePanel class="sm:hidden">
            <div class="space-y-1 pb-3">
                <Link
                    :href="route('home')"
                    class="block py-2 px-8 font-medium text-gray-900"
                >
                    Home
                </Link>
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="block py-2 px-8 font-medium text-gray-900"
                >
                    Dashboard
                </Link>
            </div>
            <div v-if="!$page.props.auth.user" class="space-y-1 pb-3">
                <Link
                    v-if="$page.props.auth.features.registration && !$page.props.auth.user"
                    :href="route('register')"
                    class="block py-2 px-8 font-medium text-gray-900"
                >
                    Create an account
                </Link>
                <Link
                    v-if="!$page.props.auth.user"
                    :href="route('login')"
                    class="block py-2 px-8 font-medium text-gray-900"
                >
                    Sign In
                </Link>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>
