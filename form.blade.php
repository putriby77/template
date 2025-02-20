@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2>Proses Pembayaran</h2>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Total Pembayaran: Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</h5>
            <p>Silakan pilih metode pembayaran:</p>

            <form action="{{ route('payment.process', $transaksi->id_transaksi) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="metode" class="form-label">Metode Pembayaran</label>
                    <select name="metode" id="metode" class="form-control" required>
                        <option value="">-- Pilih Metode Pembayaran --</option>
                        <option value="gopay">GoPay</option>
                        <option value="dana">Dana</option>
                        <option value="ovo">OVO</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Bayar Sekarang</button>
            </form>
        </div>
    </div>
</div>
@endsection

