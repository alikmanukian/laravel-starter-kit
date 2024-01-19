<script setup>
import InertiaDialog from '@/Components/Modals/InertiaDialog.vue'
import PrimaryButton from '@/Components/Forms/PrimaryButton.vue'
import SecondaryButton from '@/Components/Forms/SecondaryButton.vue'
</script>

<template>
    <InertiaDialog class="bg-white max-w-lg shadow-xl rounded-md">
        <template #title> Modal Title </template>

        <template #content>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. A
                aliquid amet atque dolor, itaque, maxime minima mollitia nemo
                nesciunt nisi obcaecati odio placeat porro, quod repellat
                reprehenderit sequi ut voluptas!
            </p>

            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste,
                quis!
            </p>
        </template>

        <template #footer>
            <SecondaryButton tabindex="2"> Cancel </SecondaryButton>
            <PrimaryButton class="ms-3" tabindex="1"> Save </PrimaryButton>
        </template>
    </InertiaDialog>
</template>
