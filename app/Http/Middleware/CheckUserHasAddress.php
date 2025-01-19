<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;

class CheckUserHasAddress
{
    /**
     * Menangani permintaan masuk dan memeriksa apakah pengguna memiliki data di tabel address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $address = Address::where('user_id', $user->id)->first();

            if (!$address) {
                return redirect()->route('address.edit');
            }
        }

        return $next($request);
    }
}
