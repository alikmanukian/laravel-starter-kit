import { router, usePage } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'
import { isAxiosError } from 'axios'

const toast = useToast()

export default (app) => {
    return () => {
        // setup vue error handler
        app.config.errorHandler = (err, vm, info) => {
            if (isAxiosError(err)) {
                console.error('axios error', err)
            } else {
                console.error('Another error', err, vm, info)
            }
        }

        // catch errors from inertia
        router.on('finish', () => {
            const error = usePage().props.flash.error

            if (!error) {
                return
            }

            switch (error.code) {
                case 401: // eslint-disable-line
                    return router.visit(route('login')) // eslint-disable-line
                default: // eslint-disable-line
                    break // eslint-disable-line
            }

            if (error) {
                toast.error(error.message, { timeout: 3000 })
            }
        })
    }
}
