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
            + Tambah Bahan Baku
        </button>

        <table class="table">
            <thead>
                <tr>
                    <td style="font-weight:bold">ID</td>
                    <td style="font-weight:bold">Nama</td>
                    <td style="font-weight:bold">Stok</td>
                    <td style="font-weight:bold">Satuan</td>
                    <td style="font-weight:bold">Stok On Order Customer</td>
                    <td style="font-weight:bold">Stok On Order Supplier</td>
                    <td style="font-weight:bold">Kategori</td>

                    <td style="font-weight:bold">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($bahanBakus as $bahanBaku)
                    <tr id="tr_{{ $bahanBaku->id }}">
                        <td>{{ $bahanBaku->id_bahan }}</td>
                        <td id="td_nama_{{ $bahanBaku->id_bahan }}">{{ $bahanBaku->nama_bahan }}</td>
                        <td id="td_stok_{{ $bahanBaku->id_bahan }}">{{ $bahanBaku->total_stok }}</td>
                        <td id="td_satuan_{{ $bahanBaku->id_bahan }}">{{ $bahanBaku->satuan->satuan }}</td>
                        <td id="td_on_order_customer_{{ $bahanBaku->id_bahan }}">{{ $bahanBaku->stok_onorder_customer }}
                        </td>
                        <td id="td_on_order_supplier_{{ $bahanBaku->id_bahan }}">{{ $bahanBaku->stok_onorder_supplier }}
                        </td>
                        <td id="td_kategori_{{ $bahanBaku->id_bahan }}">{{ $bahanBaku->kategori }}</td>
                        <td>
                            <a href="#modalEdit" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                onclick="getEditForm({{ $bahanBaku->id_bahan }})">Edit</a>

                            {{-- Kalau mau pakai Gate di view bisa ditambahkan can('delete-permission') ... endcan --}}
                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="if(confirm('Apakah Anda yakin ingin menghapus {{ $bahanBaku->id_bahan }} - {{ $bahanBaku->nama_bahan }}?')) deleteDataRemove({{ $bahanBaku->id_bahan }})">
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
            <form method="POST" action="{{ route('admin.bahan-baku.store') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Bahan Baku Baru</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-2">
                            <label>Nama Bahan Baku</label>
                            <input type="text" class="form-control" name="nama_bahan"
                                placeholder="Masukkan Nama Bahan Baku" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Stok</label>
                            <input type="number" class="form-control" name="total_stok" placeholder="Masukkan Stok"
                                required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Satuan</label>
                            <select class="form-control" name="idsatuan" required>
                                <option value="">Pilih Satuan</option>
                                @foreach ($satuans as $satuan)
                                    <option value="{{ $satuan->idsatuan }}">{{ $satuan->satuan }}
                                        ({{ $satuan->idsatuan }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label>Stok On Order Customer</label>
                            <input type="number" class="form-control" name="stok_onorder_customer"
                                placeholder="Masukkan Stok On Order Customer" required>
                        </div>

                        <div class="form-group mb-2">
                            <label>Stok On Order Supplier</label>
                            <input type="number" class="form-control" name="stok_onorder_supplier"
                                placeholder="Masukkan Stok On Order Supplier" required>
                        </div>

                        <div class="form-group mb-2">
                            <label>Kategori</label>
                            <select class="form-control" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="utama">Bahan Utama</option>
                                <option value="pendukung">Bahan Pendukung</option>
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
                    <h4 class="modal-title">Edit Bahan Baku</h4>
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
                url: '{{ route('admin.bahan-baku.getEditForm') }}',
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
            var nama_bahan = $('#nama_edit').val();
            var total_stok = $('#total_stok_edit').val();
            var idsatuan = $('#idsatuan_edit').val();
            var stok_onorder_customer = $('#stok_onorder_customer_edit').val();
            var stok_onorder_supplier = $('#stok_onorder_supplier_edit').val();
            var kategori = $('#kategori_edit').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.bahan-baku.saveDataUpdate') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'nama_bahan': nama_bahan,
                    'total_stok': total_stok,
                    'idsatuan': idsatuan,
                    'stok_onorder_customer': stok_onorder_customer,
                    'stok_onorder_supplier': stok_onorder_supplier,
                    'kategori': kategori
                },
                success: function(data) {
                    if (data.status == "oke") {
                        // Update UI tabel secara langsung tanpa reload!
                        $('#td_nama_' + id).html(nama_bahan);
                        $('#td_stok_' + id).html(total_stok);
                        $('#td_satuan_' + id).html($('#idsatuan_edit option:selected').text());
                        $('#td_on_order_customer_' + id).html(stok_onorder_customer);
                        $('#td_on_order_supplier_' + id).html(stok_onorder_supplier);
                        $('#td_kategori_' + id).html($('#kategori_edit option:selected').text());
                        $('#modalEdit').modal('hide');
                    }
                }
            });
        }

        function deleteDataRemove(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.bahan-baku.deleteData') }}',
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
