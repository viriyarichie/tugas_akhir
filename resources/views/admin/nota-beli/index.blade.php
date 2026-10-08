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
            + Tambah Nota Beli
        </button>

        <table class="table">
            <thead>
                <tr>
                    <td style="font-weight:bold">ID</td>
                    <td style="font-weight:bold">Tanggal</td>
                    <td style="font-weight:bold">Supplier</td>
                    <td style="font-weight:bold">Dibuat Oleh</td>
                    <td style="font-weight:bold">Total</td>
                    <td style="font-weight:bold">Status Pembayaran</td>
                    <td style="font-weight:bold">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($notaBelis as $notaBeli)
                    <tr id="tr_{{ $notaBeli->id_nota_beli }}">
                        <td>{{ $notaBeli->id_nota_beli }}</td>
                        <td id="td_tanggal_{{ $notaBeli->id_nota_beli }}">{{ $notaBeli->tanggal }}</td>
                        <td id="td_supplier_{{ $notaBeli->id_nota_beli }}">{{ $notaBeli->supplier->nama_supplier ?? '-' }}
                        </td>
                        <td id="td_dibuat_{{ $notaBeli->id_nota_beli }}">{{ $notaBeli->user->nama ?? '-' }}</td>

                        @php
                            $grandTotal = $notaBeli->detailPembelian->sum('harga_total');
                            $terbayar = $notaBeli->pembayaranPembelian->sum('jumlah_bayar');
                        @endphp

                        <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                        <td class="text-center" id="td_status_{{ $notaBeli->id_nota_beli }}">
                            @if ($grandTotal == 0)
                                <span class='badge bg-secondary'>Nota kosong</span>
                            @elseif ($terbayar == $grandTotal)
                                <span class='badge bg-success'>Lunas</span>
                            @else
                                <span class='badge bg-danger'>Hutang</span>
                            @endif
                        </td>

                        <td>
                            @if ($terbayar < $grandTotal && $grandTotal > 0)
                                <a href="#modalBayar" class="btn btn-primary btn-sm"
                                    id= "btn_bayar_{{ $notaBeli->id_nota_beli }}" data-bs-toggle="modal"
                                    onclick="getBayarForm({{ $notaBeli->id_nota_beli }})">Bayar</a>
                            @endif

                            <a href="{{ route('admin.nota-beli.show', $notaBeli->id_nota_beli) }}"
                                class="btn btn-info btn-sm text-white">
                                Detail
                            </a>
                            <a href="#modalEdit" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                onclick="getEditForm({{ $notaBeli->id_nota_beli }})">Edit</a>


                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="if(confirm('Apakah Anda yakin ingin menghapus {{ $notaBeli->id_nota_beli }} - {{ $notaBeli->tanggal }}?')) deleteDataRemove({{ $notaBeli->id_nota_beli }})">
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
            <form method="POST" action="{{ route('admin.nota-beli.store') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Nota Beli Baru</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-2">
                            <label>Tanggal Pembelian</label>
                            <input type="date" class="form-control" name="tanggal"
                                placeholder="Masukkan Tanggal Pembelian" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Supplier</label>
                            <select class="form-control" name="id_supplier" required>
                                <option value="">Pilih Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id_supplier }}">{{ $supplier->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>
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
                    <h4 class="modal-title">Edit Nota beli</h4>
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

    <div class="modal fade" id="modalBayar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kasir Pembayaran Supplier</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="modalContentBayar"></div>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <script>
        function getEditForm(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.nota-beli.getEditForm') }}',
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
            var tanggal = $('#tanggal_edit').val();
            var supplier = $('#supplier_edit').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.nota-beli.saveDataUpdate') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'tanggal': tanggal,
                    'id_supplier': supplier
                },
                success: function(data) {
                    if (data.status == "oke") {
                        // Update UI tabel secara langsung tanpa reload!
                        $('#td_tanggal_' + id).html(tanggal);
                        $('#td_supplier_' + id).html($('#supplier_edit option:selected').text());
                        $('#modalEdit').modal('hide');
                    }
                }
            });
        }

        function deleteDataRemove(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.nota-beli.deleteDataDetail') }}',
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

        function getBayarForm(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.nota-beli.getBayarForm') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    $('#modalContentBayar').html(data.msg);
                }
            });
        }

        function saveBayar(id) {
            var bayar = $('#jumlah_bayar_input').val();
            var tgl = $('#tanggal_bayar_input').val();
            var metode = $('#metode_bayar_input').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.nota-beli.saveBayar') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id_nota_beli': id,
                    'jumlah_bayar': bayar,
                    'tanggal_bayar': tgl,
                    'metode_bayar': metode
                },
                success: function(data) {
                    if (data.status == "oke") {
                        alert(data.msg);
                        $('#modalBayar').modal('hide');

                        $('#td_status_bayar_' + id).html(data.statusHtml);

                        if (data.isLunas) {
                            $('#btn_bayar_' + id).remove();
                        }
                    } else {
                        alert(data.msg);
                    }
                }
            });
        }
    </script>
@endpush
