<script setup>
import InertiaModal from '@/Components/Modals/InertiaModal.vue'
</script>

<template>
    <InertiaModal>
        <div v-bind="$attrs" class="overflow-hidden">
            <div class="px-6 py-4">
                <div class="text-lg font-medium text-gray-900">
                    <slot name="title" />
                </div>

                <div class="mt-4 text-sm text-gray-600">
                    <slot name="content" />
                </div>
            </div>

            <div
                class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-end"
            >
                <slot name="footer" />
            </div>
        </div>
    </InertiaModal>
</template>
