<div>
    <b>Bahan Baku:</b> {{ $data->bahanBaku->nama_bahan }}<br>
    <b>Jumlah yang Dipesan:</b> {{ $data->jumlah_pesan }} {{ $data->bahanBaku->idsatuan }}
</div>

<div class="form-group mb-2">
    <label>Jumlah yang diterima</label>
    <input type="number" class="form-control" id="jumlah_diterima_input" value="{{ $data->jumlah_pesan }}">
</div>

<div class="form-group mb-2">
    <label>Tanggal Diterima</label>
    <input type="date" class="form-control" id="tanggal_terima_input" value="{{ date('Y-m-d') }}">
</div>

<div class="form-group mb-3">
    <label>Keterangan</label>
    {{-- <textarea class="form-control" id="keterangan_input" rows="2" placeholder="Contoh: Barang datang dengan selamat"></textarea> --}}
    <input type="text" class="form-control" id="keterangan_input">
</div>

<!-- Tombol ini memanggil fungsi AJAX penyimpanan yang baru saja kita buat -->
<button type="button" class="btn btn-success mt-2 w-100" onclick="saveTerimaBarang({{ $data->id_detail_pembelian }})">
    Konfirmasi Penerimaan Barang
</button>
