<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    public function index()
    {
        $user = Auth::user();


        if ($user->role !== 'merchant') {
            return redirect('/');
        }

        $products = Product::where('merchant_id', $user->id)->latest()->get();

        return view('merchant.dashboard', compact('user', 'products'));
    }

    public function storeProduct(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'merchant_id' => Auth::id(),
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
            'is_available' => true,
        ]);

        return back()->with('success', 'Menu berhasil ditambahkan!');
    }

     public function updateProduct(Request $request, $id) {
        $product = \App\Models\Product::where('id', $id)->where('merchant_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        // Update Data
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->is_available = $request->has('is_available'); // Checkbox logic

        // Ganti Gambar jika ada upload baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return back()->with('success', 'Produk berhasil diperbarui!');
    }

    // HAPUS PRODUK
    public function deleteProduct($id) {
        $product = \App\Models\Product::where('id', $id)->where('merchant_id', Auth::id())->firstOrFail();
        
        if ($product->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        return back()->with('success', 'Produk dihapus.');
    }
}
