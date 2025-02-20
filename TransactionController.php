<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Detailtransaksi;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        // Misal, data keranjang disimpan dalam session
        $cart = session('cart', []);
        
        DB::beginTransaction();
        try {
            // Buat data transaksi
            $transaksi = Transaksi::create([
                'tanggal_transaksi' => now(),
                'total_bayar' => 0, // akan diupdate kemudian
                'id_pelanggan' => auth()->guard('pelanggan')->user()->id_pelanggan,
                'id_ongkir' => $request->id_ongkir,
                'keterangan' => 'diproses'
            ]);
            
            $totalBayar = 0;
            
            foreach ($cart as $item) {
                $produk = Produk::findOrFail($item['id_produk']);
                
                // Jika stok tidak mencukupi
                if ($produk->stok < $item['qty']) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi.');
                }
                
                // Kurangi stok produk
                $produk->stok -= $item['qty'];
                $produk->save();
                
                $subtotal = $produk->harga * $item['qty'];
                Detailtransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_produk' => $produk->id_produk,
                    'harga_produk' => $produk->harga,
                    'jumlah_produk' => $item['qty'],
                    'subtotal' => $subtotal,
                    'qty' => $item['qty']
                ]);
                
                $totalBayar += $subtotal;
            }
            
            // Update total bayar pada transaksi
            $transaksi->total_bayar = $totalBayar;
            $transaksi->save();
            
            DB::commit();
            
            // Redirect ke halaman pembayaran (integrasi e-payment dilakukan di PaymentController)
            return redirect()->route('payment.form', ['id_transaksi' => $transaksi->id_transaksi]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat proses transaksi.');
        }
    }
    public function showCheckout($id_transaksi, Request $request)
{
    $transaksi = Transaksi::findOrFail($id_transaksi);
    $pelanggan = auth()->guard('pelanggan')->user();
    $detailTransaksi = Detailtransaksi::where('id_transaksi', $id_transaksi)->first();
    $produk = Produk::findOrFail($detailTransaksi->id_produk);

    $qty = $detailTransaksi->qty;
    $total = $produk->harga * $qty;

    return view('customer.checkout', compact('produk', 'qty', 'total', 'pelanggan', 'id_transaksi'));
}
}
