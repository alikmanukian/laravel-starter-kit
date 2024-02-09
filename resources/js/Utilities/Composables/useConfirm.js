import { reactive, readonly } from 'vue'

const globalState = reactive({
    show: false,
    title: '',
    message: '',
})

export function useConfirm() {
    const reset = () => {
        globalState.show = false
        globalState.resolver = null
    }

    return {
        state: readonly(globalState),
        confirmation(message, title = 'Please confirm') {
            globalState.show = true
            globalState.title = title
            globalState.message = message

            return new Promise((resolve) => {
                globalState.resolver = resolve
            })
        },
        confirm() {
            if (globalState.resolver) {
                globalState.resolver(true)
            }

            reset()
        },
        cancel() {
            if (globalState.resolver) {
                globalState.resolver(false)
            }

            reset()
        },
    }
}
