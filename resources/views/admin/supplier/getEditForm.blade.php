<div class="form-group mb-2">
    <label>Nama Supplier</label>
    <input type="text" class="form-control" id="nama_edit" value="{{ $data->nama_supplier }}"
        placeholder="Enter Nama Supplier">
</div>
<div class="form-group mb-2">
    <label>Kontak</label>
    <input type="number" class="form-control" id="kontak_edit" value="{{ $data->kontak }}" placeholder="Enter Kontak">
</div>
<div class="form-group mb-2">
    <label>Alamat</label>
    <input type="text" class="form-control" id="alamat_edit" value="{{ $data->alamat }}" placeholder="Enter Alamat">
</div>

<button type="button" class="btn btn-primary mt-2 w-100" onclick="saveDataUpdate({{ $data->id_supplier }})">Simpan
    Perubahan</button>
