<script setup>
import SvgIcon from '@/Components/Common/SvgIcon.vue'
import DropdownLink from '@/Components/Common/DropdownLink.vue'
import ResponsiveNavLink from '@/Components/App/Navigation/ResponsiveNavLink.vue'
import { computed } from 'vue'

defineEmits(['change'])

const props = defineProps({
    responsive: {
        type: Boolean,
        default: false,
    },
})

const componentName = computed(() => {
    return props.responsive ? ResponsiveNavLink : DropdownLink
})

const iconClass = computed(() => {
    return props.responsive
        ? 'h-6 w-6 text-green-500'
        : 'me-2 h-5 w-5 text-green-400'
})
</script>

<template>
    <template v-if="$page.props.auth.user.all_teams.length > 1">
        <div class="border-t border-gray-200" />

        <div class="block px-4 py-2 text-xs text-gray-400">Switch Teams</div>

        <template
            v-for="team in $page.props.auth.user.all_teams"
            :key="team.id"
        >
            <form @submit.prevent="$emit('change', team)">
                <component :is="componentName" as="button">
                    <div class="flex items-center">
                        <SvgIcon
                            v-if="
                                team.id ===
                                $page.props.auth.user.current_team_id
                            "
                            name="check-circle"
                            :class="iconClass"
                        />
                        <div>{{ team.name }}</div>
                    </div>
                </component>
            </form>
        </template>
    </template>
</template>
