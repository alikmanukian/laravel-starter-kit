<script setup>
import { Modal as MomentumModal } from 'momentum-modal'
import Toast from '@/Components/Common/Toast.vue'
</script>

<template>
    <slot />
    <MomentumModal />
    <Toast />
</template>
