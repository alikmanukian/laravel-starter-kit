<script setup>
import NavLink from '@/Components/App/Navigation/NavLink.vue'
import DropdownLink from '@/Components/Common/DropdownLink.vue'
import ResponsiveNavLink from '@/Components/App/Navigation/ResponsiveNavLink.vue'
import { computed } from 'vue'

const props = defineProps({
    items: {
        type: Array,
        required: true,
    },
    dropdown: {
        type: Boolean,
        default: false,
    },
    responsive: {
        type: Boolean,
        default: false,
    },
})

const componentName = computed(() => {
    if (props.dropdown) return DropdownLink
    return props.responsive ? ResponsiveNavLink : NavLink
})
</script>

<template>
    <div>
        <template v-for="item in items" :key="item.name">
            <component
                :is="componentName"
                v-if="item.show || item.show === undefined"
                :href="item.href"
                :active="item.current"
            >
                {{ item.name }}
            </component>
        </template>
    </div>
</template>
