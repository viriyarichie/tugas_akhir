@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('status'))
            <div class="alert alert-warning">{{ session('status') }}</div>
        @endif

        <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
            + Tambah Nota Jual
        </button>

        <table class="table">
            <thead>
                <tr>
                    <td style="font-weight:bold">ID</td>
                    <td style="font-weight:bold">Tanggal</td>
                    <td style="font-weight:bold">Dibuat Oleh</td>
                    <td style="font-weight:bold">Jenis</td>
                    <td style="font-weight:bold">Total</td>
                    <td style="font-weight:bold">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($notaJuals as $notaJual)
                    <tr id="tr_{{ $notaJual->id_nota_jual }}">
                        <td>{{ $notaJual->id_nota_jual }}</td>
                        <td id="td_tanggal_{{ $notaJual->id_nota_jual }}">{{ $notaJual->tanggal }}</td>
                        <td id="td_dibuat_{{ $notaJual->id_nota_jual }}">{{ $notaJual->user->nama ?? '-' }}</td>
                        <td id="td_jenis_{{ $notaJual->id_nota_jual }}">{{ $notaJual->jenis }}</td>
                        <td>Rp {{ number_format($notaJual->total, 0, ',', '.') }}</td>

                        <td>
                            <a href="{{ route('admin.nota-jual.show', $notaJual->id_nota_jual) }}"
                                class="btn btn-info btn-sm text-white">
                                Detail
                            </a>
                            <!-- Tombol Edit & Delete bisa Anda tambahkan belakangan jika diperlukan -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.nota-jual.store') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Nota Penjualan</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-2">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Jenis Pesanan</label>
                            <select class="form-control" name="jenis" required>
                                <option value="Dine-in">Dine-in</option>
                                <option value="Takeaway">Takeaway</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush
