<script setup>
defineProps({
    opened: {
        type: Boolean,
        default: false,
    },
})

defineEmits(['toggle'])
</script>

<template>
    <div>
        <button
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
            @click="$emit('toggle', !opened)"
        >
            <svg
                class="h-6 w-6"
                stroke="currentColor"
                fill="none"
                viewBox="0 0 24 24"
            >
                <path
                    :class="{
                        hidden: opened,
                        'inline-flex': !opened,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                    :class="{
                        hidden: !opened,
                        'inline-flex': opened,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>
    </div>
</template>
