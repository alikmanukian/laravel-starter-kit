<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Container from '@/Components/App/Container.vue'
import BlankLayout from '@/Layouts/BlankLayout.vue'
import { Head } from '@inertiajs/vue3'

defineOptions({ layout: [BlankLayout, AppLayout] })
</script>

<template>
    <Head title="Dashboard" />

    <div class="py-12">
        <Container>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white">Dashboard Content</div>
            </div>
        </Container>
    </div>
</template>
