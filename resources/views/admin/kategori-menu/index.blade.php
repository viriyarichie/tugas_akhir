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
            + Tambah Kategori
        </button>

        <table class="table">
            <thead>
                <tr>
                    <td style="font-weight:bold">ID</td>
                    <td style="font-weight:bold">Nama Kategori</td>
                    <td style="font-weight:bold">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategoriMenus as $kategoriMenu)
                    <tr id="tr_{{ $kategoriMenu->idkategori_menu }}">
                        <td>{{ $kategoriMenu->idkategori_menu }}</td>
                        <td id="td_nama_{{ $kategoriMenu->idkategori_menu }}">{{ $kategoriMenu->nama_kategori }}</td>
                        <td>
                            <a href="#modalEdit" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                onclick="getEditForm({{ $kategoriMenu->idkategori_menu }})">Edit</a>

                            {{-- Kalau mau pakai Gate di view bisa ditambahkan can('delete-permission') ... endcan --}}
                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="if(confirm('Apakah Anda yakin ingin menghapus {{ $kategoriMenu->idkategori_menu }} - {{ $kategoriMenu->nama_kategori }}?')) deleteDataRemove({{ $kategoriMenu->idkategori_menu }})">
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
            <form method="POST" action="{{ route('admin.kategori-menu.store') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Kategori Menu Baru</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-2">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Kategori"
                                required>
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

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Kategori Menu</h4>
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
                url: '{{ route('admin.kategori-menu.getEditForm') }}',
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

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.kategori-menu.saveDataUpdate') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'nama': nama,
                },
                success: function(data) {
                    if (data.status == "oke") {
                        // Update UI tabel secara langsung tanpa reload!
                        $('#td_nama_' + id).html(nama);
                        $('#modalEdit').modal('hide');
                    }
                }
            });
        }

        function deleteDataRemove(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.kategori-menu.deleteData') }}',
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
