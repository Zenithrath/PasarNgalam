<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  public function update(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6',
            'store_name' => 'nullable|string',
            'phone' => 'required|string',
            'vehicle_plate' => 'nullable|string',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($user->role === 'merchant') {
            $user->store_name = $request->store_name;
        } elseif ($user->role === 'driver') {
            $user->vehicle_plate = $request->vehicle_plate;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}