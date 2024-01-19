<script setup>
import Navigation from '@/Components/App/Navigation.vue'
import { Modal } from 'momentum-modal'
import Toast from '@/Components/Common/Toast.vue'
</script>

<template>
    <div>
        <Navigation />
        <div>
            <slot />
        </div>

        <Modal />
    </div>

    <Toast />
</template>
