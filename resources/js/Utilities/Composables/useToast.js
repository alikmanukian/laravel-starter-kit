import { ref, computed } from 'vue'

const active = ref(false)
const toastOptions = ref({
    body: '',
    timeout: 2000,
})
let timeout = null

export default () => {
    const toast = (body, options) => {
        if (active.value) {
            clearTimeout(timeout)
        }

        toastOptions.value = { ...toastOptions.value, ...options }

        toastOptions.value.body = body
        active.value = true

        timeout = setTimeout(() => {
            active.value = false
            toastOptions.value.body = ''
        }, toastOptions.value.timeout)
    }

    const hide = () => {
        clearTimeout(timeout)
        active.value = false
        toastOptions.value.body = ''
    }

    return {
        toast,
        active,
        hide,
        body: computed(() => toastOptions.value.body),
    }
}
