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

        return Inertia::render('Address/Edit', [
            'address' => $address,
            'deliveryTimes' => $deliveryTimes,
            'outlets' => $outlets
        ]);
    }

    public function update(Request $request, Address $address)
    {
        try {

            $request->validate([
                'location' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'delivery_time_id' => 'required|exists:delivery_times,id',
                'outlet_id' => 'required|exists:outlets,id',
            ]);

            $userId = Auth::id();
            $request->merge(['user_id' => $userId]);

            if (!$address->exists) {
                $address = new Address();
                $address->create($request->all());
            } else {
                $address->update($request->all());
            }
            return redirect()->route('shop.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errorMessage' => $e->getMessage()]);
        }
    }
}
