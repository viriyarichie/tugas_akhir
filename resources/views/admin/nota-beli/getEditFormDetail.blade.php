<div class="form-group mb-2">
    <label>Bahan Baku</label>
    <input type="text" class="form-control"
        value="{{ $data->bahanBaku->nama_bahan }} ({{ $data->bahanBaku->idsatuan }})" disabled>
</div>
<div class="form-group mb-2">
    <label>Jumlah Pesan</label>
    <input type="number" step="0.01" class="form-control" id="jumlah_pesan_edit" value="{{ $data->jumlah_pesan }}"
        placeholder="Masukkan Jumlah">
</div>
<div class="form-group mb-2">
    <label>Harga Total (Rp)</label>
    <input type="number" class="form-control" id="harga_total_edit" value="{{ $data->harga_total }}"
        placeholder="Masukkan Harga">
</div>
<button type="button" class="btn btn-primary mt-2 w-100"
    onclick="saveDataUpdate({{ $data->id_detail_pembelian }})">Simpan Perubahan</button>
