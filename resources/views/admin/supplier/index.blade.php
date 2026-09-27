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
            + Tambah Supplier
        </button>

        <table class="table">
            <thead>
                <tr>
                    <td style="font-weight:bold">ID</td>
                    <td style="font-weight:bold">Nama </td>
                    <td style="font-weight:bold">Kontak</td>
                    <td style="font-weight:bold">Alamat</td>
                    <td style="font-weight:bold">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr id="tr_{{ $supplier->id_supplier }}">
                        <td>{{ $supplier->id_supplier }}</td>
                        <td id="td_nama_{{ $supplier->id_supplier }}">{{ $supplier->nama_supplier }}</td>
                        <td id="td_kontak_{{ $supplier->id_supplier }}">{{ $supplier->kontak }}</td>
                        <td id="td_alamat_{{ $supplier->id_supplier }}">{{ $supplier->alamat }}</td>
                        <td>
                            <a href="#modalEdit" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                onclick="getEditForm({{ $supplier->id_supplier }})">Edit</a>

                            {{-- Kalau mau pakai Gate di view bisa ditambahkan can('delete-permission') ... endcan --}}
                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="if(confirm('Apakah Anda yakin ingin menghapus {{ $supplier->id_supplier }} - {{ $supplier->nama_supplier }}?')) deleteDataRemove({{ $supplier->id_supplier }})">
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('modals')
    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.supplier.store') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Supplier Baru</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-2">
                            <label>Nama Supplier</label>
                            <input type="text" class="form-control" name="nama_supplier"
                                placeholder="Masukkan Nama Supplier" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Kontak</label>
                            <input type="number" class="form-control" name="kontak" placeholder="Masukkan Kontak"
                                required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Alamat</label>
                            <input type="text" class="form-control" name="alamat" placeholder="Masukkan Alamat"
                                required>
                        </div>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Supplier</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- ID diganti modalContent sesuai pola lama -->
                <div class="modal-body" id="modalContent"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <script>
        function getEditForm(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.supplier.getEditForm') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    $('#modalContent').html(data.msg);
                }
            });
        }

        function saveDataUpdate(id) {
            var nama = $('#nama_edit').val();
            var kontak = $('#kontak_edit').val();
            var alamat = $('#alamat_edit').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.supplier.saveDataUpdate') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'nama_supplier': nama,
                    'kontak': kontak,
                    'alamat': alamat
                },
                success: function(data) {
                    if (data.status == "oke") {
                        // Update UI tabel secara langsung tanpa reload!
                        $('#td_nama_' + id).html(nama);
                        $('#td_kontak_' + id).html(kontak);
                        $('#td_alamat_' + id).html(alamat);
                        $('#modalEdit').modal('hide');
                    }
                }
            });
        }

        function deleteDataRemove(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.supplier.deleteData') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    if (data.status == "oke") {
                        // Hapus baris dari UI tabel secara langsung tanpa reload!
                        $('#tr_' + id).remove();
                    } else {
                        alert(data.msg); // Jika gagal (misal karena constraint FK)
                    }
                }
            });
        }
    </script>
@endpush
