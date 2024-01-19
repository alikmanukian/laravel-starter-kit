<script setup>
import Navigation from '@/Components/App/Navigation.vue'
import { Modal } from 'momentum-modal'
</script>

<template>
    <div>
        <Navigation />
        <div>
            <slot />
        </div>

        <Modal />
    </div>
</template>
