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
        @after-leave="redirect"
        @close="close"
    >
        <div class="flex flex-col h-full">
            <div class="px-6 py-4 flex-1">
                <div class="text-lg font-medium text-gray-900">
                    <slot name="title" :close="close" />
                </div>

                <div class="mt-4 text-sm text-gray-600">
                    <slot name="content" :close="close" />
                </div>
            </div>

            <div
                class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-end"
            >
                <slot name="footer" :close="close" />
            </div>
        </div>
    </HeadlessUIModal>
</template>
