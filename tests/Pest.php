<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

use function Pest\Laravel\actingAs;

uses(
    TestCase::class,
    LazilyRefreshDatabase::class,
)->in('Feature');

uses()
    ->group('production')
    ->in('Feature/Jetstream');

// HELPER FUNCTIONS

function loginAsUser(?User $user = null): User
{
    $user ??= User::factory()->create();
    actingAs($user);

    return $user;
}
