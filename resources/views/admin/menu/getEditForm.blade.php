<div class="form-group mb-2">
    <label>Nama Menu</label>
    <input type="text" class="form-control" id="nama_edit" value="{{ $data->nama }}" placeholder="Enter Nama Menu">
</div>
<div class="form-group mb-2">
    <label>Harga</label>
    <input type="number" class="form-control" id="harga_edit" value="{{ $data->harga_jual }}" placeholder="Enter Harga">
</div>
<div class="form-group mb-2">
    <label>Kategori</label>
    <select class="form-control" id="kategori_edit" required>
        @foreach ($kategoriMenus as $kategori)
            <option value="{{ $kategori->id }}" {{ $data->kategori_menu_id == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
            </option>
        @endforeach
    </select>
</div>
<button type="button" class="btn btn-primary mt-2 w-100" onclick="saveDataUpdate({{ $data->id }})">Simpan Perubahan</button>
