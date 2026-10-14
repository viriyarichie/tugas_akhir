@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('status'))
            <div class="alert alert-warning">{{ session('status') }}</div>
        @endif

        <a href="{{ route('admin.nota-jual.index') }}" class="btn btn-secondary mb-3">
            Kembali ke Daftar Nota Jual
        </a>

        <h2>Detail Penjualan</h2>

        <div>
            <p><b>Tanggal:</b> {{ $notaJual->tanggal }}</p>
            <p><b>Kasir:</b> {{ $notaJual->user->nama ?? '-' }}</p>
            <p><b>Jenis:</b> {{ $notaJual->jenis }}</p>
            <!-- Total Harga (Update otomatis nanti) -->
            <p><b>Grand Total:</b> Rp {{ number_format($notaJual->total, 0, ',', '.') }}</p>
        </div>

        @if (!$isPaid)
            <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
                + Tambah Menu
            </button>

            <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#modalBayar">
                Pembayaran
            </button>
        @else
            <h4>Sudah Dibayar</h4>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <td style="font-weight:bold">ID</td>
                    <td style="font-weight:bold">Nama Menu</td>
                    <td style="font-weight:bold">Qty</td>
                    <td style="font-weight:bold">Harga Satuan</td>
                    <td style="font-weight:bold">Subtotal</td>
                    <td style="font-weight:bold">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailPenjualans as $detail)
                    <tr id="tr_{{ $detail->id_detail_jual }}">
                        <td>{{ $detail->id_detail_jual }}</td>
                        <td id="td_menu_{{ $detail->id_detail_jual }}">{{ $detail->menu->nama_menu ?? '-' }}</td>
                        <td id="td_qty_{{ $detail->id_detail_jual }}">{{ $detail->qty }}</td>
                        <td id="td_harga_{{ $detail->id_detail_jual }}">Rp
                            {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td id="td_subtotal_{{ $detail->id_detail_jual }}">Rp
                            {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        <td>
                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="if(confirm('Hapus {{ $detail->menu->nama_menu }}?')) deleteDataRemove({{ $detail->id_detail_jual }})">
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div>

        </div>
    </div>
@endsection

@push('modals')
    <!-- Modal Keranjang Dinamis -->
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('admin.nota-jual.storeDetail') }}">
                @csrf
                <input type="hidden" name="id_nota_jual" value="{{ $notaJual->id_nota_jual }}">

                <div class="modal-content">
                    <div class="modal-header ">
                        <h4 class="modal-title">Input Pesanan Pelanggan</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Area Kontrol (Pilih Menu & Qty) -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Pilih Menu</label>
                                <select class="form-control" id="temp_menu">
                                    <option value="" data-nama="" data-harga="0">-- Pilih Menu --</option>
                                    @foreach ($menus as $menu)
                                        <option value="{{ $menu->id_menu }}" data-nama="{{ $menu->nama_menu }}"
                                            data-harga="{{ $menu->harga_jual }}">
                                            {{ $menu->nama_menu }} - Rp
                                            {{ number_format($menu->harga_jual, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Qty</label>
                                <input type="number" class="form-control" id="temp_qty" value="1" min="1">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <!-- Tombol ini HANYA untuk manipulasi HTML, BUKAN untuk submit database -->
                                <button type="button" class="btn btn-info text-white w-100 fw-bold"
                                    onclick="tambahKeList()">
                                    + Tambah ke List
                                </button>
                            </div>
                        </div>

                        <!-- Area Tabel Keranjang Sementara -->
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Menu Terpilih</th>
                                    <th>Harga Satuan</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="temp_list">
                                <!-- Baris pesanan akan disuntikkan secara ajaib di sini via Javascript -->
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <!-- Tombol ini baru untuk Submit ke Database -->
                        <button type="submit" class="btn btn-primary fw-bold" id="btnSimpan" disabled>Simpan Pesanan ke
                            Nota</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalBayar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.nota-jual.saveBayar') }}">
                @csrf
                <input type="hidden" name="id_nota_jual" value="{{ $notaJual->id_nota_jual }}">

                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h4 class="modal-title">Kasir Pembayaran</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-center mb-4">Total: Rp {{ number_format($notaJual->total, 0, ',', '.') }}</h2>

                        <div class="form-group mb-3">
                            <label>Uang Diterima (Rp)</label>
                            <input type="number" class="form-control form-control-lg" name="jumlah_bayar" required
                                min="{{ $notaJual->total }}">
                        </div>
                        <div class="form-group mb-2">
                            <label>Metode Pembayaran</label>
                            <select class="form-control" name="metode_bayar" required>
                                <option value="cash">Tunai / Cash</option>
                                <option value="qris">QRIS / Transfer</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-lg w-100"
                            onclick="return confirm('Proses pembayaran? Stok gudang akan otomatis terpotong setelah ini!')">
                            Konfirmasi Pembayaran
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('script')
    <script>
        // Fitur Autofill Canggih ala Mesin Kasir
        function setHargaSatuan() {
            var harga = $('#select_menu option:selected').data('harga'); // Ambil harga terselubung
            $('#input_harga_satuan').val(harga); // Masukkan ke form
            hitungSubtotal(); // Langsung hitung ulang subtotalnya
        }

        function hitungSubtotal() {
            var harga = $('#input_harga_satuan').val();
            var qty = $('#input_qty').val();
            $('#input_subtotal').val(harga * qty); // Harga * Jumlah Porsi
        }

        // Fitur Delete berbasis AJAX
        function deleteDataRemove(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.nota-jual.deleteDetail') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function(data) {
                    if (data.status == "oke") {
                        $('#tr_' + id).remove();
                        location.reload(); // Reload sebentar untuk memperbarui tampilan Grand Total
                    } else {
                        alert(data.msg);
                    }
                }
            });
        }


        let rowIdCounter = 0; // Agar ID baris selalu unik jika menunya sama
        function tambahKeList() {
            var menuSelect = $('#temp_menu option:selected');
            var id_menu = menuSelect.val();
            var nama_menu = menuSelect.data('nama');
            var harga = menuSelect.data('harga');
            var qty = $('#temp_qty').val();
            if (id_menu == "" || qty < 1) {
                alert("Harap pilih menu dan pastikan Qty minimal 1!");
                return; // Hentikan eksekusi
            }
            var subtotal = harga * qty;
            rowIdCounter++; // Tambah ID unik
            // Kita cetak baris HTML baru, sekaligus menyisipkan tag <input type="hidden"> berbentuk Array []
            var html = `    
            <tr id="row_temp_${rowIdCounter}">
                <td>
                    ${nama_menu}
                    <input type="hidden" name="id_menus[]" value="${id_menu}">
                </td>
                <td>Rp ${harga}</td>
                <td>
                    ${qty}
                    <input type="hidden" name="qtys[]" value="${qty}">
                </td>
                <td>Rp ${subtotal}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusList(${rowIdCounter})">Batal</button>
                </td>
            </tr>
        `;
            // Suntikkan barisnya ke tabel
            $('#temp_list').append(html);

            // Aktifkan tombol submit utama
            $('#btnSimpan').prop('disabled', false);
            // Reset inputan atas agar kasir bisa langsung memilih menu berikutnya
            $('#temp_menu').val('');
            $('#temp_qty').val('1');
        }
        // Fungsi membatalkan baris yang belum di-submit
        function hapusList(rowId) {
            $('#row_temp_' + rowId).remove();

            // Jika keranjang kembali kosong, matikan lagi tombol simpannya
            if ($('#temp_list tr').length == 0) {
                $('#btnSimpan').prop('disabled', true);
            }
        }
    </script>
@endpush
