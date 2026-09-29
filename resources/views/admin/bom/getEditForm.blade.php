<div class="form-group mb-2">
    <label>Jumlah</label>
    <input type="number" step="0.01" class="form-control" id="jumlah_edit" value="{{ $data->jumlah_bahan }}"
        placeholder="Enter Jumlah">
</div>
<div class="form-group mb-2">
    <label>Satuan </label>
    <input type="text" class="form-control" value="{{ $data->idsatuan }}" disabled>
</div>
<button type="button" class="btn btn-primary mt-2 w-100" onclick="saveDataUpdate({{ $data->id_bom }})">Simpan
    Perubahan</button>
