## Inertia modal example 
Modal response in controller
```php
class SomeController extends Controller
{
    public function store()
    {
        // ...
        return inertia()->modal('MyModal', [
            'title' => 'Modal Title',
            'name' => 'Alex',
        ])->baseRoute('some.route');
    }
}
```

Modal component
```vue
<script setup>
import InertiaModal from '@/Components/Modals/InertiaModal.vue'
</script>

<template>
    <InertiaModal class="bg-white max-w-lg shadow-xl rounded-md p-8">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquid
        amet atque dolor, itaque, maxime minima mollitia nemo nesciunt nisi
        obcaecati odio placeat porro, quod repellat reprehenderit sequi ut
        voluptas!
    </InertiaModal>
</template>
```

To show modal in the center of the screen, use `centered` prop:
```vue
<script setup>
import InertiaModal from '@/Components/Modals/InertiaModal.vue'
</script>

<template>
    <InertiaModal centered>
        ...
    </InertiaModal>
</template>
```

To show modal full screen, use `fullscreen` prop:
```vue
<script setup>
import InertiaModal from '@/Components/Modals/InertiaModal.vue'
</script>

<template>
    <InertiaModal fullscreen>
        ...
    </InertiaModal>
</template>
```

## Inertia dialog example 

Dialog is a modal with a header and a footer. It also has a close button in the header.

```vue
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

        <template #footer="{ close }">
            <SecondaryButton tabindex="2" @click="close"> Cancel </SecondaryButton>
            <PrimaryButton class="ms-3" tabindex="1"> Save </PrimaryButton>
        </template>
    </InertiaDialog>
</template>
```

To show dialog in the center of the screen, use `centered` prop:
```vue
<script setup>
import InertiaDialog from '@/Components/Modals/InertiaDialog.vue'
</script>

<template>
    <InertiaDialog centered>
        ...
    </InertiaDialog>
</template>
```

To show dialog full screen, use `fullscreen` prop:
```vue
<script setup>
import InertiaDialog from '@/Components/Modals/InertiaDialog.vue'
</script>

<template>
    <InertiaDialog fullscreen>
        ...
    </InertiaDialog>
</template>
```

## Non inertia (onpage) modal example

Put modal on the page and show/hide it with show attribute.

```vue
<script setup>
import HeadlessModal from '@/Components/Modals/HeadlessModal.vue'
import { ref } from 'vue'

const showModal = ref(false)
</script>

<template>
    <a href="#"
       class="rounded-lg py-2 px-4 bg-slate-300 hover:bg-slate-500 hover:text-white inline-block"
       @click.prevent.stop="showModal = true"
    >Open modal</a>
    
    <HeadlessModal class="bg-white max-w-lg shadow-xl rounded-md p-8"
                   :show="showModal"
                   @close="showModal = false"
    >
        <div>Modal content</div>
    </HeadlessModal>
</template>
```

Important!!! Do not use <Link> component. Use <a> tag instead.
