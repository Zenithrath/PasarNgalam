<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;

class ProfileController extends Controller
{
    /**
     * Halaman profil user
     */
    public function show()
    {
        $user = Auth::user();

        // Ambil seluruh order user (untuk customer)
        $orders = Order::where('customer_id', $user->id)
            ->with('merchant')
            ->latest()
            ->get();

        $orders_count = $orders->count();
        $total_spent = $orders
            ->where('status', 'completed')
            ->sum(function ($order) {
                return $order->total_price + $order->delivery_fee;
            });

        return view('customer.profile', compact('user', 'orders_count', 'total_spent', 'orders'));
    }

    /**
     * Update Profil user (merchant, customer, driver)
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ==========================
        // VALIDATION DYNAMIC
        // ==========================
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'phone' => 'required|string',
            'address' => 'nullable|string',

            // File upload
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];

        if ($user->role === 'merchant') {
            $rules['store_name'] = 'required|string|max:255';
            $rules['store_banner'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120';
        }

        if ($user->role === 'driver') {
            $rules['vehicle_plate'] = 'required|string|max:20';
        }

        $request->validate($rules);

        // ==========================
        // UPDATE BASIC INFO
        // ==========================
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // ==========================
        // UPLOAD PROFILE PICTURE
        // ==========================
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $user->profile_picture = $request->file('profile_picture')->store('profiles', 'public');
        }

        // ==========================
        // MERCHANT ONLY
        // ==========================
        if ($user->role === 'merchant') {
            $user->store_name = $request->store_name;

            // Upload Banner
            if ($request->hasFile('store_banner')) {
                if ($user->banner && Storage::disk('public')->exists($user->banner)) {
                    Storage::disk('public')->delete($user->banner);
                }

                $user->banner = $request->file('store_banner')->store('banners', 'public');
            }
        }

        // ==========================
        // DRIVER ONLY
        // ==========================
        if ($user->role === 'driver') {
            $user->vehicle_plate = $request->vehicle_plate;
        }

        // ==========================
        // SAVE
        // ==========================
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
