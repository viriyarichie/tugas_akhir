<div class="form-group mb-2">
    <label>Nama User</label>
    <input type="text" class="form-control" id="nama_edit" value="{{ $data->nama }}" placeholder="Enter Nama User">
</div>
<div class="form-group mb-2">
    <label>Email</label>
    <input type="email" class="form-control" id="email_edit" value="{{ $data->email }}" placeholder="Enter Email">
</div>
<div class="form-group mb-2">
    <label>Role</label>
    <select class="form-control" id="role_edit" required>
        <option value="admin" {{ $data->role == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="manajer" {{ $data->role == 'manajer' ? 'selected' : '' }}>Manajer</option>
        <option value="kasir" {{ $data->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
    </select>
</div>
<button type="button" class="btn btn-primary mt-2 w-100" onclick="saveDataUpdate({{ $data->id_user }})">Simpan
    Perubahan</button>
