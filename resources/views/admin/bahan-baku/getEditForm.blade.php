<div class="form-group mb-2">
    <label>Nama Bahan Baku</label>
    <input type="text" class="form-control" id="nama_edit" value="{{ $data->nama_bahan }}"
        placeholder="Enter Nama Bahan Baku">
</div>
<div class="form-group mb-2">
    <label>Total Stok</label>
    <input type="number" class="form-control" id="total_stok_edit" value="{{ $data->total_stok }}"
        placeholder="Enter Total Stok">
</div>
<div class="form-group mb-2">
    <label>Satuan</label>
    <select class="form-control" id="idsatuan_edit" required>
        @foreach ($satuans as $satuan)
            <option value="{{ $satuan->idsatuan }}" {{ $data->idsatuan == $satuan->idsatuan ? 'selected' : '' }}>
                {{ $satuan->satuan }} ({{ $satuan->idsatuan }})
            </option>
        @endforeach
    </select>
</div>
<div class="form-group mb-2">
    <label>Stok On Order (Customer)</label>
    <input type="number" class="form-control" id="stok_onorder_customer_edit"
        value="{{ $data->stok_onorder_customer }}" placeholder="Enter Stok On Order (Customer)">
</div>
<div class="form-group mb-2">
    <label>Stok On Order (Supplier)</label>
    <input type="number" class="form-control" id="stok_onorder_supplier_edit"
        value="{{ $data->stok_onorder_supplier }}" placeholder="Enter Stok On Order (Supplier)">
</div>
<div class="form-group mb-2">
    <label>Kategori</label>
    <select class="form-control" id="kategori_edit" required>
        <option value="utama" {{ $data->kategori == 'utama' ? 'selected' : '' }}>Utama</option>
        <option value="pendukung" {{ $data->kategori == 'pendukung' ? 'selected' : '' }}>Pendukung</option>
    </select>
</div>
<button type="button" class="btn btn-primary mt-2 w-100" onclick="saveDataUpdate({{ $data->id_bahan }})">Simpan
    Perubahan</button>
