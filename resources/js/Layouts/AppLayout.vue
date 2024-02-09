<script setup>
import { Head } from '@inertiajs/vue3'
import Banner from '@/Components/App/Banner.vue'
import MainHeader from '@/Components/App/Navigation/MainHeader.vue'
import Confirmation from '@/Components/Modals/Confirmation.vue'

defineProps({
    title: {
        type: String,
        default: null,
    },
})
</script>

<template>
    <Head :title="title" />

    <Banner />

    <div class="min-h-screen bg-gray-100">
        <MainHeader />

        <main>
            <slot />
        </main>
    </div>

    <Confirmation />
</template>
