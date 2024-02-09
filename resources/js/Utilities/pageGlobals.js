import { usePage } from '@inertiajs/vue3'

export function isCurrentRoute(name) {
    return usePage().props.ziggy.route_name === name
}

export function isAuthorized() {
    return usePage().props.auth.user !== null
}
export default {}
