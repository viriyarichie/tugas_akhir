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
            + Tambah User
        </button>

        <table class="table">
            <thead>
                <tr>
                    <td style="font-weight:bold">ID</td>
                    <td style="font-weight:bold">Nama User</td>
                    <td style="font-weight:bold">Email</td>
                    <td style="font-weight:bold">Role</td>
                    <td style="font-weight:bold">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr id="tr_{{ $user->id_user }}">
                        <td>{{ $user->id_user }}</td>
                        <td id="td_nama_{{ $user->id_user }}">{{ $user->nama }}</td>
                        <td id="td_email_{{ $user->id_user }}">{{ $user->email }}</td>
                        <td id="td_role_{{ $user->id_user }}">{{ $user->role }}</td>
                        <td>
                            <a href="#modalEdit" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                onclick="getEditForm({{ $user->id_user }})">Edit</a>

                            {{-- Kalau mau pakai Gate di view bisa ditambahkan can('delete-permission') ... endcan --}}
                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="if(confirm('Apakah Anda yakin ingin menghapus {{ $user->id_user }} - {{ $user->nama }}?')) deleteDataRemove({{ $user->id_user }})">
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
            <form method="POST" action="{{ route('admin.user.store') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah User Baru</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-2">
                            <label>Nama User</label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama User"
                                required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Masukkan Password"
                                required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Role</label>
                            <select class="form-control" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="manajer">Manajer</option>
                                <option value="kasir">Kasir</option>
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

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Menu</h4>
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
                url: '{{ route('admin.user.getEditForm') }}',
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
            var email = $('#email_edit').val();
            var role = $('#role_edit').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.user.saveDataUpdate') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'nama': nama,
                    'email': email,
                    'role': role
                },
                success: function(data) {
                    if (data.status == "oke") {
                        // Update UI tabel secara langsung tanpa reload!
                        $('#td_nama_' + id).html(nama);
                        $('#td_email_' + id).html(email);
                        $('#td_role_' + id).html(role);
                        $('#modalEdit').modal('hide');
                    }
                }
            });
        }

        function deleteDataRemove(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.user.deleteData') }}',
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
