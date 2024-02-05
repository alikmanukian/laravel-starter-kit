<script setup>
import SvgIcon from '@/Components/Common/SvgIcon.vue'
import Dropdown from '@/Components/Common/Dropdown.vue'
import TeamSwitcher from '@/Components/App/Navigation/TeamSwitcher.vue'
import NavLinks from '@/Components/App/Navigation/NavLinks.vue'

defineEmits(['ChangeTeam'])

defineProps({
    items: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <Dropdown align="right" width="60">
        <template #trigger>
            <span class="inline-flex rounded-md">
                <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"
                >
                    {{ $page.props.auth.user.current_team.name }}

                    <SvgIcon
                        name="chevron-up-down"
                        class="ms-2 -me-0.5 h-4 w-4"
                    />
                </button>
            </span>
        </template>

        <template #content>
            <div class="w-60">
                <!-- Team Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    Manage Team
                </div>

                <!-- Team Settings -->
                <NavLinks :items="items" dropdown />

                <TeamSwitcher @change="(team) => $emit('ChangeTeam', team)" />
            </div>
        </template>
    </Dropdown>
</template>
