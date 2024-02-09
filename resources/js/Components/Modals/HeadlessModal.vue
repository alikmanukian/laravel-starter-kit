<script setup>
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
} from '@headlessui/vue'
import { onMounted, onUnmounted } from 'vue'

const props = defineProps({
    centered: {
        type: Boolean,
        default: false,
    },
    fullscreen: {
        type: Boolean,
        default: false,
    },
    show: {
        type: Boolean,
        default: false,
    },
    open: {
        type: Boolean,
        default: false,
    },
    afterLeave: {
        type: Function,
        default: () => {},
    },
    closeOnEsc: {
        type: Boolean,
        default: false,
    },
    closeOnOverlayClick: {
        type: Boolean,
        default: false,
    }
})

const emit = defineEmits(['close', 'afterLeave'])

const onClickOverlay = () => {
    if (props.closeOnOverlayClick) {
        emit('close')
    }
}

const onEscape = (e) => {
    if (e.key === 'Escape') {
        emit('close')
    }
}

onMounted(() => {
    if (props.closeOnEsc) {
        window.addEventListener('keydown', onEscape)
    }
})

onUnmounted(() => {
    if (props.closeOnEsc) {
        window.removeEventListener('keydown', onEscape)
    }
})
</script>

<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-50">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
                @after-leave="$emit('afterLeave')"
            >
                <div class="fixed inset-0 transform transition-all">
                    <div class="absolute inset-0 bg-gray-500 opacity-75" @click="onClickOverlay" />
                </div>
            </TransitionChild>

            <div
                class="fixed overflow-y-auto transition-opacity pointer-events-none"
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
                        <DialogPanel
                            v-bind="$attrs"
                            :class="{ 'w-full min-w-full': fullscreen }"
                            class="pointer-events-auto"
                        >
                            <slot />
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
