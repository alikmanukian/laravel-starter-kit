## Flash message in toast components

```php
class SomeController extends Controller
{
    public function store()
    {
        // ...
        return redirect()->route('some.route')->with('toast', 'Something went wrong!');
    }
}
```
