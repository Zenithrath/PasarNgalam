<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function index() {
        $user = Auth::user();


        if ($user->role !== 'driver') {
            return redirect('/');
        }
        

        $availableOrders = Order::where('status', 'ready')
                                ->whereNull('driver_id')
                                ->with('merchant') 
                                ->get();

        $activeOrder = Order::where('driver_id', $user->id)
                            ->whereIn('status', ['delivery'])
                            ->with('merchant')
                            ->first();

        return view('driver.dashboard', compact('user', 'availableOrders', 'activeOrder'));
    }

    public function takeOrder($id) {
        $order = Order::find($id);
        $order->update([
            'driver_id' => Auth::id(),
            'status' => 'delivery'
        ]);

        return back()->with('success', 'Order berhasil diambil!');
    }

    // Driver selesaikan order
    public function completeOrder($id) {
        $order = Order::where('id', $id)->where('driver_id', Auth::id())->first();
        
        if($order) {
            $order->update(['status' => 'completed']);
        }

        return back()->with('success', 'Pekerjaan selesai! Saldo bertambah.');
    }
}