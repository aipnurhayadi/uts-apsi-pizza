<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTime;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DeliveryController extends Controller
{
    public function address(): Response
    {
        $delivery_times = DeliveryTime::all();
        $outlets = Outlet::all();
        return Inertia::render('Delivery/Adress', compact('delivery_times', 'outlets'));
    }
}
