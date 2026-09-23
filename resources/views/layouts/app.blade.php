<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Informasi')</title>
</head>
<body>

    <header>
        <h1>Sistem Informasi</h1>
        <p>Welcome, Admin</p>
    </header>

    <nav>
        <h2>Menu Utama</h2>
        <ul>
            <li><a href="{{ url('/') }}">Dashboard</a></li>
            <li><a href="#">Kategori Menu</a></li>
            <li><a href="#">Menu</a></li>
            <li><a href="#">Bahan Baku</a></li>
            <li><a href="#">Supplier</a></li>
            <li><a href="#">Pembelian</a></li>
            <li><a href="#">Penjualan</a></li>
            <li><a href="#">Prediksi</a></li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>
