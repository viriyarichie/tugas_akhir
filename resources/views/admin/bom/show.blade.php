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
            + Tambah Bahan
        </button>

        <h1>BELUM BUAT BUTTON ACTION YAA</h1>
        <h2>progress : bisa select bahan baku yang belum ada di resep ini, tapi belum bisa edit dan delete</h2>
        <table class="table">
            <thead>
                <tr>
                    <td style="font-weight:bold">ID</td>
                    <td style="font-weight:bold">Nama Bahan</td>
                    <td style="font-weight:bold">Jumlah</td>
                    <td style="font-weight:bold">Satuan</td>
                    <td style="font-weight:bold" class="text-center">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($boms as $bom)
                    <tr id="tr_{{ $bom->id_bom }}">
                        <td>{{ $bom->id_bom }}</td>
                        <td id="td_nama_{{ $bom->id_bom }}">{{ $bom->bahanBaku->nama_bahan ?? '-' }}</td>
                        <td id="td_jumlah_{{ $bom->id_bom }}">{{ $bom->jumlah_bahan ?? '-' }}</td>
                        <td id="td_satuan_{{ $bom->id_bom }}">{{ $bom->satuan->idsatuan ?? '-' }}</td>
                        <td class="text-center">
                            <a href="#modalEdit" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                onclick="getEditForm({{ $bom->id_bom }})">Edit</a>

                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="if(confirm('Apakah Anda yakin ingin menghapus {{ $bom->id_bom }} - {{ $bom->bahanBaku->nama_bahan }}?')) deleteDataRemove({{ $bom->id_bom }})">
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
            <form method="POST" action="{{ route('admin.bom.store') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Bahan Baru</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id_menu" value="{{ $selectedMenu->id_menu }}">
                        <div class="form-group mb-2">
                            <label>Bahan Baku</label>
                            <select class="form-control" name="id_bahan" required>
                                <option value="">Pilih Bahan Baku</option>
                                @foreach ($bahanBakus as $bahan)
                                    <option value="{{ $bahan->id_bahan }}">{{ $bahan->nama_bahan }} ({{ $bahan->idsatuan }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Jumlah</label>
                            <input type="number" step="0.01" class="form-control" name="jumlah_bahan" placeholder="Masukkan Jumlah" required>
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
                    <h4 class="modal-title">Edit BOM</h4>
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
                url: '{{ route('admin.bom.getEditForm') }}',
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
            var jumlah = $('#jumlah_edit').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.bom.saveDataUpdate') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'jumlah_bahan': jumlah
                },
                success: function(data) {
                    if (data.status == "oke") {
                        // Update UI tabel secara langsung tanpa reload!
                        $('#td_jumlah_' + id).html(jumlah);
                        $('#modalEdit').modal('hide');
                    }
                }
            });
        }

        function deleteDataRemove(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.bom.deleteData') }}',
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
