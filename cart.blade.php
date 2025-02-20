@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<h2>Keranjang Belanja</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(empty($cart))
    <p>Keranjang belanja Anda kosong.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cart as $item)
                <tr>
                    <td>{{ $item['nama_produk'] }}</td>
                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</td>
                </tr>
                @php $total += $item['harga'] * $item['qty']; @endphp
            @endforeach
            <tr>
                <td colspan="3" class="text-end"><strong>Total Bayar:</strong></td>
                <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('checkout') }}" class="btn btn-success">Lanjutkan ke Pembayaran</a>
@endif
@endsection
