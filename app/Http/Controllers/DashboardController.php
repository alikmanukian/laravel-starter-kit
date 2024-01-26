<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return inertia('Dashboard');
    }
}
