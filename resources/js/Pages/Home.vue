<script setup>
import Container from '@/Components/App/Container.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
    <AppLayout title="Home">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Home
            </h2>
        </template>

        <div class="py-12">
            <Container>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white">
                        <div class="mb-8">Home Content</div>

                        <div class="space-x-4">
                            <Link
                                :href="route('modal', 'Modal')"
                                class="rounded-lg py-2 px-4 bg-blue-300 hover:bg-blue-500 hover:text-white inline-block"
                            >
                                Open momentum modal
                            </Link>
                            <Link
                                :href="route('modal', 'Dialog')"
                                class="rounded-lg py-2 px-4 bg-red-300 hover:bg-red-500 hover:text-white inline-block"
                            >
                                Open momentum dialog
                            </Link>
                            <a
                                href="#"
                                class="rounded-lg py-2 px-4 bg-slate-300 hover:bg-slate-500 hover:text-white inline-block"
                                @click.prevent.stop="showModal"
                            >
                                Open modal
                            </a>
                        </div>
                    </div>
                </div>
            </Container>
        </div>
    </AppLayout>
</template>
