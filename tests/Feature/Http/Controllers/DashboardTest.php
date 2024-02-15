<?php

use function Pest\Laravel\get;

it('does not allow guests', function () {
    get(route('dashboard'))
        ->assertRedirect(route('login'));
});

it('should return the correct component', function () {
    loginAsUser();

    get(route('dashboard'))
        ->assertOk()
        ->assertInertiaComponent('Dashboard');
});
