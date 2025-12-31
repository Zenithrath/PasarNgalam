<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderActivity;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MerchantController extends Controller
{
    public function getRecentOrders(Request $request)
    {
        $user = Auth::user();
        $lastCheck = $request->query('last_check', 0);

        $recentOrders = Order::where('merchant_id', $user->id)
            ->whereIn('status', ['pending', 'cooking', 'ready'])
            ->where('created_at', '>', now()->subMinutes(5))
            ->with(['customer', 'driver'])
            ->orderBy('created_at', 'desc')
            ->get();

        $newOrders = $recentOrders->filter(function ($order) use ($lastCheck) {
            return $order->created_at->timestamp > $lastCheck;
        });

        return response()->json([
            'has_new' => count($newOrders) > 0,
            'new_orders' => $newOrders,
            'all_pending_count' => Order::where('merchant_id', $user->id)
                ->where('status', 'pending')
                ->count()
        ]);
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'merchant') return redirect('/');

        $products = Product::where('merchant_id', $user->id)->latest()->get();

        $incomingOrders = Order::where('merchant_id', $user->id)
            ->whereIn('status', ['pending', 'cooking', 'ready'])
            ->with('driver')
            ->latest()
            ->get();

        $totalRevenue = Order::where('merchant_id', $user->id)
            ->where('status', 'completed')
            ->sum('total_price');

        $revenueThisMonth = Order::where('merchant_id', $user->id)
            ->where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_price');

        $revenueToday = Order::where('merchant_id', $user->id)
            ->where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_price');

        $orderHistory = Order::where('merchant_id', $user->id)
            ->where('status', 'completed')
            ->with(['customer', 'driver'])
            ->latest()
            ->limit(50)
            ->get();

        $merchantOrderIds = Order::where('merchant_id', $user->id)->pluck('id');

        $recentActivities = OrderActivity::whereIn('order_id', $merchantOrderIds)
            ->latest()
            ->limit(20)
            ->get();

        // 🔥 Ambil review customer
        $reviews = Review::where('target_id', $user->id)
            ->with('reviewer')
            ->orderBy('created_at', 'desc')
            ->get();

        // =============================
        // ⭐ RATING SUMMARY
        // =============================
        $ratingCount = $reviews->count();
        $ratingAvg = $reviews->avg('rating') ?? 5;
        $ratingAvg = number_format($ratingAvg, 1);

        $ratingBreakdown = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        return view('merchant.dashboard', compact(
            'user',
            'products',
            'incomingOrders',
            'totalRevenue',
            'revenueThisMonth',
            'revenueToday',
            'orderHistory',
            'recentActivities',
            'reviews',
            'ratingCount',
            'ratingAvg',
            'ratingBreakdown'
        ));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('products', 'public')
            : null;

        Product::create([
            'merchant_id' => Auth::id(),
            'name' => $request->name,
            'price' => $request->price,
            'description' => strip_tags($request->description), // Security: Sanitize Input
            'image' => $imagePath,
            'category' => $request->category ?? 'Makanan Berat',
            'addons' => json_decode($request->addons, true) ?? [],
            'is_available' => true,
        ]);

        return back()->with('success', 'Menu berhasil ditambahkan!');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::where('id', $id)
            ->where('merchant_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $product->fill([
            'name' => $request->name,
            'price' => $request->price,
            'description' => strip_tags($request->description), // Security: Sanitize Input
            'category' => $request->category,
            'addons' => json_decode($request->addons, true) ?? [],
            'is_available' => $request->has('is_available'),
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return back()->with('success', 'Menu berhasil diperbarui!');
    }

    public function deleteProduct($id)
    {
        $product = Product::where('id', $id)
            ->where('merchant_id', Auth::id())
            ->firstOrFail();

        if ($product->image) Storage::disk('public')->delete($product->image);

        $product->delete();

        return back()->with('success', 'Menu dihapus.');
    }

    public function countPendingOrders()
    {
        $count = Order::where('merchant_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        return response()->json(['count' => $count]);
    }

    public function getPendingOrdersApi()
    {
        $orders = Order::where('merchant_id', Auth::id())
            ->where('status', 'pending')
            ->with('customer')
            ->latest()
            ->get();

        return response()->json([
            'count' => $orders->count(),
            'orders' => $orders
        ]);
    }
}
