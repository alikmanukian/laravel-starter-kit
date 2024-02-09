# Confirmations
```vue
<script setup>
import { useConfirm } from '@/Utilities/Composables/useConfirm'
const { confirmation } = useConfirm()

const onDelete = async () => {
    if (! await confirmation(
        'Are you sure you want to confirm this action?', 
        'Please confirm action'
    )) {
        return
    }

    // Do something
}

</script>

<template>
    <button @click="onDelete">Delete</button>
</template>
```
