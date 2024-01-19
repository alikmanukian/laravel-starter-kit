<script setup>
import Navigation from '@/Components/App/Navigation.vue'
</script>

<template>
    <div>
        <Navigation />
        <div>
            <slot />
        </div>
    </div>
</template>
