<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'cart_data' => 'required',
            'delivery_address' => 'required',
            'total_amount' => 'required'
        ]);

        $cart = json_decode($request->cart_data, true);

 
        if (isset($cart[0]['merchant_id'])) {
            $merchantId = $cart[0]['merchant_id'];
        } else {
            $randomMerchant = User::where('role', 'merchant')->first();
            $merchantId = $randomMerchant ? $randomMerchant->id : 1;
        }

        $lat = $request->latitude ?? -7.9666;
        $lng = $request->longitude ?? 112.6326;


        $assignedDriver = User::select("users.*")
            ->selectRaw("(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
            ->where('role', 'driver')
            ->where('is_online', true)
            ->having('distance', '<', 10) 
            ->orderBy('distance', 'asc')
            ->first();


        if (!$assignedDriver) {
            $assignedDriver = User::where('role', 'driver')->first();
        }


        Order::create([
            'customer_id' => Auth::id() ?? 1,
            'merchant_id' => $merchantId,
            'driver_id'   => $assignedDriver ? $assignedDriver->id : null, 
            'delivery_address' => $request->delivery_address,
            'dest_latitude' => $lat,
            'dest_longitude' => $lng,
            'total_price' => $request->total_amount,
            'delivery_fee' => 5000,
            'status' => 'pending' 
        ]);

        return redirect('/')->with('success', 'Order Berhasil! Cek Dashboard Driver & Merchant sekarang.');
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        return back()->with('success', 'Status pesanan diperbarui!');
    }
}