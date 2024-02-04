<script setup>
import { defineAsyncComponent } from 'vue'

const props = defineProps({
    name: {
        type: String,
        required: true,
    }
})

const icon = defineAsyncComponent(() => import(`../../../assets/icons/svg/${props.name.toLowerCase()}.svg`))
</script>

<template>
    <component :is="icon"></component>
</template>
