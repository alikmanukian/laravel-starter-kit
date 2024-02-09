<?php

use function Pest\Laravel\get;

it('should return the correct component', function () {
    get(route('home'))
        ->assertOk()
        ->assertInertiaComponent('Home');
});
