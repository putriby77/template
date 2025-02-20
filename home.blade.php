<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home - Toko Online</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Styling untuk bagian hero */
    .hero {
      background: url('https://via.placeholder.com/1500x500') no-repeat center center;
      background-size: cover;
      color: #fff;
      padding: 100px 0;
      text-align: center;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="{{ route('customer.home') }}">Toko Online</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('customer.home') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('customer.login') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('customer.register') }}">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('customer.cart') }}">Keranjang ({{ session('cart') ? count(session('cart')) : 0 }})</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="hero">
    <div class="container">
      <h1 class="display-4">Selamat Datang di Toko Online</h1>
      <p class="lead">Dapatkan produk terbaik dengan harga terjangkau!</p>
      <a href="#produk-unggulan" class="btn btn-primary btn-lg">Lihat Produk</a>
    </div>
  </div>

  <!-- Produk Unggulan -->
  <div class="container my-5" id="produk-unggulan">
    <h2 class="mb-4">Produk Unggulan</h2>
    <div class="row">
      @foreach($produkUnggulan as $item)
        <div class="col-md-4">
          <div class="card mb-4">
            <img src="{{ $item->foto_produk }}" class="card-img-top" alt="{{ $item->nama_produk }}">
            <div class="card-body">
              <h5 class="card-title">{{ $item->nama_produk }}</h5>
              <p class="card-text">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
              
              <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="id_produk" value="{{ $item->id_produk }}">
                <div class="mb-2">
                  <label for="qty" class="form-label">Jumlah:</label>
                  <input type="number" name="qty" value="1" min="1" max="{{ $item->stok }}" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Beli Sekarang</button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white py-4">
    <div class="container text-center">
      <p>&copy; {{ date('Y') }} Toko Online</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
