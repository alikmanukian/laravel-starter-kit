<?php

use App\Http\Controllers\Controller;

uses()->group('arch');

it('looks for missing debugging statements')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();

it('does not use validator facade')
    ->expect(\Illuminate\Support\Facades\Validator::class)
    ->not->toBeUsed()
    ->ignoring('App\Actions\Fortify')
    ->ignoring('App\Actions\Jetstream');

test('strict types')
    ->expect('App')
    ->toUseStrictTypes();

test('controllers')
    ->expect('App\Http\Controllers')
    ->toHaveSuffix('Controller')
    ->toExtend(Controller::class);

test('resources')
    ->expect('App\Http\Resources')
    ->toHaveSuffix('Resource');

test('policies')
    ->expect('App\Policies')
    ->toHaveSuffix('Policy');

test('providers')
    ->expect('App\Providers')
    ->toHaveSuffix('Provider');

test('jobs')
    ->expect('App\Jobs')
    ->toHaveSuffix('Job');

test('commands')
    ->expect('App\Console\Commands')
    ->toHaveSuffix('Command');
