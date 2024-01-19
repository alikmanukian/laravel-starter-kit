<script setup>
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
} from '@headlessui/vue'
import { useModal } from 'momentum-modal'

defineProps({
    centered: {
        type: Boolean,
        default: false,
    },
})

// methods
const { show, close, redirect } = useModal()
</script>

<template>
    <TransitionRoot :show="show">
        <Dialog as="div" class="relative z-50" @close="close">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
                @after-leave="redirect"
            >
                <div class="fixed inset-0 transform transition-all">
                    <div class="absolute inset-0 bg-gray-500 opacity-75" />
                </div>
            </TransitionChild>

            <div class="fixed inset-4 overflow-y-auto transition-opacity">
                <div
                    class="flex justify-center"
                    :class="{ 'items-center min-h-full': centered }"
                >
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="transform overflow-hidden align-middle transition-all"
                        >
                            <slot />
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
