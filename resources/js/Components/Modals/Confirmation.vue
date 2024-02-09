<script setup>
import HeadlessUIModal from '@/Components/Modals/HeadlessModal.vue'
import SecondaryButton from '@/Components/Forms/SecondaryButton.vue'
import DangerButton from '@/Components/Forms/DangerButton.vue'
import { useConfirm } from '@/Utilities/Composables/useConfirm.js'

defineProps({
    centered: {
        type: Boolean,
        default: false,
    },
})

const { state, confirm, cancel } = useConfirm()

/**
 * Focus the cancel button when the modal is shown
 * But we don't use this because better to use tabindex="1"
 */
/*watchEffect(async () => {
    if (state.show) {
        await nextTick()
        cancelBtnRef.value?.$el.focus()
    }
})*/
</script>

<template>
    <HeadlessUIModal
        class="bg-white max-w-lg min-w-[400px] shadow-xl rounded-md overflow-hidden"
        :show="state.show"
        :centered="centered"
        v-bind="$attrs"
        close-on-esc
        @close="cancel"
    >
        <div class="flex flex-col h-full">
            <div class="px-6 py-4 flex-1">
                <div class="text-lg font-medium text-gray-900">
                    <slot name="title">
                        {{ state.title }}
                    </slot>
                </div>

                <div class="my-4 text-sm text-gray-600">
                    <slot name="content">
                        {{ state.message }}
                    </slot>
                </div>
            </div>

            <div
                class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-end"
            >
                <slot name="footer">
                    <SecondaryButton tabindex="1" @click="cancel">
                        Cancel
                    </SecondaryButton>
                    <DangerButton class="ms-3" tabindex="2" @click="confirm">
                        Confirm
                    </DangerButton>
                </slot>
            </div>
        </div>
    </HeadlessUIModal>
</template>
