<div class="alert alert-warning text-dark">
    <strong>Total Belanja:</strong> Rp {{ number_format($grandTotal, 0, ',', '.') }} <br>
    <strong>Sudah Dibayar:</strong> Rp {{ number_format($terbayar, 0, ',', '.') }} <br>
    <strong>Sisa Tagihan:</strong> Rp {{ number_format($sisa, 0, ',', '.') }}
</div>

@if ($sisa > 0)
    <div class="form-group mb-2">
        <label>Nominal Pembayaran (Rp)</label>
        <input type="number" class="form-control" id="jumlah_bayar_input" value="{{ $sisa }}"
            max="{{ $sisa }}">
    </div>
    <div class="form-group mb-2">
        <label>Tanggal Bayar</label>
        <input type="date" class="form-control" id="tanggal_bayar_input" value="{{ date('Y-m-d') }}">
    </div>
    <div class="form-group mb-3">
        <label>Metode Pembayaran</label>
        <select class="form-control" id="metode_bayar_input">
            <option value="cash">Tunai / Cash</option>
            <option value="transfer">Transfer Bank</option>
            <option value="tempo">Tempo (Kredit)</option>
        </select>
    </div>
    <button type="button" class="btn btn-primary mt-2 w-100" onclick="saveBayar({{ $nota->id_nota_beli }})">
        Proses Pembayaran
    </button>
@else
    <div class="alert alert-success text-center">
        <strong>Nota sudah lunas!</strong>
    </div>
@endif
