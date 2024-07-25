<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Shop;
use Illuminate\Support\Facades\Log;
use Exception;



class StoreRepresentativeController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin')->only(['index', 'create', 'store', 'success']);
    }

    public function index()
    {
        try {
            $representatives = User::where('is_store_representative', true)->get();
            return view('admin.store-representatives.index', compact('representatives'));
        } catch (Exception $e) {
            Log::error('Error fetching store representatives: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }

    public function create()
    {
        try {
            $shops = Shop::all();
            return view('admin.store-representatives.create', compact('shops'));
        } catch (Exception $e) {
            Log::error('Error fetching shops: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'shop_id' => 'required|exists:shops,id',
        ]);

        $shop = Shop::find($request->shop_id);

        $user = new User();
        $user->name = $shop->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->is_store_representative = true;
        $user->shop_id = $request->shop_id;
        $user->save();

        return redirect()->route('admin.store-representatives.success')->with('message', 'Store representative created successfully.');
    }


    public function success()
    {
        try {
            return view('admin.store-representatives.success');
        } catch (Exception $e) {
            Log::error('Error displaying success page: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }
}
