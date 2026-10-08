@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('status'))
            <div class="alert alert-warning">{{ session('status') }}</div>
        @endif

        <h2>Detail Pembelian</h2>

        <div>
            <p>Tanggal {{ $notaBeli->tanggal }}</p>
            <p>Supplier : {{ $notaBeli->supplier->nama_supplier ?? '-' }}</p>

        </div>

        <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
            + Tambah Bahan
        </button>


        <table class="table">
            <thead>
                <tr>
                    <td style="font-weight:bold">ID</td>
                    <td style="font-weight:bold">Nama Bahan</td>
                    <td style="font-weight:bold">Jumlah Pesan</td>
                    <td style="font-weight:bold">Satuan</td>
                    <td style="font-weight:bold">Harga Total</td>
                    <td style="font-weight:bold" class="text-center">Status</td>
                    <td style="font-weight:bold" class="text-center">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailPembelians as $detailPembelian)
                    <tr id="tr_{{ $detailPembelian->id_detail_pembelian }}">
                        <td>{{ $detailPembelian->id_detail_pembelian }}</td>
                        <td id="td_nama_{{ $detailPembelian->id_detail_pembelian }}">
                            {{ $detailPembelian->bahanBaku->nama_bahan ?? '-' }}
                        </td>
                        <td id="td_jumlah_{{ $detailPembelian->id_detail_pembelian }}">
                            {{ $detailPembelian->jumlah_pesan ?? '-' }}</td>
                        <td id="td_satuan_{{ $detailPembelian->id_detail_pembelian }}">
                            {{ $detailPembelian->bahanBaku->satuan->idsatuan ?? '-' }}</td>
                        <td id="td_harga_{{ $detailPembelian->id_detail_pembelian }}">
                            {{ $detailPembelian->harga_total ?? '-' }}</td>

                        <td class="text-center" id="td_status_{{ $detailPembelian->id_detail_pembelian }}">
                            @php
                                $totalDiterima = $detailPembelian->penerimaanBarang()->sum('jumlah_diterima');
                            @endphp

                            @if ($totalDiterima == 0)
                                <span class="badge bg-danger ">Belum Diterima</span>
                            @elseif ($totalDiterima < $detailPembelian->jumlah_pesan)
                                <span class="badge bg-warning ">Sebagian</span>
                            @else
                                <span class="badge bg-success ">Selesai</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if ($detailPembelian->penerimaanBarang()->sum('jumlah_diterima') < $detailPembelian->jumlah_pesan)
                                <a href="#modalTerima" id="btn_terima_{{ $detailPembelian->id_detail_pembelian }}"
                                    class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    onclick="getTerimaBarangForm({{ $detailPembelian->id_detail_pembelian }})">Terima</a>
                            @endif

                            <a href="#modalEdit" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                onclick="getEditForm({{ $detailPembelian->id_detail_pembelian }})">Edit</a>

                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="if(confirm('Apakah Anda yakin ingin menghapus {{ $detailPembelian->id_detail_pembelian }} - {{ $detailPembelian->bahanBaku->nama_bahan }}?')) deleteDataRemove({{ $detailPembelian->id_detail_pembelian }})">
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
            <form method="POST" action="{{ route('admin.nota-beli.storeDetail') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Pembelian Bahan</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id_nota_beli" value="{{ $notaBeli->id_nota_beli }}">
                        <div class="form-group mb-2">
                            <label>Bahan Baku</label>
                            <select class="form-control" name="id_bahan" required>
                                <option value="">Pilih Bahan Baku</option>
                                @foreach ($bahanBakus as $bahan)
                                    <option value="{{ $bahan->id_bahan }}">{{ $bahan->nama_bahan }}
                                        ({{ $bahan->idsatuan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Jumlah Pesan</label>
                            <input type="number" step="0.01" class="form-control" name="jumlah_pesan"
                                placeholder="Masukkan Jumlah Pesan" required>
                        </div>

                        <div class="form-group mb-2">
                            <label>Harga Total</label>
                            <input type="number" step="0.01" class="form-control" name="harga_total"
                                placeholder="Masukkan Harga Total" required>
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
                    <h4 class="modal-title">Edit Detail Pembelian</h4>
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

    <div class="modal fade" id="modalTerima" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Terima Barang</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="modalContentTerima"></div>
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
                url: '{{ route('admin.nota-beli.getEditFormDetail') }}',
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
            var jumlah = $('#jumlah_pesan_edit').val();
            var harga_total = $('#harga_total_edit').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.nota-beli.saveDataUpdateDetail') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'jumlah': jumlah,
                    'harga_total': harga_total
                },
                success: function(data) {
                    if (data.status == "oke") {
                        // Update UI tabel secara langsung tanpa reload!
                        $('#td_jumlah_' + id).html(jumlah);
                        $('#td_harga_' + id).html(harga_total);
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

        function getTerimaBarangForm(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.nota-beli.getTerimaBarangForm') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    $('#modalContentTerima').html(data.msg);
                }
            });
        }

        function saveTerimaBarang(id) {
            var diterima = $('#jumlah_diterima_input').val();
            var tanggal = $('#tanggal_terima_input').val();
            var keterangan = $('#keterangan_input').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.nota-beli.saveTerimaBarang') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id_detail_pembelian': id,
                    'jumlah_diterima': diterima,
                    'tanggal_terima': tanggal,
                    'keterangan': keterangan
                },

                success: function(data) {
                    if (data.status == "oke") {
                        alert(data.msg);

                        $('#td_status_' + id).html(data.statusTerima);

                        if (data.isLengkap) {
                            $('#btn_terima_' + id).remove();
                        }

                        $('#modalTerima').modal('hide');
                    } else {
                        alert(data.msg);
                    }
                }
            })
        }
    </script>
@endpush
