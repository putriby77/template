@extends('layouts.app')

@section('content')
<div class="container my-5 text-center">
    <h2>Pembayaran Berhasil!</h2>
    <p>Terima kasih telah melakukan pembelian. Pesanan Anda sedang diproses.</p>
    <a href="{{ route('customer.home') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection
