<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DeliveryController extends Controller
{
    public function address(): Response
    {
        return Inertia::render('Delivery/Adress', []);
    }
}
