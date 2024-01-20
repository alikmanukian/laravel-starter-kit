<script setup>
import { Modal } from 'momentum-modal'
import Toast from '@/Components/Common/Toast.vue'
</script>

<template>
    <slot />
    <Modal />
    <Toast />
</template>
