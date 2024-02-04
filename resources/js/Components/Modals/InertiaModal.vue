<script setup>
import { useModal } from 'momentum-modal'
import HeadlessUIModal from '@/Components/Modals/HeadlessModal.vue'

defineProps({
    centered: {
        type: Boolean,
        default: false,
    },
    fullscreen: {
        type: Boolean,
        default: false,
    },
})

// methods
const { show, close, redirect } = useModal()
</script>

<template>
    <HeadlessUIModal
        :show="show"
        :centered="centered"
        :fullscreen="fullscreen"
        v-bind="$attrs"
        @after-leave="redirect"
        @close="close"
    >
        <slot />
    </HeadlessUIModal>
</template>
