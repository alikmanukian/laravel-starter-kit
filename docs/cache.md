## Caching with stale-while-revalidate strategy
Sometimes you want to cache a response for a short period of time, but you also want to make sure that the cache is always up-to-date. This is where the stale-while-revalidate strategy comes in handy.
```php
Cache::staleWhileRevalidate(
    key: 'users',
    ttl: [
        now()->addHour(), // fresh
        now()->addWeek(), // stale
    ],
    callback: fn() => User::all()
);
```
