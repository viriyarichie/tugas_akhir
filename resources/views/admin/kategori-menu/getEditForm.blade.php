<div class="form-group mb-2">
    <label>Nama Kategori</label>
    <input type="text" class="form-control" id="nama_edit" value="{{ $data->nama }}" placeholder="Enter Nama Kategori">
</div>
<button type="button" class="btn btn-primary mt-2 w-100" onclick="saveDataUpdate({{ $data->id }})">Simpan Perubahan</button>
