<?php

namespace App\Http\Controllers;

class ModalController extends Controller
{
    public function index($type)
    {
        return inertia()->modal($type)->baseRoute('home');
    }
}
