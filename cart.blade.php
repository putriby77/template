@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2>Keranjang Belanja</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($keranjang as $item)
                @php $subtotal = $item->produk->harga * $item->qty; @endphp
                <tr>
                    <td><img src="{{ $item->produk->foto_produk }}" alt="{{ $item->produk->nama_produk }}" width="80"></td>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                @php $total += $subtotal; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-end"><strong>Total Bayar:</strong></td>
                <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <form action="{{ route('checkout') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_ongkir" class="form-label">Pilih Ongkir</label>
            <select name="id_ongkir" id="id_ongkir" class="form-control" required>
                <option value="">-- Pilih Ongkir --</option>
                <option value="1">JNE - Rp 10.000</option>
                <option value="2">J&T - Rp 12.000</option>
                <option value="3">SiCepat - Rp 9.000</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Checkout</button>
    </form>
</div>
@endsection
