<script setup>
import SvgIcon from '@/Components/Common/SvgIcon.vue'
import DropdownLink from '@/Components/Common/DropdownLink.vue'
import Dropdown from '@/Components/Common/Dropdown.vue'

defineEmits(['logout'])
</script>

<template>
    <div>
        <Dropdown align="right" width="48">
            <template #trigger>
                <button
                    v-if="$page.props.jetstream.managesProfilePhotos"
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
                >
                    <img
                        class="h-8 w-8 rounded-full object-cover"
                        :src="$page.props.auth.user.profile_photo_url"
                        :alt="$page.props.auth.user.name"
                    />
                </button>

                <span v-else class="inline-flex rounded-md">
                    <button
                        type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"
                    >
                        {{ $page.props.auth.user.name }}
                        <SvgIcon
                            name="chevron-down"
                            class="ms-2 -me-0.5 h-4 w-4"
                        />
                    </button>
                </span>
            </template>

            <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    Manage Account
                </div>

                <DropdownLink :href="route('profile.show')">
                    Profile
                </DropdownLink>

                <DropdownLink
                    v-if="$page.props.jetstream.hasApiFeatures"
                    :href="route('api-tokens.index')"
                >
                    API Tokens
                </DropdownLink>

                <div class="border-t border-gray-200" />

                <!-- Authentication -->
                <form @submit.prevent="$emit('logout')">
                    <DropdownLink as="button"> Log Out </DropdownLink>
                </form>
            </template>
        </Dropdown>
    </div>
</template>
