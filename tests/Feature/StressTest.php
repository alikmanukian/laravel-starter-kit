<?php

use function Pest\Stressless\stress;

uses()->group('stress');

test('stress landing page', function () {
    $result = stress(config('app.url'))
        ->dump();

    $requests = $result->requests;

    expect($requests->failed->count)
        ->toBe(0)
        ->and($requests->duration->med)
        ->toBeLessThan(100);
});
