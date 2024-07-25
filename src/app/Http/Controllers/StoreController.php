<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $shop = Shop::find($user->shop_id);


        if (!$shop) {
            return redirect()->route('stores.dashboard')->with('error', 'Store not found.');
        }

        $reservations = Reservation::where('shop_id', $shop->id)->with('user')->get();

        return view('stores.index', compact('shop', 'reservations'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $shop = Shop::find($user->shop_id);


        if (!$shop) {
            return redirect()->route('stores.dashboard')->with('error', 'Store not found.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $shop->name = $request->name;
        $shop->about = $request->about;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $shop->photo = $path;
        }

        $shop->save();

        return redirect()->route('stores.dashboard')->with('success', 'Store information updated successfully.');
    }
}
