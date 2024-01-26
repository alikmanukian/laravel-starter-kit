<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Momentum\Modal\Modal;

class ModalController extends Controller
{
    public function index(string $type): Modal
    {
        return inertia()->modal($type)->baseRoute('home');
    }
}
