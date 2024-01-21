## Modal example 
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
    <InertiaModal>
        <div class="bg-white max-w-lg shadow-xl rounded-md p-8">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquid
            amet atque dolor, itaque, maxime minima mollitia nemo nesciunt nisi
            obcaecati odio placeat porro, quod repellat reprehenderit sequi ut
            voluptas!
        </div>
    </InertiaModal>
</template>
```

To show modal in the center of the screen, use `centered` prop:
```vue
<template>
    <InertiaModal centered>
        ...
    </InertiaModal>
</template>
```

## Dialog example 

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

        <template #footer>
            <SecondaryButton tabindex="2"> Cancel </SecondaryButton>
            <PrimaryButton class="ms-3" tabindex="1"> Save </PrimaryButton>
        </template>
    </InertiaDialog>
</template>
```

To show dialog in the center of the screen, use `centered` prop:
```vue
<template>
    <InertiaDialog centered>
        ...
    </InertiaDialog>
</template>
```
