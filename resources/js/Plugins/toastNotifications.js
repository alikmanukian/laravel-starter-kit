import { router, usePage } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'

const toast = useToast()

export default () => {
    router.on('finish', () => {
        let body = usePage().props.flash.toast

        if (body) {
            toast(body, { timeout: 3000 })
        }
    })
}
