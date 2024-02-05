<script setup>
import ApiTokenManager from '@/Pages/API/Partials/ApiTokenManager.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Container from '@/Components/App/Container.vue'

defineProps({
    tokens: {
        type: Array,
        default: () => [],
    },
    availablePermissions: {
        type: Array,
        default: () => [],
    },
    defaultPermissions: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <AppLayout title="API Tokens">
        <div>
            <Container class="py-10">
                <ApiTokenManager
                    :tokens="tokens"
                    :available-permissions="availablePermissions"
                    :default-permissions="defaultPermissions"
                />
            </Container>
        </div>
    </AppLayout>
</template>
