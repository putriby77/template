<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $produk = Produk::findOrFail($request->id_produk);

        // Validasi stok
        if ($request->qty > $produk->stok) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = session()->get('cart', []);

        // Tambahkan produk ke keranjang
        $cart[$produk->id_produk] = [
            'id_produk' => $produk->id_produk,
            'nama_produk' => $produk->nama_produk,
            'harga' => $produk->harga,
            'qty' => $request->qty,
            'foto_produk' => $produk->foto_produk
        ];

        session()->put('cart', $cart);

        return redirect()->route('customer.cart')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('customer.cart', compact('cart'));
    }
}
