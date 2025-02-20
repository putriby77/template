@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Checkout</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Informasi Produk</h4>
                </div>
                <div class="card-body">
                    <p><strong>Nama Produk:</strong> {{ $produk->nama_produk }}</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <p><strong>Jumlah:</strong> {{ $qty }}</p>
                    <p><strong>Total:</strong> Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4>Informasi Pelanggan</h4>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $pelanggan->nama_pelanggan }}</p>
                    <p><strong>Alamat:</strong> {{ $pelanggan->alamat }}</p>
                    <p><strong>No HP:</strong> {{ $pelanggan->no_hp }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Pembayaran</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('payment.process', ['id_transaksi' => $id_transaksi]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="Dana">Dana</option>
                                <option value="GoPay">GoPay</option>
                                <option value="OVO">OVO</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Bayar Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
