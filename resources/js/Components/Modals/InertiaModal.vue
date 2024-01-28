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
    fullscreen: {
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

            <div
                class="fixed overflow-y-auto transition-opacity"
                :class="{ 'inset-4': !fullscreen, 'inset-0': fullscreen }"
            >
                <div
                    class="flex"
                    :class="{
                        'items-center min-h-full': centered,
                        'justify-center': !fullscreen,
                        'min-h-full': fullscreen,
                    }"
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
                        <DialogPanel as="template">
                            <slot />
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
