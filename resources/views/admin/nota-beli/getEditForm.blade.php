<div class="form-group mb-2">
    <label>Tanggal Pembelian</label>
    <input type="date" class="form-control" id="tanggal_edit" value="{{ $data->tanggal }}"
        placeholder="Enter Tanggal Pembelian">
</div>
<div class="form-group mb-2">
    <label>Supplier</label>
    <select class="form-control" id="supplier_edit" required>
        @foreach ($suppliers as $supplier)
            <option value="{{ $supplier->id_supplier }}"
                {{ $data->id_supplier == $supplier->id_supplier ? 'selected' : '' }}>
                {{ $supplier->nama_supplier }}
            </option>
        @endforeach
    </select>
</div>

<button type="button" class="btn btn-primary mt-2 w-100" onclick="saveDataUpdate({{ $data->id_nota_beli }})">Simpan
    Perubahan</button>
