<script setup>
import Container from '@/Components/App/Container.vue'
import { Link, Head } from '@inertiajs/vue3'
import HeadlessModal from '@/Components/Modals/HeadlessModal.vue'
import { ref } from 'vue'
import BlankLayout from '@/Layouts/BlankLayout.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useConfirm } from '@/Utilities/Composables/useConfirm'

defineOptions({ layout: [BlankLayout, AppLayout] })

const showLocalModal = ref(false)

const { confirmation } = useConfirm()

const onConfirm = async () => {
    if (
        !(await confirmation('Are you sure you want to confirm this action?'))
    ) {
        return
    }

    alert('Confirmed')
}
</script>

<template>
    <Head title="Home" />
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
                            class="rounded-lg py-2 px-4 bg-orange-300 hover:bg-orange-500 hover:text-white inline-block"
                        >
                            Open momentum dialog
                        </Link>
                        <a
                            href="#"
                            class="rounded-lg py-2 px-4 bg-slate-300 hover:bg-slate-500 hover:text-white inline-block"
                            @click.prevent.stop="showLocalModal = true"
                        >
                            Open modal
                        </a>

                        <button
                            class="rounded-lg py-2 px-4 bg-red-300 hover:bg-red-500 hover:text-white inline-block"
                            @click="onConfirm"
                        >
                            Open Confirmation
                        </button>
                    </div>
                </div>
            </div>
        </Container>
    </div>

    <HeadlessModal
        class="bg-white max-w-lg shadow-xl rounded-md p-8"
        :show="showLocalModal"
        close-on-esc
        close-on-overlay-click
        @close="showLocalModal = false"
    >
        Test content. Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquid amet
        atque dolor, itaque, maxime minima mollitia nemo nesciunt nisi obcaecati
        odio placeat porro, quod repellat reprehenderit sequi ut voluptas!
    </HeadlessModal>
</template>
