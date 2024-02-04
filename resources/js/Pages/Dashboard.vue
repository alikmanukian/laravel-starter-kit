<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Container from '@/Components/App/Container.vue'
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <Container>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white">
                        Dashboard Content
                    </div>
                </div>
            </Container>
        </div>
    </AppLayout>
</template>
