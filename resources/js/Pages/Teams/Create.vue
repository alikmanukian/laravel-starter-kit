<script setup>
import CreateTeamForm from '@/Pages/Teams/Partials/CreateTeamForm.vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import BlankLayout from '@/Layouts/BlankLayout.vue'

defineOptions({ layout: [BlankLayout, AppLayout] })
</script>

<template>
    <Head title="Create Team" />

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <CreateTeamForm />
        </div>
    </div>
</template>
