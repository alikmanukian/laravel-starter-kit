<script setup>
import { Head, Link } from '@inertiajs/vue3'
import Blank from '@/Layouts/Blank.vue'
import Default from '@/Layouts/Default.vue'

defineOptions({ layout: [Blank, Default] })
</script>

<template>
    <Head title="Starter Kit" />
    <div class="max-w-5xl mx-auto p-8">
        <h2 class="text-2xl my-4">Inertia Modals</h2>
        <div class="space-y-4 w-60">
            <Link
                :href="route('modal', { type: 'HeadlessUIModal' })"
                class="bg-slate-600 text-white rounded px-4 py-2 block text-center"
            >
                Open HeadlessUI Modal
            </Link>

            <Link
                :href="route('modal', { type: 'HeadlessUIDialog' })"
                class="bg-orange-600 text-white rounded px-4 py-2 block text-center"
            >
                Open HeadlessUI Dialog
            </Link>
        </div>
    </div>
</template>
