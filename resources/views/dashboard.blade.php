@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2>Dashboard</h2>

    <section>
        <h3>Ringkasan</h3>
        <ul>
            <li>Total Bahan Baku: 0</li>
            <li>Penjualan Hari Ini: Rp 0</li>
            <li>Stok Menipis: 0</li>
            <li>Total Menu: 0</li>
        </ul>
    </section>

    <section>
        <h3>Grafik Penjualan Terakhir</h3>
        <p>Data belum tersedia.</p>
    </section>

    <section>
        <h3>Aktivitas Terakhir</h3>
        <ul>
            <li>Belum ada aktivitas</li>
        </ul>
    </section>

    <section>
    <h3>Link</h3>
        <ul>
            <li>
                <a href="{{ route('admin.kategori-menu.index') }}">Kategori Menu</a>
            </li>
            <li>
                <a href="{{ route('admin.menu.index') }}">Menu</a>
            </li>
            <li>
                <a href="{{ route('admin.satuan.index') }}">Satuan</a>
            </li>
                      <li>
                <a href="{{ route('admin.bahan-baku.index') }}">Bahan Baku</a>
            </li>
                      <li>
                <a href="{{ route('admin.supplier.index') }}">Supplier</a>
            </li>
                      <li>
                <a href="{{ route('admin.user.index') }}">User</a>
            </li>
        </ul>
    </section>
@endsection
