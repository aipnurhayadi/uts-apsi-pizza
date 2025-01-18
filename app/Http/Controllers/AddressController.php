<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\DeliveryTime;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function edit(Address $address)
    {
        $address = Address::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        $deliveryTimes = DeliveryTime::all();
        $outlets = Outlet::all();

        return Inertia::render('Addresses/Edit', [
            'address' => $address,
            'deliveryTimes' => $deliveryTimes,
            'outlets' => $outlets
        ]);
    }

    public function update(Request $request, Address $address)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'delivery_time_id' => 'required|exists:delivery_times,id',
            'outlet_id' => 'required|exists:outlets,id',
        ]);

        if (!$address) {
            $address = new Address();
        }

        $address->update($request->all());

        return redirect()->route('profile.edit');
    }
}
